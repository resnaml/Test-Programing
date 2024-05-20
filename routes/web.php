<?php

use App\Customer;
use App\Barang;
use App\InvoiceCounter;
use App\Sales;
use App\SalesDet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/daftar-transaksi', function () {
    $sales = Sales::with(['salesDet','customer'])->get();
    // $salesdt = SalesDet::where('sales_id',2)->count('qty');
    // dd($salesdt);
    return view('transaksi',compact('sales'));
});

Route::get('/costumer/{id}', function ($id) {
    $customer = Customer::find($id);
    return response()->json($customer);
});

Route::get('/barangs',function(){
    return response()->json(Barang::all());
});

Route::get('/transaksi', function () {
    $customer = Customer::all();
    $barangs = Barang::all();
    return view('input',compact('customer','barangs'));
});

Route::post('/transaksi', function(Request $request){
    
    
    $request->validate([
        'kode' => 'required',
        'tgl' => 'required',
        'cust_id' => 'required',
        'subtotal' => 'nullable',
        'diskon' => 'nullable|min:1|max:100',
        'ongkir' => 'nullable',
        'total_bayar' => 'required',
    ]);

    DB::beginTransaction();

    $sales = Sales::create([
        'kode' => $request->kode,
        'tgl' => $request->tgl,
        'cust_id' => $request->cust_id,
        'subtotal' => $request->sub_total,
        'diskon' => $request->diskon,
        'ongkir' => $request->ongkir,
        'jml_qty' => $request->jml_qty,
        'total_bayar' => $request->total_bayar
    ]);


        // $salesdt->id_barang = $request->id_barang;
        // $salesdt->quantity =  $request->quantity;
        // $salesdt->harga =  $request->harga;
        // $salesdt->persen =  $request->persen;
        // $salesdt->diskon_persen =  $request->diskon_persen;
        // $salesdt->diskon_harga =  $request->diskon_harga;
        // $salesdt->total =  $request->total;

    foreach ($request->id_barang as $key => $items ) {
        $salesdt['barang_id'] = $request->id_barang[$key];
        $salesdt['harga_bandrol'] = $request->harga[$key];
        $salesdt['qty'] = $request->quantity[$key];
        $salesdt['diskon_pct'] = $request->persen[$key];
        $salesdt['diskon_nilai'] = $request->diskon_persen[$key];
        $salesdt['harga_diskon'] = $request->diskon_harga[$key];
        $salesdt['total'] = $request->total_bayar;
        $salesdt['sales_id'] = $sales->id;
        SalesDet::create($salesdt);
    }
    
    // $sales['salesdt_id'] = $sales->id;
    // $sales->save();

    DB::commit();

    $message = "Berhasil";
    return Redirect::to('/daftar-transaksi')->with('message', $message);
});
