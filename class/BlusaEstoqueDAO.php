<?php	
	require_once 'CrudDAO.php';
	require_once 'EstoqueDAO.php';	
	require_once 'BlusaDAO.php';
	require_once 'BlusaEstoque.php';

	class BlusaEstoqueDAO extends CrudDAO
	{

		public function salvar($blusaEstoque){	
			$situacao = FALSE;
			try{
				
				if($blusaEstoque->getIdBlusaEstoque()==0){

					$situacao = $this->incluir($blusaEstoque);

				}else{	
					$situacao = $this->atualizar($blusaEstoque);
				}

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}			

			return $situacao;
		}

		public function incluir($blusaEstoque){	
			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	

				$sql = "INSERT INTO tbEstoque_tbBlusa(idEstoque, idBlusa, qtd) VALUES (:idEstoque, :idBlusa, :qtd)";
				
				$run = $pdo->prepare($sql);
				$run->bindValue(':idEstoque', $blusaEstoque->getEstoque()->getIdEstoque()); 
				$run->bindValue(':idBlusa', $blusaEstoque->getBlusa()->getIdBlusa()); 
				$run->bindValue(':qtd', $blusaEstoque->getQuantidade()); 
	  			$run->execute(); 

				if($run->rowCount() > 0){
					$situacao = TRUE;
				}

				$blusaEstoque->setIdBlusaEstoque($pdo->lastInsertId());
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $situacao;
		}

		public function atualizar($blusaEstoque){	
			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();
					
				$sql = "UPDATE tbEstoque_tbBlusa SET idEstoque = :idEstoque, idBlusa = :idBlusa, qtd = :qtd WHERE idBlusaEstoque = :idBlusaEstoque";
				
				$run = $pdo->prepare($sql);
				$run->bindValue(':idBlusaEstoque', $blusaEstoque->getIdBlusaEstoque()); 
				$run->bindValue(':idEstoque', $blusaEstoque->getEstoque()->getIdEstoque()); 
				$run->bindValue(':idBlusa', $blusaEstoque->getBlusa()->getIdBlusa()); 
				$run->bindValue(':qtd', $blusaEstoque->getQuantidade()); 
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

		public function excluir($blusaEstoque){

			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	
					
				$sql = "DELETE FROM tbEstoque_tbBlusa WHERE idBlusaEstoque = :idBlusaEstoque";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idBlusaEstoque', $blusaEstoque->getIdBlusaEstoque());			
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
					
				$sql = "DELETE FROM tbEstoque_tbBlusa WHERE idBlusaEstoque = :idBlusaEstoque";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idBlusaEstoque', $codigo);			
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
					
				$sql = "SELECT * FROM tbEstoque_tbBlusa";

				$run = $pdo->prepare($sql);			
				$run->execute(); 
				$resultado = $run->fetchAll();
				
				$estoqueDAO = new EstoqueDAO();
				$blusaDAO = new BlusaDAO();

				foreach ($resultado as $registro){

					$blusaEstoque = new BlusaEstoque();

					$blusaEstoque->setIdBlusaEstoque($registro['idBlusaEstoque']);

					$estoque = $estoqueDAO->buscarPorId($registro['idEstoque']);
					$blusaEstoque->setEstoque($estoque);					

					$blusa = $blusaDAO->buscarPorId($registro['idBlusa']);
					$blusaEstoque->setBlusa($blusa);		

					$blusaEstoque->setQuantidade($registro['qtd']);						
					array_push($objetos, $blusaEstoque);
				}	
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $objetos;

		}			
		
		public function buscarPorId($codigo){

			$blusa = new Blusa();
						
			try{

				$pdo = parent::conectar();

				$sql = "SELECT * FROM tbEstoque_tbBlusa WHERE idBlusaEstoque = :idBlusaEstoque";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idBlusaEstoque', $codigo);			
				$run->execute(); 
				$registro = $run->fetch();

				$estoqueDAO = new EstoqueDAO();
				$blusaDAO = new BlusaDAO();

				$blusaEstoque = new BlusaEstoque();

				$blusaEstoque->setIdBlusaEstoque($registro['idBlusaEstoque']);

				$estoque = $estoqueDAO->buscarPorId($registro['idEstoque']);
				$blusaEstoque->setEstoque($estoque);					

				$blusa = $blusaDAO->buscarPorId($registro['idBlusa']);
				$blusaEstoque->setBlusa($blusa);		

				$blusaEstoque->setQuantidade($registro['qtd']);	


			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}
			
			return $blusaEstoque;
		}		
		
        public function listarPorEntrada($codigo){

			$objetos = array();	

			try{
				
				$pdo = parent::conectar();
					
				$sql = "SELECT * FROM tbEstoque_tbBlusa WHERE idEstoque = :idEstoque; ";

				$run = $pdo->prepare($sql);	
				$run->bindValue(':idEstoque', $codigo);		


				$run->execute(); 
				$resultado = $run->fetchAll();
				
				$estoqueDAO = new EstoqueDAO();
				$blusaDAO = new BlusaDAO();

				foreach ($resultado as $registro){

					$blusaEstoque = new BlusaEstoque();

					$blusaEstoque->setIdBlusaEstoque($registro['idBlusaEstoque']);

					$estoque = $estoqueDAO->buscarPorId($registro['idEstoque']);
					$blusaEstoque->setEstoque($estoque);					

					$blusa = $blusaDAO->buscarPorId($registro['idBlusa']);
					$blusaEstoque->setBlusa($blusa);		

					$blusaEstoque->setQuantidade($registro['qtd']);						
					array_push($objetos, $blusaEstoque);
				}	
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $objetos;

		}	
		public function excluirPorIdEstoque($codigo){

			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	
					
				$sql = "DELETE FROM tbEstoque_tbBlusa WHERE idEstoque = :idEstoque";
				
				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idEstoque', $codigo);			
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
		public function excluirPorIdBlusaAndIdEstoque($idBlusa, $idEstoque){

			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	
					
				$sql = "DELETE FROM tbEstoque_tbBlusa WHERE idEstoque = :idEstoque AND idBlusa = :idBlusa;";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idEstoque', $idEstoque);			
	  			$run->bindValue(':idBlusa', $idBlusa);			
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

		public function buscarQuantidaPorIdBlusaAndIdEstoque($idBlusa, $idEstoque){

			$quantidade = 0;
						
			try{

				$pdo = parent::conectar();

				$sql = "SELECT qtd FROM tbEstoque_tbBlusa WHERE idEstoque = :idEstoque AND idBlusa = :idBlusa;";

				$run = $pdo->prepare($sql);
				$run->bindValue(':idEstoque', $idEstoque);			
				$run->bindValue(':idBlusa', $idBlusa);			
				$run->execute(); 
				$registro = $run->fetch();

				$quantidade = $registro['qtd'];

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}
			
			return $quantidade;
		}

	}
	
?>
