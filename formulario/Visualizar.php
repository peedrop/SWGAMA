<?php	
	session_start();
    if(isset($_SESSION['USUARIO'])){
	}else{
		echo "<script>alert('É preciso estar logado para acessar essa página!');location.href='../formulario/Login.php';</script>";
    }
    
    $objeto = array();
    $titulo = "Desculpe! Não foi encontrado nada para visualizar.";

	if(isset($_GET["objeto"])){
        // pego objeto json do get já decodifacando para objeto normal
        $objeto = json_decode($_GET["objeto"]);
        $titulo = $objeto[0];
    }
    //caso não saiba para onde voltar
    $pagina = "index.php"; 
    if(isset($_GET["pagina"])){
        //sabe para onde voltar
        $pagina = $_GET["pagina"];
    }
	
?>

<!DOCTYPE html>
<html lang="pt">
    <head>
        <title><?php echo $titulo ?></title>
        <?php 
            include_once("../blocosRepetidos/cssPadrao.php");  	
        ?>	
        <!-- Outros CSS-->
        <style>
            @media (min-width: 768px) {
                .table-condensed > thead > tr > th,
                .table-condensed > tbody > tr > th,
                .table-condensed > tfoot > tr > th,
                .table-condensed > thead > tr > td,
                .table-condensed > tbody > tr > td,
                .table-condensed > tfoot > tr > td {
                    padding: 5px;
                }
            }
        </style>
    </head>

    <body>	
        <div class="wrapper">
            <?php 
                include_once("../blocosRepetidos/sidebar.php");  	
            ?>
            <div class="main-panel" id="main-panel">
                <?php 
                    include_once("../blocosRepetidos/navbar.php");  	
                ?>
                <div class="panel-header panel-header-sm">
                </div>
                <div class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="col-md-3 float-right">
                                    <a class="btn btn-light btn-round float-right" href="<?php echo $pagina ?>"><< Voltar</a>
                                </div>
                                <div class="card-header">
                                    <h5 class="title"><?php echo $titulo ?></h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm table-condensed table-hover table-bordered table-striped">
                                        <tbody>
                                            <?php 
                                                for ($i = 1; $i < count($objeto); $i = $i+2) {
                                                    echo "<tr>";
                                                        echo "<td width='50%'>";
                                                            echo $objeto[$i];
                                                        echo "</td>";
                                                        echo "<td width='50%'>";
                                                            echo $objeto[$i+1];
                                                        echo "</td>";
                                                    echo "</tr>";
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php 
                    include_once("../blocosRepetidos/footer.php");  	
                ?>
            </div>
        </div>
        <?php 
            include_once("../blocosRepetidos/jsPadrao.php");  	
        ?>
        <!-- Outros JS-->
    </body>
</html>
