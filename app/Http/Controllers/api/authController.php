<?php

namespace App\Http\Controllers\api;

#Basic
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
#resources
use App\Http\Resources\userResource;
#config->app
use Validator;
use Auth;
use Hash;
#Mail
use Mail;
use App\Mail\ActiveCode;use Illuminate\Support\Str;
#Models
use App\Models\Device;
use App\Models\Role;
use App\Models\City;
use App\Models\Section;
use App\Models\User_image;
use App\Models\User_neighborhood;
use App\Models\User;

class authController extends Controller
{
    #sign up
    public function register(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            //required
            'first_name' => 'required|max:255',
            'phone'      => 'required|min:7|max:13',
            'country_id' => 'nullable|exists:countries,id',
            'city_id'    => 'nullable|exists:cities,id',
            'gender'     => 'nullable|max:255',
            'expert'     => 'nullable|max:255',
            'password'   => 'required|max:255',
            //nullable
            'user_type'  => 'nullable|in:client,provider',
            'last_name'  => 'nullable|max:255',
            'email'      => 'nullable|max:255|email|unique:users,email',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #check phone if in used
        $phoneCode = isset($request->phone_code) ? ltrim($request->phone_code, '+') : '966';
        $phone     = convert_to_english($request->phone);
        $checkUser = User::wherePhone($phone)->wherePhoneCode($phoneCode)->first();
        #faild response
        if (isset($checkUser) && $request->user_type != 'market') return api_response(0, trans('api.usedPhone'));

        #send code to client's phone
        $code = active_code();
        $full_phone = convert_phone_to_international_format($phone, $phoneCode);
        sms_zain_auth($full_phone, $code);

        #store new client
        $request->request->add([
            'user_type'  => 'client',
            'active'     => 0,
            'blocked'    => 0,
            'api_token'  => Str::random(80),
            'code'       => $code,
            'password'   => $request->has('password') ? $request->password : '123456',
            'phone_code' => $phoneCode,
            'avatar'     => $request->has('avatar') ? $request->avatar : '/public/user.png',
            'role_id'    => Role::first()->id
        ]);
        $user = User::create($request->except(['_token']));

        #success response
        return api_response(1, trans('api.codeSentToPhoneSuccessfully'), new userResource($user), ['status' => user_status($user)]);
    }

    #sign in
    public function login(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'phone_code'  => 'nullable',
            'phone'       => 'required',
            'password'    => 'required',
            //'user_type'   => 'required|in:client,saler',
            'device_id'   => 'nullable|max:255',
            'device_type' => 'nullable|in:android,ios',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #full phone
        //$phoneCode = isset($request->phone_code) ? $request->phone_code : '966';

        #login with first_name
        if (Auth::attempt(['first_name' => $request->phone, 'password' => $request->password])) {
            $user = Auth::user();
            $user->update(['login' => '1']);
            #update user's device
            if (isset($request->device_id) && !is_null($request->device_id)) update_device($user, $request->device_id, $request->device_type);

            #success response
            return api_response(1, trans('api.loggedInSuccessfully'), new userResource($user), ['status' => user_status($user)]);
        }

        #login with phone
        if (Auth::attempt(['phone' => $request->phone, 'password' => $request->password])) {
            $user = Auth::user();
            $user->update(['login' => '1']);
            #update user's device
            if (isset($request->device_id) && !is_null($request->device_id)) update_device($user, $request->device_id, $request->device_type);

            #success response
            return api_response(1, trans('api.loggedInSuccessfully'), new userResource($user), ['status' => user_status($user)]);
        }

        #faild response
        return api_response(0, trans('api.wrongLogin'));
    }

    #logout
    public function logout(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'device_id' => 'nullable',
            'user_id'   => 'required|exists:users,id',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #remove user's device id
        if (!is_null($request->device_id)) Device::where('device_id', $request->device_id)->delete();
        else Device::where('user_id', $request->user_id)->delete();

        $user = User::whereId($request->user_id)->first();
        if (isset($user)) $user->update(['login' => '0']);

        #success response
        return api_response('1', trans('api.loggedOutSuccessfully'));
    }

    #destroy_user
    public function destroy_user(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id'   => 'required|exists:users,id',
            //'device_id' => 'required',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        //if (Device::where('user_id', $request->user_id)->where('device_id', $request->device_id)->count() == 0) return api_response(0, 'البيانات غير صحيحة');

        #remove user's device id
        Device::where('user_id', $request->user_id)->delete();
        #remove user
        User::whereId($request->user_id)->delete();

        #success response
        return api_response('1', trans('api.delete'));
    }

    #active account
    public function activeAccount(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id'     => 'required|exists:users,id',
            'code'        => 'required',
            'device_id'   => 'nullable|max:255',
            'device_type' => 'nullable|in:android,ios',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #get user
        $user = User::whereId($request->user_id)->first();
        #check code
        if ($user->code == $request->code) {
            #update client data
            $user->code      = rand(111, 999);
            $user->active    = '1';
            $user->login     = '1';
            $user->api_token = Str::random(80);
            $user->save();

            #update user's device
            if (isset($request->device_id) && !is_null($request->device_id)) update_device($user, $request->device_id, $request->device_type);

            #success response
            return api_response(1, trans('api.loggedInSuccessfully'), new userResource($user), ['status' => user_status($user)]);
        }

        #faild response
        return api_response(0, trans('api.wrongCode'));
    }

