

<?php
/* Database connection start web */
/*
$servername = "localhost";
$username = "fw2011_sors";
$password = "foconet2017";
$dbname = "fw2011_sors_parmegiano";
*/
/* Database connection start local */

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "iflow_loyalty";

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());

/* Database connection end */

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0=> 'id',
	1=> 'n_voucher', 
	2=> 'fechacanje',
	3=> 'importe',
	4=> 'premio',
	5=> 'puntos',
	6=> 'canjeado'

);

$dni 	= $_POST['dninum'];
// getting total number records without any search
$sql = "SELECT *, DATE_FORMAT(fechacanje,'%d-%m-%Y') AS fechala FROM `vouchers` WHERE `dni`='$dni'";
$query=mysqli_query($conn, $sql) or die("jsonhistorialvouchers.php: get historial");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT *, DATE_FORMAT(fechacanje,'%d-%m-%Y') AS fechala FROM `vouchers` WHERE `dni`='$dni'";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( n_voucher LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR fechala LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR importe LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR premio LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR puntos LIKE '".$requestData['search']['value']."%' )";

}
$query=mysqli_query($conn, $sql) or die("jsonhistorialvouchers.php: get historial");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("jsonhistorialvouchers.php: get historial");
$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 
	
	if ($row["canjeado"] == 1) {
		$row["descanjeado"] = 'S&iacute';
	}
		else
		{
			$row["descanjeado"] = 'No';
		}
	
	$nestedData[] = $row["fechala"];
	$nestedData[] = $row["n_voucher"];
	if (($row["premio"]) == "Voucher") { 
	$nestedData[] = '$ '.$row["importe"];
	}
	else
	$nestedData[] = "";
	$nestedData[] = $row["premio"];
	$nestedData[] = $row["puntos"];
	$nestedData[] = $row["descanjeado"];

	
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
