<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Daily;
use DateTime;

class DailyController extends Controller
{
    public function import()
    {
        // dailies.JSON
        $dailies = file_get_contents('https://absensi.campus.co.id/api/magang/dailies');
        $data_dailies = array_slice(json_decode($dailies, true), 1);

        dd($data_dailies);

        foreach ($data_dailies as $data) {
            Daily::insert([
                'id' => $data['id'],
                'user_id' => $data['user_id'],
                'division_id' => $data['division_id'],
                'date' => $data['date'],
                'note' => $data['note'],
                'created_at' => $data['created_at'] ? DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $data['created_at'])->format('Y-m-d H:i:s') : null,
                'updated_at' => $data['updated_at'] ? DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $data['updated_at'])->format('Y-m-d H:i:s') : null

                // 'created_at' => date('Y-m-d\TH:i:s.u\Z'),
                // 'updated_at' => date('Y-m-d\TH:i:s.u\Z') 
                
                // 'created_at' => $data['created_at'],
                // 'updated_at' => $data['updated_at']
            ]);
        }

        return response()->json(['message' => 'Data Daily imported successfully']);
    }
}
