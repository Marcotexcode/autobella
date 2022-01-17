<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornitore extends Model
{
    use HasFactory;

    protected $table = 'fornitori';

    protected $fillable = [
        'ragione_sociale',
        'indirizzo',
        'comune',
        'cap',
        'provincia',
        'p_iva'
    ];

    public function ricambio()
    {
        return $this->belongsTo(Ricambi::class);
    }
}
