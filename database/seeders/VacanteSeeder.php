<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vacante;
use App\Models\User;

class VacanteSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@localizamos.co')->first();
        
        $vacantes = [
            [
                'titulo' => 'Asesor Comercial Senior',
                'area' => 'Comercial',
                'descripcion' => 'Buscamos un asesor comercial experimentado para impulsar las ventas de nuestros sistemas de monitoreo y seguridad.',
                'responsabilidades' => '• Contactar clientes potenciales\n• Realizar presentaciones comerciales\n• Generar cotizaciones\n• Hacer seguimiento a prospectos\n• Cumplir metas de ventas mensuales',
                'requisitos' => '• Bachiller graduado\n• Mínimo 2 años de experiencia en ventas\n• Excelente comunicación verbal\n• Manejo de Office\n• Disponibilidad de tiempo completo',
                'competencias' => '• Orientación al cliente\n• Persuasión\n• Trabajo bajo presión\n• Organización',
                'salario_minimo' => 2000000,
                'salario_maximo' => 3500000,
                'tipo_contrato' => 'indefinido',
                'modalidad' => 'presencial',
                'ubicacion' => 'Pereira, Risaralda',
                'vacantes_disponibles' => 2,
                'fecha_publicacion' => now()->subDays(5)->toDateString(),
                'fecha_cierre' => now()->addDays(25)->toDateString(),
                'estado' => 'publicada',
                'prioridad' => 'alta',
                'contacto_responsable' => 'Angie Villa - Recursos Humanos',
                'proceso_seleccion' => 'Entrevista inicial, prueba psicotécnica, entrevista técnica con gerencia comercial',
                'documentos_requeridos' => ['hoja_vida', 'cedula', 'certificados_educacion', 'referencias_laborales'],
                'created_by' => $admin->id
            ],
            [
                'titulo' => 'Técnico Instalador',
                'area' => 'Técnica',
                'descripcion' => 'Técnico especializado en instalación y mantenimiento de sistemas de monitoreo vehicular y seguridad.',
                'responsabilidades' => '• Instalar equipos de GPS y monitoreo\n• Realizar mantenimientos preventivos\n• Atender servicios correctivos\n• Documentar trabajos realizados\n• Brindar soporte técnico a clientes',
                'requisitos' => '• Técnico en electrónica o afines\n• Experiencia en instalación de equipos electrónicos\n• Conocimientos básicos de electricidad automotriz\n• Licencia de conducción vigente\n• Disponibilidad para viajar',
                'competencias' => '• Resolución de problemas\n• Atención al detalle\n• Trabajo en equipo\n• Adaptabilidad',
                'salario_minimo' => 1500000,
                'salario_maximo' => 2200000,
                'tipo_contrato' => 'indefinido',
                'modalidad' => 'presencial',
                'ubicacion' => 'Pereira y municipios aledaños',
                'vacantes_disponibles' => 1,
                'fecha_publicacion' => now()->subDays(2)->toDateString(),
                'estado' => 'publicada',
                'prioridad' => 'media',
                'contacto_responsable' => 'Coordinador Técnico',
                'proceso_seleccion' => 'Entrevista inicial, prueba práctica técnica, entrevista final',
                'documentos_requeridos' => ['hoja_vida', 'cedula', 'certificados_educacion', 'licencia_conduccion'],
                'created_by' => $admin->id
            ],
            [
                'titulo' => 'Operador Centro de Control Nocturno',
                'area' => 'Operaciones',
                'descripcion' => 'Operador para turno nocturno en nuestro centro de monitoreo, responsable de la vigilancia y respuesta a eventos.',
                'responsabilidades' => '• Monitorear sistemas de seguridad 24/7\n• Atender alarmas y eventos\n• Contactar clientes y autoridades\n• Generar reportes de novedades\n• Coordinar respuesta a emergencias',
                'requisitos' => '• Bachiller graduado\n• Disponibilidad turno nocturno\n• Capacidad de trabajo bajo presión\n• Excelente comunicación\n• Responsabilidad y puntualidad',
                'competencias' => '• Atención sostenida\n• Toma de decisiones\n• Comunicación efectiva\n• Manejo del estrés',
                'salario_minimo' => 1400000,
                'salario_maximo' => 1800000,
                'tipo_contrato' => 'indefinido',
                'modalidad' => 'presencial',
                'ubicacion' => 'Pereira - Centro de Control',
                'vacantes_disponibles' => 1,
                'fecha_publicacion' => now()->subDays(10)->toDateString(),
                'fecha_cierre' => now()->addDays(5)->toDateString(),
                'estado' => 'publicada',
                'prioridad' => 'urgente',
                'contacto_responsable' => 'Coordinador de Operaciones',
                'proceso_seleccion' => 'Entrevista inicial, prueba psicotécnica, entrevista con coordinación, examen médico',
                'documentos_requeridos' => ['hoja_vida', 'cedula', 'antecedentes'],
                'created_by' => $admin->id
            ]
        ];

        foreach ($vacantes as $vacanteData) {
            Vacante::create($vacanteData);
        }
    }
}