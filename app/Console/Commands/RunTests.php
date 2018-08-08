<?php

namespace App\Console\Commands;

use App\Repository\VocabularyQuery;
use Illuminate\Console\Command;

class RunTests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simulationmoise:test';

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
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		$vocquery = new VocabularyQuery;
		$vocquery->constructArray();
		print_r($vocquery->relationSimulation());

    }
}
