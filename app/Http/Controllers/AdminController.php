<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Reimbursement;
use App\Models\ReimbursementHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $users = User::whereNot('id',$user->id)->get();
        if($user->role == 'staff'){
            $reimbursement = Reimbursement::where('from_user',$user->id)->get();
        }else{
            $reimbursement = ReimbursementHistory::where('user_id',$user->id)
            ->with('reimbursement')
            ->get();
        }
        return view('admin.dashboard',compact('users','reimbursement'));
    }

    public function formEditUser(Request $request,$id)
    {
       $user = User::where('id',$id)->first();
       return view('admin.update_users',compact('user'));
    }

    public function formTambahUser(Request $request)
    {
       return view('admin.tambah_user');
    }

    public function formReimbursement(Request $request)
    {
       return view('admin.tambah_reimbursement');
    }
    
    public function updateUser(Request $request)
    {
        $userid     = $request->get('iduser');
        $name       = $request->get('name');
        $email       = $request->get('email');
        $nip        = $request->get('nip');
        $role       = $request->get('jabatan');
        $jabatan    = strtoupper($role);

        $ceknip = User::whereNot('id',$userid)->where('nip',$nip)->first();

        if($ceknip) return response()->json(['status' => 'error', 'msg' => 'NIP sudah dipakai!'], 401);

        $update = User::where('id',$userid)->update([
            'name' => $name,
            'email' => $email,
            'nip' => $nip,
            'role' => $role,
            'jabatan' => $jabatan
        ]);
        if($update){
            return response()->json(['status' => 'success', 'msg' => 'update user sukses!'], 200);
        }else{
            return response()->json(['status' => 'error', 'msg' => 'update user gagal!'], 401);
        }
    }

    public function tambahUser(Request $request)
    {
        $userid     = $request->get('iduser');
        $name       = $request->get('name');
        $email       = $request->get('email');
        $nip        = $request->get('nip');
        $role       = $request->get('jabatan');
        $jabatan    = strtoupper($role);
        $password  = Hash::make($request->get('password'));

        $ceknip = User::where('nip',$nip)->first();

        if($ceknip) return response()->json(['status' => 'error', 'msg' => 'NIP sudah dipakai!'], 401);

        $create = User::create([
            'name' => $name,
            'email' => $email,
            'nip' => $nip,
            'role' => $role,
            'jabatan' => $jabatan,
            'password' => $password 
        ]);
        if($create){
            return response()->json(['status' => 'success', 'msg' => 'tambah user sukses!'], 200);
        }else{
            return response()->json(['status' => 'error', 'msg' => 'tambah user gagal!'], 401);
        }
    }

    public function deleteUser(Request $request)
    {
        $id = $request->get('id');
        $deleteUser = User::where('id',$id)->delete();
        $deleteReimburstement = Reimbursement::where('from_user',$id)->delete();
        $deleteReimburstement = ReimbursementHistory::where('user_own',$id)->delete();

        return response()->json(['status' => 'success', 'msg' => 'hapus user sukses!'], 200);
    }

    public function tambahReimbursement(Request $request)
    {
        $request->validate([
            'file_pendukung' => 'required|file|max:10240', // max 10MB file size, adjust as needed
        ]);

		$file = $request->file('file_pendukung');
		$nama_file = time()."_".$file->getClientOriginalName();
 		$tujuan_upload = 'reimbursement';
		$file->move($tujuan_upload,$nama_file);

        $user = Auth::user();
        $tanggal = $request->get('tanggal');
        $nama_r = $request->get('nama_r');
        $deskripsi = $request->get('deskripsi');
        $direktur = User::where('role','direktur')->first();

        $create = Reimbursement::create([
            'from_user' => $user->id,
            'status' => 'to_direktur',
            'to_user' => $direktur->id ,
            'file' => $nama_file,       
            'name' => $nama_r,       
            'description' => $deskripsi,       
            'tanggal' => $tanggal,       
        ]);
        $createHistory = ReimbursementHistory::create([
            'id_reimbursement' => $create->id,
            'user_id' => $direktur->id,
            'status' => 'to_direktur',
            'deskripsi' => 'Reimbursement created and sent to direktur',
            'user_own' => $user->id
        ]);

        if($create){
            return response()->json(['status' => 'success', 'msg' => 'tambah reimbursement baru sukses!'], 200);
        }else{
            return response()->json(['status' => 'error', 'msg' => 'tambah reimbursement baru gagal!'], 401);
        }
    }
    

    public function aprroveReimbursement(Request $request)
    {
        $user = Auth::user();
        $id =  $request->get('id');
        $reim = Reimbursement::where('id',$id)->first();

        if($user->role == 'direktur'){
            $finance = User::where('role','finance')->first();
            $update = Reimbursement::where('id',$id)->update([
                    'status' => 'to_finance',
                    'to_user' => $finance->id
            ]);
            $createHistory = ReimbursementHistory::create([
                'id_reimbursement' => $id,
                'user_id' => $finance->id,
                'status' => 'to_finance',
                'deskripsi' => 'Reimbursement sent to finance',
                'user_own' => $reim->from_user
            ]);

            if($update){
                return response()->json(['status' => 'success', 'msg' => 'update reimbursement sukses!'], 200);
            }else{
                return response()->json(['status' => 'error', 'msg' => 'update reimbursement gagal!'], 401);
            }
        }else{
            $update = Reimbursement::where('id',$id)->update([
                'status' => 'approved',
                'to_user' => $reim->from_user
            ]);

            if($update){
                return response()->json(['status' => 'success', 'msg' => 'update reimbursement sukses!'], 200);
            }else{
                return response()->json(['status' => 'error', 'msg' => 'update reimbursement gagal!'], 401);
            }
        }
    }

    public function rejectReimbursement(Request $request)
    {
        $user = Auth::user();
        $id =  $request->get('id');
        $rejectionReason = $request->get('rejectionReason');
        $update = Reimbursement::where('id',$id)->update([
            'status' => 'rejected',
            'keterangan_ditolak' => $rejectionReason
         ]);
         if($update){
            return response()->json(['status' => 'success', 'msg' => 'update reimbursement sukses!'], 200);
        }else{
            return response()->json(['status' => 'error', 'msg' => 'update reimbursement gagal!'], 401);
        }
    }
}
