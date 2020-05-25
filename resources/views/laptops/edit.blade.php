@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('messages.home')</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{ $title }} [ {{ $laptop->brand . ' ' . $laptop->model . ($laptop->year ? ' (' . $laptop->year . ') ' : '') }} ]</li>
        </ol>
    </nav>

    <div class="row mx-0 mt-4">

        <div class="col-md-8 offset-md-2 p-0">
            <form method="POST" action="/laptops/{{$laptop->id}}" enctype="multipart/form-data">
                @csrf
                {{ method_field('PATCH') }}

                <input
                    type="hidden"
                    name="user_id"
                    value="{{ $laptop->user->id }}"
                >

                <!-- Laptop -->
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="brand">@lang('messages.brand')*</label>
                        <select
                            class="form-control @error('brand') is-invalid @enderror"
                            id="brand"
                            name="brand"
                            required
                        >
                            <option
                                value=""
                                disabled
                            >@lang('messages.select_brand')</option>

                            @foreach( $brands as $brand )
                                <option
                                    value="{{ $brand }}"
                                    title="{{ $brand }}"
                                    {{ $laptop->brand == $brand ? 'selected' : '' }}
                                >{{ $brand }}</option>
                            @endforeach
                        </select>

                        @error('brand')
                            <div class="invalid-feedback">
                                {{ $errors->first('brand') }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="model">@lang('messages.model')*</label>
                        <input
                            type="text"
                            class="form-control @error('model') is-invalid @enderror"
                            id="model"
                            name="model"
                            placeholder="@lang('messages.model')"
                            value="{{ $laptop->model }}"
                            required
                        >

                        @error('model')
                            <div class="invalid-feedback">
                                {{ $errors->first('model') }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label for="year">@lang('messages.year')</label>
                        <input
                            type="number"
                            class="form-control @error('year') is-invalid @enderror"
                            id="year"
                            name="year"
                            value="{{ $laptop->year }}"
                            placeholder="@lang('messages.year')"
                            min="1970"
                            max="{{ \Carbon\Carbon::tomorrow()->year }}"
                        >

                        @error('year')
                            <div class="invalid-feedback">
                                {{ $errors->first('year') }}
                            </div>
                        @enderror
                    </div>
                </div>

                <hr>

                <!-- CPU -->
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="cpuBrand">@lang('messages.cpuBrand')*</label>
                        <select
                            class="form-control @error('cpuBrand') is-invalid @enderror"
                            id="cpuBrand"
                            name="cpuBrand"
                            required
                        >
                            <option
                                value=""
                                disabled
                            >@lang('messages.select_brand')</option>

                            <option
                                value="Intel"
                                {{ $laptop->cpuBrand == 'Intel' ? 'selected' : '' }}
                            >Intel</option>

                            <option
                                value="AMD"
                                {{ $laptop->cpuBrand == 'AMD' ? 'selected' : '' }}
                            >AMD</option>

                            <option
                                value="Other"
                                {{ $laptop->cpuBrand == 'Other' ? 'selected' : '' }}
                            >@lang('messages.other')</option>
                        </select>

                        @error('cpuBrand')
                            <div class="invalid-feedback">
                                {{ $errors->first('cpuBrand') }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group col-md-5">
                        <label for="cpuModel">@lang('messages.cpuModel')</label>
                        <input
                            type="text"
                            class="form-control @error('cpuModel') is-invalid @enderror"
                            id="cpuModel"
                            name="cpuModel"
                            value="{{ $laptop->cpuModel }}"
                            placeholder="@lang('messages.cpuModel')"
                        >

                        @error('cpuModel')
                            <div class="invalid-feedback">
                                {{ $errors->first('cpuModel') }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group col-md-2">
                        <label for="cpuCores">@lang('messages.cpuCores')</label>
                        <input
                            type="number"
                            class="form-control @error('cpuCores') is-invalid @enderror"
                            id="cpuCores"
                            name="cpuCores"
                            value="{{ $laptop->cpuCores }}"
                            placeholder="@lang('messages.cpuCores')"
                            min="1"
                            max="32"
                        >

                        @error('cpuCores')
                            <div class="invalid-feedback">
                                {{ $errors->first('cpuCores') }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group col-md-2">
                        <label for="cpuFrequency">@lang('messages.cpuFrequency')</label>
                        <input
                            type="number"
                            class="form-control @error('cpuFrequency') is-invalid @enderror"
                            id="cpuFrequency"
                            name="cpuFrequency"
                            value="{{ $laptop->cpuFrequency }}"
                            placeholder="@lang('messages.cpuFrequency_ghz')"
                            min="0.0"
                            max="5.0"
                            step="0.1"
                        >

                        @error('cpuFrequency')
                            <div class="invalid-feedback">
                                {{ $errors->first('cpuFrequency') }}
                            </div>
                        @enderror
                    </div>
                </div>

                <hr>

                <!-- RAM & Storage -->
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="ramSize">@lang('messages.ramSize')*</label>
                        <div class="input-group">
                            <input
                                type="number"
                                class="form-control @error('ramSize') is-invalid @enderror"
                                id="ramSize"
                                name="ramSize"
                                value="{{ $laptop->ramSize }}"
                                placeholder="Size"
                                min="1"
                                max="32"
                                required
                            >
                            <div class="input-group-append">
                                 <span class="input-group-text">GB</span>
                            </div>
                        </div>

                        @error('ramSize')
                            <div class="invalid-feedback">
                                {{ $errors->first('ramSize') }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group col-md-5">
                        <label for="storage1">Storage 1</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select
                                    class="form-control @error('storage1.type') is-invalid @enderror"
                                    name="storage1[type]"
                                >
                                    <option
                                        value="SSD"
                                        {{ $laptop->storage1['type'] == 'SSD' ? 'selected' : '' }}
                                    >SSD</option>

                                    <option
                                        value="HDD"
                                        {{ $laptop->storage1['type'] == 'HDD' ? 'selected' : '' }}
                                    >HDD</option>
                                </select>
                            </div>

                            <input
                                type="number"
                                class="form-control @error('storage1') is-invalid @enderror @error('storage1.size') is-invalid @enderror"
                                id="storage1"
                                name="storage1[size]"
                                value="{{ $laptop->storage1['size'] }}"
                                placeholder="Size"
                            >

                            <div class="input-group-append">
                                <select
                                    class="form-control @error('storage1.unit') is-invalid @enderror"
                                    name="storage1[unit]"
                                >
                                    <option
                                        value="GB"
                                        {{ $laptop->storage1['unit'] == 'GB' ? 'selected' : '' }}
                                    >GB</option>

                                    <option
                                        value="TB"
                                        {{ $laptop->storage1['unit'] == 'TB' ? 'selected' : '' }}
                                    >TB</option>
                                </select>
                            </div>

                            @error('storage1')
                                <div class="invalid-feedback">
                                    {{ $errors->first('storage1') }}
                                </div>
                            @enderror

                            @error('storage1.*')
                                <div class="invalid-feedback">
                                    {{ $errors->first('storage1.type') }}
                                    {{ $errors->first('storage1.size') }}
                                    {{ $errors->first('storage1.unit') }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group col-md-5">
                        <label for="storage2">Storage 2</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select
                                    class="form-control @error('storage2.type') is-invalid @enderror"
                                    name="storage2[type]"
                                >
                                    <option
                                        value="HDD"
                                        {{ $laptop->storage2['type'] == 'HDD' ? 'selected' : '' }}
                                    >HDD</option>

                                    <option
                                        value="SSD"
                                        {{ $laptop->storage2['type'] == 'SSD' ? 'selected' : '' }}
                                    >SSD</option>
                                </select>
                            </div>

                            <input
                                type="number"
                                class="form-control @error('storage2') is-invalid @enderror @error('storage2.size') is-invalid @enderror"
                                id="storage2"
                                name="storage2[size]"
                                value="{{ $laptop->storage2['size'] }}"
                                placeholder="Size"
                            >

                            <div class="input-group-append">
                                <select
                                    class="form-control @error('storage2.unit') is-invalid @enderror"
                                    name="storage2[unit]"
                                >
                                    <option
                                        value="GB"
                                        {{ $laptop->storage2['unit'] == 'GB' ? 'selected' : '' }}
                                    >GB</option>

                                    <option
                                        value="TB"
                                        {{ $laptop->storage2['unit'] == 'TB' ? 'selected' : '' }}
                                    >TB</option>
                                </select>
                            </div>

                            @error('storage2')
                                <div class="invalid-feedback">
                                    {{ $errors->first('storage2') }}
                                </div>
                            @enderror

                            @error('storage2.*')
                                <div class="invalid-feedback">
                                    {{ $errors->first('storage2.type') }}
                                    {{ $errors->first('storage2.size') }}
                                    {{ $errors->first('storage2.unit') }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr>

                <!-- Operating System -->
                <div class="form-row">
                    <div class="form-group col-12">
                        <label for="os">@lang('messages.os')*</label>
                        <select
                            class="form-control @error('os') is-invalid @enderror"
                            id="os"
                            name="os"
                            required
                        >
                            <option
                                value=""
                            >@lang('messages.select_os')</option>

                            <option
                                value="Windows"
                                {{ $laptop->os == 'Windows' ? 'selected' : '' }}
                            >Windows</option>

                            <option
                                value="Linux"
                                {{ $laptop->os == 'Linux' ? 'selected' : '' }}
                            >Linux</option>

                            <option
                                value="macOS"
                                {{ $laptop->os == 'macOS' ? 'selected' : '' }}
                            >macOS</option>

                            <option
                                value="Chrome OS"
                                {{ $laptop->os == 'Chrome OS' ? 'selected' : '' }}
                            >Chrome OS</option>
                        </select>

                        @error('os')
                            <div class="invalid-feedback">
                                {{ $errors->first('os') }}
                            </div>
                        @enderror
                    </div>
                </div>

                <hr>

                <!-- Description -->
                <div class="form-row">
                    <div class="form-group col-12">
                        <label for="description">@lang('messages.description')</label>
                        <textarea
                            class="form-control @error('description') is-invalid @enderror"
                            id="description"
                            name="description"
                            rows="4"
                            placeholder="@lang('messages.description')"
                        >{{ $laptop->description }}</textarea>

                        @error('description')
                            <div class="invalid-feedback">
                                {{ $errors->first('description') }}
                            </div>
                        @enderror
                    </div>
                </div>

                <hr>

                <!-- Price & Damage -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="price">@lang('messages.price')*</label>
                        <div class="input-group">
                            <input
                                type="number"
                                class="form-control @error('price') is-invalid @enderror"
                                id="price"
                                name="price"
                                value="{{ $laptop->price }}"
                                placeholder="@lang('messages.price')"
                                required
                            >
                            <div class="input-group-append">
                                 <span class="input-group-text">&euro;</span>
                            </div>

                            @error('price')
                                <div class="invalid-feedback">
                                    {{ $errors->first('price') }}
                                </div>
                            @enderror
                        </div>

                    </div>

                    <div class="form-group col-md-6">
                        <label for="damage">@lang('messages.damage')*</label>
                        <select
                            class="form-control @error('damage') is-invalid @enderror"
                            id="damage"
                            name="damage"
                        >
                            <option
                                value="0"
                                {{ !$laptop->damage ? 'selected' : '' }}
                            >No</option>

                            <option
                                value="1"
                                {{ $laptop->damage ? 'selected' : '' }}
                            >Yes</option>
                        </select>

                        @error('damage')
                            <div class="invalid-feedback">
                                {{ $errors->first('damage') }}
                            </div>
                        @enderror
                    </div>
                </div>

                <hr>

                <div class="form-group">
                    <label for="photo">Upload New Photo</label>
                    <div class="custom-file @error('photo') is-invalid @enderror">
                        <input type="file" name="photo" class="custom-file-input" id="photo">
                        <label class="custom-file-label" for="photo">Choose file...</label>
                    </div>

                    @error('photo')
                        <div class="invalid-feedback">
                            {{ $errors->first('photo') }}
                        </div>
                    @enderror
                </div>

                <hr>

                <div class="form-row mt-4">
                    <div class="form-group col-md-4 offset-md-4 mb-0">
                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                    </div>
                </div>

            </form>
        </div>

    </div>


</div>
@endsection
