@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row my-3">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right">
                    <a class="btn btn-success" href="{{ route('categorie.create') }}">Aggiungi Fornitore</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Descrizione</th>
                        <th scope="col">Azioni</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($categorie as $categoria)
                        <tr>
                            <th>{{$categoria->id}}</th>
                            <td>{{$categoria->descrizione}}</td>
                            <td>
                                <form action="{{ route('categorie.destroy', $categoria->id)}}" method="POST">
                                    <a class="btn btn-primary" href="{{ route('categorie.edit', $categoria->id) }}">Modifica</a>
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