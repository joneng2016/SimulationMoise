<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
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

class VocabularyQuery
{
	private $simulation;  
	private $entity;
	private $condition;
	private $entityrelation;
	private $goal;
	private $goalcondition;
	private $goalplan;
	private $goalsequence;
	private $organization;
	private $schemaorganizaiton;
	private $mission;
	private $goalmission;
	private $plan;
	private $group;
	private $subgroup;
	private $simulationrelation;
	private $entityrel;
	private $relationsbetweewnentity;
	private $goalrelation;
	private $planrelation;
	private $missionrelation;
	private $organizationrelation;
	private $schemaorganizationrelation;
	private $grouprelation;
	private $rolerelation;
	private $goalsequencerelation;

	public function constructArray(){
		$this->simulation = (new Simulation)->get(); 
		$this->entity = (new Entity)->get();
		$this->condition = (new Condition)->get();
		$this->entityrelation = (new EntityRelation)->get();
		$this->goal = (new Goal)->get();
		$this->goalcondition = (new GoalCondition)->get();
		$this->goalplan = (new GoalPlan)->get();
		$this->plan = (new Plan)->get();
		$this->goalsequence = (new GoalSequence)->get();
		$this->organization = (new Organization)->get();
		$this->schemaorganization = (new SchemaOrganization)->get();
		$this->mission = (new Mission)->get();
		$this->goalmission = (new GoalMission)->get();
		$this->group = (new Group)->get();
		$this->subgroup = (new SubGroup)->get();
		$this->role = (new Role)->get();
	}
	public function relationSimulation(){
		foreach($this->simulation as $sim){
			$this->simulationrelation[] = (object)
			[
				"simulation" => $sim,
				"entity" => $sim->hasEntity()->get(),
				"organization" => $sim->hasOrganization()->get()
			];
		}
		return $this->simulationrelation;
	}
	public function joinEntityRelEntity(){
		return (object)
		[
			"entity_one" =>DB::table('entities')
			->leftJoin('entity_relations','entities.id','=','entity_relations.entity_one_id')->get(),
			"entity_two" =>DB::table('entities')
			->leftJoin('entity_relations','entities.id','=','entity_relations.entity_two_id')->get()
		];
	}

	public function relationEntity($type){
		$entities = $this->entity->where('type',$type); 
		foreach($entities as $entity){
			$this->entityrel[]	= (object)
			[
				"entity" => $entity,
				"role" => $entity->role(),
				"relation" => $entity->entityRelation()
			];
		}			
		return $this->entityrel;
	}
	public function relationAgent(){
		return $this->relationEntity("agent");
	}
	public function relationObject(){
		return $this->relationEntity("object");
	}
	public function relationTool(){
		return $this->relationEntity("tool");
	}
	public function relationEntityRelation(){		
		foreach($this->entityrelation as $entityrelation){
			$this->relationsbetweewnentity[] = (object)
			[ 
				"first" => $entityrelation->hasEntityFirst()->get(),
				"second" =>$entityrelation->hasEntitySecond()->get(),
			];
		}
		return $this->relationsbetweewnentity;	
	}
	public function relationGoal(){
		foreach($this->goal as $goal){
			$this->goalrelation[] = (object)
			[	
				"goal" => $goal,
				"reached" => false, 
				"plan" => $goal->plan()
			];
		}
		return $this->goalrelation;
	}
	public function relationPlan(){
		foreach($this->plan as $plan){
			$this->planrelation[] = (object)
			[
				"plan" => $plan,
				"goal" => $plan->goal(),
				"sequence" => $plan->goalSequence()->get()
			];
		}	
		return $this->planrelation;	
	}
	public function relationMission(){
		foreach($this->mission as $mission){
			$this->missionrelation[] = (object)
			[
				"mission" => $mission,
				"deontic_relation" => $mission->deonticRelation()->get(),
				"goal" => $mission->goal()
			];
		}
		return $this->missionrelation;
	}
	public function relationOrganization(){
		foreach($this->organization as $organization){
			$this->organizationrelation[] = (object)
			[
				"organization" => $organization,
				"schema_organization" => $organization->schemaOrganization()->get(),
				"group" => $organization->group()->get()
			];
		}
		return $this->organizationrelation;
	}
	public function relationSchemaOrganization(){
		foreach ($this->schemaorganization as $schema) {
			$this->schemaorganizationrelation[] = (object) [
				"schema" => $schema,
				"mission" => $schema->mission()->get()
			];
		}
		return $this->schemaorganizationrelation;
	} 
	public function relationGroup()
	{
		foreach($this->group as $group){
			$this->grouprelation[] = (object)[
				"group" => $group,
				"role" => $group->role()->get()
			];
		}
		return $this->grouprelation;
	}
	public function relationRole(){
		foreach($this->role as $role){
			$this->rolerelation[] = (object)[
				"role" => $role,
				"deontic_relation" => $role->deonticRelation()->get(),
				"link_authority" => $role->linkAuthority(),
				"link_communication" => $role->linkCommunication(),
				"link_acquaintace" => $role->linkAcquaintace(),
				"heritage" => $role->heritage(),
				"compatibility()" => $role->compatibility()
			];
		}
		return $this->rolerelation;
	}


	public function loadBank()
	{
		$this->constructArray();
		$this->relationSimulation();
		$this->relationAgent();
		$this->relationObject();
		$this->relationTool();
		$this->relationEntityRelation();
		$this->relationGoal();
		$this->relationPlan();
	 	$this->relationMission();
	 	$this->relationOrganization();
	 	$this->relationSchemaOrganization();
	 	$this->relationGroup();
		$this->relationRole();
	}
	public function relationVect(&$vet){
		$vet = (object)
		[
			"simulation" => $this->simulationrelation,
			"entity" => $this->entityrel,
			"entity_entity" => $this->relationsbetweewnentity,
			"goal" => $this->goalrelation,
			"plan" => $this->planrelation,
			"mission" => $this->missionrelation,
			"organization" => $this->organizationrelation,
			"schema" => $this->schemaorganizationrelation,
			"group" => $this->grouprelation,
			"role" => $this->rolerelation
		];
	}
}
