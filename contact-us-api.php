<html>
<head></head>
<body>
    

<?php

require 'vendor/autoload.php';

$from = new SendGrid\Email(null, "test@example.com");
$subject = "Hello World from the SendGrid PHP Library!";
$to = new SendGrid\Email(null, "mtsdesigner@ymail.com");
$content = new SendGrid\Content("text/plain", "Hello, Email!");
$mail = new SendGrid\Mail($from, $subject, $to, $content);

$apiKey = "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";
$sg = new \SendGrid($apiKey);

$response = $sg->client->mail()->send()->post($mail);
echo $response->statusCode();
echo $response->headers();
echo $response->body();

?>

</body>
</html>