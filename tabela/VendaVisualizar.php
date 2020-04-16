<?php	
	session_start();
    if(isset($_SESSION['USUARIO'])){
	}else{
		echo "<script>alert('É preciso estar logado para acessar essa página!');location.href='../formulario/Login.php';</script>";
    }
    require_once '../class/VendaDAO.php';	
    require_once '../class/BlusaVendaDAO.php';	

    $vendaDAO = new VendaDAO();
    $venda = new Venda();
    
	if(isset($_GET["idVenda"])){
        $venda = $vendaDAO->buscarPorId($_GET["idVenda"]);
    }else{
        echo "<script>alert('Blusa não encontrada!');location.href='../tabela/VendaTabela.php';</script>"; 
    }
?>

<!DOCTYPE html>
<html lang="pt">
    <head>
        <title><?php echo $titulo ?></title>
        <?php 
            include_once("../blocosRepetidos/cssPadrao.php");  	
        ?>	
        <!-- Outros CSS-->
        <style>
            @media (min-width: 768px) {
                .table-condensed > thead > tr > th,
                .table-condensed > tbody > tr > th,
                .table-condensed > tfoot > tr > th,
                .table-condensed > thead > tr > td,
                .table-condensed > tbody > tr > td,
                .table-condensed > tfoot > tr > td {
                    padding: 5px;
                }
            }
        </style>
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
                                    <h5 class="title">Visualizando detalhes da Venda</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm table-condensed table-hover table-bordered table-striped">
                                        <tbody>
                                            <tr>
                                                <td>Id</td>
                                                <td><?php echo $venda->getIdVenda() ?></td>
                                            </tr>
                                            <tr>
                                                <td>Data</td>
                                                <td><?php echo $venda->getDataHora() ?></td>
                                            </tr>
                                            <tr>
                                                <td>Valor Total</td>
                                                <td><?php echo $venda->getValorTotal() ?></td>
                                            </tr>
                                            <tr>
                                                <td>Desconto</td>
                                                <td><?php echo $venda->getDesconto() ?></td>
                                            </tr>
                                            <tr>
                                                <td>Observação</td>
                                                <td><?php echo $venda->getObservacao() ?></td>
                                            </tr>
                                            <tr>
                                                <td>Tipo</td>
                                                <td><?php echo $venda->getTipo() ?></td>
                                            </tr>
                                            <tr>
                                                <td>Cliente</td>
                                                <td><?php echo $venda->getCliente()->getNome() ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <h5 class="title">Blusas</h5>
                                    <table class="table table-sm table-condensed table-hover table-bordered table-striped">
                                        <tbody>
                                            <tr>
                                                <td><b>Nome</td>
                                                <td><b>Valor</td>
                                                <td><b>Quantidade</td>
                                                <td><b>Observação</td>
                                            </tr>
                                            <?php
                                                $blusaVendaDAO = new BlusaVendaDAO();
                                                $lista = $blusaVendaDAO->listarPorVenda($venda->getIdVenda());

                                                foreach($lista as $blusaVenda){
                                                    echo"<tr>";	
                                                    echo"<td>{$blusaVenda->getBlusa()->getNome()}</td>";
                                                    echo"<td>{$blusaVenda->getValor()}</td>";
                                                    echo"<td>{$blusaVenda->getQtd()}</td>";
                                                    echo"<td>{$blusaVenda->getObservacao()}</td>";
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
        <?php 
            include_once("../blocosRepetidos/jsPadrao.php");  	
        ?>
        <!-- Outros JS-->
    </body>
</html>
