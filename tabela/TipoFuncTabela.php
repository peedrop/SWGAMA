<?php	
	session_start();
    if(isset($_SESSION['USUARIO'])){
	}else{
		echo "<script>alert('É preciso estar logado para acessar essa página!');location.href='../formulario/Login.php';</script>";
    }
	require_once '../class/TipoFuncDAO.php';	
?>
<!DOCTYPE html>
<html lang="pt">
    <head>
        <title>Tipo Funcionário Tabela</title>
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
                                    <a class="btn btn-success btn-round float-right" href="../formulario/TipoFuncFormulario.php">+ Novo Tipo Funcionário</a>
                                    <button type="button" class="btn btn-primary btn-round float-right mr-3" data-toggle="modal" data-target="#modalFiltro">Filtrar</button>	
                                    <?php
                                        if(isset($_GET["operacao"])=="filtrar"){
                                            echo "<a class='mx-2 btn btn-warning btn-round float-right mr-3' href='TipoFuncTabela.php'>Limpar filtro</a>";
                                        }
                                    ?>
                                </div>
                                <div class="card-header">
                                    <h5 class="title">Tipo Funcionário Tabela</h5>
                                </div>
                                <div class="card-body">
                                    <table id="tabela1" class="compact cell-border hover order-column 
                                    row-border stripe table table-striped" style="width:100%">
                                        <thead class="">
                                            <tr>
                                            <th width="10%">#</th>
                                            <th width="35%">Tipo de funcionário</th>
                                            <th width="35%">Permissão</th>
                                            <th width="13%">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                
                                                $tipoFuncDAO = new TipoFuncDAO();

                                                //pega lista com filtro ou sem filtro
                                                if(isset($_GET["operacao"])=="filtrar"){							
                                                    $descricao = "null";	
                                                    $permissao = "null";						
                                                    if(isset($_POST["descricao"])){
                                                        $descricao = $_POST["descricao"];
                                                    }
                                                    if(isset($_POST["permissao"])){
                                                        $permissao = $_POST["permissao"];
                                                    }
                                                    $lista = $tipoFuncDAO->filtrar($descricao, $permissao);
                                                }else{
                                                    $lista = $tipoFuncDAO->listar();
                                                }

                                                if ($lista == null){
                                                    echo"<td></td>";	
                                                    echo"<td>Não encontrado</td>";	
                                                    echo"<td>Não encontrado</td>";
                                                    echo"<td></td>";
                                                }

                                                foreach($lista as $tipoFunc){
                                                    $obj_json = json_encode(array(
                                                        "Visualizar Tipo de Funcionário",
                                                        "Id", $tipoFunc->getIdTipoFunc(), 
                                                        "Nome", $tipoFunc->getDescricao(),
                                                        "Permissão", $tipoFunc->getPermissao()
                                                    ));

                                                    echo"<tr>";			
                                                    echo"<td>{$tipoFunc->getIdTipoFunc()}</td>";	
                                                    echo"<td>{$tipoFunc->getDescricao()}</td>";	
                                                    if($tipoFunc->getPermissao() == 'ESCRITA')
                                                        echo "<td>Escrita</td>";
                                                    else 
                                                        echo "<td>Visualização</td>";
                                                    echo"<td><div class='btn-group btn-block' role='group'>";
                                                    echo"<a class='btn btn-secondary btn-simple btn-icon btn-sm mr-2'  
                                                    href='../formulario/Visualizar.php?objeto={$obj_json}&pagina={$_SERVER['PHP_SELF']}'><i class='material-icons'>search </i></a>";	
                                                    echo"<a class='btn btn-info btn-simple btn-icon btn-sm mr-2'
                                                    href='../formulario/TipoFuncFormulario.php?operacao=editar&idTipoFunc={$tipoFunc->getIdTipoFunc()}'><i class='material-icons'>
                                                        create</i></a>";
                                                    echo"<a class='btn btn-danger btn-simple btn-icon btn-sm'  
                                                    href='../controlador/TipoFuncControlador.php?operacao=excluir&idTipoFunc={$tipoFunc->getIdTipoFunc()}'>
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
				<form id="formFiltroTipoFunc" action="TipoFuncTabela.php?operacao=filtrar" 
					method="post">
				  <div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Filtro</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body">
					 <label for="descricao">Tipo de funcionário</label>  
					 <input class="form-control campo" name="descricao" 
						id="descricao" type="text">
				  </div>
                  <div class="modal-body">
					 <label for="permissao">Permissão</label>  
					 <select class="form-control" id="exampleFormControlSelect1" id="permissao" name="permissao">
                        <option selected disabled>Selecione uma permissão</option>
                        <option value="ESCRITA">Escrita</option>
                        <option value="LEITURA">Visualização</option>
                    </select>
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
