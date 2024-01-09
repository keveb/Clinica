<?php

$errorMSG = "";

// NAME
if (empty($_POST["name"])) {
    $errorMSG = "El mombre es requerido ";
} else {
    $name = $_POST["name"];
}

// EMAIL
if (empty($_POST["email"])) {
    $errorMSG .= "Email es requerido ";
} else {
    $email = $_POST["email"];
}

// MSG Guest
if (empty($_POST["guest"])) {
    $errorMSG .= "Subject es requerido ";
} else {
    $guest = $_POST["guest"];
}


// MSG Event
if (empty($_POST["event"])) {
    $errorMSG .= "Subject es requerido ";
} else {
    $event = $_POST["event"];
}


// MESSAGE
if (empty($_POST["message"])) {
    $errorMSG .= "Mensaje es requerido ";
} else {
    $message = $_POST["message"];
}


$EmailTo = "armanmia7@gmail.com";
$Subject = "Nuevo mensaje recibido";

// prepare email body text
$Body = "";
$Body .= "Name: ";
$Body .= $name;
$Body .= "\n";
$Body .= "Email: ";
$Body .= $email;
$Body .= "\n";
$Body .= "guest: ";
$Body .= $guest;
$Body .= "\n";
$Body .= "event: ";
$Body .= $event;
$Body .= "\n";
$Body .= "Message: ";
$Body .= $message;
$Body .= "\n";

// send email
$success = mail($EmailTo, $Subject, $Body, "From:".$email);

// redirect to success page
if ($success && $errorMSG == ""){
   echo "Hecho";
}else{
    if($errorMSG == ""){
        echo "Algo mal salio :(";
    } else {
        echo $errorMSG;
    }
}

?>