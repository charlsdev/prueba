<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Prueba Tecnica</title>

      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
   </head>

   <body>
      
      <div class="container">
         <div class="row mt-5">
            <div class="col-md-6 mx-auto text-center">
               <button type="button" class="btn btn-outline-danger" onclick="concumeREST();">
                  Extraer
               </button>
            </div>
         </div>

         <div class="row mt-4">
            <div class="col-md-8 mx-auto">
               <table class="table table-bordered border-primary">
                  <thead class="table-info">
                     <tr style="text-align: center;">
                        <th scope="col">ID</th>
                        <th scope="col"># Contacts</th>
                        <th scope="col">Lastname</th>
                        <th scope="col">Created Time</th>
                     </tr>
                  </thead>
                  <tbody class="allData" style="text-align: right;">
                     <tr>
                        <td colspan="4" style="text-align: center;">Empty table</td>
                     </tr>
                  </tbody>
                  </table>
            </div>
         </div>
      </div>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
      <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-md5/2.19.0/js/md5.min.js"></script> -->

      <!-- NOTA: Este codigo JS lo podríamos colocar en un archivo JS aparte y luego llamarlo -->
      <script>
         // Función que al hacer clic en el botón extrae los contactos de la WEB Service
         const concumeREST = () => {
            $.ajax({
               // Señalamos al archivo donde están todos los procesos de consume de la WEB Service
               url: 'controllers/C_index.php',
               // Tipo de Petición
               type: 'POST',
               // Que tipo de dato enviaré
               dataType: 'JSON',
               // Parámetros que debo de enviar en este caso
               data: {
                  operation: 'getchallenge',
                  username: 'prueba'
               }
            })
            .done(function(res) {
               // Aqui es donde me retorna todo como los datos, JSON, ARRAY, siempre definido en el archivo que apuntamos la inicio
               if (res.res) {
                  // Si todo es correcto el resultado final me entrega un ARRAY el cual verificamos si su longitud es mayor a 0 y si es así lo empezamos a recorrer
                  if (res.data.length > 0) {
                     // Usamos el INNERHTML de JS que nos permite modificar el DOM añadiendo codigo HTML
                     document.querySelector('.allData').innerHTML = ``;
                     const array = res.data;

                     // Recorremos le ARRAY
                     array.forEach(item => {
                        // Añadimos HTML al DOM (etiqueta) llamada 'allData'
                        // En este caso aquei es que llenamos los contactos que nos proporciona el WEB Service
                        document.querySelector('.allData').innerHTML += `
                              <tr>
                                 <th scope="row">${item.id}</th>
                                 <td>${item.contact_no}</td>
                                 <td>${item.lastname}</td>
                                 <td>${item.createdtime}</td>
                              </tr>
                           `;
                     });
                  } else {
                     // Si el array esta vacio se muestra un ALERT de aviso
                     swal(`Contacts Empty!`, `No existe contactos dentro de la lista...`, `info`);
                  }
               } else {
                  // Y en este caso si existe un error se muestra un ALERT detallando donde sucedió el error
                  swal(`${res.tittle}!`, `${res.message}`, `${res.icon}`);
               }
            })
            .fail(function(e) {
               // En este es un eeror general si sucede al intentar llamar el archivo o según la respuesta que nos proporciona
               console.log(`Error: ${e}`);
               console.log(e);
            });
         }

      </script>
   </body>
</html>