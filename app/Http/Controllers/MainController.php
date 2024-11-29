<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class MainController extends Controller
{
    public function __construct()
    {
        $this->middleware(['ceksession', 'refreshsession']);
    }

    public function base()
    {
        return redirect()->route('dashboard');
    }

    public function dashboard(Request $request)
    {
        return view('dashboard');
    }

    public function main_board(Request $request)
    {
        $data['date'] = date('d M Y');
        $data['peserta'] = DB::table('peserta_radir')->select('*')->where('group', 'LIKE', '%1%')->orderBy('priority', 'ASC')->orderBy('priority_number', 'ASC')->get();
        return view('main_board', compact('data'));
    }

    public function main_board_khusus(Request $request)
    {
        $data['date'] = date('d M Y');
        $data['peserta'] = DB::table('peserta_radir')->select('*')->where('group', 'LIKE', '%2%')->orderBy('priority', 'ASC')->orderBy('priority_number', 'ASC')->get();
        return view('main_board_khusus', compact('data'));
    }

    public function main_event(Request $request, $id)
    {
        $data['date'] = date('d M Y');
        $data['id'] = $id;
        $data['peserta_event'] = DB::table('peserta_event')->select('*')->where('event_id', $id)->orderBy('priority_number', 'ASC')->get();
        $data['event_list'] = DB::table('event_list')->where('id', $id)->get()->first();
        return view('main_event', compact('data'));
    }

    public function manage_admin (Request $request) 
    {
        $data['admin'] = DB::table('users')->get();
        return view('admin.manage_admin', compact('data'));
    }

    public function add_admin (Request $request, $id = NULL)
    {
        if ($id != NULL){
            $data['admin'] = DB::table('users')->where('id', $id)->select('*')->get();
        } else {
            $data = [];
            return view('admin.add_admin', compact('data'));
        }
        if (count($data['admin']) == 0){
            return redirect()->route('manage_admin')->with('error', 'Admin with ID '.$id.' Not Found, Please Check Again Your URL');
        } else {
            $data['id'] = $id;
            $data['admin'] = $data['admin']->first();
            return view('admin.add_admin', compact('data'));
        }
    }

    public function submit_admin (Request $request, $id = NULL)
    {
        $nik_tg = $request->session()->get('nik_tg');
        $datetime = date('Y-m-d H:i:s');
        $data = $request->all();
        $password = "047ff07257cc632dc6a208adb5098e57";
        if ($id != NULL){
            $check = DB::table('users')->where('id', $id)->select('*')->get();
            if (count($check) > 0){
                $update = DB::table('users')->where('id', $id)->update([
                    'nik_tg' => $data['nik_tg'],
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'updated_by' => $nik_tg,
                    'updated_at' => $datetime
                ]);
                if ($update){
                    $activity = "Edit Admin ID ".$id." Successful";
                    $status = 'SUCCESS';
                    $message = 'success';
                } else {
                    $activity = "Edit Admin Failed";
                    $status = 'ERROR';
                    $message = 'error';
                }
                $route = 'manage_admin';
            } else {
                return redirect()->route('manage_admin')->with('error', 'Admin ID Not Found');
            }
        } else {
            $insert = DB::table('users')->insertGetId([
                'nik_tg' => $data['nik_tg'],
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $password,
                'created_by' => $nik_tg,
                'created_at' => $datetime
            ]);
            if ($insert){
                $activity = "Add Admin ID ".$insert." Successful";
                $status = 'SUCCESS';
                $message = 'success';
            } else {
                $activity = "Add Admin Failed";
                $status = 'ERROR';
                $message = 'error';
            }
            $route = 'add_admin';
        }
        $log = DB::table('log')->insert([
            'nik_tg' => $nik_tg,
            'activity' => $activity,
            'status' => $status,
            'datetime' => $datetime
        ]);
        return redirect()->route($route)->with($message, $activity);
    }

    public function delete_admin (Request $request, $id = NULL)
    {
        $nik_tg = $request->session()->get('nik_tg');
        $datetime = date('Y-m-d H:i:s');
        if ($id != NULL){
            if ($id == $request->session()->get('id')){
                $activity = "Delete Admin Failed, Session Still in Use";
                $status = "ERROR";
                $message = "error";
                $return = 0;
            } else {
                $delete = DB::table('users')->where('id', $id)->delete();
                if ($delete){
                    $activity = "Delete Admin ID ".$id." Success";
                    $status = "SUCCESS";  
                    $message = "success";
                    $return = 1;  
                } else {
                    $activity = "Delete Admin Failed, ID ".$id." Not Found";
                    $status = "ERROR";
                    $message = "error";
                    $return = 0;
                }
            }
        } else {
            $activity = "Delete Admin Failed, No ID Provided";
            $status = "ERROR";
            $message = "error";
            $return = 0;
        }
        $log = DB::table('log')->insert([
            'nik_tg' => $nik_tg,
            'activity' => $activity,
            'status' => $status,
            'datetime' => $datetime
        ]);
        $request->session()->flash($message, $activity);
        return $return;
    }

    public function manage_peserta (Request $request) 
    {
        $data['peserta'] = DB::table('peserta_radir')->orderBy('priority','ASC')->orderBy('priority_number','ASC')->get();
        return view('admin.manage_peserta', compact('data'));
    }

    public function add_peserta (Request $request, $id = NULL)
    {
        if ($id != NULL){
            $data['peserta'] = DB::table('peserta_radir')->where('id', $id)->select('*')->get();
        } else {
            $data = [];
            return view('admin.add_peserta', compact('data'));
        }
        if (count($data['peserta']) == 0){
            return redirect()->route('manage_peserta')->with('error', 'Peserta Radir with ID '.$id.' Not Found, Please Check Again Your URL');
        } else {
            $data['id'] = $id;
            $data['peserta'] = $data['peserta']->first();
            $group = explode(',',$data['peserta']->group);
            if (count($group) >= 2){
                $data['group_1'] = $group[0];
                $data['group_2'] = $group[1];
            } else {
                $data['group_1'] = NULL;
                $data['group_2'] = NULL;
            }
            return view('admin.add_peserta', compact('data'));
        }
    }

    public function submit_peserta (Request $request, $id = NULL)
    {
        $nik_tg = $request->session()->get('nik_tg');
        $datetime = date('Y-m-d H:i:s');
        $data = $request->all();
        $file = $request->file('photo');
        if ($file){
            $destination = \Config::get('values.upload_url');
            $file_name = $data['nik_tg']."_".date('YmdHis').'.'.$file->getClientOriginalExtension();
            $move = $file->move($destination,$file_name);
        } else {
            if ($data['replace']){
                $move = 1;
                $file_name = NULL;
            } else {
                $move = 1;
                $file_name = $data['replace_name'];
            }
        }
        $group = '';
        if (isset($data['group_1'])){
            $group = '1';
        }
        $group .= ',';
        if (isset($data['group_2'])){
            $group .= '2';
        }
        if (!isset($data['priority'])){
            $data['priority'] = 0;
        }
        if (!isset($data['priority_number'])){
            $data['priority_number'] = 0;
        }
        if ($move){
            if ($id != NULL){
                $check = DB::table('peserta_radir')->where('id', $id)->select('*')->get();
                if (count($check) > 0){
                    $update = DB::table('peserta_radir')->where('id', $id)->update([
                        'nik_tg' => $data['nik_tg'],
                        'name' => $data['name'],
                        'unit' => $data['unit'],
                        'direktorat' => $data['direktorat'],
                        'jabatan' => $data['jabatan'],
                        'priority' => $data['priority'],
                        'priority_number' => $data['priority_number'],
                        'photo' => $file_name,
                        'group' => $group,
                        'updated_by' => $nik_tg,
                        'updated_at' => $datetime
                    ]);
                    if ($update){
                        $activity = "Edit Peserta Radir ID ".$id." Successful";
                        $status = 'SUCCESS';
                        $message = 'success';
                    } else {
                        $activity = "Edit Peserta Radir Failed";
                        $status = 'ERROR';
                        $message = 'error';
                    }
                    $route = 'manage_peserta';
                } else {
                    return redirect()->route('manage_peserta')->with('error', 'Peserta ID Not Found');
                }
            } else {
                $insert = DB::table('peserta_radir')->insertGetId([
                    'nik_tg' => $data['nik_tg'],
                    'name' => $data['name'],
                    'unit' => $data['unit'],
                    'direktorat' => $data['direktorat'],
                    'jabatan' => $data['jabatan'],
                    'priority' => $data['priority'],
                    'priority_number' => $data['priority_number'],
                    'photo' => $file_name,
                    'group' => $group,
                    'created_by' => $nik_tg,
                    'created_at' => $datetime
                ]);
                if ($insert){
                    $activity = "Add Peserta Radir ID ".$insert." Successful";
                    $status = 'SUCCESS';
                    $message = 'success';
                } else {
                    $activity = "Add Peserta Radir Failed";
                    $status = 'ERROR';
                    $message = 'error';
                }
                $route = 'add_peserta';
            }
        } else {
            $activity = "Upload Error, Please Contact Team IT";
            $status = 'ERROR';
            $message = 'error';
        }
        $log = DB::table('log')->insert([
            'nik_tg' => $nik_tg,
            'activity' => $activity,
            'status' => $status,
            'datetime' => $datetime
        ]);
        return redirect()->route($route)->with($message, $activity);
    }

    public function delete_peserta (Request $request, $id = NULL)
    {
        $nik_tg = $request->session()->get('nik_tg');
        $datetime = date('Y-m-d H:i:s');
        if ($id != NULL){
            $delete = DB::table('peserta_radir')->where('id', $id)->delete();
            if ($delete){
                $activity = "Delete Peserta Radir ID ".$id." Success";
                $status = "SUCCESS";  
                $message = "success";
                $return = 1;  
            } else {
                $activity = "Delete Peserta Radir Failed, ID ".$id." Not Found";
                $status = "ERROR";
                $message = "error";
                $return = 0;
            }
        } else {
            $activity = "Delete Peserta Radir Failed, No ID Provided";
            $status = "ERROR";
            $message = "error";
            $return = 0;
        }
        $log = DB::table('log')->insert([
            'nik_tg' => $nik_tg,
            'activity' => $activity,
            'status' => $status,
            'datetime' => $datetime
        ]);
        $request->session()->flash($message, $activity);
        return $return;
    }

    public function manage_peserta_event (Request $request) 
    {
        $data['peserta_event'] = DB::table('peserta_event as pe')
                                    ->leftJoin('event_list as el', 'el.id', '=', 'pe.event_id')
                                    ->leftJoin('event_priority as ep', function($join)
                                    {
                                        $join->on('ep.event_id', '=', 'pe.event_id');
                                        $join->on('ep.priority','=','pe.priority');
                                    })
                                    ->select(
                                        'pe.*',
                                        'el.event',
                                        'ep.priority_name'
                                    )
                                    ->orderBy('priority','ASC')
                                    ->orderBy('priority_number','ASC')->get();
        return view('admin.manage_peserta_event', compact('data'));
    }

    public function add_peserta_event (Request $request, $id = NULL)
    {
        $event_id = 1;
        $data['event'] = DB::table('event_list')->select('*')->get();
        $data['event_priority'] = DB::table('event_priority')->where('event_id', $event_id)->select('*')->get();
        if ($id != NULL){
            $data['peserta_event'] = DB::table('peserta_event')->where('id', $id)->select('*')->get();
        } else {
            // $data = [];
            return view('admin.add_peserta_event', compact('data'));
        }
        if (count($data['peserta_event']) == 0){
            return redirect()->route('manage_peserta_event')->with('error', 'Peserta Event with ID '.$id.' Not Found, Please Check Again Your URL');
        } else {
            $data['id'] = $id;
            $data['peserta_event'] = $data['peserta_event']->first();
            return view('admin.add_peserta_event', compact('data'));
        }
    }

    public function submit_peserta_event (Request $request, $id = NULL)
    {
        $nik_tg = $request->session()->get('nik_tg');
        $datetime = date('Y-m-d H:i:s');
        $data = $request->all();
        $event_id = $data['event_id'];
        $file = $request->file('photo');
        if ($file){
            $destination = \Config::get('values.upload_url');
            $file_name = $data['nik_tg']."_".date('YmdHis').'.'.$file->getClientOriginalExtension();
            $move = $file->move($destination,$file_name);
        } else {
            if ($data['replace']){
                $move = 1;
                $file_name = NULL;
            } else {
                $move = 1;
                $file_name = $data['replace_name'];
            }
        }
        $group = '';
        if (isset($data['group_1'])){
            $group = '1';
        }
        $group .= ',';
        if (isset($data['group_2'])){
            $group .= '2';
        }
        if (!isset($data['priority'])){
            $data['priority'] = 0;
        }
        if (!isset($data['priority_number'])){
            $data['priority_number'] = 0;
        }
        if ($move){
            if ($id != NULL){
                $check = DB::table('peserta_event')->where('id', $id)->select('*')->get();
                if (count($check) > 0){
                    $update = DB::table('peserta_event')->where('id', $id)->update([
                        'event_id' => $event_id,
                        'nik_tg' => $data['nik_tg'],
                        'name' => $data['name'],
                        'posisi' => $data['posisi'],
                        'company' => $data['company'],
                        'priority' => $data['priority'],
                        'priority_number' => $data['priority_number'],
                        'photo' => $file_name,
                        'updated_by' => $nik_tg,
                        'updated_at' => $datetime
                    ]);
                    if ($update){
                        $activity = "Edit Peserta Event ID ".$id." Successful";
                        $status = 'SUCCESS';
                        $message = 'success';
                    } else {
                        $activity = "Edit Peserta Event Failed";
                        $status = 'ERROR';
                        $message = 'error';
                    }
                    $route = 'manage_peserta_event';
                } else {
                    return redirect()->route('manage_peserta_event')->with('error', 'Peserta ID Not Found');
                }
            } else {
                $insert = DB::table('peserta_event')->insertGetId([
                    'event_id' => $event_id,
                    'nik_tg' => $data['nik_tg'],
                    'name' => $data['name'],
                    'posisi' => $data['posisi'],
                    'company' => $data['company'],
                    'priority' => $data['priority'],
                    'priority_number' => $data['priority_number'],
                    'photo' => $file_name,
                    'created_by' => $nik_tg,
                    'created_at' => $datetime
                ]);
                if ($insert){
                    $activity = "Add Peserta Event ID ".$insert." Successful";
                    $status = 'SUCCESS';
                    $message = 'success';
                } else {
                    $activity = "Add Peserta Event Failed";
                    $status = 'ERROR';
                    $message = 'error';
                }
                $route = 'add_peserta_event';
            }
        } else {
            $activity = "Upload Error, Please Contact Team IT";
            $status = 'ERROR';
            $message = 'error';
        }
        $log = DB::table('log')->insert([
            'nik_tg' => $nik_tg,
            'activity' => $activity,
            'status' => $status,
            'datetime' => $datetime
        ]);
        return redirect()->route($route)->with($message, $activity);
    }

    public function delete_peserta_event (Request $request, $id = NULL)
    {
        $nik_tg = $request->session()->get('nik_tg');
        $datetime = date('Y-m-d H:i:s');
        if ($id != NULL){
            $delete = DB::table('peserta_event')->where('id', $id)->delete();
            if ($delete){
                $activity = "Delete Peserta Event ID ".$id." Success";
                $status = "SUCCESS";  
                $message = "success";
                $return = 1;  
            } else {
                $activity = "Delete Peserta Event Failed, ID ".$id." Not Found";
                $status = "ERROR";
                $message = "error";
                $return = 0;
            }
        } else {
            $activity = "Delete Peserta Event Failed, No ID Provided";
            $status = "ERROR";
            $message = "error";
            $return = 0;
        }
        $log = DB::table('log')->insert([
            'nik_tg' => $nik_tg,
            'activity' => $activity,
            'status' => $status,
            'datetime' => $datetime
        ]);
        $request->session()->flash($message, $activity);
        return $return;
    }

    public function download_excel (Request $request){
        $data['excel'] = DB::table('absen_radir')->select(DB::raw("DISTINCT( DATE(datetime)) as date_radir"))
                                                ->orderBy('date_radir', 'DESC')
                                        ->get();
        return view('admin.download_excel', compact('data'));
    }

    public function download_excel_list (Request $request, $date){
        $data['date'] = $date;
        $data['absen'] = DB::table('absen_radir')->select('*')
                                                ->where(DB::raw('DATE(datetime)'), $date)
                                                ->get();
        return view('api.download_excel_list', compact('data'));
    }

    public function reset_absen (Request $request){
        $date = date('Y-m-d');
        $nik_tg = $request->session()->get('nik_tg');
        $activity = 'Reset Absen Tanggal '.$date.' Berhasil';
        $status = 'SUCCESS';
        $datetime = date('Y-m-d H:i:s');
        $delete = DB::table('absen_radir')->where(DB::raw('DATE(datetime)'), $date)->delete();
        $log = DB::table('log')->insert([
            'nik_tg' => $nik_tg,
            'activity' => $activity,
            'status' => $status,
            'datetime' => $datetime
        ]);
        $request->session()->flash('success', $activity);
        return $delete;
    }

    public function reset_absen_event (Request $request, $id){
        $date = date('Y-m-d');
        $nik_tg = $request->session()->get('nik_tg');
        $activity = 'Reset Absen Event '.$id.' Tanggal '.$date.' Berhasil';
        $status = 'SUCCESS';
        $datetime = date('Y-m-d H:i:s');
        $delete = DB::table('absen_event')->where('event_id', $id)->where(DB::raw('DATE(datetime)'), $date)->delete();
        $log = DB::table('log')->insert([
            'nik_tg' => $nik_tg,
            'activity' => $activity,
            'status' => $status,
            'datetime' => $datetime
        ]);
        $request->session()->flash('success', $activity);
        return $delete;
    }
}
