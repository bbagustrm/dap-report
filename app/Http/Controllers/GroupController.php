<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use DateTime;

class GroupController extends Controller
{
    public function import()
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
}
