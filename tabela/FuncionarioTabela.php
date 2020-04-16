<?php	
	session_start();
    if(isset($_SESSION['USUARIO'])){
	}else{
		echo "<script>alert('É preciso estar logado para acessar essa página!');location.href='../formulario/Login.php';</script>";
    }
	require_once '../class/FuncionarioDAO.php';	
?>
<!DOCTYPE html>
<html lang="pt">
    <head>
        <title>Funcionário Tabela</title>
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
                                    <a class="btn btn-success btn-round float-right" href="../formulario/FuncionarioFormulario.php">+ Novo Funcionário</a>
                                    <button type="button" class="btn btn-primary btn-round float-right mr-3" data-toggle="modal" data-target="#modalFiltro">Filtrar</button>	
                                    <?php
                                        if(isset($_GET["operacao"])=="filtrar"){
                                            echo "<a class='mx-2 btn btn-warning btn-round float-right mr-3' href='FuncionarioTabela.php'>Limpar filtro</a>";
                                        }
                                    ?>
                                </div>
                                <div class="card-header">
                                    <h5 class="title">Funcionário Tabela</h5>
                                </div>
                                <div class="card-body">
                                    <table id="tabela1" class="compact cell-border hover order-column 
                                    row-border stripe table table-striped" style="width:100%">
                                        <thead class="">
                                            <tr>
                                            <th width="25%">Nome</th>
                                            <th width="20%">Telefone</th>
                                            <th width="25%">Tipo</th>
                                            <th width="15%">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                
                                                $funcionarioDAO = new FuncionarioDAO();

                                                //pega lista com filtro ou sem filtro
                                                if(isset($_GET["operacao"])=="filtrar"){							
                                                    $nome = "null";	
                                                    $tipo = "null";						
                                                    if(isset($_POST["nome"])){
                                                        $nome = $_POST["nome"];
                                                    }
                                                    if(isset($_POST["tipo"])){
                                                        $tipo = $_POST["tipo"];
                                                    }
                                                    $lista = $funcionarioDAO->filtrar($nome, $tipo);
                                                }else{
                                                    $lista = $funcionarioDAO->listar();
                                                }

                                                if ($lista == null){
                                                    echo"<td></td>";	
                                                    echo"<td>Não encontrado</td>";	
                                                    echo"<td>Não encontrado</td>";
                                                    echo"<td></td>";
                                                }

                                                foreach($lista as $funcionario){

                                                    if($funcionario->getTipo() != "VOLUNTARIO"){
                                                        $obj_json = json_encode(array(
                                                            "Visualizar Funcionário",
                                                            "Id", $funcionario->getIdFuncionario(), 
                                                            "Nome", $funcionario->getNome(),
                                                            "Data de Nascimento", date("d/m/Y", strtotime($funcionario->getDataNascimento())),
                                                            "Telefone", $funcionario->getTelefone(),
                                                            "Cpf", $funcionario->getCpf(),
                                                            "Sexo", $funcionario->getSexo(),
                                                            "Email", $funcionario->getEmail(),
                                                            "Tipo de funcionário", $funcionario->getTipo(),
                                                            "Salário", $funcionario->getSalario(),
                                                            "Data de pagamento", $funcionario->getDataPag(),
                                                            "Endereço", $funcionario->getEndereco()
                                                        ));
                                                    } else{
                                                        $obj_json = json_encode(array(
                                                            "Visualizar Funcionário",
                                                            "Id", $funcionario->getIdFuncionario(), 
                                                            "Nome", $funcionario->getNome(),
                                                            "Data de Nascimento", date("d/m/Y", strtotime($funcionario->getDataNascimento())),
                                                            "Telefone", $funcionario->getTelefone(),
                                                            "Cpf", $funcionario->getCpf(),
                                                            "Sexo", $funcionario->getSexo(),
                                                            "Email", $funcionario->getEmail(),
                                                            "Tipo de funcionário", $funcionario->getTipo(),
                                                            "Endereço", $funcionario->getEndereco()
                                                        ));
                                                    }
                                                    

                                                    echo"<tr>";		
                                                    echo"<td>{$funcionario->getNome()}</td>";	
                                                    echo"<td>{$funcionario->getTelefone()}</td>";	
                                                    echo"<td>{$funcionario->getTipo()}</td>";	
                                                    echo"<td><div class='btn-group btn-block' role='group'>";
                                                    echo"<a class='btn btn-secondary btn-simple btn-icon btn-sm mr-2'  
                                                    href='../formulario/Visualizar.php?objeto={$obj_json}&pagina={$_SERVER['PHP_SELF']}'><i class='material-icons'>search </i></a>";
                                                    echo"<a class='btn btn-info btn-simple btn-icon btn-sm mr-2'
                                                    href='../formulario/FuncionarioFormulario.php?operacao=editar&idFuncionario={$funcionario->getIdFuncionario()}'><i class='material-icons'>
                                                        create</i></a>";
                                                    echo"<a class='btn btn-danger btn-simple btn-icon btn-sm'  
                                                    href='../controlador/FuncionarioControlador.php?operacao=excluir&idFuncionario={$funcionario->getIdFuncionario()}'>
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
				<form id="formFiltroFuncionario" action="FuncionarioTabela.php?operacao=filtrar" 
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
						id="nome" type="text">
				  </div>
                  <div class="modal-body">
					 <label for="tipo">Tipo</label>  
					 <select id="tipo" name="tipo" class="form-control">						  
                        
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
