<?php

    require_once '../class/TipoFuncDAO.php';
    
	$tipoFuncDAO = new TipoFuncDAO();
	$tipoFunc = new TipoFunc();

	$operacao = $_GET["operacao"];

	switch($operacao) 
	{
        case 'salvar':

			$tipoFunc->setIdTipoFunc($_POST["idTipoFunc"]);
            $tipoFunc->setDescricao($_POST["descricao"]);
            $tipoFunc->setPermissao($_POST["permissao"]);

			$resultado = $tipoFuncDAO->salvar($tipoFunc);		

			if($resultado == TRUE)
				echo "<script>location.href='../formulario/TipoFuncFormulario.php?resultado=sucesso';</script>"; 
			else
				echo "<script>location.href='../formulario/TipoFuncFormulario.php?resultado=erro';</script>"; 			

            break; 

        case 'excluir':
			
			$resultado = $tipoFuncDAO->excluirPorId($_GET["idTipoFunc"]);

			if($resultado == 1)
				echo "<script>alert('Registro excluido com sucesso !!!'); location.href='../tabela/TipoFuncTabela.php';</script>"; 
			else
				echo "<script>alert('Erro ao excluir o registro'); location.href='../tabela/TipoFuncTabela.php';</script>"; 	
            break;         	
	}
			
?>