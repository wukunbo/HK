<?php
 
	$base64 = $_POST['formFile'];
 	$IMG = base64_decode( $base64 );
 	file_put_contents('1.jpg', $IMG )


?>
 