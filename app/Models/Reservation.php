<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{    
    use HasFactory;
    protected $primaryKey = 'id_reservation';
  public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'date_debut',
        'date_fin',
        'etat',
        'id_client',
        'id_chambre'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client');
    }

    public function chambre(){
        return $this->belongsTo(Chambre::class, 'id_chambre');
    }
}
