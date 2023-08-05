<?php

namespace Database\Seeders;

use App\Models\Provider;
use Illuminate\Database\Seeder;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $providers = [
            [
                'name' => 'amazon_native',
                'access_token' => 'AKIAI6BJD2TDO62RD4PA',
                'access_secret' => '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',
                'chance' => 10
            ],
            [
                'name' => 'rainforest',
                'access_token' => 'F2E0C0641BF94BDD87C054271DDC3090',
                'access_secret' => '',
                'chance' => 10
            ]
        ];
        Provider::insert($providers);
    }
}
