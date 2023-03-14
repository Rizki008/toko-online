<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $credentials = request(['email', 'password']);

        if (auth()->attempt($credentials)) {
            $token = Auth::guard('api')->attempt($credentials);
            return response()->json([
                'success' => true,
                'message' => 'Login Berhasil',
                'token' => $token
            ]);
            // $token = Auth::guard('api')->attempt($credentials);
            // dd($token);
            // cookie()->queue(cookie('token', $token, 60));
            // return redirect('/dashboard');
        }

        return response()->json([
            'success' => false,
            'message' => 'Email atau Password Salah'
        ]);

        // return back()->withErrors([
        //     'error' => 'Email atau Password Salah'
        // ]);
        // $credentials = request(['email', 'password']);

        // if (!$token = auth()->attempt($credentials)) {
        //     return response()->json('Email or Password is worng', 401);
        // }

        // return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function register()
    {
        return view('auth.register_member');
    }

    public function register_action(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_member' => 'required',
            // 'provinsi' => 'required',
            // 'kabupaten' => 'required',
            // 'kecamatan' => 'required',
            // 'detail_alamat' => 'required',
            'no_hp' => 'required',
            'email' => 'required|email',
            'password' => 'required|same:konfirmasi_password',
            'konfirmasi_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            // return response()->json([
            //     $validator->errors(), 422
            // ]);
            Session::flash('errors', $validator->errors()->toArray());
            return redirect('/register');
        }

        $input = $request->all();
        $input['password'] = bcrypt($request->password);
        // $input['password'] = Hash::make($request->password);
        unset($input['konfirmasi_password']);
        // $member = Member::create($input);
        Member::create($input);

        // return response()->json([
        //     'data' => $member
        // ]);

        Session::flash('success', 'Akun Berhasil Dibuat');
        return redirect('/login_member');
    }

    public function login_member()
    {
        return view('auth.login_member');
    }

    public function login_member_action(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            // return response()->json([
            //     $validator->errors(), 422
            // ]);
            Session::flash('errors', $validator->errors()->toArray());
            return redirect('/login_member');
        }

        $credentials = $request->only('email', 'password');
        $member = Member::where('email', $request->email)->first();

        if ($member) {
            if (Auth::guard('webmember')->attempt($credentials)) {
                // if (Hash::check($request->password, $member->password)) {
                $request->session()->regenerate();
                // return response()->json([
                //     'message' => 'Success',
                //     'data' => $member
                // ]);
                // echo "Login Berhasil";
                return redirect('/');
            } else {
                // return response()->json([
                //     'message' => 'failed',
                //     'data' => 'Password Salah'
                // ]);
                Session::flash('failed', "Password Salah");
                return redirect('/login_member');
            }
        } else {
            // return response()->json([
            //     'message' => 'failed',
            //     'data' => 'Email Salah'
            // ]);
            Session::flash('failed', "Email Salah");
            return redirect('/login_member');
        }
    }

    public function logout()
    {
        Session::flush();
        return redirect('/login');
        // auth()->logout();
        // return response()->json(['message' => 'Successfully logged out']);
    }

    public function logout_member()
    {
        Auth::guard('webmember')->logout();
        Session::flush();
        return redirect('/');
        // redirect('/login_member');
    }
}
