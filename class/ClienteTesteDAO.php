<?php	
	require_once 'CrudDAO.php';
	require_once 'ClienteTeste.php';

	class ClienteTesteDAO extends CrudDAO
	{

		public function salvar($cliente){	
			$situacao = FALSE;
			try{
				
				if($cliente->getIdCliente()==0){

					$situacao = $this->incluir($cliente);

				}else{	
					$situacao = $this->atualizar($cliente);
				}

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}			

			return $situacao;
		}

		public function incluir($cliente){	
			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	

				$sql = "INSERT INTO tbClienteTeste(nome, idade) VALUES (:nome, :idade)";

				$run = $pdo->prepare($sql);
                $run->bindValue(':nome', $cliente->getNome()); 
                $run->bindValue(':idade', $cliente->getIdade()); 
	  			$run->execute(); 

				if($run->rowCount() > 0){
					$situacao = TRUE;
				}

				$cliente->setIdCliente($pdo->lastInsertId());
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $situacao;
		}

		public function atualizar($cliente){	
			
			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();
					
				$sql = "UPDATE tbClienteTeste SET nome = :nome, idade = :idade WHERE idCliente = :idCliente";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':nome', $cliente->getNome());
	  			$run->bindValue(':idade', $cliente->getIdade());
	  			$run->bindValue(':idCliente', $cliente->getIdCliente());				
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

		public function excluir($cliente){

			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	
					
				$sql = "DELETE FROM tbClienteTeste WHERE idCliente = :idCliente";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idCliente', $cliente->getIdCliente());			
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
					
				$sql = "DELETE FROM tbClienteTeste WHERE idCliente = :idCliente";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idCliente', $codigo);			
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
					
				$sql = "SELECT * FROM tbClienteTeste ORDER BY nome";

				$run = $pdo->prepare($sql);			
				$run->execute(); 

				$resultado = $run->fetchAll();

				foreach ($resultado as $registro){
					$cliente = new ClienteTeste();
					$cliente->setIdCliente($registro['idCliente']);
					$cliente->setNome($registro['nome']);
					$cliente->setIdade($registro['idade']);
					array_push($objetos, $cliente);
				}	
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $objetos;

		}			
		
		public function buscarPorId($codigo){

			$cliente = new ClienteTeste();
						
			try{

				$pdo = parent::conectar();

				$sql = "SELECT * FROM tbClienteTeste WHERE idCliente = :idCliente";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idCliente', $codigo);			
				$run->execute(); 

				$registro = $run->fetch();

				$cliente->setIdCliente($registro['idCliente']);
				$cliente->setNome($registro['nome']);
				$cliente->setIdade($registro['idade']);

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}
			
			return $cliente;
		}

		public function filtrar($nome, $idade){
			
			$objetos = array();	

			$cliente = new ClienteTeste();						
			try{
				$pdo = parent::conectar();
				
				$sql = "SELECT * FROM tbClienteTeste WHERE nome LIKE :nome AND idade LIKE :idade ORDER BY nome";
				$run = $pdo->prepare($sql);
	  			$run->bindValue(':nome', '%'.$nome.'%');
	  			$run->bindValue(':idade', '%'.$idade.'%');
				
				$run->execute(); 
				$resultado = $run->fetchAll();

				foreach ($resultado as $registro){
					$cliente = new ClienteTeste();
					$cliente->setIdCliente($registro['idCliente']);
					$cliente->setNome($registro['nome']);
					$cliente->setIdade($registro['idade']);
					array_push($objetos, $cliente);
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