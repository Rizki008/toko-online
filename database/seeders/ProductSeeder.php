<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i < 20; $i++) {
            Product::create([
                'id_kategori' => rand(1, 3),
                'id_subkategori' => rand(1, 4),
                'nama_barang' => 'Lorem Ipsum',
                'harga' => rand(1000, 10000000),
                'diskon' => 0,
                'bahan' => 'Lorem Ipsum',
                'tags' => 'Lorem, Ipsum, Average, Honolulu',
                'sku' => Str::random(8),
                'ukuran' => 'S,L,M,XL,XXL',
                'warna' => 'Hitam,Biru,Kuning,Merah,Putih,Hijau',
                'gambar' => 'shop_image_' . $i . '.jpg',
                'deskripsi' => 'Lorem Ipsum',
            ]);
        }
    }
}
