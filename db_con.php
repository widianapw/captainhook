<?php
	$koneksi =  mysqli_connect("www.db4free.net","captainhook","widiana1999","captainhook");
	if(mysqli_connect_errno()){
		printf ("Gagal terkoneksi : ".mysqli_connect_error());
		exit();
	}
?>