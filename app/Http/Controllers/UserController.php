<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDomicilio;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Show the profile for a given user.
     */
    public function index()
    {
        $users = DB::table( 'users' )
            ->join( 'user_domicilios', 'users.id', '=', 'user_domicilios.user_id' )
            ->get();
        foreach ($users as $key => $value) {
            $date = Carbon::now();
            $fecha_nacimiento = Carbon::createFromFormat( 'Y-m-d', $value->fecha_nacimiento );
            $year_fecha = $fecha_nacimiento->year;
            $edad = $date->subYears( $year_fecha );
            $value->edad = $edad->year;
        }
        return response()->json( $users );
    }
}
