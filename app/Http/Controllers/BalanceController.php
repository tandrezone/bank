<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Services\Crypto;
use Illuminate\Console\Command;

class BalanceController extends Controller
{
    public $crypto;
    public function __construct(Crypto $crypto) {
        $this->crypto = $crypto;
    }
    public function index() {
        list($table,$totalPrice,$totalGain) = Asset::zask();
        return view('bank.index', [
            "tableHeaders" => ['wallet','coin','value','valueEUR','gain'],
            "tableBody" => $table,
            "total" => round($totalPrice,2),
            "gain" => round($totalGain,2)
        ]);
        return Command::SUCCESS;
    }
}
