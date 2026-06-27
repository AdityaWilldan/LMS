<?php 
namespace App\Http\Controllers\Api\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Mahasiswa; // <--- TAMBAHKAN IMPORT INI

class ProfilController extends Controller 
{
    public function show() 
    { 
        /** @var Mahasiswa $mhs */
        $mhs = Auth::guard('mahasiswa')->user();
        return response()->json(['data' => $mhs]); 
    }
    
    public function update(Request $request) 
    {
        /** @var Mahasiswa $mhs */
        $mhs = Auth::guard('mahasiswa')->user();
        
        $request->validate([
            'nama_mahasiswa' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:mahasiswa,email,'.$mhs->id_mahasiswa.',id_mahasiswa',
            'username' => 'required|string|max:50|unique:mahasiswa,username,'.$mhs->id_mahasiswa.',id_mahasiswa',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        $data = $request->only(['nama_mahasiswa', 'email', 'username']);
        if ($request->hasFile('foto')) {
            if ($mhs->foto && Storage::disk('public')->exists($mhs->foto)) Storage::disk('public')->delete($mhs->foto);
            $data['foto'] = $request->file('foto')->store('foto_mahasiswa', 'public');
        }
        
        $mhs->update($data);
        return response()->json(['message' => 'Profil diubah', 'data' => $mhs]);
    }

    public function changePassword(Request $request) 
    {
        $request->validate(['current_password' => 'required', 'new_password' => 'required|min:8|confirmed']);
        
        /** @var Mahasiswa $mhs */
        $mhs = Auth::guard('mahasiswa')->user();
        
        if (!Hash::check($request->current_password, $mhs->password)) return response()->json(['message' => 'Password lama salah'], 400);
        $mhs->password = Hash::make($request->new_password);
        $mhs->save();
        return response()->json(['message' => 'Password diubah']);
    }
}