<?php	
	require_once 'CrudDAO.php';
	require_once 'BlusaVenda.php';
	require_once 'BlusaDAO.php';
	require_once 'VendaDAO.php';

	class BlusaVendaDAO extends CrudDAO
	{

		public function salvar($blusaVenda){	
			$situacao = FALSE;
			try{
				
				if($blusaVenda->getIdBlusaVenda()==0){

					$situacao = $this->incluir($blusaVenda);

				}else{	
					$situacao = $this->atualizar($blusaVenda);
				}

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}			

			return $situacao;
        }
        
        
		public function incluir($blusaVenda){	
			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	

				$sql = "INSERT INTO tbBlusa_tbVenda(idBlusa, idVenda, valor, qtd, observacao)
                        VALUES (:idBlusa, :idVenda, :valor, :qtd, :observacao)";

				$run = $pdo->prepare($sql);
                $run->bindValue(':idBlusa', $blusaVenda->getBlusa()->getIdBlusa()); 
                $run->bindValue(':idVenda', $blusaVenda->getVenda()->getIdVenda()); 
                $run->bindValue(':valor', $blusaVenda->getValor()); 
                $run->bindValue(':qtd', $blusaVenda->getQtd()); 
                $run->bindValue(':observacao', $blusaVenda->getObservacao()); 
	  			$run->execute(); 

				if($run->rowCount() > 0){
					$situacao = TRUE;
				}

				$blusaVenda->setIdBlusaVenda($pdo->lastInsertId());
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $situacao;
		}

		public function atualizar($blusaVenda){	
			
			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();
					
				$sql = "UPDATE tbBlusa_tbVenda SET idBlusa = :idBlusa, idVenda = :idVenda, valor = :valor,
                        qtd = :qtd, observacao = :observacao
                        WHERE idBlusaVenda = :idBlusaVenda";

				$run = $pdo->prepare($sql);
                $run->bindValue(':idBlusaVenda', $blusaVenda->getIdBlusaVenda());
                
                $run->bindValue(':idBlusa', $blusaVenda->getBlusa()->getIdBlusa()); 
                $run->bindValue(':idVenda', $blusaVenda->getVenda()->getIdVenda()); 
                $run->bindValue(':valor', $blusaVenda->getValor()); 
                $run->bindValue(':qtd', $blusaVenda->getQtd()); 
                $run->bindValue(':observacao', $blusaVenda->getObservacao()); 
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

		public function excluir($blusaVenda){

			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	
					
				$sql = "DELETE FROM tbBlusa_tbVenda WHERE idBlusaVenda = :idBlusaVenda";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idBlusaVenda', $blusaVenda->getIdBlusaVenda());			
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
					
				$sql = "DELETE FROM tbBlusa_tbVenda WHERE idBlusaVenda = :idBlusaVenda";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idBlusaVenda', $codigo);			
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

		public function listarPorVenda($codigo){

			$objetos = array();	

			try{
				
				$pdo = parent::conectar();
					
				$sql = "SELECT * FROM tbBlusa_tbVenda WHERE idVenda = :idVenda; ";

				$run = $pdo->prepare($sql);	
				$run->bindValue(':idVenda', $codigo);		


				$run->execute(); 
				$resultado = $run->fetchAll();
				
				$vendaDAO = new VendaDAO();
				$blusaDAO = new BlusaDAO();

				foreach ($resultado as $registro){

					$blusaVenda = new BlusaVenda();

					$blusaVenda->setIdBlusaVenda($registro['idBlusaVenda']);

					$venda = $vendaDAO->buscarPorId($registro['idVenda']);
					$blusaVenda->setVenda($venda);					

					$blusa = $blusaDAO->buscarPorId($registro['idBlusa']);
					$blusaVenda->setBlusa($blusa);		

					$blusaVenda->setQtd($registro['qtd']);		
					$blusaVenda->setValor($registro['valor']);				
					$blusaVenda->setObservacao($registro['observacao']);
					array_push($objetos, $blusaVenda);
				}	
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $objetos;

		}

		public function listar(){

			$objetos = array();	

			try{
				
				$pdo = parent::conectar();
					
				$sql = "SELECT * FROM tbBlusa_tbVenda";

				$run = $pdo->prepare($sql);			
				$run->execute(); 

				$resultado = $run->fetchAll();

				foreach ($resultado as $registro){
					$blusaVenda = new BlusaVenda();
                    $blusaVenda->setIdBlusaVenda($registro['idBlusaVenda']);
                    
                    $blusaDAO = new BlusaDAO();
					$blusa = $blusaDAO->buscarPorId($registro['idBlusa']);
                    $blusaVenda->setBlusa($blusa);

                    $vendaDAO = new VendaDAO();
					$venda = $vendaDAO->buscarPorId($registro['idVenda']);
                    $blusaVenda->setVenda($venda);

					$blusaVenda->setValor($registro['valor']);
					$blusaVenda->setQtd($registro['qtd']);
					$blusaVenda->setObservacao($registro['observacao']);
                    
					array_push($objetos, $blusaVenda);
				}	
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $objetos;

		}			
		
		public function excluirPorIdVenda($codigo){

			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	
					
				$sql = "DELETE FROM tbBlusa_tbVenda WHERE idVenda = :idVenda";
				
				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idVenda', $codigo);			
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

		public function buscarPorId($codigo){

			$venda = new Venda();
						
			try{

				$pdo = parent::conectar();

				$sql = "SELECT * FROM tbBlusa_tbVenda WHERE idBlusaVenda = :idBlusaVenda";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idBlusaVenda', $codigo);			
				$run->execute(); 

				$registro = $run->fetch();

				$blusaVenda->setIdBlusaVenda($registro['idBlusaVenda']);
                
                $blusaDAO = new BlusaDAO();
                $blusa = $blusaDAO->buscarPorId($registro['idBlusa']);
                $blusaVenda->setBlusa($blusa);

                $vendaDAO = new VendaDAO();
                $venda = $vendaDAO->buscarPorId($registro['idVenda']);
                $blusaVenda->setVenda($venda);

                $blusaVenda->setValor($registro['valor']);
                $blusaVenda->setQtd($registro['qtd']);
                $blusaVenda->setObservacao($registro['observacao']);

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}
			
			return $blusaVenda;
		}

		public function filtrar(){
            return "Filtrar não está programado";
		}		
		
	}
	
?> 