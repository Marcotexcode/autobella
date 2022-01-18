@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Modelli</h2>
        <div class="row my-3">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right">
                    <a class="btn btn-success" href="{{ route('modelli.create') }}">Aggiungi Modello</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Marca</th>
                        <th scope="col">Modello</th>
                        <th scope="col">Anno Commercializzazione</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($modelli as $modello)
                        <tr>
                            <th>{{$modello->id}}</th>
                            <td>{{$modello->marca->nome}}</td>
                            <td>{{$modello->nome}}</td>
                            <td>{{$modello->anno_commercializzazione}}</td>
                            <td>
                                <form action="{{ route('modelli.destroy', $modello->id)}}" method="POST">
                                    <a class="btn btn-primary" href="{{ route('modelli.edit', $modello->id) }}">Modifica</a>
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