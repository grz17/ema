<?php

namespace Controllers;
require('Configuracion/JWT/config.php');

use JwtAuth;
use Models\Restaurantes;
use Rakit\Validation\Validator;

class RestaurantesController
{
    public static function crearRestaurante($data)
    {
        $validator = new Validator;
        $validation = $validator->make($data, [
            'nombre' => 'required',
            'descripcion' => 'required',
        ]);
        $validation->setMessages([
            'nombre:required' => 'El campo nombre es requerido',
            'descripcion:required' => 'El campo descripcion es requerido',
        ]);
        $validation->validate();
        if ($validation->fails()) {
            $errores = $validation->errors();
            echo json_encode(["estado" => false, "detalle" => $errors = $errores->all()]);
            return;
        }
        $restaurante =Restaurantes::where('nombre', $data['nombre'])->orWhere('descripcion', $data['descripcion'])->first();
        if (isset($restaurante)) {
            echo json_encode(["estado" => false, "detalle" => ["Restaurante repetido"]]);
            return;
        }
        $restaurante = new Restaurantes();
        $restaurante->nombre = $data['nombre'];
        $restaurante->descripcion = $data['descripcion'];
        $restaurante->save();
        $JWT = new JwtAuth();
        $token = $JWT->Generar($restaurante);
        echo json_encode(["estado" => true, 'detalle' => $token]);
    }

    public static function datos()
    {
      $res= Restaurantes::all();
       echo json_encode(["estado" => true, 'detalle' => $res]);

    }
}

?>