<?php
	session_start();
	if(isset($_SESSION['USUARIO'])){
		echo "<script>location.href='../index.php';</script>";
	}
?>

<!DOCTYPE html>
<html lang="pt">
    <head>
        <title>Login</title>
        <?php 
            include_once("../blocosRepetidos/cssPadrao.php");  	
        ?>	
        <!-- Outros CSS-->
        <link type="text/css" rel="stylesheet" href="#"/>
    </head>

    <body>	
        <div class="wrapper">
            <div class="panel-header panel-header-sm">
                <div class="row justify-content-md-center">
                    <div class="col-md-3">
                        <div class="row align-items-center">
                            <h2 class="text-secondary">SWGAMA</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <div class="row justify-content-md-center">
                                <div class="col-md-2">
                                    <b>Recuperar Senha</b>
                                </div>
                            </div>
                            <form id="formRecuSenha" action="../controlador/LoginControlador.php?operacao=recuperarSenha" method="post" >
                                <div class="row justify-content-md-center">
                                    <div class="row align-items-center">
                                        <div class="col-md-12">
                                            <label>Email</label>
                                            <input type="text" class="form-control" name="login" id="login" placeholder="Email">
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-md-8 pr-1">
                                            <button type="submit" class="btn btn-primary btn-block btn-flat">Enviar</button>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php 
                    include_once("../blocosRepetidos/footer.php");  	
                ?>
            </div>
        </div>
        <?php 
            include_once("../blocosRepetidos/jsPadrao.php");  	
        ?>
        <!-- Outros JS-->
        <script type="text/javascript" src="../js/login.js"></script>
        <script src="../js/recuperarSenha.js"></script>
    </body>

</html>
