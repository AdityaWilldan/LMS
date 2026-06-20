<?php
namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Mahasiswa;

class ProfilMahasiswaController extends Controller
{
    public function show()
    {
        /** @var Mahasiswa $mahasiswa */
        $mahasiswa = Auth::guard('mahasiswa')->user();
        return view('mahasiswa.profil.index', compact('mahasiswa'));
    }

    public function edit()
    {
        /** @var Mahasiswa $mahasiswa */
        $mahasiswa = Auth::guard('mahasiswa')->user();
        return view('mahasiswa.profil.edit', compact('mahasiswa'));
    }

    public function update(Request $request)
    {
        /** @var Mahasiswa $mahasiswa */
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $request->validate([
            'nama_mahasiswa' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:mahasiswa,email,'.$mahasiswa->id_mahasiswa.',id_mahasiswa',
            'username' => 'required|string|max:50|unique:mahasiswa,username,'.$mahasiswa->id_mahasiswa.',id_mahasiswa',
        ]);

        $mahasiswa->update($request->only(['nama_mahasiswa', 'email', 'username']));
        return redirect()->route('mahasiswa.profil')->with('success', 'Profil berhasil diubah');
    }

    public function changePasswordForm()
    {
        return view('mahasiswa.profil.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        /** @var Mahasiswa $mahasiswa */
        $mahasiswa = Auth::guard('mahasiswa')->user();
        if (!Hash::check($request->current_password, $mahasiswa->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah']);
        }

        $mahasiswa->password = Hash::make($request->new_password);
        $mahasiswa->save();

        return redirect()->route('mahasiswa.profil')->with('success', 'Password berhasil diubah');
    }
}