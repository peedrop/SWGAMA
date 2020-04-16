<?php	
	session_start();
    if(isset($_SESSION['USUARIO'])){
	}else{
		echo "<script>alert('É preciso estar logado para acessar essa página!');location.href='../formulario/Login.php';</script>";
    }
    
	require_once '../class/EntradaDespesaDAO.php';
    require_once '../class/DespesaDAO.php';
    require_once '../class/FornecedorDAO.php';
    require_once '../class/InsumoDAO.php';
    
	$entradaDespesa = new EntradaDespesa();

	if(isset($_GET["operacao"])){
		$operacao = $_GET["operacao"];
    }
    $resultado = '';
    if(isset($_GET["resultado"])){
		$resultado = $_GET["resultado"];
    }
    
    $titulo = "Cadastrando Entrada de Despesa";

	if(isset($_GET["idEntradaDespesa"])){
		
        $idEntradaDespesa = $_GET["idEntradaDespesa"];

		$entradaDespesaDAO = new EntradaDespesaDAO();
        $entradaDespesa = $entradaDespesaDAO->buscarPorId($idEntradaDespesa);

        $nome = $entradaDespesa->getIdEntDespesa();
        
        $titulo = "Editando Entrada de Despesa: $nome";
	}		
?>

<!DOCTYPE html>
<html lang="pt">
    <head>
        <title>Entrada de Despesa Formulário</title>
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
                                    <a class="btn btn-light btn-round float-right" href="../tabela/EntradaDespesaTabela.php"><< Voltar</a>
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
                                    <form id="formEntradaDespesa" action="../controlador/EntradaDespesaControlador.php?operacao=salvar" method="post">
                                        <div class="row">


                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="idFornecedor">Fornecedor</label>
                                                    <input type="hidden" name="idEntradaDespesa" id="idEntradaDespesa" value="<?php echo $entradaDespesa->getIdEntDespesa() ?>" >	
                                                    <select id="idFornecedor" name="idFornecedor" class="form-control">						  
                                                        <?php
                                                            $fornecedorDAO = new FornecedorDAO();
                                                            $lista = $fornecedorDAO->listar();

                                                            if($entradaDespesa->getFornecedor()->getIdFornecedor() == 0){
                                                                echo "<option 
                                                                        value='' disabled selected>Selecione um fornecedor</option>";
                                                            }

                                                            foreach($lista as $fornecedor){	
                                                                if($fornecedor->getIdFornecedor() == $entradaDespesa->getFornecedor()->getIdFornecedor()){
                                                                    echo "<option selected 
                                                                            value='{$fornecedor->getIdFornecedor()}'>{$fornecedor->getNome()}
                                                                            </option>";
                                                                }
                                                                else{
                                                                    echo "<option 
                                                                            value='{$fornecedor->getIdFornecedor()}'>{$fornecedor->getNome()}
                                                                            </option>";
                                                                }
                                                                
                                                            }
                                                        ?>	
                                                
                                                    </select>			
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="idInsumo">Insumo</label>	
                                                    <select id="idInsumo" name="idInsumo" class="form-control">						  
                                                        <?php
                                                            $insumoDAO = new InsumoDAO();
                                                            $lista = $insumoDAO->listar();

                                                            if($entradaDespesa->getInsumo()->getId() == 0){
                                                                echo "<option 
                                                                        value='' disabled selected>Selecione um insumo</option>";
                                                            }

                                                            foreach($lista as $insumo){	
                                                                if($insumo->getId() == $entradaDespesa->getInsumo()->getId()){
                                                                    echo "<option selected 
                                                                            value='{$insumo->getId()}'>{$insumo->getNome()}
                                                                            </option>";
                                                                }
                                                                else{
                                                                    echo "<option 
                                                                            value='{$insumo->getId()}'>{$insumo->getNome()}
                                                                            </option>";
                                                                }
                                                                
                                                            }
                                                        ?>	
                                                
                                                    </select>			
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="idDespesa">Despesa</label>	
                                                    <select id="idDespesa" name="idDespesa" class="form-control">						  
                                                        <?php
                                                            $despesaDAO = new DespesaDAO();
                                                            $lista = $despesaDAO->listar();

                                                            if($entradaDespesa->getDespesa()->getIdDespesa() == 0){
                                                                echo "<option 
                                                                        value='' disabled selected>Selecione uma despesa</option>";
                                                            }

                                                            foreach($lista as $despesa){	
                                                                if($despesa->getIdDespesa() == $entradaDespesa->getDespesa()->getIdDespesa()){
                                                                    echo "<option selected 
                                                                            value='{$despesa->getIdDespesa()}'>{$despesa->getNome()}
                                                                            </option>";
                                                                }
                                                                else{
                                                                    echo "<option 
                                                                            value='{$despesa->getIdDespesa()}'>{$despesa->getNome()}
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
                                                    <label>Valor</label>
                                                    <input type="text" class="form-control" id="valor" name="valor" 
                                                    value="<?php echo $entradaDespesa->getValor() ?>" placeholder="Ex: 50,00" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Data de Vencimento</label>
                                                    <input type="date" class="form-control" id="dataVencimento" name="dataVencimento" 
                                                    value="<?php echo $entradaDespesa->getDataVencimento() ?>" placeholder="" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Data</label>
                                                    <input type="date" class="form-control" id="data" name="data" 
                                                    value="<?php echo $entradaDespesa->getData() ?>" placeholder="" readonly>
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
