<?php
/* Database connection start */
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sors";

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());

/* Database connection end */


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0=>'n_voucher', 
	1=> 'dni',
	2=> 'apellido',
	3=> 'nombre',
	4=> 'fechacanje',
	5=> 'importe',
	6=> 'canjeado'
);

// getting total number records without any search
$sql = "SELECT * FROM `vouchers` WHERE `canjeado`= 0 ";
$query=mysqli_query($conn, $sql) or die("jsonvouchers.php: get vouchers");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT * FROM `vouchers` WHERE 1=1 AND `canjeado`= 0 ";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( n_voucher LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR dni LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR apellido LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR nombre LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR fechacanje LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($conn, $sql) or die("jsonvouchers.php: get vouchers");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("jsonvouchers.php: get vouchers");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = $row["n_voucher"];
	$nestedData[] = $row["dni"];
	$nestedData[] = $row["apellido"];
	$nestedData[] = $row["nombre"];
	$nestedData[] = $row["fechacanje"];
	$nestedData[] = $row["importe"];
	$nestedData[] = $row["canjeado"];
	
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
