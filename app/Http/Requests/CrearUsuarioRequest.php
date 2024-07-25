<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password as PasswordRules;

class CrearUsuarioRequest extends FormRequest
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
            "numero_documento" => ["required", "string"],
            "usuario" => ["required", "string"],
            "fecha_nacimiento" => ["required", "string"],
            "direccion" => ["required", "string"],
            "email" => ["required", "email"],
            "imagen" => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            "password" => [
                "required",
                "confirmed",
                PasswordRules::min(8)->letters()->symbols()->numbers()
            ],
            "id_tipo_documento" => ["required", "numeric"],
            "id_rol" => ["required", "numeric"],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            "nombre.required" => "El campo nombre es obligatorio.",
            "apellido.required" => "El campo apellido es obligatorio.",
            "numero_documento.required" => "El campo número de documento es obligatorio.",
            "usuario.required" => "El campo usuario es obligatorio.",
            "fecha_nacimiento.required" => "El campo fecha de nacimiento es obligatorio.",
            "direccion.required" => "El campo dirección es obligatorio.",
            "email.required" => "El campo email es obligatorio.",
            "email.email" => "El email debe ser una dirección de correo electrónico válida.",
            "imagen.required" => "La imagen es obligatoria.",
            "imagen.image" => "El archivo debe ser una imagen.",
            "imagen.mimes" => "La imagen debe tener uno de los siguientes formatos: jpeg, png, jpg, gif.",
            "imagen.max" => "La imagen no debe ser mayor de 2 MB.",
            "password.required" => "El campo contraseña es obligatorio.",
            "password.confirmed" => "Las contraseñas no coinciden.",
            "password.min" => "La contraseña debe tener al menos :min caracteres y contener letras, números y símbolos.",
            "id_tipo_documento.required" => "El campo tipo de documento es obligatorio.",
            "id_rol.required" => "El campo rol es obligatorio.",
        ];
    }
}
