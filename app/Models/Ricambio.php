<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ricambi extends Model
{
    use HasFactory;

    protected $table = 'ricambi';

    protected $fillable = [
        'categoria_id',
        'fornitore_id',
        'descrizione',
        'prezzo'
    ];

    public function categorie()
    {
        return $this->hasMany(Categoria::class);
    }

    public function fornitori()
    {
        return $this->hasMany(Fornitore::class);
    }
}
