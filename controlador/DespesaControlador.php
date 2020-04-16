<?php

	require_once '../class/DespesaDAO.php';

	$despesaDAO = new DespesaDAO();
	$despesa = new Despesa();

	$operacao = $_GET["operacao"];

	switch($operacao) 
	{
        case 'salvar':

			$despesa->setIdDespesa($_POST["idDespesa"]);
			$despesa->setNome($_POST["nome"]);
            
            $resultado = $despesaDAO->salvar($despesa);

			if($resultado == TRUE){
				echo "<script>location.href='../formulario/DespesaFormulario.php?resultado=sucesso';</script>"; 
			}else{
				echo "<script>location.href='../formulario/DespesaFormulario.php?resultado=erro';</script>"; 			
			}

        	break; 

        case 'excluir':
			
			$resultado = $despesaDAO->excluirPorId($_GET["idDespesa"]);

			if($resultado == 1){
				echo "<script>alert('Registro excluido com sucesso !!!'); location.href='../tabela/DespesaTabela.php';</script>"; 
			}else{
				echo "<script>alert('Erro ao excluir o registro'); location.href='../tabela/DespesaTabela.php';</script>"; 			
			}			
        	break;         	
	}
			
?>
