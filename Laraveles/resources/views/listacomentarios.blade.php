<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Document</title>
    <style>
    .table td,
    .table th{
    text-align: center;
    vertical-align: middle;
    }
    </style>
<body>
</head>
<body>
    <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Lista Comentarios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">codComentario</th>
                            <th scope="col">nomUsuario</th>
                            <th scope="col">nomjuego</th>
                            <th scope="col">texto</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($comentarios as $comentario)
                            <tr>
                        <th scope="row">{{$comentario->codComentario}}</th>
                        <td scope="row">{{$comentario->usuario->nomUsuario}}</td>
                        <td scope="row">{{$comentario->juego->nombre}}</td>
                        <td>{{$comentario->texto}}</td>
                        <form action="{{ route('borrarcomentario', ['id' => $comentario->codComentario]) }}" method="post">
                        @csrf
                        <td><button class="btn btn-danger">borrar comentario</button></td>
                        </form>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

</body>
</html>
