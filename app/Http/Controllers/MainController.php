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
        $nik_tg = $request->session()->get('user')->nik_tg;
        $data['dashboard'] = DB::table('document_tracking as d')->select(
                                                                DB::raw('COUNT(d.id) as count'),
                                                                'd.region',
                                                                'ms.status'
                                                            )->where(function ($query) use ($nik_tg) {
                                                                $query->where('pm_nik', '=' , $nik_tg)
                                                                    ->orWhere('mgr_region_nik', '=', $nik_tg)
                                                                    ->orWhere('gm_area_nik', '=', $nik_tg)
                                                                    ->orWhere('mgr_cons_nik', '=', $nik_tg)
                                                                    ->orWhere('gm_cons_nik', '=', $nik_tg)
                                                                    ->orWhere('mgr_proc_nik', '=', $nik_tg)
                                                                    ->orWhere('vp_proc_nik', '=', $nik_tg)
                                                                    ->orWhere(DB::raw('935378 = '.$nik_tg), '=', 1)
                                                                    ;
                                                            })
                                                            ->leftJoin('master_status as ms', 'ms.id', '=', 'd.id_status')
                                                            ->orderBy('d.region', 'asc')
                                                            ->groupBy('d.region', 'ms.status')
                                                            ->get();
        $data['all_status'] = DB::table('master_status')->select('*')->get();
        $data['all_region'] = DB::table('document_tracking')->select(DB::raw('DISTINCT region as region'))->orderBy('region','asc')->get();
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
        $nik_tg = $request->session()->get('user')->nik_tg;
        $data['document'] = DB::table('document_tracking as d')->select(
                                                                'd.*',
                                                                'ms.status',
                                                                'ms.class'
                                                            )->where(function ($query) use ($nik_tg) {
                                                                $query->where('pm_nik', '=' , $nik_tg)
                                                                    ->orWhere('mgr_region_nik', '=', $nik_tg)
                                                                    ->orWhere('gm_area_nik', '=', $nik_tg)
                                                                    ->orWhere('mgr_cons_nik', '=', $nik_tg)
                                                                    ->orWhere('gm_cons_nik', '=', $nik_tg)
                                                                    ->orWhere('mgr_proc_nik', '=', $nik_tg)
                                                                    ->orWhere('vp_proc_nik', '=', $nik_tg)
                                                                    ->orWhere(DB::raw('935378 = '.$nik_tg), '=', 1)
                                                                    ;
                                                            })
                                                            ->leftJoin('master_status as ms', 'ms.id', '=', 'd.id_status')
                                                            ->orderBy('d.id_status', 'asc')
                                                            ->get();
        $data['all_status'] = DB::table('master_status')->select('*')->get();
        $data['all_region'] = DB::table('document_tracking')->select(DB::raw('DISTINCT region as region'))->orderBy('region','asc')->get();
        return view('list_document', compact('data'));
    }

    public function detail_list_document (Request $request, $id){
        $nik_tg = $request->session()->get('user')->nik_tg;
        $data['document'] = DB::table('document_tracking as d')->select(
                                                                'd.*',
                                                                'ms.status',
                                                                'ms.class'
                                                            )->where(function ($query) use ($nik_tg) {
                                                                $query->where('pm_nik', '=' , $nik_tg)
                                                                    ->orWhere('mgr_region_nik', '=', $nik_tg)
                                                                    ->orWhere('gm_area_nik', '=', $nik_tg)
                                                                    ->orWhere('mgr_cons_nik', '=', $nik_tg)
                                                                    ->orWhere('gm_cons_nik', '=', $nik_tg)
                                                                    ->orWhere('mgr_proc_nik', '=', $nik_tg)
                                                                    ->orWhere('vp_proc_nik', '=', $nik_tg)
                                                                    ->orWhere(DB::raw('935378 = '.$nik_tg), '=', 1)
                                                                    ;
                                                            })->where('d.id', $id)
                                                            ->leftJoin('master_status as ms', 'ms.id', '=', 'd.id_status')
                                                            ->orderBy('d.id_status', 'asc')
                                                            ->get();
        if (count($data['document']) == 0){
            return redirect()->route('dashboard')->with('error', 'Data dokumen tidak ditemukan, mohon cek kembali URL anda');
        }
        $data['document'] = $data['document']->first();
        $doc = $data['document'];
        if ($doc->vp_proc_date != null){
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
        if (($nik_tg == '935378') && ($doc->id_status != 8)){
            $data['privilege'] = 1;
            if ($doc->id_status == 1){
                $data['latest_pic'] = 'PM';
            } else if ($doc->id_status == 2){
                $data['latest_pic'] = 'MGR Regional';
            } else if ($doc->id_status == 3){
                $data['latest_pic'] = 'GM Area';
            } else if ($doc->id_status == 4){
                $data['latest_pic'] = 'MGR Construction';
            } else if ($doc->id_status == 5){
                $data['latest_pic'] = 'GM Construction';
            } else if ($doc->id_status == 6){
                $data['latest_pic'] = 'MGR Procurement';
            } else if ($doc->id_status == 7){
                $data['latest_pic'] = 'VP Procurement';
            }
        }
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
        }
        if (($doc->id_status == 7) && ($doc->vp_proc_nik == $nik_tg)){
            $data['privilege'] = 1;
            $data['latest_pic'] = 'VP Procurement';
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
            } else {
                $status = 1;
                $column = 'temp_doc';
                $column2 = 'temp_date';
            }
            $doc = implode('|', $array_filename);
            $update = DB::table('document_tracking')->where('id', $id)
                                                    ->update([
                                                        'id_status' => $status,
                                                        $column => $doc,
                                                        $column2 => date('Y-m-d H:i:s')
                                                    ]);
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
}
