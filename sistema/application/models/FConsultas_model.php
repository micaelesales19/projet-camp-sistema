<?php

/**
 * @property $db
 * @property $load
 * @property $uri
 */

class FConsultas_model extends CI_Model
{
	protected $active_group;
	protected $db2; // <------ ADICIONE

	public function __construct()
	{
		parent::__construct();
		$this->connect();
		date_default_timezone_set('America/Sao_Paulo');
	}

	public function __destruct()
	{
		$this->db->close();
	}

	public function connect($active_group = 'default')
	{
		$this->active_group = $active_group;
		$this->load->database($active_group, TRUE);

		// ADICIONE ISTO ABAIXO
		$db2 = $this->load->database('auxiliar', TRUE);
		$this->db2 = $db2;
	}
	public function mensagem($class, $titulo, $mensagem)
	{
		$dados = array(
			'class' => $class,
			'titulo' => $titulo,
			'mensagem' => $mensagem,
		);

		$this->load->view('mensagem', $dados);
	}

	public function converterData($data)
	{
		// normaliza entrada
		$data = trim((string)$data);
		if ($data === '') return false;

		// 1) se já está no formato Y-m-d e é válido, retorna como está
		$dt = DateTime::createFromFormat('Y-m-d', $data);
		if ($dt && $dt->format('Y-m-d') === $data) {
			return $data;
		}

		// 2) tenta vários formatos comuns
		$formatos = [
			'd/m/Y',
			'd-m-Y',
			'j/n/Y',
			'j-n-Y', // sem zero à esquerda
			'd/m/y',
			'd-m-y',
			'Y/m/d',
			'Y.n.j',
			'd M Y',
			'd F Y' // por precaução (ex: 1 Jan 2024)
		];

		foreach ($formatos as $fmt) {
			$dt = DateTime::createFromFormat($fmt, $data);
			if ($dt !== false) {
				// valida erros de parsing (por exemplo 32/13/2020)
				$errors = DateTime::getLastErrors();
				if ($errors['warning_count'] === 0 && $errors['error_count'] === 0) {
					return $dt->format('Y-m-d');
				}
			}
		}

		// 3) tenta extrair só dígitos e formar DDMMYYYY ou YYYYMMDD
		$nums = preg_replace('/\D+/', '', $data);
		if (strlen($nums) === 8) {
			// tenta assumir DDMMYYYY primeiro
			$d = substr($nums, 0, 2);
			$m = substr($nums, 2, 2);
			$y = substr($nums, 4, 4);
			if (checkdate((int)$m, (int)$d, (int)$y)) {
				return sprintf('%04d-%02d-%02d', $y, $m, $d);
			}
			// tenta YYYYMMDD
			$y = substr($nums, 0, 4);
			$m = substr($nums, 4, 2);
			$d = substr($nums, 6, 2);
			if (checkdate((int)$m, (int)$d, (int)$y)) {
				return sprintf('%04d-%02d-%02d', $y, $m, $d);
			}
		}

		// 4) tenta strtotime() — último recurso (pode falhar com formatos ambíguos)
		$ts = strtotime($data);
		if ($ts !== false) {
			return date('Y-m-d', $ts);
		}

		// Não conseguiu converter — retorna false para ser tratado pelo chamador
		return false;
	}

	public function getInfoUserId($id)
	{
		$query_rementente_lider = $this->db->select('*')
			->from('lider')
			->where('id_lider', $id)
			->get();
		$dadosLider = $query_rementente_lider->row_array();
		$contLider = $query_rementente_lider->num_rows();

		$query_rementente_coord = $this->db->select('*')
			->from('coordenador')
			->where('id_coordenador', $id)
			->get();
		$dadosCoord = $query_rementente_coord->row_array();
		$contCoord = $query_rementente_coord->num_rows();

		$query_rementente_sr = $this->db->select('*')
			->from('supervisor_local')
			->where('id_supervisorR', $id)
			->get();
		$dadosSuperR = $query_rementente_sr->row_array();
		$contSurpR = $query_rementente_sr->num_rows();

		$query_rementente_se = $this->db->select('*')
			->from('supervisor_regional')
			->where('id_supervisorEs', $id)
			->get();
		$dadosSuperE = $query_rementente_se->row_array();
		$contSuperE = $query_rementente_se->num_rows();

		$query_rementente_direcao = $this->db->select('*')
			->from('direcao')
			->where('id_direcao', $id)
			->get();
		$dadosDirecao = $query_rementente_direcao->row_array();
		$contDirecao = $query_rementente_direcao->num_rows();

		if ($contLider == 0 && $contCoord == 0 && $contSurpR == 0 && $contSuperE == 0 && $contDirecao == 0) {
			return false;
		} else {

			if ($contLider == 0) {
			} else {
				$dados = array(
					'row' => $contLider,
					'dados' => $dadosLider,
				);
				return $dados;
			}

			if ($contCoord == 0) {
			} else {
				$dados = array(
					'row' => $contCoord,
					'dados' => $dadosCoord,
				);
				return $dados;
			}

			if ($contSurpR == 0) {
			} else {
				$dados = array(
					'row' => $contSurpR,
					'dados' => $dadosSuperR,
				);
				return $dados;
			}

			if ($contSuperE == 0) {
			} else {
				$dados = array(
					'row' => $contSuperE,
					'dados' => $dadosSuperE,
				);
				return $dados;
			}

			if ($contDirecao == 0) {
			} else {
				$dados = array(
					'row' => $contDirecao,
					'dados' => $dadosDirecao,
				);
				return $dados;
			}
		}
	}

