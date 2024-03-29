<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modello extends Model
{
    use HasFactory;

    protected $table = 'modelli';

    protected $fillable = [
        'marca_id',
        'nome',
        'anno_commercializzazione'
    ];

    public function marca() 
    {
        return $this->belongsTo(Marca::class);
    }

    public function ricambi()
    {
        return $this->belongsToMany(Ricambio::class);
    }
}
