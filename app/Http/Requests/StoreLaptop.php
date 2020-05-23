<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;
use \Illuminate\Contracts\Validation\Validator;

class StoreLaptop extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $storage1 = $this->storage1['size'];
        $storage2 = $this->storage2['size'];

        if(is_null($storage1)) {
            $this->merge([
                'storage1' => null,
            ]);
        }

        if(is_null($storage2)) {
            $this->merge([
                'storage2' => null,
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //dd(request()->all());
        return [
            'user_id' => 'required|in:'.Auth::id(),
            'brand' => 'required|in:'.collect(json_decode(Storage::get('brands.json')))->implode(','),
            'model' => 'required|max:120',
            'year' => 'nullable|digits:4|integer|min:1970|max:'.\Carbon\Carbon::tomorrow()->year,

            'cpuBrand' => 'required|in:Intel,AMD,Other',
            'cpuModel' => 'nullable|max:30',
            'cpuCores' => 'nullable|integer|min:1|max:32',
            'cpuFrequency' => 'nullable|numeric|min:0.5|max:5.0',

            'ramSize' => 'required|integer|min:1|max:32',

            'storage1' => 'nullable|array',
            'storage1.type' => 'nullable|in:HDD,SSD',
            'storage1.size' => 'nullable|integer',
            'storage1.unit' => 'nullable|in:GB,TB',

            'storage2' => 'nullable|array',
            'storage2.type' => 'nullable|in:HDD,SSD',
            'storage2.size' => 'nullable|integer',
            'storage2.unit' => 'nullable|in:GB,TB',

            'os' => 'required|in:Windows,Linux,macOS,Chrome OS',
            'damage' => 'required|boolean',
            'price' => 'required|numeric|min:1|max:5000',
            'description' => 'nullable|min:3',

            'photo' => 'nullable|mimes:jpeg,bmp,png|max:2048'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'storage1.json' => 'A valid storage is required.',
            'storage2.json'  => 'A valid storage is required.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'storage1.type' => 'storage 1 type',
            'storage1.size' => 'storage 1 size',
            'storage1.unit' => 'storage 1 unit',

            'storage2.type' => 'storage 2 type',
            'storage2.size' => 'storage 2 size',
            'storage2.unit' => 'storage 2 unit',
        ];
    }
}
