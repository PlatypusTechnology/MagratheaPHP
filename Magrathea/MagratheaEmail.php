<?php

/**
 * MagratheaEmail:
 * 	function that manages e-mail sends, building headers and sending e-mails
 */
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
	
	/**
	 * if an error happened, it's this way you're gonna get it!
	 * @return 		object 		error on mail sending...
	 */
	function getError(){
		return $error;
	}

	/**
	 * if we want to use a different SMTP, it should be set here.
	 * The format of the SMTP is: 
	 * 		array(["smtp_host"] => "", ["smtp_port"] => "", ["smtp_username"] => "", ["smtp_password"] => "")
	 * @param 	array 		$smtp  	SMTP for use, in the format above
	 * @return 	$this       itself
	 */
	function startSMTP($smtp){
		$this->smtpArr = $smtp;
		$this->smtpArr["auth"] = true;
		return $this;
	}

	/**
	 * Who's the guy(s) you have been contacting, huh?
	 * @param 		string 		$var 		destination e-mail
	 * @return 	$this       itself
	 */
	function setTo($var){
		if( is_array($var) ){
			implode(", ", $var);
		}
		$this->to = $var;
		return $this;
	}
	/**
	 * Who should be replied?
	 * @param 	string 		$var 		e-mail 'reply-to'
	 * @return 	$this       itself
	 */
	function setReplyTo($var){
		if( is_array($var) ){
			implode(", ", $var);
		}
		$this->replyTo = $var;
		return $this;
	}
	/**
	 * Who are you pretending to be?
	 * @param string $from  e-mail 'from'
	 * @param string $reply e-mail 'reply-to' (same as `setReplyTo`) *optional*
	 * @return 	$this       itself
	 */	
	function setFrom($from, $reply=""){
		$this->from = $from;
		if( empty($replyTo) ){
			$this->replyTo = $from;
		} else {
			$this->replyTo = $reply;
		}
		return $this;
	}
	/**
	 * What the fuck are we talking about?
	 * @param 	string 		$subject 	message subject
	 * @return 	$this       itself
	 */
	function setSubject($subject){
		$this->subject = $subject;
		return $this;
	}
	/**
	 * Ok, I'm in a hurry and don't want to set everything... 
	 * can you give me all of this in a single function?
	 * 	YES, I CAN!
	 * @param 	string 		$to      		destination e-mail
	 * @param 	string 		$from    		origin e-mail
	 * @param 	string 		$subject 		subject
	 * @return 	$this       itself
	 */
	function setNewEmail($to, $from, $subject){
		$this->to = $to;
		$this->from = $from;
		$this->subject = $subject;
		return $this;
	}
	/**
	 * Set Message as HTML
	 * @param 	string 		$message 		HTML message
	 * @return 	$this       itself
	 */
	function setHTMLMessage($message){
		$this->htmlMessage = nl2br($message);
		return $this;
	}
	/**
	 * Set Message as TXT
	 * @param 	string 		$message 		TXT message
	 * @return 	$this       itself
	 */
	function setTXTMessage($message){
		$this->txtMessage = $message;
		return $this;
	}
	/**
	 * now we send it!
	 * @return boolean true on e-mail sent, false if we have any error
	 */
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

		$mensagem = empty($this->htmlMessage) ? $this->txtMessage : $this->htmlMessage;		

		if( mail($this->to,$this->subject,$mensagem,$headers) ){
			return true;
		} else {
			MagratheaDebugger::Instance()->Add("Error sending email to ".$mail->to);
			$this->error = "Error sending e-mail!";
			return false;
		}
	}


}




?>