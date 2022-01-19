@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('carrello.update', $ordineRiga->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card" style="width: 18rem;">
                        <img class="card-img-top" src="https://231719-715203-raikfcquaxqncofqfm.stackpathdns.com/media/wysiwyg/Vendita_Ricambi_Auto.jpg" alt="Card image cap">
                        <div class="card-body">
                        <h5 class="card-title"><strong>{{$ordineRiga->ricambio->codice}}</strong></h5>
                        <h6 class="card-title"><strong>Fornitore: </strong> {{$ordineRiga->ricambio->fornitore->ragione_sociale}}</h6>
                        <h6 class="card-title"><strong>Prezzo: </strong>{{$ordineRiga->ricambio->prezzo}} €</h6>
                        <h6 class="card-title"><strong>Compatibile con: </strong>  
                            @foreach ($ordineRiga->ricambio->modelli as $item)
                                {{$item->marca->nome}}-{{$item->nome}}{{-- 
                                --}}@if (!$loop->last){{--
                                --}},
                                @endif
                            @endforeach
                        </h6>
                        <h6><strong>Descrizione: </strong></h6>
                        <p class="card-text">{{$ordineRiga->ricambio->descrizione}}</p>
                        <div class="form-check">
                            <label class="form-check-label pt-3 text-center" for=""><strong>Quantità</strong></label>
                            <input class="form-input" value="{{$ordineRiga->quantità}}" name="quantità" type="number">
                        </div>
                        <button type="submit" href="#" class="btn btn-primary my-4">Aggiungi Carrello</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection