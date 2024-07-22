<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Divisi;
use DateTime;

class DivisiController extends Controller
{
    public function import()
    {
        $divisi = file_get_contents('https://absensi.campus.co.id/api/magang/divisi');
        $data_divisi = json_decode($divisi, true);

        // dd($data_divisi);

        foreach ($data_divisi as $data) {
            Divisi::insert([
                'id' => $data['id'],
                'group_id' => $data['group_id'],
                'code' => $data['code'],
                'name' => $data['name'],
                'wewenang' => $data['wewenang'],
                'created_at' => $data['created_at'] ? DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $data['created_at'])->format('Y-m-d H:i:s') : null,
                'updated_at' => $data['updated_at'] ? DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $data['updated_at'])->format('Y-m-d H:i:s') : null

                // 'created_at' => $data['created_at'],
                // 'updated_at' => $data['updated_at']
            ]);
        }

        return response()->json(['message' => 'Data Divisi imported successfully']);
    }

}
