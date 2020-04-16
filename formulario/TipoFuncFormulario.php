<?php	
	session_start();
    if(isset($_SESSION['USUARIO'])){
	}else{
		echo "<script>alert('É preciso estar logado para acessar essa página!');location.href='../formulario/Login.php';</script>";
    }
	require_once '../class/TipoFuncDAO.php';

	$tipoFunc = new TipoFunc();

	if(isset($_GET["operacao"])){
		$operacao = $_GET["operacao"];
    }
    $resultado = '';
    if(isset($_GET["resultado"])){
		$resultado = $_GET["resultado"];
    }
    
    $titulo = "Cadastrando Tipo de Funcionário";

	if(isset($_GET["idTipoFunc"])){
		
        $idTipoFunc = $_GET["idTipoFunc"];

		$tipoFuncDAO = new TipoFuncDAO();
        $tipoFunc = $tipoFuncDAO->buscarPorId($idTipoFunc);

        $descricao = $tipoFunc->getDescricao();
        
        $titulo = "Editando Tipo de funcionário: $descricao";
	}		
?>

<!DOCTYPE html>
<html lang="pt">
    <head>
        <title>Tipo Funcionário Formulário</title>
        <?php 
            include_once("../blocosRepetidos/cssPadrao.php");  	
        ?>	
        <!-- Outros CSS-->
        <link type="text/css" rel="stylesheet" href="../css/clienteTesteFormulario.css"/>
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
                                    <a class="btn btn-light btn-round float-right" href="../tabela/TipoFuncTabela.php"><< Voltar</a>
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
                                    <form id="formTipoFunc" action="../controlador/TipoFuncControlador.php?operacao=salvar" method="post">
                                        <div class="row">
                                            <div class="col-md-6 pr-1">
                                                <div class="form-group">
                                                    <label>Tipo de funcionário</label>
                                                    <input type="hidden" name="idTipoFunc" id="idTipoFunc" value="<?php echo $tipoFunc->getIdTipoFunc() ?>" >
                                                    <input type="text" class="form-control" id="descricao" name="descricao" 
                                                    value="<?php echo $tipoFunc->getDescricao() ?>" placeholder="Ex: Contratado" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 pl-1">
                                                <div class="form-group">
                                                    <label>Permissão</label>
                                                    <select class="form-control" id="exampleFormControlSelect1" id="permissao" name="permissao">
                                                    <?php
                                                        if($tipoFunc->getPermissao() == ''){
                                                            echo "<option 
                                                                value='' disabled selected>Selecione uma permissão</option>";
                                                                echo "<option value='ESCRITA'>Escrita</option>";
                                                                echo "<option value='LEITURA'>Visualização</option>";
                                                        } else{
                                                            if($tipoFunc->getPermissao() == 'LEITURA'){
                                                                echo "<option value='ESCRITA'>Escrita</option>";
                                                                echo "<option selected value='LEITURA'>Visualização</option>";
                                                            }else{
                                                                echo "<option selected value='ESCRITA'>Escrita</option>";
                                                                echo "<option value='LEITURA'>Visualização</option>";
                                                            }
                                                        }
                                                    ?>
                                                    </select>
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
        <script type="text/javascript" src="../js/tipoFuncFormulario.js"></script>
    </body>
</html>
