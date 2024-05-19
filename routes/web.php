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
    return view('welcome');
});

Route::get('/daftar-transaksi', function () {
    $sales = Sales::all();
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
        'total_bayar' => $request->total_bayar
    ]);

    // dd(
    //     $request->id_barang,
    //     $request->quantity,
    //     $request->harga,
    //     $request->persen,
    //     $request->diskon_persen,
    //     $request->diskon_harga,
    //     $request->total
    // );


    // dd($data2);
    // foreach ($variable as $key ) {
    //     # code...
    // }
    SalesDet::createMany([
        'sales_id' => $sales->id,
        'barang_id' => $request->id_barang,
        'harga_bandrol' => $request->harga,
        'qty' => $request->quantity,
        'diskon_pct' => $request->diskon_persen,
        'diskon_nilai' => $request->diskon_harga,
        'harga_diskon' => $request->total,
        'total' => $request->total_bayar,
    ]);

    DB::commit();

    $message = "Berhasil";
    return Redirect::to('/daftar-transaksi')->with('message', $message);
});
