<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ApiController extends Controller
{
    public function get_absen(Request $request)
    {
        $date = date('Y-m-d');
        $data = DB::table('peserta_radir as pa')->select(
                                                    DB::raw("(SELECT COUNT(*) as count FROM absen_radir WHERE nik_tg = pa.nik_tg AND status = 'HADIR' AND DATE(datetime) = '".$date."') as hadir_count"),
                                                    DB::raw("(SELECT COUNT(*) as count FROM absen_radir WHERE nik_tg = pa.nik_tg AND status = 'TIDAK HADIR' AND DATE(datetime) = '".$date."') as tidak_hadir_count"),
                                                    DB::raw("(SELECT alasan as count FROM absen_radir WHERE nik_tg = pa.nik_tg AND status = 'TIDAK HADIR' AND DATE(datetime) = '".$date."' LIMIT 1) as alasan"),
                                                    'pa.id',
                                                    'pa.name'
                                                )->where('pa.group', 'LIKE', '%1%')
                                                ->get();
        return $data;
    }

    public function get_absen_khusus(Request $request)
    {
        $date = date('Y-m-d');
        $data = DB::table('peserta_radir as pa')->select(
                                                    DB::raw("(SELECT COUNT(*) as count FROM absen_radir WHERE nik_tg = pa.nik_tg AND status = 'HADIR' AND DATE(datetime) = '".$date."') as hadir_count"),
                                                    DB::raw("(SELECT COUNT(*) as count FROM absen_radir WHERE nik_tg = pa.nik_tg AND status = 'TIDAK HADIR' AND DATE(datetime) = '".$date."') as tidak_hadir_count"),
                                                    DB::raw("(SELECT alasan as count FROM absen_radir WHERE nik_tg = pa.nik_tg AND status = 'TIDAK HADIR' AND DATE(datetime) = '".$date."' LIMIT 1) as alasan"),
                                                    'pa.id',
                                                    'pa.name'
                                                )->where('pa.group', 'LIKE', '%2%')
                                                ->get();
        return $data;
    }

    public function get_absen_event(Request $request, $id)
    {
        $date = date('Y-m-d');
        $data = DB::table('peserta_event as pa')->select(
                                                    DB::raw("(SELECT COUNT(*) as count FROM absen_event WHERE nik_tg = pa.nik_tg AND event_id = '$id' AND status = 'HADIR' AND DATE(datetime) = '".$date."') as hadir_count"),
                                                    DB::raw("(SELECT COUNT(*) as count FROM absen_event WHERE nik_tg = pa.nik_tg AND event_id = '$id' AND status = 'TIDAK HADIR' AND DATE(datetime) = '".$date."') as tidak_hadir_count"),
                                                    DB::raw("(SELECT alasan as count FROM absen_event WHERE nik_tg = pa.nik_tg AND event_id = '$id' AND status = 'TIDAK HADIR' AND DATE(datetime) = '".$date."' LIMIT 1) as alasan"),
                                                    'pa.id',
                                                    'pa.nik_tg',
                                                    'pa.name'
                                                )->where('pa.event_id', $id)
                                                ->get();
        return $data;
    }
}
