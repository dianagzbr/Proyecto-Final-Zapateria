<?php

namespace Tests\Feature;

use App\Models\Talla;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TallaControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Crear un usuario manualmente
        $this->adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'), 
            'role' => 'admin',
        ]);

        
        $this->actingAs($this->adminUser);
    }

    /** @test */
    public function usuario_puede_consultar_ruta_tallas_y_con_codigo_200()
    {
        // Crear tallas para probar
        $tallas = Talla::factory()->count(3)->create();

        // Consultar la ruta
        $response = $this->get(route('tallas.index'));

        // Verificar que la ruta responde con código 200
        $response->assertStatus(200);

        // Verificar que las tallas están presentes en la respuesta
        foreach ($tallas as $talla) {
            $response->assertSee($talla->nombre); 
        }
    }

    /** @test */
    public function usuario_puede_crear_una_talla_y_redireccionar()
    {
        // Datos válidos para crear una talla
        $data = [
            'nombre' => '22',
        ];

        // Enviar petición POST para crear una talla
        $response = $this->post(route('tallas.store'), $data);

        // Verificar que se creó en la base de datos
        $this->assertDatabaseHas('tallas', [
            'nombre' => '22',
        ]);

        // Verificar redirección
        $response->assertRedirect(route('tallas.index'));
    }

    /** @test */
    public function usuario_no_puede_crear_talla_con_datos_invalidos()
    {
        // Enviar datos inválidos
        $data = [
            'nombre' => '', // Campo requerido vacío
        ];

        // Enviar petición POST
        $response = $this->post(route('tallas.store'), $data);

        // Verificar que no se creó el registro en la base de datos
        $this->assertDatabaseCount('tallas', 0);

        // Verificar error en validación
        $response->assertSessionHasErrors(['nombre']);
    }

    /** @test */
    public function usuario_puede_eliminar_una_talla_y_redireccionar()
    {
        // Crear una talla para eliminar
        $talla = Talla::factory()->create();

        // Enviar petición DELETE
        $response = $this->delete(route('tallas.destroy', $talla->id));

        // Verificar que la talla fue eliminada
        $this->assertDatabaseMissing('tallas', ['id' => $talla->id]);

        // Verificar redirección
        $response->assertRedirect(route('tallas.index'));
    }
}
