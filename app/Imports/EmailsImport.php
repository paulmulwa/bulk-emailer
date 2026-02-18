<?php

namespace App\Imports;

use App\Models\Email;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmailsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Email([
            'first_name' => $row['first_name'],
            'email' => $row['email'],
        ]);
    }
}
