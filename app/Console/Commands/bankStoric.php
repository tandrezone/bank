<?php

namespace App\Console\Commands;

use App\Models\Storic;
use Illuminate\Console\Command;

class bankStoric extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bank:storic';

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
     * @return int
     */
    public function handle()
    {
        $columns = ['wallet', 'coin','gain','gain%'];
        $storics = Storic::all();
        $table = [];
        foreach ($storics as $storic) {

            $table[] = [$storic->asset()->wallet()->name, $storic->asset()->coin, $storic->gain_value, $storic->gain_percentage];
        }
        $this->table($columns,$table);
        return Command::SUCCESS;
    }
}
