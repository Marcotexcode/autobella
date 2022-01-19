@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">id</th>
                        <th scope="col">Nome Ricambio</th>
                        <th scope="col">Prezzo €</th>
                        <th scope="col">Quantità</th>
                        <th scope="col">azioni</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($ordineRighe as $ordineRiga)
                            <tr>
                                <th scope="row">{{$ordineRiga->id}}</th>
                                <td>{{$ordineRiga->ricambio->codice}}</td>
                                <td>{{$ordineRiga->ricambio->prezzo}}</td>
                                <td>{{$ordineRiga->quantità}}</td>

                                <td>
                                    <form action="{{ route('carrello.destroy', $ordineRiga) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('carrello.edit', $ordineRiga->id) }}" class="btn btn-primary">Modifica</a>
                                        <button type="submit" class="btn btn-danger">Elimina</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <button class="btn btn-primary">Conferma Ordine</button>
            </div>
        </div>
    </div>
@endsection