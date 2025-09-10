<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProcesoSeleccion;
use App\Models\Candidato;
use App\Models\User;

class ProcesoSeleccionSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@localizamos.co')->first();
        $candidatos = Candidato::all();
        
        if ($candidatos->count() > 0) {
            $evaluaciones = [
                [
                    'candidato_id' => $candidatos->first()->id,
                    'tipo_evaluacion' => 'entrevista_inicial',
                    'fecha_programada' => now()->subDays(2)->toDateString(),
                    'hora_programada' => '10:00',
                    'fecha_realizada' => now()->subDays(2)->toDateString(),
                    'estado' => 'realizada',
                    'puntaje' => 85,
                    'puntaje_maximo' => 100,
                    'resultado' => 'aprobado',
                    'observaciones' => 'Candidata con excelente comunicación y motivación. Muy buena presentación personal.',
                    'fortalezas' => 'Comunicación efectiva, experiencia relevante, motivación alta',
                    'entrevistador' => 'Angie Villa - Analista RRHH',
                    'lugar_evaluacion' => 'Oficina principal',
                    'created_by' => $admin->id
                ],
                [
                    'candidato_id' => $candidatos->skip(1)->first()->id ?? $candidatos->first()->id,
                    'tipo_evaluacion' => 'entrevista_inicial',
                    'fecha_programada' => now()->subDays(1)->toDateString(),
                    'hora_programada' => '14:30',
                    'fecha_realizada' => now()->subDays(1)->toDateString(),
                    'estado' => 'realizada',
                    'puntaje' => 78,
                    'puntaje_maximo' => 100,
                    'resultado' => 'aprobado',
                    'observaciones' => 'Candidato con experiencia técnica sólida. Algo nervioso pero competente.',
                    'fortalezas' => 'Experiencia técnica, conocimiento del sector',
                    'debilidades' => 'Nerviosismo inicial, poca experiencia en presentaciones',
                    'entrevistador' => 'Angie Villa - Analista RRHH',
                    'lugar_evaluacion' => 'Oficina principal',
                    'created_by' => $admin->id
                ],
                [
                    'candidato_id' => $candidatos->first()->id,
                    'tipo_evaluacion' => 'prueba_psicotecnica',
                    'fecha_programada' => now()->addDays(1)->toDateString(),
                    'hora_programada' => '09:00',
                    'estado' => 'programada',
                    'resultado' => 'pendiente',
                    'observaciones' => 'Evaluación programada con psicólogo externo',
                    'entrevistador' => 'Dr. Patricia Mejía - Psicóloga',
                    'lugar_evaluacion' => 'Consultorio Psicológico Centro',
                    'created_by' => $admin->id
                ],
                [
                    'candidato_id' => $candidatos->skip(2)->first()->id ?? $candidatos->first()->id,
                    'tipo_evaluacion' => 'entrevista_inicial',
                    'fecha_programada' => now()->addDays(2)->toDateString(),
                    'hora_programada' => '11:00',
                    'estado' => 'programada',
                    'resultado' => 'pendiente',
                    'observaciones' => 'Primera entrevista para operadora nocturna',
                    'entrevistador' => 'Angie Villa - Analista RRHH',
                    'lugar_evaluacion' => 'Oficina principal',
                    'created_by' => $admin->id
                ]
            ];

            foreach ($evaluaciones as $evaluacionData) {
                ProcesoSeleccion::create($evaluacionData);
            }
        }
    }
}