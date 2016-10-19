<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SupplierController extends Controller
{
	public function index(){
    $data = \DB::Table('supplier')
							->orderBy('created_at','desc')
              ->get();

		return view('master.supplier.index',[
      'data' => $data
    ]);
	}

  public function create(){
    return view('master.supplier.create',[]);
  }

	public function insert(Request $req){
		return \DB::transaction(function()use($req){
			\DB::table('supplier')->insert([
				'nama' => $req->nama,
				// 'desc' => $req->desc,
			]);

			return redirect('master/supplier');
		});
	}

  public function edit($supplier_id){
    $data = \DB::Table('supplier')
              ->find($supplier_id);
    return view('master.supplier.edit',[
      'data' => $data
    ]);
  }

	public function update(Request $req){
		return \DB::transaction(function()use($req){
			\DB::table('supplier')
				->where('id',$req->supplier_id)
				->update([
					'nama' => $req->nama,
					// 'desc' => $req->desc,
				]);

				return redirect('master/supplier');
		});
	}


}
