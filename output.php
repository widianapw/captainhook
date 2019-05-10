<?php
	include 'db_con.php';
	global $koneksi;

	$koneksi->set_charset('utf8mb4');
	$TOKEN = "821904545:AAHQDMbWf46pc1e77g_0hqQOJgj4eiR3TYA";
	$usernamebot= "@cpthook_bot";
	$debug = false;
	function request_url($method)
	{
		global $TOKEN;
		return "https://api.telegram.org/bot" . $TOKEN . "/". $method;
	}

	function send_reply($chatid, $text)
	{
		global $debug;
		
		$data = array(
			'chat_id' => $chatid,
			'text' => $text,
		);
		
		$options = array(
			'http' => array(
				'header' => "Content-type: application/x-www-form-urlencodedrn",
				'method' => 'POST',
				'content' => http_build_query($data),
			),
		);
		$context = stream_context_create($options);
		$result = file_get_contents(request_url('sendMessage'), false, $context);
		if ($debug)
		print_r($result);
    }

    function send_photo($chatid)
	{
		global $debug;
		
		$data = array(
			'chat_id' => $chatid,
			'photo' => 'https://3.bp.blogspot.com/-IUyIJZ9hT_Y/WLtq_FlHT4I/AAAAAAAAF8o/EWrqnNUTWBQ_H2Jxv9MRv-zPVLv1r26mgCLcB/s1600/logo-teknologi-informasi-universitas-udayana-ti-unud-jhonarendra.png',
		);
		
		$options = array(
			'http' => array(
				'header' => "Content-type: application/x-www-form-urlencodedrn",
				'method' => 'POST',
				'content' => http_build_query($data),
			),
		);
		$context = stream_context_create($options);
		$result = file_get_contents(request_url('sendPhoto'), false, $context);
		if ($debug)
		print_r($result);
    }

    function send_location($chatid)
	{
		global $debug;
		
		$data = array(
			'chat_id' => $chatid,
			'latitude' => '-8.796166',
			'longitude' => '115.176397',
		);
		
		$options = array(
			'http' => array(
				'header' => "Content-type: application/x-www-form-urlencodedrn",
				'method' => 'POST',
				'content' => http_build_query($data),
			),
		);
		$context = stream_context_create($options);
		$result = file_get_contents(request_url('sendLocation'), false, $context);
		if ($debug)
		print_r($result);
    }

    function send_document($chatid)
	{
		global $debug;
		$file_url = 'https://jurnal.ugm.ac.id/buletinpsikologi/article/download/22759/pdf';
		$data = array(
			'caption'  => 'file',
			'chat_id' => $chatid,
			'document' => $file_url,
		);
		
		$options = array(
			'http' => array(
				'header' => "Content-type: application/x-www-form-urlencodedrn",
				'method' => 'POST',
				'content' => http_build_query($data),
			),
		);
		$context = stream_context_create($options);
		$result = file_get_contents(request_url('sendDocument'), false, $context);
		if ($debug)
		print_r($result);
    }
    
	while(true)	{
		global $koneksi;
    $result = mysqli_query($koneksi, "SELECT *FROM tb_outbox WHERE flag = '1'");
		while ( $row = mysqli_fetch_assoc($result)) {
			echo "-";
			$id_outbox = $row["id_outbox"];
			$chat_id = $row["chat_id"];

			if ($row["type"] == 'msg') {
				$text = $row["out_msg"];
				send_reply($chat_id, $text);
				mysqli_query($koneksi, "UPDATE tb_outbox set flag = '2',tgl = NOW() where id_outbox = $id_outbox");
			}

			elseif ($row["type"] == 'img') {
				send_photo($chat_id);
				mysqli_query($koneksi, "UPDATE tb_outbox set flag = '2',tgl = NOW() where id_outbox = $id_outbox");
			}

			elseif ($row["type"] == 'loc') {
				send_location($chat_id);
				mysqli_query($koneksi, "UPDATE tb_outbox set flag = '2',tgl = NOW() where id_outbox = $id_outbox");
			}

			elseif ($row["type"] == 'file') {
				send_document($chat_id);
				mysqli_query($koneksi, "UPDATE tb_outbox set flag = '2',tgl = NOW() where id_outbox = $id_outbox");
			}
        }
	}
	
	

?>