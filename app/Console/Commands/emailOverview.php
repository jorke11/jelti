<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Http\Controllers\Report\CronController;

class emailOverview extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'overview:data';

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
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $obj = new CronController();
        $obj->emailoverview();
    }

}
