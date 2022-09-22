<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Helpers\Mail {
		class Mail {
			private $headers = null,
					$receiver,
					$sender,
					$sender_name,
					$message,
					$subject;

			/**
			 * Mail constructor.
			 * @param string 		$receiver
			 * @param string 		$sender
			 * @param string 		$subject
			 * @param string 		$message
			 * @param string|null 	$sender_name
			 * @param string|null 	$headers
			 */
			public function __construct($receiver, $sender, $subject, $message, $sender_name = null, $headers = null) {
				$this->receiver = $receiver;
				$this->sender = $sender;
				$this->subject = $subject;
				$this->message = $message;
				$this->headers = $headers;
			}

			/**
			 * Returns the sender.
			 * @return string
			 */
			public function getSender() {
				if($this->sender_name != null && strlen($this->sender_name) > 0) {
					return $this->sender_name . ' <' . $this->sender . '>';
				}

				return $this->sender;
			}

			/**
			 * Returns the headers.
			 * @return string
			 */
			public function getHeaders() {
				if($this->headers == null) {
					$headers = 'From: ' . $this->getSender() . "\r\n";
					$headers .= 'Reply-To: '. $this->sender . "\r\n";
					$headers .= 'CC: ' . $this->sender . "\r\n";
					$headers .= 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";
				}

				return $this->headers;
			}

			/**
			 * Sends the mail.
			 */
			public function send() {
				mail($this->receiver, $this->subject, $this->message, $this->getHeaders());
			}
	    }
	}
