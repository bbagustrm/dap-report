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
        <div class="content w-4/5 transition-all duration-500">
            <x-navbar>
            </x-navbar>
            <div class="w-full px-8">
                <div class="w-full flex gap-2 py-2 mb-2">
                    <a href="{{ url('/report') }}" class="flex justify-center items-center">
                        <svg class="w-fit h-fit" width="24" height="24">
                            <image xlink:href="{{ asset('assets/ic-arrow-left.svg') }}" />
                        </svg>
                    </a>
                    <h1 class="text-xl">Monitoring Report</h1>
                </div>
                <div class="flex flex-col items-center gap-8 w-full bg-white px-4 py-4 text-sm shadow-sm rounded-md">
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
                        </div>
                    @else
                        <div class="w-full flex gap-2 flex-col">
                            <p>Data masih kosong</p>
                            <a href="{{ url('/report') }}" class="btn-warning w-fit">Back</a>
                        </div>
                    @endif
                    <table class="w-full">
                        @forelse ($reports as $id_tugas => $data)
                            <tr>
                                <td id="container-{{ $id_tugas }}"
                                    class="w-full h-[400px] p-8 border-[1px] border-gray-300"></td>
                            </tr>
                            @php
                                $tugas_data = $divisiTugas[$id_tugas] ?? [
                                    'tugas' => 'Unknown Task',
                                    'tipe' => 'Unknown Type',
                                ];
                                $nama_tugas = $tugas_data['tugas'];
                                $tipe_tugas = $tugas_data['tipe'];
                                $tipe_span = '';
                                if ($tipe_tugas == 1) {
                                    $tipe_span =
                                        '<span class="px-2 text-center border-[1px] border-[#28a745] text-[#28a745] rounded-full">harian</span>';
                                } elseif ($tipe_tugas == 2) {
                                    $tipe_span =
                                        '<span class="px-2 text-center border-[1px] border-[#ffc107] text-[#ffc107] rounded-full">mingguan</span>';
                                } elseif ($tipe_tugas == 3) {
                                    $tipe_span =
                                        '<span class="px-2 text-center border-[1px] border-[#dc3545] text-[#dc3545] rounded-full">bulanan</span>';
                                }
                                $title = 'Tugas : ' . $nama_tugas . ' ' . $tipe_span;
                                
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
                                            text: `{!! $title !!}`,
                                            useHTML: true
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
                    </table>
                </div>

            </div>
            <x-sidebar>
            </x-sidebar>
        </div>

        @vite('resources/js/dom.js')


</body>

</html>
