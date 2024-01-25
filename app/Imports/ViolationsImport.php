<?php

namespace App\Imports;

use App\Models\Violation;
use Maatwebsite\Excel\Concerns\ToModel;

class ViolationsImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Violation([
            'title' => $row[0]
        ]);
    }
}
