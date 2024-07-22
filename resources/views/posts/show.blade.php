<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>hello</title>
    @vite('resources/css/app.css')
</head>

<body>
    <div class="w-[500px] flex flex-col gap-4 mx-auto">
        <div class="flex flex-row justify-between items-center mt-8">
            <h1 class="h-fit text-3xl font-semibold">{{ $post->title }}</h1>
            <a href="{{ url("posts/create") }}" class="">
                <svg class="w-fit h-fit py-2 px-2 bg-green-500 rounded-full" width="24" height="24">
                    <image xlink:href="{{ asset('assets/ic-plus.svg') }}" />
                </svg>
            </a>
        </div>
        <p class="text-xs text-gray-400">{{ $post->created_at }}</p>
        <hr class="">
        <p class="w-[500px]">{{ $post->content }}</p>
        <a href="{{ url("posts") }}" class="w-fit py-2 px-4 bg-blue-400 font-semibold rounded-md">
            < Kembali</a>
    </div>
</body>

</html>