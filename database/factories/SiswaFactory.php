<?php

namespace Database\Factories;

use App\Models\Siswa;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiswaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Siswa::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $nama = $this->faker->name;
        return [
            'nama_lengkap' => $nama,
            'nama_panggilan' => explode(" ",$nama)[0],
            'tempat_lahir' => $this->faker->address,
            'tanggal_lahir' => $this->faker->date,
            'alamat' => $this->faker->address,
            'jenis_kelamin' => $this->faker->randomElement(['m', 'f']),
            'nama_ayah' => $this->faker->name,
            'telp_ayah' => '085'.$this->faker->numberBetween(1000000, 9000000),
            'nama_ibu' => $this->faker->name,
            'telp_ibu' => '085'.$this->faker->numberBetween(1000000, 9000000),
        ];
    }
}
