<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulador de Investimento</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@800&family=Roboto:wght@700;900&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/af4212dbbd.js" crossorigin="anonymous"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #121214;
        }

        ::-webkit-scrollbar-thumb {
            background: #29292E;
        }

        body {
            width: 100vw;
            height: 100vh;

            background-color: #121212;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        h1 {
            font-family: 'Orbitron', sans-serif;
            font-size: 40px;
            color: #8257e5;
        }

        div {
            margin-top: 30px;
            height: 40%;
            overflow-y: auto;
        }

        table {
            margin-right: 5px;

            color: #d9d9d9;

            border-collapse: collapse;

            font-family: 'Roboto', sans-serif;
            font-weight: 700;
        }

        table tr:nth-child(even) {
            background-color: #8257e5;
        }

        td,
        th {
            padding: 10px;
        }

        th {
            font-weight: 900;
        }
    </style>

</head>

<body>
    <header>
        <h1>Simulação: Resultado</h1>
    </header>
    <?php require_once "classes/autoloader.class.php";

    function realizarSimulacao($cliente, $aporteInicial, $aporteMensal, $rendimento, $periodo)
    {
        require_once './classes/autoloader.class.php';

        R::setup('mysql:host=localhost;dbname=fintech', 'root', '');

        $s = R::dispense('simulacao');

        $s->cliente = $cliente;
        $s->aporteInicial = $aporteInicial;
        $s->aporteMensal = $aporteMensal;
        $s->rendimento = $rendimento;
        $s->periodo = $periodo;

        $id = R::store($s);
        R::close();

        $simulacao = Util::calcularSimulacao($aporteInicial, $aporteMensal, $rendimento, $periodo);

        return $simulacao;
    }

    ?>
    <div>
        <table>
            <thead>
                <tr>
                    <th>Mês</th>
                    <th>Aplicação</th>
                    <th>Rendimento</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $cliente = $_GET["cliente"];
                $aporteInicial = $_GET["aporteInicial"];
                $aporteMensal = $_GET["aporteMensal"];
                $rendimento = $_GET["rendimento"];
                $periodo = $_GET["periodo"];

                if ($cliente && $aporteInicial && $aporteMensal && $rendimento && $periodo) {
                    $result = realizarSimulacao($cliente, $aporteInicial, $aporteMensal, $rendimento, $periodo);

                    foreach ($result as $value) {
                        echo "<tr>";
                        echo "<td>" . $value["mes"] . "</td>";
                        echo "<td>" . number_format($value["aporteinicial"], 2, ',', '.') . "</td>";
                        echo "<td>" . number_format($value["rendimento"], 2, ',', '.') . "</td>";
                        echo "<td>" . number_format($value["total"], 2, ',', '.') . "</td>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <nav style="padding: 30px;"><a href="index.html"><i class="fa-solid fa-house" style="color: #8257e5; font-size: 20px; size:20;"></i></a>
    </nav>
</body>

</html>