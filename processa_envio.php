<?php

    //Importação de bibliotecas
    require "./bibliotecas/PHPMailer/Exception.php";
    require "./bibliotecas/PHPMailer/OAuth.php";
    require "./bibliotecas/PHPMailer/PHPMailer.php";
    require "./bibliotecas/PHPMailer/POP3.php";
    require "./bibliotecas/PHPMailer/SMTP.php";

    //Importando Namespaces
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;




    class Mensagem {
        //Atributos
        private $para = null;
        private $assunto = null;
        private $mensagem = null;
        public $status = array('cod_status' => null, 'descricao_status' => '');

        //Método get mágico
        public function __get($atr) {
            return $this->$atr;
        }

        //Método set mágico
        public function __set($atr, $valor) {
            $this->$atr = $valor;
        }

        //Teste de mensagem válida ou inválida
        public function mensagemValida() {
            if (empty($this->para) || empty($this->assunto)) {
                return false;
            }

            return true;
        }
    }


    //Instância da classe
    $mensagem = new Mensagem();

    //Recuperando dados do form front-end para popular a instância criada (com superglobal $_POST)
    $mensagem->__set('para', $_POST['para']);
    $mensagem->__set('assunto', $_POST['assunto']);
    $mensagem->__set('mensagem', $_POST['mensagem']);

    //Testa mensagem inválida
    if (!$mensagem->mensagemValida()) {
        echo 'Mensagem Inválida';
        header('Location: index.php?envio=erro');
    }

    //Se mensagem válida tenta:
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = false;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'EMAIL-REMETENTE-AQUI@gmail.com';
        // SMTP username
        
        /*Aqui necessário colocar senha da conta remetente
          ideal retirar o script do diretório público do server
          e escondê-lo atrás do firewall do sistema operacional servidor.
          por fins didáticos, não o fiz.
        */
        $mail->Password   = "SENHA REMETENTE AQUI";                               // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('teste.aagj@gmail.com', 'Remetente Teste');
        $mail->addAddress($mensagem->__get('para'));     // Add a recipient
        //$mail->addAddress('ellen@example.com');               // Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        // Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $mensagem->__get('assunto');
        $mail->Body    = $mensagem->__get('mensagem');
        $mail->AltBody = 'Necessário um client com suporte HTML para visualizar todo conteúdo da mensagem.';

        $mail->send();

        $mensagem->status['cod_status'] = 1;
        $mensagem->status['descricao_status'] = 'E-mail enviado com sucesso!';

    } catch (Exception $e) {

        $mensagem->status['cod_status'] = 2;
        $mensagem->status['descricao_status'] = 'Não foi possivel enviar este e-mail! Mailer Error:' . $mail->ErrorInfo;

    }

?>




<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>App Send Mail</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>

    <body>
        <div class="container">
            <!-- Imagem do topo -->
            <div class="py-3 text-center">

                <img src="logo.png" alt="" class="d-block mx-auto mb-2" width="72" height="72">
                <h2>Send Mail</h2>
                <p class="lead">Seu APP particular de envio de e-mails!</p>

            </div>

            <div class="row">
                <div class="col-md-12">
                    <!-- Tratativas de retorno caso SUCESSO -->
                    <? if ($mensagem->status['cod_status'] == 1) { ?>

                        
                        <div class="container">
                            <h1 class="display-4 text-success">Sucesso!</h1>

                            <p> <?= $mensagem->status['descricao_status'] ?> </p>

                            <a href="index.php" class='btn btn-info btn-lg mt-5 text-white'>Voltar</a>
                        </div>

                    <? } ?>
                    
                    <!-- Tratativas de retorno caso ERRO -->
                    <? if ($mensagem->status['cod_status'] == 2) { ?>

                        <div class="container">
                            <h1 class="display-4 text-danger">Ops! Algo deu errado.</h1>

                            <p> <?= $mensagem->status['descricao_status'] ?> </p>

                            <a href="index.php" class='btn btn-info btn-lg mt-5 text-white'>Voltar</a>
                        </div>

                    <? } ?>

                </div>

                <div class="col-md-12">
                    <footer class="text-center">
                        <span> <small>Criado por Alair J</small> </span>
                    </footer>
                </div>

            </div>
        </div>
    </body>
</html>