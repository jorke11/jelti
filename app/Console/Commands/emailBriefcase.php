<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Report\CronController;

class emailBriefcase extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'briefcase:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get all briefcase of system in status pending';

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
