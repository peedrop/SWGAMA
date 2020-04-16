<?php

	require_once '../class/BlusaDAO.php';
	require_once '../class/GolaDAO.php';
    require_once '../class/ModoProdDAO.php';
    require_once '../class/TamanhoDAO.php';
    require_once '../class/TipoMalhaDAO.php';

	$golaDAO = new GolaDAO();
	$modoProdDAO = new ModoProdDAO();
	$tamanhoDAO = new TamanhoDAO();
	$malhaDAO = new TipoMalhaDAO();
	
	$blusaDAO = new BlusaDAO();

	$operacao = $_GET["operacao"];

	switch($operacao) 
	{
        case 'salvar':

			$gola = $golaDAO->buscarPorId($_POST["idGola"]);
			$modoProd = $modoProdDAO->buscarPorId($_POST["idModoProd"]);
			$tamanho = $tamanhoDAO->buscarPorId($_POST["idTamanho"]);
			$malha = $malhaDAO->buscarPorId($_POST["idMalha"]);

			$blusa = new Blusa();
			$blusa->setIdBlusa($_POST["idBlusa"]);	

			$blusa->setGola($gola);
			$blusa->setModoProd($modoProd);
			$blusa->setTamanho($tamanho);
			$blusa->setMalha($malha);
			$blusa->setEstoque($_POST["qtdEstoque"]);
			$blusa->setValor($_POST["valor"]);
			$blusa->setNome($_POST["nome"]);

			$resultado = $blusaDAO->salvar($blusa);

			if($resultado == TRUE){
				echo "<script>location.href='../formulario/BlusaFormulario.php?resultado=sucesso';</script>"; 
			}else{
				echo "<script>location.href='../formulario/BlusaFormulario.php?resultado=erro';</script>"; 			
			}

        	break; 

         case 'excluir':
            
            $idBlusa = $_GET["idBlusa"];
			$blusa = $blusaDAO->buscarPorId($idBlusa);
			
			$resultado = $blusaDAO->excluirPorId($_GET["idBlusa"]);

			if($resultado == 1){
				echo "<script>alert('Registro excluido com sucesso !!!'); location.href='../tabela/BlusaTabela.php';</script>"; 
			}else{
				echo "<script>alert('Erro ao excluir o registro'); location.href='../tabela/BlusaTabela.php';</script>"; 			
			}			
        	break;    
	}
			
?>