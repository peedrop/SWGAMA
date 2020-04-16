<?php	
	require_once 'CrudDAO.php';
	require_once 'TipoFunc.php';

	class TipoFuncDAO extends CrudDAO
	{

		public function salvar($tipoFunc){	
			$situacao = FALSE;
			try{
				
				if($tipoFunc->getIdTipoFunc()==0){

					$situacao = $this->incluir($tipoFunc);

				}else{	
					$situacao = $this->atualizar($tipoFunc);
				}

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}			

			return $situacao;
		}

		public function incluir($tipoFunc){	
			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	

				$sql = "INSERT INTO tbTipoFuncionario(descricao, permissao) VALUES (:descricao, :permissao)";

				$run = $pdo->prepare($sql);
                $run->bindValue(':descricao', $tipoFunc->getDescricao()); 
                $run->bindValue(':permissao', $tipoFunc->getPermissao()); 
	  			$run->execute(); 

				if($run->rowCount() > 0){
					$situacao = TRUE;
				}

				$tipoFunc->setIdTipoFunc($pdo->lastInsertId());
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $situacao;
		}

		public function atualizar($tipoFunc){	
			
			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();
					
				$sql = "UPDATE tbTipoFuncionario SET descricao = :descricao, permissao = :permissao WHERE idTipoFunc = :idTipoFunc";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':descricao', $tipoFunc->getDescricao());
	  			$run->bindValue(':permissao', $tipoFunc->getPermissao());
	  			$run->bindValue(':idTipoFunc', $tipoFunc->getIdTipoFunc());				
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

		public function excluir($tipoFunc){

			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	
					
				$sql = "DELETE FROM tbTipoFuncionario WHERE idTipoFunc = :idTipoFunc";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idTipoFunc', $tipoFunc->getIdTipoFunc());			
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
					
				$sql = "DELETE FROM tbTipoFuncionario WHERE idTipoFunc = :idTipoFunc";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idTipoFunc', $codigo);			
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
					
				$sql = "SELECT * FROM tbTipoFuncionario ORDER BY descricao";

				$run = $pdo->prepare($sql);			
				$run->execute(); 

				$resultado = $run->fetchAll();

				foreach ($resultado as $registro){
					$tipoFunc = new TipoFunc();
					$tipoFunc->setIdTipoFunc($registro['idTipoFunc']);
					$tipoFunc->setDescricao($registro['descricao']);
					$tipoFunc->setPermissao($registro['permissao']);
					array_push($objetos, $tipoFunc);
				}	
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $objetos;

		}			
		
		public function buscarPorId($codigo){

			$tipoFunc = new TipoFunc();
						
			try{

				$pdo = parent::conectar();

				$sql = "SELECT * FROM tbTipoFuncionario WHERE idTipoFunc = :idTipoFunc";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idTipoFunc', $codigo);			
				$run->execute(); 

				$registro = $run->fetch();

				$tipoFunc->setIdTipoFunc($registro['idTipoFunc']);
				$tipoFunc->setDescricao($registro['descricao']);
				$tipoFunc->setPermissao($registro['permissao']);

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}
			
			return $tipoFunc;
		}

		public function filtrar($descricao, $permissao){
			
			$objetos = array();	

			$tipoFunc = new TipoFunc();						
			try{
                $pdo = parent::conectar();
                if($permissao != 'null'){
                    $permissao = "'".$permissao."'";
                }
                $sql = "SELECT * FROM tbTipoFuncionario 
                        WHERE descricao LIKE '%{$descricao}%' AND permissao = IFNULL($permissao, permissao)";
				$run = $pdo->prepare($sql);
                $run->bindValue(':descricao', '%'.$descricao.'%');
				$run->execute(); 
				$resultado = $run->fetchAll();

				foreach ($resultado as $registro){
					$tipoFunc = new tipoFunc();
					$tipoFunc->setIdTipoFunc($registro['idTipoFunc']);
					$tipoFunc->setDescricao($registro['descricao']);
					$tipoFunc->setPermissao($registro['permissao']);
					array_push($objetos, $tipoFunc);
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