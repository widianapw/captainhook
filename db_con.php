<?php
	$koneksi =  mysqli_connect("remotemysql.com","pYRyUKA0J1","TYeoeqCy3h","pYRyUKA0J1");
	
	if(mysqli_connect_errno()){
		printf ("Gagal terkoneksi : ".mysqli_connect_error());
		exit();
	}
?>