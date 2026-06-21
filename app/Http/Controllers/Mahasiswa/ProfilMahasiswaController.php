<?php
namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // maks 2MB
        ]);

        $data = $request->only(['nama_mahasiswa', 'email', 'username']);

        // Upload foto jika ada
    if ($request->hasFile('foto')) {
        // Hapus foto lama jika ada
        if ($mahasiswa->foto && Storage::disk('public')->exists($mahasiswa->foto)) {
            Storage::disk('public')->delete($mahasiswa->foto);
        }
        // Simpan foto baru dengan disk public, path tanpa 'public/'
        $path = $request->file('foto')->store('foto_mahasiswa', 'public');
        $data['foto'] = $path; // 'foto_mahasiswa/nama_file.jpg'
    }

        $mahasiswa->update($data);
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