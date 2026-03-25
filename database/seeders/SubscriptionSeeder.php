<?php

namespace Database\Seeders;

use App\Models\Subscription;
use Illuminate\Database\Seeder;

/**
 * Seeds the subscriptions table with the 3 default Via membership tiers.
 * Run once after migrating: php artisan db:seed --class=SubscriptionSeeder
 */
class SubscriptionSeeder extends Seeder
{
    public function run(): void
    {
        // Only seed if table is empty to avoid duplicates
        if (Subscription::count() > 0) {
            return;
        }

        $tiers = [
            [
                'name'     => 'Via Basic',
                'price'    => '500',
                'period'   => '/month',
                'tagline'  => 'Entry to the ecosystem',
                'features' => "Educational content access\nCommunity forums\nWeekly insights",
            ],
            [
                'name'     => 'Via Core',
                'price'    => '1,200',
                'period'   => '/month',
                'tagline'  => 'Tools and guidance',
                'features' => "Everything in Basic\nCurated opportunities\nGroup community sessions\nProduct guidance",
            ],
            [
                'name'     => 'Via Circle',
                'price'    => '15,000',
                'period'   => '/month',
                'tagline'  => 'Personal community',
                'features' => "Everything in Core\nOne-on-one community\nCareer guidance\nEquity participation",
            ],
        ];

        foreach ($tiers as $tier) {
            Subscription::create($tier);
        }
    }
}
