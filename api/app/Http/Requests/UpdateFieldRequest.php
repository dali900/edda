<?php

namespace App\Http\Requests;

use App\Models\Field;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFieldRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'form_id' => 'required',
            'title' => 'required|string|unique:fields,form_id,title,'.$this->route('id'),
            'type' => 'required|in:'.implode(",", Field::TYPES),
            'value' => 'required'
        ];;
    }
}
