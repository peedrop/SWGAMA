<?php	
	session_start();
    if(isset($_SESSION['USUARIO'])){
	}else{
		echo "<script>alert('É preciso estar logado para acessar essa página!');location.href='../formulario/Login.php';</script>";
	}
	require_once '../class/BlusaDAO.php';
    require_once '../class/GolaDAO.php';
    require_once '../class/ModoProdDAO.php';
    require_once '../class/TamanhoDAO.php';
    require_once '../class/TipoMalhaDAO.php';
    
	$blusa = new Blusa();

	if(isset($_GET["operacao"])){
		$operacao = $_GET["operacao"];
    }
    $resultado = '';
    if(isset($_GET["resultado"])){
		$resultado = $_GET["resultado"];
    }
    
    $titulo = "Cadastrando Blusa";

	if(isset($_GET["idBlusa"])){
		
        $idBlusa = $_GET["idBlusa"];

		$blusaDAO = new BlusaDAO();
        $blusa = $blusaDAO->buscarPorId($idBlusa);

        $nome = $blusa->getNome();
        
        $titulo = "Editando Blusa: $nome";
	}		
?>

<!DOCTYPE html>
<html lang="pt">
    <head>
        <title>Blusa Formulário</title>
        <?php 
            include_once("../blocosRepetidos/cssPadrao.php");  	
        ?>	
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
                                    <a class="btn btn-light btn-round float-right" href="../tabela/BlusaTabela.php"><< Voltar</a>
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
                                    <form id="formBlusa" action="../controlador/BlusaControlador.php?operacao=salvar" method="post">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Nome</label>
                                                    <input type="hidden" name="idBlusa" id="idBlusa" value="<?php echo $blusa->getIdBlusa() ?>" >
                                                    <input type="text" class="form-control" id="nome" name="nome" 
                                                    value="<?php echo $blusa->getNome() ?>" placeholder="Ex: Blusa poliéster com gola polo" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="idMalha">Malha</label>	
                                                    <select id="idMalha" name="idMalha" class="form-control" required>						  
                                                        <?php
                                                            $malhaDAO = new TipoMalhaDAO();
                                                            $lista = $malhaDAO->listar();

                                                            if($blusa->getMalha()->getIdMalha() == 0){
                                                                echo "<option 
                                                                        value='' disabled selected>Selecione uma malha</option>";
                                                            }

                                                            foreach($lista as $malha){	
                                                                if($malha->getIdMalha() == $blusa->getMalha()->getIdMalha()){
                                                                    echo "<option selected 
                                                                            value='{$malha->getIdMalha()}'>{$malha->getNome()}
                                                                            </option>";
                                                                }
                                                                else{
                                                                    echo "<option 
                                                                            value='{$malha->getIdMalha()}'>{$malha->getNome()}
                                                                            </option>";
                                                                }
                                                                
                                                            }
                                                        ?>	
                                                
                                                    </select>			
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="idGola">Gola</label>	
                                                    <select id="idGola" name="idGola" class="form-control" required>						  
                                                        <?php
                                                            $golaDAO = new GolaDAO();
                                                            $lista = $golaDAO->listar();

                                                            if($blusa->getGola()->getIdGola() == 0){
                                                                echo "<option 
                                                                        value='' disabled selected>Selecione uma gola</option>";
                                                            }

                                                            foreach($lista as $gola){	
                                                                if($gola->getIdGola() == $blusa->getGola()->getIdGola()){
                                                                    echo "<option selected 
                                                                            value='{$gola->getIdGola()}'>{$gola->getNome()}
                                                                            </option>";
                                                                }
                                                                else{
                                                                    echo "<option 
                                                                            value='{$gola->getIdGola()}'>{$gola->getNome()}
                                                                            </option>";
                                                                }
                                                                
                                                            }
                                                        ?>	
                                                
                                                    </select>			
                                                </div>
                                            </div>
                                        </div>
                                      
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="idModoProd">Modo de produção</label>	
                                                    <select id="idModoProd" name="idModoProd" class="form-control" required>						  
                                                        <?php
                                                            $modoProdDAO = new ModoProdDAO();
                                                            $lista = $modoProdDAO->listar();

                                                            if($blusa->getModoProd()->getIdModoProd() == 0){
                                                                echo "<option 
                                                                        value='' disabled selected>Selecione um modo de produção</option>";
                                                            }

                                                            foreach($lista as $modoProd){	
                                                                if($modoProd->getIdModoProd() == $blusa->getModoProd()->getIdModoProd()){
                                                                    echo "<option selected 
                                                                            value='{$modoProd->getIdModoProd()}'>{$modoProd->getNome()}
                                                                            </option>";
                                                                }
                                                                else{
                                                                    echo "<option 
                                                                            value='{$modoProd->getIdModoProd()}'>{$modoProd->getNome()}
                                                                            </option>";
                                                                }
                                                                
                                                            }
                                                        ?>	
                                                
                                                    </select>			
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="idTamanho">Tamanho</label>	
                                                    <select id="idTamanho" name="idTamanho" class="form-control" required>						  
                                                        <?php
                                                            $tamanhoDAO = new TamanhoDAO();
                                                            $lista = $tamanhoDAO->listar();

                                                            if($blusa->getTamanho()->getIdTamanho() == 0){
                                                                echo "<option 
                                                                        value='' disabled selected>Selecione um tamanho</option>";
                                                            }

                                                            foreach($lista as $tamanho){	
                                                                if($tamanho->getIdTamanho() == $blusa->getTamanho()->getIdTamanho()){
                                                                    echo "<option selected 
                                                                            value='{$tamanho->getIdTamanho()}'>{$tamanho->getTamanho()}
                                                                            </option>";
                                                                }
                                                                else{
                                                                    echo "<option 
                                                                            value='{$tamanho->getIdTamanho()}'>{$tamanho->getTamanho()}
                                                                            </option>";
                                                                }
                                                                
                                                            }
                                                        ?>	
                                                
                                                    </select>			
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Quantidade em estoque</label>
                                                    <input type="number" class="form-control" id="qtdEstoque" name="qtdEstoque" 
                                                    value="<?php echo $blusa->getEstoque() ?>" placeholder="Ex: 20" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Valor</label>
                                                    <input type="number" class="form-control" id="valor" name="valor" 
                                                    value="<?php echo $blusa->getValor() ?>" placeholder="R$ 10,00" required>
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
        <script type="text/javascript" src=""></script>
    </body>
</html>
