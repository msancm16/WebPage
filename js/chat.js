$(document).ready(function() {
  document.getElementById("viaje").onchange = (function () {
        var myName = document.getElementById("userName").text;
        var id = document.getElementById("viaje").value;
        var selected = document.getElementById("viaje").selectedIndex;

        if(selected != 0){ //SI selecciona la primera opcion borramos el select de perosnas, sino continuamos normalmente
          var elem = {
              "viajeId": id
          };

          $.ajax({
          	type: 'POST',
        	  data: elem,
        	  url: 'personasChat.php',
        	  dataType: "json",
        	  success: function(result) {
              $("#persona").empty();
              $("#persona").append("<option> --- </option>");
        	  	$.each(result, function(index, element){
                if(element.nombre != myName){ //Para evitar que escriba el propio nombre del usuario logeado
        				    $("#persona").append("<option value=\""+element.nombre+ "\">" + element.nombre + "</option>");
                }
        	   	});
        	  }
        	});
        } else{
          $("#persona").empty();
          $("#mensajes").empty();
        }
    });

    document.getElementById("persona").onchange = (function () {
      var myName = document.getElementById("userName").text;
      var name = document.getElementById("persona").value;
      var empty = "---";
      if(name != empty ){
          var elem = {
            "persona1": myName,
            "persona2": name
          };

          $.ajax({
            type: 'POST',
            data: elem,
            url: 'loadMensajes.php',
            dataType: "json",
            success: function(result) {
              $("#mensajes").empty();
              $.each(result, function(index, element){
                  if(element.persona1 == myName){ //Persona 1 es quien mando los mensajes, por tanto si soy persona 1 el mensaje ira a la derecha
                    $("#mensajes").append("<p class=\"enviado\">" + element.texto + "</p>");
                  } else{ //No fui yo quien envio el mensaje, y el mensaje ira a la izquierda
                    $("#mensajes").append("<p class=\"recibido\">" + element.texto + "</p>");
                  }
              });
              $(".enviado").css("text-align","right");
              // $(".enviado").css("color","green");
              $(".recibido").css("text-align","left");
            }
          });
        } else{ //Si selecciona --- vaciamos los mensajes
          $("#mensajes").empty();
        }
    });

    document.getElementById("sendButton").onclick = (function (){
        var myName = document.getElementById("userName").text;
        var destinatario = document.getElementById("persona").value;
        var msj = document.getElementById("textField").value;
        var elem = {
          "persona1": myName,
          "persona2": destinatario,
          "mensaje" : msj
        };

        $.ajax({
          type: 'POST',
          data: elem,
          url: 'sendMsj.php',
          dataType: "json",
          success: function(result) {
            $("#mensajes").empty();
            document.getElementById("textField").value = ""; //Borramos el textfield
            $.each(result, function(index, element){
                if(element.persona1 == myName){ //Persona 1 es quien mando los mensajes, por tanto si soy persona 1 el mensaje ira a la derecha
                  $("#mensajes").append("<p class=\"enviado\">" + element.texto + "</p>");
                } else{ //No fui yo quien envio el mensaje, y el mensaje ira a la izquierda
                  $("#mensajes").append("<p class=\"recibido\">" + element.texto + "</p>");
                }
            });
            $(".enviado").css("text-align","right");
            // $(".enviado").css("color","green");
            $(".recibido").css("text-align","left");
          }
        });
    });

});
