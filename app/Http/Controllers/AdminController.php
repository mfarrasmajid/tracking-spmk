<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\SSPManageUsers;
use App\Traits\SSPManageSOW;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExcelImport;
use DB;

class AdminController extends Controller
{
    use SSPManageUsers;
    use SSPManageSOW;

    public function __construct()
    {
        $this->middleware(['ceksession', 'cekadmin',  'refreshsession']);
    }

    public function get_list_manage_users() { return $this->list_manage_users(); }
    public function get_list_manage_sow() { return $this->list_manage_sow(); }

    public function manage_users(Request $request) {
        $data = array();
        return view('admin.manage_users', compact('data'));
    }

    public function detail_users(Request $request, $id = NULL){
        $data = array();
        if ($id != NULL){
            $data['u'] = DB::table('master_special_privilege')->select('*')->where('id', $id)->get();
            if (count($data['u']) > 0){
                $data['u'] = $data['u']->first();
                $data['id'] = $id;
                return view('admin.detail_users', compact('data'));
            } else {
                return redirect()->route('manage_users')->with('error', 'User ID tidak ditemukan!');
            }
        } else {
            return view('admin.detail_users', compact('data'));
        }
    }

    public function submit_users(Request $request, $id = NULL){
        $nik_tg = $request->session()->get('user')->nik_tg;
        $datetime = date('Y-m-d H:i:s');
        $input = $request->all();
        if ($id == NULL){
            $insert = DB::table('master_special_privilege')->insertGetId([
                'nik_tg' => $input['nik_tg']
            ]);
            $activity = 'Success Insert Special Privilege NIK TG '.$input['nik_tg'];
            $status = 'SUCCESS';
            DB::table('log')->insert([
                'nik_tg' => $nik_tg,
                'activity' => $activity,
                'status' => $status,
                'datetime' => $datetime
            ]);
        } else {
            $update = DB::table('master_special_privilege')->where('id', $id)->update([
                'nik_tg' => $input['nik_tg']
            ]);
            $activity = 'Success Update Special Privilege ID '.$id.' NIK TG '.$input['nik_tg'];
            $status = 'SUCCESS';
            DB::table('log')->insert([
                'nik_tg' => $nik_tg,
                'activity' => $activity,
                'status' => $status,
                'datetime' => $datetime
            ]);
        }
        if ($id != NULL){
            return redirect()->route('detail_users', ['id' => $id])->with('success', 'Update user special privilege berhasil.');
        } else {
            return redirect()->route('detail_users')->with('success', 'Insert user special privilege berhasil.');
        }
    }

    public function delete_users(Request $request, $id){
        $nik_tg = $request->session()->get('user')->nik_tg;
        $datetime = date('Y-m-d H:i:s');
        $delete = DB::table('master_special_privilege')->where('id', $id)->delete();
        $activity = 'Delete Special Privilege ID '.$id;
        $status = 'SUCCESS';
        DB::table('log')->insert([
                        'nik_tg' => $nik_tg,
                        'activity' => $activity,
                        'status' => $status,
                        'datetime' => $datetime
                    ]);
        $request->session()->flash('success', 'Special privilege berhasil dihapus.');
        return 1;
    }

    public function manage_sow(Request $request) {
        $data = array();
        return view('admin.manage_sow', compact('data'));
    }

    public function detail_sow(Request $request, $id = NULL){
        $data = array();
        if ($id != NULL){
            $data['u'] = DB::table('master_sow')->select('*')->where('id', $id)->get();
            if (count($data['u']) > 0){
                $data['u'] = $data['u']->first();
                $data['id'] = $id;
                return view('admin.detail_sow', compact('data'));
            } else {
                return redirect()->route('manage_sow')->with('error', 'SOW tidak ditemukan!');
            }
        } else {
            return view('admin.detail_sow', compact('data'));
        }
    }

    public function submit_sow(Request $request, $id = NULL){
        $nik_tg = $request->session()->get('user')->nik_tg;
        $datetime = date('Y-m-d H:i:s');
        $input = $request->all();
        if ($id == NULL){
            $insert = DB::table('master_sow')->insertGetId([
                'sow' => $input['sow']
            ]);
            $activity = 'Success Insert SOW '.$input['sow'];
            $status = 'SUCCESS';
            DB::table('log')->insert([
                'nik_tg' => $nik_tg,
                'activity' => $activity,
                'status' => $status,
                'datetime' => $datetime
            ]);
        } else {
            $update = DB::table('master_sow')->where('id', $id)->update([
                'sow' => $input['sow']
            ]);
            $activity = 'Success Update SOW ID '.$id.' SOW '.$input['sow'];
            $status = 'SUCCESS';
            DB::table('log')->insert([
                'nik_tg' => $nik_tg,
                'activity' => $activity,
                'status' => $status,
                'datetime' => $datetime
            ]);
        }
        if ($id != NULL){
            return redirect()->route('detail_sow', ['id' => $id])->with('success', 'Update SOW berhasil.');
        } else {
            return redirect()->route('detail_sow')->with('success', 'Insert SOW berhasil.');
        }
    }

