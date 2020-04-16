<?php	
	require_once 'CrudDAO.php';
	require_once 'Cliente.php';

	class ClienteDAO extends CrudDAO
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

				$sql = "INSERT INTO tbCliente(nmCliente, dtNasc, telefone, email, cpf, cnpj, tipo, endereco) 
                                VALUES (:nmCliente, :dtNasc, :telefone, :email, :cpf, :cnpj, :tipo, :endereco)";

				$run = $pdo->prepare($sql);
                $run->bindValue(':nmCliente', $cliente->getNome()); 
                $run->bindValue(':dtNasc', $cliente->getDataNascimento()); 
                $run->bindValue(':telefone', $cliente->getTelefone()); 
                $run->bindValue(':email', $cliente->getEmail()); 
                $run->bindValue(':cpf', $cliente->getCpf()); 
                $run->bindValue(':cnpj', $cliente->getCnpj()); 
                $run->bindValue(':tipo', $cliente->getTipoPessoa()); 
                $run->bindValue(':endereco', $cliente->getEndereco()); 
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
                
				$sql = "UPDATE tbCliente SET nmCliente = :nmCliente, dtNasc = :dtNasc, telefone = :telefone,
                email = :email, cpf = :cpf, cnpj = :cnpj, tipo = :tipo, endereco = :endereco WHERE idCliente = :idCliente";

                $run = $pdo->prepare($sql);
                $run->bindValue(':idCliente', $cliente->getIdCliente());
                $run->bindValue(':nmCliente', $cliente->getNome()); 
                $run->bindValue(':dtNasc', $cliente->getDataNascimento()); 
                $run->bindValue(':telefone', $cliente->getTelefone()); 
                $run->bindValue(':email', $cliente->getEmail()); 
                $run->bindValue(':cpf', $cliente->getCpf()); 
                $run->bindValue(':cnpj', $cliente->getCnpj()); 
                $run->bindValue(':tipo', $cliente->getTipoPessoa()); 
                $run->bindValue(':endereco', $cliente->getEndereco()); 				
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
					
				$sql = "DELETE FROM tbCliente WHERE idCliente = :idCliente";

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
					
				$sql = "DELETE FROM tbCliente WHERE idCliente = :idCliente";

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
					
				$sql = "SELECT * FROM tbCliente ORDER BY nmCliente";

				$run = $pdo->prepare($sql);			
				$run->execute(); 

				$resultado = $run->fetchAll();

				foreach ($resultado as $registro){
					$cliente = new Cliente();
					$cliente->setIdCliente($registro['idCliente']);
					$cliente->setNome($registro['nmCliente']);
					$cliente->setDataNascimento($registro['dtNasc']);
					$cliente->setTelefone($registro['telefone']);
					$cliente->setEmail($registro['email']);
					$cliente->setCpf($registro['cpf']);
					$cliente->setCnpj($registro['cnpj']);
					$cliente->setTipoPessoa($registro['tipo']);
					$cliente->setEndereco($registro['endereco']);
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

			$cliente = new Cliente();
						
			try{

				$pdo = parent::conectar();

				$sql = "SELECT * FROM tbCliente WHERE idCliente = :idCliente";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idCliente', $codigo);			
				$run->execute(); 

				$registro = $run->fetch();

				$cliente->setIdCliente($registro['idCliente']);
                $cliente->setNome($registro['nmCliente']);
                $cliente->setDataNascimento($registro['dtNasc']);
                $cliente->setTelefone($registro['telefone']);
                $cliente->setEmail($registro['email']);
                $cliente->setCpf($registro['cpf']);
                $cliente->setCnpj($registro['cnpj']);
                $cliente->setTipoPessoa($registro['tipo']);
                $cliente->setEndereco($registro['endereco']);

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}
			
			return $cliente;
		}
        
		public function filtrar($nmCliente, $dtNasc, $telefone, $email, $cpf, $cnpj, $tipo, $endereco){
			
			$objetos = array();	

			$cliente = new Cliente();						
			try{
				$pdo = parent::conectar();
				
				$sql = "SELECT * FROM tbCliente WHERE nmCliente LIKE :nmCliente AND dtNasc LIKE :dtNasc 
                AND telefone LIKE :telefone AND email LIKE :email AND cpf LIKE :cpf AND cnpj LIKE :cnpj 
                AND tipo LIKE :tipo AND endereco LIKE :endereco ORDER BY nmCliente";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':nmCliente', '%'.$nmCliente.'%');
	  			$run->bindValue(':dtNasc', '%'.$dtNasc.'%');
	  			$run->bindValue(':telefone', '%'.$telefone.'%');
	  			$run->bindValue(':email', '%'.$email.'%');
	  			$run->bindValue(':cpf', '%'.$cpf.'%');
	  			$run->bindValue(':cnpj', '%'.$cnpj.'%');
	  			$run->bindValue(':tipo', '%'.$tipo.'%');
	  			$run->bindValue(':endereco', '%'.$endereco.'%');
				
				$run->execute(); 
				$resultado = $run->fetchAll();

				foreach ($resultado as $registro){
					$cliente = new Cliente();
					$cliente->setIdCliente($registro['idCliente']);
                    $cliente->setNome($registro['nmCliente']);
                    $cliente->setDataNascimento($registro['dtNasc']);
                    $cliente->setTelefone($registro['telefone']);
                    $cliente->setEmail($registro['email']);
                    $cliente->setCpf($registro['cpf']);
                    $cliente->setCnpj($registro['cnpj']);
                    $cliente->setTipoPessoa($registro['tipo']);
                    $cliente->setEndereco($registro['endereco']);
					array_push($objetos, $cliente);
				}	

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}
			
			return $objetos;
		}	
		
		public function verificarCpf($codigo, $cpf){

			$situacao = TRUE;
			try{
				
				$pdo = Banco::conectar();	
					
				$sql = "SELECT * FROM tbCliente WHERE idCliente <> :idCliente AND cpf = :cpf";

				$run = $pdo->prepare($sql);
	  			$run->bindParam(':idCliente', $codigo);			
	  			$run->bindParam(':cpf', $cpf);	
				$run->execute(); 

				if($run->rowCount() > 0){
					$situacao = FALSE;
				}
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				Banco::desconectar();
			}			

			return $situacao;

		}
		public function verificarCnpj($codigo, $cnpj){

			$situacao = TRUE;
			try{
				
				$pdo = Banco::conectar();	
					
				$sql = "SELECT * FROM tbCliente WHERE idCliente <> :idCliente AND cnpj = :cnpj";

				$run = $pdo->prepare($sql);
	  			$run->bindParam(':idCliente', $codigo);			
	  			$run->bindParam(':cnpj', $cnpj);	
				$run->execute(); 

				if($run->rowCount() > 0){
					$situacao = FALSE;
				}
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				Banco::desconectar();
			}			

			return $situacao;

		}
		
	}
	
?> 