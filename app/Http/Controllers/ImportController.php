<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Divisi;
use App\Models\User;
use App\Models\Group;
use App\Models\Jabatan;
use App\Models\Daily;
use App\Models\Report;
use App\Models\Tugas;
use DateTime;

class ImportController extends Controller
{
    public function import_divisi()
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
                'tugas' => json_encode($data['tugas']),
                'wewenang' => $data['wewenang'],
                'created_at' => $data['created_at'] ? DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $data['created_at'])->format('Y-m-d H:i:s') : null,
                'updated_at' => $data['updated_at'] ? DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $data['updated_at'])->format('Y-m-d H:i:s') : null

                // 'created_at' => $data['created_at'],
                // 'updated_at' => $data['updated_at']
            ]);
        }

        return response()->json(['message' => 'Data Divisi imported successfully']);
    }

    public function import_user()
    {
        // user.JSON
        $user = file_get_contents('https://absensi.campus.co.id/api/magang/user');
        $data_user = json_decode($user, true);

        // dd($data_divisi);

        foreach ($data_user as $data) {
            User::insert([
                'id' => $data['id'],
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'birthdate' => $data['birthdate'],
                'phone_number' => $data['phone_number'],
                'address' => $data['address']
            ]);
        }

        return response()->json(['message' => 'Data User imported successfully']);
    }

    public function import_group()
    {
        // user.JSON
        $group = file_get_contents('https://absensi.campus.co.id/api/magang/group');
        $data_group = json_decode($group, true);

        // dd($data_group);

        foreach ($data_group as $data) {
            Group::insert([
                'name' => $data['name'],
                'created_at' => $data['created_at'] ? DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $data['created_at'])->format('Y-m-d H:i:s') : null,
                'updated_at' => $data['updated_at'] ? DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $data['updated_at'])->format('Y-m-d H:i:s') : null

                // 'created_at' => date('Y-m-d\TH:i:s.u\Z'),
                // 'updated_at' => date('Y-m-d\TH:i:s.u\Z') 
                // 'created_at' => $data['created_at'],
                // 'updated_at' => $data['updated_at']

            ]);
        }

        return response()->json(['message' => 'Data Group imported successfully']);
    }

    public function import_jabatan()
    {
        // jabatan.JSON
        $jabatan = file_get_contents('https://absensi.campus.co.id/api/magang/jabatan_attr');
        $data_jabatan = json_decode($jabatan, true);

        // dd($data_jabatan);

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
    
    public function import_daily()
    {
        // dailies.JSON
        $dailies = file_get_contents('https://absensi.campus.co.id/api/magang/dailies');
        $data_dailies = array_slice(json_decode($dailies, true), 1);

        // dd($data_dailies);

        foreach ($data_dailies as $data) {
            Daily::insert([
                'id' => $data['id'],
                'user_id' => $data['user_id'],
                'division_id' => $data['division_id'],
                'report' => json_encode($data['report']),
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