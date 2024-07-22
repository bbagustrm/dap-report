<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    public function import()
    {
        // divisi.JSON
        $divisi = file_get_contents('https://absensi.campus.co.id/api/magang/divisi');
        $data_divisi = json_decode($divisi, true);

        // dd($data_divisi);

        foreach($data_divisi as $divisi){
            foreach ($divisi['tugas'] as $data) {
                Tugas::insert([
                    'id_tugas' => $data['id_tugas'],
                    'divisi_id' => $divisi['id'],
                    'tugas' => $data['tugas'],
                    'tipe' => $data['tipe'],
                    'target' => $data['target']
                ]);
            }
        }

        return response()->json(['message' => 'Data Tugas imported successfully']);
    }
}
