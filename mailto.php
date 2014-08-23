<?php
	// multiple recipients
	$to  = 'Sousa Lae <sousa.lae@gmail.com>' . ', '; // note the comma
	$to .= 'Laerte Purchase <laerte.sousaneto@purchase.edu>';

	// subject
	$subject = 'Birthday Reminders for August';

	// message
	$message = '
	<html>
	<head>
	  <title>Birthday Reminders for August</title>
	</head>
	<body>
	  <p>Here are the birthdays upcoming in August!</p>
	  <table>
		<tr>
		  <th>Person</th><th>Day</th><th>Month</th><th>Year</th>
		</tr>
		<tr>
		  <td>Joe</td><td>3rd</td><td>August</td><td>1970</td>
		</tr>
		<tr>
		  <td>Sally</td><td>17th</td><td>August</td><td>1973</td>
		</tr>
	  </table>
	</body>
	</html>
	';

	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	// Additional headers
	$headers .= 'From: Pixelgraphy Support <support@pixelgraphy.net>' . "\r\n";

	// Mail it
	mail($to, $subject, $message, $headers,"-f your@email.here");
?>
