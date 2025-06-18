<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromoCodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
         /** @var \App\Models\User $user */
        $user = auth()->user();
        $userIsAdmin = $user->isAdmin();
        return auth()->check() && $userIsAdmin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'code' => 'required',
            'content' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ];
    }
}
