<?php	
	session_start();
    if(isset($_SESSION['USUARIO'])){
	}else{
		echo "<script>alert('É preciso estar logado para acessar essa página!');location.href='../formulario/Login.php';</script>";
    }
	require_once '../class/EntradaDespesaDAO.php';	
?>
<!DOCTYPE html>
<html lang="pt">
    <head>
        <title>Entrada de Despesa Tabela</title>
        <?php 
            include_once("../blocosRepetidos/cssPadrao.php");  	
        ?>	
        <!-- Outros CSS-->
        <link rel="stylesheet" type="text/css" href="">
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
                                <div class="col-md-5 float-right">
                                    <a class="btn btn-success btn-round float-right" href="../formulario/EntradaDespesaFormulario.php">+ Nova Entrada de Despesa</a>
                                    <button type="button" class="btn btn-primary btn-round float-right mr-3" data-toggle="modal" data-target="#modalFiltro">Filtrar</button>	
                                    <?php
                                        if(isset($_GET["operacao"])=="filtrar"){
                                            echo "<a class='mx-2 btn btn-warning btn-round float-right mr-3' href='EntradaDespesaTabela.php'>Limpar filtro</a>";
                                        }
                                    ?>
                                </div>
                                <div class="card-header">
                                    <h5 class="title">Entrada de Despesa Tabela</h5>
                                </div>
                                <div class="card-body">
                                    <table id="tabela1" class="compact cell-border hover order-column 
                                    row-border stripe table table-striped" style="width:100%">
                                        <thead class="">
                                            <tr>
                                            <th width="5%">#</th>
                                            <th width="15%">Fornecedor</th>
                                            <th width="15%">Insumo</th>
                                            <th width="15%">Despesa</th>
                                            <th width="15%">Valor</th>
                                            <th width="10%">Data de Vencimento</th>
                                            <th width="10%">Data</th>
                                            <th width="15%">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                
                                                $entradaDespesaDAO = new EntradaDespesaDAO();

                                                if(isset($_GET["operacao"])=="filtrar"){							
                                                    $nome = '';
                                                    $idGola = '';
                                                    $idMalha = '';
                                                    $idModoProd = '';
                                                    $idTamanho = '';
                                                    $valor = '';
                     
                                                    if(isset($_POST["nome"])){
                                                        $nome = $_POST["nome"];
                                                    }
                                                    if(isset($_POST["idGola"])){
                                                        $idGola = $_POST["idGola"];
                                                    }
                                                    if(isset($_POST["idMalha"])){
                                                        $idMalha = $_POST["idMalha"];
                                                    }
                                                    if(isset($_POST["idModoProd"])){
                                                        $idModoProd = $_POST["idModoProd"];
                                                    }
                                                    if(isset($_POST["idTamanho"])){
                                                        $idTamanho = $_POST["idTamanho"];
                                                    }
                                                    if(isset($_POST["valor"])){
                                                        $valor = $_POST["valor"];
                                                    }
                                                    $lista = $entradaDespesaDAO->filtrar($nome, $idGola, $idMalha, $idModoProd, $idTamanho, $valor);
                                                }else{
                                                    $lista = $entradaDespesaDAO->listar();
                                                }

                                                if ($lista == null){
                                                    echo"<td></td>";	
                                                    echo"<td>Não encontrado</td>";	
                                                    echo"<td>Não encontrado</td>";
                                                    echo"<td>Não encontrado</td>";
                                                    echo"<td>Não encontrado</td>";	
                                                    echo"<td>Não encontrado</td>";	
                                                    echo"<td>Não encontrado</td>";	
                                                    echo"<td></td>";
                                                }

                                                foreach($lista as $entradaDespesa){
                                                    
                                                    $obj_json = json_encode(array(
                                                        "Visualizar EntradaDespesa",
                                                        "Id", $entradaDespesa->getIdEntDespesa(), 
                                                        "Fornecedor", $entradaDespesa->getFornecedor()->getNome(),
                                                        "Insumo", $entradaDespesa->getInsumo()->getNome(),
                                                        "Despesa", $entradaDespesa->getDespesa()->getNome(),

                                                        "Valor", $entradaDespesa->getValor(),
                                                        "Data de Vencimento", $entradaDespesa->getDataVencimento(),
                                                        "Data", $entradaDespesa->getData()
                                                    ));


                                                    echo"<tr>";			
                                                    echo"<td>{$entradaDespesa->getIdEntDespesa()}</td>";	
                                                    echo"<td>{$entradaDespesa->getFornecedor()->getNome()}</td>";	
                                                    echo"<td>{$entradaDespesa->getInsumo()->getNome()}</td>";	
                                                    echo"<td>{$entradaDespesa->getDespesa()->getNome()}</td>";
                                                    echo"<td>{$entradaDespesa->getValor()}</td>";	
                                                    echo"<td>".date("d/m/Y", strtotime($entradaDespesa->getDataVencimento()))."</td>";	
                                                    echo"<td>".date("d/m/Y", strtotime($entradaDespesa->getData()))."</td>";
                                                    echo"<td><div class='btn-group btn-block' role='group'>";
                                                    //botão visualizar - passando objeto json para visualizar
                                                    echo"<a class='btn btn-secondary btn-simple btn-icon btn-sm mr-2'  
                                                    href='../formulario/Visualizar.php?objeto={$obj_json}&pagina={$_SERVER['PHP_SELF']}'><i class='material-icons'>search </i></a>";	
                                                    //botão editar
                                                    echo"<a  class='btn btn-info btn-simple btn-icon btn-sm mr-2'
                                                    href='../formulario/EntradaDespesaFormulario.php?operacao=editar&idEntradaDespesa={$entradaDespesa->getIdEntDespesa()}'><i class='material-icons'>
                                                        create</i></a>";
                                                    //botão excluir
                                                    echo"<a class='btn btn-danger btn-simple btn-icon btn-sm'  
                                                    href='../controlador/EntradaDespesaControlador.php?operacao=excluir&idEntradaDespesa={$entradaDespesa->getIdEntDespesa()}'>
                                                        <i class='material-icons'>
                                                            delete</i></a>";
                                                    echo"</td></div";								
                                                    echo"</tr>";							
                                                }	
                                                
                                            ?>

                                        </tbody>
                                    </table>
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
        <!-- Modal do filtro -->
        <div class="modal fade" id="modalFiltro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		    <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="formFiltroEntradaDespesa" action="EntradaDespesaTabela.php?operacao=filtrar" 
                        method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Filtro</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label for="nome">Nome</label>  
                        <input class="form-control campo" name="nome" 
                            id="nome" type="text" value="" >
                    </div>
                    <div class="modal-body">
                        <label for="idGola">Gola</label>  
                        <select id="idGola" name="idGola" class="form-control">						  
                            <?php
                                $golaDAO = new GolaDAO();
                                $lista = $golaDAO->listar();

                                echo "<option value='0' disabled selected>Selecione uma gola</option>";

                                foreach($lista as $gola){	
                                    echo "<option value='{$gola->getIdGola()}'>{$gola->getNome()}</option>";
                                }
                            ?>	
                        </select>
                    </div>
                    <div class="modal-body">
                        <label for="idMalha">Malha</label>  
                        <select id="idMalha" name="idMalha" class="form-control">						  
                            <?php
                                $malhaDAO = new TipoMalhaDAO();
                                $lista = $malhaDAO->listar();

                                echo "<option value='0' disabled selected>Selecione uma malha</option>";

                                foreach($lista as $malha){	
                                    echo "<option value='{$malha->getIdMalha()}'>{$malha->getNome()}</option>";
                                }
                            ?>	
                        </select>
                    </div>
                    <div class="modal-body">
                        <label for="idModoProd">Modo de produção</label>  
                        <select id="idModoProd" name="idModoProd" class="form-control">						  
                            <?php
                                $modoProdDAO = new ModoProdDAO();
                                $lista = $modoProdDAO->listar();

                                echo "<option value='0' disabled selected>Selecione um modo de produção</option>";

                                foreach($lista as $modoProd){	
                                    echo "<option value='{$modoProd->getIdModoProd()}'>{$modoProd->getNome()}</option>";
                                }
                            ?>	
                        </select>
                    </div>
                    <div class="modal-body">
                        <label for="idTamanho">Tamanho</label>  
                        <select id="idTamanho" name="idTamanho" class="form-control">						  
                            <?php
                                $tamanhoDAO = new TamanhoDAO();
                                $lista = $tamanhoDAO->listar();

                                echo "<option value='0' disabled selected>Selecione um tamanho</option>";

                                foreach($lista as $tamanho){	
                                    echo "<option value='{$tamanho->getIdTamanho()}'>{$tamanho->getTamanho()}</option>";
                                }
                            ?>	
                        </select>
                    </div>
                    <div class="modal-body">
                        <label for="idTamanho">Estoque</label>  
                        <input class="form-control campo" name="idTamanho" 
                            id="idTamanho" type="number" value="" >
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary btn-round" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary btn-round">Aplicar</button>
                    </div>
                    </form>
                </div>
		    </div>
		</div>
        <?php 
            include_once("../blocosRepetidos/jsPadrao.php");  	
        ?>
        <!-- Outros JS-->
        <script type="text/javascript" src=""></script>
    </body>
</html>
