<?php	
	session_start();
    if(isset($_SESSION['USUARIO'])){
	}else{
		echo "<script>alert('É preciso estar logado para acessar essa página!');location.href='../formulario/Login.php';</script>";
    }
	require_once '../class/InsumoDAO.php';

	$insumo = new Insumo();

	if(isset($_GET["operacao"])){
		$operacao = $_GET["operacao"];
    }
    $resultado = '';
    if(isset($_GET["resultado"])){
		$resultado = $_GET["resultado"];
    }
    
    $titulo = "Cadastrando Insumo";

	if(isset($_GET["idInsumo"])){
		
        $idInsumo = $_GET["idInsumo"];

		$insumoDAO = new InsumoDAO();
        $insumo = $insumoDAO->buscarPorId($idInsumo);

        $nome = $insumo->getNome();
        
        $titulo = "Editando Insumo: $nome";
	}		
?>

<!DOCTYPE html>
<html lang="pt">
    <head>
        <title>Insumo</title>
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
                                    <a class="btn btn-light btn-round float-right" href="../tabela/InsumoTabela.php"><< Voltar</a>
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
                                    <form id="formInsumo" action="../controlador/InsumoControlador.php?operacao=salvar" method="post">
                                        <div class="row">
                                            <div class="col-md-6 pr-1">
                                                <div class="form-group">
                                                    <label>Nome</label>
                                                    <input type="hidden" name="idInsumo" id="idInsumo" value="<?php echo $insumo->getId() ?>" >
                                                    <input type="text" class="form-control" id="nome" name="nome" 
                                                    value="<?php echo $insumo->getNome() ?>" placeholder="Ex: Tinta azul claro" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tipo</label>
                                                    <input type="text" class="form-control" id="tipo" name="tipo" 
                                                    value="<?php echo $insumo->getTipo() ?>" placeholder="Ex: Tinta" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 pr-1">
                                                <div class="form-group">
                                                    <label>Quantidade Mínima</label>
                                                    <input type="text" class="form-control" id="qtdMin" name="qtdMin" 
                                                    value="<?php echo $insumo->getQtdMin() ?>" placeholder="Ex: 10" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Quantidade Estoque</label>
                                                    <input type="text" class="form-control" id="qtdEstoque" name="qtdEstoque" 
                                                    value="<?php echo $insumo->getQtdEstoque() ?>" placeholder="" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 pr-3">
                                                <div class="form-group">
                                                    <label>Descrição</label>
                                                    <input type="text" class="form-control" id="descricao" name="descricao" 
                                                    value="<?php echo $insumo->getDescricao() ?>" placeholder="Ex: tinta média qualidade" required>
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
        <!--<script type="text/javascript" src="../js/InsumoFormulario.js"></script>-->
    </body>
</html>
