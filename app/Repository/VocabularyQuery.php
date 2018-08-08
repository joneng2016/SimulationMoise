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
	private $group;
	private $subgroup;
	private $rolerelation;
	private $simulationrelation;
	private $entityrelaiton;

	public function constructArray(){
		$this->simulation = (new Simulation)->get(); 
		$this->entity = (new Entity)->get();
		$this->condition = (new Condition)->get();
		$this->entityrelation = (new EntityRelation)->get();
		$this->goal = (new Goal)->get();
		$this->goalcondition = (new GoalCondition)->get();
		$this->goalplan = (new GoalPlan)->get();
		$this->goalsequence = (new GoalSequence)->get();
		$this->organization = (new Organization)->get();
		$this->schemaorganization = (new SchemaOrganization)->get();
		$this->misson = (new Mission)->get();
		$this->goalmission = (new GoalMission)->get();
		$this->group = (new Group)->get();
		$this->subgroup = (new SubGroup)->get();
		$this->role = (new Role)->get();
		$this->rolerelation = (new RoleRelation)->get();
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
	public function relationEntity(){
		foreach($this->entity as $entity){
			$this->entityrelation[]	=
			[
				"entity" => $entity,
				"role" => $entity->role(),

			];
		}			
	}
}
