<?php	
	session_start();
    if(isset($_SESSION['USUARIO'])){
	}else{
		echo "<script>alert('É preciso estar logado para acessar essa página!');location.href='../formulario/Login.php';</script>";
    }
	require_once '../class/ClienteDAO.php';	
?>
<!DOCTYPE html>
<html lang="pt">
    <head>
        <title>Cliente Tabela</title>
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
                                    <a class="btn btn-success btn-round float-right" href="../formulario/ClienteFormulario.php">+ Novo Cliente</a>
                                    <button type="button" class="btn btn-primary btn-round float-right mr-3" data-toggle="modal" data-target="#modalFiltro">Filtrar</button>	
                                    <?php
                                        if(isset($_GET["operacao"])=="filtrar"){
                                            echo "<a class='mx-2 btn btn-warning btn-round float-right mr-3' href='ClienteTabela.php'>Limpar filtro</a>";
                                        }
                                    ?>
                                </div>
                                <div class="card-header">
                                    <h5 class="title">Cliente Tabela</h5>
                                </div>
                                <div class="card-body">
                                    <table id="tabela1" class="compact cell-border hover order-column 
                                    row-border stripe table table-striped" style="width:100%">
                                        <thead class="">
                                            <tr>
                                            <th width="10%">#</th>
                                            <th width="25%">Nome</th>
                                            <th width="25%">Data de Nascimento</th>
                                            <th width="25%">Telefone</th>
                                            <th width="15%">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                
                                                $clienteDAO = new ClienteDAO();

                                                //pega lista com filtro ou sem filtro
                                                if(isset($_GET["operacao"])=="filtrar"){							
                                                    $nome = '';
                                                    $dataNascimento = '';
                                                    $telefone = '';
                                                    $email = '';
                                                    $cpf = '';
                                                    $cnpj = '';
                                                    $tipoPessoa = '';
                                                    $endereco = '';	
                     
                                                    if(isset($_POST["nome"])){
                                                        $nome = $_POST["nome"];
                                                    }
                                                    if(isset($_POST["dataNascimento"])){
                                                        $dataNascimento = $_POST["dataNascimento"];
                                                    }
                                                    if(isset($_POST["telefone"])){
                                                        $telefone = $_POST["telefone"];
                                                    }
                                                    if(isset($_POST["email"])){
                                                        $email = $_POST["email"];
                                                    }
                                                    if(isset($_POST["cpf"])){
                                                        $cpf = $_POST["cpf"];
                                                    }
                                                    if(isset($_POST["cnpj"])){
                                                        $cnpj = $_POST["cnpj"];
                                                    }
                                                    if(isset($_POST["tipoPessoa"])){
                                                        $tipoPessoa = $_POST["tipoPessoa"];
                                                    }
                                                    if(isset($_POST["endereco"])){
                                                        $endereco = $_POST["endereco"];
                                                    }
                                                    $lista = $clienteDAO->filtrar($nome, $dataNascimento, $telefone, $email, $cpf, $cnpj, $tipoPessoa, $endereco);
                                                }else{
                                                    $lista = $clienteDAO->listar();
                                                }

                                                if ($lista == null){
                                                    echo"<td></td>";	
                                                    echo"<td>Não encontrado</td>";	
                                                    echo"<td>Não encontrado</td>";
                                                    echo"<td>Não encontrado</td>";
                                                    echo"<td></td>";
                                                }

                                                foreach($lista as $cliente){
                                                    /*
                                                        Transformar em objeto json para poder mandar via GET por URL 
                                                        Colocar na seguinte ordem:
                                                            *(Título conforme vai ser exibido no visualizar)
                                                            *(Nome do atributo conforme vai ser exibido no visualizar)
                                                            *(Valor do respectivo atributo)
                                                    */
                                                    $cpfOUcnpjNome = "";
                                                    $cpfOUcnpjValor = "";
                                                    if ($cliente->getTipoPessoa() == "Pessoa Física"){
                                                        $cpfOUcnpjNome = "Cpf";
                                                        $cpfOUcnpjValor = $cliente->getCpf();
                                                    }else{
                                                        if ($cliente->getTipoPessoa() == "Pessoa Jurídica"){
                                                            $cpfOUcnpjNome = "Cnpj";
                                                            $cpfOUcnpjValor = $cliente->getCnpj();
                                                        }
                                                    }
                                                    $obj_json = json_encode(array(
                                                        "Visualizar Cliente",
                                                        "Id", $cliente->getIdCliente(), 
                                                        "Nome", $cliente->getNome(),
                                                        "Data de Nascimento", date("d/m/Y", strtotime($cliente->getDataNascimento())),
                                                        "Telefone", $cliente->getTelefone(),
                                                        "Email", $cliente->getEmail(),
                                                        $cpfOUcnpjNome, $cpfOUcnpjValor,
                                                        "Tipo de Pessoa", $cliente->getTipoPessoa(),
                                                        "Endereço", $cliente->getEndereco()
                                                    ));


                                                    echo"<tr>";			
                                                    //idCliente
                                                    echo"<td>{$cliente->getIdCliente()}</td>";	
                                                    //nome	
                                                    echo"<td>{$cliente->getNome()}</td>";	
                                                    //data de nascimento
                                                    echo"<td>".date('d/m/Y', strtotime($cliente->getDataNascimento()))."</td>";	
                                                    //telefone
                                                    echo"<td>{$cliente->getTelefone()}</td>";	
                                                    echo"<td><div class='btn-group btn-block' role='group'>";
                                                    //botão visualizar - passando objeto json para visualizar
                                                    echo"<a class='btn btn-secondary btn-simple btn-icon btn-sm mr-2'  
                                                    href='../formulario/Visualizar.php?objeto={$obj_json}&pagina={$_SERVER['PHP_SELF']}'><i class='material-icons'>search </i></a>";	
                                                    //botão editar
                                                    echo"<a  class='btn btn-info btn-simple btn-icon btn-sm mr-2'
                                                    href='../formulario/ClienteFormulario.php?operacao=editar&idCliente={$cliente->getIdCliente()}'><i class='material-icons'>
                                                        create</i></a>";
                                                    //botão excluir
                                                    echo"<a class='btn btn-danger btn-simple btn-icon btn-sm'  
                                                    href='../controlador/ClienteControlador.php?operacao=excluir&idCliente={$cliente->getIdCliente()}'>
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
				<form id="formFiltroCliente" action="ClienteTabela.php?operacao=filtrar" 
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
					 <label for="dataNascimento">Data de Nascimento</label>  
					 <input class="form-control campo" name="dataNascimento" 
						id="dataNascimento" type="text" value="" >
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
					 <label for="cpf">Cpf</label>  
					 <input class="form-control campo" name="cpf" 
						id="cpf" type="text" value="" >
				  </div>
                  <div class="modal-body">
					 <label for="cnpj">Cnpj</label>  
					 <input class="form-control campo" name="cnpj" 
						id="cnpj" type="text" value="" >
				  </div>
                  <div class="modal-body">
					 <label for="tipoPessoa">Tipo de Pessoa</label>  
					 <input class="form-control campo" name="tipoPessoa" 
						id="tipoPessoa" type="text" value="" >
				  </div>
                  <div class="modal-body">
					 <label for="endereco">Endereco</label>  
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
