<?php

/**
 * 
 */
class FAlerta_model extends CI_Model
{
	// ALERTA - DIREÇÃO
	public function alerta_controle($id_responsavel, $id, $motivo, $acao)
	{
		date_default_timezone_set('America/Sao_Paulo');

		$data = date('d/m/Y');
		$hora = date('H:i');

		$id_remetente = 6003;

		// Consulta
		$query_rementente_pais = $this->db->select('*')
			->from('pais')
			->where('id', $id_responsavel)
			->get();
		$dadosPais = $query_rementente_pais->row_array();
		$contPais = $query_rementente_pais->num_rows();

		$query_rementente_lider = $this->db->select('*')
			->from('lider')
			->where('id_lider', $id_responsavel)
			->get();
		$dadosLider = $query_rementente_lider->row_array();
		$contLider = $query_rementente_lider->num_rows();

		$query_rementente_coord = $this->db->select('*')
			->from('coordenador')
			->where('id_coordenador', $id_responsavel)
			->get();
		$dadosCoord = $query_rementente_coord->row_array();
		$contCoord = $query_rementente_coord->num_rows();

		$query_rementente_sr = $this->db->select('*')
			->from('supervisorr')
			->where('id_supervisorR', $id_responsavel)
			->get();
		$dadosSuperR = $query_rementente_sr->row_array();
		$contSurpR = $query_rementente_sr->num_rows();

		$query_rementente_se = $this->db->select('*')
			->from('supervisore')
			->where('id_supervisorEs', $id_responsavel)
			->get();
		$dadosSuperE = $query_rementente_se->row_array();
		$contSuperE = $query_rementente_se->num_rows();

		$query_rementente_direcao = $this->db->select('*')
			->from('direcao')
			->where('id_direcao', $id_responsavel)
			->get();
		$dadosDirecao = $query_rementente_direcao->row_array();
		$contDirecao = $query_rementente_direcao->num_rows();

		$nome_resposanvel = "";

		if ($contPais == 0) {
		} else {
			$nome_resposanvel .= $dadosPais['nome'];
		}

		if ($contLider == 0) {
		} else {
			$nome_resposanvel .= $dadosLider['nome_lider'];
		}

		if ($contCoord == 0) {
		} else {
			$nome_resposanvel .= $dadosCoord['nome_coordenador'];
		}

		if ($contSurpR == 0) {
		} else {
			$nome_resposanvel .= $dadosSuperR['nome_supervisorR'];
		}

		if ($contSuperE == 0) {
		} else {
			$nome_resposanvel .= $dadosSuperE['nome_supervisorE'];
		}

		if ($contDirecao == 0) {
		} else {
			$nome_resposanvel .= $dadosDirecao['nome_direcao'];
		}
		// Fim Consulta	

		$texto_motivo = "";

		if ($acao == "EX_CL_1") {
			$texto_motivo .= "O (A) " . $nome_resposanvel . " excluiu um de seus colíderes ID - ($id). Por esse motivo - " . $motivo;
		} else if ($acao == "EX_CL_2") {
			$texto_motivo .= "O (A) " . $nome_resposanvel . " excluiu um de seus PG's ID - ($id). Por esse motivo - " . $motivo;
		} else if ($acao == "EX_CL_3") {
			$texto_motivo .= "O (A) " . $nome_resposanvel . " excluiu uma de suas Crianças ID - ($id). Por esse motivo - " . $motivo;
		} else if ($acao == "MUDANCA_DE_MODULO") {
			$texto_motivo .= "O (A) " . $nome_resposanvel . " ($id). " . $motivo;
		}

		$inserir['id_alerta'] = NULL;
		$inserir['id_remetente'] = $id_remetente;
		$inserir['id_emissor'] = $id_responsavel;
		$inserir['acao'] = $acao;
		$inserir['motivo'] = $texto_motivo;
		$inserir['data'] = $data;
		$inserir['hora'] = $hora;
		$this->db->insert('alerta_controle', $inserir);
	}

