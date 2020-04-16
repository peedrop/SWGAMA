<?php	
	session_start();
    if(isset($_SESSION['USUARIO'])){
	}else{
		echo "<script>alert('É preciso estar logado para acessar essa página!');location.href='../formulario/Login.php';</script>";
    }
	require_once '../class/TamanhoDAO.php';

	$tamanho = new Tamanho();

	if(isset($_GET["operacao"])){
		$operacao = $_GET["operacao"];
    }
    $resultado = '';
    if(isset($_GET["resultado"])){
		$resultado = $_GET["resultado"];
    }
    
    $titulo = "Cadastrando Tamanho ";

	if(isset($_GET["idTamanho"])){
		
        $idTamanho = $_GET["idTamanho"];

		$tamanhoDAO = new TamanhoDAO();
        $tamanho = $tamanhoDAO->buscarPorId($idTamanho);

        $nome = $tamanho->getTamanho();
        
        $titulo = "Editando Tamanho : $nome";
	}		
?>

<!DOCTYPE html>
<html lang="pt">
    <head>
        <title>Tamanho  Formulário</title>
        <?php 
            include_once("../blocosRepetidos/cssPadrao.php");  	
        ?>	
        <!-- Outros CSS-->
        <link type="text/css" rel="stylesheet" href="../css/tamanhoFormulario.css"/>
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
                                    <a class="btn btn-light btn-round float-right" href="../tabela/TamanhoTabela.php"><< Voltar</a>
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
                                    <form id="formTamanho" action="../controlador/TamanhoControlador.php?operacao=salvar" method="post">
                                        <div class="row">
                                            <div class="col-md-6 pr-1">
                                                <div class="form-group">
                                                    <label>Tamanho</label>
                                                    <input type="hidden" name="idTamanho" id="idTamanho" value="<?php echo $tamanho->getIdTamanho() ?>" >
                                                    <input type="text" class="form-control" id="tamanho" name="tamanho" 
                                                    value="<?php echo $tamanho->getTamanho() ?>" placeholder="Ex: M" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3 pl-1">
                                                <div class="form-group">
                                                    <label>Altura</label>
                                                    <input type="text" class="form-control" id="altura" name="altura" 
                                                    value="<?php echo $tamanho->getAltura() ?>" placeholder="Ex: 0,00" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3 pl-1">
                                                <div class="form-group">
                                                    <label>Largura</label>
                                                    <input type="text" class="form-control" id="largura" name="largura" 
                                                    value="<?php echo $tamanho->getLargura() ?>" placeholder="Ex: 0,00" required>
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
        <script type="text/javascript" src="../js/tamanhoFormulario.js"></script>
    </body>
</html>
