<?php

namespace Database\Factories;

use App\Models\Persona;
use App\Models\Proveedore;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Proveedore>
 */
class ProveedoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Proveedore::class;

    public function definition()
    {
        return [
            'persona_id' => Persona::factory(), // Relación con Persona
        ];
    }
}
