<?php

namespace Omniax\X_slot\Requests\Xslot;

use Omniax\X_slot\Requests\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'slot_time' => 'required|string',
            'capacity' => 'required|integer',
            'date' => 'required|date'
        ];
    }
}
