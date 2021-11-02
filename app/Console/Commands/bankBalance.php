<?php

namespace App\Console\Commands;

use App\Models\Asset;
use App\Services\Crypto;
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

    protected $crypto;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Crypto $cypto)
    {
        $this->crypto = $cypto;
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
        $totalPrice = 0;
        $totalGain = 0;
        $totalBuy = 0;
        foreach ($assets as $asset) {
            if(in_array($asset->coin,crypto::KNOWN_SYMBOLS)) {
                $coinPrice = $this->crypto->getRate($asset->coin . 'BTC', true);
                $assetPrice = $coinPrice * $asset->value;
                $totalPrice += $assetPrice;
                $gain = round($assetPrice - $asset->buy, 2);
                $totalGain += $gain;
                $gainPercentage = round(($assetPrice - $asset->buy) / ($asset->buy / 100), 1);
                $totalBuy += $asset->buy;
                $table[] = [$asset->wallet()->name, $asset->coin, $asset->value, round($assetPrice, 2) . "€", $gain . "€ (" . $gainPercentage . "%)"];
            }
            else {
                $totalPrice += $asset->value;
                $table[] = [$asset->wallet()->name, $asset->coin, $asset->value, "", ""];
            }


        }
        $this->table(['wallet','coin','value','valueEUR','gain'], $table);
        echo "\nTotal:".round($totalPrice,2)."€\n";
        echo "\nGain:".round($totalGain,2)."€\n";
        return Command::SUCCESS;
    }
}
