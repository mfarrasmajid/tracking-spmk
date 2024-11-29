<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class AbsenController extends Controller
{
    public function absen(Request $request){
        $data['init'] = 1;
        $data['date'] = date('d M Y');
        return view('absen', compact('data'));
    }

    public function submit_absen(Request $request){
        $data = $request->all();
        $data['init'] = 0;
        if ($data['status'] == 'HADIR'){
            $alasan = '';
        } else {
            $alasan = $data['alasan'];
        }
        $nik_tg = $data['nik_tg'];
        $date = date('Y-m-d');
        $datetime = date('Y-m-d H:i:s');
        $check = DB::table('peserta_radir')->where('nik_tg', $data['nik_tg'])->select('*')->get();
        if (count($check) > 0){
            $check_absen = DB::table('absen_radir')->where('nik_tg', $data['nik_tg'])
                                                   ->where(DB::raw('DATE(datetime)'), $date)
                                                   ->select('*')
                                                   ->get();
            if (count($check_absen) > 0){
                $activity = 'Absen Gagal (Double) dari NIK TG '.$data['nik_tg'];
                $status = "ERROR";
                $data['status_absen'] = 0;
            } else {
                $check = $check->first();
                $insert = DB::table('absen_radir')->insertGetId([
                    'nik_tg' => $data['nik_tg'],
                    'name' => $check->name,
                    'unit' => $check->unit,
                    'jabatan' => $check->jabatan,
                    'direktorat' => $check->direktorat,
                    'status' => $data['status'],
                    'alasan' => $alasan,
                    'datetime' => $datetime
                ]);
                if ($insert){
                    $activity = 'Absen Berhasil dari NIK TG '.$data['nik_tg'];
                    $status = "SUCCESS";
                    $data['status_absen'] = 1;
                    $data['peserta_absen'] = $check->name;
                } else {
                    $activity = 'Absen Gagal dari NIK TG '.$data['nik_tg'];
                    $status = "ERROR";
                    $data['status_absen'] = 2;
                }
            }
        } else {
            $activity = 'NIK TG '.$data['nik_tg'].' Tidak Terdaftar di Peserta Radir';
            $status = "ERROR";
            $data['status_absen'] = 3;
        }
        $log = DB::table('log')->insert([
            'nik_tg' => $nik_tg,
            'activity' => $activity,
            'status' => $status,
            'datetime' => $datetime
        ]);
        return view('absen', compact('data'));
    }

    public function absen_event(Request $request, $id){
        $data['init'] = 1;
        $data['date'] = date('d M Y');
        $data['id'] = $id;
        $data['event_list'] = DB::table('event_list')->where('id', $id)->get()->first();
        return view('absen_event', compact('data'));
    }

    public function submit_absen_event(Request $request, $id){
        $data = $request->all();
        $data['id'] = $id;
        $data['event_list'] = DB::table('event_list')->where('id', $id)->get()->first();
        $data['init'] = 0;
        if ($data['status'] == 'HADIR'){
            $alasan = '';
        } else {
            $alasan = $data['alasan'];
        }
        $nik_tg = $data['nik_tg'];
        $date = date('Y-m-d');
        $datetime = date('Y-m-d H:i:s');
        $check = DB::table('peserta_event')->where('nik_tg', $data['nik_tg'])->select('*')->get();
        if (count($check) > 0){
            $check_absen = DB::table('absen_event')->where('nik_tg', $data['nik_tg'])
                                                   ->where(DB::raw('DATE(datetime)'), $date)
                                                   ->where('event_id', $id)
                                                   ->select('*')
                                                   ->get();
            if (count($check_absen) > 0){
                $activity = 'Absen Gagal (Double) dari NIK TG '.$data['nik_tg'];
                $status = "ERROR";
                $data['status_absen'] = 0;
            } else {
                $check = $check->first();
                $insert = DB::table('absen_event')->insertGetId([
                    'event_id' => $id,
                    'nik_tg' => $data['nik_tg'],
                    'name' => $check->name,
                    'posisi' => $check->posisi,
                    'company' => $check->company,
                    'status' => $data['status'],
                    'alasan' => $alasan,
                    'datetime' => $datetime
                ]);
                if ($insert){
                    $activity = 'Absen Event Berhasil dari NIK TG '.$data['nik_tg'];
                    $status = "SUCCESS";
                    $data['status_absen'] = 1;
                    $data['peserta_absen'] = $check->name;
                } else {
                    $activity = 'Absen Event Gagal dari NIK TG '.$data['nik_tg'];
                    $status = "ERROR";
                    $data['status_absen'] = 2;
                }
            }
        } else {
            $activity = 'NIK TG '.$data['nik_tg'].' Tidak Terdaftar di Peserta Event';
            $status = "ERROR";
            $data['status_absen'] = 3;
        }
        $log = DB::table('log')->insert([
            'nik_tg' => $nik_tg,
            'activity' => $activity,
            'status' => $status,
            'datetime' => $datetime
        ]);
        return view('absen_event', compact('data'));
    }
}
