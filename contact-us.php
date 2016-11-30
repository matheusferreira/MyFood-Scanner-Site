<html>
<head></head>
<body>
    

<?php
    

if(isset($_POST['email'])) {
 
    echo("<script>console.log('PHP: ".json_encode($_POST['email'])."');</script>");
 
    $email_to = "mts.seven@gmail.com";
 
    $email_subject = "New MyFoodScanner Site Message";
 
 
    function died($error) {
 
        // your error code can go here
 
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
 
        echo "These errors appear below.<br /><br />";
 
        echo $error."<br /><br />";
 
        echo "Please go back and fix these errors.<br /><br />";
 
        die();
 
    }

 
    // validation expected data exists
 
    if(!isset($_POST['name']) ||
 
        !isset($_POST['human']) ||
 
        !isset($_POST['email']) ||
 
        !isset($_POST['subject']) ||
 
        !isset($_POST['message'])) {
 
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
 
    }

    echo("<script>console.log('PHP: todos os parametros preenchidos');</script>");
 
     
 
    $first_name = $_POST['name']; // required
 
    $human = $_POST['human']; // required
 
    $email_from = $_POST['email']; // required
 
    $subject = $_POST['subject']; // not required
 
    $message = $_POST['message']; // required
 
     
 
    $error_message = "";
 
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
  if(!preg_match($email_exp,$email_from)) {
 
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
 
  }
 
    $string_exp = "/^[A-Za-z .'-]+$/";
 
  if(!preg_match($string_exp,$first_name)) {
 
    $error_message .= 'The First Name you entered does not appear to be valid.<br />';
 
  }
 
  if(!preg_match('5',$human)) {
 
    $error_message .= 'The Anti-Spam answer you entered does not appear to be valid.<br />';
 
  }
 
  if(strlen($message) < 2) {
 
    $error_message .= 'The Comments you entered do not appear to be valid.<br />';
 
  }
 
  if(strlen($error_message) > 0) {
 
    died($error_message);
 
  }
 
    $email_message = "Form details below.\n\n";
 
     
 
    function clean_string($string) {
 
      $bad = array("content-type","bcc:","to:","cc:","href");
 
      return str_replace($bad,"",$string);
 
    }
 
     
 
    $email_message .= "First Name: ".clean_string($first_name)."\n";
 
    $email_message .= "Subject: ".clean_string($subject)."\n";
 
    $email_message .= "Email: ".clean_string($email_from)."\n";
 
    $email_message .= "Message: ".clean_string($message)."\n";
 
     
 
     
 
// create email headers
 
$headers = 'From: '.$email_from."\r\n".
 
'Reply-To: '.$email_from."\r\n" .
 
'X-Mailer: PHP/' . phpversion();

echo("<script>console.log('PHP: criação dos headers');</script>");
 
mail($email_to, $email_subject, $email_message, $headers);

echo("<script>console.log('PHP: envio do mail');</script>");
 
?>
 
 
 
<!-- include your own success html here -->
 
 
 

<h2>Thank you for contacting us. We will be in touch with you very soon.</h2>
       
       <button onclick="history.go(-1);"> Voltar </button>

</body>

</html> 