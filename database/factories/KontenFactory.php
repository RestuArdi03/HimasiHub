<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Konten>
 */
class KontenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $judul = $this->faker->sentence(6);
        return [
            'judul' => $judul,
            'slug' => Str::slug($judul),
            'deskripsi' => $this->faker->paragraphs(10, true), // Menghasilkan teks paragraf
            // Mengambil gambar dari LoremFlickr. Parameter 'lock' dengan angka acak
            // ditambahkan untuk memastikan setiap URL unik, sehingga browser tidak
            // menampilkan gambar yang sama dari cache.
            'gambar' => 'https://loremflickr.com/1200/400/student,technology,activity/all?lock=' . $this->faker->randomNumber(5),
            // Mengambil user_id secara acak. Jika tidak ada user, buat satu.
            // Ini akan memperbaiki error "Application error" di Heroku.
            'users_id' => function () {
                return User::inRandomOrder()->first()->id ?? User::factory()->create()->id;
            },
        ];
    }
}
