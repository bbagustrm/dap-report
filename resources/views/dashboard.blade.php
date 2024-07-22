<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>User</title>
</head>

<body class="overflow-x-hidden bg-[#f5f7fb]">

    <div class="w-full flex justify-end ">
        <div class="content w-[80vw] transition-all duration-500">
            <div class="w-full py-2 px-4 bg-white shadow-sm mb-8">
                <div class="container mx-auto flex justify-between items-center gap-2">
                    <img class="burger w-8 rounded-full cursor-pointer" src="{{ asset('assets/ic-burger-bar.svg') }}"
                        alt="">
                    <div class="flex gap-2 items-center">
                        <img class="w-10 rounded-full" src="{{ asset('assets/profile.jpg') }}" alt="profile">
                        <h3>Admin</h3>
                    </div>
                </div>
            </div>
            <div class="w-full px-8">
                <div class="w-full py-4 px-4">
                    <h1 class="text-2xl py-2 mb-4">Daily Activity Progress Report</h1>
                    <div class="container mx-auto flex justify-between items-center gap-2 bg-white px-5 py-5">
                        <table class="w-full border-[1px] border-[#dee2e6] text-sm">
                            <thead class="w-full py-2 bg-[#f5f7fb]">
                                <td scope="col" class="w-[5%] font-bold px-2 py-2 border-[1px] border-[#dee2e6]">No
                                </td>
                                <td scope="col" class="w-[20%] font-bold px-2 py-2 border-[1px] border-[#dee2e6]">
                                    Nama</td>
                                <td scope="col" class="w-[16%] font-bold px-2 py-2 border-[1px] border-[#dee2e6]">
                                    Tanggal</td>
                                <td scope="col" class="font-bold px-2 py-2 border-[1px] border-[#dee2e6]">Note</td>
                                <td scope="col" class="w-[12%] font-bold px-2 py-2 border-[1px] border-[#dee2e6]">
                                    Action</td>
                            </thead>
                            @php($number = 1)
                            @foreach ($dailies as $daily)
                                @foreach ($users as $user)
                                @php($name = "")
                                @if ($daily->user_id == $user->id)
                                    <tbody>
                                        <td class="px-2 py-1 border-[1px] border-[#dee2e6]">{{ $number }}</td>
                                        <td class="px-2 py-1 border-[1px] border-[#dee2e6]">{{ $user->name }} </td>
                                        <td class="px-2 py-1 border-[1px] border-[#dee2e6]">{{ $daily->date }}</td>
                                        <td class="px-2 py-1 border-[1px] border-[#dee2e6] line-clamp-1" >{{ $daily->note }}</td>
                                        <td class="px-2 py-1 border-[1px] border-[#dee2e6]">Action</td>
                                    </tbody>
                                @endif
                                @endforeach
                                @php($number++)
                            @endforeach
                    </div>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="side-bar bg-[#3b7ddd] w-[20vw] h-[100vh] absolute top-0 left-0 transition-all duration-[400ms] ">
        <h1 class="text-3xl font-semibold text-white px-8 py-4 mb-12">E-Absensi</h1>
        <ul class="">
            <li class="px-8 py-2 font-semibold text-gray-300 hover:text-white cursor-pointer">
                <a href="#">DAP</a>
            </li>
            <li class="px-8 py-2 font-semibold text-gray-300 hover:text-white cursor-pointer">
                <a href="#">Report</a>
            </li>
        </ul>
    </div>
    @vite('resources/js/dom.js')

</body>

</html>
