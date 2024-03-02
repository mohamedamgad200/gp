<?php

namespace Modules\Authentication\App\Http\Controllers\Doctor;

use App\Models\Doctor;
use App\Trait\AHM_Response;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\DoctorResource;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller 
{
    use AHM_Response;
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }
    public function handleGoogleCallback()
    {

        $socialiteUser = Socialite::driver('google')->stateless()->user();
        $doctor = Doctor::updateOrCreate([
            'provider' => 'google',
            'provider_id' => $socialiteUser->getId(),
        ], [
            'name' => $socialiteUser->getName(),
            'email' => $socialiteUser->getEmail(),
        ]);
        $doctor_role = Role::where('name','doctor')->first();
        if($doctor_role){
            $doctor->assignRole($doctor_role);
        }
       // $doctor->addMediaFromUrl($socialiteUser->getAvatar())->toMediaCollection('doctor_profile_image');
        Auth::login($doctor);
        return $this->SocialiteResponse(
            'google',
            $doctor->id,
            $socialiteUser->getName(),
            $socialiteUser->getEmail(),
            $socialiteUser->getAvatar(),
            $socialiteUser->token
        );
    }
}