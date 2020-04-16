<?php	
	require_once 'CrudDAO.php';
	require_once 'Venda.php';
	require_once 'ClienteDAO.php';

	class VendaDAO extends CrudDAO
	{
		public function salvar($venda){	
			$situacao = FALSE;
			try{
				
				if($venda->getIdVenda()==0){

					$situacao = $this->incluir($venda);

				}else{	
					$situacao = $this->atualizar($venda);
				}

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}			

			return $situacao;
		}

		public function incluir($venda){	
			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	

				$sql = "INSERT INTO tbVenda(valorTotal, desconto, dataHora, observacao, tipo, idCliente)
                        VALUES (:valorTotal, :desconto, :dataHora, :observacao, :tipo, :idCliente)";

				$run = $pdo->prepare($sql);
                $run->bindValue(':valorTotal', $venda->getValorTotal()); 
                $run->bindValue(':desconto', $venda->getDesconto()); 
                $run->bindValue(':dataHora', $venda->getDataHora()); 
                $run->bindValue(':observacao', $venda->getObservacao()); 
                $run->bindValue(':tipo', $venda->getTipo()); 
                $run->bindValue(':idCliente', $venda->getCliente()->getIdCliente()); 
	  			$run->execute(); 

				if($run->rowCount() > 0){
					$situacao = TRUE;
				}

				$venda->setIdVenda($pdo->lastInsertId());
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $situacao;
		}

		public function atualizar($venda){	
			
			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();
					
				$sql = "UPDATE tbVenda SET valorTotal = :valorTotal, desconto = :desconto, dataHora = :dataHora,
                        observacao = :observacao, tipo = :tipo, idCliente = :idCliente
                        WHERE idVenda = :idVenda";

				$run = $pdo->prepare($sql);
                $run->bindValue(':idVenda', $venda->getIdVenda());
                $run->bindValue(':valorTotal', $venda->getValorTotal()); 
                $run->bindValue(':desconto', $venda->getDesconto()); 
                $run->bindValue(':dataHora', $venda->getDataHora()); 
                $run->bindValue(':observacao', $venda->getObservacao()); 
                $run->bindValue(':tipo', $venda->getTipo()); 
                $run->bindValue(':idCliente', $venda->getCliente()->getIdCliente()); 				
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

		public function excluir($venda){

			$situacao = FALSE;
			try{
				
				$pdo = parent::conectar();	
					
				$sql = "DELETE FROM tbVenda WHERE idVenda = :idVenda";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idVenda', $venda->getIdVenda());			
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
					
				$sql = "DELETE FROM tbVenda WHERE idVenda = :idVenda";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idVenda', $codigo);			
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
					
				$sql = "SELECT * FROM tbVenda ORDER BY dataHora";

				$run = $pdo->prepare($sql);			
				$run->execute(); 

				$resultado = $run->fetchAll();

				foreach ($resultado as $registro){
					$venda = new Venda();
                    $venda->setIdVenda($registro['idVenda']);
                    
					$venda->setValorTotal($registro['valorTotal']);
					$venda->setDesconto($registro['desconto']);
					$venda->setDataHora($registro['dataHora']);
					$venda->setObservacao($registro['observacao']);
                    $venda->setTipo($registro['tipo']);
                    
                    $clienteDAO = new ClienteDAO();
					$cliente = $clienteDAO->buscarPorId($registro['idCliente']);
                    $venda->setCliente($cliente);
                    
					array_push($objetos, $venda);
				}	
				
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}		

			return $objetos;

		}			
		
		public function buscarPorId($codigo){

			$venda = new Venda();
						
			try{

				$pdo = parent::conectar();

				$sql = "SELECT * FROM tbVenda WHERE idVenda = :idVenda";

				$run = $pdo->prepare($sql);
	  			$run->bindValue(':idVenda', $codigo);			
				$run->execute(); 

				$registro = $run->fetch();

				$venda->setIdVenda($registro['idVenda']);
                
                $venda->setValorTotal($registro['valorTotal']);
                $venda->setDesconto($registro['desconto']);
                $venda->setDataHora($registro['dataHora']);
                $venda->setObservacao($registro['observacao']);
                $venda->setTipo($registro['tipo']);
                
                $clienteDAO = new ClienteDAO();
                $cliente = $clienteDAO->buscarPorId($registro['idCliente']);
                $venda->setCliente($cliente);

			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}finally {
				parent::desconectar();
			}
			
			return $venda;
        }
        public function proximoId(){
            
            $id = 0;
						
			try{

				$pdo = parent::conectar();

				$sql = "SELECT AUTO_INCREMENT
                        FROM   information_schema.tables
                        WHERE  table_name = 'tbvenda'
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

		public function filtrar(){
            return "Filtrar não está programado";
		}		
		
	}
	
?> 