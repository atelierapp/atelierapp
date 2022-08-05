<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\ProductView;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class ProductViewCount implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private Product $product;
    private ?int $userId;
    private Carbon $called;

    public function __construct(Product $product, ?int $userId)
    {
        $this->product = $product->withoutRelations();
        $this->userId = $userId;
        $this->called = now();
    }

    public function handle()
    {
        $this->product->increment('view_count');

        ProductView::create([
            'product_id' => $this->product->id,
            'user_id' => $this->userId,
            'created_at' => $this->called
        ]);
    }
}
