<html>
<head></head>
<body>
    

<?php
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $from = 'From: MyFoodScanner Site'; 
    $to = 'mts.seven@gmail.com'; 
    $subject = $_POST['subject'];
    $human = $_POST['human'];
			
    $body = "From: $name\n E-Mail: $email\n  Subject: $subject\n Message:\n $message";

    echo 'Enviando menssagem...'
				
    if ($_POST['submit'] && $human == '5') {				 
        if (mail ($to, $subject, $body, $from)) { 
	    $result = '<p>Your message has been sent!</p>';
	   } else { 
	       $result = '<p>Something went wrong, go back and try again!</p>'; 
	   } 
    } else if ($_POST['submit'] && $human != '5') {
	   $result = '<p>You answered the anti-spam question incorrectly!</p>';
    }
    else{
        $result = '<p>Something went wrong.</p>';
    }
?>


<h2>Obrigado pelo seu contato!</h2>
       <?php echo $result; ?>
       <button onclick="history.go(-1);"> Voltar </button>

</body>

</html> 