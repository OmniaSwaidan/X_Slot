<?php

namespace Omniax\X_slot\Requests\Xslot;

use Illuminate\Foundation\Http\FormRequest;
use Omniax\X_slot\Requests\ApiRequest;

class UpdateRequest extends ApiRequest
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
            'slot_time' => 'sometimes|required|string',
            'capacity' => 'sometimes|required|integer',
            'date' => 'sometimes|required|date'
        ];
    }
}
