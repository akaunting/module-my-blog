<?php

namespace Modules\MyBlog\Http\Requests;

use App\Abstracts\Http\FormRequest;

class Post extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'enabled' => 'integer|boolean',
            'created_by' => 'integer',
        ];
    }
}
