<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class ReportController extends Controller
{
    public function import()
    {
        // dailies.JSON
        $dailies = file_get_contents('https://absensi.campus.co.id/api/magang/dailies');
        $data_dailies = array_slice(json_decode($dailies, true), 1);


        foreach($data_dailies as $dailies){
            foreach ($dailies['report'] as $data) {
                Report::insert([
                    'id_tugas' => $data['id_tugas'],
                    'daily_id' => $dailies['id'],
                    'score' => $data['score'],
                ]);
            }
        }

        return response()->json(['message' => 'Data Report imported successfully']);
    }
}
