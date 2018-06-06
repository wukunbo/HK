<?php
	ini_set('display_errors', 'Off');  
	error_reporting(E_ALL & ~ E_WARNING);
	//error_reporting(E_ALL ^ E_DEPRECATED);
	session_start();
	header("Content-type: text/html; charset=utf-8");

 
 
	
	
	// $db_host = "39.108.91.77:3306";
	// $db_host_name = "39.108.91.77";
	// $db_host_port = "3306";
	// // database name
	// $db_name = "zhubao";
	// // database username
	// $db_user = "root";
	// $db_pass = "root";
	// database tuolve123456FOD;";//tuolve123456FOD;
		
 
 
	
	
	$db_host   = "193.112.100.47:3306";
	$db_host_name   = "193.112.100.47";
	$db_host_port   = "3306";

	$db_name   = "HK";

	// database username
	$db_user   = "yuancheng";
	
	// database password
	$db_pass   = "yuancheng";


	$con = mysql_connect($db_host, $db_user, $db_pass );
	 //$con = mysql_connect("localhost", "root", "root");
	$db_selected = mysql_select_db($db_name,$con);

	if (!$db_selected)
	{
	    die ("Can not use $dbdatabase : " . mysql_error());
	}

	//$con = mysql_connect("localhost", "root", "root");
	 
	//$con = mysql_connect("39.108.91.77", "root", "root");
	//$db_selected = mysql_select_db("xingguanyuan",$con);
	if (!$con){
	 	die('Could not connect: ' . mysql_error());
	 }
	mysql_query("SET NAMES 'utf8'");
	define('db_host', $db_host);
	define('db_host_name', $db_host_name);
	define('db_host_port', $db_host_port);
	define('db_name', $db_name);
	define('db_user', $db_user);
	define('db_pass', $db_pass);
	//define('DOMIAN','http://www.homeland.net.cn/');
	define('DOMAIN', "http://192.168.1.215/HK/web");