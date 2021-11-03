<?php

namespace App\Console\Commands;

use App\Models\Asset;
use Illuminate\Console\Command;

class bankSwap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bank:swap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Swap assets from one wallet or from one currency to another';

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
        $assets = Asset::orderBy('wallet_id')->get();
        $table = [];
        foreach ($assets as $asset) {
            $table[] = [$asset->id,$asset->wallet()->name,$asset->coin, $asset->value];
        }
        $this->table(['id','wallet','coin','value'],$table);
        return Command::SUCCESS;
    }
}
