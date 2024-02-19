@extends('layouts.app')

@section('main')

<div class="container">
    <div class="row justify-cintent-center">
        <div class="col-sm-8 mt-4">
            <div class="card p-4">
                <p>Name : <b>{{ $product->title }}</b></p>
                <p>Description : <b>{{ $product->description }}</b></p>
                <img src="/storage/{{ $product->image }}" class="rounded" width="100%"/>
            </div>
        </div>
    </div>
</div>

@endsection