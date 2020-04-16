<?php	
	require_once 'CrudDAO.php';
	require_once 'Usuario.php';

	class UsuarioDAO extends CrudDAO
	{

		public function salvar($usuario){	
			$situacao = FALSE;
			try{
				
				if($usuario->getIdUsuario()==0){

					$situacao = $this->incluir($usuario);

				}else{	
					$situacao = $this->atualizar($usuario);
				}

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}			

			return $situacao;
		}

		public function incluir($usuario){	
			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	

				$sql = "INSERT INTO tbUsuario(nome, senha, email) VALUES (:nome, :senha, :email)";

				$run = $pdo->prepare($sql);
                $run->bindValue(':nome', $usuario->getNome()); 
                $run->bindValue(':senha', $usuario->getSenha()); 
                $run->bindValue(':email', $usuario->getEmail()); 
	  			$run->execute(); 

				if($run->rowCount() > 0){
					$situacao = TRUE;
				}

				$usuario->setIdUsuario($pdo->lastInsertId());
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $situacao;
		}

		public function atualizar($usuario){	
			
			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();
					
				$sql = "UPDATE tbUsuario SET nome = :nome, senha = :senha, email = :email WHERE idUsuario = :idUsuario";

				$run = $pdo->prepare($sql);
                $run->bindValue(':nome', $usuario->getNome()); 
                $run->bindValue(':senha', $usuario->getSenha()); 
                $run->bindValue(':email', $usuario->getEmail()); 
	  			$run->bindValue(':idUsuario', $usuario->getIdUsuario());				
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

		public function excluir($usuario){

			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	
					
				$sql = "DELETE FROM tbUsuario WHERE idUsuario = :idUsuario";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idUsuario', $usuario->getIdUsuario());			
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
					
				$sql = "DELETE FROM tbUsuario WHERE idUsuario = :idUsuario";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idUsuario', $codigo);			
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
					
				$sql = "SELECT * FROM tbUsuario ORDER BY nome";

				$run = $pdo->prepare($sql);			
				$run->execute(); 

				$resultado = $run->fetchAll();

				foreach ($resultado as $registro){
					$usuario = new Usuario();
					$usuario->setIdUsuario($registro['idUsuario']);
					$usuario->setNome($registro['nome']);
                    $usuario->setEmail($registro['email']);
					$usuario->setSenha($registro['senha']);
					array_push($objetos, $usuario);
				}	
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $objetos;

		}			
		
		public function buscarPorId($codigo){

			$usuario = new Usuario();
						
			try{

				$pdo = parent::conectar();

				$sql = "SELECT * FROM tbUsuario WHERE idUsuario = :idUsuario";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idUsuario', $codigo);			
				$run->execute(); 

				$registro = $run->fetch();

				$usuario->setIdUsuario($registro['idUsuario']);
				$usuario->setNome($registro['nome']);
				$usuario->setEmail($registro['email']);
				$usuario->setSenha($registro['senha']);

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}
			
			return $usuario;
		}

		public function filtrar($usuario, $email, $senha){
			
			$objetos = array();	

			$usuario = new Usuario();						
			try{
				$pdo = parent::conectar();
				
				$sql = "SELECT * FROM tbUsuario WHERE usuario LIKE :usuario AND senha LIKE :senha AND email LIKE :email ORDER BY usuario";
				$run = $pdo->prepare($sql);
	  			$run->bindValue(':usuario', '%'.$usuario.'%');
                $run->bindValue(':senha', '%'.$altura.'%');     
	  			$run->bindValue(':email', '%'.$largura.'%');
				
				$run->execute(); 
				$resultado = $run->fetchAll();

				foreach ($resultado as $registro){
					$usuario = new Usuario();
					$usuario->setIdUsuario($registro['idUsuario']);
					$usuario->setNome($registro['usuario']);
					$usuario->setEmail($registro['email']);
					$usuario->setSenha($registro['senha']);
					array_push($objetos, $usuario);
				}	

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}
			
			return $objetos;
		}	

		public function autenticar($email, $senha){

			$usuario = new Usuario();
						
			try{

				$pdo = parent::conectar();

				$sql = "SELECT * FROM TbUsuario WHERE email = :email AND senha = :senha";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':email', $email);			
	  			$run->bindValue(':senha', $senha);	
				$run->execute(); 
				
				$registro = $run->fetch();

				$usuario->setIdUsuario($registro['idUsuario']);
				$usuario->setNome($registro['nome']);
				$usuario->setEmail($registro['email']);
				$usuario->setSenha($registro['senha']);
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}
			
			return $usuario;
		}	

		public function verificarEmail($idUsuario, $email){

			$situacao = TRUE;
			try{
				
				$pdo = parent::conectar();
					
				$sql = "SELECT * FROM TbUsuario WHERE idUsuario <> :idUsuario AND email = :email";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idUsuario', $idUsuario);			
				$run->bindValue(':email', $email);	
				  
				$run->execute(); 

				if($run->rowCount() > 0){
					$situacao = FALSE;
				}
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}			

			return $situacao;

		}
		public function buscarPorEmail($email){

			$usuario = new Usuario();
						
			try{

				$pdo = parent::conectar();

				$sql = "SELECT * FROM TbUsuario WHERE email = :email";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':email', $email);			
				$run->execute(); 
				$resultado = $run->fetch();

				foreach ($resultado as $registro){
				$usuario = new Usuario();
				$usuario->setIdUsuario($resultado['idUsuario']);
				$usuario->setEmail($resultado['email']);
				
			}

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}
			
			return $usuario;
		}
		
		public function atualizarSenha($idUsuario, $senhaGerada){
			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();
					
				$sql = "UPDATE TbUsuario SET senha = :senha WHERE idUsuario = :idUsuario";

				$run = $pdo->prepare($sql);
				$run->bindValue(':idUsuario', $idUsuario);  
				$run->bindValue(':senha', md5($senhaGerada)); 
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
	
		
	}
	
?> 