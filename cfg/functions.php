<?php

use PHPMailer\PHPMailer\PHPMailer;

function show($data)
{
    echo "<pre>" . print_r($data, 1) . "</pre>";
}

function loading($d)
{
    foreach ($_POST as $k => $v) {
        if (array_key_exists($k, $d)) {
            $d[$k]['value'] = trim($v);
        }
    }
    return $d;
}

function validate($d)
{
    $errors = '';
    foreach ($d as $k => $v) {
        if ($d[$k]['required'] && empty($d[$k]['value'])) {
            $errors .= "<li> Вы не заполнили поле {$d[$k]['innerName']} </li>";
        }
    }
    if (!checkCapcha($d['capcha']['value'])) {
        $errors .= "<li>Неверно ввели капчу</li>";
    }
    return $errors;
}

function setCapcha()
{
    $num1 = rand(1, 20);
    $num2 = rand(1, 20);
    $_SESSION['capcha'] = $num1 + $num2;
    return "Сколько будет {$num1} + {$num2} ?";
}

function checkCapcha($d)
{
    return ($_SESSION['capcha'] == $d);
}

function sendMail($examples, $mailSettings)
{
    $mail = new \PHPMailer\PHPMailer\PHPMailer();

    try {
        //Server settings
        $mail->SMTPDebug = 0;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = $mailSettings['host'];                    // Set the SMTP server to send through
        $mail->SMTPAuth   = $mailSettings['smtp_auth'];                                   // Enable SMTP authentication
        $mail->Username   =  $mailSettings['username'];                     // SMTP username
        $mail->Password   =   $mailSettings['password'];                            // SMTP password
        $mail->SMTPSecure =  $mailSettings['smtp_secure'];              // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       =          $mailSettings['port'];                                  // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom($mailSettings['from_email'], $mailSettings['from_name']);
        $mail->addAddress($mailSettings['to_email']);     // Add a recipient

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->CharSet = "UTF-8";
        $mail->Subject = "Заполненная форма";


        $flag = true;
        $message = "";

        foreach ($examples as $k => $v) {
            if (isset($v['mailable']) && $v['mailable'] == 0) {
                continue;
            }
            $message .= (($flag = !$flag) ? '<tr>' : '<tr style="background-color:#f8f8f8;">') . "
             <td style='padding:10px;border: #e9e9e9 1px solid;'>{$v['innerName']}</td>
            <td style='padding:10px;border: #e9e9e9 1px solid;'>{$v['value']}</td>
            </tr>";
        }
        $mail->Body = "<table style ='width:100%;'>$message</table>";
        if (!$mail->send()) {
            return false;
        };
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}
