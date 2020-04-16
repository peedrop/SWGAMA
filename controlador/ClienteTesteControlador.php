<?php

    require_once '../class/ClienteTesteDAO.php';
    
	$clienteTesteDAO = new ClienteTesteDAO();
	$cliente = new ClienteTeste();

	$operacao = $_GET["operacao"];

	switch($operacao) 
	{
        case 'salvar':

			$cliente->setIdCliente($_POST["idCliente"]);
			$cliente->setNome($_POST["nome"]);
            $cliente->setIdade($_POST["idade"]);

			$resultado = $clienteTesteDAO->salvar($cliente);		

			if($resultado == TRUE){
				echo "<script>location.href='../formulario/ClienteTesteFormulario.php?resultado=sucesso';</script>"; 
			}else{
				echo "<script>location.href='../formulario/ClienteTesteFormulario.php?resultado=erro';</script>"; 			
			}

        	break; 

        case 'excluir':
			
			$resultado = $clienteTesteDAO->excluirPorId($_GET["idCliente"]);

			if($resultado == 1){
				echo "<script>alert('Registro excluido com sucesso !!!'); location.href='../tabela/ClienteTesteTabela.php';</script>"; 
			}else{
				echo "<script>alert('Erro ao excluir o registro'); location.href='../tabela/ClienteTesteTabela.php';</script>"; 			
			}			
        	break;         	
	}
			
?>