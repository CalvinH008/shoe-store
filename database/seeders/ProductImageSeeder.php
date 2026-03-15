<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProductImageSeeder extends Seeder
{
    private array $productImages = [
        'Nike Air Zoom Pegasus 40'      => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600',
        'Adidas Ultraboost 23'          => 'https://images.unsplash.com/photo-1608231387042-66d1773070a5?w=600',
        'Asics Gel Nimbus 26'           => 'https://images.unsplash.com/photo-1539185441755-769473a23570?w=600',
        'New Balance 1080v13'           => 'https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?w=600',
        'Nike Invincible Run 3'         => 'https://images.unsplash.com/photo-1491553895911-0055eca6402d?w=600',
        'Puma Deviate Nitro 2'          => 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?w=600',
        'Nike LeBron 21'                => 'https://images.unsplash.com/photo-1556906781-9a412961a28c?w=600',
        'Air Jordan 38'                 => 'https://images.unsplash.com/photo-1460353581641-37baddab0fa2?w=600',
        'Adidas Harden Vol 7'           => 'https://images.unsplash.com/photo-1584735175315-9d5df23be620?w=600',
        'Nike KD 16'                    => 'https://images.unsplash.com/photo-1571945153237-4929e783af4a?w=600',
        'Puma MB.03'                    => 'https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?w=600',
        'Under Armour Curry 11'         => 'https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?w=600',
        'Nike Air Force 1'              => 'https://images.unsplash.com/photo-1600269452121-4f2416e55c28?w=600',
        'Air Jordan 1 Mid'              => 'https://images.unsplash.com/photo-1597045566677-8cf032ed6634?w=600',
        'Adidas Samba OG'               => 'https://images.unsplash.com/photo-1543508282-6319a3e2621f?w=600',
        'New Balance 550'               => 'https://images.unsplash.com/photo-1562183241-b937e95585b6?w=600',
        'Nike Dunk Low'                 => 'https://images.unsplash.com/photo-1603787081207-362bcef7c144?w=600',
        'Vans Old Skool'                => 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?w=600',
        'Nike Metcon 9'                 => 'https://images.unsplash.com/photo-1574680096145-d05b474e2155?w=600',
        'Reebok Nano X3'                => 'https://images.unsplash.com/photo-1576337942219-0f40ab4a5a5e?w=600',
        'Under Armour Tribase Reign 5'  => 'https://images.unsplash.com/photo-1518894781321-630e638d0742?w=600',
        'Adidas Dropset Trainer'        => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=600',
        'Puma Fuse 2.0'                 => 'https://images.unsplash.com/photo-1587563871167-1ee9c731aefb?w=600',
        'Nike Free Metcon 5'            => 'https://images.unsplash.com/photo-1579338559194-a162d19bf842?w=600',
        'Salomon Speedcross 6'          => 'https://images.unsplash.com/photo-1551107696-a4b0c5a0d9a2?w=600',
        'Merrell Moab 3'                => 'https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?w=600',
        'The North Face Vectiv'         => 'https://images.unsplash.com/photo-1516478177764-9fe5bd7e9717?w=600',
        'Columbia Redmond III'          => 'https://images.unsplash.com/photo-1520316587275-5e4f06f355e4?w=600',
        'Adidas Terrex Swift R3'        => 'https://images.unsplash.com/photo-1467043237213-65f2da53396f?w=600',
        'Hoka Speedgoat 5'              => 'https://images.unsplash.com/photo-1536185376-40d781d3a5e4?w=600',
    ];

    public function run(): void
    {
        $products = Product::all();

        foreach ($products as $product) {
            if ($product->images()->count() > 0) {
                $product->images()->delete();
            }

            // Search Unsplash berdasarkan nama produk
            $query = urlencode($product->name . ' shoe');
            $imageUrl = "https://source.unsplash.com/600x600/?{$query}";

            try {
                $response = Http::timeout(30)->withoutVerifying()->get($imageUrl);

                if ($response->successful()) {
                    $filename = 'products/product-' . $product->id . '.jpg';
                    Storage::disk('public')->put($filename, $response->body());

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $filename,
                        'is_primary' => true,
                        'sort_order' => 0,
                    ]);

                    $this->command->info("✅ {$product->name}");
                }
            } catch (\Exception $e) {
                $this->command->warn("❌ {$product->name}: " . $e->getMessage());
            }
        }
    }
}
