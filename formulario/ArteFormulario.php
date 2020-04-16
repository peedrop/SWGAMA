<?php	
	session_start();
	if(isset($_SESSION['USUARIO'])){
	}else{
		echo "<script>alert('É preciso estar logado para acessar essa página!');location.href='../formulario/Login.php';</script>";
	}
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

        $nome = $arte->getImagem();
        
        $titulo = "Editando Arte: $nome";
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
                                            <input class="btn btn-info" type="button" id="botaoImagem" value="Escolha a imagem da arte">
                                                <input class="btn btn-danger float-right" type="button" id="limparImagem" onclick="limpar()" value="Limpar imagem">
                                            <div class="col-lg-4">
                                                <div class="card card-chart">
                                                    <div class="card-header">
                                                        <h5 class="card-category">Imagem</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <input id="imagem" name="imagem" type="file" accept="image/*" hidden>
                                                        <img src="../images/padrao.jpg" id="imagemTagImg" alt="Imagem Arte" height="100%" width="100%">
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
        <script type="text/javascript" src="../js/arteFormulario.js"></script>
        <script type="text/javascript" src="../js/imagemForm.js"></script>
    </body>
</html>
