<?php	
	session_start();
    if(isset($_SESSION['USUARIO'])){
	}else{
		echo "<script>alert('É preciso estar logado para acessar essa página!');location.href='../formulario/Login.php';</script>";
    }
    require_once '../class/EstoqueDAO.php';	
    require_once '../class/BlusaDAO.php';	
    require_once '../class/BlusaEstoqueDAO.php';	
?>
<!DOCTYPE html>
<html lang="pt">
    <head>
        <title>Entrada de Estoque Tabela</title>
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
                                    <a class="btn btn-success btn-round float-right" href="../formulario/EstoqueFormulario.php">+ Nova entrada de estoque </a>
                                    <button type="button" class="btn btn-primary btn-round float-right mr-3" data-toggle="modal" data-target="#modalFiltro">Filtrar</button>	
                                    <?php
                                        if(isset($_GET["operacao"])=="filtrar"){
                                            echo "<a class='mx-2 btn btn-warning btn-round float-right mr-3' href='EstoqueTabela.php'>Limpar filtro</a>";
                                        }
                                    ?>
                                </div>
                                <div class="card-header">
                                    <h5 class="title">Entrada de Estoque Tabela</h5>
                                </div>
                                <div class="card-body">
                                    <table id="tabela1" class="compact cell-border hover order-column 
                                    row-border stripe table table-striped" style="width:100%">
                                        <thead class="">
                                            <tr>
                                            <th width="10%">#</th>
                                            <th width="40%">Data</th>
                                            <th width="35%">Tipo</th>
                                            <th width="15%">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                
                                                $estoqueDAO = new EstoqueDAO();

                                                if(isset($_GET["operacao"])=="filtrar"){							
                                                    $data = "";		
                                                    if(isset($_POST["data"])){
                                                        $data = $_POST["data"];
                                                    }

                                                    $lista = $estoqueDAO->filtrar($data);
                                                }else{
                                                    $lista = $estoqueDAO->listar();
                                                }

                                                if ($lista == null){
                                                    echo"<td></td>";	
                                                    echo"<td>Não encontrado</td>";	
                                                    echo"<td>Não encontrado</td>";
                                                    echo"<td></td>";
                                                }

                                                foreach($lista as $estoque){

                                                    echo"<tr>";			
                                                    echo"<td>{$estoque->getIdEstoque()}</td>";
                                                    echo"<td>".date("d/m/Y", strtotime($estoque->getData()))."</td>";	
                                                    echo"<td>{$estoque->getTipo()}</td>";	
                                                    echo"<td><div class='btn-group btn-block' role='group'>";
                                                    echo"<a class='btn btn-secondary btn-simple btn-icon btn-sm mr-2'><i class='material-icons'>search </i></a>";	
                                                    echo"<a  class='btn btn-info btn-simple btn-icon btn-sm mr-2'
                                                    href='../formulario/EstoqueFormulario.php?operacao=editar&idEstoque={$estoque->getIdEstoque()}'><i class='material-icons'>
                                                        create</i></a>";
                                                    echo"<a class='btn btn-danger btn-simple btn-icon btn-sm'  
                                                    href='../controlador/EstoqueControlador.php?operacao=excluir&idEstoque={$estoque->getIdEstoque()}'>
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
				<form id="formFiltroTamanho" action="TamanhoTabela.php?operacao=filtrar" 
					method="post">
				  <div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Filtro</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body">
					 <label for="tamanho">Tamanho</label>  
					 <input class="form-control campo" name="tamanho" 
						id="tamanho" type="text" value="" >
				  </div>
                  <div class="modal-body">
					 <label for="altura">Altura</label>  
					 <input class="form-control campo" name="altura" 
						id="altura" type="text" value="" >
				  </div>
                  <div class="modal-body">
					 <label for="altura">Largura</label>  
					 <input class="form-control campo" name="largura" 
						id="largura" type="text" value="" >
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
