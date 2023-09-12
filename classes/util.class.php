<?php

class Util
{
	static public function calcularSimulacao($aporteinicial, $aportemensal, $rendimento, $periodo)
	{
		$Dados = array();
		$Total = $aporteinicial + ($aporteinicial * ($rendimento / 100));

		$Lista = array(
			"mes" => 1,
			"aporteinicial" => $aporteinicial,
			"aportemensal" => 0,
			"rendimento" => $aporteinicial * ($rendimento / 100),
			"total" => $Total,

		);

		$Dados[] = $Lista;
		for ($i = 2; $i <= $periodo; $i++) {

			$Valorrendimento = ($Total + $aportemensal) * ($rendimento / 100);
			$Total += $aportemensal + $Valorrendimento;
			$Listas = array(
				"mes" => $i,
				"aporteinicial" => $Total - ($aportemensal + $Valorrendimento),
				"aportemensal" => $aportemensal,
				"rendimento" => $Valorrendimento,
				"total" => $Total
			);
			$Dados[] = $Listas;
		}
		return $Dados;
	}
}
