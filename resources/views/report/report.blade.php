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
        <div class="content w-[82vw] transition-all duration-500">
            <x-navbar>
            </x-navbar>
            <div class="w-full px-8">
                <h1 class="text-xl py-2 mb-2">Monitoring Report</h1>
            </div>
        </div>
        <x-sidebar>
        </x-sidebar>
    </div>

    @vite('resources/js/dom.js')


</body>

</html>
