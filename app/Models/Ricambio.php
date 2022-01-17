<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ricambio extends Model
{
    use HasFactory;

    protected $table = 'ricambi';

    protected $fillable = [
        'categoria_id',
        'fornitore_id',
        'descrizione',
        'prezzo',
        'codice'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function fornitore()
    {
        return $this->belongsTo(Fornitore::class);
    }
}
