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
                                    <div class="col-md-3">
                                        <b>Login <b>
                                    </div>
                                </div>
                                <form id="formLogin" action="../controlador/LoginControlador.php?operacao=autenticar" method="post" >
                                    <div class="row justify-content-md-center">
                                        <div class="row align-items-center">
                                            <div class="col-md-8">
                                                <label>Email</label>
                                                <input type="email" class="form-control" name="email" id="email" placeholder="Email(admin@gmail.com)">
                                            </div>
                                            <div class="col-md-8">
                                                <label>Senha</label>
                                                <input type="password" class="form-control" name="senha" id="senha" placeholder="Senha (1234)" >
                                            </div>
                                            <div class="col-md-8">
                                                <a href="RecuperarSenha.php">Recuperar senha</a>
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-md-8 pr-1">
                                                <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                    </div>
                                </form>
                            </div>
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
    </body>
</html>
