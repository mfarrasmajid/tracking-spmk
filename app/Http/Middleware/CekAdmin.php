<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use DB;

class CekAdmin
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
            $nik_tg = $request->session()->get('user')->nik_tg;
            $special = DB::table('master_special_privilege')->select('*')->where('nik_tg', $nik_tg)->get();
            if (count($special) > 0){
                return $next($request);
            } else {
                return redirect()->route('dashboard')->with('error', 'Anda tidak berhak mengakses halaman ini!');
            }
        } else {
            return redirect()->route('login');
        }
    }
}
