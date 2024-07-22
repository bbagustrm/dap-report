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
                            <select class="w-[300px] p-2 border-[1px] border-gray-300 rounded-sm" name="user_name">
                                @foreach($users as $user)
                                    <option value="{{ $user->name }}" {{ $user->name == $daily->user_name ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="division_name">Divisi : </label>
                            <select class="w-[300px] p-2 border-[1px] border-gray-300 rounded-sm" name="division_name">
                                @foreach($divisions as $division)
                                    <option value="{{ $division->name }}" {{ $division->name == $daily->division_name ? 'selected' : '' }}>
                                        {{ $division->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <hr>
                        <input id="x" type="hidden" name="note" id="note">
                        <trix-editor input="x" class="min-h-[200px]">{!! $daily->note !!}</trix-editor>
                        <div class="w-full flex gap-1">
                            <a href="{{ url('/table') }}" class="btn-ghost-warning">Cancel</a>
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
