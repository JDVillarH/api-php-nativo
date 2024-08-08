<?php

namespace App\Controller;

use App\Core\HttpResponse;
use Rakit\Validation\Validator;

class Controller
{
    static $validatorMessages = [
        "min" => "El parámetro :attribute debe ser mayor o igual a :min",
        "max" => "El parámetro :attribute debe ser menor o igual a :max",
        "required" => "El parámetro :attribute es obligatorio",
        "integer" => "El parámetro :attribute debe ser un número entero",
    ];

    /**
     * Valida los parámetros de la URL y los devuelve en un objeto de validación.
     * 
     * @param array $data Los datos de la URL
     * @param array $rules Las reglas de validación
     * @return object Devuelve el objeto de validación o muestra un error
     */
    public static function validate(array $data, array $rules): object
    {
        $validator = new Validator();
        $validation = $validator->validate($data, $rules, self::$validatorMessages);

        if ($validation->fails()) {
            die(HttpResponse::status400(["message" => $validation->errors()->firstOfAll()]));
        }

        return $validation;
    }
}
