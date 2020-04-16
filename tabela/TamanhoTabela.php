<?php	
	session_start();
    if(isset($_SESSION['USUARIO'])){
	}else{
		echo "<script>alert('É preciso estar logado para acessar essa página!');location.href='../formulario/Login.php';</script>";
    }
	require_once '../class/TamanhoDAO.php';	
?>
<!DOCTYPE html>
<html lang="pt">
    <head>
        <title>Tamanho Tabela</title>
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
                                    <a class="btn btn-success btn-round float-right" href="../formulario/TamanhoFormulario.php">+ Novo Tamanho </a>
                                    <button type="button" class="btn btn-primary btn-round float-right mr-3" data-toggle="modal" data-target="#modalFiltro">Filtrar</button>	
                                    <?php
                                        if(isset($_GET["operacao"])=="filtrar"){
                                            echo "<a class='mx-2 btn btn-warning btn-round float-right mr-3' href='TamanhoTabela.php'>Limpar filtro</a>";
                                        }
                                    ?>
                                </div>
                                <div class="card-header">
                                    <h5 class="title">Tamanho Tabela</h5>
                                </div>
                                <div class="card-body">
                                    <table id="tabela1" class="compact cell-border hover order-column 
                                    row-border stripe table table-striped" style="width:100%">
                                        <thead class="">
                                            <tr>
                                            <th width="10%">#</th>
                                            <th width="25%">Tamanho</th>
                                            <th width="25%">Altura</th>
                                            <th width="25%">Largura</th>
                                            <th width="15%">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                
                                                $tamanhoDAO = new TamanhoDAO();

                                                //pega lista com filtro ou sem filtro
                                                if(isset($_GET["operacao"])=="filtrar"){							
                                                    $tamanho = "";		
                                                    $altura = 0;
                                                    $largura = 0;							
                                                    if(isset($_POST["tamanho"])){
                                                        $tamanho = $_POST["tamanho"];
                                                    }
                                                    if(isset($_POST["altura"])){
                                                        $altura = $_POST["altura"];
                                                    }
                                                    if(isset($_POST["largura"])){
                                                        $largura = $_POST["largura"];
                                                    }
                                                    $lista = $tamanhoDAO->filtrar($tamanho, $altura, $largura);
                                                }else{
                                                    $lista = $tamanhoDAO->listar();
                                                }

                                                if ($lista == null){
                                                    echo"<td></td>";	
                                                    echo"<td>Não encontrado</td>";	
                                                    echo"<td>Não encontrado</td>";
                                                    echo"<td></td>";
                                                }

                                                foreach($lista as $tamanho){
                                                    /*
                                                        Transformar em objeto json para poder mandar via GET por URL 
                                                        Colocar na seguinte ordem:
                                                            *(Título conforme vai ser exibido no visualizar)
                                                            *(Tamanho do atributo conforme vai ser exibido no visualizar)
                                                            *(Valor do respectivo atributo)
                                                    */

                                                    $altura = number_format($tamanho->getAltura(), 2, ',', '.') . ' m';
                                                    $largura = number_format($tamanho->getLargura(), 2, ',', '.') . ' m' ;

                                                    $obj_json = json_encode(array(
                                                        "Visualizar Tamanho ",
                                                        "Id", $tamanho->getIdTamanho(), 
                                                        "Tamanho", $tamanho->getTamanho(),
                                                        "Altura", $altura,
                                                        "Largura", $largura,
                                                    ));


                                                    echo"<tr>";			
                                                    //idTamanho
                                                    echo"<td>{$tamanho->getIdTamanho()}</td>";	
                                                    //tamanho	
                                                    echo"<td>{$tamanho->getTamanho()}</td>";	
                                                    //altura
                                                    echo"<td>{$altura}</td>";	
                                                    //largura
                                                    echo"<td>{$largura}</td>";	
                                                    echo"<td><div class='btn-group btn-block' role='group'>";
                                                    //botão visualizar - passando objeto json para visualizar
                                                    echo"<a class='btn btn-secondary btn-simple btn-icon btn-sm mr-2'  
                                                    href='../formulario/Visualizar.php?objeto={$obj_json}&pagina={$_SERVER['PHP_SELF']}'><i class='material-icons'>search </i></a>";	
                                                    //botão editar
                                                    echo"<a  class='btn btn-info btn-simple btn-icon btn-sm mr-2'
                                                    href='../formulario/TamanhoFormulario.php?operacao=editar&idTamanho={$tamanho->getIdTamanho()}'><i class='material-icons'>
                                                        create</i></a>";
                                                    //botão excluir
                                                    echo"<a class='btn btn-danger btn-simple btn-icon btn-sm'  
                                                    href='../controlador/TamanhoControlador.php?operacao=excluir&idTamanho={$tamanho->getIdTamanho()}'>
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
