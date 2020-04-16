<?php

    require_once '../class/TipoMalhaDAO.php';
    
	$tipoMalhaDAO = new TipoMalhaDAO();
	$tipoMalha = new TipoMalha();

	$operacao = $_GET["operacao"];

	switch($operacao) 
	{
        case 'salvar':

			$tipoMalha->setIdMalha($_POST["idMalha"]);
			$tipoMalha->setNome($_POST["nome"]);

			$resultado = $tipoMalhaDAO->salvar($tipoMalha);		

			if($resultado == TRUE){
				echo "<script>location.href='../formulario/TipoMalhaFormulario.php?resultado=sucesso';</script>"; 
			}else{
				echo "<script>location.href='../formulario/TipoMalhaFormulario.php?resultado=erro';</script>"; 			
			}

        	break; 

        case 'excluir':
			
			$resultado = $tipoMalhaDAO->excluirPorId($_GET["idMalha"]);

			if($resultado == 1){
				echo "<script>alert('Registro excluido com sucesso !!!'); location.href='../tabela/TipoMalhaTabela.php';</script>"; 
			}else{
				echo "<script>alert('Erro ao excluir o registro'); location.href='../tabela/TipoMalhaTabela.php';</script>"; 			
			}			
        	break;         	
	}
			
?>