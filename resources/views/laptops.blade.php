@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
        </ol>
    </nav>

    <div class="row mx-0 mt-4">

        <div class="col-md-3 border-right pl-0">

            <div class="card mb-4">
                <div class="card-header">
                    Brand
                </div>
                <div class="card-body py-0">
                    <div class="form-group">
                        <label for=""></label>
                        <input type="text" class="form-control" name="" placeholder="">
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    Year
                </div>
                <div class="card-body py-0">
                    <div class="form-group">
                        <label for=""></label>
                        <input type="text" class="form-control" name="" placeholder="">
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    CPU Brand
                </div>
                <div class="card-body py-0">
                    <div class="form-group">
                        <label for=""></label>
                        <select class="selectpicker" id="" multiple>
                            <option>Intel</option>
                            <option>AMD</option>
                            <option>Other</option>
                        </select>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-9 pr-0">
            <div class="row row-cols-1 row-cols-md-3">
                @foreach( $laptops as $laptop )
                    @php
                        // Display only 15 characters of laptop's brand and model
                        $laptopBrandModel = Illuminate\Support\Str::limit($laptop->brand.' '.$laptop->model, 14)
                    @endphp

                    <div class="col mb-4">
                        <div class="card text-center">
                            <img src="{{ asset('image/usedlaptops.png') }}" class="card-img-top" alt="...">

                            <div class="card-body">
                                <h5 class="card-title font-weight-bold">
                                    {{ $laptopBrandModel.' ('.$laptop->year.')' }}
                                </h5>

                                <p class="card-text">
                                    {{ $laptop->cpuBrand . ' ' . $laptop->cpuModel }}
                                </p>

                                <p class="card-text lead">
                                    {{ $laptop->price }} &euro;
                                </p>

                                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>


</div>
@endsection
