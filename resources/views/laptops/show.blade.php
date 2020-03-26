@extends('layouts.app')

@section('title', $title)

@php
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
    $hiddenAttributes = ['id', 'user_id', 'description', 'views', 'created_at', 'updated_at'];
@endphp

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item">Laptop</li>
          <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
        </ol>
    </nav>

    <h2 class="text-center">{{ $title }}</h2>
    <p class="text-center"><small class="text-muted">{{ $diff_from_now }}</small></p>

    <div class="d-flex justify-content-center">
        <img src="{{ asset('image/usedlaptops.png') }}" style="width: 25%;" class="img-fluid" alt="Responsive image">
    </div>

    <div class="table-responsive">
        <table class="table table-striped {{--table-bordered--}}">
            <tbody>
                @foreach( $laptop->toArray() as $key => $value )
                    @if( !in_array($key, $hiddenAttributes) )
                        <tr>
                            <th scope="row">{{ $key }}</th>
                            <td>{{ $value }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
