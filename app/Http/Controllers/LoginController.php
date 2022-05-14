<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
 
class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'telp_ibu' => ['required'],
            'password' => ['required'],
        ]);

 
        if (Auth::guard('siswa')->attempt($credentials)) {
            $siswa = Siswa::where('telp_ibu', $request['telp_ibu'])->firstOrFail();
            $token = $siswa->createToken('auth_token')->plainTextToken;

            $response = [
                'nama_lengkap' => $siswa->nama_lengkap,
                'kelas' => $siswa->kelas,
                'token' => $token,
            ];
    
            return response()->json(['success' => true, 'data' => $response]);
        }
 
        return back()->withErrors([
            'telp_ibu' => 'The provided credentials do not match our records.',
        ])->onlyInput('telp_ibu');
    }
}

