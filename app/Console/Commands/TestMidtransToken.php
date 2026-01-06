<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Services\MidtransService;
use Illuminate\Support\Facades\Log;

class TestMidtransToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:midtrans';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Midtrans Snap token for latest pending order without token';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $order = Order::where('status', Order::STATUS_PENDING)
            ->whereNull('snap_token')
            ->latest()
            ->first();

        if (! $order) {
            $this->info('No pending order without snap_token found.');
            return 0;
        }

        $this->info('Testing order: ' . $order->order_number . ' (ID: ' . $order->id . ')');

        try {
            $svc = new MidtransService();
            $token = $svc->generateSnapToken($order);

            if ($token) {
                $order->update(['snap_token' => $token]);
                $this->info('Snap token generated and saved: ' . $token);
                return 0;
            }

            $this->error('Failed to generate snap token (returned null). Check logs.');
            return 1;
        } catch (\Exception $e) {
            $this->error('Exception: ' . $e->getMessage());
            Log::error('TestMidtransToken exception: ' . $e->getMessage());
            return 1;
        }
    }
}
