<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AnalizeBank extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'agentrun:analize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->s_s_repository = new \App\Repository\StatisticSimulationRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $numbergoal = "04";
        $this->s_s_repository->loadToRelationGoalProbability("goal_simulation_test_goal00_2408-4 - 0.01",$numbergoal);
        $this->s_s_repository->relationGoalProbability();
        $this->s_s_repository->getRelation($relation);
        $this->writeInFile($relation,$numbergoal);
    }
    public function writeInFile($relation,$numbergoal){
        $where = __DIR__."/../../../public/solutionsimulation/simulation2408";
        $name_file = "goal".$numbergoal.".txt";
        $where_file = $where."/".$name_file;
        $file = fopen($where_file,"w");
        foreach($relation as $rel){
            $sentence = $rel["goal_probability"]."  ".$rel["activity_probability"]."\n";
            fwrite($file, $sentence);
        }
        fclose($file);
    }
}
