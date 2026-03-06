<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [

            // RUNNING SHOES
            [
                'name' => 'Nike Air Zoom Pegasus 40',
                'price' => 1800000,
                'stock' => 20,
                'category_id' => 1,
                'description' => 'Sepatu running ringan dengan cushioning responsif.'
            ],
            [
                'name' => 'Adidas Ultraboost 23',
                'price' => 2200000,
                'stock' => 15,
                'category_id' => 1,
                'description' => 'Running shoes dengan teknologi Boost.'
            ],
            [
                'name' => 'Asics Gel Nimbus 26',
                'price' => 2100000,
                'stock' => 18,
                'category_id' => 1,
                'description' => 'Sepatu lari dengan cushioning maksimal.'
            ],
            [
                'name' => 'New Balance 1080v13',
                'price' => 2000000,
                'stock' => 17,
                'category_id' => 1,
                'description' => 'Running shoes dengan Fresh Foam.'
            ],
            [
                'name' => 'Nike Invincible Run 3',
                'price' => 2300000,
                'stock' => 12,
                'category_id' => 1,
                'description' => 'Sepatu running dengan ZoomX foam.'
            ],
            [
                'name' => 'Puma Deviate Nitro 2',
                'price' => 1950000,
                'stock' => 14,
                'category_id' => 1,
                'description' => 'Sepatu lari dengan Nitro foam.'
            ],

            // BASKETBALL
            [
                'name' => 'Nike LeBron 21',
                'price' => 2600000,
                'stock' => 10,
                'category_id' => 2,
                'description' => 'Sepatu basket performa tinggi.'
            ],
            [
                'name' => 'Air Jordan 38',
                'price' => 2700000,
                'stock' => 9,
                'category_id' => 2,
                'description' => 'Sepatu basket premium dari Jordan.'
            ],
            [
                'name' => 'Adidas Harden Vol 7',
                'price' => 2400000,
                'stock' => 11,
                'category_id' => 2,
                'description' => 'Signature shoes James Harden.'
            ],
            [
                'name' => 'Nike KD 16',
                'price' => 2500000,
                'stock' => 8,
                'category_id' => 2,
                'description' => 'Sepatu basket Kevin Durant.'
            ],
            [
                'name' => 'Puma MB.03',
                'price' => 2200000,
                'stock' => 10,
                'category_id' => 2,
                'description' => 'Signature shoes LaMelo Ball.'
            ],
            [
                'name' => 'Under Armour Curry 11',
                'price' => 2600000,
                'stock' => 7,
                'category_id' => 2,
                'description' => 'Sepatu basket Stephen Curry.'
            ],

            // SNEAKERS
            [
                'name' => 'Nike Air Force 1',
                'price' => 1600000,
                'stock' => 25,
                'category_id' => 3,
                'description' => 'Sneakers klasik sepanjang masa.'
            ],
            [
                'name' => 'Air Jordan 1 Mid',
                'price' => 2500000,
                'stock' => 12,
                'category_id' => 3,
                'description' => 'Sneakers ikonik dari Jordan.'
            ],
            [
                'name' => 'Adidas Samba OG',
                'price' => 1700000,
                'stock' => 16,
                'category_id' => 3,
                'description' => 'Sneakers klasik Adidas.'
            ],
            [
                'name' => 'New Balance 550',
                'price' => 1900000,
                'stock' => 13,
                'category_id' => 3,
                'description' => 'Sneakers retro populer.'
            ],
            [
                'name' => 'Nike Dunk Low',
                'price' => 2000000,
                'stock' => 15,
                'category_id' => 3,
                'description' => 'Sneakers streetwear populer.'
            ],
            [
                'name' => 'Vans Old Skool',
                'price' => 1200000,
                'stock' => 20,
                'category_id' => 3,
                'description' => 'Sneakers skate klasik.'
            ],

            // TRAINING
            [
                'name' => 'Nike Metcon 9',
                'price' => 2100000,
                'stock' => 14,
                'category_id' => 4,
                'description' => 'Sepatu training untuk gym.'
            ],
            [
                'name' => 'Reebok Nano X3',
                'price' => 1900000,
                'stock' => 15,
                'category_id' => 4,
                'description' => 'Sepatu cross training.'
            ],
            [
                'name' => 'Under Armour Tribase Reign 5',
                'price' => 2000000,
                'stock' => 10,
                'category_id' => 4,
                'description' => 'Training shoes stabil.'
            ],
            [
                'name' => 'Adidas Dropset Trainer',
                'price' => 1800000,
                'stock' => 11,
                'category_id' => 4,
                'description' => 'Sepatu gym performa tinggi.'
            ],
            [
                'name' => 'Puma Fuse 2.0',
                'price' => 1700000,
                'stock' => 13,
                'category_id' => 4,
                'description' => 'Sepatu gym ringan.'
            ],
            [
                'name' => 'Nike Free Metcon 5',
                'price' => 2100000,
                'stock' => 9,
                'category_id' => 4,
                'description' => 'Sepatu hybrid training.'
            ],

            // OUTDOOR
            [
                'name' => 'Salomon Speedcross 6',
                'price' => 2300000,
                'stock' => 10,
                'category_id' => 5,
                'description' => 'Trail running shoes.'
            ],
            [
                'name' => 'Merrell Moab 3',
                'price' => 2100000,
                'stock' => 12,
                'category_id' => 5,
                'description' => 'Sepatu hiking populer.'
            ],
            [
                'name' => 'The North Face Vectiv',
                'price' => 2400000,
                'stock' => 8,
                'category_id' => 5,
                'description' => 'Sepatu trail performance.'
            ],
            [
                'name' => 'Columbia Redmond III',
                'price' => 1800000,
                'stock' => 14,
                'category_id' => 5,
                'description' => 'Sepatu hiking ringan.'
            ],
            [
                'name' => 'Adidas Terrex Swift R3',
                'price' => 2200000,
                'stock' => 9,
                'category_id' => 5,
                'description' => 'Sepatu outdoor tangguh.'
            ],
            [
                'name' => 'Hoka Speedgoat 5',
                'price' => 2400000,
                'stock' => 11,
                'category_id' => 5,
                'description' => 'Sepatu trail running populer.'
            ],

        ];

        foreach ($products as $product) {
            $product['slug'] = Str::slug($product['name']);
            Product::create($product);
        }
    }
}
