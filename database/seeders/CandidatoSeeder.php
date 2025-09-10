<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Candidato;
use App\Models\Vacante;
use App\Models\User;

class CandidatoSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@localizamos.co')->first();
        $vacantes = Vacante::all();
        
        if ($vacantes->count() > 0) {
            $candidatos = [
                [
                    'vacante_id' => $vacantes->first()->id,
                    'cedula' => '52789456',
                    'nombres' => 'María Elena',
                    'apellidos' => 'González Pérez',
                    'fecha_nacimiento' => '1995-05-15',
                    'genero' => 'femenino',
                    'telefono' => '3167894561',
                    'celular' => '3167894561',
                    'email' => 'maria.gonzalez@email.com',
                    'direccion' => 'Carrera 15 #30-45 Barrio Cuba',
                    'ciudad' => 'Pereira',
                    'departamento' => 'Risaralda',
                    'nivel_educativo' => 'profesional',
                    'titulo_obtenido' => 'Administradora de Empresas',
                    'institucion' => 'Universidad Católica Luis Amigó',
                    'experiencia_laboral' => 'Dos años como asesora comercial en empresa de telecomunicaciones. Excelente manejo de CRM y técnicas de ventas.',
                    'pretension_salarial' => 2800000,
                    'estado' => 'preseleccionado',
                    'fecha_aplicacion' => now()->subDays(3)->toDateString(),
                    'observaciones' => 'Candidata con perfil muy interesante. Aplicó por WhatsApp.',
                    'created_by' => $admin->id
                ],
                [
                    'vacante_id' => $vacantes->skip(1)->first()->id ?? $vacantes->first()->id,
                    'cedula' => '1088456789',
                    'nombres' => 'Juan Carlos',
                    'apellidos' => 'Ramírez Torres',
                    'fecha_nacimiento' => '1992-08-22',
                    'genero' => 'masculino',
                    'telefono' => '3201234567',
                    'celular' => '3201234567',
                    'email' => 'juan.ramirez@email.com',
                    'direccion' => 'Calle 50 #25-30 Villa Santana',
                    'ciudad' => 'Pereira',
                    'departamento' => 'Risaralda',
                    'nivel_educativo' => 'tecnico',
                    'titulo_obtenido' => 'Técnico en Electrónica',
                    'institucion' => 'SENA',
                    'experiencia_laboral' => 'Tres años instalando sistemas de alarmas y CCTV en empresa de seguridad.',
                    'pretension_salarial' => 2000000,
                    'estado' => 'entrevista_inicial',
                    'fecha_aplicacion' => now()->subDays(5)->toDateString(),
                    'observaciones' => 'Experiencia relevante en el sector. Recomendado por empleado actual.',
                    'created_by' => $admin->id
                ],
                [
                    'vacante_id' => $vacantes->skip(2)->first()->id ?? $vacantes->first()->id,
                    'cedula' => '1094123456',
                    'nombres' => 'Andrea',
                    'apellidos' => 'Morales Silva',
                    'fecha_nacimiento' => '1998-12-10',
                    'genero' => 'femenino',
                    'telefono' => '3159876543',
                    'celular' => '3159876543',
                    'email' => 'andrea.morales@email.com',
                    'direccion' => 'Avenida 30 de Agosto #15-20',
                    'ciudad' => 'Pereira',
                    'departamento' => 'Risaralda',
                    'nivel_educativo' => 'bachillerato',
                    'titulo_obtenido' => 'Bachiller Académico',
                    'institucion' => 'Colegio San José',
                    'experiencia_laboral' => 'Un año en centro de llamadas. Disponibilidad para turnos nocturnos.',
                    'pretension_salarial' => 1600000,
                    'estado' => 'aplicado',
                    'fecha_aplicacion' => now()->subDays(1)->toDateString(),
                    'observaciones' => 'Primera experiencia laboral. Muy motivada.',
                    'created_by' => $admin->id
                ]
            ];

            foreach ($candidatos as $candidatoData) {
                Candidato::create($candidatoData);
            }
        }
    }
}