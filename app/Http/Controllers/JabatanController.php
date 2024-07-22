<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jabatan;
use DateTime;

class JabatanController extends Controller
{
    public function import()
    {
        // jabatan.JSON
        $jabatan = file_get_contents('https://absensi.campus.co.id/api/magang/jabatan_attr');
        $data_jabatan = json_decode($jabatan, true);

        // dd($data_divisi);

        foreach ($data_jabatan as $data) {
            Jabatan::insert([
                'id' => $data['id'],
                'division_id' => $data['division_id'],
                'user_id' => $data['user_id'],
                'created_at' => $data['created_at'] ? DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $data['created_at'])->format('Y-m-d H:i:s') : null,
                'updated_at' => $data['updated_at'] ? DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $data['updated_at'])->format('Y-m-d H:i:s') : null

                // 'created_at' => date('Y-m-d\TH:i:s.u\Z'),
                // 'updated_at' => date('Y-m-d\TH:i:s.u\Z') 
                // 'created_at' => $data['created_at'],
                // 'updated_at' => $data['updated_at']
            ]);
        }

        return response()->json(['message' => 'Data Jabatan imported successfully']);
    }
}
