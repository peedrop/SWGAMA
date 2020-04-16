<?php	
	require_once 'CrudDAO.php';
	require_once 'TipoMalha.php';

	class TipoMalhaDAO extends CrudDAO
	{

		public function salvar($tipoMalha){	
			$situacao = FALSE;
			try{
				
				if($tipoMalha->getIdMalha()==0){

					$situacao = $this->incluir($tipoMalha);

				}else{	
					$situacao = $this->atualizar($tipoMalha);
				}

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}			

			return $situacao;
		}

		public function incluir($tipoMalha){	
			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	

				$sql = "INSERT INTO tbMalha(nmMalha) VALUES (:nmMalha)";

				$run = $pdo->prepare($sql);
                $run->bindValue(':nmMalha', $tipoMalha->getNome()); 
	  			$run->execute(); 

				if($run->rowCount() > 0){
					$situacao = TRUE;
				}

				$tipoMalha->setIdMalha($pdo->lastInsertId());
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $situacao;
		}

		public function atualizar($tipoMalha){	
			
			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();
					
				$sql = "UPDATE tbMalha SET nmMalha = :nmMalha WHERE idMalha = :idMalha";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':nmMalha', $tipoMalha->getNome());
	  			$run->bindValue(':idMalha', $tipoMalha->getIdMalha());				
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

		public function excluir($tipoMalha){

			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	
					
				$sql = "DELETE FROM tbMalha WHERE idMalha = :idMalha";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idMalha', $tipoMalha->getIdMalha());			
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
					
				$sql = "DELETE FROM tbMalha WHERE idMalha = :idMalha";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idMalha', $codigo);			
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
					
				$sql = "SELECT * FROM tbMalha ORDER BY nmMalha";

				$run = $pdo->prepare($sql);			
				$run->execute(); 

				$resultado = $run->fetchAll();

				foreach ($resultado as $registro){
					$tipoMalha = new TipoMalha();
					$tipoMalha->setIdMalha($registro['idMalha']);
					$tipoMalha->setNome($registro['nmMalha']);
					array_push($objetos, $tipoMalha);
				}	
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $objetos;

		}			
		
		public function buscarPorId($codigo){

			$tipoMalha = new TipoMalha();
						
			try{

				$pdo = parent::conectar();

				$sql = "SELECT * FROM tbMalha WHERE idMalha = :idMalha";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idMalha', $codigo);			
				$run->execute(); 

				$registro = $run->fetch();

				$tipoMalha->setIdMalha($registro['idMalha']);
				$tipoMalha->setNome($registro['nmMalha']);

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}
			
			return $tipoMalha;
		}

		public function filtrar($nmMalha){
			
			$objetos = array();	

			$tipoMalha = new TipoMalha();						
			try{
				$pdo = parent::conectar();
				
				$sql = "SELECT * FROM tbMalha WHERE nmMalha LIKE :nmMalha ORDER BY nmMalha";
				$run = $pdo->prepare($sql);
	  			$run->bindValue(':nmMalha', '%'.$nmMalha.'%');
				
				$run->execute(); 
				$resultado = $run->fetchAll();

				foreach ($resultado as $registro){
					$tipoMalha = new TipoMalha();
					$tipoMalha->setIdMalha($registro['idMalha']);
					$tipoMalha->setNome($registro['nmMalha']);
					array_push($objetos, $tipoMalha);
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