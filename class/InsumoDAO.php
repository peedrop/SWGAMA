<?php	
	require_once 'CrudDAO.php';
	require_once 'Insumo.php';

	class InsumoDAO extends CrudDAO
	{

		public function salvar($insumo){	
			$situacao = FALSE;
			try{
				
				if($insumo->getId()==0){

					$situacao = $this->incluir($insumo);

				}else{	
					$situacao = $this->atualizar($insumo);
				}

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}			

			return $situacao;
		}

		public function incluir($insumo){	
			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	

				$sql = "INSERT INTO tbInsumo(nmInsumo, qtdMin, qtdEstoque, descricao, tipo) 
                        VALUES (:nmInsumo, :qtdMin, :qtdEstoque, :descricao, :tipo)";

				$run = $pdo->prepare($sql);
                $run->bindValue(':nmInsumo', $insumo->getNome()); 
                $run->bindValue(':qtdMin', $insumo->getQtdMin()); 
                $run->bindValue(':qtdEstoque', $insumo->getQtdEstoque()); 
                $run->bindValue(':descricao', $insumo->getDescricao()); 
                $run->bindValue(':tipo', $insumo->getTipo()); 
	  			$run->execute(); 

				if($run->rowCount() > 0){
					$situacao = TRUE;
				}

				$insumo->setId($pdo->lastInsertId());
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $situacao;
		}

		public function atualizar($insumo){	
			
			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();
					
				$sql = "UPDATE tbInsumo SET nmInsumo = :nmInsumo, qtdMin = :qtdMin, qtdEstoque = :qtdEstoque,
                descricao = :descricao, tipo = :tipo WHERE idInsumo = :idInsumo";
                
				$run = $pdo->prepare($sql);
                $run->bindValue(':nmInsumo', $insumo->getNome()); 
                $run->bindValue(':qtdMin', $insumo->getQtdMin()); 
                $run->bindValue(':qtdEstoque', $insumo->getQtdEstoque()); 
                $run->bindValue(':descricao', $insumo->getDescricao()); 
                $run->bindValue(':tipo', $insumo->getTipo()); 
	  			$run->bindValue(':idInsumo', $insumo->getId());				
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

		public function excluir($insumo){

			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	
					
				$sql = "DELETE FROM tbInsumo WHERE idInsumo = :idInsumo";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idInsumo', $insumo->getId());			
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
					
				$sql = "DELETE FROM tbInsumo WHERE idInsumo = :idInsumo";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idInsumo', $codigo);			
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
					
				$sql = "SELECT * FROM tbInsumo ORDER BY nmInsumo";

				$run = $pdo->prepare($sql);			
				$run->execute(); 

				$resultado = $run->fetchAll();

				foreach ($resultado as $registro){
					$insumo = new Insumo();
					$insumo->setId($registro['idInsumo']);
					$insumo->setNome($registro['nmInsumo']);
					$insumo->setQtdMin($registro['qtdMin']);
					$insumo->setQtdEstoque($registro['qtdEstoque']);
					$insumo->setDescricao($registro['descricao']);
					$insumo->setTipo($registro['tipo']);
					array_push($objetos, $insumo);
				}	
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $objetos;

		}			
		
		public function buscarPorId($codigo){

			$insumo = new Insumo();
						
			try{

				$pdo = parent::conectar();

				$sql = "SELECT * FROM tbInsumo WHERE idInsumo = :idInsumo";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idInsumo', $codigo);			
				$run->execute(); 

				$registro = $run->fetch();

				$insumo->setId($registro['idInsumo']);
                $insumo->setNome($registro['nmInsumo']);
                $insumo->setQtdMin($registro['qtdMin']);
                $insumo->setQtdEstoque($registro['qtdEstoque']);
                $insumo->setDescricao($registro['descricao']);
                $insumo->setTipo($registro['tipo']);

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}
			
			return $insumo;
		}

		public function filtrar($nmInsumo, $qtdMin, $qtdEstoque, $descricao, $tipo){
			
			$objetos = array();	

			$insumo = new Insumo();						
			try{
				$pdo = parent::conectar();
				
				$sql = "SELECT * FROM tbInsumo 
                WHERE nmInsumo LIKE :nmInsumo 
                AND qtdMin LIKE :qtdMin 
                AND qtdEstoque LIKE :qtdEstoque 
                AND descricao LIKE :descricao 
                AND tipo LIKE :tipo 
                ORDER BY nmInsumo";
				$run = $pdo->prepare($sql);
	  			$run->bindValue(':nmInsumo', '%'.$nmInsumo.'%');
	  			$run->bindValue(':qtdMin', '%'.$qtdMin.'%');
	  			$run->bindValue(':qtdEstoque', '%'.$qtdEstoque.'%');
	  			$run->bindValue(':descricao', '%'.$descricao.'%');
	  			$run->bindValue(':tipo', '%'.$tipo.'%');
				
				$run->execute(); 
				$resultado = $run->fetchAll();

				foreach ($resultado as $registro){
                    $insumo = new Insumo();	
					$insumo->setId($registro['idInsumo']);
                    $insumo->setNome($registro['nmInsumo']);
                    $insumo->setQtdMin($registro['qtdMin']);
                    $insumo->setQtdEstoque($registro['qtdEstoque']);
                    $insumo->setDescricao($registro['descricao']);
                    $insumo->setTipo($registro['tipo']);
					array_push($objetos, $insumo);
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