	public function getNomeUserId($id)
	{

		$query_rementente_lider = $this->db->select('*')
			->from('lider')
			->where('id_lider', $id)
			->get();
		$dadosLider = $query_rementente_lider->row_array();
		$contLider = $query_rementente_lider->num_rows();

		$query_rementente_colider = $this->db->select('*')
			->from('colider')
			->where('id_colider', $id)
			->get();
		$dadosCoLider = $query_rementente_colider->row_array();
		$contCoLider = $query_rementente_colider->num_rows();

		$query_rementente_coord = $this->db->select('*')
			->from('coordenador')
			->where('id_coordenador', $id)
			->get();
		$dadosCoord = $query_rementente_coord->row_array();
		$contCoord = $query_rementente_coord->num_rows();

		$query_rementente_sr = $this->db->select('*')
			->from('supervisor_local')
			->where('id_supervisorR', $id)
			->get();
		$dadosSuperR = $query_rementente_sr->row_array();
		$contSurpR = $query_rementente_sr->num_rows();

		$query_rementente_se = $this->db->select('*')
			->from('supervisor_regional')
			->where('id_supervisorEs', $id)
			->get();
		$dadosSuperE = $query_rementente_se->row_array();
		$contSuperE = $query_rementente_se->num_rows();

		$query_rementente_direcao = $this->db->select('*')
			->from('direcao')
			->where('id_direcao', $id)
			->get();
		$dadosDirecao = $query_rementente_direcao->row_array();
		$contDirecao = $query_rementente_direcao->num_rows();

		if ($contCoLider == 0 && $contLider == 0 && $contCoord == 0 && $contSurpR == 0 && $contSuperE == 0 && $contDirecao == 0) {
			return false;
		} else {

			if ($contCoLider == 0) {
			} else {
				$dados = array(
					'row' => $contCoLider,
					'nome' => $dadosCoLider['nome_colider'],
				);
				return $dados;
			}


			if ($contLider == 0) {
			} else {
				$dados = array(
					'row' => $contLider,
					'nome' => $dadosLider['nome_lider'],
				);
				return $dados;
			}

			if ($contCoord == 0) {
			} else {
				$dados = array(
					'row' => $contCoord,
					'nome' => $dadosCoord['nome_coordenador'],
				);
				return $dados;
			}

			if ($contSurpR == 0) {
			} else {
				$dados = array(
					'row' => $contSurpR,
					'nome' => $dadosSuperR['nome_supervisorR'],
				);
				return $dados;
			}

			if ($contSuperE == 0) {
			} else {
				$dados = array(
					'row' => $contSuperE,
					'nome' => $dadosSuperE['nome_supervisorE'],
				);
				return $dados;
			}

			if ($contDirecao == 0) {
			} else {
				$dados = array(
					'row' => $contDirecao,
					'nome' => $dadosDirecao['nome_direcao'],
				);
				return $dados;
			}
		}
	}

	function red($route, $time, $data)
	{

		$funcao = "
			<br>
			<form action='$route' method='post' id='dateForm'>

			";

		foreach ($data as $valor) {
			$funcao .= $valor;
		}

		$funcao .= "
			</form>

			<script type='text/javascript'>

				setTimeout(function(){
					document.getElementById('dateForm').submit(); // SUBMIT FORM
				}, $time);

			</script>
		";

		//setTimeout(function(){ $('#dateForm').submit(); }, 3000);
		return $funcao;
	}

	public function checkControler($idLider, $idPg, $anoPg, $modulo, $licao, $diaDevocional)
	{
		$controller = $this->db->select("*")
			->from("controle_envio_email_devocional")
			->where("idLider", $idLider)
			->where("idPG", $idPg)
			->where("anoController", $anoPg)
			->where("moduloController", $modulo)
			->where("licaoController", $licao)
			->where("dia", $diaDevocional)
			->where("sucesso", 1)
			->get();
		$rowController = $controller->num_rows();
		return $rowController;
	}

