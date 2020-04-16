<?php	
		require_once 'CrudDAO.php';
        require_once 'Estoque.php';

	class EstoqueDAO extends CrudDAO
	{

		public function salvar($estoque){	
			$situacao = FALSE;
			try{
				
				if($estoque->getIdEstoque()==0){

					$situacao = $this->incluir($estoque);
				}else{	
					$situacao = $this->atualizar($estoque);
				}

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}			

			return $situacao;
		}

		public function incluir($estoque){	
			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	

				
				$sql = "INSERT INTO tbEstoque(data, tipo) 
                                VALUES (:data, :tipo)";

				$run = $pdo->prepare($sql);
                $run->bindValue(':data', $estoque->getData()); 
                $run->bindValue(':tipo', $estoque->getTipo()); 
				$run->execute(); 

				if($run->rowCount() > 0){
					$situacao = TRUE;
				}

				$estoque->setIdEstoque($pdo->lastInsertId());
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $situacao;
		}

		public function atualizar($estoque){	
			
			$situacao = FALSE;
			try{
                $pdo = parent::conectar();
				print_r($estoque);
				$sql = "UPDATE tbEstoque SET data = :data, tipo = :tipo WHERE idEstoque = :idEstoque";

                $run = $pdo->prepare($sql);
				$run->bindValue(':idEstoque', $estoque->getIdEstoque());
				$run->bindValue(':data', $estoque->getData()); 
                $run->bindValue(':tipo', $estoque->getTipo()); 				
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

		public function excluir($estoque){

			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	
					
				$sql = "DELETE FROM tbEstoque WHERE idEstoque = :idEstoque";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idEstoque', $estoque->getIdEstoque());			
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
					
				$sql = "DELETE FROM tbEstoque WHERE idEstoque = :idEstoque";

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

		public function listar(){

			$objetos = array();	

			try{
				
				$pdo = parent::conectar();
					
				$sql = "SELECT * FROM tbEstoque ORDER BY data";

				$run = $pdo->prepare($sql);			
				$run->execute(); 

				$resultado = $run->fetchAll();

				foreach ($resultado as $registro){
					$estoque = new Estoque();

					$estoque->setIdEstoque($registro['idEstoque']);
					$estoque->setData($registro['data']);
					$estoque->setTipo($registro['tipo']);

					array_push($objetos, $estoque);
				}	
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $objetos;

		}			
		
		public function buscarPorId($codigo){

			$estoque = new Estoque();
						
			try{

				$pdo = parent::conectar();

				$sql = "SELECT * FROM tbEstoque WHERE idEstoque = :idEstoque";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idEstoque', $codigo);			
				$run->execute(); 

				$registro = $run->fetch();

				$estoque->setIdEstoque($registro['idEstoque']);
				$estoque->setData($registro['data']);
				$estoque->setTipo($registro['tipo']);

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}
			
			return $estoque;
		}

	}
	
?> 