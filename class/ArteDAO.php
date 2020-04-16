<?php	
	require_once 'CrudDAO.php';
	require_once 'Arte.php';

	class ArteDAO extends CrudDAO
	{

		public function salvar($arte){	
			$situacao = FALSE;
			try{
				
				if($arte->getIdArte()==0){

					$situacao = $this->incluir($arte);

				}else{	
					$situacao = $this->atualizar($arte);
				}

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}			

			return $situacao;
		}

		public function incluir($arte){	
			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	

				$sql = "INSERT INTO tbArte(nmArte) VALUES (:nmArte)";

				$run = $pdo->prepare($sql);
                $run->bindValue(':nmArte', $arte->getImagem()); 
	  			$run->execute(); 

				if($run->rowCount() > 0){
					$situacao = TRUE;
				}

				$arte->setIdArte($pdo->lastInsertId());
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $situacao;
		}

		public function atualizar($arte){	
			
			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();
					
				$sql = "UPDATE tbArte SET nmArte = :nmArte WHERE idArte = :idArte";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':nmArte', $arte->getImagem());
	  			$run->bindValue(':idArte', $arte->getIdArte());				
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

		public function excluir($arte){

			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	
					
				$sql = "DELETE FROM tbArte WHERE idArte = :idArte";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idArte', $arte->getIdArte());			
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
					
				$sql = "DELETE FROM tbArte WHERE idArte = :idArte";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idArte', $codigo);			
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
					
				$sql = "SELECT * FROM tbArte ORDER BY nmArte";

				$run = $pdo->prepare($sql);			
				$run->execute(); 

				$resultado = $run->fetchAll();

				foreach ($resultado as $registro){
					$arte = new Arte();
					$arte->setIdArte($registro['idArte']);
					$arte->setImagem($registro['nmArte']);
					array_push($objetos, $arte);
				}	
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $objetos;

		}			
		
		public function buscarPorId($codigo){

			$arte = new Arte();
						
			try{

				$pdo = parent::conectar();

				$sql = "SELECT * FROM tbArte WHERE idArte = :idArte";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idArte', $codigo);			
				$run->execute(); 

				$registro = $run->fetch();

				$arte->setIdArte($registro['idArte']);
				$arte->setImagem($registro['nmArte']);

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}
			
			return $arte;
		}

		public function filtrar($imagem){
			
			$objetos = array();	

			$arte = new Arte();						
			try{
				$pdo = parent::conectar();
				
				$sql = "SELECT * FROM tbArte WHERE nmArte LIKE :nmArte ORDER BY nmArte";
				$run = $pdo->prepare($sql);
	  			$run->bindValue(':nmArte', '%'.$imagem.'%');
				
				$run->execute(); 
				$resultado = $run->fetchAll();

				foreach ($resultado as $registro){
					$arte = new Arte();
					$arte->setIdArte($registro['idArte']);
					$arte->setImagem($registro['nmArte']);
					array_push($objetos, $arte);
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