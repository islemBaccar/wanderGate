<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\User;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'destination',
        'date_depart',
        'date_retour',
        'budget',
        'preferences',
        'type_voyage',
        'style_hebergement',
        'transport_prefere',
        'climat_souhaite',
    ];

    // Relation avec l'utilisateur (Un trip appartient à un utilisateur)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected $casts = [
        'preferences' => 'array',  // This will automatically cast preferences as an array when retrieving from the DB
    ];


    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}

/*
    // Relation avec la destination (Un trip a une destination)
    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    // Relation avec les activités (Un trip peut contenir plusieurs activités)
    public function activities()
    {
        return $this->hasMany(Activity::class, 'destination_id', 'destination_id');
    }

    // Relation avec les réservations
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
*/