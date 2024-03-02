<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DoctorPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // create permission
        $doctorPermissions = [
            'add_post',
            'show_post',
            'edit_post',
            'delete_post',
            'show_statistics',
        ];
        foreach ($doctorPermissions as $permission) {
            Permission::Create( [
                'name' => $permission,
                'guard_name' => 'doctor_api',
            ]);
        }
        // create role
        $doctor_role = Role::updateOrCreate(['name' => 'doctor'], [
            'name' => 'doctor',
            'guard_name' => 'doctor_api',
        ]);
        // give permissions to role
        $doctor_role->givePermissionTo($doctorPermissions);
        /*

            // give role to user
            $doctor = Doctor::create([
                'name' => 'Doctor',
                'email' => 'doctor@doctor.com',
                'password' => Hash::make('abdo@abdo.com'),
                'email_verified_at' => Carbon::now(),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            $doctor->assignRole($doctor_role);

        */
    }
}
