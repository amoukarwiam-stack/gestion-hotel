<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chambre extends Model
{    
    use HasFactory;
    protected $primaryKey = 'id_chambre';
     public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'numero',
        'type',
        'prix',
        'disponible'
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'id_chambre');
    }
}
