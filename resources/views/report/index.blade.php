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
    <title>User</title>
</head>

<body class="overflow-x-hidden bg-[#f5f7fb] ">

    <div class="w-full flex justify-end">
        <div class="content w-4/5 transition-all duration-500">
            <x-navbar>
            </x-navbar>
            <div class="w-full px-8">
                <h1 class="text-xl py-2 mb-2">Rekap Report</h1>
                <div class="w-full bg-white px-4 py-4 text-sm shadow-sm">
                    <div class="flex gap-2 justify-between items-center">
                        <a href="{{ url('/report') }}" class="btn-primary flex items-center gap-2">
                            <svg class="w-fit h-fit" width="24" height="24">
                                <image xlink:href="{{ asset('assets/ic-reload.svg') }}" />
                            </svg>
                            Reload</a>
                        <div class="flex gap-2">
                            <select id="division" class="border-[1px] px-2 h-6 border-gray-300">
                                <option value="">All Divisions</option>
                                @foreach ($divisions as $division)
                                    <option value="{{ $division->name }}">{{ $division->name }}</option>
                                @endforeach
                            </select>
                            <button id="filter" class="px-4 bg-[#3b7ddd] text-white h-6">Filter</button>
                        </div>
                    </div>
                    <hr class="my-2">
                    <table id="myTable" class="w-full border-[1px] border-gray-300">
                        <thead class="bg-[#f5f7fb] ">
                            <tr>
                                <th scope="col" class="w-4 border-[1px] border-gray-300">No</th>
                                <th scope="col" class="w-[16vw] border-[1px] border-gray-300">Name</th>
                                <th scope="col" class="border-[1px] border-gray-300">Divisi</th>
                                <th scope="col" class="w-[10vw] border-[1px] border-gray-300">Action</th>
                            </tr>
                        </thead>
                    </table>
                    <script class="">
                        $(document).ready(function() {
                            var table = $('#myTable').DataTable({
                                processing: true,
                                serverSide: true,
                                ajax: {
                                    url: "{{ url('report') }}",
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
                                    "lengthMenu": "Menampilkan _MENU_ data",
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
    </div>
    <x-sidebar>
    </x-sidebar>
    </div>

    @vite('resources/js/dom.js')


</body>

</html>
