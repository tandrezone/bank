<?php

namespace App\Console\Commands;

use App\Models\Wallet;
use Illuminate\Console\Command;

class createWallet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bank:wallet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create/edit wallets';

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
        $wallets = Wallet::all();
        $table = [];
        foreach ($wallets as $wallet) {
            $table[] = ['id' => $wallet->id, 'name' => $wallet->name, 'description' => $wallet->description];
        }
        $this->table(['id','name','description'],$table);
        $name = $this->ask('Name of the new wallet?');
        $description = $this->ask('Description of the new wallet?');
        Wallet::create([
            'name' => $name,
            'description' => $description
        ]);
        //print_r($wallets);
        return Command::SUCCESS;
    }
}
