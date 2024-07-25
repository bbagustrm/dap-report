<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Daily Note</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
    <style>
        trix-toolbar [data-trix-button-group = "file-tools"] {
            display: none;
        }
    </style>
</head>

<body class="overflow-x-hidden bg-[#f5f7fb] ">

    <div class="w-full flex justify-end">
        <div class="content w-[82vw] transition-all duration-500">
            <x-navbar>
            </x-navbar>
            <div class="w-full px-8">
                <h1 class="text-xl py-2 mb-2">Edit Daily Note</h1>
                <div class="w-full bg-white px-4 py-4 text-sm shadow-sm">
                    <form class="flex flex-col gap-4" action="{{ route('dailies.update', $daily->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="flex items-center gap-4">
                            <label for="user_name">Name : </label>
                            <input class="w-[300px] p-2 border-[1px] border-gray-300 rounded-sm" name="user_name"
                                value="{{ $daily->user_name }}" disabled></input>
                            <label for="division_name">Divisi : </label>
                            <input class="w-[300px] p-2 border-[1px] border-gray-300 rounded-sm" name="division_name"
                                value="{{ $daily->division_name }}" disabled></input>
                        </div>
                        <hr>
                        <input id="x" type="hidden" name="note" id="note">
                        <trix-editor input="x" class="min-h-[200px] px-4 py-2">{!! $daily->note !!}</trix-editor>
                        <hr>
                        <table class="w-full border-collapse border border-gray-300">
                            <thead class="bg-[#f5f7fb]">
                                <tr>
                                    <th class="border border-gray-300 p-2" >Tipe</th>
                                    <th class="border border-gray-300 p-2" >Tugas</th>
                                    <th class="border border-gray-300 p-2" colspan="2">Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reports as $report)
                                <tr>
                                    <td class="border border-gray-300 px-2 w-[8vw]">
                                        <div class="flex gap-2 items-center justify-center">
                                            @if ($report->tipe == 1)
                                            <span class="px-2 text-center border border-[#28a745] text-[#28a745] rounded-full">harian</span>
                                            @elseif ($report->tipe == 2)
                                            <span class="px-2 text-center border border-[#ffc107] text-[#ffc107] rounded-full">mingguan</span>
                                            @elseif ($report->tipe == 3)
                                            <span class="px-2 text-center border border-[#dc3545] text-[#dc3545] rounded-full">bulanan</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="border border-gray-300 px-2">
                                        <p>{{ $report->tugas }}</p>
                                    </td>
                                    <td class="border border-gray-300 w-[100px]">
                                        <input type="hidden" name="reports[{{ $report->id_tugas }}][id_tugas]" value="{{ $report->id_tugas }}">
                                        <input class="w-full p-2 border-[1px] border-gray-400" name="reports[{{ $report->id_tugas }}][score]" placeholder="Masukan Score" type="number" value="{{ $report->score }}" min="0" max="{{ $report->target }}">
                                    </td>
                                    <td class="border border-gray-300 w-[80px] text-center">
                                        <p>/{{ $report->target }}</p>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        <div class="w-full flex gap-1">
                            <a href="{{ url('/daily') }}" class="btn-ghost-warning">Cancel</a>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <x-sidebar>
        </x-sidebar>
    </div>

    @vite('resources/js/dom.js')


</body>

</html>
