<?php

    require_once '../class/FuncionarioDAO.php';
	
	$funcionarioDAO = new FuncionarioDAO();
	$funcionario = new Funcionario();

	$operacao = $_GET["operacao"];

	switch($operacao) 
	{
        case 'salvar':

			$funcionario->setIdFuncionario($_POST['idFuncionario']);
			$funcionario->setNome($_POST['nmFuncionario']);
			$funcionario->setCpf($_POST['cpf']);
			$funcionario->setSexo($_POST['sexo']);
			$funcionario->setTelefone($_POST['telefone']);
			$funcionario->setDataNascimento($_POST['dtNasc']);
			$funcionario->setEmail($_POST['email']);
			$funcionario->setSalario($_POST['salario']);
			$funcionario->setDataPag($_POST['dtPagamento']);
		
			$funcionario->setEndereco($_POST['endereco']);
			$funcionario->setTipo($_POST['tipo']);

			$resultado = $funcionarioDAO->salvar($funcionario);		
		
			if($resultado == TRUE){
				echo "<script>location.href='../formulario/FuncionarioFormulario.php?resultado=sucesso';</script>"; 
			}else{
				echo "<script>location.href='../formulario/FuncionarioFormulario.php?resultado=erro';</script>"; 			
			}

        	break; 

        case 'excluir':
			
			$resultado = $funcionarioDAO->excluirPorId($_GET["idFuncionario"]);

			if($resultado == 1){
				echo "<script>alert('Registro excluido com sucesso !!!'); location.href='../tabela/FuncionarioTabela.php';</script>"; 
			}else{
				echo "<script>alert('Erro ao excluir o registro'); location.href='../tabela/FuncionarioTabela.php';</script>"; 			
			}			
			break;  
			
		
			case 'verificarCpf':
		
				$cpf = $_POST["cpf"];
				$idFuncionario = $_GET["idFuncionario"];
	
				$resultado = $funcionarioDAO->verificarCpf($idFuncionario, $cpf);
	
				echo json_encode( $resultado );
	
			
			break;   
	}
			
?>