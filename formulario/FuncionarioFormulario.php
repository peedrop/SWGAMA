<?php	
	session_start();
    if(isset($_SESSION['USUARIO'])){
	}else{
		echo "<script>alert('É preciso estar logado para acessar essa página!');location.href='../formulario/Login.php';</script>";
    }
    
    require_once '../class/FuncionarioDAO.php';

	$funcionario = new Funcionario();

	if(isset($_GET["operacao"])){
		$operacao = $_GET["operacao"];
    }
    $resultado = '';
    if(isset($_GET["resultado"])){
		$resultado = $_GET["resultado"];
    }

    $titulo = "Cadastrando Funcionário";

	if(isset($_GET["idFuncionario"])){
		
        $idFuncionario = $_GET["idFuncionario"];

		$funcionarioDAO = new FuncionarioDAO();
        $funcionario = $funcionarioDAO->buscarPorId($idFuncionario);

        $nome = $funcionario->getNome();
        
        $titulo = "Editando Funcionário: $nome";
	}		
?>

<!DOCTYPE html>
<html lang="pt">
    <head>
        <title>Funcionário</title>
        <?php 
            include_once("../blocosRepetidos/cssPadrao.php");  	
        ?>	
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
                                    <a class="btn btn-light btn-round float-right" href="../tabela/FuncionarioTabela.php"><< Voltar</a>
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
                                    <form id="formFuncionario" action="../controlador/FuncionarioControlador.php?operacao=salvar" method="post">
                                        <div class="row">
                                            <div class="col-md-6 pr-1">
                                                <div class="form-group">
                                                    <label>Nome</label>
                                                    <input type="hidden" name="idFuncionario" id="idFuncionario" value="<?php echo $funcionario->getIdFuncionario() ?>">
                                                    <input type="hidden" name="idUsuario" id="idUsuario" value="1" >
                                                    <input type="text" class="form-control" id="nmFuncionario" name="nmFuncionario" 
                                                    value="<?php echo $funcionario->getNome() ?>" placeholder="Ex: João" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="email" class="form-control" id="email" name="email" 
                                                    value="<?php echo $funcionario->getEmail() ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 pr-1">
                                                <div class="form-group">
                                                    <label>Data de nascimento</label>
                                                    <input type="date" class="form-control" id="dtNasc" name="dtNasc" 
                                                    value="<?php echo $funcionario->getDataNascimento() ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3 pr-1">
                                                <div class="form-group">
                                                    <label>Telefone</label>
                                                    <input type="text" class="form-control" id="telefone" name="telefone" 
                                                    value="<?php echo $funcionario->getTelefone() ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3 pr-1">
                                                <div class="form-group">
                                                    <label>Cpf</label>
                                                    <input type="text" class="form-control" id="cpf" name="cpf" 
                                                    value="<?php echo $funcionario->getCpf() ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Sexo</label>
                                                    <select class="form-control" id="exampleFormControlSelect1" id="sexo" name="sexo">
                                                    <?php
                                                        if($funcionario->getSexo() == ''){
                                                            echo "<option 
                                                                value='' disabled selected>Selecione o sexo</option>";
                                                                echo "<option value='F'>Feminino</option>";
                                                                echo "<option value='M'>Masculino</option>";
                                                                echo "<option value='O'>Outro</option>";
                                                        } else{
                                                            if($funcionario->getSexo() == 'F'){
                                                                echo "<option selected value='F'>Feminino</option>";
                                                                echo "<option value='M'>Masculino</option>";
                                                                echo "<option value='O'>Outro</option>";
                                                            }else if($funcionario->getSexo() == 'M'){
                                                                echo "<option value='F'>Feminino</option>";
                                                                echo "<option selected value='M'>Masculino</option>";
                                                                echo "<option value='O'>Outro</option>";
                                                            } else{
                                                                echo "<option value='F'>Feminino</option>";
                                                                echo "<option value='M'>Masculino</option>";
                                                                echo "<option selected value='O'>Outro</option>";
                                                            }
                                                        }
                                                    ?>
                                                    </select>
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
                                                    value="<?php echo $funcionario->getEndereco() ?>" placeholder="" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5 pr-1">
                                            <label>Tipo funcionário</label>
                                            <select class="col form-control" id="tipo" name="tipo" onchange="exibir_ocultar()">  
                                                <?php
                                                    if($funcionario->getTipo() == ''){
                                                        echo "<option value='' disabled selected>Selecione o tipo de funcionário</option>";
                                                        echo "<option value='CONTRATADO'>Contratado</option>";
                                                        echo "<option value='GERENTE'>Gerente</option>";
                                                        echo "<option value='VOLUNTARIO'>Voluntário</option>";
                                                    } else{
                                                        if($funcionario->getTipo() == 'CONTRATADO'){
                                                            echo "<option selected value='CONTRATADO'>Contratado</option>";
                                                            echo "<option value='GERENTE'>Gerente</option>";
                                                            echo "<option value='VOLUNTARIO'>Voluntário</option>";
                                                        }else if($funcionario->getSexo() == 'GERENTE'){
                                                            echo "<option value='CONTRATADO'>Contratado</option>";
                                                            echo "<option selected value='M'>Gerente</option>";
                                                            echo "<option value='VOLUNTARIO'>Voluntário</option>";
                                                        } else{
                                                            echo "<option value='CONTRATADO'>Contratado</option>";
                                                            echo "<option value='GERENTE'>Gerente</option>";
                                                            echo "<option selected value='VOLUNTARIO'>Voluntário</option>";
                                                        }
                                                    }
                                                ?>	
                                            </select>
                                            </div>
                                            <div class="col-md-3 pr-1">
                                                <div class="form-group ocultar">
                                                    <label>Salário</label>
                                                    <input type="salario" class="form-control" id="salario" name="salario" 
                                                    value="<?php echo $funcionario->getSalario() ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4 ">
                                                <div class="form-group ocultar">
                                                    <label>Data de pagamento</label>
                                                    <input type="number" class="form-control" id="dtPagamento" name="dtPagamento" 
                                                    value="<?php echo $funcionario->getDataPag() ?>">
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
        <script type="text/javascript" src="../js/FuncionarioFormulario.js"></script>
    </body>
</html>
