<?php	
	session_start();
    if(isset($_SESSION['USUARIO'])){
	}else{
		echo "<script>alert('É preciso estar logado para acessar essa página!');location.href='../formulario/Login.php';</script>";
    }
	require_once '../class/ArteDAO.php';	
?>
<!DOCTYPE html>
<html lang="pt">
    <head>
        <title>Arte Tabela</title>
        <?php 
            include_once("../blocosRepetidos/cssPadrao.php");  	
        ?>	
        <!-- Outros CSS-->
        <link rel="stylesheet" type="text/css" href="../css/padrao.css">
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
                                    <a class="btn btn-success btn-round float-right" href="../formulario/ArteFormulario.php">+ Nova Arte</a>
                                    <button type="button" class="btn btn-primary btn-round float-right mr-3" data-toggle="modal" data-target="#modalFiltro">Filtrar</button>	
                                    <?php
                                        if(isset($_GET["operacao"])=="filtrar"){
                                            echo "<a class='mx-2 btn btn-warning btn-round float-right mr-3' href='ArteTabela.php'>Limpar filtro</a>";
                                        }
                                    ?>
                                </div>
                                <div class="card-header">
                                    <h5 class="title">Arte Tabela</h5>
                                </div>
                                <div class="card-body">
                                    <table id="tabela1" class="compact cell-border hover order-column 
                                    row-border stripe table table-striped" style="width:100%">
                                        <thead class="">
                                            <tr>
                                            <th width="10%">#</th>
                                            <th width="35%">Imagem</th>
                                            <th width="15%">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                
                                                $arteDAO = new ArteDAO();

                                                $lista = $arteDAO->listar();

                                                if ($lista == null){
                                                    echo"<td></td>";	
                                                    echo"<td>Não encontrado</td>";	
                                                    echo"<td>Não encontrado</td>";
                                                    echo"<td></td>";
                                                }

                                                foreach($lista as $arte){
                                                    echo"<tr>";			
                                                    //idArte
                                                    echo"<td>{$arte->getIdArte()}</td>";	
                                                    //imagem	
                                                    echo"<td> <img class='circle' src='../{$arte->getImagem()}'> </td>";
                                                    echo"<td><div class='btn-group btn-block' role='group'>";
                                                    //botão visualizar - passando objeto json para visualizar
                                                    echo"<a class='btn btn-secondary btn-simple btn-icon btn-sm mr-2'  
                                                    href='../formulario/ArteVisualizacao.php?idArte={$arte->getIdArte()}'><i class='material-icons'>search </i></a>";	
                                                    //botão excluir
                                                    echo"<a class='btn btn-danger btn-simple btn-icon btn-sm'  
                                                    href='../controlador/ArteControlador.php?operacao=excluir&idArte={$arte->getIdArte()}'>
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
				<form id="formFiltroArte" action="tabela/ArteTabela.php?operacao=filtrar" 
					method="post">
				  <div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Filtro</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body">
					 <label for="imagem">Imagem</label>  
					 <input class="form-control campo" name="imagem" 
						id="imagem" type="text" value="" >
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
