@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Ricambi</h2>
        <div class="row my-3">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right">
                    <a class="btn btn-success" href="{{ route('ricambi.create') }}">Aggiungi Ricambio</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Codice</th>
                        <th scope="col">Categoria</th>
                        <th scope="col">Fornitore</th>
                        <th scope="col">Prezzo €</th>
                        <th scope="col">Azioni</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($ricambi as $ricambio)
                            <tr>
                                <th>{{$ricambio->id}}</th>
                                <td>{{$ricambio->codice}}</td>
                                <td>{{$ricambio->categoria->descrizione}}</td>
                                <td>{{$ricambio->fornitore->ragione_sociale}}</td>
                                <td>{{$ricambio->prezzo}}</td>
                                <td>
                                    <form action="{{ route('ricambi.destroy', $ricambio->id)}}" method="POST">
                                        <a class="btn btn-primary" href="{{ route('ricambi.edit', $ricambio->id) }}">Modifica</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"  class="btn btn-danger">Elimina</button>
                                    </form>    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
@endsection