/*
"dom": '<"top"i>rt<"bottom"flp><"clear">',
"dom": '<"top"flpi>'
i = information
f = filter
l = lenght
p = pagination
*/

$(document).ready(function(){

	/*
	$("#dataGrid").DataTable({
		"language": {
			"url": "js/jquery-dataTables-1.10.13/Spanish.json"
		},
		"order": [[ 0, "desc" ]],
		"pagingType": "full_numbers",
		"dom": '<"top"fli>rt<"bottom"p><"clear">',
	});
	*/

	var t = $("#dataGrid").DataTable({
		//Para que no busque ni ordene en la columna 0 
		"columnDefs": [{
			"searchable": false,
			"orderable": false,
			"targets": 0
		}],
		"language": {
			"url": "js/jquery-dataTables-1.10.13/Spanish.json"
		},
		"order": [[ 1, "desc" ]],
		"pagingType": "full_numbers",
		//"lengthMenu": [[100, 50, 25, 10], [100, 50, 25, 10]],
		"dom": '<"top"fli>rt<"bottom"p><"clear">',
	});

	t.on("order.dt search.dt", function(){
		t.column(0, {search:"applied", order:"applied"}).nodes().each(function(cell, i){
			cell.innerHTML = i+1;
		});
	}).draw();

});