<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PasienController extends Controller
{
	public function index(){
    $data = \DB::Table('pasien')
							->orderBy('created_at','desc')
              ->get();

		return view('master.pasien.index',[
      'data' => $data
    ]);
	}

  public function create(){
		$pasien = \DB::table('pasien')
						->orderBy('created_at','desc')
						->get();
		$select_pasien=[];
		foreach($pasien as $dt){
			$select_pasien[$dt->id] = $dt->nama;
		}
    return view('master.pasien.create',[
			'select_pasien' => $select_pasien
		]);
  }

	public function insert(Request $req){
		return \DB::transaction(function()use($req){

			// generate tanggal_lahir
			$tanggal_lahir = $req->tanggal_lahir;
      $arr_tgl = explode('-',$tanggal_lahir);
      $tanggal_lahir = new \DateTime();
      $tanggal_lahir->setDate($arr_tgl[2],$arr_tgl[1],$arr_tgl[0]);

			// generate NIK Pasien
			$pasien_counter = \DB::table('appsetting')->whereName('pasien_counter')->first()->value;
			$kode = '0000' . $pasien_counter++ . '/BPU-ZIKMAL/' . $this->romanic_number(date('m')).'/'.date('Y');
			// $kode = '00000/BPU-ZIKMAL/' strtoupper(substr($req->nama,0,2)) . '-000-' . $this->romanic_number(date('m')) . '-' . date('Y');
			// update counter
			\DB::table('appsetting')->whereName('pasien_counter')->update([
				'value' => $pasien_counter
			]);

			$pasien_id = \DB::table('pasien')->insertGetId([
				'kode' => $kode,
				'nama' => $req->nama,
				'jenis_kelamin' => $req->jenis_kelamin,
				'alamat' => $req->alamat,
				'desa' => $req->desa,
				'kecamatan' => $req->kecamatan,
				'kabupaten' => $req->kabupaten,
				'provinsi' => $req->provinsi,
				'telepon' => $req->telepon,
				'tanggal_lahir' => $tanggal_lahir,
				'tempat_lahir' => $req->tempat_lahir,
				'pekerjaan' => $req->pekerjaan,
				'is_bpjs' => $req->is_bpjs,
				'no_bpjs' => $req->no_bpjs,
				'telepon' => $req->telepon,
				'ktp' => $req->ktp,

			]);

			return redirect('master/pasien/edit/'.$pasien_id);
		});
	}

	function romanic_number($integer, $upcase = true)
	{
	    $table = array('M'=>1000, 'CM'=>900, 'D'=>500, 'CD'=>400, 'C'=>100, 'XC'=>90, 'L'=>50, 'XL'=>40, 'X'=>10, 'IX'=>9, 'V'=>5, 'IV'=>4, 'I'=>1);
	    $return = '';
	    while($integer > 0)
	    {
	        foreach($table as $rom=>$arb)
	        {
	            if($integer >= $arb)
	            {
	                $integer -= $arb;
	                $return .= $rom;
	                break;
	            }
	        }
	    }

	    return $return;
	}

  public function edit($pasien_id){
		// $pasien = \DB::table('pasien')
		// 				->select('pasien.*',\DB::raw('date_format(pasien.tanggal_lahir,"%d-%m-%Y") as tanggal_lahir_formatted') )
		// 				->orderBy('created_at','desc')
		// 				->get();
		// $select_pasien=[];
		// foreach($pasien as $dt){
		// 	$select_pasien[$dt->id] = $dt->nama;
		// }

    $data = \DB::Table('pasien')
							->select('pasien.*',\DB::raw('date_format(pasien.tanggal_lahir,"%d-%m-%Y") as tanggal_lahir_formatted') )
              ->find($pasien_id);
    return view('master.pasien.edit',[
      'data' => $data,
			// 'select_pasien' => $select_pasien
    ]);
  }

	public function update(Request $req){
		return \DB::transaction(function()use($req){
			// generate tanggal_lahir
			$tanggal_lahir = $req->tanggal_lahir;
      $arr_tgl = explode('-',$tanggal_lahir);
      $tanggal_lahir = new \DateTime();
      $tanggal_lahir->setDate($arr_tgl[2],$arr_tgl[1],$arr_tgl[0]);
			
			\DB::table('pasien')
				->where('id',$req->pasien_id)
				->update([
					'nama' => $req->nama,
					'jenis_kelamin' => $req->jenis_kelamin,
					'alamat' => $req->alamat,
					'desa' => $req->desa,
					'kecamatan' => $req->kecamatan,
					'kabupaten' => $req->kabupaten,
					'provinsi' => $req->provinsi,
					'telepon' => $req->telepon,
					'tanggal_lahir' => $tanggal_lahir,
					'tempat_lahir' => $req->tempat_lahir,
					'pekerjaan' => $req->pekerjaan,
					'is_bpjs' => $req->is_bpjs,
					'no_bpjs' => $req->no_bpjs,
					'telepon' => $req->telepon,
					'ktp' => $req->ktp,

				]);

				return redirect('master/pasien');
		});
	}


}
