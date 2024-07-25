<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password as PasswordRules;


class RegistrarseRequest extends FormRequest
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
            "nombre" => ["required", "string"],
            "apellido" => ["required", "string"],
            "numero_documento" => ["required", "string", "regex:/^\d{8}(?:\d{2})?$/"],
            "usuario" => ["required", "string"],
            "fecha_nacimiento" => ["required", "string"],
            "direccion" => ["required", "string"],
            "email" => ["required", "email",],
            "imagen" => 'required|image|mimes:jpeg,png,jpg|max:2048',
            "password" => [
                "required",
                "confirmed",
                PasswordRules::min(8)->letters()->symbols()->numbers()
            ],
            "id_tipo_documento" => ["required", "numeric"],
            "id_rol" => ["required", "numeric"],
        ];
    }

    public function messages():array
    {
        return [
            "nombre.required" => "El campo nombre es obligatorio.",
            "apellido.required" => "El campo apellido es obligatorio.",
            "numero_documento.required" => "El campo número de documento es obligatorio.",
            "numero_documento.regex" => "El campo número de documento debe tener 8 o 10 dígitos.",
            "usuario.required" => "El campo usuario es obligatorio.",
            "fecha_nacimiento.required" => "El campo fecha de nacimiento es obligatorio.",
            "direccion.required" => "El campo dirección es obligatorio.",
            "email.required" => "El campo email es obligatorio.",
            "email.email" => "El email proporcionado no es válido.",
            "imagen.required" => "La imagen es obligatoria.",
            "imagen.image" => "El archivo debe ser una imagen.",
            "imagen.mimes" => "La imagen debe ser de tipo: jpeg, png, jpg, o gif.",
            "imagen.max" => "La imagen no puede ser mayor a 2MB.",
            "password.required" => "El campo contraseña es obligatorio.",
            "password.confirmed" => "La confirmación de la contraseña no coincide.",
            "password.min" => "La contraseña debe tener al menos :min caracteres y contener letras, números y símbolos.",
            "id_tipo_documento.numeric" => "El campo ID tipo de documento debe ser numérico.",
            "id_rol.required" => "El campo tipo de rol es obligatorio.",
            "id_rol.numeric" => "El campo ID de rol debe ser numérico."
        ];
    }
}
