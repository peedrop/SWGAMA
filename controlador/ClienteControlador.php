<?php

    require_once '../class/ClienteDAO.php';
    
	$clienteDAO = new ClienteDAO();
	$cliente = new Cliente();

	$operacao = $_GET["operacao"];

	switch($operacao) 
	{
		case 'salvar':
			/*
			echo $_POST["idCliente"];
			echo "<br>";
			echo $_POST["nome"];
			echo "<br>";
			echo $_POST["dataNascimento"];
			echo "<br>";
			echo $_POST["telefone"];
			echo "<br>";
			echo $_POST["email"];
			echo "<br>";
			echo $_POST["cpf"];
			echo "<br>";
			echo $_POST["cnpj"];
			echo "<br>";
			echo $_POST["tipoPessoa"];
			echo "<br>";
			echo $_POST["endereco"];
			*/
			
			$cliente->setIdCliente($_POST["idCliente"]);
			$cliente->setNome($_POST["nome"]);
            $cliente->setDataNascimento($_POST["dataNascimento"]);
            $cliente->setTelefone($_POST["telefone"]);
			$cliente->setEmail($_POST["email"]);

			$tipoPessoa = $_POST["tipoPessoa"];

			if ($tipoPessoa == "pessoaFisica"){
				$cliente->setTipoPessoa("Pessoa Física");
				$cliente->setCpf($_POST["cpf"]);
				$cliente->setCnpj("");
			}else{
				if ($tipoPessoa == "pessoaJuridica"){
					$cliente->setTipoPessoa("Pessoa Jurídica");
					$cliente->setCnpj($_POST["cnpj"]);
					$cliente->setCpf("");
				}
			}

            $cliente->setEndereco($_POST["endereco"]);

			print_r($cliente);
			$resultado = $clienteDAO->salvar($cliente);		

			if($resultado == TRUE){
				echo "<script>location.href='../formulario/ClienteFormulario.php?resultado=sucesso';</script>"; 
			}else{
				echo "<script>location.href='../formulario/ClienteFormulario.php?resultado=erro';</script>"; 			
			}
			

        	break; 

        case 'excluir':
			
			$resultado = $clienteDAO->excluirPorId($_GET["idCliente"]);

			if($resultado == 1){
				echo "<script>alert('Registro excluido com sucesso !!!'); location.href='../tabela/ClienteTabela.php';</script>"; 
			}else{
				echo "<script>alert('Erro ao excluir o registro'); location.href='../tabela/ClienteTabela.php';</script>"; 			
			}			
			break;  

		case 'verificarCpf':
		
			$cpf = $_POST["cpf"];
			$idCliente = $_GET["idCliente"];

			$resultado = $clienteDAO->verificarCpf($idCliente, $cpf);

			echo json_encode( $resultado );

		
			break;   

		case 'verificarCnpj':
	
			$cnpj = $_POST["cnpj"];
			$idCliente = $_GET["idCliente"];

			$resultado = $clienteDAO->verificarCnpj($idCliente, $cnpj);

			echo json_encode( $resultado );

		
			break;     	
	}
			
?>