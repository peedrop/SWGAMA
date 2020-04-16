<?php

    require_once '../class/GolaDAO.php';
    
	$golaDAO = new GolaDAO();
	$gola = new Gola();

	$operacao = $_GET["operacao"];

	switch($operacao) 
	{
        case 'salvar':

			$gola->setidGola($_POST["idGola"]);
			$gola->setNome($_POST["nome"]);

			$resultado = $golaDAO->salvar($gola);		

			if($resultado == TRUE){
				echo "<script>location.href='../formulario/GolaFormulario.php?resultado=sucesso';</script>"; 
			}else{
				echo "<script>location.href='../formulario/GolaFormulario.php?resultado=erro';</script>"; 			
			}

        	break; 

        case 'excluir':
			
			$resultado = $golaDAO->excluirPorId($_GET["idGola"]);

			if($resultado == 1){
				echo "<script>alert('Registro excluido com sucesso !!!'); location.href='../tabela/GolaTabela.php';</script>"; 
			}else{
				echo "<script>alert('Erro ao excluir o registro'); location.href='../tabela/GolaTabela.php';</script>"; 			
			}			
        	break;         	
	}
			
?>