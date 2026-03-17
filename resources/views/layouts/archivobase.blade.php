<!doctype html>
<html lang="en">
  <head>
     <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

            
    <title>SISTEMA PEDIDOS</title>
  </head>
  
  <body>
  
    <h1 class="bg-primary text-white text-center">SISTEMA PEDIDOS</h1>
               <table width="850" cellspacing="0" cellpadding="0" align="center">
                  <tr>
                    <td><img src="images/BANNER.jpg" width="850" height="110"></td>
                  </tr>
               </table>
 
            <div class="container">
               
                @yield ('Contenido')
               
            </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    
<!-----valida errors-->
@if (session()->has('msj'))
                        <div class="alert alert-success" role="alert">
                        {{session('msj')}}
                    @endif
                      @if ($errors->any())
                          <div class="alert alert-danger" role="alert">
                          <ul>
                            @foreach ($errors->all() as $error)
                              <li>{{$error}}</li>
                            @endforeach
                          </ul>
                      @endif
          <!-----valida errors-->
  </body>
</html>