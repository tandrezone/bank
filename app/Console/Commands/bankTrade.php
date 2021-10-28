<?php

namespace App\Console\Commands;

use App\Models\Asset;
use App\Models\Trade;
use Illuminate\Console\Command;

class bankTrade extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bank:trade';

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
        $assets = Asset::orderBy('wallet_id')->get();
        $table = [];
        foreach ($assets as $asset) {
            $table[] = [$asset->id,$asset->wallet()->name,$asset->coin, $asset->value];
        }
        $this->table(['id','wallet','coin','value'],$table);
        $asset = $this->ask('Which asset you pretend to use?');
        $description =  $this->ask('What this trade is related to?');
        $value =$this->ask('What is the value?');
        $fee =$this->ask('What is the fee?');


        Trade::create([
            'asset_id' => $asset,
            'description' => $description,
            'value' => $value,
            'fee' => $fee
        ]);
        $asset = Asset::find($asset);
        $valueDB = $asset->value;
        $vX = $valueDB+$value;
        $asset->value = $vX;
        $asset->save();
        return Command::SUCCESS;
    }
}
