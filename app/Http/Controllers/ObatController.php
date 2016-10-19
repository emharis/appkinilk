<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ObatController extends Controller
{
	public function index(){
    $data = \DB::Table('VIEW_STOK_OBAT')
							// ->leftJoin('satuan','obat.satuan_kecil_id','=','satuan.id')
							// ->select('obat.*',\DB::raw('satuan.nama as satuan'))
							->orderBy('nama','asc')
							// ->orderBy('created_at','desc')
              ->get();

		return view('inventory.obat.index',[
      'data' => $data
    ]);
	}

  public function create(){
		$satuan = \DB::table('satuan')
						->orderBy('created_at','desc')
						->get();
		$select_satuan=[];
		foreach($satuan as $dt){
			$select_satuan[$dt->id] = $dt->nama;
		}

    return view('inventory.obat.create',[
			'select_satuan' => $select_satuan
		]);
  }

	public function insert(Request $req){
		return \DB::transaction(function()use($req){
			\DB::table('obat')->insert([
				'nama' => $req->nama,
				'satuan_besar_id' => $req->satuan_besar,
				'satuan_kecil_id' => $req->satuan_kecil,
			]);

			return redirect('inventory/obat');
		});
	}

  public function edit($obat_id){
		$satuan = \DB::table('satuan')
						->orderBy('created_at','desc')
						->get();
		$select_satuan=[];
		foreach($satuan as $dt){
			$select_satuan[$dt->id] = $dt->nama;
		}

    $data = \DB::Table('obat')
              ->find($obat_id);

		// kartu stok
		$stok_moving = \DB::table('VIEW_MUTASI_OBAT')
		 								->where('obat_id',$obat_id)
										->orderBy('tanggal','asc')
										->get();

    return view('inventory.obat.edit',[
      'data' => $data,
			'select_satuan' => $select_satuan,
			'stok_moving' => $stok_moving
    ]);
  }

	public function update(Request $req){
		return \DB::transaction(function()use($req){
			\DB::table('obat')
				->where('id',$req->obat_id)
				->update([
					'nama' => $req->nama,
					'satuan_besar_id' => $req->satuan_besar,
					'satuan_kecil_id' => $req->satuan_kecil,
				]);

				return redirect('inventory/obat');
		});
	}


}
