<?php	
	require_once 'CrudDAO.php';
	require_once 'Gola.php';

	class GolaDAO extends CrudDAO
	{

		public function salvar($gola){	
			$situacao = FALSE;
			try{
				
				if($gola->getIdGola()==0){

					$situacao = $this->incluir($gola);

				}else{	
					$situacao = $this->atualizar($gola);
				}

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}			

			return $situacao;
		}

		public function incluir($gola){	
			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	

				$sql = "INSERT INTO tbGola(nmGola) VALUES (:nmGola)";

				$run = $pdo->prepare($sql);
                $run->bindValue(':nmGola', $gola->getNome()); 
	  			$run->execute(); 

				if($run->rowCount() > 0){
					$situacao = TRUE;
				}

				$gola->setIdGola($pdo->lastInsertId());
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $situacao;
		}

		public function atualizar($gola){	
			
			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();
					
				$sql = "UPDATE tbGola SET nmGola = :nmGola WHERE idGola = :idGola";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':nmGola', $gola->getNome());
	  			$run->bindValue(':idGola', $gola->getIdGola());				
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

		public function excluir($gola){

			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	
					
				$sql = "DELETE FROM tbGola WHERE idGola = :idGola";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idGola', $gola->getIdGola());			
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
					
				$sql = "DELETE FROM tbGola WHERE idGola = :idGola";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idGola', $codigo);			
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
					
				$sql = "SELECT * FROM tbGola ORDER BY nmGola";

				$run = $pdo->prepare($sql);			
				$run->execute(); 

				$resultado = $run->fetchAll();

				foreach ($resultado as $registro){
					$gola = new Gola();
					$gola->setIdGola($registro['idGola']);
					$gola->setNome($registro['nmGola']);
					array_push($objetos, $gola);
				}	
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $objetos;

		}			
		
		public function buscarPorId($codigo){

			$gola = new Gola();
						
			try{

				$pdo = parent::conectar();

				$sql = "SELECT * FROM tbGola WHERE idGola = :idGola";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idGola', $codigo);			
				$run->execute(); 

				$registro = $run->fetch();

				$gola->setIdGola($registro['idGola']);
				$gola->setNome($registro['nmGola']);

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}
			
			return $gola;
		}

		public function filtrar($nmGola){
			
			$objetos = array();	

			$gola = new Gola();						
			try{
				$pdo = parent::conectar();
				
				$sql = "SELECT * FROM tbGola WHERE nmGola LIKE :nmGola  ORDER BY nmGola";
				$run = $pdo->prepare($sql);
	  			$run->bindValue(':nmGola', '%'.$nmGola.'%');
				
				$run->execute(); 
				$resultado = $run->fetchAll();

				foreach ($resultado as $registro){
					$gola = new gola();
					$gola->setIdGola($registro['idGola']);
					$gola->setNome($registro['nmGola']);
					array_push($objetos, $gola);
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