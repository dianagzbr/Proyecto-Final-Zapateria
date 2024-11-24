<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Proveedore;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use League\CommonMark\Node\Block\Document;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->withPersonalTeam()->create();

        // User::factory()->withPersonalTeam()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // $this->call(DocumentoSeeder::class);
        // $this->call(ComprobanteSeeder::class);

        Cliente::factory()->count(20)->create(); // 20 clientes
        Proveedore::factory()->count(10)->create(); // 10 proveedores
    }
}
