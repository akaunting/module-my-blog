<?php

namespace Modules\MyBlog\Http\Requests;

use App\Abstracts\Http\FormRequest;

class Comment extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description' => 'required',
        ];
    }
}
