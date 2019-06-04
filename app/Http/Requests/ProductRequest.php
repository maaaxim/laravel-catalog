<?php

namespace App\Http\Requests;

use App\Rules\NumericList;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
			'category' => [
				'required',
				new NumericList(),
				'exists:categories,id'
			],
			'amount' => 'numeric',
		];
    }
}
