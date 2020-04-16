<?php	
	require_once 'CrudDAO.php';
	require_once 'ModeloBlusa.php';
	require_once 'ModoProdDAO.php';

	class ModeloBlusaDAO extends CrudDAO
	{

		public function salvar($modeloBlusa){	
			$situacao = FALSE;
			try{
				
				if($modeloBlusa->getIdModeloBlusa()==0){

					$situacao = $this->incluir($modeloBlusa);

				}else{	
					$situacao = $this->atualizar($modeloBlusa);
				}

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}			

			return $situacao;
		}

		public function incluir($modeloBlusa){	
			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	

				$sql = "INSERT INTO tbModelo(nmModelo, imagem, idModoProducao) 
                VALUES (:nmModelo, :imagem, :idModoProducao)";

				$run = $pdo->prepare($sql);
                $run->bindValue(':nmModelo', $modeloBlusa->getNome()); 
                $run->bindValue(':imagem', $modeloBlusa->getImagem()); 
                $run->bindValue(':idModoProducao', $modeloBlusa->getModoProducao()->getIdModoProd()); 
	  			$run->execute(); 

				if($run->rowCount() > 0){
					$situacao = TRUE;
				}

				$modeloBlusa->setIdModeloBlusa($pdo->lastInsertId());
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $situacao;
		}

		public function atualizar($modeloBlusa){	
			
			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();
					
				$sql = "UPDATE tbModelo SET nmModelo = :nmModelo, imagem = :imagem, idModoProducao = :idModoProducao 
                WHERE idModeloBlusa = :idModeloBlusa";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':nmModelo', $modeloBlusa->getNome());
	  			$run->bindValue(':imagem', $modeloBlusa->getImagem());
                $run->bindValue(':idModoProducao', $modeloBlusa->getModoProducao()->getIdModoProd());
                  
	  			$run->bindValue(':idModeloBlusa', $modeloBlusa->getIdModeloBlusa());				
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

		public function excluir($modeloBlusa){

			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	
					
				$sql = "DELETE FROM tbModelo WHERE idModeloBlusa = :idModeloBlusa";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idModeloBlusa', $modeloBlusa->getIdModeloBlusa());			
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
					
				$sql = "DELETE FROM tbModelo WHERE idModelo = :idModelo";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idModelo', $codigo);			
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
					
				$sql = "SELECT * FROM tbModelo ORDER BY nmModelo";

				$run = $pdo->prepare($sql);			
				$run->execute(); 

                $resultado = $run->fetchAll();
                
                $modoProdDAO = new ModoProdDAO();

				foreach ($resultado as $registro){
					$modeloBlusa = new ModeloBlusa();
					$modeloBlusa->setIdModeloBlusa($registro['idModelo']);
					$modeloBlusa->setNome($registro['nmModelo']);
					$modeloBlusa->setImagem($registro['imagem']);
                    
                    $modoProd = $modoProdDAO->buscarPorId($registro['idModoProducao']);
                    $modeloBlusa->setModoProducao($modoProd);

					array_push($objetos, $modeloBlusa);
				}	
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $objetos;

		}			
		
		public function buscarPorId($codigo){

			$modeloBlusa = new ModeloBlusa();
						
			try{

				$pdo = parent::conectar();

				$sql = "SELECT * FROM tbModelo WHERE idModelo = :idModelo";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idModelo', $codigo);			
				$run->execute(); 

				$registro = $run->fetch();
				
				$modeloBlusa->setIdModeloBlusa($registro['idModelo']);
                $modeloBlusa->setNome($registro['nmModelo']);
                $modeloBlusa->setImagem($registro['imagem']);
                $modoProd = $modoProdDAO->buscarPorId($registro['idModoProducao']);
                $modeloBlusa->setModoProducao($modoProd);

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}
			
			return $modeloBlusa;
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