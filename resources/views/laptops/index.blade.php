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
                <div class="card-header mb-3">Brand</div>

                <div class="card-body py-0">
                    <form action="/laptops">
                        @foreach(request()->only(['cpuBrand', 'os', 'search', 'sort']) as $key => $value)
                            @if(empty($value))
                                @continue
                            @endif

                            @if(is_array($value))
                                @foreach($value as $arrayValue)
                                    <input type="hidden" name="{{ $key }}[]" value="{{ $arrayValue }}">
                                @endforeach
                                @continue
                            @endif

                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach

                        <div class="form-group">
                            <select class="form-control filter" name="brand[]" id="" size="5" multiple>
                                @foreach( $brands as $brand )
                                    <option
                                        value="{{ $brand }}"
                                        {{ !is_null(request()->brand) && in_array($brand, request()->brand) ? 'selected' : '' }}
                                    >{{ $brand }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header mb-3">CPU Brand</div>

                <div class="card-body py-0">
                    <form action="/laptops">
                        @foreach(request()->only(['brand', 'os', 'search', 'sort']) as $key => $value)
                            @if(empty($value))
                                @continue
                            @endif

                            @if(is_array($value))
                                @foreach($value as $arrayValue)
                                    <input type="hidden" name="{{ $key }}[]" value="{{ $arrayValue }}">
                                @endforeach
                                @continue
                            @endif

                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach

                        <div class="form-group">
                            <select class="form-control filter" name="cpuBrand[]" id="" size="3" multiple>
                                <option
                                    value="Intel"
                                    {{ !is_null(request()->cpuBrand) && in_array('Intel', request()->cpuBrand) ? 'selected' : '' }}
                                >Intel</option>

                                <option
                                    value="AMD"
                                    {{ !is_null(request()->cpuBrand) && in_array('AMD', request()->cpuBrand) ? 'selected' : '' }}
                                >AMD</option>

                                <option
                                    value="Other"
                                    {{ !is_null(request()->cpuBrand) && in_array('Other', request()->cpuBrand) ? 'selected' : '' }}
                                >Other</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header mb-3">Operating System</div>

                <div class="card-body py-0">
                    <form action="/laptops">
                        @foreach(request()->only(['brand', 'cpuBrand', 'search', 'sort']) as $key => $value)
                            @if(empty($value))
                                @continue
                            @endif

                            @if(is_array($value))
                                @foreach($value as $arrayValue)
                                    <input type="hidden" name="{{ $key }}[]" value="{{ $arrayValue }}">
                                @endforeach
                                @continue
                            @endif

                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach

                        <div class="form-group">
                            <select class="form-control filter" name="os[]" id="" size="4" multiple>
                                <option
                                    value="Windows"
                                    {{ !is_null(request()->os) && in_array('Windows', request()->os) ? 'selected' : '' }}
                                >Windows</option>

                                <option
                                    value="Linux"
                                    {{ !is_null(request()->os) && in_array('Linux', request()->os) ? 'selected' : '' }}
                                >Linux</option>

                                <option
                                    value="macOS"
                                    {{ !is_null(request()->os) && in_array('macOS', request()->os) ? 'selected' : '' }}
                                >macOS</option>

                                <option
                                    value="Chrome OS"
                                    {{ !is_null(request()->os) && in_array('Chrome OS', request()->os) ? 'selected' : '' }}
                                >Chrome OS</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="laptops" class="col-md-9 pr-0">
            <div class="d-flex justify-content-between mt-n4">
                <form action="/laptops" class="mt-4">
                    @foreach(request()->only(['brand', 'cpuBrand', 'os', 'sort']) as $key => $value)
                        @if(empty($value))
                            @continue
                        @endif

                        @if(is_array($value))
                            @foreach($value as $arrayValue)
                                <input type="hidden" name="{{ $key }}[]" value="{{ $arrayValue }}">
                            @endforeach
                            @continue
                        @endif

                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach

                    <div class="form-group">
                        <input type="text" class="form-control" name="search" placeholder="Search" value="{{ request()->search }}">
                    </div>
                </form>

                <div class="mt-4">
                    {{ $laptops->appends(request()->except('page'))->links() }}
                </div>

                <form action="/laptops" class="mt-4">
                    @foreach(request()->only(['brand', 'cpuBrand', 'os', 'search']) as $key => $value)
                        @if(empty($value))
                            @continue
                        @endif

                        @if(is_array($value))
                            @foreach($value as $arrayValue)
                                <input type="hidden" name="{{ $key }}[]" value="{{ $arrayValue }}">
                            @endforeach
                            @continue
                        @endif

                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach

                    <div class="form-group">
                        <select class="form-control filter" name="sort">
                            <option disabled>Order By</option>

                            <option
                                value="latest"
                                {{ request()->sort == 'latest' ? 'selected' : '' }}
                            >Latest</option>

                            <option
                                value="oldest"
                                {{ request()->sort == 'oldest' ? 'selected' : '' }}
                            >Oldest</option>
                        </select>
                    </div>
                </form>
            </div>

            @if(session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row row-cols-1 row-cols-md-2">
                @foreach($laptops as $laptop)
                    @php
                        // Display only 15 characters of laptop's brand and model
                        $laptopBrandModel = Illuminate\Support\Str::limit($laptop->brand.' '.$laptop->model, 20);

                        $laptopUrl = url("/laptops/{$laptop->id}");
                    @endphp

                    <div class="col mb-4">
                        <div class="card text-center">
                            <a href="{{ $laptopUrl }}">
                                <img src="{{ asset('image/usedlaptops.png') }}" class="card-img-top" alt="Laptop image">
                            </a>

                            <div class="card-body">
                                <h5 class="card-title font-weight-bold">
                                    <a href="{{ $laptopUrl }}">{{ $laptopBrandModel }} <br> {!! $laptop->year ? '('.$laptop->year.')' : '&nbsp;' !!}</a>
                                </h5>

                                <p class="card-text">
                                    {{ $laptop->user->name }}
                                </p>

                                <p class="card-text lead">
                                    {{ $laptop->price }} &euro;
                                </p>

                                <p class="card-text"><small class="text-muted">{{ $laptop->created_at->diffForHumans() }}</small></p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center">
                {{ $laptops->appends(request()->except('page'))->links() }}
            </div>

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

            $('select.filter').change(function() {
                this.form.submit();
            });
        });
    </script>
@endsection
