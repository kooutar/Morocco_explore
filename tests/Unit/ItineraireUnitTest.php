<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\itineraire;

class ItineraireUnitTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_verification_duree_itineraire()
    {
        $itineraire = new Itineraire([
            'titre' => 'Voyage Test',
            'categorie' => 'Aventure',
            'duree' => 7
        ]);

        $this->assertEquals(7, $itineraire->duree);
    }
}
