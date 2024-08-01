<?php

namespace App\Http\Controllers;

use App\Models\Daily;
use App\Models\Divisi;
use App\Models\Jabatan;
use DateTime;
use Illuminate\Http\Request;

use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Jabatan::select('jabatans.*', 'users.name as user_name', 'divisis.name as division_name')
                ->join('users', 'users.id', '=', 'jabatans.user_id')
                ->join('divisis', 'divisis.id', '=', 'jabatans.division_id');

            if ($request->has('division') && $request->division) {
                $division = $request->division;
                $query->where('divisis.name', $division);
            }

            $dailies = $query->get();

            return datatables()->of($dailies)
                ->addColumn('action', function ($row) {
                    $showUrl = route('report.show', $row->user_id);
                    $btn = '<a href="' . $showUrl . '" class="btn-primary">Show</a>';
                    return $btn;
                })
                ->addIndexColumn()
                ->make(true);
        }
        $divisions = Divisi::all();

        return view('report/index', compact('divisions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $now = Carbon::now();

        $startDate = $now->copy()->subMonth()->startOfDay();
        $endDate = $now->copy()->addMonth()->endOfDay();

        $dailies = Daily::select(
            'dailies.*',
            'users.name as user_name',
            'divisis.code as division_code',
            'divisis.name as division_name'
        )
            ->join('users', 'users.id', '=', 'dailies.user_id')
            ->join('divisis', 'divisis.id', '=', 'dailies.division_id')
            ->where('dailies.user_id', $id)
            ->whereBetween('dailies.date', [$startDate, $endDate])
            ->orderBy('dailies.updated_at')
            ->get();

        // dd($dailies);

        $reports = [];

        foreach ($dailies as $daily) {
            $tasks = json_decode($daily->report, true);
            $date = $daily->updated_at->format('Y-m-d');

            foreach ($tasks as $task) {
                $id_tugas = $task['id_tugas'];
                $score = $task['score'];

                if (!isset($reports[$id_tugas])) {
                    $reports[$id_tugas] = [];
                }
                $reports[$id_tugas][] = ['date' => $date, 'score' => $score];
            }
        }

        $division_ids = $dailies->pluck('division_id')->unique()->toArray();

        $divisiTugas = [];
        $divisis = Divisi::whereIn('id', $division_ids)->get();
        foreach ($divisis as $divisi) {
            foreach ($divisi->tugas as $task) {
                $divisiTugas[$task['id_tugas']] = $task['tugas'];
            }
        }

        $dateRange = [
            'startDate' => $startDate->format('Y-m-d'),
            'endDate' => $endDate->format('Y-m-d')
        ];


        $view_data = [
            'daily' => $dailies,
            'reports' => $reports,
            'dateRange' => $dateRange,
            'divisiTugas' => $divisiTugas
        ];

        return view('report/show', $view_data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
