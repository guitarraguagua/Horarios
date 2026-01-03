<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Database\Exceptions\DatabaseException;

class TestConexion extends Controller
{
    public function index()
    {
        try {
            $db = \Config\Database::connect();
            $db->initialize(); // fuerza la conexión y lanza excepción si falla

            if ($db->connID) {
                echo "Conexión exitosa a la base de datos usando CodeIgniter.";
            } else {
                echo "No se pudo conectar a la base de datos.";
            }
        } catch (\Throwable $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
    }
}