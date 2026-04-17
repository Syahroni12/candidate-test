<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;
use App\Models\Layup;
use App\Models\Layer;
use Faker\Factory as Faker;
use Carbon\Carbon;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // 5 supplier spesifik beserta layup dan layer-nya
        $specificSuppliers = [
            ['name' => 'Nordic Timber Co.',    'layups' => 4, 'date' => '2023-10-24'],
            ['name' => 'Alpine CLT Solutions', 'layups' => 3, 'date' => '2023-11-02'],
            ['name' => 'MassivWood Ltd.',       'layups' => 5, 'date' => '2024-01-15'],
            ['name' => 'TimberStruct Inc.',     'layups' => 3, 'date' => '2024-02-10'],
            ['name' => 'EuroLam Systems',       'layups' => 4, 'date' => '2024-02-28'],
        ];

        // Pola angle CLT yang umum
        $anglePatterns = [
            [0, 90, 0],
            [0, 90, 0, 90, 0],
            [0, 90, 90, 0],
            [45, -45, 45],
            [0, 90, 0, 90, 0, 90, 0],
        ];

        foreach ($specificSuppliers as $data) {
            $supplier = Supplier::create([
                'name'       => $data['name'],
                'created_at' => Carbon::parse($data['date']),
                'updated_at' => Carbon::parse($data['date']),
            ]);

            for ($i = 0; $i < $data['layups']; $i++) {
                $layup = Layup::create([
                    'supplier_id' => $supplier->id,
                    'name'        => 'Layup ' . ($i + 1) . ' - ' . $supplier->name,
                ]);

                // Pilih pola angle acak
                $pattern = $anglePatterns[array_rand($anglePatterns)];
                $plyCount = count($pattern);
                $thickness = round($faker->randomFloat(1, 20, 50), 1);

                foreach ($pattern as $order => $angle) {
                    Layer::create([
                        'layup_id'    => $layup->id,
                        'layer_order' => $order + 1,
                        'thickness'   => $thickness,
                        'width'       => round($faker->randomFloat(1, 100, 300), 1),
                        'angle'       => $angle,
                    ]);
                }
            }
        }

        // 10 supplier tambahan secara random
        for ($j = 0; $j < 10; $j++) {
            $randomDate = $faker->dateTimeBetween('-2 years', 'now');

            $supplier = Supplier::create([
                'name'       => $faker->company . ' ' . $faker->companySuffix,
                'created_at' => $randomDate,
                'updated_at' => $randomDate,
            ]);

            $randomLayupsCount = rand(2, 6);
            for ($k = 0; $k < $randomLayupsCount; $k++) {
                $layup = Layup::create([
                    'supplier_id' => $supplier->id,
                    'name'        => 'Layup ' . strtoupper($faker->bothify('???-####')),
                ]);

                $pattern   = $anglePatterns[array_rand($anglePatterns)];
                $thickness = round($faker->randomFloat(1, 20, 50), 1);

                foreach ($pattern as $order => $angle) {
                    Layer::create([
                        'layup_id'    => $layup->id,
                        'layer_order' => $order + 1,
                        'thickness'   => $thickness,
                        'width'       => round($faker->randomFloat(1, 100, 300), 1),
                        'angle'       => $angle,
                    ]);
                }
            }
        }
    }
}
