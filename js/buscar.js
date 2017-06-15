$(document).ready(function() {
  function openNav() {
    document.getElementById("mySidenav").style.width = "500px";
    document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
  }

  function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.body.style.backgroundColor = "white";
  }

  $("#abrirFiltro").click(function() {
    openNav();
  });

  $("#cerrarFiltro").click(function() {
    closeNav();
  });

  $(".ec-stars-wrapper a").click(function(){
    $("#valoracion").val($(this).attr("value"));
  });

  $("#aplicar").click(function(){
        var elem = {
          "element": "busqueda",
          "origen": $("#origen").val(),
          "destino": $("#destino").val(),
          "fecha": $("#fecha").val(),
          "precio": $("#precio").val(),
          "plazas": $("#plazas").val(),
          "valoracion":  $("#valoracion").val()
        };

        var elem2 = {
          "element": "datos"
        }

        $.ajax({
          type: 'POST',
          data: elem2,
          url: 'busqueda.php',
          dataType: "json",
          success: function(result) {
            var idUser = result.id;

            if(result.tipo == "pasajero"){
              $.ajax({
                type: 'POST',
                data: elem,
                url: 'busqueda.php',
                dataType: "json",
                success: function(result) {
                  $(".results").empty();
                  $.each(result, function(index, element){
                        var valoracion = "";
                        for (var i = 0; i < element.valoracion_conductor; i++) {
                          valoracion = valoracion + "&#9733;";
                        }

                        $(".results").append("<div id=\"\" class=\"Page\">"+
                          "<div class=\"Trip-container\">"+
                            "<div class=\"Trip\">"+
                                   "<span class=\"Trip-avatar\">"+
                                     "<img src=\"data:image/png;base64,"+element.imagen_conductor+"\" alt=\"\" />"+ //data:image;base64,$_SESSION['imagen']
                                   "</span>"+
                                   "<div class=\"Trip-body\">"+
                                     "<h1>"+element.nombre_conductor+"</h1>"+
                                     "<span class=\"Trip-time\" style=\"color:blue\"> Valoracion:" +valoracion+"</span>"+
                                     "<span class=\"Trip-time\">"+element.horasalida+" &rarr; "+element.horallegada+"</span>"+
                                     "<span class=\"Trip-location\">"+
                                       "<span>"+element.origen+"</span> &rarr; <span>"+element.destino+"</span>"+
                                     "</span>"+
                                     "<span class=\"Trip-cost\">"+element.precio+"€ por plaza</span>"+
                                     "<span class=\"Trip-seats\">"+element.plazas+" plazas</span>"+
                                     "<span class=\"Trip-seats\">"+element.numeroPasajeros+" pasajeros apuntados</span>"+
                                   "</div>"+
                                 "</div>"+
                                  "</div>"+
                             "<div class=\"middle\">"+
                             "<button type=\"button\" class=\"reserv\" id=\"id-"+element.id+"\" value=\""+idUser+"\">Reservar</button>"+
                           "</div>"+
                         "</div>");

                         $("#id-"+element.id).click(function(){
                           var val = {
                             "element": "reservar",
                             "idT": $(this).attr("id").split("id-")[1],
                             "idP": $(this).attr("value")
                           }

                           $.ajax({
                             type: 'POST',
                             data: val,
                             url: 'busqueda.php',
                             dataType: "json",
                             success: function(result) {

                             }
                           });

                          $(this).prop("disabled",true);
                          $(this).hide();
                         });
                  });
                },

                error: function(result){
                  $(".results").empty();
                }
              });
            }else{
              $.ajax({
                type: 'POST',
                data: elem,
                url: 'busqueda.php',
                dataType: "json",
                success: function(result) {
                  $.each(result, function(index, element){
                        var valoracion = "";
                        for (var i = 0; i < element.valoracion_conductor; i++) {
                          valoracion = valoracion + "&#9733;";
                        }

                        $(".results").hide();
                        $(".results").empty();

                        $(".results").append("<div id=\""+element.id+"\" class=\"Page\">"+
                          "<div class=\"Trip-container\">"+
                            "<div class=\"Trip\">"+
                                   "<span class=\"Trip-avatar\">"+
                                     "<img src=\"data:image/png;base64,"+element.imagen_conductor+"\" alt=\"\" />"+ //data:image;base64,$_SESSION['imagen']
                                   "</span>"+
                                   "<div class=\"Trip-body\">"+
                                     "<h1>"+element.nombre_conductor+"</h1>"+
                                     "<span class=\"Trip-time\" style=\"color:blue\"> Valoracion:" +valoracion+"</span>"+
                                     "<span class=\"Trip-time\">"+element.horasalida+" &rarr; "+element.horallegada+"</span>"+
                                     "<span class=\"Trip-location\">"+
                                       "<span>"+element.origen+"</span> &rarr; <span>"+element.destino+"</span>"+
                                     "</span>"+
                                     "<span class=\"Trip-cost\">"+element.precio+"€ por plaza</span>"+
                                     "<span class=\"Trip-seats\">"+element.plazas+" plazas</span>"+
                                     "<span class=\"Trip-seats\">"+element.numeroPasajeros+" pasajeros apuntados</span>"+
                                   "</div>"+
                                 "</div>"+
                               "</div>"+
                             "<div class=\"middle\">"+

                           "</div>"+
                         "</div>");

                         $(".results").show();
                  });
                }
              });
            }
          }
        });
    closeNav();
  });



});
