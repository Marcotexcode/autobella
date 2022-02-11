@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Nome Ricambio</th>
                        <th scope="col">Prezzo €</th>
                        <th scope="col">Quantità</th>
                        <th scope="col">Tot €</th>
                        <th scope="col">Azioni</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($righeCarrello as $rigaCarrello)
                            <tr>
                                <td>{{$rigaCarrello->ricambio->codice}}</td>
                                <td>{{$rigaCarrello->ricambio->prezzo}}</td>
                                <td>{{$rigaCarrello->quantità}}</td>
                                <td>{{$rigaCarrello->quantità * $rigaCarrello->prezzo}}</td>

                                <td>
                                    <form action="{{ route('carrello.destroy', $rigaCarrello) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('carrello.edit', $rigaCarrello->id) }}" class="btn btn-primary">Modifica</a>
                                        <button type="submit" class="btn btn-danger">Elimina</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <h2> Totale: {{$sommaTotale}} €</h2> 

                <a href="{{ Auth::user() ? url('indirizzo') : route('login')}}" class="btn btn-primary">Conferma Ordine</a>

            </div>
        </div>
    </div>
@endsection