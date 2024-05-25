<?php

use PHPMailer\PHPMailer\PHPMailer;




// usama_send email
if (!function_exists('send_email')) {
    function send_email($to, $subject, $body)
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Specify your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = env('MAIL_USERNAME'); // SMTP username
        $mail->Password = env('MAIL_PASSWORD'); // SMTP password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        //Recipients
        $mail->setFrom(env('MAIL_USERNAME'), 'ShadySales');
        $mail->addAddress($to); // Add a recipient

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
    }
}

if (!function_exists('upload_pic')) {
    function upload_pic($pic,$folder)
    {
        $imageName = time() . '.' . $pic->extension();
        if (!file_exists(public_path($folder))) {
            mkdir(public_path($folder), 0777);
        }
        $pic->move(public_path($folder), $imageName);

        return $imageName;
    }
}
