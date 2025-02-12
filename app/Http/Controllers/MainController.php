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
                                                                    ->orWhere('se_nik', '=', $nik_tg)
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
                                                                    ->orWhere('se_nik', '=', $nik_tg)
                                                                    ->orWhereIn(DB::raw($nik_tg), $special_nik)
                                                                    ;
                                                            })
                                                            ->leftJoin('master_status as ms', 'ms.id', '=', 'd.id_status')
                                                            ->orderBy('d.id_status', 'asc')
                                                            ->get();
        foreach($data['document'] as $key => $d){
            if ($d->off_proc_date != null){
                $data['document'][$key]->last_date = $d->off_proc_date;
            } else if ($d->se_date != null){
                $data['document'][$key]->last_date = $d->se_date;
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
                                                                    ->orWhere('se_nik', '=', $nik_tg)
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
        } else if ($d->se_date != null){
            $data['document']->last_date = $d->se_date;
        } else if ($d->vp_proc_date != null){
            $data['document']->last_date = $d->vp_proc_date;
        }  else if ($d->mgr_proc_date != null){
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
        if ($doc->off_proc_doc != null){
            $data['latest_document'] = explode('|', $doc->off_proc_doc);
        } else if ($doc->vp_proc_doc != null){
            $data['latest_document'] = explode('|', $doc->vp_proc_doc);
        } else if ($doc->mgr_proc_doc != null){
            $data['latest_document'] = explode('|', $doc->mgr_proc_doc);
        } else if ($doc->gm_cons_doc != null){
            $data['latest_document'] = explode('|', $doc->gm_cons_doc);
        } else if ($doc->mgr_cons_doc != null){
            $data['latest_document'] = explode('|', $doc->mgr_cons_doc);
        } else if ($doc->gm_area_doc != null){
            $data['latest_document'] = explode('|', $doc->gm_area_doc);
        } else if ($doc->mgr_region_doc != null){
            $data['latest_document'] = explode('|', $doc->mgr_region_doc);
        } else if ($doc->pm_doc != null){
            $data['latest_document'] = explode('|', $doc->pm_doc);
        } else {
            $data['latest_document'] = [];
        }
        $data['document_pm'] = explode('|', $doc->pm_doc);
        $data['document_proc'] = explode('|', $doc->mgr_proc_doc);
        $data['privilege'] = 0;
        if (($nik_tg == '935378') && ($doc->id_status != 9)){
            $data['privilege'] = 1;
            if (($doc->id_status == 1) || ($doc->id_status == 11)){
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
            } else if ($doc->id_status == 8){
                $data['latest_pic'] = 'Solution Engineering';
            } else if ($doc->id_status == 10){
                $data['latest_pic'] = 'Officer Procurement';
            }
        }
        if ((($doc->id_status == 1) || ($doc->id_status == 11)) && ($doc->pm_nik == $nik_tg)){
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
        if (($doc->id_status == 8) && ($doc->se_nik == $nik_tg)){
            $data['privilege'] = 1;
            $data['latest_pic'] = 'Solution Engineering';
        }
        if (($doc->id_status == 10) && ($doc->off_proc_nik == $nik_tg)){
            $data['privilege'] = 1;
            $data['latest_pic'] = 'Officer Procurement';
        }
        $cek_pm = DB::table('master_pm')->where('pm', $nik_tg)->select('*')->get();
        if (count($cek_pm) > 0){
            $data['new_doc'] = 1;
        } else {
            $data['new_doc'] = 0;
        }
        $data['komentar'] = DB::table('document_komentar')->where('id_document', $id)->select('*')->orderBy('id', 'DESC')->get();
        $data['sow'] = DB::table('master_sow')->select('*')->orderBy('id', 'ASC')->get();
        return view('detail_list_document', compact('data'));
    }

    public function submit_detail_list_document(Request $request, $id){
        $nik_tg = $request->session()->get('user')->nik_tg;
        $name = $request->session()->get('user')->name;
        $check = DB::table('document_tracking')->where('id', $id)->select('*')->get();
        if (count($check) == 0){
            return redirect()->route('list_document')->with('error', 'ID Dokumen tidak ditemukan, mohon cek kembali URL anda');
        }
        $check = $check->first();
        if ($request->file()){
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
                        $activity = 'Failed Upload Document File in Detail Document file '.$fileName;
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
        } else {
            $array_filename = [];
        }
        $input = $request->all();
        if ($input['approve_or_return'] == '1'){
            if (($check->id_status == 1) || ($check->id_status == 11)){
                $status = 2;
                $column = 'pm_doc';
                $column2 = 'pm_date';
                $column3 = 'pm_komentar';
                $activity = 'Upload Document dan Approval PM';
            } else if ($check->id_status == 2){
                $status = 3;
                $column = 'mgr_region_doc';
                $column2 = 'mgr_region_date';
                $column3 = 'mgr_region_komentar';
                $activity = 'Approval MGR Regional';
            } else if ($check->id_status == 3){
                $status = 4;
                $column = 'gm_area_doc';
                $column2 = 'gm_area_date';
                $column3 = 'gm_area_komentar';
                $activity = 'Approval GM Area';
            } else if ($check->id_status == 4){
                $status = 5;
                $column = 'mgr_cons_doc';
                $column2 = 'mgr_cons_date';
                $column3 = 'mgr_cons_komentar';
                $activity = 'Approval MGR Construction';
            } else if ($check->id_status == 5){
                $status = 6;
                $column = 'gm_cons_doc';
                $column2 = 'gm_cons_date';
                $column3 = 'gm_cons_komentar';
                $activity = 'Approval GM Construction';
            } else if ($check->id_status == 6){
                $status = 7;
                $column = 'mgr_proc_doc';
                $column2 = 'mgr_proc_date';
                $column3 = 'mgr_proc_komentar';
                $activity = 'Approval MGR Procurement';
            } else if ($check->id_status == 7){
                $status = 8;
                $column = 'vp_proc_doc';
                $column2 = 'vp_proc_date';
                $column3 = 'vp_proc_komentar';
                $activity = 'Approval VP Procurement';
            } else if ($check->id_status == 8){
                $status = 10;
                $column = 'se_doc';
                $column2 = 'se_date';
                $column3 = 'se_komentar';
                $activity = 'Approval PR oleh SE';
            } else if ($check->id_status == 10){
                $status = 9;
                $column = 'off_proc_doc';
                $column2 = 'off_proc_date';
                $column3 = 'off_proc_komentar';
                $activity = 'Approval PO oleh Procurement';
            } else {
                $status = 11;
                $column = 'temp_doc';
                $column2 = 'temp_date';
                $column3 = 'temp_komentar';
                $activity = 'Error';
            }
            $doc = implode('|', $array_filename);
            if (($check->id_status == 1) || ($check->id_status == 11)){
                if ($check->nomor_boq == NULL){
                    $bulan = (int) date('m');
                    if ($bulan == 1) $b = 'I';
                    if ($bulan == 2) $b = 'II';
                    if ($bulan == 3) $b = 'III';
                    if ($bulan == 4) $b = 'IV';
                    if ($bulan == 5) $b = 'V';
                    if ($bulan == 6) $b = 'VI';
                    if ($bulan == 7) $b = 'VII';
                    if ($bulan == 8) $b = 'VIII';
                    if ($bulan == 9) $b = 'IX';
                    if ($bulan == 10) $b = 'X';
                    if ($bulan == 11) $b = 'XI';
                    if ($bulan == 12) $b = 'XII';
                    $tahun = (int) date('Y');
                    $check_nomor = DB::table('master_nomor')->where('regional', $check->region)
                                                            ->where('id_sow', $input['id_sow'])
                                                            ->where('bulan', $bulan)
                                                            ->where('tahun', $tahun)
                                                            ->select('*')
                                                            ->get();
                    if (count($check_nomor) > 0){
                        $nomor = $check_nomor->first()->nomor + 1;
                        $nomor_str = $nomor;
                        if ($nomor < 1000){
                            $nomor_str = '0'.$nomor_str;
                        }
                        if ($nomor < 100){
                            $nomor_str = '0'.$nomor_str;
                        }
                        if ($nomor < 10){
                            $nomor_str = '0'.$nomor_str;
                        }
                    } else {
                        $nomor_str = '0001';
                    }
                    $nomor_boq = $nomor_str.'/'.$check->region.'/'.$input['id_sow'].'/BoQ/'.$b.'/'.$tahun;
                } else {
                    $nomor_boq = $check->nomor_boq;
                }
                $update = DB::table('document_tracking')->where('id', $id)
                                                        ->update([
                                                            'nomor_boq' => $nomor_boq,
                                                            'id_status' => $status,
                                                            $column => $doc,
                                                            $column2 => date('Y-m-d H:i:s'),
                                                            $column3 => $input['komentar'],
                                                            'amount_awal' => str_replace('.','',$input['amount_awal']),
                                                            'id_sow' => $input['id_sow']
                                                        ]);
            } else if ($check->id_status == 6){
                $update = DB::table('document_tracking')->where('id', $id)
                                                        ->update([
                                                            'id_status' => $status,
                                                            $column => $doc,
                                                            $column2 => date('Y-m-d H:i:s'),
                                                            $column3 => $input['komentar'],
                                                            'amount_proc' => str_replace('.','',$input['amount_proc'])
                                                        ]);
            } else {
                $update = DB::table('document_tracking')->where('id', $id)
                                                        ->update([
                                                            'id_status' => $status,
                                                            $column => $doc,
                                                            $column2 => date('Y-m-d H:i:s'),
                                                            $column3 => $input['komentar']
                                                        ]);
            }

            $update_komentar = DB::table('document_komentar')->insertGetId([
                'id_document' => $id,
                'nik_tg' => $nik_tg,
                'name' => $name,
                'approval_status' => 'APPROVED',
                'activity' => $activity,
                'komentar' => $input['komentar']
            ]);

            $activity = 'Success Update Progress Status '.$status.' Document ID '.$id;
            $status = 'SUCCESS';
            $datetime = date('Y-m-d H:i:s');
            DB::table('log')->insert([
                'nik_tg' => $nik_tg,
                'activity' => $activity,
                'status' => $status,
                'datetime' => $datetime
            ]);
            return redirect()->route('detail_list_document', ['id' => $id])->with('success', 'Progress berhasil diapprove!');
        } else {
            $return = DB::table('document_tracking')->where('id', $id)
                                                    ->update([
                                                        'pm_doc' => NULL,
                                                        'pm_date' => NULL,
                                                        'pm_komentar' => NULL,
                                                        'mgr_region_doc' => NULL,
                                                        'mgr_region_date' => NULL,
                                                        'mgr_region_komentar' => NULL,
                                                        'gm_area_doc' => NULL,
                                                        'gm_area_date' => NULL,
                                                        'gm_area_komentar' => NULL,
                                                        'mgr_cons_doc' => NULL,
                                                        'mgr_cons_date' => NULL,
                                                        'mgr_cons_komentar' => NULL,
                                                        'gm_cons_doc' => NULL,
                                                        'gm_cons_date' => NULL,
                                                        'gm_cons_komentar' => NULL,
                                                        'mgr_proc_doc' => NULL,
                                                        'mgr_proc_date' => NULL,
                                                        'mgr_proc_komentar' => NULL,
                                                        'vp_proc_doc' => NULL,
                                                        'vp_proc_date' => NULL,
                                                        'vp_proc_komentar' => NULL,
                                                        'se_doc' => NULL,
                                                        'se_date' => NULL,
                                                        'se_komentar' => NULL,
                                                        'off_proc_doc' => NULL,
                                                        'off_proc_date' => NULL,
                                                        'off_proc_komentar' => NULL,
                                                        'amount_proc' => NULL,
                                                        'amount_awal' => NULL,
                                                        'id_sow' => NULL,
                                                        'id_status' => 11
                                                    ]);
            $update_komentar = DB::table('document_komentar')->insertGetId([
                'id_document' => $id,
                'nik_tg' => $nik_tg,
                'name' => $name,
                'approval_status' => 'RETURNED',
                'activity' => 'Return BOQ oleh '.$name,
                'komentar' => $input['komentar']
            ]);

            $activity = 'Success Return All, Document ID '.$id.' oleh '.$name;
            $status = 'SUCCESS';
            $datetime = date('Y-m-d H:i:s');
            DB::table('log')->insert([
                'nik_tg' => $nik_tg,
                'activity' => $activity,
                'status' => $status,
                'datetime' => $datetime
            ]);
            return redirect()->route('detail_list_document', ['id' => $id])->with('success', 'Dokumen berhasil direturn!');
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
        if ($count == 1) $x = 'A';
        if ($count == 2) $x = 'B';
        if ($count == 3) $x = 'C';
        if ($count == 4) $x = 'D';
        if ($count == 5) $x = 'E';
        if ($count == 6) $x = 'F';
        if ($count == 7) $x = 'G';
        if ($count == 8) $x = 'H';
        if ($count == 9) $x = 'I';
        if ($count == 10) $x = 'J';
        if ($count == 11) $x = 'K';
        if ($count == 12) $x = 'L';
        if ($count == 13) $x = 'M';
        if ($count == 14) $x = 'N';
        if ($count == 15) $x = 'O';

        $nomor_arr = explode('/', $check->nomor_boq);
        if (count($nomor_arr) > 0) {
            $nomor_arr[0] = $nomor_arr[0].$x;
            $nomor_boq = implode('/', $nomor_arr);
        } else {
            $nomor_boq = NULL;
        }
        
        $insert = DB::table('document_tracking')->insertGetId([
                                                    'nomor_boq' => $nomor_boq,
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
                                                    'se_nik' => $check->se_nik,
                                                    'se_name' => $check->se_name,
                                                    'se_posisi' => $check->se_posisi,
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
