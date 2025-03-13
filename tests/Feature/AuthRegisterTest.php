<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AuthRegisterTest extends TestCase
{
    use RefreshDatabase; // Réinitialise la base de données après chaque test

    /** @test */
    public function un_utilisateur_peut_s_inscrire_avec_des_donnees_valides()
    {
        // Données de test pour l'inscription
        $data = [
            'name' => 'kaoutar',
            'email' => 'kaoutar@gmial.com',
            'password' => '12345678',
            
        ];

        // Envoyer une requête POST à l'endpoint de l'inscription
        $response = $this->postJson('/api/Auth', $data);

        // Vérifier que la réponse est bien 201 (Created)
        $response->assertStatus(201);

        // Vérifier que l'utilisateur a bien été créé dans la base de données
        $this->assertDatabaseHas('users', [
            'email' => 'kaoutar@gmial.com',
        ]);
    }

    /** @test */
    public function une_inscription_echoue_si_les_donnees_sont_invalides()
    {
        // Données invalides (mot de passe manquant)
        $data = [
            'name' => '',
            'email' => 'email-invalid',
            'password' => '',
           
        ];

        // Envoyer une requête POST
        $response = $this->postJson('/api/Auth', $data);

        // Vérifier que la réponse retourne une erreur 422 (Validation Error)
        $response->assertStatus(422);

        // Vérifier que l'utilisateur n'a pas été ajouté
        $this->assertDatabaseMissing('users', [
            'email' => 'email-invalid',
        ]);
    }
}
