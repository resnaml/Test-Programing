<?php

use App\Barang;
use App\Customer;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Barang::create([
            'nama' => 'Barang A',
            'kode' => 'A001',
            'harga' => 200000
        ]);

        Barang::create([
            'nama' => 'Barang B',
            'kode' => 'C025',
            'harga' => 350000
        ]);

        Barang::create([
            'nama' => 'Barang C',
            'kode' => 'A102',
            'harga' => 125000
        ]);

        Barang::create([
            'nama' => 'Barang D',
            'kode' => 'A301',
            'harga' => 300000
        ]);

        Barang::create([
            'nama' => 'Barang E',
            'kode' => 'B221',
            'harga' => 300000
        ]);

        Customer::create([
            'kode' => 'C01',
            'name' => 'Jajang',
            'telp' => '089237132'
        ]);

        Customer::create([
            'kode' => 'C02',
            'name' => 'Haikal',
            'telp' => '0892327132'
        ]);

        Customer::create([
            'kode' => 'C03',
            'name' => 'Suep',
            'telp' => '0892371423'
        ]);
    }
}
