<?php

namespace Database\Seeders;

use App\Models\PetType;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Product::factory(50)->create();

        Product::create([
            'product_name' => 'Smartheart 1 Kg Makanan Kelinci Rasa Apel',
            'product_desc' => 'Rasa apel
Menjaga kesehatan kulit dan bulu kelinci
Kaya vitamin dan mineral',
            'product_product_type_id' => 1,
            'pet_pet_types_id' => 3,
            'product_image' => 'https://images.tokopedia.net/img/cache/700/hDjmkQ/2025/3/7/8f24522d-658b-46a0-91b2-3ec3518a49a7.jpg.webp?ect=4g',
            'product_stock' => fake()->numberBetween(1, 100),
            'product_rating' => fake()->numberBetween(1, 10),
            'product_price' => 49900,
        ]);

        Product::create([
            'product_name' => 'Royal Canin 3 Kg Makanan Anjing Kering Adult Cihuahua',
            'product_desc' => 'Makanan khusus untuk anjing Chihuahua
Kandungan nutrisi lengkap dan seimbang untuk sistem imun atau kekebalan tubuh
Menjaga kesehatan bulu agar lebih lebat dan berkilau
Mendukung kesehatan, gigi, tulang, dan persendian
Mencegah masalah pencernaan
Merangsang nafsu makan anjing
Mengurangi bau tidak sedap pada kotoran anjing
Rasa lezat yang disukai anjing
Memiliki bentuk dan ukuran kibble yang disesuaikan secara khusus',
            'product_product_type_id' => 1,
            'pet_pet_types_id' => 1,
            'product_image' => 'https://images.tokopedia.net/img/cache/700/hDjmkQ/2025/2/13/3c04fa21-cdc1-4c11-8baa-721ae95ebefc.jpg.webp?ect=4g',
            'product_stock' => fake()->numberBetween(10, 100),
            'product_rating' => fake()->numberBetween(5, 10),
            'product_price' => 445900,
        ]);

        Product::create([
            'product_name' => 'Pet Kingdom Wanpy 1.5 kg Makanan Kucing Kering Kitten grain Free Tuna',
            'product_desc' => 'Terbuat dari bahan-bahan berkualitas
Dilengkapi 91% protein hewani
Grain-free (tanpa tambahan jangung, gandum, kedelai, atau kacang-kacangan)
Meningkatkan sistem imun tubuh anak kucing selama masa pertumbuhan
Membantu melatih insting alami kucing untuk mengunyah
Tekstur mudah dicerna
Rasa dan aroma yang disukai kucing
Isi : 1.5 kg',
            'product_product_type_id' => 1,
            'pet_pet_types_id' => 2,
            'product_image' => 'https://images.tokopedia.net/img/cache/500-square/hDjmkQ/2025/3/25/c7f6f805-9520-432a-bc5f-1172e6e318e9.jpg.webp?ect=4g',
            'product_stock' => fake()->numberBetween(10, 100),
            'product_rating' => fake()->numberBetween(5, 10),
            'product_price' => 129900,
        ]);
        Product::create([
            'product_name' => 'Pet Kingdom Aatas Cat 80 gr Makanan Kucing Basah Daily Defence',
            'product_desc' => 'Disajikan dalam jelly gurih untuk pengalaman makan yang nikmat
Grain free
Dengan kombinasi bahan berkualitas
Mengandung Ammonium Chloride
Mendukung kesehatan saluran kemih
Membantu mencegah pembentukan batu ginjal dan kandung kemih
Menambah variasi makanan serta membantu hidrasi kucing
Memiliki rasa lezat yang disukai kucing 
Isi : 80 gr',
            'product_product_type_id' => 1,
            'pet_pet_types_id' => 2,
            'product_image' => 'https://images.tokopedia.net/img/cache/500-square/hDjmkQ/2025/3/25/55a165ac-76d0-4ce6-9e05-5aa8126190e6.jpg.webp?ect=4g',
            'product_stock' => fake()->numberBetween(10, 100),
            'product_rating' => fake()->numberBetween(5, 10),
            'product_price' => 16900,
        ]);
        Product::create([
            'product_name' => 'Pet Kingdom Ukuran S Coolpet Tali Ikatan Badan - Ungu/Hijau Mint',
            'product_desc' => 'Perpaduan warna menarik
Dilengkapi lubang pengait dan clip
Dapat dikaitkan dengan tali anjing
Panjang dan lebar tali dapat disesuaikan
Mudah dipasang dan nyaman saat digunakan
Material berkualitas, kuat, dan awet
Cocok untuk mengawasi atau membawa pergi anjing
Ukuran : S',
            'product_product_type_id' => 2,
            'pet_pet_types_id' => 1,
            'product_image' => 'https://images.tokopedia.net/img/cache/500-square/hDjmkQ/2025/3/5/4e4bb299-1f82-4e2f-99a2-889610016a0e.jpg.webp?ect=4g',
            'product_stock' => fake()->numberBetween(10, 100),
            'product_rating' => fake()->numberBetween(5, 10),
            'product_price' => 53940,
        ]);
        Product::create([
            'product_name' => 'Pet Kingdom M-Pets Ukuran L Java Tempat Tidur Anjing Dengan Cushion  ',
            'product_desc' => 'Cushion dengan kualitas bantalan empuk dan nyaman saat digunakan
Keranjang mudah dibersihkan
Mudah dipindahkan
Material berkualitas dan awet
Cocok digunakan sebagai tempat istirahat atau area tidur anjing
Ukuran : L',
            'product_product_type_id' => 2,
            'pet_pet_types_id' => 1,
            'product_image' => 'https://images.tokopedia.net/img/cache/500-square/hDjmkQ/2025/2/21/c7e3bcf5-aeff-430c-a739-fe7d27547a68.jpg.webp?ect=4g',
            'product_stock' => fake()->numberBetween(10, 100),
            'product_rating' => fake()->numberBetween(5, 10),
            'product_price' => 459900,
        ]);
        Product::create([
            'product_name' => 'Pet Kingdom 200 Ml Rose Parfum Hewan',
            'product_desc' => 'Praktis digunakan
Bebas alkohol
Aman untuk hewan peliharaan
Dapat digunakan untuk anjing dan kucing
Membuat bulu terasa halus, berkilau, dan wangi
Aroma : mawar
Isi : 200 ml',
            'product_product_type_id' => 3,
            'pet_pet_types_id' => 1,
            'product_image' => 'https://images.tokopedia.net/img/cache/500-square/hDjmkQ/2025/2/13/93359398-1875-4b5c-a0fd-9fd430a4d496.jpg.webp?ect=4g',
            'product_stock' => fake()->numberBetween(10, 100),
            'product_rating' => fake()->numberBetween(5, 10),
            'product_price' => 119900,
        ]);

        Product::create([
            'product_name' => 'Pet Kingdom Germ Killer 500 ml Spray Disinfektan',
            'product_desc' => 'Praktis digunakan
Disinfektan cair premium water based
Tersertifikasi oleh lembaga di Amerika dan Singapore
Hospital grade Efektif membunuh 99.99999% bakteri dan virus (termasuk SARS-CoV-2, H1N1, dan patogen berbahaya lainnya)
Mampu mencegah pertumbuhan jamur dan lumut
Dapat menghilangkan bau',
            'product_product_type_id' => 3, //3 = Obat, 2 = acc, 1 = food
            'pet_pet_types_id' => 1, // 1 anjing 2 kucing 3 kelinci 4 kura2
            'product_image' => 'https://images.tokopedia.net/img/cache/700/hDjmkQ/2025/3/6/6d530216-9e3f-45a3-a22c-cfdef9c118a7.jpg.webp?ect=4g',
            'product_stock' => fake()->numberBetween(10, 100),
            'product_rating' => fake()->numberBetween(5, 10),
            'product_price' => 198000,
        ]);
    }
}
