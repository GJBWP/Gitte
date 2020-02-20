<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\MdwExport;
use App\Exports\HoursExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class ExportController extends Controller
{


    public function exportHours()
    {
        return Excel::download(new HoursExport, 'Uren.xlsx');
    }
}
