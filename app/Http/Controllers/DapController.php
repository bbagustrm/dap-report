<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Divisi;
use App\Models\Daily;
use App\Models\Report;
use App\Models\Tugas;
use Illuminate\Http\Request;

use DataTables;
use PhpParser\JsonDecoder;
use DateTime;


class DapController extends Controller
{
    public function index(Request $request)
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
        return view('dap/daily', compact('divisions'));
    }

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

        return view('dap/create', $view_data);
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

        // new report
        // $daily->id

        return redirect('/daily');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $query = Daily::select(
            'dailies.*',
            'users.name as user_name',
            'divisis.code as division_code',
            'divisis.name as division_name'
        )
            ->join('users', 'users.id', '=', 'dailies.user_id')
            ->join('divisis', 'divisis.id', '=', 'dailies.division_id');

        $daily = $query->find($id);

        if (!$daily) {
            return redirect()->back()->withErrors(['Daily record not found']);
        }

        $reports = is_string($daily->report) ? json_decode($daily->report, true) : $daily->report;

        $divisi = Divisi::find($daily->division_id);
        $tugas = is_string($divisi->tugas) ? json_decode($divisi->tugas, true) : $divisi->tugas;

        $reports_with_details = array_map(function ($report) use ($tugas) {
            foreach ($tugas as $task) {
                if ($task['id_tugas'] == $report['id_tugas']) {
                    return array_merge($report, [
                        'tugas' => $task['tugas'],
                        'tipe' => $task['tipe'],
                        'target' => $task['target'],
                    ]);
                }
            }
            return $report;
        }, $reports);

        $sortedReports = collect($reports_with_details)->sortBy('tipe');

        $view_data = [
            'daily' => $daily,
            'reports' => $sortedReports
        ];

        return view('dap/show', $view_data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $query = Daily::select(
            'dailies.*',
            'users.name as user_name',
            'divisis.code as division_code',
            'divisis.name as division_name'
        )
            ->join('users', 'users.id', '=', 'dailies.user_id')
            ->join('divisis', 'divisis.id', '=', 'dailies.division_id');

        $daily = $query->find($id);

        if (!$daily) {
            return redirect()->back()->withErrors(['Daily record not found']);
        }

        $reports = is_string($daily->report) ? json_decode($daily->report, true) : $daily->report;

        $divisi = Divisi::find($daily->division_id);
        $tugas = is_string($divisi->tugas) ? json_decode($divisi->tugas, true) : $divisi->tugas;

        $reports_with_details = array_map(function ($report) use ($tugas) {
            foreach ($tugas as $task) {
                if ($task['id_tugas'] == $report['id_tugas']) {
                    return array_merge($report, [
                        'tugas' => $task['tugas'],
                        'tipe' => $task['tipe'],
                        'target' => $task['target'],
                    ]);
                }
            }
            return $report;
        }, $reports);

        $sortedReports = collect($reports_with_details)->sortBy('tipe');

        $view_data = [
            'daily' => $daily,
            'reports' => $sortedReports
        ];

        return view('dap/edit', $view_data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $note = $request->input('note');

        $date_current = new DateTime();

        $daily = Daily::find($id);
        if (!$daily) {
            return redirect()->back()->withErrors(['Daily record not found']);
        }

        $daily->note = $note;
        $daily->updated_at = $date_current->format('Y-m-d H:i:s');
        $daily->date = substr($daily->updated_at, 0, 10);

        // Update reports JSON
        $reportsData = $request->input('reports', []);
        $reports = [];
        foreach ($reportsData as $reportData) {
            if (isset($reportData['id_tugas']) && isset($reportData['score'])) {
                $reports[] = [
                    'id_tugas' => $reportData['id_tugas'],
                    'score' => $reportData['score']
                ];
            }
        }
        $daily->report = json_encode($reports);

        $daily->save();

        return redirect('/daily');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $daily = Daily::find($id);
        $daily->delete();

        return redirect('/daily');
    }
}
