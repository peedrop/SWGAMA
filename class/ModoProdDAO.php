<?php	
	require_once 'CrudDAO.php';
	require_once 'ModoProd.php';

	class ModoProdDAO extends CrudDAO
	{

		public function salvar($modoProd){	
			$situacao = FALSE;
			try{
				
				if($modoProd->getIdModoProd()==0){

					$situacao = $this->incluir($modoProd);

				}else{	
					$situacao = $this->atualizar($modoProd);
				}

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}			

			return $situacao;
		}

		public function incluir($modoProd){	
			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	

				$sql = "INSERT INTO tbModoProd(nmModoProd) VALUES (:nmModoProd)";

				$run = $pdo->prepare($sql);
                $run->bindValue(':nmModoProd', $modoProd->getNome()); 
	  			$run->execute(); 

				if($run->rowCount() > 0){
					$situacao = TRUE;
				}

				$modoProd->setIdModoProd($pdo->lastInsertId());
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $situacao;
		}

		public function atualizar($modoProd){	
			
			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();
					
				$sql = "UPDATE tbModoProd SET nmModoProd = :nmModoProd WHERE idModoProd = :idModoProd";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':nmModoProd', $modoProd->getNome());
	  			$run->bindValue(':idModoProd', $modoProd->getIdModoProd());				
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

		public function excluir($modoProd){

			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	
					
				$sql = "DELETE FROM tbModoProd WHERE idModoProd = :idModoProd";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idModoProd', $modoProd->getIdModoProd());			
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
					
				$sql = "DELETE FROM tbModoProd WHERE idModoProd = :idModoProd";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idModoProd', $codigo);			
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
					
				$sql = "SELECT * FROM tbModoProd ORDER BY nmModoProd";

				$run = $pdo->prepare($sql);			
				$run->execute(); 

				$resultado = $run->fetchAll();

				foreach ($resultado as $registro){
					$modoProd = new ModoProd();
					$modoProd->setIdModoProd($registro['idModoProd']);
					$modoProd->setNome($registro['nmModoProd']);
					array_push($objetos, $modoProd);
				}	
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $objetos;

		}			
		
		public function buscarPorId($codigo){

			$modoProd = new ModoProd();
						
			try{

				$pdo = parent::conectar();

				$sql = "SELECT * FROM tbModoProd WHERE idModoProd = :idModoProd";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idModoProd', $codigo);			
				$run->execute(); 

				$registro = $run->fetch();

				$modoProd->setIdModoProd($registro['idModoProd']);
				$modoProd->setNome($registro['nmModoProd']);

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}
			
			return $modoProd;
		}

		public function filtrar($nmModoProd){
			
			$objetos = array();	

			$modoProd = new ModoProd();						
			try{
				$pdo = parent::conectar();
				
				$sql = "SELECT * FROM tbModoProd WHERE nmModoProd LIKE :nmModoProd ORDER BY nmModoProd";
				$run = $pdo->prepare($sql);
	  			$run->bindValue(':nmModoProd', '%'.$nmModoProd.'%');
				
				$run->execute(); 
				$resultado = $run->fetchAll();

				foreach ($resultado as $registro){
					$modoProd = new ModoProd();
					$modoProd->setIdModoProd($registro['idModoProd']);
					$modoProd->setNome($registro['nmModoProd']);
					array_push($objetos, $modoProd);
				}	

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}
			
			return $objetos;
		}		
		
	}
	
?> 