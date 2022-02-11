@extends('layouts.app')

@section('content')
    <div class="mt-5 container">
        <div class="mt-5 row">
            <div class="mt-5 col text-center">
                <h2>L'ordine è stato effetuato</h2>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-4">
            <a href="{{ url('/') }}" class="btn btn-primary">ritorna alla home</a>
            </div>
        </div>
    </div>
@endsection