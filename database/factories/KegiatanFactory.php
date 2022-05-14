<?php

namespace Database\Factories;

use App\Models\Kegiatan;
use Illuminate\Database\Eloquent\Factories\Factory;

class KegiatanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Kegiatan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $radio = '{"radio" : {"False" : 0, "True" : 1}}';
        $select = '{"select" : {"False" : 0, "True" : 1}}';
        $tipe = $this->faker->randomElement(['text', 'textarea', 'number', 'time', 'radio', 'select']);
        return [
            'kegiatan' => $this->faker->randomElement(['Menonton', 'Senam', 'Berenang']),
            'deskripsi' => $this->faker->randomElement(['Menonton Film', 'Senam/Menari', 'Bermain berkelompok']),
            'tipe' => $tipe,
            'data' => ($tipe == 'radio' ? $radio : ($tipe == 'select' ? $select : null)),
            'group' => $this->faker->randomElement(['Makanan dan Snack', 'Kegiatanku', 'Kecelakaan']),
        ];
    }
}
