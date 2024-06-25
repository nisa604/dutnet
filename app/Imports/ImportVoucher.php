<?php

namespace App\Imports;

use App\Models\M_voucher;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportVoucher implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new M_voucher([
            'kode_voucher' => $row['username'],
            'id_jenis' => $row['profile'],
        ]);
    }

    public function fields(): array
    {
        return [
            'username' => 'kode_voucher',
            'profile' => 'id_jenis',
        ];
    }
}
