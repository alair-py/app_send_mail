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
        
            <div class="py-3 text-center">

                <img src="logo.png" alt="" class="d-block mx-auto mb-2" width="72" height="72">
                <h2>Send Mail</h2>
                <p class="lead">Seu APP particular de envio de e-mails!</p>

            </div>

            <div class="row">
            
                <div class="col-md-12">
                
                    <div class="card-body font-weight-bold">
                    
                        <form action="processa_envio.php" method="post">
                            <div class="form-group">
                                <label for="para">Para</label>
                                <input name="para" type="text" class="form-control" id="para" placeholder="email@email.com">
                            </div>
                        
                            <div class="form-group">
                                <label for="assunto">Assunto</label>
                                <input name="assunto" type="text" class="form-control" id="assunto">
                            </div>
                        
                            <div class="form-group">
                                <label for="mensagem">Mensagem</label>
                                <textarea name="mensagem" id="mensagem" class="form-control"></textarea>
                            </div>


                            <!--Verifica se retornou um erro no envio em Processa_Envio.php, caso sim retorna para usuário-->
                            <? if(isset($_GET['envio']) && $_GET['envio'] == 'erro') { ?>

                                <div class='text-danger'>
                                    Erro ao enviar. Verifique os campos e tente novamente!
                                </div>

                            <? } ?>


                            <button type="submit" class="btn btn-primary btn-lg mt-2">Enviar Mensagem</button>
                        
                        </form>

                    </div>

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