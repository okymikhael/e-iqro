<?php

namespace Database\Factories;

use App\Models\Guru;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuruFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Guru::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $nama = $this->faker->name;
        return [
            'nip' => '000'.$this->faker->numberBetween(1000000, 9000000),
            'nama_guru' => $nama,
            'alamat' => $this->faker->address,
        ];
    }
}
