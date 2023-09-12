<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulador de Investimento</title>
</head>
<body>

<header>
    <h1>Simulação: Resultado</h1>
</header>

<?php
require_once "dbtest/autoloader.class.php";
require_once "dbtest/classes/simulacao.class.php";



function Resultado($cliente, $mes, $aporteinicial, $aportemensal, $rendimento, $periodo)
{
    $s = new Simulacao ();
    $s->cliente = $cliente;
    $s->mes = $mes;
    $s->aporteinicial = $aporteinicial;
    $s->aportemensal = $aportemensal;
    $s->rendimento = $rendimento;
    $s->periodo = $periodo;

    $Dados= array();
    $Total= $aporteinicial+($aporteinicial*($rendimento/100));
    
    $Lista= array(
        "mes"=> 1, 
        "aporteinicial"=> $aporteinicial,
        "aportemensal"=> 0,
        "rendimento"=> $aporteinicial*($rendimento/100),
        "total"=> $Total,

    );

    $Dados[] = $Lista;
    for($i=2; $i<=$periodo; $i++)
    {

        $Valorrendimento= ($Total+$aportemensal)*($rendimento/100);
        $Total+=$aportemensal+$Valorrendimento;
        $Listas= array(
            "mes"=> $i, 
            "aporteinicial"=> $Total-($aportemensal+$Valorrendimento),
            "aportemensal"=> $aportemensal,
            "rendimento"=> $Valorrendimento,
            "total"=> $Total
        );
        $Dados[] = $Listas;

    }
    return $Dados;
}
 ?>

 <table>
    <thead>
        <tr>
            <th>
                Mês 
            </th>
            <th>
                Aplicação
            </th>
            <th>
                Rendimento
            </th>
            <th>
                Total
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
        $Aporteinicial = $_GET["aporte-inicial"];
        $Aportemensal = $_GET["aporte-mensal"];
        $Rendimento = $_GET["rendimento"];
        $Periodo = $_GET["periodo"];

        $Result= Resultado($Aporteinicial, $Aportemensal, $Rendimento, $Periodo);
        foreach($Result as $value){
            echo "<tr>";
            echo "<td>" . $value["mes"] . "</td>";
            echo "<td>" . $value["aporteinicial"] . "</td>";
            echo "<td>" . $value["rendimento"] . "</td>";
            echo "<td>" . $value["total"] . "</td>";
        } 
        ?>
    </tbody>
 </table>
    
</body>
</html>