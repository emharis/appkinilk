<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class KaryawanController extends Controller
{
	public function index(){
    $data = \DB::Table('karyawan')
							->orderBy('created_at','desc')
              ->get();

		return view('master.karyawan.index',[
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
    return view('master.karyawan.create',[
			'select_poli' => $select_poli
		]);
  }

	public function insert(Request $req){
		return \DB::transaction(function()use($req){

			// generate tanggal_lahir
			$tanggal_lahir = $req->tanggal_lahir;
      $arr_tgl = explode('-',$tanggal_lahir);
      $tanggal_lahir = new \DateTime();
      $tanggal_lahir->setDate($arr_tgl[2],$arr_tgl[1],$arr_tgl[0]);

			// generate NIK Karyawan
			$karyawan_counter = \DB::table('appsetting')->where('name','karyawan_counter')->first()->value;
			$nik =strtoupper(substr($req->nama,0,2)) . '-000' . $karyawan_counter++ . '-' . $this->romanic_number(date('m')) . '-' . date('Y');
			// update counter
			\DB::table('appsetting')->where('name','karyawan_counter')->update([
				'value' => $karyawan_counter
			]);

			\DB::table('karyawan')->insert([
				'nik' => $nik,
				'nama' => $req->nama,
				'jenis_kelamin' => $req->jenis_kelamin,
				'alamat' => $req->alamat,
				'telepon' => $req->telepon,
				'tanggal_lahir' => $tanggal_lahir,
				'tempat_lahir' => $req->tempat_lahir,

			]);

			return redirect('master/karyawan');
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

  public function edit($karyawan_id){
		$poli = \DB::table('poli')
						->orderBy('created_at','desc')
						->get();
		$select_poli=[];
		foreach($poli as $dt){
			$select_poli[$dt->id] = $dt->nama;
		}

    $data = \DB::Table('karyawan')
              ->find($karyawan_id);
    return view('master.karyawan.edit',[
      'data' => $data,
			'select_poli' => $select_poli
    ]);
  }

	public function update(Request $req){
		return \DB::transaction(function()use($req){
			\DB::table('karyawan')
				->where('id',$req->karyawan_id)
				->update([
					'nama' => $req->nama,
					'jenis_kelamin' => $req->jenis_kelamin,
					'alamat' => $req->alamat,
					'telepon' => $req->telepon,
					'tanggal_lahir' => $tanggal_lahir,
					'tempat_lahir' => $req->tempat_lahir,

				]);

				return redirect('master/karyawan');
		});
	}


}
