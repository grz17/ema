<?php

namespace Controllers;
require('Configuracion/JWT/config.php');

use JwtAuth;
use Models\Comida;
use Rakit\Validation\Validator;

class ComidaController
{
    public static function crearComida($data)
    {
        $validator = new Validator;
        $validation = $validator->make($data, [
            'nombre' => 'required',
        ]);
        $validation->setMessages([
            'nombre:required' => 'El campo nombre es requerido',
        ]);
        $validation->validate();
        if ($validation->fails()) {
            $errores = $validation->errors();
            echo json_encode(["estado" => false, "detalle" => $errors = $errores->all()]);
            return;
        }
        $comida =Comida::where('nombre', $data['nombre'])->first();
        if (isset($comida)) {
            echo json_encode(["estado" => false, "detalle" => ["Comida repetido"]]);
            return;
        }
        $comida = new Comida();
        $comida->nombre = $data['nombre'];
        $comida->save();
        $JWT = new JwtAuth();
        $token = $JWT->Generar($comida);
        echo json_encode(["estado" => true, 'detalle' => $token]);
    }

    public static function comidas()
    {
      $res= Comida::all();
       echo json_encode(["estado" => true, 'detalle' => $res]);

    }
}

?>