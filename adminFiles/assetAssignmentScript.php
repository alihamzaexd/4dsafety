<?php
session_start();
require_once(dirname(__FILE__).'/../db_connect.php');
$connectionClass = new DB_CONNECT();
$conn  = $connectionClass->connect();

// works when admin chooses an asset for user assingment	
if(isset($_POST['userAssetId'])){
    // saving asset ID in session to be assigned to checked users
    $_SESSION['userAssetId'] = $_POST['userAssetId'];
    echo "success";	
}
// works when any user is selected under user assignment
if(isset($_POST['userIdForAssetAssignment'])){
    $userId = $_POST['userIdForAssetAssignment'];
    $assetId = $_SESSION['userAssetId'];
    $employeeId;
	
	// get employee ID from person ID. Employee ID will be inserted along asset ID in Employee Asset
	$sqlForEmployeeId = "SELECT employee_id FROM EMPLOYEE WHERE person_id = {$userId}; ";
	$retForEmployeeId = pg_query($conn, $sqlForEmployeeId);
	$row = pg_fetch_row($retForEmployeeId);
	$employeeId = $row[0];
	
	// assign asset to the user; add employee ID and asset ID to employee_asset table			
	$sqlInsetIntoEmployeeAsset =<<<EOF
	INSERT into EMPLOYEE_ASSET(employee_id,asset_id) VALUES('{$employeeId}','{$assetId}');
EOF;
	$retInsetIntoEmployeeAsset= pg_query($conn, $sqlInsetIntoEmployeeAsset);
	if($retInsetIntoEmployeeAsset){
	    echo "success";
	}else{
	    echo "error";
	}
}

// works when any user is unchecked under user assignment
if(isset($_POST['userIdForAssetRemoval'])){
    $userId = $_POST['userIdForAssetRemoval'];
    $assetId = $_SESSION['userAssetId'];
    $employeeId;
	
	// get employee ID from person ID. Employee ID will be deleted from Employee Asset along asset ID 
	$sqlForEmployeeId = "SELECT employee_id FROM EMPLOYEE WHERE person_id = {$userId}; ";
	$retForEmployeeId = pg_query($conn, $sqlForEmployeeId);
	$row = pg_fetch_row($retForEmployeeId);
	$employeeId = $row[0];
	
	// unassign asset to the user; remove employee ID and asset ID from employee_asset table			
	$sqlDeleteFromEmployeeAsset =<<<EOF
	DELETE from EMPLOYEE_ASSET WHERE employee_id = {$employeeId} AND asset_id = {$assetId} ;
EOF;
	$retDeleteFromEmployeeAsset = pg_query($conn, $sqlDeleteFromEmployeeAsset);
	if($retDeleteFromEmployeeAsset){
	    echo "success";
	}else{
	    echo "error";
	}
}

// works when admin chooses an asset for company assingment	
if(isset($_POST['companyAssetId'])){
    // saving asset ID in session to be assigned to checked companies
    $_SESSION['companyAssetId'] = $_POST['companyAssetId'];
    echo "success";	
}

// works when any company is selected under company asset assignment
if(isset($_POST['companyIdForAssetAssignment'])){
    $companyObjId = $_POST['companyIdForAssetAssignment'];
    $assetId = $_SESSION['companyAssetId'];
	
	// assign asset to the company; add company object ID and asset ID to company_asset table			
	$sqlInsetIntoCompanyAsset =<<<EOF
	INSERT into COMPANY_ASSET(companyobj_id,asset_id) VALUES('{$companyObjId}','{$assetId}');
EOF;
	$retInsetIntoCompanyAsset= pg_query($conn, $sqlInsetIntoCompanyAsset);
	if($retInsetIntoCompanyAsset){
	    echo "success";
	}else{
	    echo "error";
	}
}

// works when any company is unchecked under company asset assignment
if(isset($_POST['companyIdForAssetRemoval'])){
    $companyObjId = $_POST['companyIdForAssetRemoval'];
    $assetId = $_SESSION['companyAssetId'];
	
	// unassign asset to the company; remove company object ID and asset ID from company_asset table			
	$sqlDeleteFromCompanyAsset =<<<EOF
	DELETE from COMPANY_ASSET WHERE companyobj_id = {$companyObjId} AND asset_id = {$assetId} ;
EOF;
	$retDeleteFromCompanyAsset = pg_query($conn, $sqlDeleteFromCompanyAsset);
	if($retDeleteFromCompanyAsset){
	    echo "success";
	}else{
	    echo "error";
	}
}


?>