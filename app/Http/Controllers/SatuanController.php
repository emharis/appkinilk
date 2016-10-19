<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SatuanController extends Controller
{
	public function index(){
    $data = \DB::Table('satuan')
							->orderBy('created_at','desc')
              ->get();

		return view('inventory.satuan.index',[
      'data' => $data
    ]);
	}

  public function create(){
    return view('inventory.satuan.create',[]);
  }

	public function insert(Request $req){
		return \DB::transaction(function()use($req){
			\DB::table('satuan')->insert([
				'nama' => $req->nama,
				// 'desc' => $req->desc,
			]);

			return redirect('inventory/satuan');
		});
	}

  public function edit($satuan_id){
    $data = \DB::Table('satuan')
              ->find($satuan_id);
    return view('inventory.satuan.edit',[
      'data' => $data
    ]);
  }

	public function update(Request $req){
		return \DB::transaction(function()use($req){
			\DB::table('satuan')
				->where('id',$req->satuan_id)
				->update([
					'nama' => $req->nama,
					// 'desc' => $req->desc,
				]);

				return redirect('inventory/satuan');
		});
	}


}
