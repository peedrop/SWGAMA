<?php	
	session_start();
    if(isset($_SESSION['USUARIO'])){
	}else{
		echo "<script>alert('É preciso estar logado para acessar essa página!');location.href='../formulario/Login.php';</script>";
    }
	require_once '../class/TipoMalhaDAO.php';

	$tipoMalha = new TipoMalha();

	if(isset($_GET["operacao"])){
		$operacao = $_GET["operacao"];
    }
    $resultado = '';
    if(isset($_GET["resultado"])){
		$resultado = $_GET["resultado"];
    }
    
    $titulo = "Cadastrando Tipo de Malha";

	if(isset($_GET["idMalha"])){
		
        $idMalha = $_GET["idMalha"];

		$tipoMalhaDAO = new TipoMalhaDAO();
        $tipoMalha = $tipoMalhaDAO->buscarPorId($idMalha);

        $nome = $tipoMalha->getNome();
        
        $titulo = "Editando Tipo de Malha: $nome";
	}		
?>

<!DOCTYPE html>
<html lang="pt">
    <head>
        <title>Tipo de Malha Formulário</title>
        <?php 
            include_once("../blocosRepetidos/cssPadrao.php");  	
        ?>	
        <!-- Outros CSS-->
        <link type="text/css" rel="stylesheet" href="#"/>
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
                <div class="panel-header panel-header-sm">
                </div>
                <div class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="col-md-3 float-right">
                                    <a class="btn btn-light btn-round float-right" href="../tabela/TipoMalhaTabela.php"><< Voltar</a>
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
                                    <form id="formTipoMalha" action="../controlador/TipoMalhaControlador.php?operacao=salvar" method="post">
                                        <div class="row">
                                            <div class="col-md-6 pr-1">
                                                <div class="form-group">
                                                    <label>Nome</label>
                                                    <input type="hidden" name="idMalha" id="idMalha" value="<?php echo $tipoMalha->getIdMalha() ?>" >
                                                    <input type="text" class="form-control" id="nome" name="nome" 
                                                    value="<?php echo $tipoMalha->getNome() ?>" placeholder="Ex: Poliéster" required>
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
        <script type="text/javascript" src="../js/tipoMalhaFormulario.js"></script>
    </body>
</html>
