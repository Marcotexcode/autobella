@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Marche</h2>
        <div class="row my-3">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right">
                    <a class="btn btn-success" href="{{ route('marche.create') }}">Aggiungi Marca</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Nome</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($marche as $marca)
                        <tr>
                            <th>{{$marca->id}}</th>
                            <td>{{$marca->nome}}</td>
                            <td>
                                <form action="{{ route('marche.destroy', $marca->id)}}" method="POST">
                                    <a class="btn btn-primary" href="{{ route('marche.edit', $marca->id) }}">Modifica</a>
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