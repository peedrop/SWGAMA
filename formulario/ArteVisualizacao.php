<?php	
	session_start();

	require_once '../class/ArteDAO.php';

	$arte = new Arte();

	if(isset($_GET["operacao"])){
		$operacao = $_GET["operacao"];
    }
    $resultado = '';
    if(isset($_GET["resultado"])){
		$resultado = $_GET["resultado"];
    }
    
    $titulo = "Cadastrando Arte";

	if(isset($_GET["idArte"])){
		
        $idArte = $_GET["idArte"];

		$arteDAO = new ArteDAO();
        $arte = $arteDAO->buscarPorId($idArte);
        
        $titulo = "Visualizando Arte";
	}		
?>

<!DOCTYPE html>
<html lang="pt">
    <head>
        <title>Arte Formulário</title>
        <?php 
            include_once("../blocosRepetidos/cssPadrao.php");  	
        ?>	
        <!-- Outros CSS-->
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
                                    <a class="btn btn-light btn-round float-right" href="../tabela/ArteTabela.php"><< Voltar</a>
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
                                    <form id="formArte" action="../controlador/ArteControlador.php?operacao=salvar" method="post" enctype="multipart/form-data">
                                            <div class="col-lg-4" style="margin-left: 375px;">
                                                <div class="card card-chart">
                                                    <div class="card-header">
                                                        <h5 class="card-category">Imagem</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <img src="../<?php echo $arte->getImagem() ?>" id="imagemTagImg" alt="Imagem Arte" height="100%" width="100%">
                                                    </div>
                                                </div>
                                            </div>
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
        <script type="text/javascript" src="../js/arteFormulario.js"></script>
        <script type="text/javascript" src="../js/imagemForm.js"></script>
    </body>
</html>
