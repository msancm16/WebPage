$(document).ready(function(){
	$('#myFile').change(function(){
		var str = $(this).val();
    var n = str.lastIndexOf("\\");
    var result = str.substring(n+1, str.length);
		$('#path').val(result);
	});
	var elem2 = {
	 "element": "1"
	};

	$.ajax({
  	type: 'POST',
	  data: elem2,
	  url: 'busquedaIndex.php',
	  dataType: "json",
	  success: function(result) {
	  	$.each(result, function(index, element){
				var optionExists = ($("#origen option[value=" + element.origen + "]").length > 0);
				if(!optionExists){
					$("#origen").append("<option value=\""+ element.origen+ "\">" + element.origen + "</option>");
				}
	   	});
	  }
	});

	$("#origen").change(function(){
		if($("#origen").val() == ""){
			$("#destino").empty();
			$("#destino").append("<option value=\"\">...</option>");

			$("#tabla").empty();
		}else{
			var elem = {
				"element": "2",
				"origen": $("#origen").val()
			};

			$.ajax({
				type: 'POST',
				data: elem,
			  url: 'busquedaIndex.php',
			  dataType: "json",
			  success: function(result) {
					$("#destino").empty();

			   	$.each(result, function(index, element){
						var optionExists = ($("#destino option[value=" + element.destino + "]").length > 0);
						if(!optionExists){
							$("#destino").append("<option value=\"" + element.destino + "\">" + element.destino + "</option>");
						}
			   	});
			  }
			});
		}
	});

	$("#buscar").click(function(){
		if($("#origen").val() != "" && $("#destino").val() != "" && $("#fecha").val() != ""){
			var datos = {
				"element": "3",
				"origen":  $("#origen").val(),
				"destino":  $("#destino").val(),
				"fecha":  $("#fecha").val()
			};

			$.ajax({
				type: 'POST',
				data: datos,
			  url: 'busquedaIndex.php',
			  dataType: "json",
			  success: function(result) {
					$("#tabla").empty();

					$("#tabla").append("<tr>"+
	          "<th>Origen</th>"+
	          "<th>Destino</th>"+
	          "<th>Fecha Salida</th>"+
	          "<th>Fecha Llegada</th>"+
	          "<th>Precio</th>"+
	          "<th>Plazas</th>"+
	        "</tr>");

			   	$.each(result, function(index, element){
						$("#tabla").append("<tr>"+
		          "<th>"+element.origen+"</th>"+
		          "<th>"+element.destino+"</th>"+
		          "<th>"+element.horasalida+"</th>"+
		          "<th>"+element.horallegada+"</th>"+
		          "<th>"+element.precio+"</th>"+
		          "<th>"+element.plazas+"</th>"+
		        "</tr>");
			   	});

					$(".advert2").hide();
					$(".advert").hide();
					$(".modal").show();
			  },
				error: function(result) {
					$(".advert2").show();
					$(".advert").hide();
          $("#tabla").empty();
        }
			});
		}else{
			$(".advert2").hide();
			$(".advert").show();
		}
	});

	document.getElementsByClassName("close")[0].onclick = function(){
		document.getElementById('myModal').style.display = "none";
	}

	window.onclick = function(event) {
	    if (event.target ==  document.getElementById('myModal')) {
	         document.getElementById('myModal').style.display = "none";
	    }
	}

});
