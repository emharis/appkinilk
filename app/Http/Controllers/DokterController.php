<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DokterController extends Controller
{
	public function index(){
    $data = \DB::Table('dokter')
							->join('poli','dokter.id_poli','=','poli.id')
							->select('dokter.*',\DB::raw('poli.nama as poli'))
							->orderBy('created_at','desc')
              ->get();

		return view('master.dokter.index',[
      'data' => $data
    ]);
	}

  public function create(){
		$poli = \DB::table('poli')
						->orderBy('created_at','desc')
						->get();
		$select_poli=[];
		foreach($poli as $dt){
			$select_poli[$dt->id] = $dt->nama;
		}
    return view('master.dokter.create',[
			'select_poli' => $select_poli
		]);
  }

	public function insert(Request $req){
		return \DB::transaction(function()use($req){
			\DB::table('dokter')->insert([
				'nama' => $req->nama,
				'jenis_kelamin' => $req->jenis_kelamin,
				'nik' => $req->nik,
				'alamat' => $req->alamat,
				'telepon' => $req->telepon,
				// 'tanggal_lahir' => $req->tanggal_lahir,
				'id_poli' => $req->poli,
				'spesialisasi' => $req->spesialisasi,
			]);

			return redirect('master/dokter');
		});
	}

  public function edit($dokter_id){
		$poli = \DB::table('poli')
						->orderBy('created_at','desc')
						->get();
		$select_poli=[];
		foreach($poli as $dt){
			$select_poli[$dt->id] = $dt->nama;
		}

    $data = \DB::Table('dokter')
              ->find($dokter_id);
    return view('master.dokter.edit',[
      'data' => $data,
			'select_poli' => $select_poli
    ]);
  }

	public function update(Request $req){
		return \DB::transaction(function()use($req){
			\DB::table('dokter')
				->where('id',$req->dokter_id)
				->update([
					'nama' => $req->nama,
					'desc' => $req->desc,
				]);

				return redirect('master/dokter');
		});
	}


}
