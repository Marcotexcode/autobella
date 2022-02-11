@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h2>Elenco ordini</h2>
            </div>
            <div class="row">
                <div class="col">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Data</th>
                            <th scope="col">Indirizzo</th>
                            <th scope="col">Telefono</th>
                            <th scope="col">Azioni</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($elencoOrdini as $elencoOrdine)
                                <tr>
                                    <td>{{ $elencoOrdine->utente->name }}</td>
                                    <td>{{ $elencoOrdine->created_at }}</td>
                                    <td>{{ $elencoOrdine->indirizzo }}</td>
                                    <td>{{ $elencoOrdine->telefono }}</td>
                                    <td>
                                        {{-- <button class="btn btn-primary">Dettaglio Ordine</button> --}}
                                        <form action="{{route('ordini.update', $elencoOrdine->id)}}" method="POST">
                                            @method('PUT') 
                                            @csrf
                                            <button class="btn btn-{{$elencoOrdine->tipo == 0 ?  'danger' : 'success'}}">Ordine Pronto</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection