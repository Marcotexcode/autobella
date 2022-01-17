<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorie';

    protected $fillable = [
        'descrizione'
    ];
    
    public function ricambi()
    {
        return $this->hasMany(Ricambio::class);
    }
}
