<?php	
	require_once 'CrudDAO.php';
	require_once 'Funcionario.php';

	class FuncionarioDAO extends CrudDAO
	{

		public function salvar($funcionario){	
			$situacao = FALSE;
			try{
				
				if($funcionario->getIdFuncionario()==0){

					$situacao = $this->incluir($funcionario);

				}else{	
					$situacao = $this->atualizar($funcionario);
				}

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}			

			return $situacao;
		}

		public function incluir($funcionario){	
			$situacao = FALSE;
			try{
			
				$pdo = parent::conectar();	

				$sql = "INSERT INTO tbFuncionario(nmFuncionario, cpf, telefone, dtNasc, sexo, email, salario, dtPagamento,
				endereco, tipo, idUsuario) VALUES (:nmFuncionario, :cpf, :telefone, :dtNasc, :sexo, :email, :salario, 
				:dtPagamento, :endereco, :tipo, :idUsuario)";

				$run = $pdo->prepare($sql);
				$run->bindValue(':nmFuncionario', $funcionario->getNome()); 
				$run->bindValue(':cpf', $funcionario->getCpf()); 
				$run->bindValue(':telefone', $funcionario->getTelefone()); 
				$run->bindValue(':dtNasc', $funcionario->getDataNascimento()); 
				$run->bindValue(':sexo', $funcionario->getSexo()); 
				$run->bindValue(':email', $funcionario->getEmail()); 
				$run->bindValue(':salario', $funcionario->getSalario()); 
				$run->bindValue(':dtPagamento', $funcionario->getDataPag()); 
				$run->bindValue(':endereco', $funcionario->getEndereco()); 
				$run->bindValue(':tipo', $funcionario->getTipo());
				$run->bindValue(':idUsuario', $funcionario->getUsuario());
				
				
	  			$run->execute(); 

				if($run->rowCount() > 0){
					$situacao = TRUE;
				}

				$funcionario->setIdfuncionario($pdo->lastInsertId());
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $situacao;
		}

		public function atualizar($funcionario){	
			
			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();

				$sql = "UPDATE tbFuncionario SET nmFuncionario = :nmFuncionario, cpf = :cpf, telefone = :telefone,
				dtNasc = :dtNasc, sexo = :sexo, email = :email, salario = :salario, dtPagamento = :dtPagamento,
				endereco = :endereco, tipo = :tipo WHERE idFuncionario = :idFuncionario";

				$run = $pdo->prepare($sql);
				$run->bindValue(':nmFuncionario', $funcionario->getNome()); 
				$run->bindValue(':cpf', $funcionario->getCpf()); 
				$run->bindValue(':telefone', $funcionario->getTelefone()); 
				$run->bindValue(':dtNasc', $funcionario->getDataNascimento()); 
				$run->bindValue(':sexo', $funcionario->getSexo()); 
				$run->bindValue(':email', $funcionario->getEmail()); 
				$run->bindValue(':salario', $funcionario->getSalario()); 
				$run->bindValue(':dtPagamento', $funcionario->getDataPag()); 
				$run->bindValue(':endereco', $funcionario->getEndereco()); 
				$run->bindValue(':tipo', $funcionario->getTipo());
				$run->bindValue(':idFuncionario', $funcionario->getIdFuncionario());		
				  		
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

		public function excluir($funcionario){

			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	
					
				$sql = "DELETE FROM tbFuncionario WHERE idFuncionario = :idFuncionario";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idFuncionario', $funcionario->getIdFuncionario());			
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
					
				$sql = "DELETE FROM tbFuncionario WHERE idFuncionario = :idFuncionario";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idFuncionario', $codigo);			
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
					
				$sql = "SELECT * FROM tbFuncionario ORDER BY nmFuncionario";

				$run = $pdo->prepare($sql);			
				$run->execute(); 

				$resultado = $run->fetchAll();

				foreach ($resultado as $registro){
					$funcionario = new Funcionario();
					$funcionario->setIdFuncionario($registro['idFuncionario']);
					$funcionario->setNome($registro['nmFuncionario']);
					$funcionario->setCpf($registro['cpf']);
					$funcionario->setSexo($registro['sexo']);
                    $funcionario->setTelefone($registro['telefone']);
                    $funcionario->setDataNascimento($registro['dtNasc']);
                    $funcionario->setEmail($registro['email']);
                    $funcionario->setSalario($registro['salario']);
                    $funcionario->setDataPag($registro['dtPagamento']);
                    $funcionario->setEndereco($registro['endereco']);
                    $funcionario->setTipo($registro['tipo']);
                
					array_push($objetos, $funcionario);
				}				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $objetos;

		}			
		
		public function buscarPorId($codigo){

			$funcionario = new Funcionario();
						
			try{

				$pdo = parent::conectar();

				$sql = "SELECT * FROM tbFuncionario WHERE idFuncionario = :idFuncionario";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idFuncionario', $codigo);			
				$run->execute(); 

				$registro = $run->fetch();
				
				$funcionario = new Funcionario();
				$funcionario->setIdFuncionario($registro['idFuncionario']);
				$funcionario->setNome($registro['nmFuncionario']);
				$funcionario->setCpf($registro['cpf']);
				$funcionario->setSexo($registro['sexo']);
				$funcionario->setTelefone($registro['telefone']);
				$funcionario->setDataNascimento($registro['dtNasc']);
				$funcionario->setEmail($registro['email']);
				$funcionario->setSalario($registro['salario']);
				$funcionario->setDataPag($registro['dtPagamento']);
				$funcionario->setEndereco($registro['endereco']);
				$funcionario->setTipo($registro['tipo']);

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}
			
			return $funcionario;
		}

        public function filtrar($nome, $tipo){
			
			$objetos = array();	

			$funcionario = new Funcionario();						
			try{
				$pdo = parent::conectar();
				
				$sql = "SELECT * FROM tbFuncionario WHERE nmFuncionario LIKE :nome AND tipo = IFNULL($tipo, tipo) ORDER BY nmFuncionario";
				$run = $pdo->prepare($sql);
                $run->bindValue(':nome', '%'.$nome.'%');
				
				$run->execute(); 
				$resultado = $run->fetchAll();

				foreach ($resultado as $registro){
					$funcionario->setIdFuncionario($registro['idFuncionario']);
					$funcionario->setNome($registro['nmFuncionario']);
					$funcionario->setCpf($registro['cpf']);
					$funcionario->setSexo($registro['sexo']);
                    $funcionario->setTelefone($registro['telefone']);
                    $funcionario->setDataNascimento($registro['dtNasc']);
                    $funcionario->setEmail($registro['email']);
                    $funcionario->setSalario($registro['salario']);
                    $funcionario->setDataPag($registro['dtPagamento']);
                    $funcionario->setEndereco($registro['endereco']);
					$funcionario->setTipo($registro['tipo']);

					array_push($objetos, $funcionario);
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
					
				$sql = "SELECT * FROM tbFuncionario WHERE idFuncionario <> :idFuncionario AND cpf = :cpf";
	
				$run = $pdo->prepare($sql);
				  $run->bindParam(':idFuncionario', $codigo);			
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
		
	}
?> 