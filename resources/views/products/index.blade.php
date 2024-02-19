@extends('layouts.app')

@section('main')

    <div class="container">
        <div class="text-end">
            <a href="products/create" class="btn btn-dark mt-2">New Product</a>
        </div>
          
            <table class="table table-hover mt-3">
              <thead>
                <tr>
                  <th>Sno.</th> 
                  <th>Title</th>
                  <th>Image</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($products as $product)
                <tr>
                  <td>{{ $loop->index+1 }}</td>
                  <td><a href="products/{{ $product->id }}" class="text-dark" style="text-decoration:none">{{ $product->title }}</a></td>
                  <td>
                    <img src="storage/{{ $product->image }}" class="rounded-circle" width="30" height="30"/>
                  </td>
                  <td>
                    <a href="products/{{ $product->id }}/edit" class="btn btn-dark btn-sm">Edit</a>

                    <form method="POST" class="d-inline" action="products/{{ $product->id }}">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-danger btn-sm" onclick="return confirm('{{ __('Are you sure you want to delete?') }}')">
                        {{ __('Delete') }}
                    </button>
                    </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            {{ $products->links() }}
    </div>
@endsection
