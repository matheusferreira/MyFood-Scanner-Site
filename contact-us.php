<html>
<head></head>
<body>
    

<?php
require 'vendor/autoload.php';
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
 
    
    function died($error) {
 
        // your error code can go here
        echo "<br />";
 
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
 
        echo "These errors appear below.<br /><br />";
 
        echo $error."<br /><br />";
 
        echo "Please go back and fix these errors.<br /><br />";
 
        die();
 
    }

    function success() {
 
        // your error code can go here
        echo "<br />";
 
        echo "Thank you for contacting us. We will be in touch with you very soon.";
 
        echo "<br />";
 
        
 
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
 
  if($human != '5') {
 
    $error_message .= 'The Anti-Spam answer you entered does not appear to be valid.<br />';
 
  }
 
  if(strlen($message) < 2) {
 
    $error_message .= 'The Comments you entered do not appear to be valid.<br />';
 
  }
 
  if(strlen($error_message) > 0) {
 
    died($error_message);
 
  }
 
    $email_message = "Uma nova mensagem foi enviada através do formulário do site. Detalhes abaixo:\n\n<br/><br/>";
 
     
 
    function clean_string($string) {
 
      $bad = array("content-type","bcc:","to:","cc:","href");
 
      return str_replace($bad,"",$string);
 
    }
 
 
    $email_message .= "<b>Nome: </b>".clean_string($first_name)."\n <br/>";
 
    $email_message .= "<b>Assunto: </b>".clean_string($subject)."\n <br/>";
 
    $email_message .= "<b>Email: </b>".clean_string($email_from)."\n <br/><br/>"; 
 
    $email_message .= "<b>Mensagem: </b>".$message."\n <br/>";
 

    echo("<script>console.log('PHP: envio do mail');</script>");
    

    $email_to = "contato@myfoodscanner.com.br";
    $email_subject = "MyFoodScanner Site: Nova Mensagem";


     try {
        $from = new SendGrid\Email(null, $email_from);
        $to = new SendGrid\Email(null, $email_to);
        $content = new SendGrid\Content("text/html", $email_message);
        $mail = new SendGrid\Mail($from, $email_subject, $to, $content);

        $apiKey = getenv('AZURE_SENDGRID_API_KEY');
        $sg = new \SendGrid($apiKey);

        $response = $sg->client->mail()->send()->post($mail);
        echo("<script>console.log('PHP: Response Code=> ".json_encode($response->statusCode())."');</script>");
        echo("<script>console.log('PHP: Response Header=> ".json_encode($response->headers())."');</script>");
        echo("<script>console.log('PHP: Response Body=> ".json_encode($response->body())."');</script>");
        success();
        //echo $response->statusCode();
        //echo $response->headers();
        //echo $response->body();
     
     
     } catch(Exception $e) {

        trigger_error(sprintf(
            'Email failed with error #%d: %s',
            $e->getCode(), $e->getMessage()),
            E_USER_ERROR);

    }
}
 
?>
 
 
 
<!-- include your own success html here -->
 
 
 


       
       <button onclick="history.go(-1);"> Voltar </button>

</body>

</html> 