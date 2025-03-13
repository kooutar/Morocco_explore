<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class destination extends Model
{
    use HasFactory;
    
    protected $fillable=[
        'itineraire_id',
        'nom',
        'lieu_logement',
        'endroits_visite',
        'activites',
        'plats',
    ];
}
