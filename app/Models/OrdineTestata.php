<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdineTestata extends Model
{
    use HasFactory;

    protected $table = 'ordine_testate';

    protected $fillable = [
        'user_id',
        'tipo',
        'indirizzo',
        'telefono'
    ];

    public function ordine_righe()
    {
        return $this->hasMany(OrdineRiga::class);
    }

    public function utente()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
