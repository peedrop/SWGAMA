<?php	
	session_start();
    if(isset($_SESSION['USUARIO'])){
	}else{
		echo "<script>alert('É preciso estar logado para acessar essa página!');location.href='../formulario/Login.php';</script>";
    }
    
	require_once '../class/UsuarioDAO.php';

	$usuario1 = new Usuario();

	if(isset($_GET["operacao"])){
		$operacao = $_GET["operacao"];
    }
    $resultado = '';
    if(isset($_GET["resultado"])){
		$resultado = $_GET["resultado"];
    }
    
    $titulo = "Cadastrando Usuário ";

	if(isset($_GET["idUsuario"])){
		
        $idUsuario = $_GET["idUsuario"];

		$usuario1DAO = new UsuarioDAO();
        $usuario1 = $usuario1DAO->buscarPorId($idUsuario);

        $nome = $usuario1->getNome();
        
        $titulo = "Editando Usuario : $nome";
	}		
?>

<!DOCTYPE html>
<html lang="pt">
    <head>
        <title>Usuário Formulário</title>
        <?php 
            include_once("../blocosRepetidos/cssPadrao.php");  	
        ?>	
        <!-- Outros CSS
        <link type="text/css" rel="stylesheet" href="../css/usuario1Formulario.css"/>
        -->
    </head>

    <body>	
        <div class="wrapper">
            <?php 
                include_once("../blocosRepetidos/sidebar.php");  	
            ?>
            <div class="main-panel" id="main-panel">
                <?php 
                    include_once("../blocosRepetidos/navbar.php");  	
                ?>
                <div class="panel-header panel-header-sm"></div>
                <div class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="col-md-3 float-right">
                                    <a class="btn btn-light btn-round float-right" href="../tabela/UsuarioTabela.php"><< Voltar</a>
                                </div>
                                <div class="card-header">
                                    <h5 class="title"><?php echo $titulo ?></h5>
                                </div>
                                <div class="card-body">
                                    <?php 
                                        if ($resultado == 'sucesso'){
                                            include_once("../blocosRepetidos/alertSucesso.php");  
                                        }
                                        if ($resultado == 'erro'){
                                            include_once("../blocosRepetidos/alertErro.php");  
                                        }
                                    ?>	
                                    <form id="formUsuario" action="../controlador/UsuarioControlador.php?operacao=salvar" method="post">
                                        <div class="row">
                                            <div class="col-md-6 pr-1">
                                                <div class="form-group">
                                                    <label>Nome</label>
                                                    <input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $usuario1->getIdUsuario(); ?>">
                                                    <input type="text" class="form-control" id="nome" name="nome" 
                                                    placeholder="Ex: Maria" value="<?php echo $usuario1->getNome(); ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3 pl-1">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="text" class="form-control" id="email" name="email" 
                                                     placeholder="maria@gmail.com" value="<?php echo $usuario1->getEmail(); ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3 pl-1">
                                                <div class="form-group">
                                                    <label>Senha</label>
                                                    <input type="text" class="form-control" id="senha" name="senha" 
                                                    placeholder="" value="<?php echo $usuario1->getSenha(); ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="reset" class="btn btn-danger btn-round mt-3">Cancelar</button>
                                        <button type="submit" class="btn btn-success btn-round mt-3">Salvar</button>
                                    </form>
                                </div>
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
        <script type="text/javascript" src="../js/usuario1Formulario.js"></script>
    </body>
</html>
