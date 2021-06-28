<?php

namespace Controllers;
require('Configuracion/JWT/config.php');

use JwtAuth;
use Models\Precio;
use Rakit\Validation\Validator;

class PreciosController
{
    public static function Nuevoprecio($data)
    {
        $validator = new Validator;
        $validation = $validator->make($data, [
            'precios' => 'required',
        ]);
        $validation->setMessages([
            'precios:required' => 'El precio es requerido',
        ]);
        $validation->validate();
        if ($validation->fails()) {
            $errores = $validation->errors();
            echo json_encode(["estado" => false, "detalle" => $errors = $errores->all()]);
            return;
        }
        $precio=Precio::where('precios', $data['precios'])->first();
        if (isset($precio)) {
            echo json_encode(["estado" => false, "detalle" => ["precio igual"]]);
            return;
        }
        $precio = new Precio();
        $precio->precios = $data['precios'];
        $precio->save();
        $JWT = new JwtAuth();
        $token = $JWT->Generar($precio);
        echo json_encode(["estado" => true, 'detalle' => $token]);
    }

    public static function Precios()
    {
      $res= Precio::all();
       echo json_encode(["estado" => true, 'detalle' => $res]);

    }
}

?>