<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property $db
 */

class Adm extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('America/Sao_Paulo');
		define(
			'LETRAS',
			['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z']
		);
	}

	public function numero_igrejas()
	{
		$consultar_informacao_igreja_2025 = $this->db->query("SELECT igreja, Count(*) FROM lider GROUP BY igreja HAVING Count(*) >= 1 ORDER BY igreja ASC");
		$total_igreja_2025 = $consultar_informacao_igreja_2025->num_rows();
		echo " 2025 - " . $total_igreja_2025 - 170;
	}
}
