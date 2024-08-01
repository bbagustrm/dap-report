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
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <title>User</title>
</head>

<body class="overflow-x-hidden bg-[#f5f7fb] ">

    <div class="w-full flex justify-end">
        <div class="content w-[82vw] transition-all duration-500">
            <x-navbar>
            </x-navbar>
            <div class="w-full px-8">
                <h1 class="text-xl py-2 mb-2">Monitoring Report</h1>
                <div class="flex flex-col items-center gap-8 w-full bg-white px-4 py-4 text-sm shadow-sm">
                    @if (isset($daily) && count($daily) > 0)
                        <div class="w-full">
                            <table class="w-full">
                                <tr>
                                    <td class="border-[1px] w-[15vw] border-gray-300 px-2 py-2 align-top">Name</td>
                                    <td class="border-[1px] border-gray-300 px-2 py-2">{{ $daily[0]['user_name'] }}</td>
                                </tr>
                                <tr>
                                    <td class="border-[1px] border-gray-300 bg-gray-100 px-2 py-2 align-top">Divisi</td>
                                    <td class="border-[1px] border-gray-300 bg-gray-100 px-2 py-2">
                                        {{ $daily[0]['division_name'] }}</td>
                                </tr>
                            </table>
                            <div class="w-full flex gap-1 mt-4">
                                <a href="{{ url('/report') }}" class="btn-warning">Back</a>
                            </div>
                        </div>
                    @else
                        <div class="w-full flex gap-2 flex-col">
                            <p>Data masih kosong</p>
                            <a href="{{ url('/report') }}" class="btn-warning w-fit">Back</a>
                        </div>
                    @endif

                    @forelse ($reports as $id_tugas => $data)
                        <div id="container-{{ $id_tugas }}" class="w-full h-[400px]"></div>
                        @php
                            $nama_tugas = $divisiTugas[$id_tugas] ?? 'Unknown Task';
                        @endphp
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                var dates = @json(array_column($data, 'date'));
                                var scores = @json(array_column($data, 'score')).map(function(score) {
                                    return parseInt(score);
                                });

                                Highcharts.chart('container-{{ $id_tugas }}', {
                                    chart: {
                                        type: 'line'
                                    },
                                    title: {
                                        text: 'Tugas : {{ $nama_tugas }}'
                                    },
                                    xAxis: {
                                        categories: dates,
                                        title: {
                                            text: 'Date'
                                        }
                                    },
                                    yAxis: {
                                        title: {
                                            text: 'Skor'
                                        }
                                    },
                                    series: [{
                                        name: 'Skor',
                                        data: scores
                                    }]
                                });
                            });
                        </script>
                    @empty
                    @endforelse
                </div>

            </div>
            <x-sidebar>
            </x-sidebar>
        </div>

        @vite('resources/js/dom.js')


</body>

</html>
