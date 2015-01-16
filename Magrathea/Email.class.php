<?php

require "Mail.php";

class MagratheaEmail{
	
	private $to;
	private $from;
	private $replyTo;
	private $htmlMessage;
	private $txtMessage;
	private $subject;
	private $error;

	private $smtpArr;
	
	function Email(){}
	
	function getError(){
		return $error;
	}

	// SMTP array format:
	// array(["smtp_host"] => "", ["smtp_port"] => "", ["smtp_username"] => "", ["smtp_password"] => "")
	function startSMTP($smtp){
		$this->smtpArr = $smtp;
		$this->smtpArr["auth"] = true;
		return $this;
	}

	function setTo($var){
		if( is_array($var) ){
			implode(", ", $var);
		}
		$this->to = $var;
		return $this;
	}
	function setReplyTo($var){
		if( is_array($var) ){
			implode(", ", $var);
		}
		$this->replyTo = $var;
		return $this;
	}
	
	function setFrom($from, $reply=""){
		$this->from = $from;
		if( empty($replyTo) ){
			$this->replyTo = $from;
		} else {
			$this->replyTo = $reply;
		}
		return $this;
	}
	
	function setSubject($subject){
		$this->subject = $subject;
		return $this;
	}
	
	function setNewEmail($to, $from, $subject){
		$this->to = $to;
		$this->from = $from;
		$this->subject = $subject;
		return $this;
	}
	
	function setHTMLMessage($message){
		$this->htmlMessage = nl2br($message);
		return $this;
	}
	function setTXTMessage($message){
		$this->txtMessage = $message;
		return $this;
	}
	
	function send(){

		if( empty($this->to) ){ $this->error="E-mail destination empty!"; return false; }
		if( empty($this->from) ){ $this->error="E-mail sender empty!"; return false; }
		if( empty($this->replyTo) ){ $this->replyTo = $this->from; }
		if( empty($this->subject) ){ $this->subject=""; }

		$content_type = empty($this->htmlMessage) ? "text/plain" : "text/html";

		$headers = 'MIME-Version: 1.0'."\r\n";
		$headers .= 'Content-Type: '.$content_type.'; charset=utf-8'."\r\n";
		$headers .= 'From: '.$this->from."\r\n";
		$headers .= 'Reply-To: '.$this->replyTo."\r\n";
//		p_r($headers);

		$mensagem = empty($this->htmlMessage) ? $this->txtMessage : $this->htmlMessage;		

		if( mail($this->to,$this->subject,$mensagem,$headers) ){
			return true;
		} else {
			MagratheaLogger::Log("Error sending email to ".$mail->to);
			$this->error = "Error sending e-mail!";
			return false;
		}

	}


}




?>