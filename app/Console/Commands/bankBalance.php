<?php

namespace App\Console\Commands;

use App\Models\Asset;
use ccxt\binance;
use Illuminate\Console\Command;
use function Symfony\Component\Translation\t;

class bankBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bank:balance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get my bank balance';

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
        $exchange = new binance();
        $exchange->load_markets();
        $assets = Asset::all();
        $knownSymbols = ['UMA', 'ZRX','OMG','ANKR','1INCH','ETH','XRP','ADA','DOT','BCH'];
        $tvalue = 0;
        $table = [];
        $ticker = $exchange->fetch_ticker('BTCEUR');
        $eurbtc = $ticker['last'];

        foreach ($assets as $asset) {
            if(in_array($asset->coin,$knownSymbols)) {
                $ticker = $exchange->fetch_ticker($asset->coin . 'BTC');
                $btcoin =  $ticker['last'] . " \n";
                $valEur = $eurbtc*$btcoin*$asset->value;
                $tvalue = $tvalue+$valEur;
            }
            if($asset->coin == 'AMP'){
                $tvalue = $tvalue+100;
                $valEur = 100;
            }
            if($asset->coin == 'EUR'){
                $tvalue = $tvalue+$asset->value;
                $valEur = $asset->value;
            }
            $table[] = [$asset->wallet()->name, $asset->coin, $asset->value, round($valEur,2)."€"];
        }
        $this->table(['wallet','coin','value','valueEUR'],
        $table);
        echo "\nTotal:".round($tvalue,2)."€\n";
        return Command::SUCCESS;
    }
}
