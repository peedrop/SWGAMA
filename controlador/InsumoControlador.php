<?php

    require_once '../class/InsumoDAO.php';
    
	$insumoDAO = new InsumoDAO();
	$insumo = new Insumo();

	$operacao = $_GET["operacao"];

	switch($operacao) 
	{
        case 'salvar':

			$insumo->setId($_POST["idInsumo"]);
			$insumo->setNome($_POST["nome"]);
			$insumo->setQtdMin($_POST["qtdMin"]);
			$insumo->setQtdEstoque($_POST["qtdEstoque"]);
			$insumo->setDescricao($_POST["descricao"]);
			$insumo->setTipo($_POST["tipo"]);

			$resultado = $insumoDAO->salvar($insumo);		

			if($resultado == TRUE){
				echo "<script>location.href='../formulario/InsumoFormulario.php?resultado=sucesso';</script>"; 
			}else{
				echo "<script>location.href='../formulario/InsumoFormulario.php?resultado=erro';</script>"; 			
			}

        	break; 

        case 'excluir':
			
			$resultado = $insumoDAO->excluirPorId($_GET["idInsumo"]);

			if($resultado == 1){
				echo "<script>alert('Registro excluido com sucesso !!!'); location.href='../tabela/InsumoTabela.php';</script>"; 
			}else{
				echo "<script>alert('Erro ao excluir o registro'); location.href='../tabela/InsumoTabela.php';</script>"; 			
			}			
        	break;         	
	}
			
?>