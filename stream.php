<?php
	/** php �������ļ� 
	* @param  String  $url  ���յ�·�� 
	* @param  String  $file Ҫ���͵��ļ� 
	* @return boolean 
	*/  
	function sendStreamFile($url, $file){  
	  
	    if(file_exists($file)){  
	  
	        $opts = array(  
	            'http' => array(  
	                'method' => 'POST',  
	                'header' => 'content-type:application/x-www-form-urlencoded',  
	                'content' => file_get_contents($file)  
	            )  
	        );  
	  
	        $context = stream_context_create($opts);  
	        $response = file_get_contents($url, false, $context);  
	        $ret = json_decode($response, true);
	        return $ret['success'];  
	  
	    }else{  
	        return false;  
	    }  
	  
	}  
	  
	$ret = sendStreamFile('http://127.0.0.1:81/stream.php', 'send.jpg');  
	var_dump($ret); 

	/** php �������ļ� 
	* @param  String  $file ���պ󱣴���ļ��� 
	* @return boolean 
	*/  
	function receiveStreamFile($receiveFile){  
	  
	    $streamData = isset($GLOBALS['HTTP_RAW_POST_DATA'])? $GLOBALS['HTTP_RAW_POST_DATA'] : '';  
	  
	    if(empty($streamData)){  
	        $streamData = file_get_contents('php://input');  
	    }  
	  
	    if($streamData!=''){  
	        $ret = file_put_contents($receiveFile, $streamData, true);  
	    }else{  
	        $ret = false;  
	    }  
	  
	    return $ret;  
	  
	}  
	  
	$receiveFile = 'receive.jpg';  
	$ret = receiveStreamFile($receiveFile);  
	echo json_encode(array('success'=>(bool)$ret));   
?>