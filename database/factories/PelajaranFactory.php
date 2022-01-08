<?php

namespace Database\Factories;

use App\Models\Pelajaran;
use Illuminate\Database\Eloquent\Factories\Factory;

class PelajaranFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pelajaran::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $nama = $this->faker->name;
        return [
            'pelajaran' => $nama,
        ];
    }
}
