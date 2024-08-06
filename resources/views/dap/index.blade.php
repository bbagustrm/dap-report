<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="//cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <title>Rekap Report</title>
</head>

<body class="overflow-x-hidden bg-[#f5f7fb] ">

    <div class="w-full flex justify-end">
        <div class="content w-4/5 transition-all duration-500">
            <x-navbar>
            </x-navbar>
            <div class="w-full px-8">
                <div class="w-full flex gap-2 py-2 mb-2">
                    <h1 class="text-xl">Daily Activity Progress Report</h1>
                </div>
                <div class="w-full bg-white px-4 py-4 text-sm shadow-sm rounded-md">
                    <div class="flex justify-between items-center h-8 ">
                        {{-- <a href="{{ route('dailies.create') }}" class="btn-primary flex items-center gap-2">
                            <svg class="w-fit h-fit" width="24" height="24">
                                <image xlink:href="{{ asset('assets/ic-plus-white.svg') }}" />
                            </svg>
                            Create</a> --}}
                        <a href="{{ url('/daily') }}" class="px-3 py-1 text-center bg-[#007bff] text-white rounded border-[1px] border-[#007bff] hover:bg-[#0069d9] transition-all duration-300 flex items-center gap-2 h-full">
                            <svg class="w-fit h-fit" width="24" height="24">
                                <image xlink:href="{{ asset('assets/ic-reload.svg') }}" />
                            </svg>
                            Reload</a>
                        <div class="flex gap-2 items-center h-full">
                            <div class="flex gap-2 items-center h-full">
                                <select id="division" class="border-[1px] py-1 px-3 border-gray-300 rounded h-full">
                                    <option value="">All Divisions</option>
                                    @foreach ($divisions as $division)
                                        <option value="{{ $division->name }}">{{ $division->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex gap-2 items-center h-full">
                                <input type="date" id="start_date" class="border-[1px] py-1 px-3 border-gray-300 rounded h-full">
                            </div>
                            s.d
                            <div class="flex gap-2 h-full">
                                <input type="date" id="end_date" class="border-[1px] py-1 px-3 border-gray-300 rounded h-full">
                            </div>
                            <button id="filter" class="px-3 py-1 text-center bg-[#007bff] text-white rounded border-[1px] border-[#007bff] hover:bg-[#0069d9] transition-all duration-300 h-full">Filter</button>
                        </div>
                    </div>
                    <hr class="my-2">
                    <table id="myTable" class="w-full border-[1px] border-gray-300">
                        <thead class="bg-[#f5f7fb] ">
                            <tr>
                                <th scope="col" class="w-4 border-[1px] border-gray-300">No</th>
                                <th scope="col" class="w-56 border-[1px] border-gray-300">Name</th>
                                <th scope="col" class="border-[1px] border-gray-300">Divisi</th>
                                <th scope="col" class="w-[25vw] border-[1px] border-gray-300">Note</th>
                                <th scope="col" class="w-32 border-[1px] border-gray-300">Tanggal</th>
                                <th scope="col" class="w-64 border-[1px] border-gray-300">Action</th>
                            </tr>
                        </thead>
                    </table>
                    <script class="">
                        $(document).ready(function() {
                            var table = $('#myTable').DataTable({
                                processing: true,
                                serverSide: true,
                                ajax: {
                                    url: "{{ url('daily') }}",
                                    data: function(d) {
                                        d.start_date = $('#start_date').val();
                                        d.end_date = $('#end_date').val();
                                        d.division = $('#division').val();
                                    }
                                },
                                "lengthMenu": [
                                    [10, 25, 50, -1],
                                    [10, 25, 50, "All"]
                                ],
                                "language": {
                                    "lengthMenu": "_MENU_ data ditampilkan",
                                    "search": "",
                                    "searchPlaceholder": "Cari..."
                                },
                                columns: [{
                                        data: 'DT_RowIndex',
                                        name: 'DT_RowIndex',
                                        orderable: false,
                                        searchable: false
                                    },
                                    {
                                        data: 'user_name',
                                        name: 'user_name',
                                        orderable: true,
                                        searchable: true
                                    },
                                    {
                                        data: 'division_name',
                                        name: 'division_name',
                                        orderable: true,
                                        searchable: true
                                    },
                                    {
                                        data: 'note',
                                        name: 'note',
                                        orderable: false,
                                        searchable: false,
                                        render: function(data, type, row) {
                                            var parser = new DOMParser();
                                            var doc = parser.parseFromString(data, 'text/html');
                                            var text = doc.body.textContent || "";
                                            return '<div class="line-clamp-1">' + text + '</div>';
                                        }
                                    },
                                    {
                                        data: 'date',
                                        name: 'date',
                                        orderable: true,
                                        searchable: false
                                    },
                                    {
                                        data: 'action',
                                        name: 'action',
                                        orderable: false,
                                        searchable: false
                                    }
                                ],
                            });
                            $('#filter').click(function() {
                                table.draw();
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
        <x-sidebar>
        </x-sidebar>
        <x-toastr>
        </x-toastr>
    </div>

    @vite('resources/js/dom.js')


</body>

</html>
