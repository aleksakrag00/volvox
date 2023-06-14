<?php 
    session_start();

    $formular = "<table border=\"solid\"><tr><th>Naslov</th><th>Grad</th><th>Naselje</th><th>Ulica</th><th>Cena</th><th>Kvadratura</th><th>Tip</th></tr>";

    $id = $_SESSION["l0"];

    $naslov = $_SESSION["l1"];
    $grad = $_SESSION["l2"];
    $naselje = $_SESSION["l3"];
    $ulica = $_SESSION["l4"];
    $cena = $_SESSION["l5"];
    $kvadratura = $_SESSION["l6"];
    $tip = $_SESSION["l7"];

    for ($i=0; $i<count($naslov); $i++){
        $formular = $formular."<tr><td>".$naslov[$i]."</td><td>".$grad[$i]."</td><td>".$naselje[$i]."</td><td>".$ulica[$i]."</td><td>".$cena[$i]."</td><td>".$kvadratura[$i]."</td><td>".$tip[$i]."</td></tr>";
    }

    $formular = $formular."</table>";
    $mailmsg = $formular."<br><br><hr><br>".$_POST["poruka"];

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require "PHPmailer/src/Exception.php";
    require "PHPmailer/src/PHPMailer.php";
    require "PHPmailer/src/SMTP.php";

    //echo json_encode($naslov);

    
        $mail = new PHPMailer(true);
        if(isset($_POST["send"])){
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = "true";
            $mail->SMTPSecure = "tls";
            $mail->Port = "587";
            $mail->Username = "";
            $mail->Password = "";
            $mail->isHTML(true);
            $mail->Subject = $id;

            $mail->setFrom("aleksakrag@gmail.com");

            $mail->Body = $mailmsg;

            $mail->addAddress($_POST["email"]);

            $mail->Send();

            echo "Uspesno poslato!";
        }else{
            echo "Neuspesno poslato";
        }

?>

<br>
<br>
<hr>
<a href="index.php">Nazad</a>