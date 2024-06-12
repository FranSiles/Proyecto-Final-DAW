<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Lista usuarios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">Codusuario</th>
                            <th scope="col">nombre</th>
                            <th scope="col">email</th>
                            <th scope="col">rol</th>
                            <th scope="col">foto</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($usuarios as $usuario)
                            <tr>
                        <th scope="row">{{$usuario->codUsuario}}</th>
                        <td>{{$usuario->nomUsuario}}</td>
                        <td>{{$usuario->email}}</td>
                        <td>@if($usuario->administrador=="si")
                                Administrador
                            @else
                                Usuario
                            @endif</td>
                        <td><a href="http://localhost/{{$usuario->foto}}" >Ver Foto</a></td>
                        @if($usuario->administrador=="no")
                                <form action="{{ route('nuevoAdmin' , ['id' => $usuario->codUsuario]) }}" method="post">
                                @csrf
                                <td><button class="btn btn-primary" type="submit">Convertir en admin</button></td>
                                </form>
                                <form action="{{ route('borrarusuario', ['id' => $usuario->codUsuario]) }}" method="post">
                                @csrf
                                <td><button class="btn btn-danger" type="submit">Eliminar usuario</button></td>
                                </form>
                                @endif
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
