<?php

    require_once '../class/VendaDAO.php';
    require_once '../class/BlusaDAO.php';
    require_once '../class/BlusaVendaDAO.php';
    require_once '../class/ClienteDAO.php';

    require_once '../class/GolaDAO.php';
    require_once '../class/ModoProdDAO.php';
    require_once '../class/TamanhoDAO.php';
    require_once '../class/TipoMalhaDAO.php';

    
	$golaDAO = new GolaDAO();
	$modoProdDAO = new ModoProdDAO();
	$tamanhoDAO = new TamanhoDAO();
    $malhaDAO = new TipoMalhaDAO();
    
    $venda = new Venda();
	$vendaDAO = new VendaDAO();
	$blusaDAO = new BlusaDAO();
    $blusaVendaDAO = new BlusaVendaDAO();
    $clienteDAO = new ClienteDAO();

	$operacao = $_GET["operacao"];

	switch($operacao) 
	{
        case 'salvar':
            // DADOS VENDA

            //idVenda
            if(isset($_POST["idVenda"])){
                $venda->setIdVenda($_POST["idVenda"]);
            }
            //idCliente
            if(isset($_POST["idCliente"])){
                $cliente = $clienteDAO->buscarPorId($_POST["idCliente"]);
                $venda->setCliente($cliente);
            }
            //valorTotal
            if(isset($_POST["valorTotal"])){
                $venda->setValorTotal($_POST["valorTotal"]);
            }
            //desconto
            if(isset($_POST["desconto"])){
                $venda->setDesconto($_POST["desconto"]);
            }
            //tipo
            if(isset($_POST["tipo"])){
                $venda->setTipo($_POST["tipo"]);
            }
            //observacao
            if(isset($_POST["observacao"])){
                $venda->setObservacao($_POST["observacao"]);
            }
            date_default_timezone_set('America/Sao_Paulo');
            $venda->setDataHora(date('Y-m-d H:i:s'));

            $idVenda = $vendaDAO->proximoId();
            $resultado = $vendaDAO->salvar($venda);
            // DADOS BLUSAS
            if(isset($_COOKIE["blusas"])){
                $blusas = json_decode($_COOKIE["blusas"]);
                foreach ($blusas as &$value) {
                    $value = json_decode($value);
                }
                foreach ($blusas as &$reg) {
                    if($reg->idBlusa == '0'){
                        $blusa = new Blusa();
                        $blusa->setIdBlusa = 0;
                        $gola = $golaDAO->buscarPorId($reg->gola);
                        $modoProd = $modoProdDAO->buscarPorId($reg->producao);
                        $tamanho = $tamanhoDAO->buscarPorId($reg->tamanho);
                        $malha = $malhaDAO->buscarPorId($reg->malha);
                        $blusa->setGola($gola);
                        $blusa->setMalha($malha);
                        $blusa->setNome($reg->nome);
                        $blusa->setTamanho($tamanho);
                        $blusa->setValor($reg->valor);
                        $blusa->setModoProd($modoProd);
                        $blusa->setEstoque($reg->qtd);
                        $blusa->setStatus($reg->status);
                        $blusaDAO->salvar($blusa);

                        $blusaVenda = new BlusaVenda();
                        $blusaSalva = $blusaDAO->buscarPorId($blusaDAO->proximoId()-1);
                        $blusaVenda->setBlusa($blusaSalva);
                        $venda = $vendaDAO->buscarPorId($idVenda);
                        $blusaVenda->setVenda($venda);
                        $blusaVenda->setValor($blusa->getValor());
                        $blusaVenda->setQtd($reg->qtd);
                        $blusaVenda->setObservacao($reg->comentario);
                        $resultado1 = $blusaVendaDAO->salvar($blusaVenda);

                    } else{
                        $blusaVenda = new BlusaVenda();
                        $blusa = $blusaDAO->buscarPorId($reg->idBlusa);
                        $blusaVenda->setBlusa($blusa);
                        $venda = $vendaDAO->buscarPorId($idVenda);
                        $blusaVenda->setVenda($venda);
                        $blusaVenda->setValor($blusa->getValor());
                        $blusaVenda->setQtd($reg->qtd);
                        $resultado1 = $blusaVendaDAO->salvar($blusaVenda);
                    }

                }
            }
            		
            if($resultado1 == TRUE){
				echo "<script>location.href='../formulario/VendaFormulario.php?resultado=sucesso';</script>"; 
			}else{
				echo "<script>location.href='../formulario/VendaFormulario.php?resultado=erro';</script>"; 			
			}
			
        	break; 

        case 'excluir':
            $blusaVendas = $blusaVendaDAO->listarPorVenda($_GET["idVenda"]);

            foreach ($blusaVendas as $blusaVenda) {
				$quantidade = $blusaVenda->getBlusa()->getEstoque();
				$quantidade = $quantidade - $blusaVenda->getQuantidade();

				$blusa = $blusaVenda->getBlusa();
				$blusa->setEstoque($quantidade);

				$blusaDAO->salvar($blusa);		
            }
            
            $resultado1 = $blusaVendaDAO->excluirPorIdVenda($_GET["idVenda"]);
			$resultado2 = $vendaDAO->excluirPorId($_GET["idVenda"]);

			if($resultado1 == 1 && $resultado2 == 1){
				echo "<script>alert('Registro excluido com sucesso !!!'); location.href='../tabela/VendaTabela.php';</script>"; 
			}else{
				echo "<script>alert('Erro ao excluir o registro'); location.href='../tabela/VendaTabela.php';</script>"; 			
			}			
        	break;         	
	}
			
?>