	public function consultarModulo()
	{
		$consultar = $this->db->query("SELECT * FROM modulo ORDER BY id_modulo ASC");
		$row = $consultar->num_rows();
		$dados = $consultar->result_array();

		if ($row == 0) {
			return false;
		} else {
			return $dados;
		}
	}

	public function list_modulos_informacoes($ciclo, $idModulo)
	{
		$consultar = $this->db->query("SELECT * FROM modulo WHERE ano LIKE '$ciclo' AND id_modulo LIKE '$idModulo'");
		$row = $consultar->num_rows();
		$dados = $consultar->row_array();

		if ($row == 0) {
			return false;
		} else {
			return $dados;
		}
	}

	public function consultarModuloAno($id_ano)
	{
		$consultar = $this->db->query("SELECT * FROM modulo WHERE ano LIKE '$id_ano' ORDER BY ordem ASC");
		$row = $consultar->num_rows();
		$dados = $consultar->result_array();

		if ($row == 0) {
			return false;
		} else {
			return $dados;
		}
	}

	public function consultarModuloId($id_modulo)
	{
		$consultar = $this->db->query("SELECT * FROM modulo WHERE id_modulo = '$id_modulo'");
		$dados = $consultar->row_array();
		return $dados;
	}

	public function consultarLicaoModulo($id_modulo)
	{
		$consultar = $this->db->query("SELECT * FROM licao WHERE id_modulo = $id_modulo ORDER BY numero_licao ASC");
		$row = $consultar->num_rows();
		$dados = $consultar->result_array();

		if ($row == 0) {
			return false;
		} else {
			return $dados;
		}
	}

	public function consultarLicaoId($id_modulo, $id_licao)
	{
		$consultar = $this->db->query("SELECT * FROM licao WHERE id_modulo = $id_modulo AND numero_licao = $id_licao");
		$dados = $consultar->row_array();

		return $dados;
	}

	public function consultarDevocionalModuloLicaoDia($ano, $modulo, $licao, $dia)
	{
		$consultar = $this->db->query("SELECT * FROM semanarios WHERE id_ano LIKE $ano AND id_modulo LIKE $modulo AND n_licao LIKE $licao AND dia = $dia");
		$row = $consultar->num_rows();
		$dados = $consultar->row_array();

		if ($row == 0) {
			return false;
		} else {
			return $dados;
		}
	}

	public function consultarDevocionaTodos()
	{
		$consultar = $this->db->query("SELECT * FROM semanarios ORDER BY n_licao ASC");
		$row = $consultar->num_rows();
		$dados = $consultar->result_array();
		return $dados;
	}

	public function consultarDevocionalModuloLicao($ano, $modulo, $licao)
	{
		$consultar = $this->db->query("SELECT * FROM semanarios WHERE id_ano LIKE $ano AND id_modulo LIKE $modulo AND n_licao LIKE $licao ORDER BY dia ASC");
		$row = $consultar->num_rows();
		$dados = $consultar->result_array();

		if ($row == 0) {
			return false;
		} else {
			return $dados;
		}
	}

	public function consultarTodosDevocionais()
	{
		$consultar = $this->db->query("SELECT * FROM semanarios");
		$dados_consula_colider = $consultar->result_array();
		return $dados_consula_colider;
	}

	public function formatar_telefone($telefone, $is_br)
	{
		$telefone_formatado = '';
		if ($telefone == '') {
		} else {
			$numeroLimpo = preg_replace('/\D/', '', $telefone);
			if ($is_br) {
				if ($numeroLimpo[0] == '5') {
					$telefone_formatado = $numeroLimpo;
				} else {
					$telefone_formatado = "55" . $numeroLimpo;
				}
			} else {
				$telefone_formatado = $numeroLimpo;
			}
		}

		return $telefone_formatado;
	}

	function gerarCodigo($length = 10)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[Rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	function gerarLink()
	{
		for ($i = true; $i == true; $i) {

			$codigo = $this->gerarCodigo();

			$consultarLink = $this->db->select("*")
				->from("link_cadastro")
				->where("codigo", $codigo)
				->get();
			$totalLink = $consultarLink->num_rows();
			if ($totalLink == 0) {
				return $codigo;
			} else {
				return true;
			}
		}
	}

	function check_codigo($codigo)
	{
		$consultarLink = $this->db->select("*")
			->from("link_cadastro")
			->where("codigo", $codigo)
			->get();
		$totalLink = $consultarLink->num_rows();
		if ($totalLink == 0) {
			return false;
		} else {
			return true;
		}
	}


	function infos_codigo($codigo): mixed
	{
		$consultarLink = $this->db->select("*")
			->from("link_cadastro")
			->where("codigo", $codigo)
			->get();
		$link = $consultarLink->row_array();
		return $link;
	}
}
