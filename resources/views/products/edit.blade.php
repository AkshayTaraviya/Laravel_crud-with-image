@extends('layouts.app')

@section('main')
    <div id="message"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <div class="card border border-secondary mt-3 p-3">
                    <h3 class="text-muted">Product Edit #{{ $product->title }}</h3>
                    <form method="POST" id="editProfile" action="/products/{{ $product->id }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control border border-secondary"
                                value="{{ old('title', $product->title) }}" />
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control border border-secondary" rows="4" name="description">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="image" class="form-control border border-secondary" />
                            @if ('storage/{{ $product->images }}')
                                <img src="{{ asset('storage/' . $product->image) }}" class="rounded-circle" width="30"
                                    height="30" value="{{ old('image', $product->image) }}" />
                            @else
                                <p>No image found</p>
                            @endif
                        </div>
                        <button type="submit"  class="btn btn-dark mt-3 submit">submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {

            $('#editProfile').submit(function(){
                
                $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                
                var form = $('#editProfile')[0];
                var data = new FormData(form);

                $.ajax({
                    type: "POST",
                    url: "/products/{{ $product->id }}",
                    data: data,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#submit').html('Submit');
                        $('#message').append('<div class="alert alert-success alert-block">'+response.message+'</div>'); 
                    }
                })

                return false;
            });
        })
    </script>
@endsection