    #resend code
    public function resendCode(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ], [
            'user_id.required' => Translate('قم بتسجيل الدخول اولا')
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #get client
        $user = User::whereId($request->user_id)->first();

        #send code to client's phone
        $code       = active_code();
        $phoneCode  = !empty($user->phone_code) ? ltrim($user->phone_code, '+') : '966';
        $full_phone = convert_phone_to_international_format($user->phone, $phoneCode);
        sms_zain_auth($full_phone, $code);

        #update client data
        $user->code  = $code;
        $user->save();

        #success response
        return api_response(1, trans('api.send'));
    }

    #forget password
    public function forgetPassword(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'phone'      => 'required|min:9|max:13',
            'phone_code' => 'nullable',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #check phone if in used
        $phoneCode = isset($request->phone_code) ? ltrim($request->phone_code, '+') : '966';
        $phone     = convert_to_english($request->phone);
        $user      = User::wherePhone($phone)->first();
        #faild response
        if (!isset($user)) return api_response(0, trans('api.wrongPhone'));

        #send code to client's phone
        $code = active_code();
        $full_phone = convert_phone_to_international_format($phone, $phoneCode);
        sms_zain_auth($full_phone, $code);

        #update client data
        $user->code  = $code;
        $user->save();

        #success response
        return api_response(1, trans('api.codeSentToPhoneSuccessfully'), new userResource($user), ['status' => user_status($user)]);
    }

    #forget password
    public function resetPassword(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id'   => 'required|exists:users,id',
            'code'      => 'required|min:4|max:4',
            'password'  => 'required|min:6|max:255',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        $user = User::whereId($request->user_id)->first();
        /** Check Code **/
        if ($user->code == $request->code) {
            $user->update(['code' => rand('1111', '9999'), 'password' => $request->password]);

            #update user's device
            if (isset($request->device_id) && !is_null($request->device_id))
                update_device($user, $request->device_id, $request->device_type);

            /** send data **/
            return api_response('1', trans('api.passwordUpdated'), new userResource($user), ['status' => user_status($user)]);
        }

        /** If Code wrong **/
        return api_response('0', trans('api.wrongCode'));
    }

    #forget password
    public function updatePassword(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id'       => 'required|exists:users,id',
            'old_password'  => 'required',
            'password'      => 'required|min:6|max:255',
        ], [
            'user_id.required' => Translate('قم بتسجيل الدخول اولا')
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        $user = User::whereId($request->user_id)->first();
        /** Check Code **/
        if (Hash::check($request->old_password, $user->password)) {
            $user->update(['password' => $request->password]);

            /** send data **/
            return api_response('1', trans('api.passwordUpdated'), new userResource($user), ['status' => user_status($user)]);
        }

        /** If Code wrong **/
        return api_response('0', trans('api.wrongPassword'));
    }

    #update user
    public function updateUser(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            //required
            'user_id'    => 'required|exists:users,id',
            //nullable
            'lang'       => 'nullable|in:ar,en',
            'first_name' => 'nullable|max:255|unique:users,first_name,' . $request->user_id,
            'phone'      => 'nullable|min:9|max:13',
            'email'      => 'nullable|max:255|email|unique:users,email,' . $request->user_id,
            'password'   => 'nullable|max:255',
            'country_id' => 'nullable|exists:countries,id',
            'city_id'    => 'nullable|exists:cities,id',
            'gender'     => 'nullable|max:255',
            'expert'     => 'nullable|max:255',
        ], [
            'user_id.required' => Translate('قم بتسجيل الدخول اولا')
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        if (isset($request->phone) && !is_null($request->phone)) {
            #check phone if in used
            $phoneCode = isset($request->phone_code) ? ltrim($request->phone_code, '+') : '966';
            $phone     = convert_to_english($request->phone);
            $checkUser = User::where('id', '!=', $request->user_id)->wherePhone($phone)->wherePhoneCode($phoneCode)->first();
            #faild response
            if (isset($checkUser)) return api_response(0, trans('api.usedPhone'));

            if(isset($request->phone_code)) $request->request->add(['phone_code' => $phoneCode]);
        }

        #update client
        if ($request->hasFile('photo')) $avatar = upload_image($request->file('photo'), 'public/images/users');
        else $avatar = $request->photo;
        #check image
        if (!empty($avatar)) $request->request->add(['avatar' => $avatar]);
        #update client
        $user = User::whereId($request->user_id)->first();
        if (!empty($request->password)) $user->update($request->except(['user_id']));
        else $user->update($request->except(['user_id', 'password']));

        #success response
        return api_response(1, trans('api.save'), new userResource($user), ['status' => user_status($user)]);
    }

    #show user
    public function showUser(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ], [
            'user_id.required' => Translate('قم بتسجيل الدخول اولا')
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #get client
        $user = User::whereId($request->user_id)->first();

        #success response
        return api_response(1, trans('api.send'), new userResource($user), ['status' => user_status($user)]);
    }
}
