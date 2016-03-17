<html>
	<head>
		<title>gingamsgserver</title>
	</head>
	<body>

		<p>
			<?php
        	//codigo php aqui:

        	//http://example.com/?msg=...
        	//http://www.tv.unesp.br/ftp/files/convidado/ufabc/mensagem/gingamsgserver.php/?msg=
			//http://www.tv.unesp.br/webftp/geiza/chat/gingamsgserver.php/...


			define("MSG", "mensagens.txt");

			function read($fileName){
				if(!file_exists($fileName))
					return 0;
				if($arq = fopen($fileName, "r+")){
					$oldMsg = fread($arq, filesize($fileName));
					fclose($arq);
					return $oldMsg;
				}
			}

			function write($fileName, $usr, $msg){
				//echo "<" . time() . "> ";
				$oldFile = read($fileName);

				$oldFile = str_replace(array("\n<CONVERSA>\n","</CONVERSA>\n"), "",$oldFile);

				$toWrite = 	"\t<MENSAGEM>\n" .
							"\t\t<TIME>" . time() . "</TIME>" . "\n" .
							"\t\t<USR>" . $usr . "</USR>" . "\n" .
							"\t\t<MSG>" . $msg . "</MSG>" . "\n" . 
							"\t</MENSAGEM>\n";

				$msg = $oldFile . $toWrite;

				$msg = "\n<CONVERSA>\n" . $msg . "</CONVERSA>\n\n";

				if($arq = fopen($fileName, "w+")){
					fwrite($arq, $msg);
					fclose($arq);
				}
				return $msg;
			}


			// http://felipemeloni.xyz/gingamsgserver.php/?msg=teste&nome=teste

			$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			echo $url;
			echo "<br />";
			foreach($_GET as $key => $value)
			echo $key . " : " . $value . "<br />";

			$usr = $_GET["usr"];
			$msg = $_GET["msg"];

			write(MSG, $usr, $msg);

			/*
			if(isset($_REQUEST["msg"])){
				echo $_REQUEST;
				write(MSG, $msg);
				echo $msg;
			}
			*/

       		?>
       	</p>
    </body>
</html>