<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use DB;
class RefreshSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->has('id')){
            $user = DB::table('hcm.users')->select('*')
                                      ->where('id', $request->session()->get('id'))
                                      ->get();
            if (count($user) > 0){
                $u = $user->first();
                $request->session()->put('user', $u);
                $request->session()->put('nik_tg', $u->nik_tg);
                $request->session()->put('name', $u->name);
                $request->session()->put('email', $u->email);
                $special = DB::table('master_special_privilege')->where('nik_tg', $u->nik_tg)->select('*')->get();
                if (count($special) > 0){
                    $request->session()->put('special', 1);
                } else {
                    $request->session()->put('special', 0);
                }
            } else {
                $request->session()->flush();
                return redirect('login');
            }
        } else {
            return redirect('login');
        }
        return $next($request);
    }
}
