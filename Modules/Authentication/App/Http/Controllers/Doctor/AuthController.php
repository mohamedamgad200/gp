<?php

namespace Modules\Authentication\App\Http\Controllers\Doctor;

use App\Models\Doctor;
use Ichtrojan\Otp\Otp;
use App\Trait\AHM_Response;
use App\Trait\CommonFunction;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\DoctorResource;
use Modules\Authentication\App\Emails\Doctor\ResendOTPMail;
use Modules\Authentication\App\Emails\Doctor\ForgetPasswordMail;
use Modules\Authentication\App\Http\Requests\Doctor\SigninRequest;
use Modules\Authentication\App\Http\Requests\Doctor\SignupRequest;
use Modules\Authentication\App\Http\Requests\Doctor\ResendOTPRequest;
use Modules\Authentication\App\Http\Requests\Doctor\ResetPasswordRequest;
use Modules\Authentication\App\Http\Requests\Doctor\ChangePasswordRequest;
use Modules\Authentication\App\Http\Requests\Doctor\DeleteProfileRequest;
use Modules\Authentication\App\Http\Requests\Doctor\ForgetPasswordRequest;
use Modules\Authentication\App\Http\Requests\Doctor\UpdateProfileRequest;

class AuthController extends Controller
{
    use AHM_Response;
    use CommonFunction;
    public function signup(SignupRequest $request) 
    {
        $data = $request->validated();
        $doctor = Doctor::create($data);
        $doctor_role = Role::where('name','doctor')->first();
        if($doctor_role){
            $doctor->assignRole($doctor_role);
        }
        $token = $doctor->createToken("token")->plainTextToken;
        return $this->signupResponse(DoctorResource::make($doctor),$token);
    }
    public function signin(SigninRequest $request) 
    {
        $data = $request->validated();
        $doctor = Doctor::where('email', $data['email'])->first();

        if ($doctor && Hash::check($data['password'], $doctor->password)) {
            $doctor->tokens()->delete();
            $token = $doctor->createToken("token")->plainTextToken;
            return $this->signinResponse(DoctorResource::make($doctor), $token);
        }
        return $this->invalidCredentialsResponse();
    }
    public function logout() 
    {
        $doctor = auth('doctor_api')->user();
        $doctor = Doctor::find($doctor->id);
        if ($doctor) {
            $doctor->tokens()->delete();
            return $this->logoutResponse();
        }
    }
    public function forgetPassword(ForgetPasswordRequest $request) 
    {
        $data = $request->validated();
        $doctor = Doctor::where('email', $data['email'])->first();
        $this->sendMail($doctor,new ForgetPasswordMail($doctor));
        return $this->OTPSendResponse();
    }
    public function resetPassword(ResetPasswordRequest $request)
    {
        $data = $request->validated();
        $doctor = Doctor::where('email', $data['email'])->first();
        $otp2 = (new Otp)->validate($doctor->email, $data['otp']);
        if (!$otp2->status) {
            return $this->OTPNotValidResponse();
        }
        $doctor->update([
            'password' => Hash::make($data['password'])
        ]);
        $doctor->tokens()->delete();
        return $this->ResetPasswordResponse();
    }
    public function changePassword(ChangePasswordRequest $request)
    {
        $data = $request->validated();
        $doctor = auth('doctor_api')->user();
        $doctor = Doctor::find($doctor->id);
        if (!Hash::check($data['current_password'], $doctor->password)) {
            return $this->PasswordNotValidResponse();
        }
        $doctor->update([
            'password' => Hash::make($data['new_password']),
        ]);
        return $this->ChangePasswordResponse();
    }
    public function resendOtp(ResendOTPRequest $request)
    {
        $data = $request->validated();
        $doctor = Doctor::where('email',$data['email'])->first();
        $this->sendMail($doctor,new ResendOTPMail($doctor));
        return $this->OTPResendResponse();
    }
    public function profile()
    {
        $doctor = auth('doctor_api')->user();
        return $this->ProfileResponse(DoctorResource::make($doctor));
    }
    public function updateProfile(UpdateProfileRequest $request)
    {
        $data = $request->validated();
        $doctor = auth('doctor_api')->user();
        $doctor = Doctor::find($doctor->id);
        $doctor->update($data);
        if ($request->hasFile('image')) {
            $doctor->addMediaFromRequest('image')->toMediaCollection('doctor_profile_image');
        }
        return $this->UpdateProfileResponse(DoctorResource::make($doctor));
    }
    public function deleteProfile(DeleteProfileRequest $request)
    {
        $data = $request->validated();
        $doctor = auth('doctor_api')->user();
        $doctor = Doctor::find($doctor->id);
        if (!Hash::check($data['password'], $doctor->password)) {
            return $this->InvalidPasswordResponse();
        }
        $doctor->tokens()->delete();
        $doctor->delete();
        return $this->DeleteProfileResponse();
    }
}