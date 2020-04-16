<?php	
	session_start();
    if(isset($_SESSION['USUARIO'])){
	}else{
		echo "<script>alert('É preciso estar logado para acessar essa página!');location.href='../formulario/Login.php';</script>";
    }
	require_once '../class/ModeloBlusaDAO.php';
	require_once '../class/ModoProdDAO.php';

	$modeloBlusa = new ModeloBlusa();

	if(isset($_GET["operacao"])){
		$operacao = $_GET["operacao"];
    }
    $resultado = '';
    if(isset($_GET["resultado"])){
		$resultado = $_GET["resultado"];
    }
    
    $titulo = "Cadastrando Modelo de Blusa";

	if(isset($_GET["idModeloBlusa"])){
		
        $idModeloBlusa = $_GET["idModeloBlusa"];

		$modeloBlusaDAO = new ModeloBlusaDAO();
        $modeloBlusa = $modeloBlusaDAO->buscarPorId($idModeloBlusa);

        $nome = $modeloBlusa->getNome();
        
        $titulo = "Editando Modelo de Blusa: $nome";
	}		
?>

<!DOCTYPE html>
<html lang="pt">
    <head>
        <title>Modelo de Blusa Formulário</title>
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
                                    <a class="btn btn-light btn-round float-right" href="../tabela/ModeloBlusaTabela.php"><< Voltar</a>
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
                                    <form enctype="multipart/form-data" id="formModeloBlusa" action="../controlador/ModeloBlusaControlador.php?operacao=salvar" method="post">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <label>Nome</label>
                                                    <input type="hidden" name="idModeloBlusa" id="idModeloBlusa" value="<?php echo $modeloBlusa->getIdModeloBlusa() ?>" >
                                                    <input type="text" class="form-control" id="nome" name="nome" 
                                                    value="<?php echo $modeloBlusa->getNome() ?>" placeholder="Ex: Modelo 1" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Modo Produção</label>
                                                    <select class="col form-control" id="idModoProducao" name="idModoProducao">  
                                                        <?php
                                                            $modoProdDAO = new ModoProdDAO();
                                                            $lista = $modoProdDAO->listar();

                                                            if($modeloBlusa->getModoProducao()->getIdModoProd() == 0){
                                                                echo "<option value='' disabled selected>Selecione o modo de produção</option>";
                                                            }
                                                            foreach($lista as $modoProd){	
                                                                if($modoProd->getIdModoProd() == $modeloBlusa->getModoProducao()->getIdModoProd()){
                                                                    echo "<option selected value='{$modoProd->getIdModoProd()}'>{$modoProd->getNome()}</option>";
                                                                }
                                                                else{
                                                                    echo "<option value='{$modoProd->getIdModoProd()}'>{$modoProd->getNome()}</option>";
                                                                }

                                                            }
                                                        ?>	
                                                    </select>
                                                </div>
                                                <input class="btn btn-info" type="button" id="botaoImagem" value="Escolha a foto do Modelo de Blusa">
                                                <input class="btn btn-danger float-right" type="button" id="limparImagem" onclick="limpar()" value="Limpar imagem">
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="card card-chart">
                                                    <div class="card-header">
                                                        <h5 class="card-category">Imagem</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <?php 
                                                            $imagem = "imagens/modeloBlusas/". $modeloBlusa->getImagem();
                                                        ?>
                                                        <input id="imagem" name="imagem" type="file" accept="image/*" hidden
                                                        value="<?php echo $modeloBlusa->getImagem() ?>" <?php if($modeloBlusa->getImagem() <> ''){ echo "disabled"; }?>>
                                                        

                                                        <input type="hidden" name="caminho" id="caminho" value="<?php echo $modeloBlusa->getImagem() ?>" >
                              
                                                        <img src="<?php echo $imagem; ?>" id="imagemTagImg" alt="Imagem Modelo Blusa" height="100%" width="100%">
                                                    </div>
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
        <script type="text/javascript" src="../js/modeloBlusaFormulario.js"></script>
        <script type="text/javascript" src="../js/imagemForm.js"></script>
    </body>
</html>
