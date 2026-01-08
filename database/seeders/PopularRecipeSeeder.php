<?php

namespace Database\Seeders;

use App\Models\Recipe;
use App\Models\RecipeLike;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PopularRecipeSeeder extends Seeder
{
    public function run(): void
    {
        // Buat users untuk memberikan likes
        $users = User::factory()->count(100)->create();

        $recipes = [
            [
                'title' => 'Nasi Goreng Kampung Spesial',
                'chef' => 'Budi Santoso',
                'description' => 'Nasi goreng dengan bumbu tradisional, pete, dan kerupuk udang.',
                'category' => 'makan malam',
                'difficulty' => 'Mudah',
                'duration' => '20 menit',
                'servings' => '2 porsi',
                'ingredients' => ['2 piring nasi putih', '2 butir telur', '3 siung bawang putih', '5 siung bawang merah', '2 cabai merah', 'Kecap manis', 'Garam dan merica'],
                'steps' => ['Haluskan bumbu', 'Tumis bumbu hingga harum', 'Masukkan telur, orak-arik', 'Tambahkan nasi, aduk rata', 'Bumbui dengan kecap dan garam', 'Sajikan dengan kerupuk'],
            ],
            [
                'title' => 'Rendang Daging Padang',
                'chef' => 'Minang',
                'description' => 'Rendang daging sapi dengan bumbu rempah khas Padang yang kaya rasa.',
                'category' => 'makan siang',
                'difficulty' => 'Sulit',
                'duration' => '180 menit',
                'servings' => '6 porsi',
                'ingredients' => ['1 kg daging sapi', '1 liter santan', '10 cabai merah', '8 siung bawang merah', '6 siung bawang putih', 'Lengkuas, serai, daun jeruk', 'Kelapa parut sangrai'],
                'steps' => ['Potong daging kotak-kotak', 'Haluskan bumbu rempah', 'Masak daging dengan santan dan bumbu', 'Aduk terus hingga santan menyusut', 'Masak hingga daging empuk dan berwarna coklat', 'Angkat dan sajikan'],
            ],
            [
                'title' => 'Sate Ayam Madura',
                'chef' => 'Hasan',
                'description' => 'Sate ayam dengan bumbu kacang manis khas Madura.',
                'category' => 'camilan',
                'difficulty' => 'Sedang',
                'duration' => '45 menit',
                'servings' => '4 porsi',
                'ingredients' => ['500g daging ayam', '20 tusuk sate', 'Bumbu kacang', 'Kecap manis', 'Bawang merah', 'Cabai rawit'],
                'steps' => ['Potong ayam dadu', 'Tusuk dengan tusukan sate', 'Bakar di atas bara', 'Olesi dengan bumbu kacang', 'Sajikan dengan lontong'],
            ],
            [
                'title' => 'Gado-Gado Betawi',
                'chef' => 'Siti',
                'description' => 'Salad sayuran dengan bumbu kacang creamy dan kerupuk.',
                'category' => 'makan siang',
                'difficulty' => 'Mudah',
                'duration' => '30 menit',
                'servings' => '3 porsi',
                'ingredients' => ['Kangkung', 'Tauge', 'Kentang', 'Telur rebus', 'Tahu goreng', 'Tempe goreng', 'Bumbu kacang'],
                'steps' => ['Rebus sayuran', 'Goreng tahu dan tempe', 'Rebus telur dan kentang', 'Siapkan bumbu kacang', 'Tata semua bahan', 'Siram dengan bumbu kacang'],
            ],
            [
                'title' => 'Soto Ayam Lamongan',
                'chef' => 'Ratna',
                'description' => 'Soto ayam kuning dengan koya dan sambal.',
                'category' => 'makan siang',
                'difficulty' => 'Sedang',
                'duration' => '60 menit',
                'servings' => '4 porsi',
                'ingredients' => ['1 ekor ayam kampung', 'Kunyit', 'Serai', 'Daun jeruk', 'Bawang putih', 'Bawang merah', 'Koya'],
                'steps' => ['Rebus ayam hingga empuk', 'Suwir daging ayam', 'Tumis bumbu halus', 'Masukkan ke dalam kuah', 'Sajikan dengan koya dan sambal'],
            ],
            [
                'title' => 'Bakso Malang Komplit',
                'chef' => 'Joko',
                'description' => 'Bakso daging sapi dengan mie, siomay, dan tahu goreng.',
                'category' => 'makan malam',
                'difficulty' => 'Sulit',
                'duration' => '90 menit',
                'servings' => '5 porsi',
                'ingredients' => ['500g daging sapi giling', 'Tepung tapioka', 'Es batu', 'Bawang putih', 'Merica', 'Garam'],
                'steps' => ['Giling daging dengan es batu', 'Tambahkan tepung dan bumbu', 'Bentuk bulatan bakso', 'Rebus dalam air mendidih', 'Buat kuah kaldu', 'Sajikan dengan pelengkap'],
            ],
            [
                'title' => 'Mie Goreng Jawa',
                'chef' => 'Dewi',
                'description' => 'Mie goreng manis dengan sayuran dan telur.',
                'category' => 'makan malam',
                'difficulty' => 'Mudah',
                'duration' => '15 menit',
                'servings' => '2 porsi',
                'ingredients' => ['2 bungkus mie telur', '2 butir telur', 'Kol iris', 'Wortel iris', 'Kecap manis', 'Bawang putih'],
                'steps' => ['Rebus mie, tiriskan', 'Tumis bawang putih', 'Masukkan sayuran', 'Tambahkan mie dan telur', 'Bumbui dengan kecap', 'Aduk rata dan sajikan'],
            ],
            [
                'title' => 'Ayam Geprek Sambal Bawang',
                'chef' => 'Rizky',
                'description' => 'Ayam goreng tepung dengan sambal bawang pedas.',
                'category' => 'makan siang',
                'difficulty' => 'Mudah',
                'duration' => '30 menit',
                'servings' => '2 porsi',
                'ingredients' => ['2 potong dada ayam', 'Tepung terigu', 'Tepung maizena', 'Cabai rawit', 'Bawang putih', 'Garam'],
                'steps' => ['Goreng ayam dengan tepung', 'Buat sambal bawang', 'Geprek ayam', 'Siram dengan sambal', 'Sajikan dengan nasi'],
            ],
            [
                'title' => 'Pecel Lele Lamongan',
                'chef' => 'Slamet',
                'description' => 'Lele goreng dengan sambal pecel dan lalapan.',
                'category' => 'makan malam',
                'difficulty' => 'Sedang',
                'duration' => '40 menit',
                'servings' => '2 porsi',
                'ingredients' => ['2 ekor lele', 'Sambal pecel', 'Lalapan segar', 'Bawang putih', 'Kunyit', 'Garam'],
                'steps' => ['Bersihkan lele', 'Lumuri dengan bumbu', 'Goreng hingga kering', 'Siapkan sambal pecel', 'Sajikan dengan lalapan'],
            ],
            [
                'title' => 'Nasi Uduk Betawi',
                'chef' => 'Ningsih',
                'description' => 'Nasi gurih dengan santan, disajikan dengan lauk lengkap.',
                'category' => 'sarapan',
                'difficulty' => 'Sedang',
                'duration' => '45 menit',
                'servings' => '4 porsi',
                'ingredients' => ['2 cup beras', 'Santan', 'Serai', 'Daun salam', 'Daun pandan', 'Garam'],
                'steps' => ['Cuci beras', 'Masak dengan santan dan rempah', 'Kukus hingga matang', 'Siapkan lauk pauk', 'Sajikan dengan sambal'],
            ],
            [
                'title' => 'Es Cendol Dawet',
                'chef' => 'Yanti',
                'description' => 'Minuman segar dengan cendol, santan, dan gula merah.',
                'category' => 'minuman',
                'difficulty' => 'Mudah',
                'duration' => '20 menit',
                'servings' => '4 porsi',
                'ingredients' => ['Tepung hunkwe', 'Air pandan', 'Santan', 'Gula merah', 'Es batu'],
                'steps' => ['Buat adonan cendol', 'Cetak dengan saringan', 'Buat sirup gula merah', 'Siapkan santan', 'Sajikan dengan es'],
            ],
            [
                'title' => 'Pisang Goreng Crispy',
                'chef' => 'Adi',
                'description' => 'Pisang goreng dengan tepung renyah dan topping coklat.',
                'category' => 'camilan',
                'difficulty' => 'Mudah',
                'duration' => '15 menit',
                'servings' => '6 porsi',
                'ingredients' => ['6 buah pisang kepok', 'Tepung terigu', 'Tepung beras', 'Gula', 'Garam', 'Air es'],
                'steps' => ['Kupas pisang', 'Buat adonan tepung', 'Celupkan pisang', 'Goreng hingga kecoklatan', 'Taburi topping'],
            ],
            [
                'title' => 'Bubur Ayam Jakarta',
                'chef' => 'Udin',
                'description' => 'Bubur nasi lembut dengan topping ayam suwir dan cakwe.',
                'category' => 'sarapan',
                'difficulty' => 'Sedang',
                'duration' => '50 menit',
                'servings' => '4 porsi',
                'ingredients' => ['1 cup beras', 'Ayam kampung', 'Cakwe', 'Kecap asin', 'Bawang goreng', 'Seledri'],
                'steps' => ['Masak bubur hingga lembut', 'Rebus dan suwir ayam', 'Siapkan topping', 'Tuang bubur ke mangkuk', 'Beri topping dan sajikan'],
            ],
            [
                'title' => 'Rawon Surabaya',
                'chef' => 'Endang',
                'description' => 'Sup daging hitam dengan kluwek khas Surabaya.',
                'category' => 'makan siang',
                'difficulty' => 'Sulit',
                'duration' => '120 menit',
                'servings' => '6 porsi',
                'ingredients' => ['1 kg daging sapi', 'Kluwek', 'Lengkuas', 'Serai', 'Daun jeruk', 'Bawang merah', 'Bawang putih'],
                'steps' => ['Rebus daging hingga empuk', 'Haluskan bumbu dan kluwek', 'Tumis bumbu halus', 'Masukkan ke dalam kuah', 'Masak hingga bumbu meresap', 'Sajikan dengan tauge dan telur asin'],
            ],
            [
                'title' => 'Tahu Gejrot Cirebon',
                'chef' => 'Ahmad',
                'description' => 'Tahu goreng dengan kuah asam manis pedas khas Cirebon.',
                'category' => 'camilan',
                'difficulty' => 'Mudah',
                'duration' => '20 menit',
                'servings' => '3 porsi',
                'ingredients' => ['10 buah tahu pong', 'Cabai rawit', 'Bawang putih', 'Gula merah', 'Asam jawa', 'Kecap manis'],
                'steps' => ['Goreng tahu hingga kering', 'Ulek bumbu', 'Buat kuah asam manis', 'Potong tahu', 'Siram dengan kuah'],
            ],
            [
                'title' => 'Siomay Bandung',
                'chef' => 'Eko',
                'description' => 'Siomay ikan dengan tahu, kentang, dan bumbu kacang.',
                'category' => 'camilan',
                'difficulty' => 'Sedang',
                'duration' => '60 menit',
                'servings' => '6 porsi',
                'ingredients' => ['500g ikan tenggiri', 'Tepung sagu', 'Tahu', 'Kentang', 'Telur', 'Pare', 'Bumbu kacang'],
                'steps' => ['Haluskan ikan', 'Campur dengan tepung', 'Bentuk siomay', 'Kukus hingga matang', 'Siapkan bumbu kacang', 'Sajikan dengan kecap dan jeruk limau'],
            ],
            [
                'title' => 'Kwetiau Goreng Seafood',
                'chef' => 'Michael',
                'description' => 'Kwetiau dengan udang, cumi, dan sayuran.',
                'category' => 'makan malam',
                'difficulty' => 'Sedang',
                'duration' => '25 menit',
                'servings' => '2 porsi',
                'ingredients' => ['200g kwetiau', 'Udang', 'Cumi', 'Sawi hijau', 'Tauge', 'Telur', 'Kecap asin'],
                'steps' => ['Rendam kwetiau', 'Tumis bawang putih', 'Masak seafood', 'Tambahkan kwetiau', 'Masukkan sayuran', 'Bumbui dan sajikan'],
            ],
            [
                'title' => 'Opor Ayam Lebaran',
                'chef' => 'Kartini',
                'description' => 'Ayam dengan kuah santan kuning khas lebaran.',
                'category' => 'makan siang',
                'difficulty' => 'Sedang',
                'duration' => '75 menit',
                'servings' => '6 porsi',
                'ingredients' => ['1 ekor ayam', 'Santan', 'Lengkuas', 'Serai', 'Daun salam', 'Kunyit', 'Ketumbar'],
                'steps' => ['Potong ayam', 'Haluskan bumbu', 'Tumis bumbu', 'Masukkan ayam', 'Tuang santan', 'Masak hingga empuk'],
            ],
            [
                'title' => 'Nasi Liwet Solo',
                'chef' => 'Sari',
                'description' => 'Nasi gurih dengan areh dan lauk-pauk khas Solo.',
                'category' => 'makan malam',
                'difficulty' => 'Sedang',
                'duration' => '60 menit',
                'servings' => '4 porsi',
                'ingredients' => ['2 cup beras', 'Santan', 'Ayam kampung', 'Telur', 'Serai', 'Daun salam'],
                'steps' => ['Masak nasi dengan santan', 'Buat areh dari santan kental', 'Goreng ayam', 'Rebus telur', 'Tata nasi dengan lauk', 'Sajikan hangat'],
            ],
            [
                'title' => 'Es Teler Segar',
                'chef' => 'Linda',
                'description' => 'Minuman segar dengan alpukat, kelapa, dan cincau.',
                'category' => 'minuman',
                'difficulty' => 'Mudah',
                'duration' => '15 menit',
                'servings' => '4 porsi',
                'ingredients' => ['Alpukat', 'Kelapa muda', 'Cincau', 'Nangka', 'Susu kental manis', 'Es batu'],
                'steps' => ['Potong buah-buahan', 'Siapkan cincau', 'Tata dalam gelas', 'Tambahkan susu dan sirup', 'Beri es batu', 'Aduk dan sajikan'],
            ],
            [
                'title' => 'Pempek Palembang',
                'chef' => 'Fatimah',
                'description' => 'Pempek ikan dengan kuah cuko pedas manis.',
                'category' => 'camilan',
                'difficulty' => 'Sulit',
                'duration' => '90 menit',
                'servings' => '8 porsi',
                'ingredients' => ['500g ikan tenggiri', 'Tepung sagu', 'Air', 'Bawang putih', 'Garam', 'Gula merah untuk cuko'],
                'steps' => ['Giling ikan halus', 'Campur dengan tepung dan air', 'Bentuk pempek', 'Rebus hingga mengapung', 'Goreng sebelum disajikan', 'Sajikan dengan cuko'],
            ],
            [
                'title' => 'Martabak Manis Keju',
                'chef' => 'Roni',
                'description' => 'Martabak tebal dengan topping keju, coklat, dan kacang.',
                'category' => 'dessert',
                'difficulty' => 'Sedang',
                'duration' => '45 menit',
                'servings' => '8 porsi',
                'ingredients' => ['Tepung terigu', 'Ragi', 'Telur', 'Gula', 'Mentega', 'Keju', 'Coklat meses'],
                'steps' => ['Buat adonan', 'Diamkan hingga mengembang', 'Tuang di wajan khusus', 'Masak hingga matang', 'Olesi mentega', 'Taburi topping'],
            ],
            [
                'title' => 'Gulai Kambing',
                'chef' => 'Mansur',
                'description' => 'Gulai daging kambing dengan rempah kaya.',
                'category' => 'makan siang',
                'difficulty' => 'Sulit',
                'duration' => '150 menit',
                'servings' => '6 porsi',
                'ingredients' => ['1 kg daging kambing', 'Santan', 'Cabai', 'Lengkuas', 'Serai', 'Daun kunyit', 'Rempah gulai'],
                'steps' => ['Potong daging', 'Haluskan bumbu', 'Tumis bumbu', 'Masukkan daging', 'Tuang santan', 'Masak hingga empuk'],
            ],
            [
                'title' => 'Sop Buntut',
                'chef' => 'William',
                'description' => 'Sup buntut sapi dengan kuah bening dan rempah.',
                'category' => 'makan malam',
                'difficulty' => 'Sedang',
                'duration' => '180 menit',
                'servings' => '4 porsi',
                'ingredients' => ['1 kg buntut sapi', 'Wortel', 'Kentang', 'Tomat', 'Bawang bombay', 'Pala', 'Cengkeh'],
                'steps' => ['Rebus buntut hingga empuk', 'Goreng sebentar', 'Buat kuah dengan rempah', 'Masukkan sayuran', 'Masak hingga matang', 'Sajikan dengan sambal dan emping'],
            ],
            [
                'title' => 'Klepon Pandan',
                'chef' => 'Wati',
                'description' => 'Kue klepon isi gula merah dengan taburan kelapa.',
                'category' => 'dessert',
                'difficulty' => 'Sedang',
                'duration' => '40 menit',
                'servings' => '20 buah',
                'ingredients' => ['Tepung ketan', 'Air pandan', 'Gula merah', 'Kelapa parut', 'Garam'],
                'steps' => ['Buat adonan dengan air pandan', 'Isi dengan gula merah', 'Bentuk bulatan', 'Rebus hingga mengapung', 'Gulingkan di kelapa parut', 'Sajikan'],
            ],
        ];

        // Buat atau ambil user pemilik resep
        $chefUser = User::firstOrCreate(
            ['email' => 'chef@resepin.com'],
            ['name' => 'Chef Resepin', 'password' => bcrypt('password')]
        );

        foreach ($recipes as $recipeData) {
            $slug = Str::slug($recipeData['title']);
            $recipe = Recipe::create([
                'user_id' => $chefUser->id,
                'slug' => $slug,
                'title' => $recipeData['title'],
                'chef' => $recipeData['chef'],
                'initial_rating' => rand(40, 50) / 10,
                'description' => $recipeData['description'],
                'image' => 'recipes/' . $slug . '.jpg',
                'duration' => $recipeData['duration'],
                'servings' => $recipeData['servings'],
                'difficulty' => $recipeData['difficulty'],
                'category' => $recipeData['category'],
                'ingredients' => $recipeData['ingredients'],
                'steps' => $recipeData['steps'],
            ]);

            // Beri likes acak antara 30-100
            $likeCount = rand(30, 100);
            $randomUsers = $users->random(min($likeCount, $users->count()));
            
            foreach ($randomUsers as $user) {
                RecipeLike::create([
                    'recipe_id' => $recipe->id,
                    'user_id' => $user->id,
                ]);
            }
        }

        $this->command->info("Berhasil membuat 25 resep dengan likes acak (30-100)!");
    }
}
