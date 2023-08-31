<?php

namespace App\Console\Commands;

use App\Http\Controllers\OrderController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Carbon\Carbon;

class ExpiredOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:expired-order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredOrders = Order::where('updated_at', '<', Carbon::now()->subDays(3))->get();

        if (count($expiredOrders) > 0) {
            foreach ($expiredOrders as $singleExpiredOrder) {
                if ($singleExpiredOrder->status == 'unpaid') {
                    $expiredOrderProducts = OrderProduct::where('order_id', $singleExpiredOrder->id)->get();
                    (new OrderController)->readdStock($expiredOrderProducts);
                    $singleExpiredOrder->delete();
                }
            }            
    
            return '';    
        } else {
            return '';
        }
        
    }
}
