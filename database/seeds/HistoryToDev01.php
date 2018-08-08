<?php

use Illuminate\Database\Seeder;
use App\Repository\VocabularyInsert;


class HistoryToDev01 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$vi = new VocabularyInsert;
/*
    	$vi->insertSimulation('simulation01');
    	$vi->insertAgent('agent01','simulation01');
    	$vi->insertAgent('agent02','simulation01');
    	$vi->insertObject('object01','simulation01');
    	$vi->insertTool('tool01','simulation01');
    	$vi->insertTool('tool02','simulation01');

    	$vi->insertGoal('goal00',1);
		$vi->insertGoal('goal01',1);
		$vi->insertGoal('goal02',0.8);
		$vi->insertGoal('goal03',0.6);
		$vi->insertGoal('goal04',1);
		$vi->insertGoal('goal05',1);
		$vi->insertGoal('goal06',1);


		$vi->insertPlanSequence('plan_sequence_01');
		$vi->insertPlanSequence('plan_sequence_02');
		$vi->insertPlanParallel('plan_parallel_01');		

		$vi->insertSuperGoalPlan("goal02","plan_sequence_01");
		$vi->insertSuperGoalPlan("goal03","plan_parallel_01");
		$vi->insertSuperGoalPlan("goal06","plan_sequence_02");

		$vi->insertSubGoalPlan("goal00","plan_sequence_01");
		$vi->insertSubGoalPlan("goal01","plan_sequence_01");

		$vi->insertSubGoalPlan("goal04","plan_parallel_01");
		$vi->insertSubGoalPlan("goal05","plan_parallel_01");

		$vi->insertSubGoalPlan("goal02","plan_sequence_02");
		$vi->insertSubGoalPlan("goal03","plan_sequence_02");
		
		$vi->insertGoalSequence("plan_sequence_01","goal00-goal01");
		$vi->insertGoalSequence("plan_sequence_02","goal02-goal03");		

		$vi->insertRelationAgentGetTool('agent01','tool01','created');
		$vi->insertGoalRelationEntity('goal01','agent_get_tool','agent01','tool01','created');

		$vi->insertRelationAgentGetTool('agent02','tool02','created');
		$vi->insertGoalRelationEntity('goal04','agent_get_tool','agent02','tool02','created');

		
		$vi->insertRelationToolOnObject('tool01','object01','created');
		$vi->insertGoalRelationEntity('goal02','tool_on_object','tool01','object01','created');
	
		$vi->insertRelationToolOnObject('tool02','object01','created');
		$vi->insertGoalRelationEntity('goal03','tool_on_object','tool02','object01','created');

		$vi->insertRelationAgentGetTool('agent01','tool01','destroyed');
		$vi->insertGoalRelationEntity('goal06','agent_get_tool','agent01','tool01','destroyed');
		$vi->insertRelationAgentGetTool('agent02','tool02','destroyed');
		$vi->insertGoalRelationEntity('goal06','agent_get_tool','agent02','tool02','destroyed');		
		$vi->insertRelationToolOnObject('tool01','object01','destroyed');
		$vi->insertGoalRelationEntity('goal06','tool_on_object','tool01','object01','destroyed');		
		$vi->insertRelationToolOnObject('tool02','object01','destroyed');		
 		$vi->insertGoalRelationEntity('goal06','tool_on_object','tool02','object01','destroyed');

 		$vi->insertOrganization('organization01','simulation01');
 		
 		$vi->insertSchema('schema01','organization01');
 		$vi->insertMission('mission01','schema01');
 		$vi->insertMission('mission02','schema01');
 
		$vi->insertGoalMission('goal00','mission01');
		$vi->insertGoalMission('goal01','mission01');
		$vi->insertGoalMission('goal02','mission01');
		$vi->insertGoalMission('goal06','mission02');
		$vi->insertGoalMission('goal03','mission02');
		$vi->insertGoalMission('goal04','mission02');
		$vi->insertGoalMission('goal05','mission02');

		$vi->insertGroup('group01','organization01');
		$vi->insertRole('role01','group01');
		$vi->insertRole('role02','group01');
		$vi->insertLinkCommunication('role01','role02');
		$vi->insertObligation('role01','mission01');
		$vi->insertObligation('role02','mission02');
		$vi->insertAgentRole('agent01','role01');
		$vi->insertAgentRole('agent02','role02');
 */
    }
}
