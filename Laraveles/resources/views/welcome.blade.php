<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <title>Gaming Home</title>
        <style>
          html,body {
            height: 100%;
            margin: 0;
            padding: 0;
            background: #384B7D;
            display: flex;
            justify-content: center; /* Centrar horizontalmente */
            align-items: center; /* Centrar verticalmente */
            flex-direction: column; /* Asegura que el contenido dentro del body sea una columna */
          }
          body {
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Asegura que el body tenga al menos la altura de la ventana */
            box-sizing: border-box;
          }

          .bg-glass {
            background-color: hsla(0, 0%, 100%, 0.9) !important;
            backdrop-filter: saturate(200%) blur(25px);
          }
          .btn{
            background-color: #7283B0;
            color: white;
          }
          .btn:hover{
            background-color: #7283B0;
            color: white;
          }
          .texto-centrado{
            text-align: center;
          }
        </style>
        </head>
        <body>
<section class="seccion-1">
<div class="container px-4 py-5 px-md-5 text-center text-lg-start my-5">
    <div class="row gx-lg-5 align-items-center mb-5 texto-centrado">
    <div class="col-lg-6 mb-5 mb-lg-0" style="z-index: 10">
            <h1>
            <span class="my-5 display-5 fw-bold ls-tight" style="color: hsl(218, 81%, 75%)">GAMING HOME</span>
        </h1>
        <p class="mb-4 opacity-70" style="color: hsl(218, 81%, 85%)">
            Bienvenido administrador esta es la parte de administrador de gaming home si no eres administrador te has confundido de pagina dirigete a la siguiente para poder acceder a la experiencia Gaming Home: <a href="http://localhost:4200/iniciosesion">Ir</a>
        </p>
    </div>

    <div class="col-lg-6 mb-5 mb-lg-0 position-relative">
        <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
        <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>

        <div class="card bg-glass">
            <div class="card-body px-4 py-5 px-md-5">
            <form action="{{ route('iniciar-sesion') }}" method="post">
            @csrf
                <!-- Casilla de email -->
                <div data-mdb-input-init class="form-outline mb-4">
                <input type="text" name="email" class="form-control" placeholder="Correo electronico"/>
                @foreach($errors->get('email') as $error)
                <p class="text-danger">{{ $error }}</p>
                @endforeach
                </div>

            <!-- casilla de contraseña -->
            <div data-mdb-input-init class="form-outline mb-4">
                <input type="password" name="password" class="form-control" placeholder="contraseña"/>
                @foreach($errors->get('password') as $error)
                <p class="text-danger">{{ $error }}</p>
                @endforeach
            </div>
            <!-- botones -->
            <div class="d-grid gap-2">
                <input type="submit" class="btn" value="Iniciar sesion">
                @foreach($errors->get('error') as $error)
                <p class="text-danger">{{ $error }}</p>
                @endforeach
            </div>
            </form>
        </div>
        </div>
    </div>
    </div>
</div>
</section>
    </body>
</html>
