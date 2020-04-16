<?php

    require_once '../class/TamanhoDAO.php';
    
	$tamanhoDAO = new TamanhoDAO();
	$tamanho = new Tamanho();

	$operacao = $_GET["operacao"];

	switch($operacao) 
	{
        case 'salvar':

			$tamanho->setIdTamanho($_POST["idTamanho"]);
			$tamanho->setTamanho($_POST["tamanho"]);
            $tamanho->setAltura($_POST["altura"]);
            $tamanho->setLargura($_POST["largura"]);


			$resultado = $tamanhoDAO->salvar($tamanho);		

			if($resultado == TRUE){
				echo "<script>location.href='../formulario/TamanhoFormulario.php?resultado=sucesso';</script>"; 
			}else{
				echo "<script>location.href='../formulario/TamanhoFormulario.php?resultado=erro';</script>"; 			
			}

        	break; 

        case 'excluir':
			
			$resultado = $tamanhoDAO->excluirPorId($_GET["idTamanho"]);

			if($resultado == 1){
				echo "<script>alert('Registro excluido com sucesso !!!'); location.href='../tabela/TamanhoTabela.php';</script>"; 
			}else{
				echo "<script>alert('Erro ao excluir o registro'); location.href='../tabela/TamanhoTabela.php';</script>"; 			
			}			
        	break;         	
	}
			
?>