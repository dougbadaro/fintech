<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>

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

		form {
			display: flex;
			flex-direction: column;
			justify-content: center;
			padding: 30px;
		}

		form div {
			padding: 10px;

			display: flex;
			justify-content: space-between;
			gap: 20px;
		}

		form div label {
			color: #d9d9d9;

			font-family: 'Roboto', sans-serif;
		}

		form div input {
			width: 150px;
			height: 25px;

			background-color: transparent;

			border: none;
			border-bottom: 2px solid #8257e5;
			border-right: 2px solid #8257e5;
			border-radius: 5px;

			color: #d9d9d9;
		}

		form input:hover {
			border-top: 1px solid #8257e5;
			border-left: 1px solid #8257e5;
		}

		form div input:focus {
			outline: none;
		}

		form button {
			margin: 20px 30px 20px 30px;
			padding: 10px;

			background-color: #8257e5;
			border: none;
			border-radius: 5px;

			color: #d9d9d9;
			font-family: 'Roboto', sans-serif;
			font-size: 16px;
		}

		fieldset {
			margin-bottom: 50px;
			padding: 20px 50px;
		}

		legend {
			font-family: 'Orbitron', sans-serif;
			font-size: 18px;

			color: #8257e5;

			padding: 0 10px;
		}

		p {
			font-family: 'Roboto', sans-serif;
			font-weight: 900;
			font-size: 16px;
			color: #d9d9d9;

			display: flex;
			justify-content: space-between;
			gap: 20px;
		}

		.value {
			font-weight: 700;
		}

		.table {
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
		<h1>Histórico</h1>
	</header>

	<form action="historico.php">
		<div>
			<label for="idSimulador">ID da simulação</label>
			<input type="number" name="idSimulation" id="idSimulation">
		</div>
		<button type="submit">Recuperar</button>
	</form>

	<?php
	require_once 'classes/autoloader.class.php';

	if (isset($_GET['idSimulation'])) {
		R::setup('mysql:host=localhost;dbname=fintech', 'root', '');

		$dataSimulacao = R::load('simulacao', $_GET['idSimulation']);
		R::close();

		if ($dataSimulacao->id) {
			$simulacao = Util::calcularSimulacao($dataSimulacao->aporteInicial, $dataSimulacao->aporteMensal, $dataSimulacao->rendimento, $dataSimulacao->periodo);

			echo '<fieldset>';
			echo "<legend>Dados</legend>";
			echo "<p><span>Cliente:</span> <span class='value'>$dataSimulacao->cliente</span></p>";
			echo "<p><span>Aporte Inicial (R$):</span> <span class='value'>$dataSimulacao->aporteInicial</span></p>";
			echo "<p><span>Aporte Mensal (R$):</span> <span class='value'>$dataSimulacao->aporteMensal</span></p>";
			echo "<p><span>Rendimento (%):</span> <span class='value'>$dataSimulacao->rendimento</span></p>";
			echo "<p><span>Período:</span> <span class='value'>$dataSimulacao->periodo</span></p>";
			echo '</fieldset>';

			echo '<div class="table">';
			echo '<table>';
			echo '<thead>';
			echo '<tr>';
			echo '<th>Mês</th>';
			echo '<th>Aplicação</th>';
			echo '<th>Rendimento</th>';
			echo '<th>Total</th>';
			echo '</tr>';
			echo '</thead>';
			echo '<tbody>';

			foreach ($simulacao as $value) {
				echo "<tr>";
				echo "<td>" . $value["mes"] . "</td>";
				echo "<td>" . number_format($value["aporteinicial"], 2, ',', '.') . "</td>";
				echo "<td>" . number_format($value["rendimento"], 2, ',', '.') . "</td>";
				echo "<td>" . number_format($value["total"], 2, ',', '.') . "</td>";
			}

			echo '</tbody>';
			echo '</table>';
			echo '</div>';
		} else {
			echo "Simulação não encontrada!";
		}
	}
	?>

	<nav style="padding: 30px;"><a href="index.html"><i class="fa-solid fa-house" style="color: #8257e5; font-size: 20px;"></i></a></nav>
</body>

</html>