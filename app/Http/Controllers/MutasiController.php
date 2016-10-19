<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MutasiController extends Controller
{
	public function index(){
    $data = \DB::Table('mutasi')
							->join('users','mutasi.user_id','=','users.id')
							->select('mutasi.*','users.username',\DB::raw('date_format(tanggal, "%d-%m-%Y") as tanggal_mutasi_formatted'))
              ->get();

		return view('inventory.mutasi.index',[
      'data' => $data
    ]);
	}

  public function create(){
    return view('inventory.mutasi.create',[
		]);
  }

	public function insert(Request $req){
		return \DB::transaction(function()use($req){
			// echo $req->mutasi . '<br/>';
			// echo $req->mutasi_detail . '<br/>';

			$mutasi = json_decode($req->mutasi);
			$mutasi_detail = json_decode($req->mutasi_detail);
			// echo $mutasi->tanggal;

			// generate nomor mutasi
			$mutasi_counter = \DB::table('appsetting')->whereName('mutasi_counter')->first()->value;
			$mutasi_number = 'MOV/' . date('Y') . '/000' . $mutasi_counter++;
			\DB::table('appsetting')->whereName('mutasi_counter')->update([
				'value' => $mutasi_counter
			]);

			//generate tanggal
			$mutasi_date = $mutasi->tanggal;
      $arr_tgl = explode('-',$mutasi_date);
      $mutasi_date = new \DateTime();
      $mutasi_date->setDate($arr_tgl[2],$arr_tgl[1],$arr_tgl[0]);

			// insert mutasi
			$mutasi_id = \DB::table('mutasi')->insertGetId([
				'tanggal' => $mutasi_date,
				'user_id' => \Auth::user()->id,
				'nomor_mutasi' => $mutasi_number,
				'in_out' => $mutasi->jenis
			]);

			// insert ke detail mutasi
			foreach($mutasi_detail->obat as $dt){
				$mutasi_detail_id = \DB::table('mutasi_detail')->insertGetId([
					'mutasi_id' => $mutasi_id,
					'obat_id' => $dt->obat_id,
					'jumlah' => $dt->jumlah ,
				]);

				if($mutasi->jenis == 'I'){
					// Mutasi Masuk ...menambah stok
					// insert ke table stok
					$stok_id = \DB::table('stok')->insertGetId([
						'obat_id' => $dt->obat_id,
						'stok_awal' => $dt->jumlah,
						'current_stok' => $dt->jumlah,
						'mutasi_detail_id' => $mutasi_detail_id,
					]);

					// insert ke table stok moving
					\DB::table('stok_moving')->insert([
						'stok_id' => $stok_id,
						'obat_id' => $dt->obat_id,
						'in_out' => 'I',
						'jumlah' => $dt->jumlah
					]);
				}else{
					// MUTASI KELUAR MENGURANGI STOK
					$data_stok_obat = \DB::table('stok')
					 										->where('obat_id',$dt->obat_id)
															->orderBy('created_at','asc')
															->get();
					// KURANGI STOK
					$jumlah_keluar = $dt->jumlah;
					foreach($data_stok_obat as $dtst){
						if($dtst->current_stok >= $jumlah_keluar){
							// update stok
							\DB::table('stok')->whereId($dtst->id)->update(['current_stok' => \DB::raw('current_stok - ' . $jumlah_keluar)]);
							$jumlah_keluar = 0;
							// exit;
						}else{
							\DB::table('stok')->whereId($dtst->id)->update(['current_stok'=>0]);
							$jumlah_keluar -= $dtst->current_stok;
						}
					}

				}



			}

			// insert ke table stok_moving
			return redirect('inventory/mutasi');
		});
	}

	public function edit($mutasi_id){
		$mutasi = \DB::table('VIEW_MUTASI')->find($mutasi_id);
		$mutasi_detail = \DB::table('VIEW_MUTASI_DETAIL')->where('mutasi_id',$mutasi->id)->get();

		return view('inventory/mutasi/edit',[
			'mutasi' => $mutasi,
			'mutasi_detail' => $mutasi_detail,
		]);
	}

  // public function edit($mutasi_id){
	// 	$satuan = \DB::table('satuan')
	// 					->orderBy('created_at','desc')
	// 					->get();
	// 	$select_satuan=[];
	// 	foreach($satuan as $dt){
	// 		$select_satuan[$dt->id] = $dt->nama;
	// 	}
	//
  //   $data = \DB::Table('mutasi')
  //             ->find($mutasi_id);
	//
  //   return view('inventory.mutasi.edit',[
  //     'data' => $data,
	// 		'select_satuan' => $select_satuan
  //   ]);
  // }
	//
	// public function update(Request $req){
	// 	return \DB::transaction(function()use($req){
	// 		\DB::table('mutasi')
	// 			->where('id',$req->mutasi_id)
	// 			->update([
	// 				'nama' => $req->nama,
	// 				'satuan_besar_id' => $req->satuan_besar,
	// 				'satuan_kecil_id' => $req->satuan_kecil,
	// 			]);
	//
	// 			return redirect('inventory/mutasi');
	// 	});
	// }



}
