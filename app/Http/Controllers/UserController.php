<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function import()
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
}
