

<?php

require_once("conectjson.php");

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());

/* Database connection end */

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0=> 'id',
	1=> 'fecha', 
	2=> 'dni',
	3=> 'apellido',
	4=> 'nombre',
	5=> 'monto',
	6=> 'descripcion',
	7=> 'puntos',
	8=> 'sucursal'
);

// getting total number records without any search
$sql = "SELECT *, DATE_FORMAT(fecha,'%d-%m-%Y') AS fechala FROM `acumulacion` ";
$query=mysqli_query($conn, $sql) or die("jsonhistorial.php: get historial");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT *, DATE_FORMAT(fecha,'%d-%m-%Y') AS fechala FROM `acumulacion` WHERE 1=1 ";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( dni LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR apellido LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR nombre LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR sucursal LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($conn, $sql) or die("jsonhistorial.php: get historial");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("jsonhistorial.php: get historial");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = $row["fechala"];
	$nestedData[] = $row["dni"];
	$nestedData[] = utf8_encode($row["apellido"]);
	$nestedData[] = utf8_encode($row["nombre"]);
	$nestedData[] = '$ '.$row["monto"];
	$nestedData[] = $row["puntos"];
	$nestedData[] = utf8_encode($row["descripcion"]);
	$nestedData[] = utf8_encode($row["sucursal"]);
	$data[] = $nestedData;
}



$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>