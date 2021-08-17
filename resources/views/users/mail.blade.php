<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>mail</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</head>
<body>
    <div class="justify-content-center m-0">
        <div class="col-md-6">
            <div class="card card-profile-1 mb-4">
                <div class="card-body text-center">
                    <div class="avatar box-shadow-2 mb-3">
                        <img src="{{asset("assets/images/logo.jpeg")}}" alt="" style="width: 300;">
                    </div>
                    <p>Estimado cliente, lo invitamos a que ingrese a nuestro nuevo portal, en donde podrá acceder a gestionar el estado de sus facturas y reclamos!</p>
                    <span>Puede entrar con las siguientes credenciales: <a href="{{ route('home') }}">Ingresando aquí</a></span>
                        <p class="mt-4"><b>Usuario: </b><span>{{$user}}</span></p>
                        <p class="m-0"><b>Contraseña: </b><span>{{$password}}</span></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
