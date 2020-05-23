@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('laptops.index') }}">Laptops</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
        </ol>
    </nav>

    <div class="row mx-0 mt-4 mb-4">
        <div class="col-md-8 pl-0 pr-0 pr-md-2 mb-2 mb-md-0">
            <div class="bg-white border p-3">
                <div class="row mb-4 justify-content-between">
                    <div class="col-xl-10 col-lg-9">
                        <h2 class="mb-0">{{ $title }}</h2>
                    </div>

                    <div class="col-xl-2 col-lg-3 d-flex justify-content-lg-end align-items-start mt-2 mt-lg-0">
                        <a class="btn btn-primary mr-1 fb-share-button fb-xfbml-parse-ignore" href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}&amp;src=sdkpreparse" target="_blank"><i class="fab fa-facebook-square"></i></a>
                        <a class="btn btn-primary ml-1" href="mailto:someone@example.com?subject=usedLaptops&body={{ url()->current() }}"><i class="fas fa-envelope"></i></a>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="p-2 p-lg-4">
                            <img src="{{ $photo ? asset($photo) : asset('image/usedlaptops.png') }}" class="img-fluid" alt="Responsive image">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-2 p-lg-4 basic-laptop-info">
                            <p class="mb-0"><strong class="text-uppercase">Views:</strong> {{ $laptop->views }}</p>
                            <p class="mb-0"><strong class="text-uppercase">Damage:</strong> {{ $laptop->damage ? 'Yes' : 'No' }}</p>
                            <p class="mb-0"><strong class="text-uppercase">Date:</strong> {{ $laptop->created_at->diffForHumans() }}</p>
                            <div class="text-center bg-primary text-white p-3 mt-3 font-weight-bold price">
                                {{ $laptop->price }}&euro;
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 pr-0 pl-0 pl-md-2 mt-2 mt-md-0">
            <div class="bg-white border text-center p-3">
                <h3>{{ $laptop->user->name }}</h3>

                <p class="mb-0"><strong>Active Laptops:</strong> {{ $laptop->user->laptops->count() }}</p>
                <p class="mb-0"><strong>Joined:</strong> {{ $laptop->user->created_at }}</p>

                <a class="btn btn-secondary mt-3" href="mailto:{{ $laptop->user->email }}?subject=usedLaptops&body={{ url()->current() }}">Contact Seller</a>
            </div>

            @if($laptop->user->id == Auth::id())
                <div class="bg-white border text-center p-3 mt-3">
                    <h4 class="mb-3">Actions</h4>

                    <a class="btn btn-primary" href="{{ url("/laptops/{$laptop->id}/edit") }}"><i class="fas fa-edit"></i> Edit</a>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal"><i class="fas fa-trash"></i> Delete</button>
                </div>
            @endif

            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
    </div>

    <div class="bg-white border p-3">
        @if($laptop->description)
            <p class="mb-2 font-1point2em"><strong>Description</strong></p>
            <p class="mb-4 font-1point2em">{{ $laptop->description }}</p>
        @endif

        <p class="mb-2 font-1point2em"><strong>Specifications</strong></p>

        <div class="table-responsive">
            <table class="table table-striped table-bordered mb-0">
                <tbody>
                    @foreach($laptop->getAttributes() as $key => $value)
                        @if(in_array($key, $hiddenLaptopAttributesFromTable))
                            @continue
                        @endif

                        @if(($key == 'storage1' || $key == 'storage2') && (count($storage1) > 0 || count($storage2) > 0))
                            <th scope="row">storage</th>
                            <td>
                                <table class="table table-striped table-bordered mb-0 text-uppercase">
                                    <tbody>
                                        @foreach($storage1 as $storageKey => $storageValue)
                                            <tr>
                                                <th>{{ $storageKey }}</th>
                                                <td>{{ $storageInfo['size'].$storageInfo['unit'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                            @continue
                        @endif

                        @if(!empty($value))
                            <tr>
                                <th scope="row">{{ $key }}</th>
                                <td>
                                    {{ $value }}
                                    @if($key == 'ramSize') GB @elseif($key == 'cpuFrequency') GHz @endif
                                </td>
                            </tr>
                        @endif
                    @endforeach

                    @if(!is_null($laptop->storage1) || !is_null($laptop->storage2))
                        <th scope="row" style="vertical-align: inherit;">storage</th>
                        <td>
                            <table class="table table-striped table-bordered mb-0 text-uppercase">
                                <tbody>
                                    @foreach($storage as $storageInfo)
                                        @if(!is_null($storageInfo))
                                            <tr>
                                                <th>{{ $storageInfo['type'] }}</th>
                                                <td>{{ $storageInfo['size'].$storageInfo['unit'] }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Are you sure?</h5>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body text-center">
            This action cannot be undone. This will permanently delete the laptop.
        </div>

        <div class="modal-footer">
            <form method="POST" action="/laptops/{{$laptop->id}}" class="w-100">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}

                <button type="submit" class="btn btn-danger w-100">Delete Now</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('javascript')
    <script type="text/javascript">
        window.addEventListener('load', function() {
            setTimeout(function() {
                $(".alert").alert('close');
            }, 3000);
        });
    </script>
@endsection
