<?php	
	session_start();
    if(isset($_SESSION['USUARIO'])){
	}else{
		echo "<script>alert('É preciso estar logado para acessar essa página!');location.href='../formulario/Login.php';</script>";
	}
	require_once '../class/ClienteDAO.php';

	$cliente = new Cliente();

	if(isset($_GET["operacao"])){
		$operacao = $_GET["operacao"];
    }
    $resultado = '';
    if(isset($_GET["resultado"])){
		$resultado = $_GET["resultado"];
    }
    
    $titulo = "Cadastrando Cliente";

	if(isset($_GET["idCliente"])){
		
        $idCliente = $_GET["idCliente"];

		$clienteDAO = new ClienteDAO();
        $cliente = $clienteDAO->buscarPorId($idCliente);

        $nome = $cliente->getNome();
        
        $titulo = "Editando Cliente: $nome";
	}		
?>

<!DOCTYPE html>
<html lang="pt">
    <head>
        <title>Cliente Formulário</title>
        <?php 
            include_once("../blocosRepetidos/cssPadrao.php");  	
        ?>	
        <!-- Outros CSS-->
        <link type="text/css" rel="stylesheet" href="#"/>
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
                                    <a class="btn btn-light btn-round float-right" href="../tabela/ClienteTabela.php"><< Voltar</a>
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
                                    <form id="formCliente" action="../controlador/ClienteControlador.php?operacao=salvar" method="post">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nome</label>
                                                    <input type="hidden" name="idCliente" id="idCliente" value="<?php echo $cliente->getIdCliente() ?>" >
                                                    <input type="text" class="form-control" id="nome" name="nome" 
                                                    value="<?php echo $cliente->getNome() ?>" placeholder="Ex: Pedro" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="email" class="form-control" id="email" name="email" 
                                                    value="<?php echo $cliente->getEmail() ?>" placeholder="" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="btn-group btn-group-toggle mt-3" data-toggle="buttons">
                                                    <button class="btn btn-info active" id="pessoaFisica" name="pessoaFisica">
                                                        <input type="radio" name="tipoPessoa" id="pessoaFisica" value="pessoaFisica" autocomplete="off" checked> Pessoa Física
                                                    </button>
                                                    <button class="btn btn-outline-info" id="pessoaJuridica" name="pessoaJuridica">
                                                        <input type="radio" name="tipoPessoa" id="pessoaJuridica" value="pessoaJuridica" autocomplete="off"> Pessoa Jurídica
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-3 ">
                                                <div class="form-group" id="opcaoCpf">
                                                    <label>Cpf</label>
                                                    <input type="text" class="form-control" id="cpf" name="cpf" 
                                                    value="<?php echo $cliente->getCpf() ?>" placeholder="Ex: 000.000.000-00">
                                                </div>
                                                <div class="d-none" id="opcaoCnpj"><!--Inicialmente oculto, aguardando clique-->
                                                    <label>Cnpj</label>
                                                    <input type="text" class="form-control" id="cnpj" name="cnpj" 
                                                    value="<?php echo $cliente->getCnpj() ?>" placeholder="Ex: 00.000.000/0000-00">
                                                </div>
                                            </div>
                                            <input type="hidden" name="pegarTipoPessoa" id="pegarTipoPessoa" value="<?php echo $cliente->getTipoPessoa() ?>" >
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Data de Nascimento</label>
                                                    <input type="date" class="form-control" id="dataNascimento" name="dataNascimento" 
                                                    value="<?php echo $cliente->getDataNascimento() ?>" placeholder="" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Telefone</label>
                                                    <input type="text" class="form-control" id="telefone" name="telefone" 
                                                    value="<?php echo $cliente->getTelefone() ?>" placeholder="" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Cep</label>
                                                    <input type="text" class="form-control" id="cep" name="cep" 
                                                    value="" placeholder="Ex: 00.000-000">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Número</label>
                                                    <input type="number" class="form-control" id="numero" name="numero" 
                                                    value="" placeholder="Ex: 0">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Complemento</label>
                                                    <input type="text" class="form-control" id="complemento" name="complemento" 
                                                    value="" placeholder="Ex: Casa A">
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Endereço</label>
                                                    <input type="text" class="form-control" id="endereco" name="endereco" 
                                                    value="<?php echo $cliente->getEndereco() ?>" placeholder="" required>
                                                </div>
                                            </div>
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
        <script type="text/javascript" src="../js/clienteFormulario.js"></script>
    </body>
</html>
