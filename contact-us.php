<html>
<head></head>
<body>
    

<?php
    
// ----------------------------------------------------------------------------------------------------
// - Display Errors
// ----------------------------------------------------------------------------------------------------
ini_set('display_errors', 'On');
ini_set('html_errors', 0);

// ----------------------------------------------------------------------------------------------------
// - Error Reporting
// ----------------------------------------------------------------------------------------------------
error_reporting(-1);

// ----------------------------------------------------------------------------------------------------
// - Shutdown Handler
// ----------------------------------------------------------------------------------------------------
function ShutdownHandler()
{
    if(@is_array($error = @error_get_last()))
    {
        return(@call_user_func_array('ErrorHandler', $error));
    };

    return(TRUE);
};

register_shutdown_function('ShutdownHandler');

// ----------------------------------------------------------------------------------------------------
// - Error Handler
// ----------------------------------------------------------------------------------------------------
function ErrorHandler($type, $message, $file, $line)
{
    $_ERRORS = Array(
        0x0001 => 'E_ERROR',
        0x0002 => 'E_WARNING',
        0x0004 => 'E_PARSE',
        0x0008 => 'E_NOTICE',
        0x0010 => 'E_CORE_ERROR',
        0x0020 => 'E_CORE_WARNING',
        0x0040 => 'E_COMPILE_ERROR',
        0x0080 => 'E_COMPILE_WARNING',
        0x0100 => 'E_USER_ERROR',
        0x0200 => 'E_USER_WARNING',
        0x0400 => 'E_USER_NOTICE',
        0x0800 => 'E_STRICT',
        0x1000 => 'E_RECOVERABLE_ERROR',
        0x2000 => 'E_DEPRECATED',
        0x4000 => 'E_USER_DEPRECATED'
    );

    if(!@is_string($name = @array_search($type, @array_flip($_ERRORS))))
    {
        $name = 'E_UNKNOWN';
    };

    return(print(@sprintf("%s Error in file \xBB%s\xAB at line %d: %s\n", $name, @basename($file), $line, $message)));
};

$old_error_handler = set_error_handler("ErrorHandler");


if(isset($_POST['email'])) {
 
    echo("<script>console.log('PHP: ".json_encode($_POST['email'])."');</script>");
 
    $email_to = "mts.seven@gmail.com";
 
    $email_subject = "New MyFoodScanner Site Message";
 
 
    function died($error) {
 
        // your error code can go here
        echo "<br />";
 
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

    $anti_spam_answer = '5';
 
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
  if(!preg_match($email_exp,$email_from)) {
 
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
 
  }
 
    $string_exp = "/^[A-Za-z .'-]+$/";
 
  if(!preg_match($string_exp,$first_name)) {
 
    $error_message .= 'The First Name you entered does not appear to be valid.<br />';
 
  }
 
  if($human =! '5') {
 
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
     
    // mail($email_to, $email_subject, $email_message, $headers);

    echo("<script>console.log('PHP: envio do mail');</script>");

     $url = 'https://api.sendgrid.com/';
     $user = 'azure_526d0671b57fa2464886e31c0c2d3b30@azure.com';
     $pass = 'behappysmtp1'; 

     $params = array(
          'api_user' => $user,
          'api_key' => $pass,
          'to' => 'mts.seven@gmail.com',
          'subject' => 'New message from MyFoodScanner',
          'html' => 'testing body',
          'text' => $email_message,
          'from' => $email_from,
       );

     
     $request = $url.'api/mail.send.json';
     try {
     // Generate curl request
     $session = curl_init($request);

     // Tell curl to use HTTP POST
     curl_setopt ($session, CURLOPT_POST, true);

     // Tell curl that this is the body of the POST
     curl_setopt ($session, CURLOPT_POSTFIELDS, $params);

     // Tell curl not to return headers, but do return the response
     curl_setopt($session, CURLOPT_HEADER, false);

     //Turn off SSL
    curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($session, CURLOPT_SSL_VERIFYHOST, false);

     curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

     // obtain response
     $response = curl_exec($session);
     curl_close($session);

     // print everything out
     print_r($response);
     echo("<script>console.log('PHP: ".json_encode($response)."');</script>");
     } catch(Exception $e) {

        trigger_error(sprintf(
            'Curl failed with error #%d: %s',
            $e->getCode(), $e->getMessage()),
            E_USER_ERROR);

    }
}
 
?>
 
 
 
<!-- include your own success html here -->
 
 
 

<h2>Thank you for contacting us. We will be in touch with you very soon.</h2>
       
       <button onclick="history.go(-1);"> Voltar </button>

</body>

</html> 