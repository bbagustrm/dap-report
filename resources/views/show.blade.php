<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Show Daily</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
</head>

<body class="overflow-x-hidden bg-[#f5f7fb] ">

    <div class="w-full flex justify-end">
        <div class="content w-[82vw] transition-all duration-500">
            <x-navbar>
            </x-navbar>
            <div class="w-full px-8">
                <h1 class="text-xl py-2 mb-2">Show Daily Note</h1>
                <div class="w-full bg-white px-4 py-4 text-sm shadow-sm">
                    <div class="flex flex-col gap-4">
                        <div class="flex flex-col gap-4">
                            <div class="flex flex-col gap-1">
                                <p for="name">Name : {{ $daily->user_name }}</p>
                                <p for="name">Divisi : {{ $daily->division_name }}</p>
                                <p class="">created_at : {{ $daily->created_at }}</p>
                                <p class="">updated_at : {{ $daily->updated_at }}</p>
                            </div>
                            <div class="p-2 min-h-64 border-[1px] border-gray-300 rounded-sm">
                                {!! $daily->note !!}
                            </div>
                        </div>
                        <div class="w-full flex gap-1">
                            <a href="{{ url('/table') }}" class="btn-warning">Back</a>
                        </div>
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
