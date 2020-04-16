<?php	
	session_start();
    if(isset($_SESSION['USUARIO'])){
	}else{
		echo "<script>alert('É preciso estar logado para acessar essa página!');location.href='../formulario/Login.php';</script>";
    }
	require_once '../class/VendaDAO.php';
	require_once '../class/ClienteDAO.php';
	require_once '../class/BlusaDAO.php';
    require_once '../class/BlusaDAO.php';
    require_once '../class/GolaDAO.php';
    require_once '../class/ModoProdDAO.php';
    require_once '../class/TamanhoDAO.php';
    require_once '../class/TipoMalhaDAO.php';

	$venda = new Venda();

	if(isset($_GET["operacao"])){
		$operacao = $_GET["operacao"];
    }
    $resultado = '';
    if(isset($_GET["resultado"])){
		$resultado = $_GET["resultado"];
    }
    
    $titulo = "Cadastro de Venda";

	if(isset($_GET["idVenda"])){
		
        $idVenda = $_GET["idVenda"];

		$vendaDAO = new VendaDAO();
        $venda = $vendaDAO->buscarPorId($idVenda);
        
        $titulo = "Editando Venda";
	}		
?>

<!DOCTYPE html>
<html lang="pt">
    <head>
        <title>Venda</title>
        <?php 
            include_once("../blocosRepetidos/cssPadrao.php");  	
        ?>	
        <!-- Outros CSS-->
        <link type="text/css" rel="stylesheet" href="../css/padrao.css"/>
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
                                    <a class="btn btn-light btn-round float-right" href="../tabela/VendaTabela.php"><< Voltar</a>
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
                                    <form id="formVenda" action="../controlador/VendaControlador.php?operacao=salvar" method="post">
                                        <div id="agrupamento">
                                            <div class="row">
                                                    <div class="col-md-4 pr-1">
                                                        <div class="form-group">
                                                            <label for="idCliente">Cliente</label>	
                                                            <select id="idCliente" name="idCliente" class="form-control" required>						  
                                                                <?php
                                                                    $clienteDAO = new ClienteDAO();
                                                                    $lista = $clienteDAO->listar();

                                                                    if($venda->getCliente()->getIdCliente() == 0){
                                                                        echo "<option 
                                                                                value='' disabled selected>Selecione um cliente</option>";
                                                                    }

                                                                    foreach($lista as $cliente){	
                                                                        if($cliente->getIdCliente() == $venda->getCliente()->getIdCliente()){
                                                                            echo "<option selected 
                                                                                    value='{$cliente->getIdCliente()}'>{$cliente->getNome()}
                                                                                    </option>";
                                                                        }
                                                                        else{
                                                                            echo "<option 
                                                                                    value='{$cliente->getIdCliente()}'>{$cliente->getNome()}
                                                                                    </option>";
                                                                        }
                                                                        
                                                                    }
                                                                ?>	
                                                        
                                                            </select>			
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 pr-1">
                                                        <div class="form-group">
                                                            <label>Desconto %</label>
                                                            <input type="text" class="form-control" id="desconto" name="desconto" 
                                                            value="<?php echo $venda->getDesconto() ?>" placeholder="" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Valor Total</label>
                                                            <input type="hidden" name="idVenda" id="idVenda" value="<?php echo $venda->getIdVenda() ?>" >
                                                            <input type="text" class="form-control" id="valorTotal" name="valorTotal" 
                                                            value="<?php echo $venda->getValorTotal() ?>" placeholder="" required readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="tipo">Tipo</label>
                                                            <select class="form-control" id="tipo" name="tipo">
                                                                <option value="orcamento">Orçamento</option>
                                                                <option value="venda">Venda</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label for="observacao">Observação</label>
                                                            <input type="text" class="form-control" id="observacao" name="observacao" 
                                                            value="<?php echo $venda->getObservacao() ?>" placeholder="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                        <h5 class="mt-3">Adicionar blusa</h5>
                                        <div id="agrupamento">
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                                
                                                        <label for="idBlusa">Blusa Cadastradas</label>	
                                                        <select id="idBlusa" name="idBlusa" class="form-control">	
                                                        <option disabled selected value="">Selecione uma blusa</option>     					  
                                                            <?php
                                                                $blusaDAO = new BlusaDAO();
                                                                $lista = $blusaDAO->listar();

                                                                if($lista == null){
                                                                    echo "<option disabled selected value=''>Não há blusas cadastradas</option>";     
                                                                }
                                                                foreach($lista as $blusa){	
                                                                    $valor = $blusa->getIdBlusa()."/-/".$blusa->getNome()."/-/".$blusa->getValor();
                                                                    echo "<option 
                                                                            value='{$valor}'>{$blusa->getNome()}
                                                                            </option>";
                                                                }
                                                            ?>	
                                                        </select>	
                                                    </div>		
                                                </div>   
                                                <div class="col-md-3 ">
                                                    <div class="form-group">
                                                        <label for="qtd">Quantidade</label>
                                                        <input type="number" class="form-control" id="qtd" name="qtd" 
                                                        value="" placeholder="0">
                                                    </div>
                                                </div>  
                                                <div class="col-md-2 mt-2 ml-3" >
                                                    <a href="#" class="btn btn-success btn-round mt-3" id="addBlusa" 
                                                    onclick="addBlusa()"> Adicionar</a>
                                                </div>  
                                            </div>
                                        </div>

                                        <h5 class="mt-3">Criar blusa</h5>
                                        <div id="agrupamento">
                                            
                                            <div class="row">
                                            <div class="col-md-4 ">
                                                    <div class="form-group">
                                                        <label for="nmBlusa">Nome da blusa</label>
                                                        <input type="text" class="form-control" id="nmBlusa" name="nmBlusa">
                                                    </div>
                                                </div>  
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="idGola">Gola</label>	
                                                        <select id="idGola" name="idGola" class="form-control">	
                                                        <option disabled selected value="">Selecione uma gola</option>					  
                                                            <?php
                                                                $golaDAO = new GolaDAO();
                                                                $lista = $golaDAO->listar();
                                                                if($lista == null){
                                                                    echo "<option disabled selected value=''>Não há golas cadastradas</option>";     
                                                                }

                                                                foreach($lista as $gola){	
                                                                    echo "<option 
                                                                            value='{$gola->getIdGola()}'>{$gola->getNome()}
                                                                            </option>";
                                                                }
                                                            ?>	
                                                        </select>			
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="idMalha">Malha</label>	
                                                        <select id="idMalha" name="idMalha" class="form-control">
                                                        <option disabled selected value="">Selecione uma malha</option>						  
                                                            <?php
                                                                $malhaDAO = new TipoMalhaDAO();
                                                                $lista = $malhaDAO->listar();
                                                                if($lista == null){
                                                                    echo "<option disabled selected value=''>Não há malhas cadastradas</option>";     
                                                                }

                                                                foreach($lista as $malha){	
                                                                    echo "<option 
                                                                            value='{$malha->getIdMalha()}'>{$malha->getNome()}
                                                                            </option>";
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
                                                        <select id="idModoProd" name="idModoProd" class="form-control">
                                                        <option disabled selected value="">Selecione um modo de produção</option>						  
                                                            <?php
                                                                $modoProdDAO = new ModoProdDAO();
                                                                $lista = $modoProdDAO->listar();
                                                                if($lista == null){
                                                                    echo "<option disabled selected value=''>Não há modos de produção cadastrados</option>";     
                                                                }

                                                                foreach($lista as $modoProd){	
                                                                    echo "<option 
                                                                            value='{$modoProd->getIdModoProd()}'>{$modoProd->getNome()}
                                                                            </option>";
                                                                }
                                                            ?>	
                                                    
                                                        </select>			
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="idTamanho">Tamanho</label>	
                                                        <select id="idTamanho" name="idTamanho" class="form-control">	
                                                        <option disabled selected value="">Selecione um tamanho</option>					  
                                                            <?php
                                                                $tamanhoDAO = new TamanhoDAO();
                                                                $lista = $tamanhoDAO->listar();
                                                                if($lista == null){
                                                                    echo "<option disabled selected value=''>Não há tamanhos cadastrados</option>";     
                                                                }

                                                                foreach($lista as $tamanho){
                                                                    echo "<option 
                                                                            value='{$tamanho->getIdTamanho()}'>{$tamanho->getTamanho()}
                                                                            </option>";
                                                                    
                                                                }
                                                            ?>	
                                                    
                                                        </select>			
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Quantidade</label>
                                                        <input type="number" class="form-control" id="qtdBlusa" name="qtdBlusa">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Valor unitário</label>
                                                        <input type="number" class="form-control" id="valorBlusa" name="valorBlusa">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                <label for="comentario">Comentário</label>
                                                <textarea class="form-control" id="comentario" name="comentario" rows="3"></textarea>
                                            </div>
                                            <div class="col-md-2 mt-4 ml-3" >
                                                        <a href="#" class="btn btn-success btn-round mt-3" id="addBlusa" 
                                                        onclick="addBlusaCriada()"> Adicionar</a>
                                                    </div>  
                                            </div>
                                        </div>
                                            <div class="col-md-12">
                                                <table class="table mt-4" id="tabelaBlusas" style="display:none">
                                                    <thead>
                                                        <th width="45%">Blusa</th>
                                                        <th width="15%">Valor Uni.</th>
                                                        <th width="15%">Quantidade</th>
                                                        <th width="15%">Valor Total</th>
                                                        <th width="10%"></th>
                                                    </thead>
                                                    <tbody id="tabela">
                                                    </tbody>
                                                </table>
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
        <script type="text/javascript" src="../js/controleVendas.js"></script>
    </body>
</html>
