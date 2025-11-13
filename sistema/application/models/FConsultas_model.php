<?php

/**
 * @property $db
 * @property $load
 * @property $uri
 * @property $FSistema_model
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

	/*public function mostrar_info_user($id_usuario)
	{
		$consultar_pg = $this->db->query("SELECT * FROM usuario WHERE id_usuario LIKE $id_usuario");
		$row = $consultar_pg->num_rows();
		$dados_consulta_pg = $consultar_pg->row_array();

		$dados = array(
			'row' => $row,
			'dados' => $dados_consulta_pg,
		);
		return $dados;
	}*/

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

	/*function Ordena_Array($array, $campo)
	{
		usort($array, function ($a, $b) use ($campo) {
			return $a[$campo] > $b[$campo];
		});
		return $array;
	}*/

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

	/*public function get_url()
	{
		$url_1 = $this->uri->segment(1);
		$url_2 = $this->uri->segment(2);
		$url_3 = $this->uri->segment(3);

		$url = $url_1 . '/' . $url_2 . '/' . $url_3;

		if ($this->uri->segment(4) != '') {
			$url .= '/' . $this->uri->segment(4);
		}

		if ($this->uri->segment(5) != '') {
			$url .= '/' . $this->uri->segment(5);
		}

		if ($this->uri->segment(6) != '') {
			$url .= '/' . $this->uri->segment(6);
		}

		if ($this->uri->segment(7) != '') {
			$url .= '/' . $this->uri->segment(6);
		}

		return $url;
	}*/

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

	/*public function list_modulos_informacoes($ciclo, $idModulo)
	{
		$consultar = $this->db->query("SELECT * FROM modulo WHERE ano LIKE '$ciclo' AND id_modulo LIKE '$idModulo'");
		$row = $consultar->num_rows();
		$dados = $consultar->row_array();

		if ($row == 0) {
			return false;
		} else {
			return $dados;
		}
	}*/

	/*public function consultaraisJaTerminouOTreinamento($nome, $email, $nascimento)
	{
		$consultar = $this->db2->query("SELECT * FROM aluno WHERE nome LIKE '$nome' AND email = '$email' AND nascimento = '$nascimento'");
		$row = $consultar->num_rows();
		$dados_consultar = $consultar->row_array();

		if ($row == 0) {
			return false;
		} else {
			$idLider = $dados_consultar['id'];

			$consultar_progressso = $this->db2->query("SELECT * FROM progresso_geral WHERE id_lider LIKE '$idLider'");
			$rowProgresso = $consultar_progressso->num_rows();
			$dados_consultarProgresso = $consultar_progressso->row_array();

			if ($rowProgresso == 0) {
				return false;
			} else {
				$id_aula = $dados_consultarProgresso['id_aula'];
				if ($id_aula == 10) {
					return true;
				} else {
					return false;
				}
			}
		}
	}*/

	/*public function consultarLiderJaCadastrado($nome, $cpf, $cpf2, $email)
	{
		$consultar_1 = $this->db->query("SELECT * FROM lider WHERE nome_lider LIKE '$nome' OR cpf = '$cpf' OR cpf = '$cpf2' OR email = '$email'");
		$row_1 = $consultar_1->num_rows();

		$consultar_2 = $this->db->query("SELECT * FROM coordenador WHERE nome_coordenador LIKE '$nome' OR cpf = '$cpf' OR cpf = '$cpf2' OR email = '$email'");
		$row_2 = $consultar_2->num_rows();

		$consultar_3 = $this->db->query("SELECT * FROM supervisor_local WHERE nome_supervisorR LIKE '$nome' OR cpf = '$cpf' OR cpf = '$cpf2' OR email = '$email'");
		$row_3 = $consultar_3->num_rows();

		$consultar_4 = $this->db->query("SELECT * FROM supervisor_regional WHERE nome_supervisorE LIKE '$nome' OR cpf = '$cpf' OR cpf = '$cpf2' OR email = '$email'");
		$row_4 = $consultar_4->num_rows();

		$consultar_5 = $this->db->query("SELECT * FROM direcao WHERE nome_direcao LIKE '$nome' OR cpf = '$cpf' OR cpf = '$cpf2' OR email = '$email'");
		$row_5 = $consultar_5->num_rows();

		if ($row_1 != 0 || $row_2 != 0 || $row_3 != 0 || $row_4 != 0 || $row_5 != 0) {
			return 1;
		} else {
			return 0;
		}
	}

	public function consultarUsuarioJaCadastrado($nome, $cpf, $cpf2, $email)
	{
		$consultar = $this->db->query("SELECT * FROM usuario WHERE nome LIKE '$nome' OR cpf = '$cpf' OR cpf = '$cpf2' OR email = '$email'");
		$row = $consultar->num_rows();

		return $row;
	}*/
	// já revisou

	// mostrar pais
	/*public function mostrar_pais($id_usuario)
	{
		$consultar_lider = $this->db->query("SELECT * FROM lider WHERE id_lider LIKE $id_usuario");
		$dados_consultar_lider = $consultar_lider->row_array();
		$pais = $dados_consultar_lider['pais'];

		if ($pais == "br") {
			return true;
		} else {
			return false;
		}
	}*/

	// mostrar_usuario
	/*public function mostrar_registro_tabela($email, $cpf)
	{
		$query_rementente_colider = $this->db->select('*')
			->from('colider')
			->where('cpf', $cpf)
			->or_where('email', $email)
			->get();
		$contCoLider = $query_rementente_colider->num_rows();

		$query_rementente_lider = $this->db->select('*')
			->from('lider')
			->where('cpf', $cpf)
			->or_where('email', $email)
			->get();
		$contLider = $query_rementente_lider->num_rows();

		$query_rementente_pastor = $this->db->select('*')
			->from('pastor')
			->where('cpf', $cpf)
			->or_where('email', $email)
			->get();
		$contPastor = $query_rementente_pastor->num_rows();

		$query_rementente_coord = $this->db->select('*')
			->from('coordenador')
			->where('cpf', $cpf)
			->or_where('email', $email)
			->get();
		$contCoord = $query_rementente_coord->num_rows();

		$query_rementente_sr = $this->db->select('*')
			->from('supervisor_local')
			->where('cpf', $cpf)
			->or_where('email', $email)
			->get();
		$contSurpR = $query_rementente_sr->num_rows();

		$query_rementente_se = $this->db->select('*')
			->from('supervisor_regional')
			->where('cpf', $cpf)
			->or_where('email', $email)
			->get();
		$contSuperE = $query_rementente_se->num_rows();

		$query_rementente_direcao = $this->db->select('*')
			->from('direcao')
			->where('cpf', $cpf)
			->or_where('email', $email)
			->get();
		$contDirecao = $query_rementente_direcao->num_rows();

		$query_rementente_usuario = $this->db->select('*')
			->from('usuario')
			->where('cpf', $cpf)
			->or_where('email', $email)
			->get();
		$contUsu = $query_rementente_usuario->num_rows();

		if ($contCoLider == 0 and $contLider == 0 and $contPastor == 0 and $contCoord == 0 and $contSurpR == 0 and $contSuperE == 0 and $contDirecao == 0 and $contUsu == 0) {
			return true;
		} else {
			return false;
		}
	}*/

	/*public function mostrar_pastor($id_pastor)
	{
		$consultar_pastor = $this->db->query("SELECT * FROM pastor WHERE id_pastor LIKE $id_pastor ORDER BY nome_pastor ASC");
		$row = $consultar_pastor->num_rows();
		$dados_consulta_pastor = $consultar_pastor->result_array();

		if ($row == 0) {
			echo '<option value="' . $id_pastor . '">Falta de Dados</option>';
		} else {
			foreach ($dados_consulta_pastor as $dados_pastor) {
				echo '<option value="' . $dados_pastor['id_pastor'] . '" selected>' . $dados_pastor['nome_pastor'] . '</option>';
			}
		}
	}*/

	/*public function mostrar_coordenador($id_coordenador)
	{
		$consultar_coordenador = $this->db->query("SELECT * FROM coordenador WHERE id_coordenador LIKE $id_coordenador ORDER BY nome_coordenador ASC");
		$row = $consultar_coordenador->num_rows();
		$dados_consulta_coord = $consultar_coordenador->result_array();

		if ($row == 0) {
			echo '<option value="' . $id_coordenador . '">Falta de Dados</option>';
		} else {
			foreach ($dados_consulta_coord as $dados_coord) {
				echo '<option value="' . $dados_coord['id_coordenador'] . '" selected>' . $dados_coord['nome_coordenador'] . '</option>';
			}
		}
	}*/

	/*public function mostrar_all_coordenador()
	{
		$consultar_coordenador = $this->db->query("SELECT * FROM coordenador");
		$row = $consultar_coordenador->num_rows();
		$dados_consulta_coordenador = $consultar_coordenador->result_array();

		$dados = array(
			'row' => $row,
			'dados' => $dados_consulta_coordenador,
		);

		return $dados;
	}*/

	/*public function mostrar_sr($id_sr)
	{
		$consultar_sr = $this->db->query("SELECT * FROM supervisor_local WHERE id_supervisorR LIKE $id_sr ORDER BY nome_supervisorR ASC");
		$row = $consultar_sr->num_rows();
		$dados_consulta_sr = $consultar_sr->result_array();

		if ($row == 0) {
			echo '<option value="' . $id_sr . '">Falta de Dados</option>';
		} else {
			foreach ($dados_consulta_sr as $dados_sr) {
				echo '<option value="' . $dados_sr['id_supervisorR'] . '" selected>' . $dados_sr['nome_supervisorR'] . '</option>';
			}
		}
	}*/

	/*public function mostrar_se($id_se)
	{
		$consultar_se = $this->db->query("SELECT * FROM supervisor_regional WHERE id_supervisorEs LIKE $id_se ORDER BY nome_supervisorE ASC");
		$row = $consultar_se->num_rows();
		$dados_consulta_se = $consultar_se->result_array();

		if ($row == 0) {
			echo '<option value="' . $id_se . '">Falta de Dados</option>';
		} else {
			foreach ($dados_consulta_se as $dados_se) {
				echo '<option value="' . $dados_se['id_supervisorEs'] . '" selected>' . $dados_se['nome_supervisorE'] . '</option>';
			}
		}
	}*/

	/*Colíder*/
	/*public function checkColider($nome, $cpf, $email, $telefone)
	{
		$consultar_colider = $this->db->query("SELECT * FROM colider WHERE nome_colider LIKE '$nome' OR email LIKE '$email' OR cpf LIKE '$cpf' OR telefone_whatsapp LIKE '$telefone'");
		$row = $consultar_colider->num_rows();

		if ($row == 0) {
			return true;
		} else {
			return false;
		}
	}*/

	/*public function mostrarColider($id_colider)
	{
		$consultar_colider = $this->db->query("SELECT * FROM colider WHERE id_colider LIKE $id_colider");
		$row = $consultar_colider->num_rows();
		$dados_consula_colider = $consultar_colider->row_array();

		if ($row == 0) {
			return false;
		} else {
			return $dados_consula_colider;
		}
	}*/

	/*public function mostrarColiderDoLider($id_usuario)
	{
		$consultar_colider = $this->db->query("SELECT * FROM colider WHERE id_lider LIKE $id_usuario AND ativo = 1 ORDER BY nome_colider ASC");
		$row = $consultar_colider->num_rows();
		$dados_consula_colider = $consultar_colider->row_array();

		if ($row == 0) {
			return false;
		} else {
			return $dados_consula_colider;
		}
	}*/

	/*public function mostrarColiderDoLiderDesativados($id_usuario)
	{
		$consultar_colider = $this->db->query("SELECT * FROM colider WHERE id_lider LIKE $id_usuario AND ativo = 0 ORDER BY nome_colider ASC");
		$row = $consultar_colider->num_rows();
		$dados_consula_colider = $consultar_colider->result_array();

		$dados = array(
			'row' => $row,
			'dados' => $dados_consula_colider,
		);

		return $dados;
	}*/

	/*public function mostrarTodosLideres()
	{
		// adicionar outros níveis
		$dados = $this->db->query("SELECT * FROM lider WHERE confirmado LIKE 2 AND pais LIKE 'br'")->result_array();
		return $dados;
	}*/

	/*public function consultaDadosLiderNomeCPFEMail($nome, $cpf, $cpf2, $email)
	{
		$consultar = $this->db->query("SELECT * FROM lider WHERE nome_lider LIKE '$nome' OR cpf = '$cpf' OR cpf = '$cpf2' OR email = '$email'");
		$dados = $consultar->row_array();
		return $dados;
	}*/

	/*public function consultaraisJaCadastrado($nome, $cpf, $cpf2, $email)
	{
		$consultar = $this->db->query("SELECT * FROM lider WHERE nome_lider LIKE '$nome' OR cpf = '$cpf' OR cpf = '$cpf2' OR email = '$email'");
		$row = $consultar->num_rows();
		if ($row == 0) {
			return true;
		} else {
			return false;
		}
	}*/

	/*public function mostrarPG($id_usuario, $x)
	{
		if ($x == 2) {
			$consultar_pg = $this->db->query("SELECT * FROM pg WHERE id_lider LIKE $id_usuario AND ativo = 1 ORDER BY nome_pg ASC");
			$row = $consultar_pg->num_rows();
			$dados_consulta_pg = $consultar_pg->result_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_pg,
			);
			return $dados;
		} else if ($x == 3) {
			$consultar_pg = $this->db->query("SELECT * FROM pg WHERE id_lider LIKE $id_usuario ORDER BY id_modulo DESC");
			$row = $consultar_pg->num_rows();
			$dados_consulta_pg = $consultar_pg->row_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_pg,
			);
			return $dados;
		}
		if ($x == 5) {
			$consultar_pg = $this->db->query("SELECT * FROM pg WHERE id_lider LIKE '$id_usuario'");
			$row = $consultar_pg->num_rows();
			$dados_consulta_pg = $consultar_pg->result_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_pg,
			);
			return $dados;
		}
	}*/

	public function mostrarPGDesativados($id_usuario)
	{

		$consultar_pg = $this->db->query("SELECT * FROM pg WHERE id_lider LIKE $id_usuario AND ativo = 0 ORDER BY nome_pg ASC");
		$row = $consultar_pg->num_rows();
		$dados_consulta_pg = $consultar_pg->result_array();

		$dados = array(
			'row' => $row,
			'dados' => $dados_consulta_pg,
		);
		return $dados;
	}

	public function mostrarPGDownload($id_usuario, $x)
	{
		$consultar_pg = $this->db->query("SELECT * FROM pg WHERE id_lider LIKE $id_usuario AND ativo = 1 ORDER BY id_modulo DESC LIMIT 1");
		$row = $consultar_pg->num_rows();
		$dados_consulta_pg = $consultar_pg->row_array();

		$dados = array(
			'row' => $row,
			'dados' => $dados_consulta_pg,
		);
		return $dados;
	}

	public function consultarPgCadastrado($idLider, $nomePg)
	{
		$consultar_pg = $this->db->query("SELECT * FROM pg WHERE id_lider = $idLider AND nome_pg LIKE '$nomePg'");
		$row = $consultar_pg->num_rows();

		if ($row == 0) {
			return true;
		} else {
			return false;
		}
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

	public function consultarProgressoGeral($id_lider)
	{
		$consultar = $this->db->query("SELECT * FROM progresso_pg WHERE id_lider = $id_lider");
		$row = $consultar->num_rows();
		$dados = $consultar->result_array();

		$array = array(
			'row' => $row,
			'dados' => $dados,
		);

		return $array;
	}

	public function consultarProgressoPG($id_pg, $id_lider, $id_modulo, $numero_licao)
	{
		$consultar = $this->db->query("SELECT * FROM progresso_pg WHERE id_pg = $id_pg AND id_lider = '$id_lider' AND id_modulo = '$id_modulo' AND numero_licao = '$numero_licao'");
		$row = $consultar->num_rows();
		$dados = $consultar->row_array();

		$array = array(
			'row' => $row,
			'dados' => $dados,
		);

		return $array;
	}

	public function consultarProgressoCriancaIndividual($id_pg, $id_lider, $id_crianca, $id_modulo)
	{
		$consultar = $this->db->query("SELECT * FROM progresso_pg WHERE id_pg = $id_pg AND id_lider = $id_lider AND id_crianca_presente = $id_crianca AND id_modulo = $id_modulo");
		$row = $consultar->num_rows();
		$dados = $consultar->result_array();

		$array = array(
			'row' => $row,
			'dados' => $dados,
		);

		return $array;
	}


	public function checkCriancasPG($idLider, $idPG)
	{
		$consultar_criancas = $this->db->query("SELECT * FROM criancas WHERE lider LIKE $idLider AND id_pg = $idPG");
		$row = $consultar_criancas->num_rows();

		if ($row == 0) {
			return false;
		} else {
			return true;
		}
	}

	public function mostrarCriancasPaisPgTodos($id_usuario, $idPG)
	{
		$consultar_criancas = $this->db->query("SELECT * FROM criancas WHERE lider LIKE $id_usuario AND id_pg = $idPG ORDER BY nome_crianca ASC");
		$row = $consultar_criancas->num_rows();
		$dados_consulta_criancas = $consultar_criancas->result_array();

		$dados = array(
			'row' => $row,
			'dados' => $dados_consulta_criancas,
		);

		return $dados;
	}

	public function mostrarCriancasPais($id_usuario)
	{
		$consultar_criancas = $this->db->query("SELECT * FROM criancas WHERE lider LIKE '$id_usuario'");
		$row = $consultar_criancas->num_rows();
		$dados_consulta_criancas = $consultar_criancas->result_array();

		$dados = array(
			'row' => $row,
			'dados' => $dados_consulta_criancas,
		);

		return $dados;
	}

	public function mostrarCriancasPaisPg($id_usuario, $idPG)
	{
		$consultar_criancas = $this->db->query("SELECT * FROM criancas WHERE lider LIKE $id_usuario AND id_pg = $idPG AND ativo = 1 ORDER BY nome_crianca ASC");
		$row = $consultar_criancas->num_rows();
		$dados_consulta_criancas = $consultar_criancas->result_array();

		$dados = array(
			'row' => $row,
			'dados' => $dados_consulta_criancas,
		);

		return $dados;
	}

	public function mostrarCriancasPaisID($id_usuario, $idPG, $id_crianca)
	{
		$consultar_criancas = $this->db->query("SELECT * FROM criancas WHERE lider LIKE $id_usuario AND id_pg = $idPG AND ativo = 1 AND id_crianca = $id_crianca");
		$row = $consultar_criancas->num_rows();
		$dados_consulta_criancas = $consultar_criancas->row_array();

		$dados = array(
			'row' => $row,
			'dados' => $dados_consulta_criancas,
		);

		return $dados;
	}

	public function mostrarCriancasDesativadas($id_usuario)
	{
		$consultar_criancas = $this->db->query("SELECT * FROM criancas WHERE lider LIKE $id_usuario AND ativo = 0 ORDER BY nome_crianca ASC");
		$row = $consultar_criancas->num_rows();
		$dados_consulta_criancas = $consultar_criancas->result_array();

		$dados = array(
			'row' => $row,
			'dados' => $dados_consulta_criancas,
		);

		return $dados;
	}

	public function mostrarCriancasPaisPgDesativadas($id_usuario, $idPG)
	{
		$consultar_criancas = $this->db->query("SELECT * FROM criancas WHERE lider LIKE $id_usuario AND id_pg = $idPG AND ativo = 0 ORDER BY nome_crianca ASC");
		$row = $consultar_criancas->num_rows();
		$dados_consulta_criancas = $consultar_criancas->result_array();

		$dados = array(
			'row' => $row,
			'dados' => $dados_consulta_criancas,
		);

		return $dados;
	}

	public function mostrarCriancasPaisDesativadas($id_usuario, $id_crianca)
	{
		$consultar_criancas = $this->db->query("SELECT * FROM alcancado_crianca WHERE id_lider LIKE $id_usuario AND id_crianca = $id_crianca");
		$row = $consultar_criancas->num_rows();
		$dados_consulta_criancas = $consultar_criancas->row_array();

		$dados = array(
			'row' => $row,
			'dados' => $dados_consulta_criancas,
		);

		return $dados;
	}

	public function consultarCriancasNomeEIdade($nome, $idLider, $idPG, $nascimento, $opcao, $obs, $nome_responsavel)
	{
		$consultar_criancas = $this->db->query("SELECT * FROM criancas WHERE lider LIKE $idLider AND id_pg = $idPG AND nome_crianca = '$nome' AND nascimento = '$nascimento' AND cristao = $opcao AND observacao = '$obs' AND nome_responsavel = '$nome_responsavel'");
		$row = $consultar_criancas->num_rows();

		if ($row == 0) {
			return true;
		} else {
			return false;
		}
	}

	public function selecionarSupervisorEstado($estado)
	{
		$consultar = $this->db->query("SELECT * FROM supervisores_pais WHERE estado LIKE '$estado' AND ativo = 1");
		$row = $consultar->num_rows();
		$dados = $consultar->row_array();

		if ($row == 0) {
			$consultar_geral = $this->db->query("SELECT * FROM supervisores_pais WHERE id_supervisor = 1");
			$dados_gerais = $consultar_geral->row_array();
			return $dados_gerais;
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

	public function checkPorcentagem($x)
	{
		if ($x < 20) {
			return 'danger';
		} else if ($x > 20 && $x < 80) {
			return 'warning';
		} else {
			return 'success';
		}
	}

	public function getInfoCrianca($id, $nivel)
	{

		if ($nivel == 1) {
			$consultar_crianca = $this->db->query("SELECT * FROM crianca WHERE id_crianca LIKE '$id'");
			$row = $consultar_crianca->num_rows();
			$dados_consulta_coordenador = $consultar_crianca->row_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_coordenador,
			);
		} else if ($nivel == 2) {
			$consultar_crianca = $this->db->query("SELECT * FROM criancas_2 WHERE id_crianca LIKE '$id'");
			$row = $consultar_crianca->num_rows();
			$dados_consulta_coordenador = $consultar_crianca->row_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_coordenador,
			);
		}

		return $dados;
	}
	public function getInfoLiderId($id)
	{
		$consultar_lider = $this->db->query("SELECT * FROM lider WHERE id_lider LIKE '$id'");
		$row = $consultar_lider->num_rows();
		$dados_consulta_lider = $consultar_lider->row_array();

		$dados = array(
			'row' => $row,
			'dados' => $dados_consulta_lider,
		);

		return $dados;
	}

	public function getInfoCoordenadorId($id)
	{
		$consultar_coordenador = $this->db->query("SELECT * FROM coordenador WHERE id_coordenador LIKE '$id'");
		$row = $consultar_coordenador->num_rows();
		$dados_consulta_coordenador = $consultar_coordenador->row_array();

		$dados = array(
			'row' => $row,
			'dados' => $dados_consulta_coordenador,
		);

		return $dados;
	}

	public function getInfoSLocalId($id)
	{
		$consultar_slocal = $this->db->query("SELECT * FROM supervisor_local WHERE id_supervisorR LIKE '$id'");
		$row = $consultar_slocal->num_rows();
		$dados_consulta_slocal = $consultar_slocal->row_array();

		$dados = array(
			'row' => $row,
			'dados' => $dados_consulta_slocal,
		);

		return $dados;
	}

	public function getInfoSRegionalId($id)
	{
		$consultar_sRegional = $this->db->query("SELECT * FROM supervisor_regional WHERE id_supervisorEs LIKE '$id'");
		$row = $consultar_sRegional->num_rows();
		$dados_consulta_sRegional = $consultar_sRegional->row_array();

		$dados = array(
			'row' => $row,
			'dados' => $dados_consulta_sRegional,
		);

		return $dados;
	}
	public function getInfoDirecaoId($id)
	{
		$consultar_direcao = $this->db->query("SELECT * FROM direcao WHERE id_direcao LIKE '$id'");
		$row = $consultar_direcao->num_rows();
		$dados_consulta_direcao = $consultar_direcao->row_array();

		$dados = array(
			'row' => $row,
			'dados' => $dados_consulta_direcao,
		);

		return $dados;
	}

	public function getSRegional($id_usuario, $opc, $opc2, $datas)
	{
		if ($opc == 1 && $opc2 == 1) {
			// info de todos os supervisores regionais
			$consultar_sregional = $this->db->query("SELECT * FROM supervisor_regional ORDER BY nome_supervisorE ASC");
			$row_1 = $consultar_sregional->num_rows();
			$dados_consulta_sregional = $consultar_sregional->result_array();

			$dados1 = array(
				'row' => $row_1,
				'dados' => $dados_consulta_sregional,
			);
			$sregionalAtivos = $this->sRegionaisAtivos($dados1);

			$dados = array(
				'sregional' => $dados1,
				'sregional_ativos' => $sregionalAtivos,
			);

			return $dados;
		} else if ($opc == 1 && $opc2 == 2) {
			// info de todos os supervisores regionais
			$consultar_sregional = $this->db->query("SELECT * FROM supervisore");
			$row_1 = $consultar_sregional->num_rows();
			$dados_consulta_sregional = $consultar_sregional->result_array();

			$dados1 = array(
				'row' => $row_1,
				'dados' => $dados_consulta_sregional,
			);
			$sregionalAtivos = $this->sRegionaisAtivos($dados1);

			$dados = array(
				'sregional' => $dados1,
				'sregional_ativos' => $sregionalAtivos,
			);

			return $dados;
		} else if ($opc == 1 && $opc2 == 3) {
			// retornar um supervisor regional específico
			$id_user = $id_usuario[0];
			$consultar_sregionais = $this->db->query("SELECT * FROM supervisor_regional WHERE id_supervisorE = '$id_user'");
			$row = $consultar_sregionais->num_rows();
			$dados_consulta_sregionais = $consultar_sregionais->row_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_sregionais,
			);

			return $dados;
		} else if ($opc2 == 'nao' && $id_usuario[0] == 'direcao') {
			// Consulta na tabela de líderes entre datas geral
			$id_usuario = $id_usuario[0];

			$data_inicio = $datas['dataInicio']; // antiga
			$data_final = $datas['dataFim']; // atual

			// info de todos os supervisores regionais
			$consultar_sregional = $this->db->query("SELECT * FROM supervisor_regional WHERE data_cadastro BETWEEN '$data_inicio' AND '$data_final' ORDER BY nome_supervisorE ASC");
			$row = $consultar_sregional->num_rows();
			$dados_consulta_sregional = $consultar_sregional->result_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_sregional,
			);
			$sregionalAtivos = $this->sRegionaisAtivos($dados);
			array_push($dados, $sregionalAtivos);

			return $dados;
		} else if ($opc2 == 'sim' && $id_usuario[0] == 'direcao') {
			// Consulta na tabela de líderes entre datas geral
			$id_usuario = $id_usuario[0];

			$data_inicio = $datas['dataInicio']; // antiga
			$data_final = $datas['dataFim']; // atual

			$data_inicio_menos_um_ano = $datas['dataInicioAnoPassado']; // antiga - menos um ano
			$data_final_menos_um_ano = $datas['dataFimAnoPassado']; // atual - menos um ano

			$consultar_sregional = $this->db->query("SELECT * FROM supervisor_regional WHERE data_cadastro BETWEEN '$data_inicio' AND '$data_final' ORDER BY nome_supervisorE ASC");
			$row_1 = $consultar_sregional->num_rows();
			$dados_consulta_sregional = $consultar_sregional->result_array();

			$dados = array(
				'row' => $row_1,
				'dados' => $dados_consulta_sregional,
			);
			$sregionalAtivos = $this->sRegionaisAtivos($dados);

			array_push($dados, $sregionalAtivos);

			$consultar_sregional_mesmo_ano = $this->db->query("SELECT * FROM supervisor_regional WHERE data_cadastro BETWEEN '$data_inicio_menos_um_ano' AND '$data_final_menos_um_ano' ORDER BY nome_supervisorE ASC");
			$row_1_mesmo_ano = $consultar_sregional_mesmo_ano->num_rows();
			$dados_consulta_sregional_mesmo_ano = $consultar_sregional_mesmo_ano->result_array();

			$dados1_mesmo_ano = array(
				'row' => $row_1_mesmo_ano,
				'dados' => $dados_consulta_sregional_mesmo_ano,
			);
			$sregionalAtivos_mesmo_ano = $this->sRegionaisAtivos($dados1_mesmo_ano);

			array_push($dados, $dados1_mesmo_ano);
			array_push($dados, $sregionalAtivos_mesmo_ano);

			return $dados;
		}
	}

	public function sRegionaisAtivos($list)
	{
		$lista = $list['dados'];
		$total_ativos = 0;
		$dados_sregionais = [];

		if ($list['row'] == 0) {
		} else {
			foreach ($lista as $key => $sregional) {
				$ativo = $sregional['ativo'];

				if ($ativo == 0) {
				} else {
					// ativo
					array_push($dados_sregionais, $sregional);
					$total_ativos = $total_ativos + 1;
				}
			}
		}

		$dados = array(
			'row' => $total_ativos,
			'dados' => $dados_sregionais,
		);
		return $dados;
	}

	public function getSRegionalDesativados()
	{
		$consultar_sregional_1 = $this->db->query("SELECT * FROM supervisor_regional WHERE ativo = 0 ORDER BY id_supervisorEs ASC");
		$row_1 = $consultar_sregional_1->num_rows();
		$dados_consulta_sregional_1 = $consultar_sregional_1->result_array();

		$dados = array(
			'row' => $row_1,
			'dados' => $dados_consulta_sregional_1,
		);

		return $dados;
	}

	public function getSLocal($id_usuario, $opc, $opc2, $datas)
	{
		if ($opc == 1 && $opc2 == 1) {
			// retornar todos os supervisores locais ordenardo pelo nome
			$consultar_slocal = $this->db->query("SELECT * FROM supervisor_local ORDER BY nome_supervisorR ASC");
			$row = $consultar_slocal->num_rows();
			$dados_consulta_slocal = $consultar_slocal->result_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_slocal,
			);

			return $dados;
		} else if ($opc == 1 && $opc2 == 2) {
			// retornar todos os supervisores locais sem ordem
			$consultar_slocal = $this->db->query("SELECT * FROM supervisorr");
			$row = $consultar_slocal->num_rows();
			$dados_consulta_slocal = $consultar_slocal->result_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_slocal,
			);

			return $dados;
		} else if ($opc == 1 && $opc2 == 3) {
			// retornar um supervisor local específico
			$id_user = $id_usuario[0];
			$consultar_sregionais = $this->db->query("SELECT * FROM supervisor_local WHERE id_supervisorR = '$id_user'");
			$row = $consultar_sregionais->num_rows();
			$dados_consulta_sregionais = $consultar_sregionais->row_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_sregionais,
			);

			return $dados;
		} else if ($opc == 2 && $opc2 == 1) {
			// retornar supervisores locais do supervisor regional
			$id_user = $id_usuario[0];
			$consultar_sregionais = $this->db->query("SELECT * FROM supervisor_local WHERE id_supervisorE = '$id_user'");
			$row = $consultar_sregionais->num_rows();
			$dados_consulta_sregionais = $consultar_sregionais->result_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_sregionais,
			);

			return $dados;
		} else if ($opc2 == 'nao' && $id_usuario[0] == 'direcao') {
			// retornando todos os supervisores locais de acordo com uma data específica
			$data_inicio = $datas['dataInicio']; // antiga
			$data_final = $datas['dataFim']; // atual

			$consultar_slocais = $this->db->query("SELECT * FROM supervisor_local WHERE data_cadastro BETWEEN '$data_inicio' AND '$data_final' ORDER BY nome_supervisorR ASC");
			$row = $consultar_slocais->num_rows();
			$dados_consulta_slocais = $consultar_slocais->result_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_slocais,
			);

			$sLocaisAtivos = $this->sLocaisAtivos($dados);
			array_push($dados, $sLocaisAtivos);

			return $dados;
		} else if ($opc2 == 'sim' && $id_usuario[0] == 'direcao') {
			// retornando todos os supervisores locais de acordo com uma data específica
			$data_inicio = $datas['dataInicio']; // antiga
			$data_final = $datas['dataFim']; // atual

			$data_inicio_menos_um_ano = $datas['dataInicioAnoPassado']; // antiga - menos um ano
			$data_final_menos_um_ano = $datas['dataFimAnoPassado']; // atual - menos um ano

			$consultar_slocais = $this->db->query("SELECT * FROM supervisor_local WHERE data_cadastro BETWEEN '$data_inicio' AND '$data_final' ORDER BY nome_supervisorR ASC");
			$row = $consultar_slocais->num_rows();
			$dados_consulta_slocais = $consultar_slocais->result_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_slocais,
			);

			$sLocaisAtivos = $this->sLocaisAtivos($dados);
			array_push($dados, $sLocaisAtivos);

			$consultar_slocais_mesmo_ano = $this->db->query("SELECT * FROM supervisor_local WHERE data_cadastro BETWEEN '$data_inicio_menos_um_ano' AND '$data_final_menos_um_ano' ORDER BY nome_supervisorR ASC");
			$row_1_mesmo_ano = $consultar_slocais_mesmo_ano->num_rows();
			$dados_consulta_slocais_mesmo_ano = $consultar_slocais_mesmo_ano->result_array();

			$dados1_mesmo_ano = array(
				'row' => $row_1_mesmo_ano,
				'dados' => $dados_consulta_slocais_mesmo_ano,
			);
			$slocaisAtivos_mesmo_ano = $this->sRegionaisAtivos($dados1_mesmo_ano);

			array_push($dados, $dados1_mesmo_ano);
			array_push($dados, $slocaisAtivos_mesmo_ano);

			return $dados;
		} else if (($opc2 == 'nao' || $opc2 == 'sim') && $id_usuario[0] != 'direcao') {
			$nivel = $id_usuario[1];
			$id_user = $id_usuario[2];
			// retornando a comparação entre anos de todos os supervisores de acordo com uma data específica
			$data_inicio = $datas['dataInicio']; // antiga
			$data_final = $datas['dataFim']; // atual
			if ($nivel == '') {
				$consultar_sregionais = $this->db->query("SELECT * FROM supervisor_local WHERE id_supervisorE = '$id_user' AND data_cadastro BETWEEN '$data_inicio' AND '$data_final' ORDER BY nome_supervisorR ASC");
				$row = $consultar_sregionais->num_rows();
				$dados_consulta_sregionais = $consultar_sregionais->result_array();

				$dados = array(
					'row' => $row,
					'dados' => $dados_consulta_sregionais,
				);
			} else if ($nivel == 'todos') {
				$consultar_sregionais = $this->db->query("SELECT * FROM supervisor_local WHERE data_cadastro BETWEEN '$data_inicio' AND '$data_final' ORDER BY nome_supervisorR ASC");
				$row = $consultar_sregionais->num_rows();
				$dados_consulta_sregionais = $consultar_sregionais->result_array();

				$dados = array(
					'row' => $row,
					'dados' => $dados_consulta_sregionais,
				);
			}

			$slocalAtivos = $this->sLocaisAtivos($dados);
			array_push($dados, $slocalAtivos);


			return $dados;
		}
	}
	public function sLocaisAtivos($list)
	{
		$lista = $list['dados'];
		$total_ativos = 0;
		$dados_slocais = [];

		if ($list['row'] == 0) {
		} else {
			foreach ($lista as $key => $slocal) {
				$ativo = $slocal['ativo'];

				if ($ativo == 0) {
				} else {
					// ativo
					array_push($dados_slocais, $slocal);
					$total_ativos = $total_ativos + 1;
				}
			}
		}

		$dados = array(
			'row' => $total_ativos,
			'dados' => $dados_slocais,
		);
		return $dados;
	}

	public function getSLocalDesativados()
	{
		$consultar_local_1 = $this->db->query("SELECT * FROM supervisor_local WHERE ativo = 0 ORDER BY id_supervisorR ASC");
		$row_1 = $consultar_local_1->num_rows();
		$dados_consulta_local_1 = $consultar_local_1->result_array();

		$dados = array(
			'row' => $row_1,
			'dados' => $dados_consulta_local_1,
		);

		return $dados;
	}

	// Coordenadores
	public function getCoordenador($id_usuario, $opc, $opc2, $datas)
	{
		if ($opc == 1 && $opc2 == 1) {
			// retornar todos os coordenadores ordenardo pelo nome
			$consultar_coordenador = $this->db->query("SELECT * FROM coordenador ORDER BY nome_coordenador ASC");
			$row = $consultar_coordenador->num_rows();
			$dados_consulta_coordenador = $consultar_coordenador->result_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_coordenador,
			);

			return $dados;
		} else if ($opc == 1 && $opc2 == 2) {
			// retornar todos os coordenadores sem ordem
			$consultar_coordenador = $this->db->query("SELECT * FROM coordenador");
			$row = $consultar_coordenador->num_rows();
			$dados_consulta_coordenador = $consultar_coordenador->result_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_coordenador,
			);

			return $dados;
		} else if ($opc == 1 && $opc2 == 3) {
			// retornar um supervisor local específico
			$id_user = $id_usuario[0];
			$consultar_coordenador = $this->db->query("SELECT * FROM coordenador WHERE id_coordenador = '$id_user'");
			$row = $consultar_coordenador->num_rows();
			$dados_consulta_coordenador = $consultar_coordenador->row_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_coordenador,
			);

			return $dados;
		} else if ($opc == 2 && $opc2 == 1) {
			// retornar um coordenador, de acordo com o s. regional
			$id_user = $id_usuario[0];
			$consultar_coordenador = $this->db->query("SELECT * FROM coordenador WHERE id_supervisorE = '$id_user'");
			$row = $consultar_coordenador->num_rows();
			$dados_consulta_coordenador = $consultar_coordenador->result_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_coordenador,
			);

			return $dados;
		} else if ($opc2 == 'nao' && $id_usuario[0] == 'direcao') {
			// retornando todos os coordenadores de acordo com uma data específica
			$data_inicio = $datas['dataInicio']; // antiga
			$data_final = $datas['dataFim']; // atual

			$consultar_coordenador = $this->db->query("SELECT * FROM coordenador WHERE data_cadastro BETWEEN '$data_inicio' AND '$data_final' ORDER BY nome_coordenador ASC");
			$row = $consultar_coordenador->num_rows();
			$dados_consulta_coordenador = $consultar_coordenador->result_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_coordenador,
			);

			$coordenadoresAtivos = $this->coordenadoresAtivos($dados);
			array_push($dados, $coordenadoresAtivos);

			return $dados;
		} else if ($opc2 == 'sim' && $id_usuario[0] == 'direcao') {
			// retornando todos os coordenadores de acordo com uma data específica
			$data_inicio = $datas['dataInicio']; // antiga
			$data_final = $datas['dataFim']; // atual

			$data_inicio_menos_um_ano = $datas['dataInicioAnoPassado']; // antiga - menos um ano
			$data_final_menos_um_ano = $datas['dataFimAnoPassado']; // atual - menos um ano

			$consultar_coordenador = $this->db->query("SELECT * FROM coordenador WHERE data_cadastro BETWEEN '$data_inicio' AND '$data_final' ORDER BY nome_coordenador ASC");
			$row = $consultar_coordenador->num_rows();
			$dados_consulta_coordenador = $consultar_coordenador->result_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_coordenador,
			);

			$coordenadoresAtivos = $this->coordenadoresAtivos($dados);
			array_push($dados, $coordenadoresAtivos);

			$consultar_coordenador_mesmo_ano = $this->db->query("SELECT * FROM coordenador WHERE data_cadastro BETWEEN '$data_inicio_menos_um_ano' AND '$data_final_menos_um_ano' ORDER BY nome_coordenador ASC");
			$row_1_mesmo_ano = $consultar_coordenador_mesmo_ano->num_rows();
			$dados_consulta_coordenador_mesmo_ano = $consultar_coordenador_mesmo_ano->result_array();

			$dados1_mesmo_ano = array(
				'row' => $row_1_mesmo_ano,
				'dados' => $dados_consulta_coordenador_mesmo_ano,
			);
			$coordenadoresAtivos_mesmo_ano = $this->coordenadoresAtivos($dados1_mesmo_ano);

			array_push($dados, $dados1_mesmo_ano);
			array_push($dados, $coordenadoresAtivos_mesmo_ano);

			return $dados;
		} else if (($opc2 == 'nao' || $opc2 == 'sim') && $id_usuario[0] != 'direcao') {
			$nivel = $id_usuario[0];

			$data_inicio = $datas['dataInicio']; // antiga
			$data_final = $datas['dataFim']; // atual

			$row = 0;
			$dados_consulta_coordenadores = [];

			if ($nivel == 'sregional') {
				$comparadores = $id_usuario[1];
				if ($comparadores == '') {
					$id_sregional = $id_usuario[2];
					$consultar_coordenadores = $this->db->query("SELECT * FROM coordenador WHERE id_supervisorE = '$id_sregional' AND data_cadastro BETWEEN '$data_inicio' AND '$data_final' ORDER BY nome_coordenador ASC");
					$row_1 = $consultar_coordenadores->num_rows();
					$dados_consulta_coordenadores_1 = $consultar_coordenadores->result_array();

					$row = $row_1;
					$dados_consulta_coordenadores = $dados_consulta_coordenadores_1;
				} else {
					$id_sregional = $id_usuario[2];
					$id_slocal = $id_usuario[3];
					$consultar_coordenadores = $this->db->query("SELECT * FROM coordenador WHERE id_supervisorE = '$id_sregional' AND id_supervisorR = '$id_slocal' AND data_cadastro BETWEEN '$data_inicio' AND '$data_final' ORDER BY nome_coordenador ASC");
					$row_1 = $consultar_coordenadores->num_rows();
					$dados_consulta_coordenadores_1 = $consultar_coordenadores->result_array();

					$row = $row_1;
					$dados_consulta_coordenadores = $dados_consulta_coordenadores_1;
				}
			} else if ($nivel == 'slocal') {
				$comparadores = $id_usuario[1];
				if ($comparadores == '') {
					$id_slocal = $id_usuario[2];
					$consultar_coordenadores = $this->db->query("SELECT * FROM coordenador WHERE id_supervisorR = '$id_slocal' AND data_cadastro BETWEEN '$data_inicio' AND '$data_final' ORDER BY nome_coordenador ASC");
					$row_1 = $consultar_coordenadores->num_rows();
					$dados_consulta_coordenadores_1 = $consultar_coordenadores->result_array();

					$row = $row_1;
					$dados_consulta_coordenadores = $dados_consulta_coordenadores_1;
				}
			}

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_coordenadores,
			);

			$coordenadoresAtivos = $this->coordenadoresAtivos($dados);
			array_push($dados, $coordenadoresAtivos);
			return $dados;
		}
	}

	public function coordenadoresAtivos($list)
	{
		$lista = $list['dados'];
		$total_ativos = 0;
		$dados_coordenador = [];

		if ($list['row'] == 0) {
		} else {
			foreach ($lista as $key => $lideres) {
				$ativo = $lideres['ativo'];

				if ($ativo == 0) {
				} else {
					// líder novo
					array_push($dados_coordenador, $lideres);
					$total_ativos = $total_ativos + 1;
				}
			}
		}

		$dados = array(
			'row' => $total_ativos,
			'dados' => $dados_coordenador,
		);
		return $dados;
	}
	/*public function getCoordenadoresDesativados($id_usuario)
	{
		$consultar_coordenadores_1 = $this->db->query("SELECT * FROM coordenador WHERE id_supervisorR LIKE $id_usuario AND ativo = 0 ORDER BY nome_coordenador ASC");
		$row_1 = $consultar_coordenadores_1->num_rows();
		$dados_consulta_coordenadores_1 = $consultar_coordenadores_1->result_array();

		$row = 0;
		$dados_consulta_coordenadores = [];

		if ($row_1 == 0) {
			// supervisor local
			$consultar_coordenadores_2 = $this->db->query("SELECT * FROM coordenador WHERE id_supervisorE LIKE $id_usuario AND ativo = 0 ORDER BY nome_coordenador ASC");
			$row_2 = $consultar_coordenadores_2->num_rows();
			$dados_consulta_coordenadores_2 = $consultar_coordenadores_2->result_array();

			$row = $row_2;
			$dados_consulta_coordenadores = $dados_consulta_coordenadores_2;
		} else {
			$row = $row_1;
			$dados_consulta_coordenadores = $dados_consulta_coordenadores_1;
		}

		$dados = array(
			'row' => $row,
			'dados' => $dados_consulta_coordenadores,
		);

		return $dados;
	}*/

	/*public function getLideres($id_usuario, $opc, $opc2, $datas)
	{
		if ($opc == 1 && $opc2 == 1) {
			// Consulta na tabela de líderes ordenando pelo nome
			$consultar_lideres = $this->db->query("SELECT * FROM lider ORDER BY nome_lider ASC LIMIT 10");
			$row = $consultar_lideres->num_rows();
			$dados_consulta_lideres = $consultar_lideres->result_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_lideres,
			);

			return $dados;
		} else if ($opc == 1 && $opc2 == 2) {
			// Consulta na tabela de líderes
			$consultar_lideres = $this->db->query("SELECT * FROM lider LIMIT 10");
			$row = $consultar_lideres->num_rows();
			$dados_consulta_lideres = $consultar_lideres->result_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_lideres,
			);

			return $dados;
		} else if ($opc == 1 && $opc2 == 3) {
			// Consulta na tabela de líderes específico
			$id_user = $id_usuario[0];

			$consultar_lideres = $this->db->query("SELECT * FROM lider WHERE id_lider = '$id_user'");
			$row = $consultar_lideres->num_rows();
			$dados_consulta_lideres = $consultar_lideres->row_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_lideres,
			);

			return $dados;
		} else if ($opc == 2 && $opc2 == 1) {
			// Consulta na tabela de líderes, líderes do supervisor regional
			$id_user = $id_usuario[0];

			$consultar_lideres = $this->db->query("SELECT * FROM lider WHERE id_supervisorE = '$id_user' LIMIT 10");
			$row = $consultar_lideres->num_rows();
			$dados_consulta_lideres = $consultar_lideres->result_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_lideres,
			);

			return $dados;
		} else if ($opc2 == 'nao' && $id_usuario[0] == 'direcao') {
			// Consulta na tabela de líderes entre datas
			$data_inicio = $datas['dataInicio']; // antiga
			$data_final = $datas['dataFim']; // atual

			$consultar_lideres = $this->db->query("SELECT * FROM lider WHERE data_cadastro BETWEEN '$data_inicio' AND '$data_final' ORDER BY nome_lider ASC LIMIT 10");
			$row_4 = $consultar_lideres->num_rows();
			$dados_consulta_lideres = $consultar_lideres->result_array();

			$dados = array(
				'row' => $row_4,
				'dados' => $dados_consulta_lideres,
			);
			$lideresAtivos = $this->lideresAtivos($dados);
			array_push($dados, $lideresAtivos);

			$lista_de_id_1 = $this->FSistema_model->retornando_so_id('id_lider', $dados['dados']);
			$total_criancas_lider = $this->getNumerosCriancas($id_usuario, $lista_de_id_1, 'direcao');
			array_push($dados, $total_criancas_lider);

			$lista_de_id_1_ativos = $this->FSistema_model->retornando_so_id('id_lider', $lideresAtivos['dados']);
			$total_criancas_lider_ativos = $this->getNumerosCriancas($id_usuario, $lista_de_id_1_ativos, 'direcao');
			array_push($dados, $total_criancas_lider_ativos);

			return $dados;
		} else if ($opc2 == 'sim' && $id_usuario[0] == 'direcao') {
			// Consulta na tabela de líderes entre datas geral
			$id_user = $id_usuario[0];

			$data_inicio = $datas['dataInicio']; // antiga
			$data_final = $datas['dataFim']; // atual

			$data_inicio_menos_um_ano = $datas['dataInicioAnoPassado']; // antiga - menos um ano
			$data_final_menos_um_ano = $datas['dataFimAnoPassado']; // atual - menos um ano

			$consultar_lideres = $this->db->query("SELECT * FROM lider WHERE data_cadastro BETWEEN '$data_inicio' AND '$data_final' ORDER BY nome_lider ASC LIMIT 10");
			$row_4 = $consultar_lideres->num_rows();
			$dados_consulta_lideres = $consultar_lideres->result_array();

			$dados = array(
				'row' => $row_4,
				'dados' => $dados_consulta_lideres,
			);
			$lideresAtivos = $this->lideresAtivos($dados);
			array_push($dados, $lideresAtivos);

			$lista_de_id_1 = $this->FSistema_model->retornando_so_id('id_lider', $dados['dados']);
			$total_criancas_lider = $this->getNumerosCriancas($id_usuario, $lista_de_id_1, 'direcao');
			array_push($dados, $total_criancas_lider);

			$lista_de_id_1_ativos = $this->FSistema_model->retornando_so_id('id_lider', $lideresAtivos['dados']);
			$total_criancas_lider_ativos = $this->getNumerosCriancas($id_usuario, $lista_de_id_1_ativos, 'direcao');
			array_push($dados, $total_criancas_lider_ativos);

			// comparação do ano passado
			$consultar_lider_mesmo_ano = $this->db->query("SELECT * FROM lider WHERE data_cadastro BETWEEN '$data_inicio_menos_um_ano' AND '$data_final_menos_um_ano' ORDER BY nome_lider ASC LIMIT 10");
			$row_1_mesmo_ano = $consultar_lider_mesmo_ano->num_rows();
			$dados_consulta_lider_mesmo_ano = $consultar_lider_mesmo_ano->result_array();

			$dados1_mesmo_ano = array(
				'row' => $row_1_mesmo_ano,
				'dados' => $dados_consulta_lider_mesmo_ano,
			);
			$lideresAtivos_mesmo_ano = $this->lideresAtivos($dados1_mesmo_ano);
			array_push($dados, $dados1_mesmo_ano); // lideres comparados ao ao passado
			array_push($dados, $lideresAtivos_mesmo_ano); // lideres ativos comparado ao ano passado

			$lista_de_id_1_mesmo_ano = $this->FSistema_model->retornando_so_id('id_lider', $dados1_mesmo_ano['dados']);
			$total_criancas_lider_mesmo_ano = $this->getNumerosCriancas($id_usuario, $lista_de_id_1_mesmo_ano, 'direcao');
			array_push($dados, $total_criancas_lider_mesmo_ano);

			$lista_de_id_1_ativos_mesmo_ano = $this->FSistema_model->retornando_so_id('id_lider', $lideresAtivos_mesmo_ano['dados']);
			$total_criancas_lider_ativos_mesmo_ano = $this->getNumerosCriancas($id_usuario, $lista_de_id_1_ativos_mesmo_ano, 'direcao');
			array_push($dados, $total_criancas_lider_ativos_mesmo_ano);

			return $dados;
		} else if (($opc2 == 'nao' || $opc2 == 'sim') && $id_usuario[0] != 'direcao') {
			$nivel = $id_usuario[0];

			$row = 0;
			$dados_consulta_lideres = [];

			// Consulta na tabela de líderes entre datas
			$data_inicio = $datas['dataInicio']; // antiga
			$data_final = $datas['dataFim']; // atual

			if ($nivel == 'sregional') {
				$comparadores = $id_usuario[1];
				if ($comparadores == '') {
					$id_sregional = $id_usuario[2];
					$consultar_lideres_1 = $this->db->query("SELECT * FROM lider WHERE id_supervisorE = '$id_sregional' AND  data_cadastro BETWEEN '$data_inicio' AND '$data_final' ORDER BY nome_lider ASC LIMIT 10");
					$row_1 = $consultar_lideres_1->num_rows();
					$dados_consulta_lideres_1 = $consultar_lideres_1->result_array();

					$row = $row_1;
					$dados_consulta_lideres = $dados_consulta_lideres_1;
				} else if ($comparadores == 'slocal') {
					$id_sregional = $id_usuario[2];
					$id_slocal = $id_usuario[3];
					$consultar_lideres_1 = $this->db->query("SELECT * FROM lider WHERE id_supervisorE = '$id_sregional' AND id_supervisorR = '$id_slocal' AND data_cadastro BETWEEN '$data_inicio' AND '$data_final' ORDER BY nome_lider ASC LIMIT 10");
					$row_1 = $consultar_lideres_1->num_rows();
					$dados_consulta_lideres_1 = $consultar_lideres_1->result_array();

					$row = $row_1;
					$dados_consulta_lideres = $dados_consulta_lideres_1;
				}
			} else if ($nivel == 'slocal') {
				$comparadores = $id_usuario[1];
				if ($comparadores == '') {
					$id_slocal = $id_usuario[2];
					$consultar_lideres_1 = $this->db->query("SELECT * FROM lider WHERE id_supervisorR = '$id_slocal' AND  data_cadastro BETWEEN '$data_inicio' AND '$data_final' ORDER BY nome_lider ASC LIMIT 10");
					$row_1 = $consultar_lideres_1->num_rows();
					$dados_consulta_lideres_1 = $consultar_lideres_1->result_array();

					$row = $row_1;
					$dados_consulta_lideres = $dados_consulta_lideres_1;
				}
			} else if ($nivel == 'coordenador') {
				$comparadores = $id_usuario[1];
				if ($comparadores == '') {
					$id_coordenador = $id_usuario[2];
					$consultar_lideres_1 = $this->db->query("SELECT * FROM lider WHERE id_coordenador = '$id_coordenador' AND  data_cadastro BETWEEN '$data_inicio' AND '$data_final' ORDER BY nome_lider ASC LIMIT 10");
					$row_1 = $consultar_lideres_1->num_rows();
					$dados_consulta_lideres_1 = $consultar_lideres_1->result_array();

					$row = $row_1;
					$dados_consulta_lideres = $dados_consulta_lideres_1;
				}
			}

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_lideres,
			);

			$lideresAtivos = $this->lideresAtivos($dados);
			array_push($dados, $lideresAtivos);

			$lista_de_id_1 = $this->FSistema_model->retornando_so_id('id_lider', $dados['dados']);
			$total_criancas_lider = $this->getNumerosCriancas($id_usuario, $lista_de_id_1, 'direcao');
			array_push($dados, $total_criancas_lider);

			$lista_de_id_1_ativos = $this->FSistema_model->retornando_so_id('id_lider', $lideresAtivos['dados']);
			$total_criancas_lider_ativos = $this->getNumerosCriancas($id_usuario, $lista_de_id_1_ativos, 'direcao');
			array_push($dados, $total_criancas_lider_ativos);

			return $dados;
		}
	}*/

	/*public function lideresAtivos($list)
	{
		$lista = $list['dados'];
		$total_ativos = 0;
		$dados_lider = [];

		if ($list['row'] == 0) {
		} else {
			foreach ($lista as $key => $lideres) {
				$id_lider = $lideres['id_lider'];
				$ativo = $lideres['confirmado'];
				$data_cadastro = $lideres['data_cadastro'];

				$check = $this->check_lider_is_ativo($id_lider, $data_cadastro, $ativo);

				if (!$check) {
				} else {
					// líder novo
					array_push($dados_lider, $lideres);
					$total_ativos = $total_ativos + 1;
				}
			}
		}

		$dados = array(
			'row' => $total_ativos,
			'dados' => $dados_lider,
		);
		return $dados;
	}*/

	/*public function check_lider_is_ativo($id_lider, $data_cadastro, $ativo)
	{
		$data = date('Y-m-d');
		$data_mais_um_mes = date('Y-m-d', strtotime('+1 month', strtotime($data_cadastro)));

		$qtd_criancas = $this->mostrarCriancasPais($id_lider);
		$qtd_criancas_ativas = $this->mostrarCriancasPais($id_lider);

		$pgs = $this->mostrarPG($id_lider, 3);

		if ($ativo == 0 || $ativo == 1 || $ativo == 3) {
			return false;
		} else {
			if (strtotime($data_mais_um_mes) > strtotime($data)) {
				return true;
			} else {
				if ($pgs['row'] == 0 && $qtd_criancas_ativas['row'] == 0 && $qtd_criancas['row'] == 0) {
					// inativo por n ter pg e nem crianças
					return false;
				} else {
					$id_modulo = $pgs['dados']['id_modulo'] ?? 1;
					$numero_licao = $pgs['dados']['n_licao'] ?? 1;
					$modulo = $this->consultarModuloId($id_modulo);
					$progresso = $this->consultarProgressoGeral($id_lider);
					$data_ultimo_relatorio = "";
					$i = 0;
					foreach ($progresso['dados'] as $key => $p) {
						$data_ultimo = $p['data_aula'];
						$i++;
						if ($i == $progresso['row']) {
							$data_ultimo_relatorio = $data_ultimo;
						}
					}

					if ($data_ultimo_relatorio == '') {
						// inativo por não preenchimento de relatórios
						return false;
					} else {
						$data_convertida = $this->converterData($data_ultimo_relatorio);
						$data_mais_2_meses = date('Y-m-d', strtotime('+2 months', strtotime($data_convertida)));

						if (strtotime($data_mais_2_meses) < strtotime($data)) {
							// inativo por ter passado mais de 2 meses inativos
							return false;
						} else if ($id_modulo == 10 && $numero_licao == $modulo['n_licao']) {
							return true;
						} else {
							return true;
						}
					}
				}
			}
		}
	}*/

	/*public function getLideresDesativados($id_usuario)
	{
		$consultar_lideres_1 = $this->db->query("SELECT * FROM lider WHERE id_coordenador LIKE $id_usuario AND confirmado = 3 ORDER BY nome_lider ASC");
		$row_1 = $consultar_lideres_1->num_rows();
		$dados_consulta_lideres_1 = $consultar_lideres_1->result_array();

		$row = 0;
		$dados_consulta_lideres = [];

		if ($row_1 == 0) {
			// supervisor local
			$consultar_lideres_2 = $this->db->query("SELECT * FROM lider WHERE id_supervisorR LIKE $id_usuario AND confirmado = 3 ORDER BY nome_lider ASC");
			$row_2 = $consultar_lideres_2->num_rows();
			$dados_consulta_lideres_2 = $consultar_lideres_2->result_array();

			if ($row_2 == 0) {
				// supervisor regional
				$consultar_lideres_3 = $this->db->query("SELECT * FROM lider WHERE id_supervisorE LIKE $id_usuario AND confirmado = 3 ORDER BY nome_lider ASC");
				$row_3 = $consultar_lideres_3->num_rows();
				$dados_consulta_lideres_3 = $consultar_lideres_3->result_array();

				$row = $row_3;
				$dados_consulta_lideres = $dados_consulta_lideres_3;
			} else {
				$row = $row_2;
				$dados_consulta_lideres = $dados_consulta_lideres_2;
			}
		} else {
			$row = $row_1;
			$dados_consulta_lideres = $dados_consulta_lideres_1;
		}

		$dados = array(
			'row' => $row,
			'dados' => $dados_consulta_lideres,
		);

		return $dados;
	}*/

	/*public function getUsuario($nome, $email, $cpf)
	{
		$consultar_usuario = $this->db->query("SELECT * FROM usuario WHERE email = '$email' AND cpf = '$cpf' AND nome LIKE '$nome'");
		$dados_usuario = $consultar_usuario->row_array();
		$total_usuario = $consultar_usuario->num_rows();

		$dados = array(
			'row' => $total_usuario,
			'dados' => $dados_usuario,
		);

		return $dados;
	}*/
	/*public function getNumerosCriancas($id_usuario, $users, $opc)
	{

		$total_criancas = 0;

		$total = count($users);

		if ($total == 0) {
		} else {
			foreach ($users as $key => $dados) {
				$consultar_criancas_lider = $this->db->query("SELECT * FROM crianca WHERE lider = $dados LIMIT 10");
				$row_lider = $consultar_criancas_lider->num_rows();

				$total_criancas = $total_criancas + $row_lider;
			}
		}

		return $total_criancas;
	}*/
}
