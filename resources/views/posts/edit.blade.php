<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membuat postingan</title>
    @vite('resources/css/app.css')

</head>

<body>
    <form method="POST" action="{{ url("posts/$post->id") }}" class="w-[500px] flex flex-col gap-4 mx-auto">
        @method('PATCH')
        <h1 class="h-fit text-3xl font-semibold mt-8">Edit Postingan</h1>
        <hr class="">

        @csrf
        <div class="flex flex-col gap-2">
            <label for="title">Judul</label>
            <input type="text" id="title" name="title" placeholder="Judul" class="px-2 py-2 border-[1px] border-gray-400 shadow-sm rounded-md" value="{{ $post->title }}">
        </div>
        <div class="mb-6 flex flex-col gap-2">
            <label for="content">Content</label>
            <textarea id="content" name="content" placeholder="Masukkan teks.." class="px-2 py-2 h-[300px] border-[1px] border-gray-400 shadow-sm rounded-md resize-none">{{ $post->content }}</textarea>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="w-fit py-2 px-4 bg-yellow-400 font-semibold rounded-md">
                Edit</button>
            <a href="{{ url("posts") }}" class="w-fit py-2 px-4 bg-red-400 font-semibold rounded-md">
                Cancel</a>
        </div>
    </form>

    <form method="POST" action="{{ url("posts/$post->id") }}" class="w-[500px] flex flex-col gap-4 mx-auto my-4">
        @method('DELETE')
        @csrf
        <button type="submit" class="w-fit py-2 px-4 bg-red-400 font-semibold rounded-md">
            Delete</button>
        <button></button>
    </form>
</body>

</html>