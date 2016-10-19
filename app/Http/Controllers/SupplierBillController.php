<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SupplierBillController extends Controller
{
	public function index(){
		$data = \DB::table('VIEW_SUPPLIER_BILL')->orderBy('order_date','desc')->get();
    return view('invoice.supplier-bill.index',[
			'data' => $data
    ]);
	}

	public function create(){
		return view('invoice.supplier-bill.create');
	}

	public function insert(Request $req){
		return \DB::transaction(function()use($req){
			// create supplier bill number
			$bill_counter = \DB::table('appsetting')->whereName('supplier_bill_counter')->first()->value;
			$bill_number = 'BILL/'.date('Y').'/000'.$bill_counter++;
			\DB::table('appsetting')->whereName('supplier_bill_counter')->update(['value'=>$bill_counter]);

			// generate date
			//generate tanggal
			$order_date = $req->tanggal_order;
      $arr_tgl = explode('-',$order_date);
      $order_date = new \DateTime();
      $order_date->setDate($arr_tgl[2],$arr_tgl[1],$arr_tgl[0]);

			$due_date = $req->jatuh_tempo;
      $arr_tgl = explode('-',$due_date);
      $due_date = new \DateTime();
      $due_date->setDate($arr_tgl[2],$arr_tgl[1],$arr_tgl[0]);

			$total = str_replace(',','',$req->jumlah);
			// echo $total;

			$bill_id = \DB::table('supplier_bill')->insertGetId([
				'bill_number' => $bill_number,
				'supplier_id' => $req->supplier_id,
				'no_nota_supplier' => $req->no_nota_supplier,
				'order_date' => $order_date,
				'due_date' => $due_date,
				'status' => 'O',
				'total' => $total,
				'user_id' => \Auth::user()->id
			]);

			return redirect('invoice/supplier-bill/edit/'.$bill_id);

		});
	}

	public function update(Request $req){
		return \DB::transaction(function()use($req){
			// generate date
			//generate tanggal
			$order_date = $req->tanggal_order;
      $arr_tgl = explode('-',$order_date);
      $order_date = new \DateTime();
      $order_date->setDate($arr_tgl[2],$arr_tgl[1],$arr_tgl[0]);

			$due_date = $req->jatuh_tempo;
      $arr_tgl = explode('-',$due_date);
      $due_date = new \DateTime();
      $due_date->setDate($arr_tgl[2],$arr_tgl[1],$arr_tgl[0]);

			$paid_date = $req->tanggal_lunas;
      $arr_tgl = explode('-',$paid_date);
      $paid_date = new \DateTime();
      $paid_date->setDate($arr_tgl[2],$arr_tgl[1],$arr_tgl[0]);

			$total = str_replace(',','',$req->jumlah);
			// echo $total;

			\DB::table('supplier_bill')
			->where('id',$req->bill_id)
			->update([
				'supplier_id' => $req->supplier_id,
				'no_nota_supplier' => $req->no_nota_supplier,
				'order_date' => $order_date,
				'due_date' => $due_date,
				'paid_date' => $paid_date,
				'status' => 'O',
				'total' => $total,
				// 'user_id' => \Auth::user()->id
			]);

			return redirect('invoice/supplier-bill/edit/'.$req->bill_id);

		});
	}

	public function setAsPaid(Request $req){
		\DB::table('supplier_bill')->whereId($req->bill_id)->update(['status'=>'P']);
		return redirect()->back();
	}

	public function edit($bill_id){
		$bill = \DB::table('VIEW_SUPPLIER_BILL')->find($bill_id);

		if($bill->status == 'O'){
			return view('invoice.supplier-bill.edit',[
				'bill' => $bill
			]);
		}elseif($bill->status == 'P'){
			return view('invoice.supplier-bill.paid',[
				'bill' => $bill
			]);
		}


	}


}
