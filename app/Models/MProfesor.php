<?php

namespace App\Models;
use CodeIgniter\Model;

class MProfesor extends Model
{
    protected $table = 'Profesores';
    protected $primaryKey = 'profesor_rut';
    protected $allowedFields = ['profesor_rut', 'nombre', 'apellido_paterno', 'apellido_materno'];

    /**
     * Obtiene todos los profesores
     * @return array
     */

    public function getProfesores()
    {
        try {
            $db = \Config\Database::connect();
            $query = $db->query("SELECT * FROM Profesores");
            $result = $query->getResultArray();
            // Libera recursos si es necesario (especialmente en procedimientos almacenados)
            $query->freeResult();
            // Cierra la conexión solo si no la reutilizas en otros métodos
            $db->close();
            return $result;
        } catch (\Throwable $e) {
            log_message('error', 'Error al obtener profesores: ' . $e->getMessage());
            return [];
        }
    }
}