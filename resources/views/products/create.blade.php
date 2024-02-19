@extends('layouts.app')

@section('main')
    <div id="messages"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <div class="card border border-secondary mt-3 p-3">
                    <form method="POST" id="signupform" action="/products" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control border border-secondary" id="title"
                                value="{{ old('title') }}" />
                            <span class="text-danger error" id="title_error">
                                @error('title')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control border border-secondary" rows="4" id="description" name="description">{{ old('description') }}</textarea>
                            <span class="text-danger" id="description_error">
                                @error('description')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="image" id="image"
                                class="form-control border border-secondary" />
                            <span class="text-danger" id="image_error">
                                @error('image')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <button type="submit" id="submit" class="btn btn-dark mt-3">submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            var validator = $("#signupform").validate({
                rules: {
                    title: {
                        required: true,
                        maxlength: 5
                    },

                    description: {
                        required: true,
                        maxlength: 20
                    },

                    image: {
                        required: true,
                        accept: "jpeg,jpg,png,gif|max:10240"
                    }
                },
                messages: {
                    title: {
                        required: "Enter your title"
                    },
                    description: {
                        required: "Enter your description"
                    },
                    image: {
                        required: "Enter your image"
                    },
                },

                errorPlacement: function(error, element) {
                    $("#" + element.attr("name") + "_error").html(error);
                },

                submitHandler: function(form) {
                    
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: "POST",
                        url: "/products",
                        data: new FormData(form),
                        dataType: "json",
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            $('#submit').html('Submit');

                            $('#signupform')[0].reset();
                            $('#messages').append('<div class="alert alert-success alert-block">'+response.message+'</div>');
                        }
                    })

                    return false;
                }
            });
        });
    </script>
@endsection
