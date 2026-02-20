<?php

namespace Tests\Feature;

use App\Models\PlayerNote;
use App\Models\User;
use App\Repositories\Interfaces\PlayerNoteRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class PlayerNoteTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private PlayerNoteRepositoryInterface $noteRepository;
    private User $player;
    private User $agent;

    protected function setUp(): void
    {
        parent::setUp();

        $this->noteRepository = app(PlayerNoteRepositoryInterface::class);

        // Crear usuario jugador
        $this->player = User::factory()->create(['name' => 'Test Player']);

        // Crear agente de soporte
        $this->agent = User::factory()->create(['name' => 'Support Agent']);
    }

    /** @test */
    public function it_can_create_a_player_note(): void
    {
        $content = $this->faker->paragraph();

        $note = $this->noteRepository->create([
            'player_id' => $this->player->id,
            'author_id' => $this->agent->id,
            'content' => $content
        ]);

        // Verificar que la nota existe en la base de datos
        $this->assertDatabaseHas('player_notes', [
            'player_id' => $this->player->id,
            'author_id' => $this->agent->id,
            'content' => $content
        ]);
    }

    /** @test */
    public function it_can_get_notes_for_a_player(): void
    {
        // Crear 3 notas para el jugador
        PlayerNote::factory()->count(3)->create([
            'player_id' => $this->player->id,
            'author_id' => $this->agent->id
        ]);

        $notes = $this->noteRepository->getForPlayer($this->player->id);

        $this->assertEquals(3, $notes->total());
    }

    /** @test */
    public function it_validates_required_fields(): void
    {
        $this->expectException(ValidationException::class);

        $this->noteRepository->create([
            'player_id' => $this->player->id,
            'author_id' => $this->agent->id,
            'content' => '' // Contenido vacío
        ]);
    }
}
