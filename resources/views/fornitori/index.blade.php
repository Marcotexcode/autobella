@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row my-3">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right">
                    <a class="btn btn-success" href="{{ route('fornitori.create') }}">Aggiungi Fornitore</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Rag.Sociale</th>
                        <th scope="col">Citta</th>
                        <th scope="col">P.iva</th>
                        <th scope="col">Azioni</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($fornitori as $fornitore)
                        <tr>
                            <th>{{$fornitore->id}}</th>
                            <td>{{$fornitore->ragione_sociale}}</td>
                            <td>{{$fornitore->comune}}</td>
                            <td>{{$fornitore->p_iva}}</td>
                            <td>
                                <form action="{{ route('fornitori.destroy', $fornitore->id)}}" method="POST">
                                    <a class="btn btn-info" href="{{ route('fornitori.show', $fornitore->id) }}">Mostra</a>
                                    <a class="btn btn-primary" href="{{ route('fornitori.edit', $fornitore->id) }}">Modifica</a>
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