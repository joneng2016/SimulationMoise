<?php

use Illuminate\Database\Seeder;
use App\Repository\VocabularyInsert;


class InsertTestHistory extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //(new VocabularyInsert)->insertSimulation('simulacao01');
    	//(new VocabularyInsert)->insertObject('objeto01','simulacao01');
    	//(new VocabularyInsert)->insertAgent('agent01','simulacao01');
    	//(new VocabularyInsert)->insertAgent('agent02','simulacao01');
    	//(new VocabularyInsert)->insertAgent('agent03','simulacao01');    	    	
    	//(new VocabularyInsert)->insertTool('tool01','simulacao01');
    	//(new VocabularyInsert)->insertTool('tool02','simulacao01');
    	//(new VocabularyInsert)->insertTool('tool03','simulacao01');    
    	//(new VocabularyInsert)->insertMass(70,'agent01');
    	//(new VocabularyInsert)->insertEnergy(100,'agent01');
    	//(new VocabularyInsert)->insertPositionX(0,'agent01');
    	//(new VocabularyInsert)->insertPositionY(0,'agent01');
    	//(new VocabularyInsert)->insertPositionZ(0,'agent01');
    	//(new VocabularyInsert)->insertState('fine','agent01');
    	//(new VocabularyInsert)->insertStatus('life','agent01');
    	//(new VocabularyInsert)->insertRelation('tool01','agent01');
    	//(new VocabularyInsert)->insertRelationEntities('agent_get_tool','agent01','tool01','created');
    	//(new VocabularyInsert)->insertGoal("goal01",0.5);
    	//(new VocabularyInsert)->insertGoal("goal02",0.25);
    	//(new VocabularyInsert)->insertGoal("goal03",0.69);
    	//(new VocabularyInsert)->insertGoal("goal04",0.7);
    	//(new VocabularyInsert)->insertConditionGoal("goal01","70","mass","agent01");
    	//(new VocabularyInsert)->insertPlanSequence("plan_sequence_01");
    	//(new VocabularyInsert)->insertPlanParallel("plan_parallel_01");
    	//(new VocabularyInsert)->insertPlanChoice("plan_choice_01");    	
    	//(new VocabularyInsert)->insertSuperGoalPlan("goal01","plan_parallel_01");
    	//(new VocabularyInsert)->insertSubGoalPlan("goal02","plan_parallel_01");    	
    	//(new VocabularyInsert)->insertGoalSequence("plan_sequence_01","goal01-goal02");
    	//(new VocabularyInsert)->insertOrganization('organization_01','simulacao01');
    	//(new VocabularyInsert)->insertSchema('schema_01','organization_01');
    	//(new VocabularyInsert)->insertMission("mission01","schema_01");
		//(new VocabularyInsert)->insertGoalMission('goal01','mission01');
		//(new VocabularyInsert)->insertGroup('group01','organization_01');
		//(new VocabularyInsert)->insertGroup('group02','organization_01');
		//(new VocabularyInsert)->insertSubGroup('group01','group02');		
    	//(new VocabularyInsert)->insertRole('role01','group01');
    	//(new VocabularyInsert)->insertRole('role02','group01');
    	//(new VocabularyInsert)->insertCompatibility('role01','role02');
		//(new VocabularyInsert)->insertHeritage('role01','role02');
    	//(new VocabularyInsert)->insertLinkAuthority('role01','role02');
    	//(new VocabularyInsert)->insertObligation('role01','mission01');
   		//(new VocabularyInsert)->insertAgentRole('agent01','role01');
    }
}
