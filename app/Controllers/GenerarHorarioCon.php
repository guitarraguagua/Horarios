<?php
namespace App\Controllers;

require_once APPPATH . 'ThirdParty/fpdf.php';

use CodeIgniter\Controller;
use App\Models\MGenerarHorario;
use FPDF;

class GenerarHorarioCon extends Controller
{
    public function index()
    {
        // Cargar la vista de Generar Horario
        return view('GenerarHorarioView');
    }

    public function generarHorario()
    {
        // Aquí podrías implementar la lógica para generar el horario
        // Por ejemplo, podrías llamar a un modelo que obtenga los datos necesarios
        $modelo = new MGenerarHorario();
        $resultado = $modelo->generarHorario();    
    }

    public function generarPDF()
    {
        $modelo = new MGenerarHorario();
        $horarios = $modelo->getHorarios();

        if (empty($horarios)) {
            // Si no hay datos, muestra un mensaje simple en PDF
            $pdf = new FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->Cell(0, 10, utf8_decode('No hay horarios disponibles.'), 0, 1, 'C');
            $pdf->Output('D', 'Horarios_Por_Semestre.pdf');
            return;
        }

        // Agrupar por semestre
        $porSemestre = [];
        foreach ($horarios as $h) {
            $semestre = isset($h['semestre']) ? $h['semestre'] : 'Sin Semestre';
            $porSemestre[$semestre][] = $h;
        }

        // Crear el PDF
        $pdf = new FPDF();
        $pdf->SetAutoPageBreak(true, 15);

        foreach ($porSemestre as $semestre => $horas) {
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell(0, 10, utf8_decode('Horario Semestre ' . $semestre), 0, 1, 'C');

            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(25, 10, utf8_decode('Día'), 1);
            $pdf->Cell(25, 10, utf8_decode('Inicio'), 1);
            $pdf->Cell(25, 10, utf8_decode('Fin'), 1);
            $pdf->Cell(40, 10, utf8_decode('Asignatura'), 1);
            $pdf->Cell(40, 10, utf8_decode('Docente'), 1);
            $pdf->Cell(25, 10, utf8_decode('Sala'), 1);
            $pdf->Ln();

            $pdf->SetFont('Arial', '', 9);
            foreach ($horas as $h) {
                $y = $pdf->GetY();
                $x = $pdf->GetX();

                // Datos de la fila
                $dia = utf8_decode(isset($h['dia_nombre']) ? $h['dia_nombre'] : '');
                $inicio = isset($h['hora_inicio']) ? $h['hora_inicio'] : '';
                $fin = isset($h['hora_fin']) ? $h['hora_fin'] : '';
                $asignatura = utf8_decode(isset($h['nombre']) ? $h['nombre'] : '');
                $docente = utf8_decode(isset($h['docente']) ? $h['docente'] : '');
                $sala = isset($h['idSala']) ? $h['idSala'] : '';

                // Calcular altura necesaria para MultiCell (Asignatura y Docente)
                $altura_asig = $pdf->GetStringWidth($asignatura) > 40 ? 16 : 8;
                $altura_doc = $pdf->GetStringWidth($docente) > 40 ? 16 : 8;
                $altura = max(8, $altura_asig, $altura_doc);

                // Día, Inicio, Fin
                $pdf->Cell(25, $altura, $dia, 1);
                $pdf->Cell(25, $altura, $inicio, 1);
                $pdf->Cell(25, $altura, $fin, 1);

                // Asignatura
                $x_asig = $pdf->GetX();
                $y_asig = $pdf->GetY();
                $pdf->MultiCell(40, 8, $asignatura, 1, 'L');
                $x_doc = $pdf->GetX();
                $y_doc = $pdf->GetY();

                // Docente (a la derecha de Asignatura)
                $pdf->SetXY($x_asig + 40, $y_asig);
                $pdf->MultiCell(40, 8, $docente, 1, 'L');

                // Sala (a la derecha de Docente)
                $maxY = max($pdf->GetY(), $y_doc + 8, $y_asig + 8);
                $pdf->SetXY($x_asig + 80, $y_asig);
                $pdf->Cell(25, $altura, $sala, 1);

                // Mover a la siguiente línea
                $pdf->SetY($maxY);
            }
        }

        // Forzar descarga
        $pdf->Output('D', 'Horarios_Por_Semestre.pdf');
    }
}