@extends('layouts.app')
  
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left">
                        <h2>Modifica Ricambio</h2>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('ricambi.index') }}"> Back</a>
                    </div>
                </div>
            </div>       
            <form action="{{ route('ricambi.update', $ricambi->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')  
                <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Codice:</strong>
                                <input type="text" name="codice" value="{{$ricambi->codice}}" class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Descrizione:</strong>
                                <textarea class="form-control" style="height:150px" name="descrizione" >{{$ricambi->descrizione}}</textarea>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Prezzo:</strong>
                                <input type="text" name="prezzo" value="{{$ricambi->prezzo}}" class="form-control">
                            </div>
                        </div>
                        {{-- immagine --}}
                        @if ($ricambi->cover)
                            <div class="col-3 my-5">
                                <img class="card-img-top" style="height: 300px;" src="{{asset('storage/' . $ricambi->cover)}}" alt="Card image cap">
                            </div>
                        @endif
                        
                        <div class="card-text">
                            <label for="img" class="form-lable my-3"><strong>Inserisci immagine articolo</strong></label>
                            <input type="file" value="{{$ricambi->cover}}" name="img">
                        </div>
                        {{-- immagine --}}
                        
                        <div class="card-text">
                            <h4>Categoria</h4>
                            <select name='categoria_id' class="bg-gray-600 appearance-none">
                                @foreach ($categorie as $categoria)
                                    <option value="{{$categoria->id}}" {{$categoria->id == $ricambi->categoria_id ? 'selected' : ''}} value="{{$ricambi->categoria_id}}">{{$categoria->descrizione}}</option>
                                @endforeach 
                            </select>
                        </div>
                        <div class="card-text">
                            <h4>Fornitori</h4>
                            <select name='fornitore_id' class="bg-gray-600 appearance-none">
                                @foreach ($fornitori as $fornitore)
                                    <option value="{{$fornitore->id}}" {{$fornitore->id == $ricambi->fornitore_id ? 'selected' : ''}} >{{$fornitore->ragione_sociale}}</option>
                                @endforeach 
                            </select>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <h4>Modelli compatibili</h4>
                            <div class="card-text">
                                {{-- Usare in array --}}
                                @foreach ($modelli as $modello)  
                                    <div class="form-check">
                                        <input {{ in_array( $modello->id, $modelliScelti) ? 'checked' : ''}} class="form-check-input" name="modello_id[]" value="{{$modello->id}}" type="checkbox" id="extraIndex">
                                        <label for="extraIndex" class="form-check-label">
                                             {{$modello->nome}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>   
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>              
            </form>
        </div>
    </div>
</div>
@endsection