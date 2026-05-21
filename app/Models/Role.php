<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{      
     protected $fillable = ['libelle'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
