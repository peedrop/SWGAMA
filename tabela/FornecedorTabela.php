<?php	
	session_start();
    if(isset($_SESSION['USUARIO'])){
	}else{
		echo "<script>alert('É preciso estar logado para acessar essa página!');location.href='../formulario/Login.php';</script>";
    }
	require_once '../class/FornecedorDAO.php';	
?>
<!DOCTYPE html>
<html lang="pt">
    <head>
        <title>Fornecedor Tabela</title>
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
                                    <a class="btn btn-success btn-round float-right" href="../formulario/FornecedorFormulario.php">+ Novo Fornecedor </a>
                                    <button type="button" class="btn btn-primary btn-round float-right mr-3" data-toggle="modal" data-target="#modalFiltro">Filtrar</button>	
                                    <?php
                                        if(isset($_GET["operacao"])=="filtrar"){
                                            echo "<a class='mx-2 btn btn-warning btn-round float-right mr-3' href='FornecedorTabela.php'>Limpar filtro</a>";
                                        }
                                    ?>
                                </div>
                                <div class="card-header">
                                    <h5 class="title">Fornecedor Tabela</h5>
                                </div>
                                <div class="card-body">
                                    <table id="tabela1" class="compact cell-border hover order-column 
                                    row-border stripe table table-striped" style="width:100%">
                                        <thead class="">
                                            <tr>
                                            <th width="10%">#</th>
                                            <th width="19%">Nome</th>
                                            <th width="18%">Telefone</th>
                                            <th width="19%">Email</th>
                                            <th width="19%">Endereco</th>
                                            <th width="15%">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                
                                                $fornecedorDAO = new FornecedorDAO();

                                                //pega lista com filtro ou sem filtro
                                                if(isset($_GET["operacao"])=="filtrar"){							
                                                    $nome = "";		
                                                    $telefone = "";		
                                                    $email = "";							
                                                    $endereco = "";							
                                                    if(isset($_POST["nome"])){
                                                        $nome = $_POST["nome"];
                                                    }
                                                    if(isset($_POST["telefone"])){
                                                        $telefone = $_POST["telefone"];
                                                    }
                                                    if(isset($_POST["email"])){
                                                        $email = $_POST["email"];
                                                    }
                                                    if(isset($_POST["endereco"])){
                                                        $endereco = $_POST["endereco"];
                                                    }
                                                    $lista = $fornecedorDAO->filtrar($nome, $telefone, $email, $endereco);
                                                }else{
                                                    $lista = $fornecedorDAO->listar();
                                                }

                                                if ($lista == null){
                                                    echo"<td></td>";	
                                                    echo"<td>Não encontrado</td>";	
                                                    echo"<td>Não encontrado</td>";
                                                    echo"<td>Não encontrado</td>";
                                                    echo"<td>Não encontrado</td>";
                                                    echo"<td></td>";
                                                }

                                                foreach($lista as $fornecedor){
                                                    /*
                                                        Transformar em objeto json para poder mandar via GET por URL 
                                                        Colocar na seguinte ordem:
                                                            *(Título conforme vai ser exibido no visualizar)
                                                            *(Nome do atributo conforme vai ser exibido no visualizar)
                                                            *(Valor do respectivo atributo)
                                                    */

                                                    $obj_json = json_encode(array(
                                                        "Visualizar Fornecedor ",
                                                        "Id", $fornecedor->getIdFornecedor(), 
                                                        "Nome", $fornecedor->getNome(),
                                                        "Telefone", $fornecedor->getTelefone(),
                                                        "Email", $fornecedor->getEmail(),
                                                        "Endereço", $fornecedor->getEndereco(),
                                                    ));


                                                    echo"<tr>";			
                                                    //idFornecedor
                                                    echo"<td>{$fornecedor->getIdFornecedor()}</td>";	
                                                    //nome	
                                                    echo"<td>{$fornecedor->getNome()}</td>";
                                                    //telefone	
                                                    echo"<td>{$fornecedor->getTelefone()}</td>";	
                                                    //email
                                                    echo"<td>{$fornecedor->getEmail()}</td>";	
                                                    //endereco
                                                    echo"<td>{$fornecedor->getEndereco()}</td>";	
                                                    echo"<td><div class='btn-group btn-block' role='group'>";
                                                    //botão visualizar - passando objeto json para visualizar
                                                    echo"<a class='btn btn-secondary btn-simple btn-icon btn-sm mr-2'  
                                                    href='../formulario/Visualizar.php?objeto={$obj_json}&pagina={$_SERVER['PHP_SELF']}'><i class='material-icons'>search </i></a>";	
                                                    //botão editar
                                                    echo"<a  class='btn btn-info btn-simple btn-icon btn-sm mr-2'
                                                    href='../formulario/FornecedorFormulario.php?operacao=editar&idFornecedor={$fornecedor->getIdFornecedor()}'><i class='material-icons'>
                                                        create</i></a>";
                                                    //botão excluir
                                                    echo"<a class='btn btn-danger btn-simple btn-icon btn-sm'  
                                                    href='../controlador/FornecedorControlador.php?operacao=excluir&idFornecedor={$fornecedor->getIdFornecedor()}'>
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
				<form id="formFiltroFornecedor" action="FornecedorTabela.php?operacao=filtrar" 
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
					 <label for="telefone">Telefone</label>  
					 <input class="form-control campo" name="telefone" 
						id="telefone" type="text" value="" >
				  </div>
                  <div class="modal-body">
					 <label for="email">Email</label>  
					 <input class="form-control campo" name="email" 
						id="email" type="text" value="" >
				  </div>
                  <div class="modal-body">
					 <label for="endereco">Endereço</label>  
					 <input class="form-control campo" name="endereco" 
						id="endereco" type="text" value="" >
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
