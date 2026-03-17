<html>
<head>

<style>
          @page {
            /* margin: 0px 0px 0px 0px !important;
            padding: 0px 0px 0px 0px !important; */
             /* margin: 0cm 0cm;   */
            /*margin: 100px 25px;  */
            font-family: Arial;
            margin: 25px 25px;  
            
        }

        body {
            /* margin: 3cm 2cm 2cm; */
            margin: 3cm 2cm 2cm;
            font-size: 15px;
        }

        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 1.5cm;
            background-color: #FDFEFE;
            color: black;
            text-align: center;
            line-height: 25px;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 1cm;
            background-color: #FDFEFE;
            color: black;
            text-align: left;
            line-height: 35px;
       
            p {
            font-family: Helvetica;
            font-size: 10px;
            font-weight: bold;
            font-style: italic;
            color: #17202A;
            background-color: #FDFEFE;
            border-style: solid;
            border-color: #17202A ;
            border-width: 2px;
            margin: 14px;
            padding: 30px;
            border-radius: 14px;
            }
            th {
                font-size: 15px;
            }
            td {
                font-size: 10px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


</head>
<body>
    

<header>
<img src="./images/biloba.jpg" align="left" style="width: 200px; height: 100px;">    
<p>Informe de Asistencias - Personal-Laboratorio Clinico BILOBA </p>
    
</header>
@foreach ($ingresos as $ingreso)
@endforeach
<main><br>
<p for="empleado_id">Empleado</p>
				            <select class="form-control" name="empleado_id" id="empleado_id">
													<option>--- Seleccione uno ---</option>
                                                           @foreach ($empleados as $empleado)
                                                            <option value="{{ $empleado->cinumber }}"
                                                                 @if ($empleado->cinumber == $ingreso->cinumber)
                                                                   selected
                                                                 @endif
                                                                 <p>Empleado:</p> >{{ $empleado->name }}</option>
                                                           @endforeach
                                                           
				            </select>
<div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                  <table class="table table-striped text-center" >
                      <thead>
                          <tr class="">
                              <th scope="col">Id</th>
                              <th scope="col">Cedula</th>
                              <th scope="col">Fecha</th>
                              {{-- <th scope="col">Total</th> --}}
                              {{-- <th scope="col">Status</th> --}}

                            
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($ingresos as $ingreso)
                          <tr>
                            <td scope="row">{{ $ingreso->id }}</td>
                            <td>{{ $ingreso->cinumber }}</td>
                            <td>{{ $ingreso->timestamp }}</td>
                            
                              
                          </tr>
                          @endforeach
                      </tbody>
                      
                   </table>
                   <hr>
                  </div>
                
                </div>
              </div>

</main>

                <footer class="footer">
                <p>Laboratorio Clinico Biloba en Barrio Obrero (Sede Principal) 
                (0276)356.6525/1825 
                Carrera 19, Esquina con Calle 16, Frente al Minicentro Doña Angela, Barrio Obrero, San Cristobal</p>
                 </footer>
</body>
</html>

