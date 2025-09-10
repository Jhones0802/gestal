<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Empleado;
use App\Models\User;

class EmpleadoSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@localizamos.co')->first();
        
        // Empleados de ejemplo
        $empleados = [
            [
                'cedula' => '1094567890',
                'nombres' => 'Carlos Andrés',
                'apellidos' => 'García Rodríguez',
                'fecha_nacimiento' => '1985-03-15',
                'genero' => 'masculino',
                'estado_civil' => 'casado',
                'telefono' => '3151234567',
                'celular' => '3151234567',
                'email' => 'carlos.garcia@localizamos.co',
                'direccion' => 'Calle 25 #45-67 Barrio Los Alpes',
                'ciudad' => 'Pereira',
                'departamento' => 'Risaralda',
                'cargo' => 'Asesor Comercial Senior',
                'area' => 'Comercial',
                'salario' => 2500000,
                'tipo_contrato' => 'indefinido',
                'fecha_ingreso' => '2020-01-15',
                'estado' => 'activo',
                'eps' => 'SURA',
                'arl' => 'COLPATRIA',
                'fondo_pension' => 'PORVENIR',
                'caja_compensacion' => 'COMFAMILIAR',
                'nivel_educativo' => 'profesional',
                'titulo_obtenido' => 'Administrador de Empresas',
                'institucion' => 'Universidad Tecnológica de Pereira',
                'contacto_emergencia_nombre' => 'María García Pérez',
                'contacto_emergencia_telefono' => '3209876543',
                'contacto_emergencia_parentesco' => 'Esposo(a)',
                'created_by' => $admin->id
            ],
            [
                'cedula' => '42567890',
                'nombres' => 'Laura Patricia',
                'apellidos' => 'Hernández López',
                'fecha_nacimiento' => '1992-08-22',
                'genero' => 'femenino',
                'estado_civil' => 'soltero',
                'telefono' => '3167654321',
                'celular' => '3167654321',
                'email' => 'laura.hernandez@localizamos.co',
                'direccion' => 'Carrera 14 #28-45 Barrio Centro',
                'ciudad' => 'Dosquebradas',
                'departamento' => 'Risaralda',
                'cargo' => 'Técnico Instalador',
                'area' => 'Técnica',
                'salario' => 1800000,
                'tipo_contrato' => 'indefinido',
                'fecha_ingreso' => '2021-06-01',
                'estado' => 'activo',
                'eps' => 'COOMEVA',
                'arl' => 'COLPATRIA',
                'fondo_pension' => 'COLFONDOS',
                'caja_compensacion' => 'COMFAMILIAR',
                'nivel_educativo' => 'tecnico',
                'titulo_obtenido' => 'Técnico en Sistemas',
                'institucion' => 'SENA',
                'contacto_emergencia_nombre' => 'Pedro Hernández',
                'contacto_emergencia_telefono' => '3201122334',
                'contacto_emergencia_parentesco' => 'Padre',
                'created_by' => $admin->id
            ],
            [
                'cedula' => '1088123456',
                'nombres' => 'Miguel Ángel',
                'apellidos' => 'Jiménez Vargas',
                'fecha_nacimiento' => '1988-11-10',
                'genero' => 'masculino',
                'estado_civil' => 'union_libre',
                'telefono' => '3145556677',
                'celular' => '3145556677',
                'email' => 'miguel.jimenez@localizamos.co',
                'direccion' => 'Avenida 30 de Agosto #12-34',
                'ciudad' => 'Pereira',
                'departamento' => 'Risaralda',
                'cargo' => 'Operador Centro de Control',
                'area' => 'Operaciones',
                'salario' => 1600000,
                'tipo_contrato' => 'indefinido',
                'fecha_ingreso' => '2019-09-15',
                'estado' => 'activo',
                'jefe_inmediato' => 'Coordinador de Operaciones',
                'eps' => 'SANITAS',
                'arl' => 'COLPATRIA',
                'fondo_pension' => 'PROTECCIÓN',
                'caja_compensacion' => 'COMFAMILIAR',
                'nivel_educativo' => 'bachillerato',
                'contacto_emergencia_nombre' => 'Ana Vargas',
                'contacto_emergencia_telefono' => '3198765432',
                'contacto_emergencia_parentesco' => 'Esposo(a)',
                'created_by' => $admin->id
            ]
        ];

        foreach ($empleados as $empleadoData) {
            Empleado::create($empleadoData);
        }
    }
}