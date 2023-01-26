<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class ComplaintRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            'category_complaint_id' => 'required|integer|exists:category_complaints,id',
            'title'                 => 'required|string|max:100',
            'description'           => 'required|string',
            'status'                => 'in:Waiting,Approved,Decline,Finish',
            'latitude'              => 'required|string',
            'longitude'             => 'required|string',
        ];
    }
}