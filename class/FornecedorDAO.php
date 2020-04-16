<?php	
	require_once 'CrudDAO.php';
	require_once 'Fornecedor.php';

	class FornecedorDAO extends CrudDAO
	{

		public function salvar($fornecedor){	
			$situacao = FALSE;
			try{
				
				if($fornecedor->getIdFornecedor()==0){

					$situacao = $this->incluir($fornecedor);

				}else{	
					$situacao = $this->atualizar($fornecedor);
				}

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}			

			return $situacao;
		}

		public function incluir($fornecedor){	
			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	

				$sql = "INSERT INTO tbFornecedor(nmFornecedor, telefone, email, endereco) VALUES (:nmFornecedor, :telefone, :email, :endereco)";

				$run = $pdo->prepare($sql);
                $run->bindValue(':nmFornecedor', $fornecedor->getNome()); 
                $run->bindValue(':telefone', $fornecedor->getTelefone()); 
                $run->bindValue(':email', $fornecedor->getEmail()); 
                $run->bindValue(':endereco', $fornecedor->getEndereco()); 
	  			$run->execute(); 

				if($run->rowCount() > 0){
					$situacao = TRUE;
				}

				$fornecedor->setIdFornecedor($pdo->lastInsertId());
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $situacao;
		}

		public function atualizar($fornecedor){	
			
			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();
					
				$sql = "UPDATE tbFornecedor SET nmFornecedor = :nmFornecedor, telefone = :telefone, email = :email, endereco = :endereco WHERE idFornecedor = :idFornecedor";

				$run = $pdo->prepare($sql);
                $run->bindValue(':nmFornecedor', $fornecedor->getNome()); 
                $run->bindValue(':telefone', $fornecedor->getTelefone()); 
                $run->bindValue(':email', $fornecedor->getEmail()); 
                $run->bindValue(':endereco', $fornecedor->getEndereco());  
	  			$run->bindValue(':idFornecedor', $fornecedor->getIdFornecedor());				
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

		public function excluir($fornecedor){

			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	
					
				$sql = "DELETE FROM tbFornecedor WHERE idFornecedor = :idFornecedor";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idFornecedor', $fornecedor->getIdFornecedor());			
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
					
				$sql = "DELETE FROM tbFornecedor WHERE idFornecedor = :idFornecedor";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idFornecedor', $codigo);			
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
					
				$sql = "SELECT * FROM tbFornecedor ORDER BY nmFornecedor";

				$run = $pdo->prepare($sql);			
				$run->execute(); 

				$resultado = $run->fetchAll();

				foreach ($resultado as $registro){
					$fornecedor = new Fornecedor();
					$fornecedor->setIdFornecedor($registro['idFornecedor']);
					$fornecedor->setNome($registro['nmFornecedor']);
                    $fornecedor->setTelefone($registro['telefone']);
                    $fornecedor->setEmail($registro['email']);
					$fornecedor->setEndereco($registro['endereco']);
					array_push($objetos, $fornecedor);
				}	
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $objetos;

		}			
		
		public function buscarPorId($codigo){

			$fornecedor = new Fornecedor();
						
			try{

				$pdo = parent::conectar();

				$sql = "SELECT * FROM tbFornecedor WHERE idFornecedor = :idFornecedor";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idFornecedor', $codigo);			
				$run->execute(); 

				$registro = $run->fetch();

				$fornecedor->setIdFornecedor($registro['idFornecedor']);
				$fornecedor->setNome($registro['nmFornecedor']);
                $fornecedor->setTelefone($registro['telefone']);
                $fornecedor->setEmail($registro['email']);
                $fornecedor->setEndereco($registro['endereco']);

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}
			
			return $fornecedor;
		}

		public function filtrar($nmFornecedor, $telefone, $email, $endereco){
			
			$objetos = array();	

			$fornecedor = new Fornecedor();						
			try{
				$pdo = parent::conectar();
				
				$sql = "SELECT * FROM tbFornecedor WHERE nmFornecedor LIKE :nmFornecedor AND telefone LIKE :telefone AND email LIKE :email AND endereco LIKE :endereco ORDER BY fornecedor";
				$run = $pdo->prepare($sql);
	  			$run->bindValue(':nmFornecedor', '%'.$nmFornecedor.'%');
                $run->bindValue(':telefone', '%'.$telefone.'%');     
	  			$run->bindValue(':email', '%'.$email.'%');
	  			$run->bindValue(':endereco', '%'.$endereco.'%');
				
				$run->execute(); 
				$resultado = $run->fetchAll();

				foreach ($resultado as $registro){
					$fornecedor = new Fornecedor();
					$fornecedor->setIdFornecedor($registro['idFornecedor']);
                    $fornecedor->setNome($registro['nmFornecedor']);
                    $fornecedor->setTelefone($registro['telefone']);
                    $fornecedor->setEmail($registro['email']);
                    $fornecedor->setEndereco($registro['endereco']);
					array_push($objetos, $fornecedor);
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