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
     * Check if storage input is valid before converting into JSON.
     *
     * @return void
     */
    /*protected function prepareForValidation()
    {
        $this->merge([
            'storage1' => json_encode($this->storage1),
            'storage2' => json_encode($this->storage2),
        ]);
    }*/

    /*
    protected function getValidatorInstance(): Validator
    {
        $storage1 = $this->request->get('storage1');
        $this->merge(['storage1_field' => json_decode($json, true)]);

        $storage2 = $this->request->get('storage2');
        $this->merge(['json_field_as_array' => json_decode($json, true)]);

        return parent::getValidatorInstance();
    }
    */

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
            'storage2' => 'nullable|array',
            'os' => 'required|in:Windows,Linux,macOS,Chrome OS',
            'damage' => 'required|boolean',
            'price' => 'required|integer|min:1|max:5000',
            'description' => 'nullable|min:3'
        ];
    }
}
