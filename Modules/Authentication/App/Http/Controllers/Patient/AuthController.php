<?php

namespace Modules\Authentication\App\Http\Controllers\Patient;

use App\Models\Patient;
use Ichtrojan\Otp\Otp;
use App\Trait\AHM_Response;
use App\Trait\CommonFunction;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\PatientResource;
use Modules\Authentication\App\Emails\Patient\ResendOTPMail;
use Modules\Authentication\App\Emails\Patient\ForgetPasswordMail;
use Modules\Authentication\App\Http\Requests\Patient\SigninRequest;
use Modules\Authentication\App\Http\Requests\Patient\SignupRequest;
use Modules\Authentication\App\Http\Requests\Patient\ResendOTPRequest;
use Modules\Authentication\App\Http\Requests\Patient\ResetPasswordRequest;
use Modules\Authentication\App\Http\Requests\Patient\ChangePasswordRequest;
use Modules\Authentication\App\Http\Requests\Patient\DeleteProfileRequest;
use Modules\Authentication\App\Http\Requests\Patient\ForgetPasswordRequest;
use Modules\Authentication\App\Http\Requests\Patient\UpdateProfileRequest;

class AuthController extends Controller
{
    use AHM_Response;
    use CommonFunction;
    public function signup(SignupRequest $request) 
    {
        $data = $request->validated();
        $patient = Patient::create($data);

        // assign role to user
        $patient_role = Role::where('name','patient')->first();
        if($patient_role){
            $patient->assignRole($patient_role);
        }

        $token = $patient->createToken("token")->plainTextToken;
        return $this->signupResponse(PatientResource::make($patient),$token);
    }
    public function signin(SigninRequest $request) 
    {
        $data = $request->validated();
        $patient = Patient::where('email', $data['email'])->first();

        if ($patient && Hash::check($data['password'], $patient->password)) {
            $patient->tokens()->delete();
            $token = $patient->createToken("token")->plainTextToken;
            return $this->signinResponse(PatientResource::make($patient), $token);
        }
        return $this->invalidCredentialsResponse();
    }
    public function logout() 
    {
        $patient = auth('patient_api')->user();
        $patient = Patient::find($patient->id);
        if ($patient) {
            $patient->tokens()->delete();
            return $this->logoutResponse();
        }
    }
    public function forgetPassword(ForgetPasswordRequest $request) 
    {
        $data = $request->validated();
        $patient = Patient::where('email', $data['email'])->first();
        $this->sendMail($patient,new ForgetPasswordMail($patient));
        return $this->OTPSendResponse();
    }
    public function resetPassword(ResetPasswordRequest $request)
    {
        $data = $request->validated();
        $patient = Patient::where('email', $data['email'])->first();
        $otp2 = (new Otp)->validate($patient->email, $data['otp']);
        if (!$otp2->status) {
            return $this->OTPNotValidResponse();
        }
        $patient->update([
            'password' => Hash::make($data['password'])
        ]);
        $patient->tokens()->delete();
        return $this->ResetPasswordResponse();
    }
    public function changePassword(ChangePasswordRequest $request)
    {
        $data = $request->validated();
        $patient = auth('patient_api')->user();
        $patient = Patient::find($patient->id);
        if (!Hash::check($data['current_password'], $patient->password)) {
            return $this->PasswordNotValidResponse();
        }
        $patient->update([
            'password' => Hash::make($data['new_password']),
        ]);
        return $this->ChangePasswordResponse();
    }
    public function resendOtp(ResendOTPRequest $request)
    {
        $data = $request->validated();
        $patient = Patient::where('email',$data['email'])->first();
        $this->sendMail($patient,new ResendOTPMail($patient));
        return $this->OTPResendResponse();
    }
    public function profile()
    {
        $patient = auth('patient_api')->user();
        return $this->ProfileResponse(PatientResource::make($patient));
    }
    public function updateProfile(UpdateProfileRequest $request)
    {
        $data = $request->validated();
        $patient = auth('patient_api')->user();
        $patient = Patient::find($patient->id);
        $patient->update($data);
        if ($request->hasFile('image')) {
            $patient->addMediaFromRequest('image')->toMediaCollection('patient_profile_image');
        }
        return $this->UpdateProfileResponse(PatientResource::make($patient));
    }
    public function deleteProfile(DeleteProfileRequest $request)
    {
        $data = $request->validated();
        $patient = auth('patient_api')->user();
        $patient = Patient::find($patient->id);
        if (!Hash::check($data['password'], $patient->password)) {
            return $this->InvalidPasswordResponse();
        }
        $patient->tokens()->delete();
        $patient->delete();
        return $this->DeleteProfileResponse();
    }
}
