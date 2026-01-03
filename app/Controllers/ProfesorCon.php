<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\MProfesor;

class ProfesorCon extends Controller
{
    public function index()
{
    $modelo = new MProfesor();
    $profesores = $modelo->getProfesores();
    return view('DocenteView', ['profesores' => $profesores]);
}

    public function obtenerProfesores()
    {
        $modelo = new MProfesor();
        $profesores = $modelo->getProfesores();

        if (empty($profesores)) {
            return json_encode(['error' => 'No se encontraron profesores.']);
        }

        return json_encode($profesores);
    }
}