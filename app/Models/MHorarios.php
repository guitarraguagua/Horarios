<?php



class MHorarios extends CI_Model {

    public function generarHorarios($semestre_academico = 2) {
        $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];
        $bloques = range(1, 14); // 14 bloques de 45 minutos entre 8:30 y 19:00

        // Obtener ramos solo del semestre académico actual (pares o impares)
        $ramos = $this->db
            ->where('MOD(semestre, 2)', $semestre_academico % 2)
            ->get('ramo')->result();

        $salas = $this->db->get('sala')->result();

        foreach ($ramos as $ramo) {
            $total_bloques = $ramo->horas_catedra + $ramo->horas_laboratorio;
            $bloques_asignados = 0;

            while ($bloques_asignados < $total_bloques) {
                $asignado = false;
                foreach ($dias as $dia) {
                    foreach ($salas as $sala) {
                        if ($sala->capacidad < $ramo->cantidad_alumnos) continue;

                        for ($i = 1; $i <= 12; $i++) {
                            $cantidad_bloques = min(3, $total_bloques - $bloques_asignados);
                            $bloques_candidatos = range($i, $i + $cantidad_bloques - 1);
                            if (max($bloques_candidatos) > 14) continue;

                            if ($this->bloquesDisponibles($bloques_candidatos, $dia, $sala->idSala)) {
                                foreach ($bloques_candidatos as $bloque) {
                                    $this->db->insert('horario', [
                                        'idRamo' => $ramo->id,
                                        'idSala' => $sala->idSala,
                                        'dia' => $dia,
                                        'bloque' => $bloque
                                    ]);
                                    $bloques_asignados++;
                                }
                                $asignado = true;
                                break 2;
                            }
                        }
                    }
                }

                if (!$asignado) {
                    log_message('error', "No se pudo asignar horario completo al ramo ID {$ramo->id}");
                    break;
                }
            }
        }
    }

    // Verifica que los bloques estén libres en esa sala
    private function bloquesDisponibles($bloques, $dia, $idSala) {
        foreach ($bloques as $bloque) {
            $conflicto = $this->db
                ->where('dia', $dia)
                ->where('bloque', $bloque)
                ->where('idSala', $idSala)
                ->get('horario')->num_rows();

            if ($conflicto > 0) return false;
        }
        return true;
    }
}