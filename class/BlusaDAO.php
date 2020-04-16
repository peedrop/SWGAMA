<?php	
		require_once 'CrudDAO.php';
        require_once 'GolaDAO.php';
        require_once 'Gola.php';
        require_once 'ModoProdDAO.php';
        require_once 'ModoProd.php';
        require_once 'TamanhoDAO.php';
        require_once 'Tamanho.php';
        require_once 'TipoMalhaDAO.php';
        require_once 'TipoMalha.php';
        require_once 'Blusa.php';

	class BlusaDAO extends CrudDAO
	{

		public function salvar($blusa){	
			$situacao = FALSE;
			try{
				
				if($blusa->getIdBlusa()==0){

					$situacao = $this->incluir($blusa);
				}else{	
					$situacao = $this->atualizar($blusa);
				}

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}			

			return $situacao;
		}

		public function incluir($blusa){	
			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	
				
				$sql = "INSERT INTO tbBlusa(nome, valor, qtdEstoque, idGola, idMalha, idTamanho, idModoProd, status) 
                                VALUES (:nome, :valor, :qtdEstoque, :idGola, :idMalha, :idTamanho, :idModoProd, :status)";

				$run = $pdo->prepare($sql);
                $run->bindValue(':nome', $blusa->getNome()); 
                $run->bindValue(':valor', $blusa->getValor()); 
                $run->bindValue(':qtdEstoque', $blusa->getEstoque()); 
                $run->bindValue(':idGola', $blusa->getGola()->getIdGola()); 
                $run->bindValue(':idMalha', $blusa->getMalha()->getIdMalha()); 
                $run->bindValue(':idTamanho', $blusa->getTamanho()->getIdTamanho()); 
				$run->bindValue(':idModoProd', $blusa->getModoProd()->getIdModoProd()); 
				$run->bindValue(':status', $blusa->getStatus()); 
				$run->execute(); 

				if($run->rowCount() > 0){
					$situacao = TRUE;
				}

				$blusa->setIdBlusa($pdo->lastInsertId());
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $situacao;
		}

		public function atualizar($blusa){	
			
			$situacao = FALSE;
			try{
                $pdo = parent::conectar();
				print_r($blusa);
				$sql = "UPDATE tbBlusa SET nome = :nome, valor = :valor, qtdEstoque = :qtdEstoque,
                idGola = :idGola, idMalha = :idMalha, idTamanho = :idTamanho, idModoProd = :idModoProd, status = :status WHERE idBlusa = :idBlusa";

                $run = $pdo->prepare($sql);
				$run->bindValue(':idBlusa', $blusa->getIdBlusa());
				$run->bindValue(':nome', $blusa->getNome()); 
                $run->bindValue(':valor', $blusa->getValor()); 
                $run->bindValue(':qtdEstoque', $blusa->getEstoque()); 
                $run->bindValue(':idGola', $blusa->getGola()->getIdGola()); 
                $run->bindValue(':idMalha', $blusa->getMalha()->getIdMalha()); 
                $run->bindValue(':idTamanho', $blusa->getTamanho()->getIdTamanho()); 
				$run->bindValue(':idModoProd', $blusa->getModoProd()->getIdModoProd()); 
				$run->bindValue(':status', $blusa->getStatus());				
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

		public function excluir($blusa){

			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	
					
				$sql = "DELETE FROM tbBlusa WHERE idBlusa = :idBlusa";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idBlusa', $blusa->getIdBlusa());			
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
					
				$sql = "DELETE FROM tbBlusa WHERE idBlusa = :idBlusa";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idBlusa', $codigo);			
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
					
				$sql = "SELECT * FROM tbBlusa WHERE status != 'ORCAMENTO' ORDER BY nome";

				$run = $pdo->prepare($sql);			
				$run->execute(); 

				$resultado = $run->fetchAll();

				foreach ($resultado as $registro){
					$blusa = new Blusa();

					$blusa->setIdBlusa($registro['idBlusa']);
					$blusa->setNome($registro['nome']);
					$blusa->setValor($registro['valor']);
					$blusa->setEstoque($registro['qtdEstoque']);

					$golaDAO = new GolaDAO();
					$gola = $golaDAO->buscarPorId($registro['idGola']);
					$blusa->setGola($gola);

					$malhaDAO = new TipoMalhaDAO();
					$malha = $malhaDAO->buscarPorId($registro['idMalha']);
					$blusa->setMalha($malha);

					$tamanhoDAO = new TamanhoDAO();
					$tamanho = $tamanhoDAO->buscarPorId($registro['idTamanho']);
					$blusa->setTamanho($tamanho);

					$modoProdDAO = new ModoProdDAO();
					$modoProd = $modoProdDAO->buscarPorId($registro['idModoProd']);
					$blusa->setModoProd($modoProd);

					array_push($objetos, $blusa);
				}	
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $objetos;

		}			
		
		public function buscarPorId($codigo){

			$blusa = new Blusa();
						
			try{

				$pdo = parent::conectar();

				$sql = "SELECT * FROM tbBlusa WHERE idBlusa = :idBlusa";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idBlusa', $codigo);			
				$run->execute(); 

				$registro = $run->fetch();

				$blusa->setIdBlusa($registro['idBlusa']);
				$blusa->setNome($registro['nome']);
				$blusa->setValor($registro['valor']);
				$blusa->setEstoque($registro['qtdEstoque']);

				$golaDAO = new GolaDAO();
				$gola = $golaDAO->buscarPorId($registro['idGola']);
				$blusa->setGola($gola);

				$malhaDAO = new TipoMalhaDAO();
				$malha = $malhaDAO->buscarPorId($registro['idMalha']);
				$blusa->setMalha($malha);

				$tamanhoDAO = new TamanhoDAO();
				$tamanho = $tamanhoDAO->buscarPorId($registro['idTamanho']);
				$blusa->setTamanho($tamanho);

				$modoProdDAO = new ModoProdDAO();
				$modoProd = $modoProdDAO->buscarPorId($registro['idModoProd']);
				$blusa->setModoProd($modoProd);

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}
			
			return $blusa;
		}
        
		public function filtrar($nome, $idGola, $idMalha, $idModoProd, $idTamanho, $valor){
			
			$objetos = array();	

			$blusa = new Blusa();						
			try{
				$pdo = parent::conectar();
				
				$sql = "SELECT * FROM tbBlusa 
				WHERE nome LIKE '%{$nome}%' 
				AND idGola = {$idGola} 
				AND idMalha = {$idMalha}
                AND idModoProd LIKE {$idModoProd} 
				AND idTamanho LIKE {$idTamanho }
				AND valor LIKE '%{$valor}%'
				ORDER BY nome";

				$run = $pdo->prepare($sql);			
				$run->execute(); 
				$resultado = $run->fetchAll();

				foreach ($resultado as $registro){
					$blusa = new Blusa();

					$blusa->setIdBlusa($registro['idBlusa']);
					$blusa->setNome($registro['nome']);
					$blusa->setValor($registro['valor']);
					$blusa->setEstoque($registro['qtdEstoque']);

					$golaDAO = new GolaDAO();
					$gola = $golaDAO->buscarPorId($registro['idGola']);
					$blusa->setGola($gola);

					$malhaDAO = new TipoMalhaDAO();
					$malha = $malhaDAO->buscarPorId($registro['idMalha']);
					$blusa->setMalha($malha);

					$tamanhoDAO = new TamanhoDAO();
					$tamanho = $tamanhoDAO->buscarPorId($registro['idTamanho']);
					$blusa->setTamanho($tamanho);

					$modoProdDAO = new ModoProdDAO();
					$modoProd = $modoProdDAO->buscarPorId($registro['idModoProd']);
					$blusa->setModoProd($modoProd);

					array_push($objetos, $blusa);
				}	

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}
			
			return $objetos;
		}	

		public function proximoId(){
            
            $id = 0;
						
			try{

				$pdo = parent::conectar();

				$sql = "SELECT AUTO_INCREMENT
                        FROM   information_schema.tables
                        WHERE  table_name = 'tbBlusa'
                        AND    table_schema = 'swgama';";

				$run = $pdo->prepare($sql);		
				$run->execute(); 

				$registro = $run->fetch();

				$id = $registro['AUTO_INCREMENT'];

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}
			
			return $id;
        }
	}
	
?> 