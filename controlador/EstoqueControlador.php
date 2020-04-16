<?php

    require_once '../class/EstoqueDAO.php';
	require_once '../class/BlusaEstoqueDAO.php';
	require_once '../class/BlusaDAO.php';

	$blusaEstoqueDAO = new BlusaEstoqueDAO();
	$estoqueDAO = new EstoqueDAO();
	$blusaDAO = new BlusaDAO();

	$estoque = new Estoque();
	$blusa = new Blusa();
	
	

	$operacao = $_GET["operacao"];

	switch($operacao) 
	{
		case 'salvar':
		    $id = $_POST["idEstoque"];
			$estoque->setIdEstoque($id);
			$estoque->setData($_POST["data"]);
			$estoque->setTipo("ENTRADA");
			$iguais = false;

			if ($id != 0){
				$estoqueSalvo = $estoqueDAO->buscarPorId($id);
				
				if($estoqueSalvo->getData() == $estoque->getData() && $estoqueSalvo->getTipo() == $estoque->getTipo()){
					$iguais = true;
					$resultado = 1;
				}
			}
			if(!$iguais){
				$resultado = $estoqueDAO->salvar($estoque);	
			}
			
			if($resultado){
				if(isset($_POST["blusas"])){
					$blusas = $_POST["blusas"];
				}
				if(isset($_POST["quantidades"])){
					$quantidades = $_POST["quantidades"];
				}
				if(isset($_POST["linhasExcluidas"])){
					$linhasExcluidas = $_POST["linhasExcluidas"];
				}

				//excluir produtos que já estavam cadastrados no banco e foram excluídos da view
				if(!empty($linhasExcluidas)){
					foreach($linhasExcluidas as $linha){

							$blusa = $blusaDAO->buscarPorId($linha);
							$quantidade = $blusa->getEstoque();

							$quantidade = $quantidade - $blusaEstoqueDAO->buscarQuantidaPorIdBlusaAndIdEstoque($linha, $estoque->getIdEstoque());
							
							$blusa->setEstoque($quantidade);
			
							$blusaDAO->salvar($blusa);	

							$blusaEstoqueDAO->excluirPorIdBlusaAndIdEstoque($linha, $estoque->getIdEstoque());
					}
				}

				if(!empty($blusas)){
					$blusasEstoque = $blusaEstoqueDAO->listarPorEntrada($estoque->getIdEstoque());
					if(count($blusasEstoque) > 0){
						foreach($blusasEstoque as $blusa){
							//percorrer vetor vindo da view
							foreach($blusas as $index => $b){
								//verificar se a blusa está no banco existe na view 
								if($blusa->getBlusa()->getIdBlusa() == $b){
										//remover a blusa e quantidade vindo da view
										$blusas[$index] = 0;
										$quantidades[$index] = 0;
										break;
								}
							}
						}
					}
	
					//percorre vetor vindo da view com as novas cadastrados
					for($i = 0; $i < count($blusas); $i++){
						if($blusas[$i] != 0){
							$blusaEstoque = new BlusaEstoque();
	
							$blusa = $blusaDAO->buscarPorId($blusas[$i]);
							$quantidade = $blusa->getEstoque() + $quantidades[$i];
		
							$blusa->setEstoque($quantidade);
							$blusaDAO->salvar($blusa);
		
							$blusaEstoque->setBlusa($blusa);
							$blusaEstoque->setEstoque($estoque);
							$blusaEstoque->setQuantidade($quantidades[$i]);
							$blusaEstoqueDAO->salvar($blusaEstoque);
						}
					}
				}
	

			
			}
		
			if($resultado == 1){
				echo "<script>alert('Registro salvo com sucesso !!!'); location.href='../tabela/EstoqueTabela.php';</script>"; 
			}else{
				echo "<script>alert('Erro ao salvar o registro'); location.href='../formulario/EstoqueFormulario.php';</script>"; 			
			}	

            break; 

		case 'excluir':
			$blusaEstoques = $blusaEstoqueDAO->listarPorEntrada($_GET["idEstoque"]);

			//voltar quantidade excluida das blusas desse estoque(remessa)
			foreach ($blusaEstoques as $blusaEstoque) {
				$quantidade = $blusaEstoque->getBlusa()->getEstoque();
				$quantidade = $quantidade - $blusaEstoque->getQuantidade();

				$blusa = $blusaEstoque->getBlusa();
				$blusa->setEstoque($quantidade);

				$blusaDAO->salvar($blusa);		
			}
			
			$resultado1 = $blusaEstoqueDAO->excluirPorIdEstoque($_GET["idEstoque"]);
			$resultado2 = $estoqueDAO->excluirPorId($_GET["idEstoque"]);
			

			if($resultado1 && $resultado2){
				echo "<script>alert('Registro excluido com sucesso !!!'); location.href='../tabela/EstoqueTabela.php';</script>"; 
			}else{
				echo "<script>alert('Erro ao excluir o registro'); location.href='../tabela/EstoqueTabela.php';</script>"; 			
			}			
			break;    	
	}
			
?>