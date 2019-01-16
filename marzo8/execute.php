		<?php
		//file necessari ad inviare foto, doc e audio
		require 'class-http-request.php';
		require 'functions.php';
		//modificare col vostro token del bot
		$api="726224672:AAG0BkK_et7e6aWmtjLGRFqb6yNhN60liI0";
		
		
		//prendo quello che mi è arrivato e lo salvo nella variabile content
		$content = file_get_contents("php://input");
		//decodifico quello che mi è arrivato
		$update = json_decode($content, true);
		//se non sono riuscito a decodificarlo mi fermo
		if(!$update)
		{
		  exit;
		}

        //altrimenti proseguo e vado a leggere il messaggio salvandolo nella variabile 
		//message
		$message = isset($update['message']) ? $update['message'] : "";
		//facciamo la stessa cosa anche per l'id del mess.
		$messageId = isset($message['message_id']) ? $message['message_id'] : "";
		//l'id della chat che servirà al nostro bot per sapere a chi risponder
		$chatId = isset($message['chat']['id']) ? $message['chat']['id'] : "";
		//il nome dell'utente che ha scritto
		$firstname = isset($message['chat']['first_name']) ? $message['chat']['first_name'] : "";
		//il cognome
		$lastname = isset($message['chat']['last_name']) ? $message['chat']['last_name'] : "";
		//lo username
		$username = isset($message['chat']['username']) ? $message['chat']['username'] : "";
		//la data
		$date = isset($message['date']) ? $message['date'] : "";
		//ed il testo del messaggio
		$text = isset($message['text']) ? $message['text'] : "";
		
        //eliminiamo gli spazi con trim e convertiamo in minuscolo con la funz strtolower
		
		$text = trim($text);
		$text = strtolower($text);
        
		//$text = json_encode($message);
		 //costruiamo la risposta del nostro bot
		 //l'header è sempre uguale ed indica che sarà un messaggio con codifica
		 //JSON
		header("Content-Type: application/json");
		//i parametri sono cosa voglio mandare indietro al mio utente, rimando il testo che
		//ho ricevuto e che si trova nella variabile $text
		$parameters = array('chat_id' => $chatId, "text" => $text);
		if($text=="data"||$text=="/data")
		{
			$text="La data odierna è: ".date("d.m.y");
			$parameters = array('chat_id' => $chatId, "text" => $text);
			
		}
		if($text=="anni"||$text=="/anni")
		{
			$text="L'età è 2004";
			$parameters = array('chat_id' => $chatId, "text" => $text);
		}
		if($text=="orario"||$text=="/orario")
		{
			$text="L'ora attuale è: ".date("h.i.sa");
			$parameters = array('chat_id' => $chatId, "text" => $text);
			
		}
		
		if($text=="foto"||$text=="/foto")
				{
			$foto[0]="foto.png";
			$foto[1]="foto1.png";
			$foto[2]="foto2.png";
			
			$num=rand(0,2);
			
			sendFoto($chatId, $foto[$num] ,false, "La Mia Foto", $api);
				}
				
		if($text=="barz")
		{
			$barz[0]="Cosa fa Pisano alle 4 di notte?Cerca le 2004!";
			$barz[1]="Un taglialegna va in un negozio di abbigliamento e chiede alla commessa: “Vorrei un paio di jeans.” E la signorina domanda: “Che taglia?” La legna!";
			$barz[2]="Un consiglio per i medici: non mangiate una mela al giorno!";
			$barz[3]="Qual è il colmo per un idraulico? Non capire un tubo!";
			$i=rand(0,3);
			$parameters = array('chat_id' => $chatId, "text" => $barz[$i]);
		}
		if($text=="sunrise")
		{
			sendAudio($chatId,"sunrise.mp3",false,"Gfriend-Sunrise",$api);
		}
		if($text=="pdf")
		{
			sendDocument($chatId,"testo.pdf",false,"Il tuo file pdf",$api);
		}
		
	
		
		//aggiungo il comando di invio
		//e lo invio
		
		$parameters["method"] = "sendMessage";
        echo json_encode($parameters);
		
		
		
		
		
		
		?>
		
		
		
		
		
		

		
		
		
