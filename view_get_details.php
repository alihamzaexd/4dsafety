<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
	session_start();
    require_once __DIR__ . '/db_connect.php';
    $db = new DB_CONNECT();
	
    $sql = "SELECT bm_id,b_name,b_category,bc_url from brand_management";
    $res = pg_query($sql) or die ($sql);
    
    $data = array();
    $type = array();
    while ($row = pg_fetch_array($res)) {
        $data = array("bm_id"=>$row[0],"b_name"=>$row[1],"b_category"=>$row[2],"bc_url"=>$row[3]);
        //$_SESSION['id'] = $row[0];
		array_push($type, $data);
    }
    
    echo json_encode($type);
