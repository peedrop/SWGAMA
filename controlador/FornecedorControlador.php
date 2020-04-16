<?php

    require_once '../class/FornecedorDAO.php';
    
	$fornecedorDAO = new FornecedorDAO();
	$fornecedor = new Fornecedor();

	$operacao = $_GET["operacao"];

	switch($operacao) 
	{
        case 'salvar':

			$fornecedor->setIdFornecedor($_POST["idFornecedor"]);
			$fornecedor->setNome($_POST["nome"]);
            $fornecedor->setTelefone($_POST["telefone"]);
            $fornecedor->setEmail($_POST["email"]);
            $fornecedor->setEndereco($_POST["endereco"]);


			$resultado = $fornecedorDAO->salvar($fornecedor);		

			if($resultado == TRUE){
				echo "<script>location.href='../formulario/FornecedorFormulario.php?resultado=sucesso';</script>"; 
			}else{
				echo "<script>location.href='../formulario/FornecedorFormulario.php?resultado=erro';</script>"; 			
			}

        	break; 

        case 'excluir':
			
			$resultado = $fornecedorDAO->excluirPorId($_GET["idFornecedor"]);

			if($resultado == 1){
				echo "<script>alert('Registro excluido com sucesso !!!'); location.href='../tabela/FornecedorTabela.php';</script>"; 
			}else{
				echo "<script>alert('Erro ao excluir o registro'); location.href='../tabela/FornecedorTabela.php';</script>"; 			
			}			
        	break;         	
	}
			
?>