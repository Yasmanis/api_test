<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Product;
use App\User;
use App\Notifications\LookForPendingNotification;
use Illuminate\Support\Facades\Notification;

class LookForPendingProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'look:pending_products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for looking products on pending status';

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
     * @return mixed
     */
    public function handle()
    {
        $pending_products = Product::where('status', 'pending')->get();
        if (count($pending_products) > 0) {
            $this->info("Pending products detected!!!!");
            $this->info($pending_products);
            $user = User::where('role','admin')->get();
            $user->each->notify(new LookForPendingNotification($pending_products));
        }
    }
}
