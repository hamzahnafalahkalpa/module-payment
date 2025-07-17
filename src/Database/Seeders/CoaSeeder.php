<?php

namespace Hanafalah\ModulePayment\Database\Seeders;

use Hanafalah\LaravelSupport\Concerns\Support\HasRequestData;
use Hanafalah\ModulePayment\Contracts\Data\CoaData;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoaSeeder extends Seeder
{
    use HasRequestData;

    public function run(): void
    {
        $coas = [
            ['name' => 'ASET', 'code' => '1', 'parent_id' => null, 'coa_type' => ['name' => 'Asset'], 'balance_type' => 'DEBIT'],
            ['name' => 'ASET LANCAR', 'code' => '1.1', 'parent_code' => '1', 'coa_type' => ['name' => 'Current Asset'], 'balance_type' => 'DEBIT'],
            ['name' => 'Kas', 'code' => '1.1.1', 'parent_code' => '1.1', 'coa_type' => ['name' => 'Current Asset'], 'balance_type' => 'DEBIT'],
            ['name' => 'Bank', 'code' => '1.1.2', 'parent_code' => '1.1', 'coa_type' => ['name' => 'Current Asset'], 'balance_type' => 'DEBIT'],
            ['name' => 'Piutang Usaha', 'code' => '1.1.3', 'parent_code' => '1.1', 'coa_type' => ['name' => 'Current Asset'], 'balance_type' => 'DEBIT'],
            ['name' => 'Persediaan', 'code' => '1.1.4', 'parent_code' => '1.1', 'coa_type' => ['name' => 'Current Asset'], 'balance_type' => 'DEBIT'],
            ['name' => 'ASET TIDAK LANCAR', 'code' => '1.2', 'parent_code' => '1', 'coa_type' => ['name' => 'Non-Current Asset'], 'balance_type' => 'DEBIT'],
            ['name' => 'Tanah', 'code' => '1.2.1', 'parent_code' => '1.2', 'coa_type' => ['name' => 'Non-Current Asset'], 'balance_type' => 'DEBIT'],
            ['name' => 'Gedung', 'code' => '1.2.2', 'parent_code' => '1.2', 'coa_type' => ['name' => 'Non-Current Asset'], 'balance_type' => 'DEBIT'],
            ['name' => 'Kendaraan', 'code' => '1.2.3', 'parent_code' => '1.2', 'coa_type' => ['name' => 'Non-Current Asset'], 'balance_type' => 'DEBIT'],

            ['name' => 'KEWAJIBAN', 'code' => '2', 'parent_id' => null, 'coa_type' => ['name' => 'Liability'], 'balance_type' => 'KREDIT'],
            ['name' => 'KEWAJIBAN LANCAR', 'code' => '2.1', 'parent_code' => '2', 'coa_type' => ['name' => 'Current Liability'], 'balance_type' => 'KREDIT'],
            ['name' => 'Utang Usaha', 'code' => '2.1.1', 'parent_code' => '2.1', 'coa_type' => ['name' => 'Current Liability'], 'balance_type' => 'KREDIT'],
            ['name' => 'Beban Akrual', 'code' => '2.1.2', 'parent_code' => '2.1', 'coa_type' => ['name' => 'Current Liability'], 'balance_type' => 'KREDIT'],
            ['name' => 'KEWAJIBAN JANGKA PANJANG', 'code' => '2.2', 'parent_code' => '2', 'coa_type' => ['name' => 'Non-Current Liability'], 'balance_type' => 'KREDIT'],
            ['name' => 'Utang Bank', 'code' => '2.2.1', 'parent_code' => '2.2', 'coa_type' => ['name' => 'Non-Current Liability'], 'balance_type' => 'KREDIT'],

            ['name' => 'EKUITAS', 'code' => '3', 'parent_id' => null, 'coa_type' => ['name' => 'Equity'], 'balance_type' => 'KREDIT'],
            ['name' => 'Modal Pemilik', 'code' => '3.1', 'parent_code' => '3', 'coa_type' => ['name' => 'Equity'], 'balance_type' => 'KREDIT'],
            ['name' => 'Laba Ditahan', 'code' => '3.2', 'parent_code' => '3', 'coa_type' => ['name' => 'Equity'], 'balance_type' => 'KREDIT'],

            ['name' => 'PENDAPATAN', 'code' => '4', 'parent_id' => null, 'coa_type' => ['name' => 'Revenue'], 'balance_type' => 'KREDIT'],
            ['name' => 'Pendapatan Penjualan', 'code' => '4.1', 'parent_code' => '4', 'coa_type' => ['name' => 'Revenue'], 'balance_type' => 'KREDIT'],
            ['name' => 'Pendapatan Jasa', 'code' => '4.2', 'parent_code' => '4', 'coa_type' => ['name' => 'Revenue'], 'balance_type' => 'KREDIT'],

            ['name' => 'BEBAN', 'code' => '5', 'parent_id' => null, 'coa_type' => ['name' => 'Expense'], 'balance_type' => 'DEBIT'],
            ['name' => 'Beban Gaji', 'code' => '5.1', 'parent_code' => '5', 'coa_type' => ['name' => 'Expense'], 'balance_type' => 'DEBIT'],
            ['name' => 'Beban Sewa', 'code' => '5.2', 'parent_code' => '5', 'coa_type' => ['name' => 'Expense'], 'balance_type' => 'DEBIT'],
            ['name' => 'Beban Listrik', 'code' => '5.3', 'parent_code' => '5', 'coa_type' => ['name' => 'Expense'], 'balance_type' => 'DEBIT'],

            ['name' => 'PENDAPATAN LAINNYA', 'code' => '6', 'parent_id' => null, 'coa_type' => ['name' => 'Other Income'], 'balance_type' => 'KREDIT'],
            ['name' => 'Pendapatan Bunga', 'code' => '6.1', 'parent_code' => '6', 'coa_type' => ['name' => 'Other Income'], 'balance_type' => 'KREDIT'],

            ['name' => 'BEBAN LAINNYA', 'code' => '7', 'parent_id' => null, 'coa_type' => ['name' => 'Other Expense'], 'balance_type' => 'DEBIT'],
            ['name' => 'Rugi Penjualan Aset', 'code' => '7.1', 'parent_code' => '7', 'coa_type' => ['name' => 'Other Expense'], 'balance_type' => 'DEBIT'],

            ['name' => 'HPP', 'code' => '8', 'parent_id' => null, 'coa_type' => ['name' => 'Cost of Goods Sold'], 'balance_type' => 'DEBIT'],
            ['name' => 'HPP Barang Dagang', 'code' => '8.1', 'parent_code' => '8', 'coa_type' => ['name' => 'Cost of Goods Sold'], 'balance_type' => 'DEBIT'],
        ];


        foreach ($coas as $coa) {
            app(config('app.contracts.Coa'))->prepareStoreCoa($this->requestDTO(CoaData::class, $coa));
        }
    }
}
