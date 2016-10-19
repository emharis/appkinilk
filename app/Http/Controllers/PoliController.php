<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PoliController extends Controller
{
	public function index(){
    $data = \DB::Table('poli')
							->orderBy('created_at','desc')
              ->get();

		return view('master.poli.index',[
      'data' => $data
    ]);
	}

  public function create(){
    return view('master.poli.create',[]);
  }

	public function insert(Request $req){
		return \DB::transaction(function()use($req){
			\DB::table('poli')->insert([
				'nama' => $req->nama,
				'desc' => $req->desc,
			]);

			return redirect('master/poli');
		});
	}

  public function edit($poli_id){
    $data = \DB::Table('poli')
              ->find($poli_id);
    return view('master.poli.edit',[
      'data' => $data
    ]);
  }

	public function update(Request $req){
		return \DB::transaction(function()use($req){
			\DB::table('poli')
				->where('id',$req->poli_id)
				->update([
					'nama' => $req->nama,
					'desc' => $req->desc,
				]);

				return redirect('master/poli');
		});
	}


}
