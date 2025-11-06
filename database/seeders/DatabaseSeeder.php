<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\CarModel;
use App\Models\ColorOption;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@autohub.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('senha-segura'),
            ]
        );

        $brands = [
            [
                'name' => 'Chevrolet',
                'country' => 'Estados Unidos',
                'website' => 'https://www.chevrolet.com.br',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/7/7e/Chevrolet-logo.png',
            ],
            [
                'name' => 'Volkswagen',
                'country' => 'Alemanha',
                'website' => 'https://www.vw.com.br',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/2/26/VW-Logo-2019.png',
            ],
            [
                'name' => 'Toyota',
                'country' => 'Japão',
                'website' => 'https://www.toyota.com.br',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/9/9d/Toyota_carlogo.png',
            ],
        ];

        $brandModels = collect($brands)->mapWithKeys(fn ($data) => [
            $data['name'] => Brand::firstOrCreate(['name' => $data['name']], $data),
        ]);

        $carModels = [
            ['brand' => 'Chevrolet', 'name' => 'Onix', 'segment' => 'Hatch'],
            ['brand' => 'Chevrolet', 'name' => 'Tracker', 'segment' => 'SUV'],
            ['brand' => 'Volkswagen', 'name' => 'Nivus', 'segment' => 'SUV'],
            ['brand' => 'Volkswagen', 'name' => 'Polo', 'segment' => 'Hatch'],
            ['brand' => 'Toyota', 'name' => 'Corolla', 'segment' => 'Sedan'],
            ['brand' => 'Toyota', 'name' => 'Yaris', 'segment' => 'Hatch'],
        ];

        $modelRecords = collect($carModels)->map(function ($model) use ($brandModels) {
            return CarModel::firstOrCreate(
                [
                    'brand_id' => $brandModels[$model['brand']]->id,
                    'name' => $model['name'],
                ],
                [
                    'segment' => $model['segment'] ?? null,
                ]
            );
        })->keyBy('name');

        $colors = [
            ['name' => 'Preto Ônix', 'hex_code' => '#0A0A0A', 'is_metallic' => true],
            ['name' => 'Branco Neve', 'hex_code' => '#F7F7F7', 'is_metallic' => false],
            ['name' => 'Vermelho Rubro', 'hex_code' => '#C00021', 'is_metallic' => true],
            ['name' => 'Azul Caribe', 'hex_code' => '#005F99', 'is_metallic' => true],
        ];

        $colorRecords = collect($colors)->mapWithKeys(fn ($color) => [
            $color['name'] => ColorOption::firstOrCreate(['name' => $color['name']], $color),
        ]);

        $vehicles = [
            [
                'title' => 'Chevrolet Onix Premier Turbo',
                'brand' => 'Chevrolet',
                'model' => 'Onix',
                'color' => 'Azul Caribe',
                'year' => 2023,
                'mileage' => 12000,
                'price' => 94990.00,
                'main_photo_url' => 'https://storage.googleapis.com/car-demo/onix-premier-azul.jpg',
                'transmission' => 'Automático',
                'fuel_type' => 'Flex',
                'description' => 'Versão topo de linha com pacote completo de tecnologia e segurança.',
                'photos' => [
                    'https://storage.googleapis.com/car-demo/onix-premier-azul-1.jpg',
                    'https://storage.googleapis.com/car-demo/onix-premier-azul-2.jpg',
                ],
            ],
            [
                'title' => 'Volkswagen Nivus Comfortline',
                'brand' => 'Volkswagen',
                'model' => 'Nivus',
                'color' => 'Branco Neve',
                'year' => 2022,
                'mileage' => 18500,
                'price' => 119990.00,
                'main_photo_url' => 'https://storage.googleapis.com/car-demo/nivus-branco.jpg',
                'transmission' => 'Automático',
                'fuel_type' => 'Flex',
                'description' => 'SUV compacto com ótimo custo-benefício e conectividade VW Play.',
                'photos' => [
                    'https://storage.googleapis.com/car-demo/nivus-branco-1.jpg',
                    'https://storage.googleapis.com/car-demo/nivus-branco-2.jpg',
                    'https://storage.googleapis.com/car-demo/nivus-branco-3.jpg',
                ],
            ],
            [
                'title' => 'Toyota Corolla Altis Hybrid',
                'brand' => 'Toyota',
                'model' => 'Corolla',
                'color' => 'Preto Ônix',
                'year' => 2024,
                'mileage' => 5500,
                'price' => 189990.00,
                'main_photo_url' => 'https://storage.googleapis.com/car-demo/corolla-preto.jpg',
                'transmission' => 'Automático CVT',
                'fuel_type' => 'Híbrido',
                'description' => 'Sedan híbrido com excelente consumo e pacote Toyota Safety Sense.',
                'photos' => [
                    'https://storage.googleapis.com/car-demo/corolla-preto-1.jpg',
                    'https://storage.googleapis.com/car-demo/corolla-preto-2.jpg',
                    'https://storage.googleapis.com/car-demo/corolla-preto-3.jpg',
                ],
            ],
        ];

        foreach ($vehicles as $index => $vehicleData) {
            $vehicle = Vehicle::updateOrCreate(
                ['title' => $vehicleData['title']],
                [
                    'brand_id' => $brandModels[$vehicleData['brand']]->id,
                    'car_model_id' => $modelRecords[$vehicleData['model']]->id,
                    'color_option_id' => $colorRecords[$vehicleData['color']]->id,
                    'year' => $vehicleData['year'],
                    'mileage' => $vehicleData['mileage'],
                    'price' => $vehicleData['price'],
                    'main_photo_url' => $vehicleData['main_photo_url'],
                    'transmission' => $vehicleData['transmission'],
                    'fuel_type' => $vehicleData['fuel_type'],
                    'description' => $vehicleData['description'],
                    'is_published' => true,
                ]
            );

            foreach ($vehicleData['photos'] as $order => $url) {
                $vehicle->photos()->updateOrCreate(
                    ['image_url' => $url],
                    ['display_order' => $order]
                );
            }
        }
    }
}
