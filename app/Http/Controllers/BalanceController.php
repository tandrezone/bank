<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Storic;
use App\Services\Crypto;
use Illuminate\Console\Command;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    public $crypto;
    public function __construct(Crypto $crypto) {
        $this->crypto = $crypto;
    }
    public function index() {
        $assets = Asset::orderBy('wallet_id')->orderBy('coin')->get();
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
                $checkExists = false;
                $set = date("Ymdh");
                $check = Storic::where('set',$set)->where('asset_id',$asset->id)->first();
                if(!$check) {
                    Storic::create([
                        'asset_id' => $asset->id,
                        'set' => $set,
                        'gain_value' => $gain,
                        'gain_percentage' => $gainPercentage
                    ]);
                }

            }
            else {
                $totalPrice += $asset->value;
                $table[] = [$asset->wallet()->name, $asset->coin, $asset->value, "", ""];
            }


        }
        return view('bank.index', [
            "tableHeaders" => ['wallet','coin','value','valueEUR','gain'],
            "tableBody" => $table,
            "total" => round($totalPrice,2),
            "gain" => round($totalGain,2)
        ]);
        return Command::SUCCESS;
    }
}
