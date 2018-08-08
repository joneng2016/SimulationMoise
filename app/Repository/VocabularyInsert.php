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
use App\Models\GoalSequence;
use App\Models\Organization;
use App\Models\SchemaOrganization;
use App\Models\Mission;
use App\Models\GoalMission;
use App\Models\Group;
use App\Models\SubGroup;
use App\Models\Role;
use App\Models\RoleRelation;

class VocabularyInsert
{
	public function returnDate(){
		return ['created_at' => new \DateTime, 'updated_at' => new \DateTime];
	}

	public function insertSimulation($name){
		$arg = ['name' => $name] + $this->returnDate();
		return (new Simulation)->insert($arg);
	}
	public function findSimulation($name){
		return (new Simulation)->where('name',$name)->first()->id;
	}
	public function insertEntity($name,$type,$name_simulation){
		$arg = ['name' => $name, 'type' => $type, 'simulation_id' =>  $this->findSimulation($name_simulation)] + $this->returnDate();
		return (new Entity)->insert($arg);		
	}

	public function insertObject($name,$name_simulation){
		return $this->insertEntity($name,'object',$name_simulation);
	}

	public function insertAgent($name,$name_simulation){
		return $this->insertEntity($name,'agent',$name_simulation);
	} 
	public function insertTool($name,$name_simulation){
		return $this->insertEntity($name,'tool',$name_simulation);
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
	public function insertGoalRelationEntity($name_goal,$type_relation,$name_entity_one,$name_entity_two,$status)
	{
		$arg = 
		[
			"goal_id" => $this->findGoal($name_goal),
			"ent_rel_id" => $this->findRelationEntities($type_relation,$name_entity_one,$name_entity_two,$status)
		];
		$this->argWithDate($arg);
		(new \App\Models\GoalRelationEntity)->insert($arg);
	}
	public function findRelationEntities($type_relation,$name_entity_one,$name_entity_two,$status){
		return (new EntityRelation)->where(
				[
					['type_relation','=',$type_relation],
					['entity_one_id','=',$this->findEntity($name_entity_one)],
					['entity_two_id','=',$this->findEntity($name_entity_two)],
					['status','=',$status],					
				]
			)->first()->id;
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
	public function insertGoalSequence($name_plan,$sequence_goal){
		$arg = [
			"plan_sequence" => $this->findPlan($name_plan),
			"sequence_goal" => $sequence_goal
		] +
		$this->returnDate();
		(new GoalSequence)->insert($arg);
	}
	public function argWithDate(&$arg){
		$arg = $arg + $this->returnDate();
	}

	public function insertOrganization($name_organization,$name_simulation){
		$arg = 
		[
			"simulation_id" => (new Simulation)->where('name',$name_simulation)->first()->id,
			"name" => $name_organization
		];
		$this->argWithDate($arg);
		(new Organization)->insert($arg);
	}	
	public function findOrganization($name_organization){
		return (new Organization)->where('name',$name_organization)->first()->id;
	}
	public function insertSchema($name,$name_organization){
		$arg = 
		[
			"name" => $name,
			"organization_id" => $this->findOrganization($name_organization) 
		];
		$this->argWithDate($arg);
		(new SchemaOrganization)->insert($arg);
	}
	public function findSchema($name_schema){
		return (new SchemaOrganization)->where('name',$name_schema)->first()->id;
	}
	public function insertMission($name,$name_schema){
		$arg = 
		[
			"name" => $name,
			"schema_id" => $this->findSchema($name_schema)
		];
		$this->argWithDate($arg);
		(new Mission)->insert($arg);	
	}
	public function findMission($name_mission){
		return (new Mission)->where('name',$name_mission)->first()->id;
	}
	public function insertGoalMission($name_goal,$name_mission){
		$arg = 
		[
			"goal_id" => $this->findGoal($name_goal),
			"mission_id" => $this->findMission($name_mission)
		];
		$this->argWithDate($arg);
		(new GoalMission)->insert($arg);
	}
	public function insertGroup($name_group,$name_organization){
		$arg = [
			"name" => $name_group,
			"organization_id" => $this->findOrganization($name_organization)
		];
		$this->argWithDate($arg);
		(new Group)->insert($arg);
	}
	public function findGroup($name){
		return (new Group)->where('name',$name)->first()->id;
	}
	public function insertSubGroup($name_group_super,$name_group_sub){
		$arg = [
			"group_super_id" => $this->findGroup($name_group_super),
			"group_sub_id" => $this->findGroup($name_group_sub)
		];
		$this->argWithDate($arg);
		(new SubGroup)->insert($arg);
	}
	public function insertRole($name,$name_group){
		$arg = 
		[
			"name" => $name,
			"group_id" => $this->findGroup($name_group)
		];
		$this->argWithDate($arg);
		(new Role)->insert($arg);
	}
	public function findRole($name_role){
		return (new Role)->where('name',$name_role)->first()->id;
	}
	public function insertRoleRelations($type,$name_role_one,$name_role_two){
		$arg = 
		[
			"type" => $type,
			"role_one_id" => $this->findRole($name_role_one),
			"role_two_id" => $this->findRole($name_role_two),			
		];
		$this->argWithDate($arg);
		(new \App\Models\RoleRelation)->insert($arg);
	}
	public function insertHeritage($name_role_one,$name_role_two){
		$this->insertRoleRelations('heritage',$name_role_one,$name_role_two);
	}
	public function insertCompatibility($name_role_one,$name_role_two){
		$this->insertRoleRelations('compatibility',$name_role_one,$name_role_two);
	}
	public function insertLinkAuthority($name_role_one,$name_role_two){
		$this->insertRoleRelations('link_authority',$name_role_one,$name_role_two);
		$this->insertLinkCommunication($name_role_one,$name_role_two);
	}	
	public function insertLinkCommunication($name_role_one,$name_role_two){
		$this->insertRoleRelations('link_communication',$name_role_one,$name_role_two);
		$this->insertLinkAcquaintace($name_role_one,$name_role_two);
	}		
	public function insertLinkAcquaintace($name_role_one,$name_role_two){
		$this->insertRoleRelations('link_acquaintace',$name_role_one,$name_role_two);
	}	
	public function insertDeonticRelation($type,$name_role,$name_mission){
		$arg = 
		[
			"type" => $type,
			"mission_id" => $this->findMission($name_mission),
			"role_id" => $this->findRole($name_role)
		];
		$this->argWithDate($arg);
		(new \App\Models\DeonticRelation)->insert($arg);
	}
	public function insertPermission($name_role,$name_mission){
		$this->insertDeonticRelation('permission',$name_role,$name_mission);	
	}
	public function insertObligation($name_role,$name_mission){
		$this->insertDeonticRelation('obligation_permission',$name_role,$name_mission);
		$this->insertPermission($name_role,$name_mission);
	}
	public function insertAgentRole($name_agent,$name_role){
		$arg = [
			'entity_id' => $this->findEntity($name_agent),
			'role_id' => $this->findRole($name_role)
		];
		$this->argWithDate($arg);
		(new \App\Models\AgentRole)->insert($arg);
	}

}
