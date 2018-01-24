<?php
session_start();

if(isset($_POST['companySessionId'])){
$_SESSION['getCompanyObjects'] = $_POST['companySessionId'];
echo "success";
}else{
echo  "error";
}

?>