    public function delete_sow(Request $request, $id){
        $nik_tg = $request->session()->get('user')->nik_tg;
        $datetime = date('Y-m-d H:i:s');
        $delete = DB::table('master_sow')->where('id', $id)->delete();
        $activity = 'Delete SOW ID '.$id;
        $status = 'SUCCESS';
        DB::table('log')->insert([
                        'nik_tg' => $nik_tg,
                        'activity' => $activity,
                        'status' => $status,
                        'datetime' => $datetime
                    ]);
        $request->session()->flash('success', 'SOW berhasil dihapus.');
        return 1;
    }

    public function upload_spmk (Request $request){
        $data = array();
        return view('admin.upload_spmk', compact('data'));
    }

    public function submit_upload_spmk (Request $request){
        set_time_limit(0);
        $nik_tg = $request->session()->get('user')->nik_tg;
        $datetime = date('Y-m-d H:i:s');
        $input = $request->all();
        if ($request->has('excel')) {
            $file = $request->file('excel');
            $ext = $file->getClientOriginalExtension();
            if (($ext == 'xls') || ($ext == 'xlsx') || ($ext == 'XLS') || ($ext == 'XLSX')) {
                $array_file = Excel::toArray(new ExcelImport, $file);
                $success = 0;
                foreach ($array_file[0] as $key => $row) {
                    if ($key != 0){
                        if ((trim($row[0]) != '') &&
                            (trim($row[1]) != '') &&
                            (trim($row[2]) != '') &&
                            (trim($row[3]) != '') &&
                            (trim($row[4]) != '') &&
                            (trim($row[5]) != '') &&
                            (trim($row[6]) != '') &&
                            (trim($row[7]) != '') &&
                            (trim($row[8]) != '') &&
                            (trim($row[9]) != '') &&
                            (trim($row[10]) != '') &&
                            (trim($row[11]) != '') &&
                            (trim($row[12]) != '') &&
                            (trim($row[13]) != '') &&
                            (trim($row[14]) != '') &&
                            (trim($row[15]) != '')) {
                            $check = DB::table('document_tracking')->where('pid', trim($row[0]))
                                                                 ->where('site_name', trim($row[1]))
                                                                 ->where('region', trim($row[2]))
                                                                 ->where('scope', trim($row[3]))
                                                                 ->where('amount', trim($row[4]))
                                                                 ->where('supplier_name', trim($row[5]))
                                                                 ->where('spmk', trim($row[6]))
                                                                 ->where('pm_nik', trim($row[7]))
                                                                 ->where('mgr_region_nik', trim($row[8]))
                                                                 ->where('gm_area_nik', trim($row[9]))
                                                                 ->where('mgr_cons_nik', trim($row[10]))
                                                                 ->where('gm_cons_nik', trim($row[11]))
                                                                 ->where('mgr_proc_nik', trim($row[12]))
                                                                 ->where('vp_proc_nik', trim($row[13]))
                                                                 ->where('se_nik', trim($row[14]))
                                                                 ->where('off_proc_nik', trim($row[15]))
                                                                 ->select()
                                                                 ->get();
                            if (count($check) == 0){
                                $insert = DB::table('document_tracking')->insertGetId([
                                    'pid' => trim($row[0]),
                                    'site_name' => trim($row[1]),
                                    'region' => trim($row[2]),
                                    'scope' => trim($row[3]),
                                    'amount' => trim($row[4]),
                                    'supplier_name' => trim($row[5]),
                                    'spmk' => trim($row[6]),
                                    'pm_nik' => trim($row[7]),
                                    'mgr_region_nik' => trim($row[8]),
                                    'gm_area_nik' => trim($row[9]),
                                    'mgr_cons_nik' => trim($row[10]),
                                    'gm_cons_nik' => trim($row[11]),
                                    'mgr_proc_nik' => trim($row[12]),
                                    'vp_proc_nik' => trim($row[13]),
                                    'se_nik' => trim($row[14]),
                                    'off_proc_nik' => trim($row[15]),
                                    'id_status' => 1,
                                    'created_at' => date('Y-m-d H:i:s'),
                                ]);
                                $success++;
                            }
                        }
                    }
                }
                $notifier = 'success';
                $message = 'Berhasil mengupload ' . $success . ' pid';
                $activity = 'Success Upload Bulk SPMK, ' . $success . ' PID';
                $status = 'SUCCESS';
                $datetime = date('Y-m-d H:i:s');
                DB::table('log')->insert([
                    'nik_tg' => $nik_tg,
                    'activity' => $activity,
                    'status' => $status,
                    'datetime' => $datetime
                ]);
                return redirect()->route('upload_spmk')->with($notifier, $message);
            } else {
                return redirect()->route('upload_spmk')->with('error', 'Mohon upload file dengan extension yang sesuai');
            }
        } else {
            return redirect()->route('upload_spmk')->with('error', 'Mohon upload file yang sesuai');
        }
    }

    public function deactivate_pid (Request $request, $id){
        $nik_tg = $request->session()->get('user')->nik_tg;
        $datetime = date('Y-m-d H:i:s');
        $delete = DB::table('document_tracking')->where('id', $id)->update([
            'id_status' => 12
        ]);
        $activity = 'Deactivate PID, ID '.$id;
        $status = 'SUCCESS';
        DB::table('log')->insert([
                        'nik_tg' => $nik_tg,
                        'activity' => $activity,
                        'status' => $status,
                        'datetime' => $datetime
                    ]);
        $request->session()->flash('success', 'PID berhasi dideactivate');
        return 1;
    }
}
