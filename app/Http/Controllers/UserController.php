<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
	public function index(){
    $data = \DB::Table('users')
              ->join('user_role','user_role.user_id','=','users.id')
              ->join('roles','user_role.role_id','=','roles.id')
              ->select('users.id','users.username','user_role.role_id',\DB::raw('roles.nama as nama_role'),\DB::raw('roles.description as desc_role'))
              ->orderBy('users.created_at','desc')->get();

		return view('master.user.index',[
      'data' => $data
    ]);
	}

  public function create(){
    return view('master.user.create',[]);
  }

  public function edit($user_id){
    $data = \DB::Table('users')
              ->join('user_role','user_role.user_id','=','users.id')
              ->join('roles','user_role.role_id','=','roles.id')
              ->select('users.id','users.username','user_role.role_id',\DB::raw('roles.nama as nama_role'),\DB::raw('roles.description as desc_role'))
              ->orderBy('users.created_at','desc')
              ->where('users.id',$user_id)
              ->first();
    return view('master.user.edit',[
      'data' => $data
    ]);
  }


}
