<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if ($request->session()->has('id')){
            return redirect()->route('dashboard');
        }
        return view('login');
    }

    public function submit_login(Request $request)
    {
        $data = $request->all();
        $username = $data['nik_tg'];
        $password = $data['password'];
        $pwd = md5($data['password']);

        $url = "http://api.mitratel.co.id/ldap/telkom/api/apigwsit_v1.php";
        $postdata = http_build_query(
            array(
                'username' => $username,
                'password' => $password
            )
        );
        $option = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );
        $context = stream_context_create($option);
        $string = file_get_contents($url, false, $context);
        $json = json_decode($string,true);
        $statusx = $json['status'];

        $nik_tg = $username;
        $datetime = date('Y-m-d H:i:s');
        $activity = "Failed Login From Username ".$nik_tg;
        $status = "ERROR";

        if($statusx){
            $check = DB::table('users')->where('nik_tg', $username)->select('*')->get();
            if (count($check) > 0){
                $check = $check->first();
                $id = $check->id;
                $request->session()->put('id', $id);
                $activity = "Successful Login From Username ".$nik_tg;
                $status = "SUCCESS";
                $log = DB::table('log')->insert([
                    'nik_tg' => $nik_tg,
                    'activity' => $activity,
                    'status' => $status,
                    'datetime' => $datetime
                ]);
                $last_login = DB::table('users')->where('id', $id)->update([
                    'last_login' => $datetime
                ]);
                return redirect()->route('dashboard');
            } else {
                $log = DB::table('log')->insert([
                    'nik_tg' => $nik_tg,
                    'activity' => $activity,
                    'status' => $status,
                    'datetime' => $datetime
                ]);
                return redirect()->route('login')->with('error', 'Username not found');
            }
        } else {
            $check = DB::table('users')->where('nik_tg', $username)->orWhere('email', $username)->select('*')->get();
            if (count($check) > 0) {
                $check = $check->first();
                if (Hash::check($password, $check->password)){
                    $id = $check->id;
                    $request->session()->put('id', $id);
                    $activity = "Successful Login From Username " . $nik_tg;
                    $status = "SUCCESS";
                    $log = DB::table('log')->insert([
                        'nik_tg' => $nik_tg,
                        'activity' => $activity,
                        'status' => $status,
                        'datetime' => $datetime
                    ]);
                    $last_login = DB::table('users')->where('id', $id)->update([
                        'last_login' => $datetime
                    ]);
                    return redirect()->route('dashboard');
                } else {
                    $log = DB::table('log')->insert([
                        'nik_tg' => $nik_tg,
                        'activity' => $activity,
                        'status' => $status,
                        'datetime' => $datetime
                    ]);
                    return redirect()->route('login')->with('error', 'Username or password wrong');
                }
            } else {
                $log = DB::table('log')->insert([
                    'nik_tg' => $nik_tg,
                    'activity' => $activity,
                    'status' => $status,
                    'datetime' => $datetime
                ]);
                return redirect()->route('login')->with('error', 'Username not found');
            }
        }
    }

    public function logout(Request $request)
    {
        $id = $request->session()->get('id');
        $nik_tg = $request->session()->get('nik_tg');
        $activity = "Successful Logout From Username ".$nik_tg;
        $status = "SUCCESS";
        $datetime = date('Y-m-d H:i:s');
        $last_logout = DB::table('users')->where('id', $id)->update([
            'last_logout' => $datetime
        ]);
        $log = DB::table('log')->insert([
            'nik_tg' => $nik_tg,
            'activity' => $activity,
            'status' => $status,
            'datetime' => $datetime
        ]);
        $request->session()->flush();
        return redirect()->route('login');
    }
}
