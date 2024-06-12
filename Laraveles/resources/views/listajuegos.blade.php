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
</head>

<body>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Lista Juegos') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">Codjuego</th>
                            <th scope="col">nomUsuario</th>
                            <th scope="col">nombre</th>
                            <th scope="col">descripcion</th>
                            <th scope="col">imagen</th>
                            <th scope="col">pegi</th>
                            <th scope="col">Genero principal</th>
                            <th scope="col">Genero secundario</th>
                            <th scope="col">trailer</th>
                            <th scope="col">desarrollador</th>
                            <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($juegos as $juego)
                            <tr>
                        <th scope="row">{{$juego->codJuego}}</th>
                        <td scope="row">{{$juego->usuarios->nomUsuario}}</td>
                        <td scope="row">{{$juego->nombre}}</td>
                        <td>{{$juego->descripcion}}</td>
                        <td><a class="btn btn-primary" href="http://localhost/{{$juego->imagen}}" >Ver Foto</a></td>
                        <td>{{$juego->pegi}}</td>
                        <td>{{$juego->generoPrincipal}}</td>
                        <td>{{$juego->generoSecundario}}</td>
                        @if($juego->trailer)
                        <td><a class="btn btn-primary" href="{{$juego->trailer}}" >Ver trailer</a></td>
                        @else
                        <td></td>
                        @endif
                        <td>{{$juego->desarrollador}}</td>
                        <form action="{{ route('borrarjuego', ['id' => $juego->codJuego]) }}" method="post">
                        @csrf
                        <td><button class="btn btn-danger">borrar juego</button></td>
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