	// ALERTA - COORDENADOR
	public function alerta_para_coordenador($id_responsavel, $id_remetente, $id, $motivo, $acao)
	{

		date_default_timezone_set('America/Sao_Paulo');
		$data = date('d/m/Y');
		$hora = date('H:i');

		// Consulta
		$query_rementente_pais = $this->db->select('*')
			->from('pais')
			->where('id', $id_responsavel)
			->get();
		$dadosPais = $query_rementente_pais->row_array();
		$contPais = $query_rementente_pais->num_rows();

		$query_rementente_lider = $this->db->select('*')
			->from('lider')
			->where('id_lider', $id_responsavel)
			->get();
		$dadosLider = $query_rementente_lider->row_array();
		$contLider = $query_rementente_lider->num_rows();

		$query_rementente_coord = $this->db->select('*')
			->from('coordenador')
			->where('id_coordenador', $id_responsavel)
			->get();
		$dadosCoord = $query_rementente_coord->row_array();
		$contCoord = $query_rementente_coord->num_rows();

		$query_rementente_sr = $this->db->select('*')
			->from('supervisorr')
			->where('id_supervisorR', $id_responsavel)
			->get();
		$dadosSuperR = $query_rementente_sr->row_array();
		$contSurpR = $query_rementente_sr->num_rows();

		$query_rementente_se = $this->db->select('*')
			->from('supervisore')
			->where('id_supervisorEs', $id_responsavel)
			->get();
		$dadosSuperE = $query_rementente_se->row_array();
		$contSuperE = $query_rementente_se->num_rows();

		$query_rementente_direcao = $this->db->select('*')
			->from('direcao')
			->where('id_direcao', $id_responsavel)
			->get();
		$dadosDirecao = $query_rementente_direcao->row_array();
		$contDirecao = $query_rementente_direcao->num_rows();

		$nome_resposanvel = "";

		if ($contPais == 0) {
		} else {
			$nome_resposanvel .= $dadosPais['nome'];
		}

		if ($contLider == 0) {
		} else {
			$nome_resposanvel .= $dadosLider['nome_lider'];
		}

		if ($contCoord == 0) {
		} else {
			$nome_resposanvel .= $dadosCoord['nome_coordenador'];
		}

		if ($contSurpR == 0) {
		} else {
			$nome_resposanvel .= $dadosSuperR['nome_supervisorR'];
		}

		if ($contSuperE == 0) {
		} else {
			$nome_resposanvel .= $dadosSuperE['nome_supervisorE'];
		}

		if ($contDirecao == 0) {
		} else {
			$nome_resposanvel .= $dadosDirecao['nome_direcao'];
		}
		// Fim Consulta			

		$texto_motivo = "";
		$nome_acao = "";

		if ($acao == "EX_CL_1") {
			$nome_acao = "Exclusão de Colíder";
			$texto_motivo .= "O (A) " . $nome_resposanvel . " excluiu o seu colíderes ID - ($id). Por esse motivo - " . $motivo;
		} else if ($acao == "EX_CL_2") {
			$texto_motivo .= "O (A) " . $nome_resposanvel . " excluiu um de seus PG's ID - ($id). Por esse motivo - " . $motivo;
		} else if ($acao == "EX_CL_3") {
			$texto_motivo .= "O (A) " . $nome_resposanvel . " excluiu uma de suas Crianças ID - ($id). Por esse motivo - " . $motivo;
		} else if ($acao == "MUDANCA_DE_MODULO") {
			$texto_motivo .= "O (A) " . $nome_resposanvel . " ($id). " . $motivo;
		}

		$inserir['id_alerta'] = NULL;
		$inserir['id_remetente'] = $id_remetente;
		$inserir['id_emissor'] = $id_responsavel;
		$inserir['titulo'] = $nome_acao;
		$inserir['assunto'] = $texto_motivo;
		$inserir['data'] = $data;
		$inserir['hora'] = $hora;
		$this->db->insert('alerta', $inserir);
	}

	// Alerta
	public function excluir_alerta($id_alerta)
	{

		$this->db->where("id_alerta", $id_alerta);

		if ($this->db->delete("alerta")) {

			$this->db->query("ALTER TABLE alerta AUTO_INCREMENT = 1");
			echo "Alerta Excluido";
		} else {
			echo "Error";
		}
	}
	// Fim Alerta

