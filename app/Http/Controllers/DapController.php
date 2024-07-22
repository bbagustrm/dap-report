<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Divisi;
use App\Models\Daily;
use App\Models\Tugas;
use Illuminate\Http\Request;

use DataTables;
use PhpParser\JsonDecoder;
use DateTime;


class DapController extends Controller
{

    public function create()
    {
        $daily = Daily::select('dailies.*', 'users.name as user_name', 'divisis.code as division_code', 'divisis.name as division_name')
            ->join('users', 'users.id', '=', 'dailies.user_id')
            ->join('divisis', 'divisis.id', '=', 'dailies.division_id');

        $users = User::all();
        $divisions = Divisi::all();

        $view_data = [
            'daily' => $daily,
            'users' => $users,
            'divisions' => $divisions,
        ];

        return view('create', $view_data);
    }

    public function store(Request $request)
    {
        $user_name = $request->input('user_name');
        $division_name = $request->input('division_name');
        $note = $request->input('note');

        $user = User::where('name', $user_name)->first();
        if (!$user) {
            return redirect()->back()->withErrors(['User not found']);
        }

        $division = Divisi::where('name', $division_name)->first();
        if (!$division) {
            return redirect()->back()->withErrors(['Division not found']);
        }

        $date_current = new DateTime();

        $daily = new Daily();
        $daily->user_id = $user->id;
        $daily->division_id = $division->id;
        $daily->note = $note;

        $daily->created_at = $date_current->format('Y-m-d H:i:s');
        $daily->updated_at = $date_current->format('Y-m-d H:i:s');
        $daily->date = substr($daily->created_at, 0, 10);
        $daily->save();

        return redirect('/table');
    }


    public function dataTable(Request $request)
    {
        if ($request->ajax()) {
            $query = Daily::select('dailies.*', 'users.name as user_name', 'divisis.code as division_code', 'divisis.name as division_name')
                ->join('users', 'users.id', '=', 'dailies.user_id')
                ->join('divisis', 'divisis.id', '=', 'dailies.division_id');

            if ($request->has('start_date') && $request->has('end_date') && $request->start_date && $request->end_date) {
                $start_date = $request->start_date;
                $end_date = $request->end_date;
                $query->whereBetween('dailies.date', [$start_date, $end_date]);
            }

            if ($request->has('division') && $request->division) {
                $division = $request->division;
                $query->where('divisis.name', $division);
            }

            $dailies = $query->get();

            return datatables()->of($dailies)
                ->addColumn('action', function ($row) {
                    $showUrl = route('dailies.show', $row->id);
                    $editUrl = route('dailies.edit', $row->id);
                    $deleteUrl = route('dailies.destroy', $row->id);
                    $csrfToken = csrf_token();
                    $btn = '<a href="' . $showUrl . '" class="btn-primary">Show</a>';
                    $btn .= ' ';
                    $btn .= '<a href="' . $editUrl . '" class="btn-danger">Edit</a>';
                    $btn .= ' ';
                    $btn .= '<form action="' . $deleteUrl . '" method="POST" style="display:inline-block;">
                            ' . method_field('DELETE') . '
                            <input type="hidden" name="_token" value="' . $csrfToken . '">
                            <button type="submit" class="btn-warning" onclick="return confirm(\'Are you sure?\')">Delete</button>
                         </form>';
                    return $btn;
                })
                ->addIndexColumn()
                ->make(true);
        }
        $divisions = Divisi::all();
        return view('table', compact('divisions'));
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $query = Daily::select('dailies.*', 'users.name as user_name', 'divisis.code as division_code', 'divisis.name as division_name')
            ->join('users', 'users.id', '=', 'dailies.user_id')
            ->join('divisis', 'divisis.id', '=', 'dailies.division_id');

        $daily = $query->find($id);


        $view_data = [
            'daily' => $daily
        ];

        return view('show', $view_data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $query = Daily::select('dailies.*', 'users.name as user_name', 'divisis.code as division_code', 'divisis.name as division_name')
            ->join('users', 'users.id', '=', 'dailies.user_id')
            ->join('divisis', 'divisis.id', '=', 'dailies.division_id');


        $daily = $query->find($id);
        $users = User::all();
        $divisions = Divisi::all();

        $view_data = [
            'daily' => $daily,
            'users' => $users,
            'divisions' => $divisions,
        ];

        return view('edit', $view_data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user_name = $request->input('user_name');
        $division_name = $request->input('division_name');
        $note = $request->input('note');

        // Cari user berdasarkan user_name
        $user = User::where('name', $user_name)->first();
        if (!$user) {
            // Handle user tidak ditemukan
            return redirect()->back()->withErrors(['User not found']);
        }

        // Cari division berdasarkan division_name
        $division = Divisi::where('name', $division_name)->first();
        if (!$division) {
            // Handle division tidak ditemukan
            return redirect()->back()->withErrors(['Division not found']);
        }

        // Ambil tanggal saat ini
        $date_current = new DateTime();

        // Temukan Daily berdasarkan ID
        $daily = Daily::find($id);
        if (!$daily) {
            // Handle Daily tidak ditemukan
            return redirect()->back()->withErrors(['Daily record not found']);
        }

        // Perbarui field di Daily
        $daily->user_id = $user->id;
        $daily->division_id = $division->id;
        $daily->note = $note;

        // Perbarui waktu updated_at dan date
        $daily->updated_at = $date_current->format('Y-m-d H:i:s');
        $daily->date = substr($daily->updated_at, 0, 10);
        $daily->save();

        // Redirect ke halaman table
        return redirect('/table');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $daily = Daily::find($id);
        $daily->delete();

        return redirect('/table');
    }
}
