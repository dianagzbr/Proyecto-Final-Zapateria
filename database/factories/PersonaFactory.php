<?php

namespace Database\Factories;

use App\Models\Persona;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Persona>
 */
class PersonaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Persona::class;

    public function definition()
    {
        return [
            'razon_social' => $this->faker->name(),
            'direccion' => $this->faker->address(),
            'tipo_persona' => $this->faker->randomElement(['natural', 'jurídica']),
            'documento_id' => $this->faker->numberBetween(1, 4),
            'numero_documento' => $this->faker->unique()->numerify('##########'),
        ];
    }
}
