<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <title>Gaming Home</title>
        <style>
            .background-radial-gradient {
  background-color: hsl(218, 41%, 15%);
  background-image: radial-gradient(650px circle at 0% 0%,
      hsl(218, 41%, 35%) 15%,
      hsl(218, 41%, 30%) 35%,
      hsl(218, 41%, 20%) 75%,
      hsl(218, 41%, 19%) 80%,
      transparent 100%),
    radial-gradient(1250px circle at 100% 100%,
      hsl(218, 41%, 45%) 15%,
      hsl(218, 41%, 30%) 35%,
      hsl(218, 41%, 20%) 75%,
      hsl(218, 41%, 19%) 80%,
      transparent 100%);
}

#radius-shape-1 {
  height: 220px;
  width: 220px;
  top: -60px;
  left: -130px;
  background: radial-gradient(#44006b, #ad1fff);
  overflow: hidden;
}

#radius-shape-2 {
  border-radius: 38% 62% 63% 37% / 70% 33% 67% 30%;
  bottom: -60px;
  right: -110px;
  width: 300px;
  height: 300px;
  background: radial-gradient(#44006b, #ad1fff);
  overflow: hidden;
}

.bg-glass {
  background-color: hsla(0, 0%, 100%, 0.9) !important;
  backdrop-filter: saturate(200%) blur(25px);
}

.btn{
  background-color: purple;
  color: white;
}
.btn:hover{
  background-color: purple;
  color: white;
}
section{/*mirar porque no funciona para movil*/
  height: 100vh;
}
        </style>
    </head>
    <body>
<section class="background-radial-gradient overflow-hidden">
<div class="container px-4 py-5 px-md-5 text-center text-lg-start my-5">
    <div class="row gx-lg-5 align-items-center mb-5">
    <div class="col-lg-6 mb-5 mb-lg-0" style="z-index: 10">
        <h1 class="my-5 display-5 fw-bold ls-tight" style="color: hsl(218, 81%, 95%)">
            Bienvenido 
            <br/>
            <span style="color: hsl(218, 81%, 75%)">A gaming home</span>
        </h1>
        <p class="mb-4 opacity-70" style="color: hsl(218, 81%, 85%)">
            Lorem ipsum dolor, sit amet consectetur adipisicing elit.
            Temporibus, expedita iusto veniam atque, magni tempora mollitia
            dolorum consequatur nulla, neque debitis eos reprehenderit quasi
            ab ipsum nisi dolorem modi. Quos?
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
                <input type="email" name="email" class="form-control" placeholder="Correo electronico"/>
                @foreach($errors->get('email') as $error)
                <p class="text-danger">{{ $error }}</p>
                @endforeach
                </div>
            <!-- casilla de contraseña -->
            <div data-mdb-input-init class="form-outline mb-4">
                <input type="password" name="password" class="form-control" placeholder="Contraseña"/>
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
    </body>
</html>
