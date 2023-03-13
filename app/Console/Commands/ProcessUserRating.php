<?php

namespace App\Console\Commands;

use App\Models\Store;
use App\Models\StoreUserRating;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ProcessUserRating extends Command
{
    protected $signature = 'process:user-rating';

    protected $description = 'Evaluate stores rating from users qualifications';

    public function handle(): void
    {
        StoreUserRating::query()
            ->select('store_id')
            ->addSelect(DB::raw('avg(score) as score'))
            ->groupBy('store_id')
            ->havingRaw('count(store_id) > 15')
            ->chunk(100, function ($ratings) {
                $ratings->each(fn ($rating) => Store::whereId($rating['store_id'])->update(['customer_rating' => $rating->score * 100]));
            });
    }
}
