<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PatientPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create permission
        $patientPermissions = [
            'show_post',
        ];
        foreach ($patientPermissions as $permission) {
            Permission::Create( [
                'name' => $permission,
                'guard_name' => 'patient_api',
            ]);
        }
        // create role
        $patient_role = Role::updateOrCreate(['name' => 'patient'], [
            'name' => 'patient',
            'guard_name' => 'patient_api',
        ]);
        // give permissions to role
        $patient_role->givePermissionTo($patientPermissions);
        
    }
}
