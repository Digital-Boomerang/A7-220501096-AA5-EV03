<?php

class VehiculoController
{
    public function listar()
    {
        Response::json([
            'status' => 'ok',
            'data' => []
        ]);
    }
}
