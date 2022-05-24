var ordenar = '';

function filtrar(comercio)
{	
	$.ajax({
		data: $("#frm_filtro").serialize()+ordenar,
		type: "POST",
		dataType: "json",
		url: "consultas.php?comercio="+comercio+"",
			success: function(data){
				var total = 0;
				var html = '<tr><td class="titulo_tabla">NOMBRE</td><td class="titulo_tabla">APELLIDO</td><td class="titulo_tabla">Nº DOCUMENTO</td><td class="titulo_tabla">CONDICION</td><td class="titulo_tabla">MONTO</td><td class="titulo_tabla">FECHA DE CARGA</td></tr>';
				if(data.length > 0){
					$.each(data, function(i,item){	
						html += '<tr class="fila">'
							html += '<td class="celda">'+item.rg_nombre+'</td>'
							html += '<td class="celda">'+item.rg_apellido+'</td>'
							html += '<td class="celda">'+item.rg_numero_documento+'</td>'
							html += '<td class="celda">'+item.rg_condicion+'</td>'
							html += '<td class="celda">'+item.rg_importe_pesos+'</td>'
							html += '<td class="celda">'+item.rg_fecha_canje+'</td>'	
						html += '</tr>';
						total += parseFloat(item.rg_importe_pesos);													
					});					
				}
						html += '<tr class="fila"><td class="celda" colspan="4" ></td><td class="celda_destacada">'+total+'</td><td class="celda"></td></tr>';
						
				if(total == 0) html = '<p class="mensajes_filtros" >No se encontraron registros..</p>'
				$("#mostrar_consultas").html(html);
			}
	  });
}


function filtrar_documento(comercio)
{	
	$.ajax({
		data: $("#frm_filtro_dni").serialize()+ordenar,
		type: "POST",
		dataType: "json",
		url: "consultas_dni.php?comercio="+comercio+"",
			success: function(data){
				var total = 0;
				var html = '<tr><td class="titulo_tabla">NOMBRE</td><td class="titulo_tabla">APELLIDO</td><td class="titulo_tabla">Nº DOCUMENTO</td><td class="titulo_tabla">CONDICION</td><td class="titulo_tabla">MONTO</td><td class="titulo_tabla">FECHA DE CARGA</td></tr>';
				if(data.length > 0){
					$.each(data, function(i,item){
						html += '<tr class="fila">'
							html += '<td class="celda">'+item.rg_nombre+'</td>'
							html += '<td class="celda">'+item.rg_apellido+'</td>'
							html += '<td class="celda">'+item.rg_numero_documento+'</td>'
							html += '<td class="celda">'+item.rg_condicion+'</td>'
							html += '<td class="celda">'+item.rg_importe_pesos+'</td>'
							html += '<td class="celda">'+item.rg_fecha_canje+'</td>'	
						html += '</tr>';
						total += parseFloat(item.rg_importe_pesos);									
					});					
				}
						html += '<tr class="fila"><td class="celda" colspan="4" ></td><td class="celda_destacada">'+total+'</td><td class="celda"></td></tr>';
					
				if(total == 0) html = '<p class="mensajes_filtros">No se encontraron registros..</p>'
				$("#mostrar_consultas").html(html);
			}
	  });
}

