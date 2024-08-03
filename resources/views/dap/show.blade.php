<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Show Daily</title>
        <!-- Toastr CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
        <!-- Toastr JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @vite('resources/css/app.css')
</head>

<body class="overflow-x-hidden bg-[#f5f7fb] ">

    <div class="w-full flex justify-end">
        <div class="content w-4/5 transition-all duration-500">
            <x-navbar>
            </x-navbar>
            <div class="w-full px-8 mb-10">
                <div class="w-full flex gap-2 py-2 mb-2">
                    <a href="{{ url('/daily') }}" class="flex justify-center items-center">
                        <svg class="w-fit h-fit" width="24" height="24">
                            <image xlink:href="{{ asset('assets/ic-arrow-left.svg') }}" />
                        </svg>
                    </a>
                    <h1 class="text-xl">Show Daily Note</h1>
                </div>
                <div class="w-full bg-white px-4 py-4 text-sm shadow-sm">
                    <div class="flex flex-col gap-4">
                        <div class="flex flex-col gap-4">
                            <table>
                                <tr>
                                    <td class="border-[1px] w-[15vw] border-gray-300 px-2 py-2 align-top">Name</td>
                                    <td class="border-[1px] border-gray-300 px-2 py-2">{{ $daily->user_name }}</td>
                                </tr>
                                <tr>
                                    <td class="border-[1px] border-gray-300 px-2 py-2 align-top">Tanggal</td>
                                    <td class="border-[1px] border-gray-300 px-2 py-2">{{ $daily->date }}</td>
                                </tr>
                                <tr>
                                    <td class="border-[1px] border-gray-300 px-2 py-2 align-top">Divisi</td>
                                    <td class="border-[1px] border-gray-300 px-2 py-2">{{ $daily->division_name }}</td>
                                </tr>
                                <tr>
                                    <td class="border-[1px] border-gray-300 px-2 py-2 bg-gray-100 align-top">Keterangan
                                    </td>
                                    <td class="border-[1px] border-gray-300 px-2 py-2 bg-gray-100">
                                        <trix-editor input="x"
                                            class="min-h-[80px]">{!! $daily->note !!}</trix-editor>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-[1px] border-gray-300 px-2 py-2 align-top">Report DAP</td>
                                    <td class="border-[1px] border-gray-300 px-2 py-2 align-top">
                                        @foreach ($reports as $report)
                                            <div class="my-2">
                                                @if ($report['tipe'] == 1)
                                                    <span
                                                        class="px-2 text-center border-[1px] border-[#28a745] text-[#28a745] rounded-full">harian</span>
                                                @elseif ($report['tipe'] == 2)
                                                    <span
                                                        class="px-2 text-center border-[1px] border-[#ffc107] text-[#ffc107] rounded-full">mingguan</span>
                                                @elseif ($report['tipe'] == 3)
                                                    <span
                                                        class="px-2 text-center border-[1px] border-[#dc3545] text-[#dc3545] rounded-full">bulanan</span>
                                                @endif
                                                {{ $report['tugas'] }} : {{ $report['score'] }} /
                                                {{ $report['target'] }}
                                            </div>
                                        @endforeach
                                    </td>
                                </tr>
                            </table>

                        </div>
                        {{-- <div class="w-full flex gap-1">
                            <a href="{{ url('/daily') }}" class="btn-warning">Back</a>
                        </div> --}}
                    </div>
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
