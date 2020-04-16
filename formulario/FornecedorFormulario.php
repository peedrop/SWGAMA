<?php	
	session_start();
    if(isset($_SESSION['USUARIO'])){
	}else{
		echo "<script>alert('É preciso estar logado para acessar essa página!');location.href='../formulario/Login.php';</script>";
    }
    
	require_once '../class/FornecedorDAO.php';

	$fornecedor = new Fornecedor();

	if(isset($_GET["operacao"])){
		$operacao = $_GET["operacao"];
    }
    $resultado = '';
    if(isset($_GET["resultado"])){
		$resultado = $_GET["resultado"];
    }
    
    $titulo = "Cadastrando Fornecedor ";

	if(isset($_GET["idFornecedor"])){
		
        $idFornecedor = $_GET["idFornecedor"];

		$fornecedorDAO = new FornecedorDAO();
        $fornecedor = $fornecedorDAO->buscarPorId($idFornecedor);

        $nome = $fornecedor->getNome();
        
        $titulo = "Editando Fornecedor : $nome";
	}		
?>

<!DOCTYPE html>
<html lang="pt">
    <head>
        <title>Fornecedor Formulário</title>
        <?php 
            include_once("../blocosRepetidos/cssPadrao.php");  	
        ?>	
        <!-- Outros CSS
        <link type="text/css" rel="stylesheet" href="../css/fornecedorFormulario.css"/>
        -->
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
                                    <a class="btn btn-light btn-round float-right" href="../tabela/FornecedorTabela.php"><< Voltar</a>
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
                                    <form id="formFornecedor" action="../controlador/FornecedorControlador.php?operacao=salvar" method="post">
                                        <div class="row">
                                            <div class="col-md-6 pr-1">
                                                <div class="form-group">
                                                    <label>Nome</label>
                                                    <input type="hidden" name="idFornecedor" id="idFornecedor" value="<?php echo $fornecedor->getIdFornecedor() ?>" >
                                                    <input type="text" class="form-control" id="nome" name="nome" 
                                                    value="<?php echo $fornecedor->getNome() ?>" placeholder="Ex: Maria Artesanatos" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 pl-1">
                                                <div class="form-group">
                                                    <label>Telefone</label>
                                                    <input type="text" class="form-control" id="telefone" name="telefone" 
                                                    value="<?php echo $fornecedor->getTelefone() ?>" placeholder="Ex: (31)9 9999-9999" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 pr-1">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="email" class="form-control" id="email" name="email" 
                                                    value="<?php echo $fornecedor->getEmail() ?>" placeholder="Ex: maria@gmail.com" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 pl-1">
                                                <div class="form-group">
                                                    <label>Endereço</label>
                                                    <input type="text" class="form-control" id="endereco" name="endereco" 
                                                    value="<?php echo $fornecedor->getEndereco() ?>" placeholder="Ex: Rua A no centro de Belo Oriente" required>
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
        <script type="text/javascript" src="../js/fornecedorFormulario.js"></script>
    </body>
</html>
