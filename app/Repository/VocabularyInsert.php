<?php

namespace App\Repository;

use App\Models\Simulation;
use App\Models\Entity;
use App\Models\Condition;
use App\Models\EntityRelation;
use App\Models\Goal;
use App\Models\GoalCondition;
use App\Models\Plan;
use App\Models\GoalPlan;

class VocabularyInsert
{
	public function returnDate(){
		return ['created_at' => new \DateTime, 'updated_at' => new \DateTime];
	}

	public function insertSimulation($name){
		$arg = ['name' => $name] + $this->returnDate();
		return (new Simulation)->insert($arg);
	}

	public function insertEntity($name,$type){
		$arg = ['name' => $name, 'type' => $type ] + $this->returnDate();
		return (new Entity)->insert($arg);		
	}

	public function insertObject($name){
		return $this->insertEntity($name,'object');
	}

	public function insertAgent($name){
		return $this->insertEntity($name,'agent');
	} 
	public function insertTool($name){
		return $this->insertEntity($name,'tool');
	}
	public function findEntity($name){
		return (new Entity)->where('name',$name)->first()->id;
	}
	public function prepareArgCondition($type, $value, $name_entity,&$arg){
		$arg = [
			"type" => $type,
			"value" => $value,
			"entity_id" => $this->findEntity($name_entity),
		] + $this->returnDate();
	}
	public function insertMass($value,$name_entity){
		$this->prepareArgCondition('mass', $value, $name_entity,$arg);
		return (new Condition)->insert($arg);
	}
	public function insertEnergy($value,$name_entity){
		$this->prepareArgCondition('energy', $value, $name_entity,$arg);
		return (new Condition)->insert($arg);
	}
	public function	 insertPositionX($value,$name_entity){
		$this->prepareArgCondition('position_x',$value,$name_entity,$arg);
		return (new Condition)->insert($arg);
	}
	public function insertPositionY($value,$name_entity){
		$this->prepareArgCondition('position_y',$value,$name_entity,$arg);
		return (new Condition)->insert($arg);
	}
	public function insertPositionZ($value,$name_entity){
		$this->prepareArgCondition('position_z',$value,$name_entity,$arg);
		return (new Condition)->insert($arg);
	}
	public function insertState($value,$name_entity){
		$this->prepareArgCondition('state',$value,$name_entity,$arg);
		return (new Condition)->insert($arg);
	}
	public function insertStatus($value,$name_entity){
		$this->prepareArgCondition('status',$value,$name_entity,$arg);
		return (new Condition)->insert($arg);
	}
	public function insertRelation($value,$name_entity){
		$this->prepareArgCondition('relation',$value,$name_entity,$arg);
		return (new Condition)->insert($arg);
	}
	public function insertRelationEntities($type_relation,$name_entity_one,$name_entity_two,$status){
		$arg = [
			"type_relation" => $type_relation,
			"entity_one_id" => $this->findEntity($name_entity_one),
			"entity_two_id" => $this->findEntity($name_entity_two),
			"status" => $status,			
		] + $this->returnDate();
		(new EntityRelation)->insert($arg);
	}
	public function insertRelationAgentGetTool($name_entity_one,$name_entity_two,$status){
		$this->insertRelationEntities('agent_get_tool',$name_entity_one,$name_entity_two,$status);
	}
	public function insertRelationToolOnObject($name_entity_one,$name_entity_two,$status){
		$this->insertRelationEntities('tool_on_object',$name_entity_one,$name_entity_two,$status);
	}
	public function insertRelationAgentDropTool($name_entity_one,$name_entity_two,$status){
		$this->insertRelationEntities('agent_drop_tool',$name_entity_one,$name_entity_two,$status);
	}	
	public function insertRelationRemoveToolOnObject($name_entity_one,$name_entity_two,$status){
		$this->insertRelationEntities('remove_tool_on_object',$name_entity_one,$name_entity_two,$status);
	}	
	public function insertGoal($name,$probability){
		$arg = ["name" => $name, "probability" => $probability] + $this->returnDate();
		(new Goal)->insert($arg);
	}
	public function findGoal($goal_name){
		return (new Goal)->where('name',$goal_name)->first()->id;
	}
	public function findCondition($value,$type,$name_entity){
		return (new Condition)
			->where(
				[
					["value","=", $value], 
					["type","=", $type],
					["entity_id","=",$this->findEntity($name_entity)]
				]
			)
			->first()->id;
	}
	public function insertConditionGoal($goal_name,$value,$type,$name_entity){
		$arg = [
			"goal_id" => $this->findGoal($goal_name),
			"condition_id" => $this->findCondition($value,$type,$name_entity)
		] + $this->returnDate();

		(new GoalCondition)->insert($arg);
	}
	public function insertPlans($name,$operator){
		(new Plan)->insert(['name' => $name, 'operator' => $operator]+$this->returnDate());
	}
	public function insertPlanSequence($name){
		$this->insertPlans($name,'sequence');
	}
	public function insertPlanParallel($name){
		$this->insertPlans($name,'parallel');
	}
	public function insertPlanChoice($name){
		$this->insertPlans($name,'choice');
	}
	public function findPlan($name){
		return (new Plan)->where('name',$name)->first()->id;
	}
	public function insertGoalPlan($status_goal,$goal_name,$plan_name){
		(new GoalPlan)
			->insert
			(
				[
					"status_goal" => $status_goal,
					"goal_id" => $this->findGoal($goal_name),
					"plan_id" => $this->findPlan($plan_name)
				] 
					+
				$this->returnDate()
			);
	}
	public function insertSuperGoalPlan($goal_name,$plan_name){
		$this->insertGoalPlan('super',$goal_name,$plan_name);
	}
	public function insertSubGoalPlan($goal_name,$plan_name){
		$this->insertGoalPlan('sub',$goal_name,$plan_name);
	}
}