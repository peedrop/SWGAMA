<?php	
	require_once 'CrudDAO.php';
	require_once 'Despesa.php';

	class DespesaDAO extends CrudDAO{

		public function salvar($despesa){	
			$situacao = FALSE;
			try{
				
				if($despesa->getIdDespesa()==0){

					$situacao = $this->incluir($despesa);

				}else{	
					$situacao = $this->atualizar($despesa);
				}

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}			

			return $situacao;
		}

		public function incluir($despesa){	
			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	

				$sql = "INSERT INTO TbDespesa(nmDespesa) VALUES (:nmDespesa)";

				$run = $pdo->prepare($sql);
				$run->bindValue(':nmDespesa', $despesa->getNome(), PDO::PARAM_STR); 
				$run->execute(); 

				if($run->rowCount() > 0){
					$situacao = TRUE;
				}

				$despesa->setIdDespesa($pdo->lastInsertId());
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $situacao;
		}

		public function atualizar($despesa){	
			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();
					
				$sql = "UPDATE TbDespesa SET nmDespesa = :nmDespesa WHERE idDespesa = :idDespesa";

				$run = $pdo->prepare($sql);
				$run->bindValue(':nmDespesa', $despesa->getNome()); 
				$run->bindValue(':idDespesa', $despesa->getIdDespesa());
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

		public function excluir($despesa){

			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	
					
				$sql = "DELETE FROM TbDespesa WHERE idDespesa = :idDespesa";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idDespesa', $despesa->getIdDespesa(), PDO::PARAM_INT);			
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
				
				$sql = "DELETE FROM TbDespesa WHERE idDespesa = :idDespesa";	

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idDespesa', $codigo, PDO::PARAM_INT);			
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
					
				$sql = "SELECT * FROM TbDespesa ORDER BY nmDespesa";

				$run = $pdo->prepare($sql);			
				$run->execute(); 
				$resultado = $run->fetchAll();

				foreach ($resultado as $objeto){

					$despesa = new Despesa();
					$despesa->setIdDespesa($objeto['idDespesa']);
                    $despesa->setNome($objeto['nmDespesa']);
                   array_push($objetos, $despesa);
				}	
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $objetos;

		}			
        
        
		public function buscarPorId($codigo){

			$despesa = new Despesa();
						
			try{

				$pdo = parent::conectar();

				$sql = "SELECT * FROM TbDespesa WHERE idDespesa = :idDespesa";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idDespesa', $codigo, PDO::PARAM_INT);			
				$run->execute(); 

				$resultado = $run->fetch();

				$despesa = new Despesa();
                $despesa->setIdDespesa($resultado['idDespesa']);
                $despesa->setNome($resultado['nmDespesa']);
        
                
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}
			
			return $despesa;
		}
		
		public function filtrar($nmDespesa){
			
			$objetos = array();	

			$desepesa = new Desepesa();						
			try{
				$pdo = parent::conectar();
				
				$sql = "SELECT * FROM tbDesepesa WHERE nmDespesa LIKE :nmDespesa ORDER BY nmDespesa";
				$run = $pdo->prepare($sql);
	  			$run->bindValue(':nmDespesa', '%'.$nmDespesa.'%');
				
				$run->execute(); 
				$resultado = $run->fetchAll();

				foreach ($resultado as $registro){
					$desepesa = new Desepesa();
					$desepesa->setIdDesepesa($registro['idDesepesa']);
					$desepesa->setNome($registro['nmDespesa']);
					array_push($objetos, $desepesa);
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
