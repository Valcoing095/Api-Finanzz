<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string',
        ];
    }

    public function attributes(): array
    {
        return
        [
            'first_name'=>'Nombre',
            'last_name'=>'Apellido',
            'email'=>'Correo electrónico',
            'phone_number'=>'Número de celular',
            'address'=>'Dirección',
        ];
    }
}
