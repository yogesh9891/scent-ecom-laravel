<?php

namespace Modules\FrontendCMS\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AboutUsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mainTitle' => 'nullable',
            'subTitle' => 'nullable',
            'mainDescription' => 'nullable',
            'benifitTitle' => 'nullable',
            'benifitDescription' => 'nullable',
            'sellingTitle' => 'nullable',
            'sellingDescription' => 'nullable',
            'slug' => 'nullable|unique:about_us,slug,'.$this->id, 
            'price' => 'nullable'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
