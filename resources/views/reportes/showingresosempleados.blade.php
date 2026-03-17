<html>
<head>
    <style>
        @page {
            margin: 0cm 0cm; 
            /* margin: 100px 25px; */
            font-family: Arial;
        }

        body {
            /* margin: 3cm 2cm 2cm; */
            margin: 100px 25px;
        }

        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 1cm;
            background-color: #808080;
            color: white;
            text-align: center;
            line-height: 10px;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 1.5cm;
            background-color: #808080;
            color: white;
            text-align: center;
            line-height: 15px;
        }
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
        <header>
            
        </header>

                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                          
                            <th>ID</th>
                            <th>CEDULA</th>
                            <th>INGRESO</th>
                            {{-- <th>SALIDA</th> --}}
                            {{-- <th>NOTA</th> --}}
                                
                        </tr>
                      </thead>
                     
                      <tbody>
                        @foreach ($empleados as $empleado)
                        	<tr>
                            <td scope="row">{{ $empleado->id }}</td>
                            <td>{{ $empleado->cinumber }}</td>
                            <td>{{ $empleado->timestamp }}</td>
                            {{-- <td>{{ $empleado->updated_at }}</td> --}}
                            {{-- <td>{{ $empleado->note }}</td> --}}
                           <td>
                           
                        </tr>
                        @endforeach
                        
                      </tbody>
                    </table>

                  </div>
                
                </div>
              </div>
              <footer class="footer">
               <li class="" aria-current="page">Laboratorio Clinico Biloba en Barrio Obrero (Sede Principal)</li>
               <li class="" aria-current="page">(0276)356.6525/1825</li>
               <li class="" aria-current="page">Carrera 19, Esquina con Calle 16, Frente al Minicentro Doña Angela, Barrio Obrero, San Cristobal</li>
             </footer>
