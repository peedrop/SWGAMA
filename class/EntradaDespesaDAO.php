<?php	
        require_once 'CrudDAO.php';
        
        require_once 'DespesaDAO.php';
        require_once 'Despesa.php';
        require_once 'FornecedorDAO.php';
        require_once 'Fornecedor.php';
        require_once 'InsumoDAO.php';
        require_once 'Insumo.php';

        require_once 'EntradaDespesa.php';

	class EntradaDespesaDAO extends CrudDAO
	{

		public function salvar($entradaDespesa){	
			$situacao = FALSE;
			try{
				
				if($entradaDespesa->getIdEntDespesa()==0){

					$situacao = $this->incluir($entradaDespesa);
				}else{	
					$situacao = $this->atualizar($entradaDespesa);
				}

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}			

			return $situacao;
		}

		public function incluir($entradaDespesa){	
			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	

				
				$sql = "INSERT INTO tbEntradaDespesa(valor, data, dataVencimento, idDespesa, idFornecedor, idInsumo) 
                                VALUES (:valor, :data, :dataVencimento, :idDespesa, :idFornecedor, :idInsumo)";

				$run = $pdo->prepare($sql);
                $run->bindValue(':valor', $entradaDespesa->getValor()); 
                $run->bindValue(':data', $entradaDespesa->getData()); 
                $run->bindValue(':dataVencimento', $entradaDespesa->getDataVencimento()); 
                $run->bindValue(':idDespesa', $entradaDespesa->getDespesa()->getIdDespesa()); 
                $run->bindValue(':idFornecedor', $entradaDespesa->getFornecedor()->getIdFornecedor()); 
                $run->bindValue(':idInsumo', $entradaDespesa->getInsumo()->getId()); 
				$run->execute(); 

				if($run->rowCount() > 0){
					$situacao = TRUE;
				}

				$entradaDespesa->setIdEntDespesa($pdo->lastInsertId());
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $situacao;
		}

		public function atualizar($entradaDespesa){	
			
			$situacao = FALSE;
			try{
                $pdo = parent::conectar();
				print_r($entradaDespesa);
				$sql = "UPDATE tbEntradaDespesa SET valor = :valor, data = :data, dataVencimento = :dataVencimento,
                idDespesa = :idDespesa, idFornecedor = :idFornecedor, idInsumo = :idInsumo WHERE idEntDespesa = :idEntDespesa";

                $run = $pdo->prepare($sql);
				$run->bindValue(':idEntDespesa', $entradaDespesa->getIdEntDespesa());
				$run->bindValue(':valor', $entradaDespesa->getValor()); 
                $run->bindValue(':data', $entradaDespesa->getData()); 
                $run->bindValue(':dataVencimento', $entradaDespesa->getDataVencimento()); 
                $run->bindValue(':idDespesa', $entradaDespesa->getDespesa()->getIdDespesa()); 
                $run->bindValue(':idFornecedor', $entradaDespesa->getFornecedor()->getIdFornecedor()); 
                $run->bindValue(':idInsumo', $entradaDespesa->getInsumo()->getId()); 				
				$run->execute(); 

				if($run->rowCount() > 0){
					$situacao = TRUE;
				}
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}			
		
			
			return $situacao;
		}						

		public function excluir($entradaDespesa){

			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	
					
				$sql = "DELETE FROM tbEntradaDespesa WHERE idEntDespesa = :idEntDespesa";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idEntDespesa', $entradaDespesa->getIdEntDespesa());			
				$run->execute(); 

				if($run->rowCount() > 0){
					$situacao = TRUE;
				}
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		
			return $situacao;
		}

		public function excluirPorId($codigo){

			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	
					
				$sql = "DELETE FROM tbEntradaDespesa WHERE idEntDespesa = :idEntDespesa";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idEntDespesa', $codigo);			
				$run->execute(); 

				if($run->rowCount() > 0){
					$situacao = TRUE;
				}
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}			

			return $situacao;

		}					

		public function listar(){

			$objetos = array();	

			try{
				
				$pdo = parent::conectar();
					
				$sql = "SELECT * FROM tbEntradaDespesa ORDER BY dataVencimento";

				$run = $pdo->prepare($sql);			
				$run->execute(); 

				$resultado = $run->fetchAll();

				foreach ($resultado as $registro){
					$entradaDespesa = new EntradaDespesa();

					$entradaDespesa->setIdEntDespesa($registro['idEntDespesa']);
                    $entradaDespesa->setValor($registro['valor']);
                    $entradaDespesa->setData($registro['data']);
					$entradaDespesa->setDataVencimento($registro['dataVencimento']);

					$despesaDAO = new DespesaDAO();
					$despesa = $despesaDAO->buscarPorId($registro['idDespesa']);
					$entradaDespesa->setDespesa($despesa);

					$fornecedorDAO = new FornecedorDAO();
					$fornecedor = $fornecedorDAO->buscarPorId($registro['idFornecedor']);
					$entradaDespesa->setFornecedor($fornecedor);

					$insumoDAO = new InsumoDAO();
					$insumo = $insumoDAO->buscarPorId($registro['idInsumo']);
					$entradaDespesa->setInsumo($insumo);

					array_push($objetos, $entradaDespesa);
				}	
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $objetos;

		}			
		
		public function buscarPorId($codigo){

			$entradaDespesa = new EntradaDespesa();
						
			try{

				$pdo = parent::conectar();

				$sql = "SELECT * FROM tbEntradaDespesa WHERE idEntDespesa = :idEntDespesa";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idEntDespesa', $codigo);			
				$run->execute(); 

				$registro = $run->fetch();

				$entradaDespesa->setIdEntDespesa($registro['idEntDespesa']);
                $entradaDespesa->setValor($registro['valor']);
                $entradaDespesa->setData($registro['data']);
                $entradaDespesa->setDataVencimento($registro['dataVencimento']);

                $despesaDAO = new DespesaDAO();
                $despesa = $despesaDAO->buscarPorId($registro['idDespesa']);
                $entradaDespesa->setDespesa($despesa);

                $fornecedorDAO = new FornecedorDAO();
                $fornecedor = $fornecedorDAO->buscarPorId($registro['idFornecedor']);
                $entradaDespesa->setFornecedor($fornecedor);

                $insumoDAO = new InsumoDAO();
                $insumo = $insumoDAO->buscarPorId($registro['idInsumo']);
                $entradaDespesa->setInsumo($insumo);

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}
			
			return $entradaDespesa;
		}
        
        /*
		public function filtrar($nome, $idGola, $idMalha, $idModoProd, $idTamanho, $valor){
			
			$objetos = array();	

			$entradaDespesa = new EntradaDespesa();						
			try{
				$pdo = parent::conectar();
				
				$sql = "SELECT * FROM tbEntradaDespesa 
				WHERE nome LIKE '%{$nome}%' 
				AND idGola = {$idGola} 
				AND idMalha = {$idMalha}
                AND idModoProd LIKE {$idModoProd} 
				AND idTamanho LIKE {$idTamanho }
				AND valor LIKE '%{$valor}%'
				ORDER BY nome";

				$run = $pdo->prepare($sql);			
				$run->execute(); 
				$resultado = $run->fetchAll();

				foreach ($resultado as $registro){
					$entradaDespesa = new EntradaDespesa();

					$entradaDespesa->setIdEntDespesa($registro['idEntDespesa']);
					$entradaDespesa->setNome($registro['nome']);
					$entradaDespesa->setValor($registro['valor']);
					$entradaDespesa->setEstoque($registro['qtdEstoque']);

					$golaDAO = new GolaDAO();
					$gola = $golaDAO->buscarPorId($registro['idGola']);
					$entradaDespesa->setGola($gola);

					$malhaDAO = new TipoMalhaDAO();
					$malha = $malhaDAO->buscarPorId($registro['idMalha']);
					$entradaDespesa->setMalha($malha);

					$tamanhoDAO = new TamanhoDAO();
					$tamanho = $tamanhoDAO->buscarPorId($registro['idTamanho']);
					$entradaDespesa->setTamanho($tamanho);

					$modoProdDAO = new ModoProdDAO();
					$modoProd = $modoProdDAO->buscarPorId($registro['idModoProd']);
					$entradaDespesa->setModoProd($modoProd);

					array_push($objetos, $entradaDespesa);
				}	

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}
			
			return $objetos;
		}	*/
	}
	
?> 