<?php

    require_once '../class/ModoProdDAO.php';
    
	$modoProdDAO = new ModoProdDAO();
	$modoProd = new ModoProd();

	$operacao = $_GET["operacao"];

	switch($operacao) 
	{
        case 'salvar':

			$modoProd->setIdModoProd($_POST["idModoProd"]);
			$modoProd->setNome($_POST["nome"]);

			$resultado = $modoProdDAO->salvar($modoProd);		

			if($resultado == TRUE){
				echo "<script>location.href='../formulario/ModoProdFormulario.php?resultado=sucesso';</script>"; 
			}else{
				echo "<script>location.href='../formulario/ModoProdFormulario.php?resultado=erro';</script>"; 			
			}

        	break; 

        case 'excluir':
			
			$resultado = $modoProdDAO->excluirPorId($_GET["idModoProd"]);

			if($resultado == 1){
				echo "<script>alert('Registro excluido com sucesso !!!'); location.href='../tabela/ModoProdTabela.php';</script>"; 
			}else{
				echo "<script>alert('Erro ao excluir o registro'); location.href='../tabela/ModoProdTabela.php';</script>"; 			
			}			
        	break;         	
	}
			
?>