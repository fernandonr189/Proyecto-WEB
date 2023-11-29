<?php
    include 'connection.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    session_start();

    $id = $_SESSION['id'];
    $user = $_SESSION['name'];
    $user_email = $_SESSION['email'];
    $sql = "SELECT p.NAME, p.IMAGE, p.PRICE, p.DESCRIPTION, s.ID FROM PRODUCTS p, SHOPPING_CART s, USERS u WHERE s.PRODUCT_ID = p.ID AND s.USER_ID = u.ID AND u.ID = $id";

    $result = $conn->query($sql);

    $sql_price = "SELECT sum(p.PRICE) FROM PRODUCTS p, SHOPPING_CART s, USERS u WHERE s.PRODUCT_ID = p.ID AND s.USER_ID = u.ID AND u.ID = $id";
    $result_price = $conn->query($sql_price);


    require 'vendor/autoload.php';
    require 'vendor/fpdf/fpdf.php';

    $pdf=new Fpdf();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 18);
    $pdf->Image('logo.png',10,8,33);
    $pdf->SetFont('Arial','B',15);
    $pdf->Cell(80);
    $pdf->Cell(30,10,'Factura',1,0,'C');
    $pdf->Ln(20);
    $pdf->Cell(60,20, "Gracias por tu compra"." ".$user);

    while($rows=$result->fetch_assoc()) {
        $pdf->Ln(20);
        $pdf->Cell(60,20, "Concepto: ".$rows['NAME']." \$".$rows['PRICE']);
    }

    while($rows=$result_price->fetch_assoc()) {
        $pdf->Ln(20);
        $pdf->Cell(60,20, "Total a pagar: $".$rows['sum(p.PRICE)']);
    }
    
    $file_name = "Factura" . "_" . date('d-m-Y') . "-" . substr(md5(uniqid($id, true)), 0, 7) . ".pdf";
    $pdf->Output($file_name,"F");

    $outlook_mail = new PHPMailer();
    $outlook_mail->IsSMTP();
    $outlook_mail->Host = 'smtp-mail.outlook.com';
    $outlook_mail->Port = 587;
    $outlook_mail->SMTPSecure = 'tls';
    $outlook_mail->SMTPDebug = 0;
    $outlook_mail->SMTPAuth = true;
    $outlook_mail->Username = 'CyFer.ventas@outlook.com';
    $outlook_mail->Password = '12345678Fer';
    $outlook_mail->From = 'CyFer.ventas@outlook.com';
    $outlook_mail->FromName = 'CyFer.ventas@outlook.com';
    $outlook_mail->AddAddress($user_email, $user);
    $outlook_mail->IsHTML(true);
    $outlook_mail->Subject = 'Recibo de compra';
    $outlook_mail->Body    = 'Gracias por tu compra!';
    $outlook_mail->AltBody = 'This is the body in plain text for non-HTML mail clients at https://onlinecode.org/';
    $outlook_mail->AddAttachment($file_name, '', $encoding = 'base64', $type = 'application/pdf');

    $sql = mysqli_query($conn, "INSERT INTO USER_PURCHASES (FILENAME, USER_ID) VALUES ('$file_name', '$id')");
    if ($sql -> connect_errno){
        die("Error al registrar" . $sql -> connect_errno);
    } else {
        echo "Registrado correctamente";
    }

    if(!$outlook_mail->Send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $outlook_mail->ErrorInfo;
    }
    else {
        $result = array();
        $exit_code = 0;
        $script_path = "./bash/sendToWebdav /var/www/CyFer/php/" . $file_name;
        exec($script_path, $result, $exit_code);
        
        echo 'Message of Send email using Outlook SMTP server has been sent';
        $sql = mysqli_query($conn, "DELETE FROM SHOPPING_CART WHERE USER_ID = '$id'");
        header("location: ../index.php");
    }
?>