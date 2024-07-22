<!DOCTYPE html>
<html lang="en">

<head>
    <title>Document</title>
    @vite('resources/css/app.css')
</head>

<body>
    <div class="container mx-auto">
        <div class="flex flex-row justify-between items-center my-8">
            <h1 class="h-fit text-3xl font-semibold">List Blog</h1>
            <a href="{{ url("posts/create") }}" class="w-fit py-2 px-4 bg-green-400 font-semibold rounded-md">
            Buat Postingan +</a>
        </div>
        @php($number = 1)
        <div class="w-full flex gap-6 flex-wrap">
            @foreach ($posts as $post )
            <div class="w-[300px] shadow-md border-[1px] border-gray-500 rounded-md px-4 py-4 flex flex-col gap-4">
                <h4 class="text-xl font-semibold">{{ "$number. $post->title" }}</h4>
                <p class="line-clamp-3">{{ $post->content }}</p>
                <a href="{{ url("posts/$post->id") }}" class="w-fit py-2 px-4 bg-blue-400 font-semibold rounded-md">Selengkapnya > </a>
                <a href="{{ url("posts/$post->id/edit") }}" class="w-fit py-2 px-4 bg-yellow-400 font-semibold rounded-md">Edit</a>
            </div>
            @php($number++)
            @endforeach
        </div>
    </div>


</body>

</html>