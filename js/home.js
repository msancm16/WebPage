$(document).ready(function() {

  var modal = document.getElementById('myModal');
  var modal2 = document.getElementById('myModal2');
  var modal3 = document.getElementById('myModal3');
  // Get the <span> element that closes the modal
  var span = document.getElementsByClassName("close")[0];
  var span2 = document.getElementById('close2');
  var span3 = document.getElementById('close3');
  // When the user clicks the button, open the modal
  $('button').on('click', function() {
    var element = this;
    var id = $(this).parent().parent().attr('id');

    if($(this).attr('id') == "btnPublicarViaje"){
      location.href = "crearViaje.php";
    }
    if($(this).attr('id') == "btnBuscarViaje"){
      location.href = "buscarViaje.php";
    }

    if ($(this).text() == "Anular"){ //ANULAR TRAYECTO SIENDO PASAJERO
      $.post("gestionarTrayecto.php", {
        origen : "anular",
        iD: id,
        idPasajero: $(this).val()
      }, function() {
        $("#" + id).fadeOut(2000);
        $("#" + id).empty();
      });
    }

    if ($(this).text() == "Ver conductor"){ //ANULAR TRAYECTO SIENDO PASAJERO
      $("#modalConductor").empty();
      $.post("gestionarUsuario.php", {
        origen : "cargar",
        iD: $(this).val()
      }, function(element) {

          $("#modalConductor").append(
          "<div class=\"Page\">"+
            "<div class=\"Trip-container\">"+
              "<div class=\"Trip\">"+
                "<span class=\"Trip-avatar\">"+
                  "<img src=\"data:image;base64,"+element.image+"\" alt=\"\" />"+
                "</span>"+
                "<div class=\"Trip-body\">"+
                  "<h1>"+element.nombre+"</h1>"+
                  "<span class=\"Trip-time\">DNI: "+element.dni+"</span>"+
                  "<span class=\"Trip-time\">Teléfono: "+element.telefono+"</span>"+
                  "<span class=\"Trip-time\">Email: "+element.email+"</span>"+
                "</div>"+
              "</div>"+
            "</div>"+
          "<p class=\"puntuacion\">Puntuar al conductor: </p>"+
          "<div class=\"starrr\"></div>"+
          "<p id=\"puntuacion\"></p>"
          );
          $('.starrr').starrr({
            change: function(e, value){
              $("#puntuacion").empty();
              $("#puntuacion").append(  "<p class=\"puntuacion\">Has puntuado al conductor con un "+value+"</p>");
            }
          });
      }, "json");

      modal3.style.display = "block";
      // When the user clicks on <span> (x), close the modal
      span3.onclick = function() {
        modal3.style.display = "none";
      };

      // When the user clicks anywhere outside of the modal, close it
      window.onclick = function(event) {
        if (event.target == modal2) {
          modal2.style.display = "none";
        }
      };
    }

    if ($(this).text() == "Borrar" & $(this).attr('class') == "btn btn-1 btn-1a u"){ //BORRAR USUARIO SIENDO ADMIN
      $.post("gestionarUsuario.php", {
        origen : "borrar",
        iD: id
      }, function() {
        $("#" + id).fadeOut("slow");
        $("#" + id).empty();
      });
    }
    if ($(this).text() == "Editar") { //EDITAR TRAYECTO SIENDO CONDUCTOR

      modal.style.display = "block";
      // When the user clicks on <span> (x), close the modal
      span.onclick = function() {
        modal.style.display = "none";
      };

      // When the user clicks anywhere outside of the modal, close it
      window.onclick = function(event) {
        if (event.target == modal) {
          modal.style.display = "none";
        }
      };

      $("#publicar").click(function() {
          $.post("gestionarTrayecto.php", {
            iD: id,
            origen: "editar",
            salida: $('#salida').val(),
            destino: $('#destino').val(),
            horaSalida: $('#horaSalida').val(),
            horaLlegada: $('#horaLlegada').val(),
            diaSalida: $('#diaSalida').val(),
            diaLlegada: $('#diaLlegada').val(),
            precio: $('#precio').val(),
            plazas: $('#plazas').val()
          }, function() {
            modal.style.display = "none";
            window.location.replace("home.php?v");
          });

        });

    }
    if ($(this).text() == "Borrar") { //BORRAR TRAYECTO SIENDO CONDUCTOR
      $.post("gestionarTrayecto.php", {
        origen: "borrar",
        iD: id
      }, function() {
        $("#" + id).fadeOut("slow");
        $("#" + id).empty();
      });
    } else if ($(this).text() == "Cancelar") { //CANCELAR TRAYECTO SIENDO CONDUCTOR
      $.post("gestionarTrayecto.php", {
        origen: "cancelar",
        iD: id
      }, function() {
        $("#" + id).children().eq(0).css("border", "3px solid #BD0000");
        $(element).hide();
        $("#" + id).children().eq(0).children().eq(0).children().eq(1).append("<span class=\"Trip-cancelled\">CANCELADO</span>");
      });
    }else if ($(this).text() == "Ver pasajeros"){  //VER PSASAJEROS
      $("#modalPasajeros").empty();
      $.post("gestionarTrayecto.php", {
        origen: "verPasajeros",
        iD: id
      }, function(result) {
        $.each(result, function(index, element){

            $("#modalPasajeros").append(
            "<div class=\"Page\">"+
              "<div class=\"Trip-container\">"+
                "<div class=\"Trip\">"+
                  "<span class=\"Trip-avatar\">"+
                    "<img src=\"data:image;base64,"+element.image+"\" alt=\"\" />"+
                  "</span>"+
                  "<div class=\"Trip-body\">"+
                    "<h1>"+element.nombre+"</h1>"+
                    "<span class=\"Trip-time\">DNI: "+element.dni+"</span>"+
                  "</div>"+
                "</div>"+
              "</div>");
        });
      }, "json");

      modal2.style.display = "block";
      // When the user clicks on <span> (x), close the modal
      span2.onclick = function() {
        modal2.style.display = "none";
      };

      // When the user clicks anywhere outside of the modal, close it
      window.onclick = function(event) {
        if (event.target == modal2) {
          modal2.style.display = "none";
        }
      };
    }
  });

  // FIN A
  $(".account").click(function() {
    var X = $(this).attr('id');
    if (X == 1) {
      $(".submenu").hide();
      $(this).attr('id', '0');
    } else {
      $(".submenu").show();
      $(this).attr('id', '1');
    }
  });

  $(".submenu").mouseup(function() {
    return false;
  });

  $(".account").mouseup(function() {
    return false;
  });

  $(document).mouseup(function() {
    $(".submenu").hide();
    $(".account").attr('id', '');
  });

});
