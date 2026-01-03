<?php

namespace App\Models;
use CodeIgniter\Model;

class MGenerarHorario extends Model
{
    protected $table = 'horarios';
    protected $primaryKey = 'id';
    protected $allowedFields = ['dia', 'hora_inicio', 'hora_fin', 'asignatura_id', 'docente_id'];
    protected $returnType = 'array';

    /**
     * Obtiene los horarios usando el procedimiento almacenado SP_OBTENER_HORARIOS
     * @return array
     */
    public function getHorarios()
    {
        try {
            $db = \Config\Database::connect();
            $query = $db->query("CALL SP_OBTENER_HORARIOS()");
            $result = $query->getResultArray();
            // Libera recursos si es necesario (especialmente en procedimientos almacenados)
            $query->freeResult();
            // Cierra la conexión solo si no la reutilizas en otros métodos
            $db->close();
            return $result;
        } catch (\Throwable $e) {
            log_message('error', 'Error al obtener horarios: ' . $e->getMessage());
            return [];
        }
    }

    public function generarHorario()
    {
        try {
            $db = \Config\Database::connect();
            $query = $db->query("CALL SP_GENERAR_HORARIO()");
            }
        catch (\Throwable $e) {
            log_message('error', 'Error al generar horario: ' . $e->getMessage());
            return false;
        }
    }
}