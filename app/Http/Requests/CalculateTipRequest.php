<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class CalculateTipRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'bill' => 'required|numeric|min:0.01',
            'tip' => 'required|numeric|min:1|max:100',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
