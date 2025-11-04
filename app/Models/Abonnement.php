<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abonnement extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'duree_mois',
        'prix',
        'actif',
    ];

    protected $casts = [
        'actif' => 'boolean',
    ];
}
