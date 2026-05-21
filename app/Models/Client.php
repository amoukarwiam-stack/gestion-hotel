<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $primaryKey = 'id_client';
    public $incrementing = true;
protected $keyType = 'int';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'user_id'
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'id_client');
    }

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}
}
