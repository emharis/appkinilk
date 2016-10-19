<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ShiftController extends Controller
{
	public function index(){
    $data = \DB::Table('shift')
							->orderBy('created_at','desc')
              ->get();

		return view('master.shift.index',[
      'data' => $data
    ]);
	}

  public function create(){
    return view('master.shift.create',[]);
  }

	public function insert(Request $req){
		return \DB::transaction(function()use($req){
			\DB::table('shift')->insert([
				'nama' => $req->nama,
				'masuk' => $req->masuk,
				'pulang' => $req->pulang,
			]);

			return redirect('master/shift');
		});
	}

  public function edit($shift_id){
    $data = \DB::Table('shift')
              ->find($shift_id);
    return view('master.shift.edit',[
      'data' => $data
    ]);
  }

	public function update(Request $req){
		return \DB::transaction(function()use($req){
			\DB::table('shift')
				->where('id',$req->shift_id)
				->update([
					'nama' => $req->nama,
					'masuk' => $req->masuk,
					'pulang' => $req->pulang,
				]);

				return redirect('master/shift');
		});
	}


}
