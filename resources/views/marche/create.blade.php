@extends('layouts.app')
  
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left">
                        <h2>Aggiungi Ricambio</h2>
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
                        <a class="btn btn-primary" href="{{ route('marche.index') }}"> Back</a>
                    </div>
                </div>
            </div>       
            <form action="{{ route('marche.store') }}" method="POST">
                @csrf
                <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Nome:</strong>
                                <input type="text" name="nome" class="form-control">
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