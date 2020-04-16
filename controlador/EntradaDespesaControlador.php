<?php

	require_once '../class/EntradaDespesaDAO.php';
	require_once '../class/DespesaDAO.php';
    require_once '../class/FornecedorDAO.php';
    require_once '../class/InsumoDAO.php';

	$despesaDAO = new DespesaDAO();
	$fornecedorDAO = new FornecedorDAO();
	$insumoDAO = new InsumoDAO();
	
	$entradaDespesaDAO = new EntradaDespesaDAO();

	$operacao = $_GET["operacao"];

	switch($operacao) 
	{
        case 'salvar':

			$entradaDespesa = new EntradaDespesa();
			$entradaDespesa->setIdEntDespesa($_POST["idEntradaDespesa"]);

			if(isset($_POST["idDespesa"])){
				$despesa = $despesaDAO->buscarPorId($_POST["idDespesa"]);
				$entradaDespesa->setDespesa($despesa);
			}
			if(isset($_POST["idFornecedor"])){
				$fornecedor = $fornecedorDAO->buscarPorId($_POST["idFornecedor"]);
				$entradaDespesa->setFornecedor($fornecedor);
			}
			if(isset($_POST["idInsumo"])){
				$insumo = $insumoDAO->buscarPorId($_POST["idInsumo"]);
				$entradaDespesa->setInsumo($insumo);
			}
			
			$entradaDespesa->setValor($_POST["valor"]);
			$entradaDespesa->setData($_POST["data"]);
			$entradaDespesa->setDataVencimento($_POST["dataVencimento"]);

			$resultado = $entradaDespesaDAO->salvar($entradaDespesa);

			if($resultado == TRUE){
				echo "<script>location.href='../formulario/EntradaDespesaFormulario.php?resultado=sucesso';</script>"; 
			}else{
				echo "<script>location.href='../formulario/EntradaDespesaFormulario.php?resultado=erro';</script>"; 			
			}

        	break; 

         case 'excluir':
            
            $idEntradaDespesa = $_GET["idEntradaDespesa"];
			$entradaDespesa = $entradaDespesaDAO->buscarPorId($idEntradaDespesa);
			
			$resultado = $entradaDespesaDAO->excluirPorId($_GET["idEntradaDespesa"]);

			if($resultado == 1){
				echo "<script>alert('Registro excluido com sucesso !!!'); location.href='../tabela/EntradaDespesaTabela.php';</script>"; 
			}else{
				echo "<script>alert('Erro ao excluir o registro'); location.href='../tabela/EntradaDespesaTabela.php';</script>"; 			
			}			
        	break;    
	}
			
?>