	function valida_cpf($cpf = false)
	{
		if (!function_exists('calc_digitos_posicoes')) {
			function calc_digitos_posicoes($digitos, $posicoes = 10, $soma_digitos = 0)
			{
				for ($i = 0; $i < strlen($digitos); $i++) {
					$soma_digitos = $soma_digitos + ($digitos[$i] * $posicoes);
					$posicoes--;
				}

				$soma_digitos = $soma_digitos % 11;

				// Verifica se $soma_digitos é menor que 2
				if ($soma_digitos < 2) {
					// $soma_digitos agora será zero
					$soma_digitos = 0;
				} else {
					$soma_digitos = 11 - $soma_digitos;
				}

				$cpf = $digitos . $soma_digitos;

				// Retorna
				return $cpf;
			}
		}

		// Verifica se o CPF foi enviado
		if (!$cpf) {
			return false;
		}

		if ($cpf == "00000000000" || $cpf == "11111111111" || $cpf == "22222222222" || $cpf == "33333333333" || $cpf == "44444444444" || $cpf == "55555555555" || $cpf == "66666666666" || $cpf == "77777777777" || $cpf == "88888888888" || $cpf == "99999999999" || $cpf == "000.000.000-00" || $cpf == "111.111.111-11" || $cpf == "222.222.222-22" || $cpf == "333.333.333-33" || $cpf == "444.444.444-44" || $cpf == "555.555.555-55" || $cpf == "666.666.666-66" || $cpf == "777.777.777-77" || $cpf == "888.888.888-88" || $cpf == "999.999.999-99") {
			return false;
		}

		// Remove tudo que não é número do CPF
		// Ex.: 025.462.884-23 = 02546288423
		$cpf = preg_replace('/[^0-9]/is', '', $cpf);

		// Verifica se o CPF tem 11 caracteres
		// Ex.: 02546288423 = 11 números
		if (strlen($cpf) != 11) {
			return false;
		}

		// Captura os 9 primeiros dígitos do CPF
		// Ex.: 02546288423 = 025462884
		$digitos = substr($cpf, 0, 9);

		// Faz o cálculo dos 9 primeiros dígitos do CPF para obter o primeiro dígito
		$novo_cpf = calc_digitos_posicoes($digitos);

		// Faz o cálculo dos 10 dígitos do CPF para obter o último dígito
		$novo_cpf = calc_digitos_posicoes($novo_cpf, 11);

		// Verifica se o novo CPF gerado é idêntico ao CPF enviado
		if ($novo_cpf === $cpf) {
			// CPF válido
			return true;
		} else {
			// CPF inválido
			return false;
		}
	}

	function validaNIF($nif, $ignoreFirst = true)
	{
		//Limpamos eventuais espaços a mais
		$nif = trim($nif);

		//Verificamos se é numérico e tem comprimento 9
		if (!is_numeric($nif) || strlen($nif) != 9) {
			return false;
		} else {
			$nifSplit = str_split($nif);
			//O primeiro digíto tem de ser 1, 2, 3, 5, 6, 8 ou 9
			//Ou não, se optarmos por ignorar esta "regra"
			if (
				in_array($nifSplit[0], array(1, 2, 3, 5, 6, 7, 8, 9))
				||
				$ignoreFirst
			) {
				//Calculamos o dígito de controlo
				$checkDigit = 0;
				for ($i = 0; $i < 8; $i++) {
					$checkDigit += $nifSplit[$i] * (10 - $i - 1);
				}

				$checkDigit = 11 - ($checkDigit % 11);

				//Se der 10 então o dígito de controlo tem de ser 0
				if ($checkDigit >= 10) $checkDigit = 0;

				//Comparamos com o último dígito
				if ($checkDigit == $nifSplit[8]) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
	}

	function ValidaData($dat)
	{

		$data = explode("/", "$dat"); // fatia a string $dat em pedados, usando / como referência

		$d = $data[0];
		$m = $data[1];
		$y = $data[2];

		// verifica se a data é válida!
		// 1 = true (válida)
		// 0 = false (inválida)

		$res = checkdate($m, $d, $y);
		if ($res == 1) {
			return true;
		} else {
			return false;
		}
	}
}
