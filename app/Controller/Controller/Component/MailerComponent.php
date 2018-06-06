<?php

class MailerComponent extends Component {

    var $Controller;

    public function startup(Controller $controller) {
        $this->Controller = $controller;
    }

    function send_mail($data) {
        $mail = new PHPMailer();
        $body = $data['body'];
        $mail->IsSMTP(); // telling the class to use SMTP
        $mail->SMTPAuth = true;                  // enable SMTP authentication
        $mail->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent
        $mail->SMTPSecure = 'ssl';

        //LOCALHOST
        //$mail->Host = "ssl://smtpout.secureserver.net"; // sets the SMTP server
          $mail->Host = "smtp.gmail.com";
//        $mail->Host = "localhost"; // sets the SMTP server
        //SERVER
//        $mail->Host = "relay-hosting.secureserver.net"; // sets the SMTP server
        $mail->Port = 465;                    // set the SMTP port for the GMAIL server
        $mail->Username = "test16741@gmail.com";

        $mail->Password = "Pass@1@!";

        $mail->SetFrom('test16741@gmail.com', 'ChessClub Elite');



        $mail->Subject = $data['subject'];

        $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
        $mail->MsgHTML($body);
        $mail->AddAddress($data['email'], $data['username']);
        $mail->SMTPDebug = 2;
        $mail->Send();
        // Clear all addresses and attachments for next loop
        $mail->ClearAddresses();
        //$mail->ClearAttachments();

        return true;
    }

}

?>