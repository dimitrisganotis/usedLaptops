@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('messages.home')</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
        </ol>
    </nav>

    <div class="row mx-0 mt-4">

        <div class="col-md-8 offset-md-2 p-0">
            <form>
                <!-- Laptop -->
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="brand">@lang('messages.brand')*</label>
                        <select class="form-control" id="brand">
                            <option value="" disabled selected>@lang('messages.select_brand')</option>
                            @foreach( $brands as $brandCode => $brandName )
                                <option title="{{ $brandCode }}">{{ $brandName }}</option>
                            @endforeach
                            <option title="@lang('messages.other')">@lang('messages.other')</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="model">@lang('messages.model')*</label>
                        <input type="text" class="form-control" id="model" placeholder="@lang('messages.model')">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="year">@lang('messages.year')</label>
                        <input type="number" class="form-control" id="year" placeholder="@lang('messages.year')" min="1970" max="{{ date('Y') }}">
                    </div>
                </div>

                <hr>

                <!-- CPU -->
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="cpuBrand">@lang('messages.cpuBrand')*</label>
                        <select class="form-control" id="cpuBrand">
                            <option value="" disabled selected>@lang('messages.select_brand')</option>
                            <option value="Intel">Intel</option>
                            <option value="AMD">AMD</option>
                            <option value="Other">@lang('messages.other')</option>
                        </select>
                    </div>

                    <div class="form-group col-md-5">
                        <label for="model">@lang('messages.cpuModel')</label>
                        <input type="text" class="form-control" id="model" placeholder="@lang('messages.cpuModel')">
                    </div>

                    <div class="form-group col-md-2">
                        <label for="cpuCores">@lang('messages.cpuCores')</label>
                        <input type="number" class="form-control" id="cpuCores" placeholder="@lang('messages.cpuCores')" min="1" max="128">
                    </div>

                    <div class="form-group col-md-2">
                        <label for="cpuFrequency">@lang('messages.cpuFrequency')</label>
                        <input type="number" class="form-control" id="cpuFrequency" placeholder="@lang('messages.cpuFrequency_ghz')" min="1.0" max="7.0">
                    </div>
                </div>

                <hr>

                <!-- RAM & Storage -->
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="ramSize">@lang('messages.ramSize')*</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="ramSize" placeholder="@lang('messages.ramSize')">

                            <div class="input-group-append">
                                 <span class="input-group-text">GB</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="hdd">@lang('messages.storageHdd')</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="hdd" placeholder="@lang('messages.storageHdd')">

                            <div class="input-group-append">
                                 <span class="input-group-text">GB</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="ssd">@lang('messages.storageSsd')</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="ssd" placeholder="@lang('messages.storageSsd')">

                            <div class="input-group-append">
                                 <span class="input-group-text">GB</span>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <!-- Operating System -->
                <div class="form-row">
                    <div class="form-group col-12">
                        <label for="os">@lang('messages.os')</label>
                        <select class="form-control" id="os">
                            <option value="" selected>@lang('messages.select_os')</option>
                            <option title="Windows">Windows</option>
                            <option title="Linux">Linux</option>
                            <option title="macOS">macOS</option>
                            <option title="Chrome OS">Chrome OS</option>
                        </select>
                    </div>
                </div>

                <hr>

                <!-- Description -->
                <div class="form-row">
                    <div class="form-group col-12">
                        <label for="description">@lang('messages.description')</label>
                        <textarea class="form-control" id="description" rows="4" placeholder="@lang('messages.description')"></textarea>
                    </div>
                </div>

                <hr>

                <!-- Price & Damage -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="price">@lang('messages.price')*</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="price" placeholder="@lang('messages.price')">

                            <div class="input-group-append">
                                 <span class="input-group-text">&euro;</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="damage">@lang('messages.damage')*</label>
                        <select class="form-control" id="damage">
                            <option value="no" selected>No</option>
                            <option value="yes">Yes</option>
                        </select>
                    </div>
                </div>

                <hr>

                <div class="form-row mt-4">
                    <div class="form-group col-md-4 offset-md-4">
                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                    </div>
                </div>

            </form>
        </div>

    </div>


</div>
@endsection
