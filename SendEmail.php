<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the data from the AJAX request and sanitize if needed
    $userName = filter_var($_POST['userName'], FILTER_SANITIZE_STRING);
    $userEmail = filter_var($_POST['userEmail'], FILTER_VALIDATE_EMAIL);
    $userSubject = filter_var($_POST['userSubject'], FILTER_SANITIZE_STRING);
    $userMessage = filter_var($_POST['userMessage'], FILTER_SANITIZE_STRING);
    $subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
    $from = filter_var($_POST['from'], FILTER_VALIDATE_EMAIL);
    $to = filter_var($_POST['to'], FILTER_VALIDATE_EMAIL);
}

// Initialize the response array
$response = array();




$emailContent = "
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Your Email Subject</title>
    <style>
        
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            background-image: url('https://khyberlandgroupuae.com/images/backg.jpg');
            background-size: cover; /* Adjust as needed */
            background-repeat: no-repeat;
            background-position: center center;
           
        }
        
        h2,p,li,strong {
            color: #fff;
           
        }
    </style>
</head>
<body>
    <div class='container' style = 'background-image: '>

        
        
        <h2>Contact Information</h2>
  
    <ul>
        <li><strong>Name:</strong> $userName</li>
        <li><strong>Email:</strong> $userEmail</li>
        <li style='color: #fff;'><strong style='color: #fff;'>Subject:</strong> $userSubject</li>
    </ul>
    <ul>
        <li style='list-style: none;'><h2>Message</h2></li>
        <li style='list-style: none;'><p>$userMessage</p></li>
    </ul>
    
    
    </div>
</body>
</html>
";



// Validate email addresses
if ($from && $to) {
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
    
                $headers .= "From: $from\r\n";
                $headers .= "Reply-To: $from\r\n";
                $headers .= "Return-Path: $from\r\n";
                $headers .= "CC: $to\r\n";
                $headers .= "BCC: $to\r\n"."X-Mailer: PHP/" . phpversion();
                

    if (mail($to, $subject, $emailContent, $headers)) {
        $response = array(
            'message' => "Hello, $userName! Thank you for submitting your details.",
            'data' => 'We will get in touch soon!',
        );
    } else {
        $response = array(
            'status' => 'error',
            'message' => "Mail sending failed.",
            'data' => 'Please try again later.',
        );
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Invalid email addresses provided.',
        'data' => 'Please provide valid email addresses.',
    );
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
