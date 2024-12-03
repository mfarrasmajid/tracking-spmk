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
        $special = DB::table('master_special_privilege')->select('*')->get();
        $special_nik = [];
        foreach($special as $s){
            $special_nik[] = $s->nik_tg;
        }
        $nik_tg = $request->session()->get('user')->nik_tg;
        $data['dashboard'] = DB::table('document_tracking as d')->select(
                                                                DB::raw('COUNT(d.id) as count'),
                                                                'd.region',
                                                                'ms.status'
                                                            )->where(function ($query) use ($nik_tg, $special_nik) {
                                                                $query->where('pm_nik', '=' , $nik_tg)
                                                                    ->orWhere('mgr_region_nik', '=', $nik_tg)
                                                                    ->orWhere('gm_area_nik', '=', $nik_tg)
                                                                    ->orWhere('mgr_cons_nik', '=', $nik_tg)
                                                                    ->orWhere('gm_cons_nik', '=', $nik_tg)
                                                                    ->orWhere('mgr_proc_nik', '=', $nik_tg)
                                                                    ->orWhere('vp_proc_nik', '=', $nik_tg)
                                                                    ->orWhere('off_proc_nik', '=', $nik_tg)
                                                                    ->orWhereIn(DB::raw($nik_tg), $special_nik)
                                                                    ;
                                                            })
                                                            ->leftJoin('master_status as ms', 'ms.id', '=', 'd.id_status')
                                                            ->orderBy('d.region', 'asc')
                                                            ->groupBy('d.region', 'ms.status')
                                                            ->get();
        $data['all_status'] = DB::table('master_status')->select('*')->get();
        $data['all_region'] = DB::table('master_area')->select('*')->orderBy('id','asc')->get();
        foreach($data['all_region'] as $r){
            foreach($data['all_status'] as $s){
                $data['count'][$r->region][$s->status] = 0;
            }
        }
        foreach($data['dashboard'] as $d){
            $data['count'][$d->region][$d->status] = $d->count;
        }
        return view('dashboard', compact('data'));
    }

    public function list_document(Request $request){
        if ($request->has('region')){
            $data['q_region'] = $request->query('region');
        }
        if ($request->has('status')){
            $data['q_status'] = $request->query('status');
        }
        $special = DB::table('master_special_privilege')->select('*')->get();
        $special_nik = [];
        foreach($special as $s){
            $special_nik[] = $s->nik_tg;
        }
        $nik_tg = $request->session()->get('user')->nik_tg;
        $data['document'] = DB::table('document_tracking as d')->select(
                                                                'd.*',
                                                                'ms.status',
                                                                'ms.class'
                                                            )->where(function ($query) use ($nik_tg, $special_nik) {
                                                                $query->where('pm_nik', '=' , $nik_tg)
                                                                    ->orWhere('mgr_region_nik', '=', $nik_tg)
                                                                    ->orWhere('gm_area_nik', '=', $nik_tg)
                                                                    ->orWhere('mgr_cons_nik', '=', $nik_tg)
                                                                    ->orWhere('gm_cons_nik', '=', $nik_tg)
                                                                    ->orWhere('mgr_proc_nik', '=', $nik_tg)
                                                                    ->orWhere('vp_proc_nik', '=', $nik_tg)
                                                                    ->orWhere('off_proc_nik', '=', $nik_tg)
                                                                    ->orWhereIn(DB::raw($nik_tg), $special_nik)
                                                                    ;
                                                            })
                                                            ->leftJoin('master_status as ms', 'ms.id', '=', 'd.id_status')
                                                            ->orderBy('d.id_status', 'asc')
                                                            ->get();
        foreach($data['document'] as $key => $d){
            if ($d->off_proc_date != null){
                $data['document'][$key]->last_date = $d->off_proc_date;
            } else if ($d->vp_proc_date != null){
                $data['document'][$key]->last_date = $d->vp_proc_date;
            } else if ($d->mgr_proc_date != null){
                $data['document'][$key]->last_date = $d->mgr_proc_date;
            } else if ($d->gm_cons_date != null){
                $data['document'][$key]->last_date = $d->gm_cons_date;
            } else if ($d->mgr_cons_date != null){
                $data['document'][$key]->last_date = $d->mgr_cons_date;
            } else if ($d->gm_area_date != null){
                $data['document'][$key]->last_date = $d->gm_area_date;
            } else if ($d->mgr_region_date != null){
                $data['document'][$key]->last_date = $d->mgr_region_date;
            } else if ($d->pm_date != null){
                $data['document'][$key]->last_date = $d->pm_date;
            } else {
                $data['document'][$key]->last_date = $d->created_at;
            }
        }
        $data['all_status'] = DB::table('master_status')->select('*')->get();
        $data['all_region'] = DB::table('master_area')->select('*')->orderBy('id','asc')->get();
        $data['all_scope'] = DB::table('document_tracking')->select(DB::raw('DISTINCT scope as scope'))->orderBy('scope','asc')->get();
        $data['all_supplier_name'] = DB::table('document_tracking')->select(DB::raw('DISTINCT supplier_name as supplier_name'))->orderBy('supplier_name','asc')->get();
        return view('list_document', compact('data'));
    }

    public function detail_list_document (Request $request, $id){
        $nik_tg = $request->session()->get('user')->nik_tg;
        $special = DB::table('master_special_privilege')->select('*')->get();
        $special_nik = [];
        foreach($special as $s){
            $special_nik[] = $s->nik_tg;
        }
        $data['document'] = DB::table('document_tracking as d')->select(
                                                                'd.*',
                                                                'ms.status',
                                                                'ms.class'
                                                            )->where(function ($query) use ($nik_tg, $special_nik) {
                                                                $query->where('pm_nik', '=' , $nik_tg)
                                                                    ->orWhere('mgr_region_nik', '=', $nik_tg)
                                                                    ->orWhere('gm_area_nik', '=', $nik_tg)
                                                                    ->orWhere('mgr_cons_nik', '=', $nik_tg)
                                                                    ->orWhere('gm_cons_nik', '=', $nik_tg)
                                                                    ->orWhere('mgr_proc_nik', '=', $nik_tg)
                                                                    ->orWhere('vp_proc_nik', '=', $nik_tg)
                                                                    ->orWhere('off_proc_nik', '=', $nik_tg)
                                                                    ->orWhereIn(DB::raw($nik_tg), $special_nik)
                                                                    ;
                                                            })->where('d.id', $id)
                                                            ->leftJoin('master_status as ms', 'ms.id', '=', 'd.id_status')
                                                            ->orderBy('d.id_status', 'asc')
                                                            ->get();
        if (count($data['document']) == 0){
            return redirect()->route('dashboard')->with('error', 'Data dokumen tidak ditemukan, mohon cek kembali URL anda');
        }
        $data['document'] = $data['document']->first();
        $d = $data['document'];
        if ($d->off_proc_date != null){
            $data['document']->last_date = $d->off_proc_date;
        } elseif ($d->vp_proc_date != null){
            $data['document']->last_date = $d->vp_proc_date;
        } else if ($d->mgr_proc_date != null){
            $data['document']->last_date = $d->mgr_proc_date;
        } else if ($d->gm_cons_date != null){
            $data['document']->last_date = $d->gm_cons_date;
        } else if ($d->mgr_cons_date != null){
            $data['document']->last_date = $d->mgr_cons_date;
        } else if ($d->gm_area_date != null){
            $data['document']->last_date = $d->gm_area_date;
        } else if ($d->mgr_region_date != null){
            $data['document']->last_date = $d->mgr_region_date;
        } else if ($d->pm_date != null){
            $data['document']->last_date = $d->pm_date;
        } else {
            $data['document']->last_date = $d->created_at;
        }
        $data['aging'] = floor((strtotime(now()) - strtotime($data['document']->last_date)) / 86400);
        $doc = $data['document'];
        if ($doc->off_proc_date != null){
            $data['latest_document'] = explode('|', $doc->off_proc_doc);
        } else if ($doc->vp_proc_date != null){
            $data['latest_document'] = explode('|', $doc->vp_proc_doc);
        } else if ($doc->mgr_proc_date != null){
            $data['latest_document'] = explode('|', $doc->mgr_proc_doc);
        } else if ($doc->gm_cons_date != null){
            $data['latest_document'] = explode('|', $doc->gm_cons_doc);
        } else if ($doc->mgr_cons_date != null){
            $data['latest_document'] = explode('|', $doc->mgr_cons_doc);
        } else if ($doc->gm_area_date != null){
            $data['latest_document'] = explode('|', $doc->gm_area_doc);
        } else if ($doc->mgr_region_date != null){
            $data['latest_document'] = explode('|', $doc->mgr_region_doc);
        } else if ($doc->pm_date != null){
            $data['latest_document'] = explode('|', $doc->pm_doc);
        } else {
            $data['latest_document'] = [];
        }
        $data['privilege'] = 0;
        $data['privilege_proc'] = 0;
        // if (($nik_tg == '935378') && ($doc->id_status != 8)){
        //     $data['privilege'] = 1;
        //     if ($doc->id_status == 1){
        //         $data['latest_pic'] = 'PM';
        //     } else if ($doc->id_status == 2){
        //         $data['latest_pic'] = 'MGR Regional';
        //     } else if ($doc->id_status == 3){
        //         $data['latest_pic'] = 'GM Area';
        //     } else if ($doc->id_status == 4){
        //         $data['latest_pic'] = 'MGR Construction';
        //     } else if ($doc->id_status == 5){
        //         $data['latest_pic'] = 'GM Construction';
        //     } else if ($doc->id_status == 6){
        //         $data['latest_pic'] = 'MGR Procurement';
        //         $data['privilege_proc'] = 1;
        //     } else if ($doc->id_status == 7){
        //         $data['latest_pic'] = 'VP Procurement';
        //     }
        // }
        if (($doc->id_status == 1) && ($doc->pm_nik == $nik_tg)){
            $data['privilege'] = 1;
            $data['latest_pic'] = 'PM';
        }
        if (($doc->id_status == 2) && ($doc->mgr_region_nik == $nik_tg)){
            $data['privilege'] = 1;
            $data['latest_pic'] = 'MGR Regional';
        }
        if (($doc->id_status == 3) && ($doc->gm_area_nik == $nik_tg)){
            $data['privilege'] = 1;
            $data['latest_pic'] = 'GM Area';
        }
        if (($doc->id_status == 4) && ($doc->mgr_cons_nik == $nik_tg)){
            $data['privilege'] = 1;
            $data['latest_pic'] = 'MGR Construction';
        }
        if (($doc->id_status == 5) && ($doc->gm_cons_nik == $nik_tg)){
            $data['privilege'] = 1;
            $data['latest_pic'] = 'GM Construction';
        }
        if (($doc->id_status == 6) && ($doc->mgr_proc_nik == $nik_tg)){
            $data['privilege'] = 1;
            $data['latest_pic'] = 'MGR Procurement';
            $data['privilege_proc'] = 1;
        }
        if (($doc->id_status == 7) && ($doc->vp_proc_nik == $nik_tg)){
            $data['privilege'] = 1;
            $data['latest_pic'] = 'VP Procurement';
        }
        if (($doc->id_status == 8) && ($doc->off_proc_nik == $nik_tg)){
            $data['privilege'] = 1;
            $data['latest_pic'] = 'Officer Procurement';
        }
        $pm = ['745491', '785582', '785789', '785886', '806040', '825809', '825811', '826188', '865672', '877258', '936442'];
        if (in_array($nik_tg, $pm)){
            $data['new_doc'] = 1;
        } else {
            $data['new_doc'] = 0;
        }
        return view('detail_list_document', compact('data'));
    }

    public function submit_detail_list_document(Request $request, $id){
        $nik_tg = $request->session()->get('user')->nik_tg;
        if ($request->file()){
            $check = DB::table('document_tracking')->where('id', $id)->select('*')->get();
            if (count($check) == 0){
                return redirect()->route('list_document')->with('error', 'ID Dokumen tidak ditemukan, mohon cek kembali URL anda');
            }
            $check = $check->first();
            $files = $request->file('document');
            $array_filename = [];
            foreach($files as $key => $file){
                $ext = $file->extension();
                if (($ext == 'pdf') || ($ext == 'PDF')) {
                    $count = $check->id.rand(0,10000);
                    $fileName = $count.'_'.$file->getClientOriginalName();
                    $move = $file->move(public_path('storage'), $fileName);
                    if ($move){
                        $array_filename[] = $fileName;
                        $datetime = date('Y-m-d H:i:s');
                        $activity = 'Success Upload Document File in Detail Document file '.$fileName;
                        $status = 'SUCCESS';
                        DB::table('log')->insert([
                            'nik_tg' => $nik_tg,
                            'activity' => $activity,
                            'status' => $status,
                            'datetime' => $datetime
                        ]);
                    } else {
                        $activity = 'Failed Upload Document File in Detail Document';
                        $status = 'ERROR';
                        $datetime = date('Y-m-d H:i:s');
                        DB::table('log')->insert([
                            'nik_tg' => $nik_tg,
                            'activity' => $activity,
                            'status' => $status,
                            'datetime' => $datetime
                        ]);
                        return back()
                        ->with('error', 'Gagal mengupload file dokumen. Mohon kontak admin IT.');
                    }
                } else {
                    return back()
                        ->with('error', 'Gagal mengupload file dokumen. Harus extension pdf!');
                }
            }
            if ($check->id_status == 1){
                $status = 2;
                $column = 'pm_doc';
                $column2 = 'pm_date';
            } else if ($check->id_status == 2){
                $status = 3;
                $column = 'mgr_region_doc';
                $column2 = 'mgr_region_date';
            } else if ($check->id_status == 3){
                $status = 4;
                $column = 'gm_area_doc';
                $column2 = 'gm_area_date';
            } else if ($check->id_status == 4){
                $status = 5;
                $column = 'mgr_cons_doc';
                $column2 = 'mgr_cons_date';
            } else if ($check->id_status == 5){
                $status = 6;
                $column = 'gm_cons_doc';
                $column2 = 'gm_cons_date';
            } else if ($check->id_status == 6){
                $status = 7;
                $column = 'mgr_proc_doc';
                $column2 = 'mgr_proc_date';
            } else if ($check->id_status == 7){
                $status = 8;
                $column = 'vp_proc_doc';
                $column2 = 'vp_proc_date';
            } else if ($check->id_status == 8){
                $status = 9;
                $column = 'off_proc_doc';
                $column2 = 'off_proc_date';
            } else {
                $status = 1;
                $column = 'temp_doc';
                $column2 = 'temp_date';
            }
            $doc = implode('|', $array_filename);
            $input = $request->all();
            if ($check->id_status == 6){
                $update = DB::table('document_tracking')->where('id', $id)
                                                        ->update([
                                                            'id_status' => $status,
                                                            $column => $doc,
                                                            $column2 => date('Y-m-d H:i:s'),
                                                            'amount_proc' => str_replace('.','',$input['amount_proc'])
                                                        ]);
            } else {
                $update = DB::table('document_tracking')->where('id', $id)
                                                        ->update([
                                                            'id_status' => $status,
                                                            $column => $doc,
                                                            $column2 => date('Y-m-d H:i:s')
                                                        ]);
            }
            $activity = 'Success Update Progress Document ID '.$id;
            $status = 'SUCCESS';
            $datetime = date('Y-m-d H:i:s');
            DB::table('log')->insert([
                'nik_tg' => $nik_tg,
                'activity' => $activity,
                'status' => $status,
                'datetime' => $datetime
            ]);
            return redirect()->route('detail_list_document', ['id' => $id])->with('success', 'Dokumen berhasil diupload!');
        } else {
            return redirect()->route('detail_list_document', ['id' => $id])->with('error', 'File upload tidak ditemukan, mohon cek kembali file anda');
        }
    }

    public function new_doc (Request $request, $id){
        $nik_tg = $request->session()->get('user')->nik_tg;

        $check = DB::table('document_tracking')->where('id', $id)->select('*')->get();
        if (count($check) == 0){
            return redirect()->route('list_document')->with('error', 'ID Dokumen tidak ditemukan, mohon cek kembali URL anda');
        }
        $check = $check->first();
        $pid = DB::table('document_tracking')->where('pid', $check->pid)->select('*')->get();
        $count = count($pid) + 1;
        
        $insert = DB::table('document_tracking')->insertGetId([
                                                    'pid' => $check->pid.' Doc '.$count,
                                                    'site_name' => $check->site_name,
                                                    'region' => $check->region,
                                                    'scope' => $check->scope,
                                                    'amount' => $check->amount,
                                                    'supplier_name' => $check->supplier_name,
                                                    'spmk' => $check->spmk,
                                                    'pm_nik' => $check->pm_nik,
                                                    'pm_name' => $check->pm_name,
                                                    'pm_posisi' => $check->pm_posisi,
                                                    'mgr_region_nik' => $check->mgr_region_nik,
                                                    'mgr_region_name' => $check->mgr_region_name,
                                                    'mgr_region_posisi' => $check->mgr_region_posisi,
                                                    'gm_area_nik' => $check->gm_area_nik,
                                                    'gm_area_name' => $check->gm_area_name,
                                                    'gm_area_posisi' => $check->gm_area_posisi,
                                                    'mgr_cons_nik' => $check->mgr_cons_nik,
                                                    'mgr_cons_name' => $check->mgr_cons_name,
                                                    'mgr_cons_posisi' => $check->mgr_cons_posisi,
                                                    'gm_cons_nik' => $check->gm_cons_nik,
                                                    'gm_cons_name' => $check->gm_cons_name,
                                                    'gm_cons_posisi' => $check->gm_cons_posisi,
                                                    'mgr_proc_nik' => $check->mgr_proc_nik,
                                                    'mgr_proc_name' => $check->mgr_proc_name,
                                                    'mgr_proc_posisi' => $check->mgr_proc_posisi,
                                                    'vp_proc_nik' => $check->vp_proc_nik,
                                                    'vp_proc_name' => $check->vp_proc_name,
                                                    'vp_proc_posisi' => $check->vp_proc_posisi,
                                                    'off_proc_nik' => $check->off_proc_nik,
                                                    'off_proc_name' => $check->off_proc_name,
                                                    'off_proc_posisi' => $check->off_proc_posisi,
                                                    'id_status' => 1
        ]);
        $activity = 'Success New Doc PID '.$check->pid;
        $status = 'SUCCESS';
        $datetime = date('Y-m-d H:i:s');
        DB::table('log')->insert([
            'nik_tg' => $nik_tg,
            'activity' => $activity,
            'status' => $status,
            'datetime' => $datetime
        ]);
        return redirect()->route('detail_list_document', ['id' => $insert])->with('success', 'Flow dokumen baru berhasil digenerate');
    }
}
