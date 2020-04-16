<?php	
	require_once 'CrudDAO.php';
	require_once 'Tamanho.php';

	class TamanhoDAO extends CrudDAO
	{

		public function salvar($tamanho){	
			$situacao = FALSE;
			try{
				
				if($tamanho->getIdTamanho()==0){

					$situacao = $this->incluir($tamanho);

				}else{	
					$situacao = $this->atualizar($tamanho);
				}

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}			

			return $situacao;
		}

		public function incluir($tamanho){	
			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	

				$sql = "INSERT INTO tbTamanho(tamanho, altura, largura) VALUES (:tamanho, :altura, :largura)";

				$run = $pdo->prepare($sql);
                $run->bindValue(':tamanho', $tamanho->getTamanho()); 
                $run->bindValue(':altura', $tamanho->getAltura()); 
                $run->bindValue(':largura', $tamanho->getLargura()); 
	  			$run->execute(); 

				if($run->rowCount() > 0){
					$situacao = TRUE;
				}

				$tamanho->setIdTamanho($pdo->lastInsertId());
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $situacao;
		}

		public function atualizar($tamanho){	
			
			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();
					
				$sql = "UPDATE tbTamanho SET tamanho = :tamanho, altura = :altura, largura = :largura WHERE idTamanho = :idTamanho";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':tamanho', $tamanho->getTamanho());
	  			$run->bindValue(':altura', $tamanho->getAltura());
	  			$run->bindValue(':largura', $tamanho->getLargura());
	  			$run->bindValue(':idTamanho', $tamanho->getIdTamanho());				
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

		public function excluir($tamanho){

			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	
					
				$sql = "DELETE FROM tbTamanho WHERE idTamanho = :idTamanho";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idTamanho', $tamanho->getIdTamanho());			
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
					
				$sql = "DELETE FROM tbTamanho WHERE idTamanho = :idTamanho";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idTamanho', $codigo);			
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
					
				$sql = "SELECT * FROM tbTamanho ORDER BY tamanho";

				$run = $pdo->prepare($sql);			
				$run->execute(); 

				$resultado = $run->fetchAll();

				foreach ($resultado as $registro){
					$tamanho = new Tamanho();
					$tamanho->setIdTamanho($registro['idTamanho']);
					$tamanho->setTamanho($registro['tamanho']);
                    $tamanho->setAltura($registro['altura']);
					$tamanho->setLargura($registro['largura']);
					array_push($objetos, $tamanho);
				}	
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $objetos;

		}			
		
		public function buscarPorId($codigo){

			$tamanho = new Tamanho();
						
			try{

				$pdo = parent::conectar();

				$sql = "SELECT * FROM tbTamanho WHERE idTamanho = :idTamanho";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idTamanho', $codigo);			
				$run->execute(); 

				$registro = $run->fetch();

				$tamanho->setIdTamanho($registro['idTamanho']);
				$tamanho->setTamanho($registro['tamanho']);
				$tamanho->setAltura($registro['altura']);
				$tamanho->setLargura($registro['largura']);

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}
			
			return $tamanho;
		}

		public function filtrar($tamanho, $altura, $largura){
			
			$objetos = array();	

			$tamanho = new Tamanho();						
			try{
				$pdo = parent::conectar();
				
				$sql = "SELECT * FROM tbTamanho WHERE tamanho LIKE :tamanho AND altura LIKE :altura AND largura LIKE :largura ORDER BY tamanho";
				$run = $pdo->prepare($sql);
	  			$run->bindValue(':tamanho', '%'.$tamanho.'%');
                $run->bindValue(':altura', '%'.$altura.'%');     
	  			$run->bindValue(':largura', '%'.$largura.'%');
				
				$run->execute(); 
				$resultado = $run->fetchAll();

				foreach ($resultado as $registro){
					$tamanho = new Tamanho();
					$tamanho->setIdTamanho($registro['idTamanho']);
					$tamanho->setTamanho($registro['tamanho']);
					$tamanho->setAltura($registro['altura']);
					$tamanho->setLargura($registro['largura']);
					array_push($objetos, $tamanho);
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