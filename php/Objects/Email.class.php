<?php

class Email
{
    private $from;
    private $message;
    private $headers;

    function __construct()
    {
        $this->generateHeaders();
        $this->from = 'support@pixelgraphy.net';
        $this->message ='Blank';
    }

    public function sendEmail($to, $subject, $content)
    {
        $this->generateBody($subject, $content);
        mail($to, $subject, $this->message, $this->headers,"-f support@pixelgraphy.net");
    }

    private function generateBody($title, $content)
    {
        // message
        $this->message = "
		<html>
		<head>
		  <title>".$title."</title>
		</head>
		<body>
		".$content."
		</body>
		</html>
		";
        return $this->message;
    }

    private function generateHeaders()
    {
        // To send HTML mail, the Content-type header must be set
        $this->headers  = 'MIME-Version: 1.0' . "\r\n";
        $this->headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Additional headers
        $this->headers .= 'From: Pixelgraphy Support <support@pixelgraphy.net>' . "\r\n";
    }
}