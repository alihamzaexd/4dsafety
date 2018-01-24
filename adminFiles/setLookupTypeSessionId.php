<?php
session_start();

// to set lookup type ID in session, that will be used to fetch realted values of a lookup type 
if(isset($_POST['lookupTypeSessionId'])){
$_SESSION['getlookupTypeValues'] = $_POST['lookupTypeSessionId'];
echo "success";
}else{
echo  "error";
}

?>