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
                <div class="card-header">Brand</div>

                <div class="card-body py-0">
                    <div class="form-group">
                        <label for=""></label>
                        <select class="form-control" id="" size="5" multiple>
                            <!-- NOTE! must change -->
                            @foreach( $brands as $brand )
                                <option title="{{ $brand }}">{{ $brand }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">Year</div>

                <div class="card-body py-0">
                    <div class="form-group">
                        <label for=""></label>
                        <input type="text" class="form-control" name="" placeholder="">
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">CPU Brand</div>

                <div class="card-body py-0">
                    <div class="form-group">
                        <label for=""></label>
                        <select class="form-control" id="" size="3" multiple>
                            <option>Intel</option>
                            <option>AMD</option>
                            <option>Other</option>
                        </select>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-9 pr-0">
            <div class="row m-0">
                <div class="col mt-n4">
                    <div class="row">
                        <div class="form-group">
                            <label for=""></label>
                            <input type="text" class="form-control" name="" placeholder="Search">
                        </div>
                    </div>
                </div>

                <div class="col mt-n4">
                    <div class="row justify-content-end">
                        <div class="form-group">
                            <label for=""></label>
                            <select class="form-control" name="">
                                <option selected disabled>Sort By</option>
                                <option>ASC</option>
                                <option>DESC</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-md-2">
                @foreach( $laptops as $laptop )
                    @php
                        // Display only 15 characters of laptop's brand and model
                        $laptopBrandModel = Illuminate\Support\Str::limit($laptop->brand.' '.$laptop->model, 20);

                        $updated_at = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $laptop->updated_at);
                        $now = \Carbon\Carbon::now();

                        if( $updated_at->diffInMinutes($now) < 60 ) {
                            $diff_from_now = $updated_at->diffInMinutes($now) <= 1 ? 'Now' : $updated_at->diffInMinutes($now).' mins ago';
                        } else if(  $updated_at->diffInHours($now) < 24 ) {
                            $diff_from_now = $updated_at->diffInHours($now) <= 1 ? 'An hour ago' : $updated_at->diffInHours($now).' hours ago';
                        } else if(  $updated_at->diffInDays($now) < 7 ) {
                            $diff_from_now = $updated_at->diffInDays($now) <= 1 ? 'A day ago' : $updated_at->diffInDays($now).' days ago';
                        } else {
                            $diff_from_now = $updated_at->format('jS \\of F Y');
                        }
                    @endphp

                    <div class="col mb-4">
                        <div class="card text-center">
                            <img src="{{ asset('image/usedlaptops.png') }}" class="card-img-top" alt="...">

                            <div class="card-body">
                                <h5 class="card-title font-weight-bold">
                                    {{ $laptopBrandModel }} <br> {!! $laptop->year ? '('.$laptop->year.')' : '&nbsp;' !!}
                                </h5>

                                <p class="card-text">
                                    {{ $laptop->user->name }}
                                </p>

                                <p class="card-text lead">
                                    {{ $laptop->price }} &euro;
                                </p>

                                @php

                                @endphp

                                <p class="card-text"><small class="text-muted">{{ $diff_from_now }}</small></p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>


</div>
@endsection