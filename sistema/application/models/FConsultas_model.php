<?php

/**
 * @property $db
 * @property $load
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
		$db = $this->load->database($active_group, TRUE);
		$this->db = $db;

		// ADICIONE ISTO ABAIXO
		$db2 = $this->load->database('auxiliar', TRUE);
		$this->db2 = $db2;
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

	public function list_modulos_informacoes($ciclo, $idModulo)
	{
		$consultar = $this->db->query("SELECT * FROM modulo WHERE ano LIKE $ciclo AND id_modulo LIKE $idModulo");
		$row = $consultar->num_rows();
		$dados = $consultar->row_array();

		if ($row == 0) {
			return false;
		} else {
			return $dados;
		}
	}

	public function consultaraisJaTerminouOTreinamento($nome, $email, $nascimento)
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
	}

	// mostrar pais
	public function mostrar_pais($id_usuario)
	{
		$consultar_lider = $this->db->query("SELECT * FROM lider WHERE id_lider LIKE $id_usuario");
		$dados_consultar_lider = $consultar_lider->row_array();
		$pais = $dados_consultar_lider['pais'];

		if ($pais == "br") {
			return true;
		} else {
			return false;
		}
	}

	// mostrar_usuario 
	public function mostrar_registro_tabela($email, $cpf)
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
			->from('supervisorr')
			->where('cpf', $cpf)
			->or_where('email', $email)
			->get();
		$contSurpR = $query_rementente_sr->num_rows();

		$query_rementente_se = $this->db->select('*')
			->from('supervisore')
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
	}

	public function mostrar_pastor($id_pastor)
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
	}

	public function mostrar_coordenador($id_coordenador)
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
	}

	public function mostrar_sr($id_sr)
	{
		$consultar_sr = $this->db->query("SELECT * FROM supervisorr WHERE id_supervisorR LIKE $id_sr ORDER BY nome_supervisorR ASC");
		$row = $consultar_sr->num_rows();
		$dados_consulta_sr = $consultar_sr->result_array();

		if ($row == 0) {
			echo '<option value="' . $id_sr . '">Falta de Dados</option>';
		} else {
			foreach ($dados_consulta_sr as $dados_sr) {
				echo '<option value="' . $dados_sr['id_supervisorR'] . '" selected>' . $dados_sr['nome_supervisorR'] . '</option>';
			}
		}
	}

	public function mostrar_se($id_se)
	{
		$consultar_se = $this->db->query("SELECT * FROM supervisore WHERE id_supervisorEs LIKE $id_se ORDER BY nome_supervisorE ASC");
		$row = $consultar_se->num_rows();
		$dados_consulta_se = $consultar_se->result_array();

		if ($row == 0) {
			echo '<option value="' . $id_se . '">Falta de Dados</option>';
		} else {
			foreach ($dados_consulta_se as $dados_se) {
				echo '<option value="' . $dados_se['id_supervisorEs'] . '" selected>' . $dados_se['nome_supervisorE'] . '</option>';
			}
		}
	}

	/*Colíder*/
	public function checkColider($nome, $cpf, $email, $telefone)
	{
		$consultar_colider = $this->db->query("SELECT * FROM colider WHERE nome_colider LIKE '$nome' OR email LIKE '$email' OR cpf LIKE '$cpf' OR telefone_whatsapp LIKE '$telefone'");
		$row = $consultar_colider->num_rows();

		if ($row == 0) {
			return true;
		} else {
			return false;
		}
	}

	public function mostrarColider($id_colider)
	{
		$consultar_colider = $this->db->query("SELECT * FROM colider WHERE id_colider LIKE $id_colider");
		$row = $consultar_colider->num_rows();
		$dados_consula_colider = $consultar_colider->row_array();

		if ($row == 0) {
			return false;
		} else {
			return $dados_consula_colider;
		}
	}

	public function mostrarColiderDoLider($id_usuario)
	{
		$consultar_colider = $this->db->query("SELECT * FROM colider WHERE id_lider LIKE $id_usuario AND ativo = 1 ORDER BY nome_colider ASC");
		$row = $consultar_colider->num_rows();
		$dados_consula_colider = $consultar_colider->row_array();

		if ($row == 0) {
			return false;
		} else {
			return $dados_consula_colider;
		}
	}

	public function mostrarColiderDoLiderDesativados($id_usuario)
	{
		$consultar_colider = $this->db->query("SELECT * FROM colider WHERE id_lider LIKE $id_usuario AND ativo = 0 ORDER BY nome_colider ASC");
		$row = $consultar_colider->num_rows();
		$dados_consula_colider = $consultar_colider->result_array();

		$dados = array(
			'row' => $row,
			'dados' => $dados_consula_colider,
		);

		return $dados;
	}

	public function mostrarTodosPais()
	{
		// adicionar outros níveis
		$dados = $this->db->query("SELECT * FROM pais WHERE confirmado LIKE 2 AND pais LIKE 'br'")->result_array();
		return $dados;
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

	// PAIS
	function consultaDadosPaisId($id, $x)
	{
		if ($x == 1) {
			$dados = $this->db->query("SELECT * FROM pais WHERE id LIKE $id")->row_array();
			return $dados;
		} else if ($x == 2) {
			$dados = $this->db->query("SELECT * FROM lider WHERE id_lider LIKE $id")->row_array();
			return $dados;
		}
	}

	public function consultaDadosPaisNomeCPFEMail($nome, $cpf, $cpf2, $email)
	{
		$consultar = $this->db->query("SELECT * FROM pais WHERE nome LIKE '$nome' OR cpf = '$cpf' OR cpf = '$cpf2' OR email = '$email'");
		$dados = $consultar->row_array();
		return $dados;
	}

	// PG
	public function mostrarPGId($id_usuario, $idPG, $x)
	{

		if ($x == 1) {
			$consultar_pg = $this->db->query("SELECT * FROM pg_pais WHERE id_lider LIKE $id_usuario AND id_pg = $idPG AND ativo = 1");
			$row = $consultar_pg->num_rows();
			$dados_consulta_pg = $consultar_pg->row_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_pg,
			);
			return $dados;
		} else if ($x == 2) {
			$consultar_pg = $this->db->query("SELECT * FROM pg_2 WHERE id_lider LIKE $id_usuario AND id_pg = $idPG AND ativo = 1");
			$row = $consultar_pg->num_rows();
			$dados_consulta_pg = $consultar_pg->row_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_pg,
			);
			return $dados;
		}
	}

	public function mostrarPG($id_usuario, $x)
	{
		if ($x == 1) {
			$consultar_pg = $this->db->query("SELECT * FROM pg_pais WHERE id_lider LIKE $id_usuario AND ativo = 1 ORDER BY nome_pg ASC");
			$row = $consultar_pg->num_rows();
			$dados_consulta_pg = $consultar_pg->result_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_pg,
			);
			return $dados;
		} else if ($x == 2) {
			$consultar_pg = $this->db->query("SELECT * FROM pg_2 WHERE id_lider LIKE $id_usuario AND ativo = 1 ORDER BY nome_pg ASC");
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
	}

	public function mostrarPGDesativados($id_usuario, $x)
	{

		if ($x == 1) {
			$consultar_pg = $this->db->query("SELECT * FROM pg_pais WHERE id_lider LIKE $id_usuario AND ativo = 0 ORDER BY nome_pg ASC");
			$row = $consultar_pg->num_rows();
			$dados_consulta_pg = $consultar_pg->result_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_pg,
			);
			return $dados;
		} else if ($x == 2) {
			$consultar_pg = $this->db->query("SELECT * FROM pg_2 WHERE id_lider LIKE $id_usuario AND ativo = 0 ORDER BY nome_pg ASC");
			$row = $consultar_pg->num_rows();
			$dados_consulta_pg = $consultar_pg->result_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_pg,
			);
			return $dados;
		}
	}

	public function mostrarPGDownload($id_usuario, $x)
	{
		if ($x == 1) {
			$consultar_pg = $this->db->query("SELECT * FROM pg_pais WHERE id_lider LIKE $id_usuario AND ativo = 1 ORDER BY id_modulo DESC LIMIT 1");
			$row = $consultar_pg->num_rows();
			$dados_consulta_pg = $consultar_pg->row_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_pg,
			);
			return $dados;
		} else if ($x == 2) {
			$consultar_pg = $this->db->query("SELECT * FROM pg_2 WHERE id_lider LIKE $id_usuario AND ativo = 1 ORDER BY id_modulo DESC LIMIT 1");
			$row = $consultar_pg->num_rows();
			$dados_consulta_pg = $consultar_pg->row_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_pg,
			);
			return $dados;
		}
	}

	public function consultarPgCadastrado($idLider, $nomePg, $x)
	{
		if ($x == 1) {
			$consultar_pg = $this->db->query("SELECT * FROM pg_pais WHERE id_lider = $idLider AND nome_pg LIKE '$nomePg'");
			$row = $consultar_pg->num_rows();

			if ($row == 0) {
				return true;
			} else {
				return false;
			}
		} else if ($x == 2) {
			$consultar_pg = $this->db->query("SELECT * FROM pg_2 WHERE id_lider = $idLider AND nome_pg LIKE '$nomePg'");
			$row = $consultar_pg->num_rows();

			if ($row == 0) {
				return true;
			} else {
				return false;
			}
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
		$consultar = $this->db->query("SELECT * FROM modulo WHERE ano = 1 ORDER BY ordem ASC");
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

	public function consultarModuloAno($id_ano)
	{
		$consultar = $this->db->query("SELECT * FROM modulo WHERE ano LIKE $id_ano ORDER BY ordem ASC");
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

	public function consultarProgressoGeral($id_lider, $x)
	{
		if ($x == 1) {
			$consultar = $this->db->query("SELECT * FROM progresso_pg_pais WHERE id_lider = $id_lider");
			$row = $consultar->num_rows();
			$dados = $consultar->result_array();

			$array = array(
				'row' => $row,
				'dados' => $dados,
			);

			return $array;
		} else if ($x == 2) {
			$consultar = $this->db->query("SELECT * FROM progresso_pg WHERE id_lider = $id_lider");
			$row = $consultar->num_rows();
			$dados = $consultar->result_array();

			$array = array(
				'row' => $row,
				'dados' => $dados,
			);

			return $array;
		}
	}

	public function consultarProgressoPG($id_pg, $id_modulo, $numero_licao, $x)
	{
		if ($x == 1) {
			$consultar = $this->db->query("SELECT * FROM progresso_pg_pais WHERE id_pg = $id_pg AND id_modulo = '$id_modulo' AND numero_licao = '$numero_licao'");
			$row = $consultar->num_rows();
			$dados = $consultar->row_array();

			$array = array(
				'row' => $row,
				'dados' => $dados,
			);

			return $array;
		} else if ($x == 2) {
			$consultar = $this->db->query("SELECT * FROM progresso_pg WHERE id_pg = $id_pg AND id_modulo = '$id_modulo' AND numero_licao = '$numero_licao'");
			$row = $consultar->num_rows();
			$dados = $consultar->row_array();

			$array = array(
				'row' => $row,
				'dados' => $dados,
			);

			return $array;
		}
	}

	public function consultarProgressoCriancaIndividual($id_pg, $id_lider, $id_crianca, $id_modulo, $x)
	{
		if ($x == 1) {
			$consultar = $this->db->query("SELECT * FROM progresso_pg_pais WHERE id_pg = $id_pg AND id_lider = $id_lider AND id_crianca_presente = $id_crianca AND id_modulo = $id_modulo");
			$row = $consultar->num_rows();
			$dados = $consultar->result_array();

			$array = array(
				'row' => $row,
				'dados' => $dados,
			);

			return $array;
		} else if ($x == 2) {
			$consultar = $this->db->query("SELECT * FROM progresso_pg WHERE id_pg = $id_pg AND id_lider = $id_lider AND id_crianca_presente = $id_crianca AND id_modulo = $id_modulo");
			$row = $consultar->num_rows();
			$dados = $consultar->result_array();

			$array = array(
				'row' => $row,
				'dados' => $dados,
			);

			return $array;
		}
	}


	public function checkCriancasPG($idLider, $idPG, $x)
	{
		if ($x == 1) {
			$consultar_criancas = $this->db->query("SELECT * FROM criancas WHERE lider LIKE $idLider AND id_pg = $idPG");
			$row = $consultar_criancas->num_rows();

			if ($row == 0) {
				return false;
			} else {
				return true;
			}
		} else if ($x == 2) {
			$consultar_criancas = $this->db->query("SELECT * FROM criancas_2 WHERE lider LIKE $idLider AND id_pg = $idPG");
			$row = $consultar_criancas->num_rows();

			if ($row == 0) {
				return false;
			} else {
				return true;
			}
		}
	}

	public function mostrarCriancasPaisPgTodos($id_usuario, $idPG, $x)
	{
		if ($x == 1) {
			$consultar_criancas = $this->db->query("SELECT * FROM criancas WHERE lider LIKE $id_usuario AND id_pg = $idPG ORDER BY nome_crianca ASC");
			$row = $consultar_criancas->num_rows();
			$dados_consulta_criancas = $consultar_criancas->result_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_criancas,
			);

			return $dados;
		} else if ($x == 2) {
			$consultar_criancas = $this->db->query("SELECT * FROM criancas_2 WHERE lider LIKE $id_usuario AND id_pg = $idPG ORDER BY nome_crianca ASC");
			$row = $consultar_criancas->num_rows();
			$dados_consulta_criancas = $consultar_criancas->result_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_criancas,
			);

			return $dados;
		}
	}

	public function mostrarCriancasPais($id_usuario, $x)
	{
		if ($x == 1) {
			$consultar_criancas = $this->db->query("SELECT * FROM criancas WHERE lider LIKE $id_usuario");
			$row = $consultar_criancas->num_rows();
			$dados_consulta_criancas = $consultar_criancas->result_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_criancas,
			);

			return $dados;
		} else if ($x == 2) {
			$consultar_criancas = $this->db->query("SELECT * FROM criancas_2 WHERE lider LIKE $id_usuario");
			$row = $consultar_criancas->num_rows();
			$dados_consulta_criancas = $consultar_criancas->result_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_criancas,
			);

			return $dados;
		} else if ($x == 3) {
			$consultar_criancas = $this->db->query("SELECT * FROM crianca WHERE lider LIKE $id_usuario");
			$row = $consultar_criancas->num_rows();
			$dados_consulta_criancas = $consultar_criancas->result_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_criancas,
			);

			return $dados;
		}
	}

	public function mostrarCriancasPaisPg($id_usuario, $idPG, $x)
	{
		if ($x == 1) {
			$consultar_criancas = $this->db->query("SELECT * FROM criancas WHERE lider LIKE $id_usuario AND id_pg = $idPG AND ativo = 1 ORDER BY nome_crianca ASC");
			$row = $consultar_criancas->num_rows();
			$dados_consulta_criancas = $consultar_criancas->result_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_criancas,
			);

			return $dados;
		} else if ($x == 2) {
			$consultar_criancas = $this->db->query("SELECT * FROM criancas_2 WHERE lider LIKE $id_usuario AND id_pg = $idPG AND ativo = 1 ORDER BY nome_crianca ASC");
			$row = $consultar_criancas->num_rows();
			$dados_consulta_criancas = $consultar_criancas->result_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_criancas,
			);

			return $dados;
		} else if ($x == 3) {
			$consultar_criancas = $this->db->query("SELECT * FROM crianca WHERE lider LIKE $id_usuario AND ativo = 1 ORDER BY nome_crianca ASC");
			$row = $consultar_criancas->num_rows();
			$dados_consulta_criancas = $consultar_criancas->result_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_criancas,
			);

			return $dados;
		}
	}

	public function mostrarCriancasPaisID($id_usuario, $idPG, $x, $id_crianca)
	{
		if ($x == 1) {
			$consultar_criancas = $this->db->query("SELECT * FROM criancas WHERE lider LIKE $id_usuario AND id_pg = $idPG AND ativo = 1 AND id_crianca = $id_crianca");
			$row = $consultar_criancas->num_rows();
			$dados_consulta_criancas = $consultar_criancas->row_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_criancas,
			);

			return $dados;
		} else if ($x == 2) {
			$consultar_criancas = $this->db->query("SELECT * FROM criancas_2 WHERE lider LIKE $id_usuario AND id_pg = $idPG AND ativo = 1 ORDER BY nome_crianca ASC");
			$row = $consultar_criancas->num_rows();
			$dados_consulta_criancas = $consultar_criancas->row_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_criancas,
			);

			return $dados;
		}
	}

	public function mostrarCriancasDesativadas($id_usuario, $x)
	{
		if ($x == 1) {
			$consultar_criancas = $this->db->query("SELECT * FROM criancas WHERE lider LIKE $id_usuario AND ativo = 0 ORDER BY nome_crianca ASC");
			$row = $consultar_criancas->num_rows();
			$dados_consulta_criancas = $consultar_criancas->result_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_criancas,
			);

			return $dados;
		} else if ($x == 2) {
			$consultar_criancas = $this->db->query("SELECT * FROM criancas_2 WHERE lider LIKE $id_usuario AND ativo = 0 ORDER BY nome_crianca ASC");
			$row = $consultar_criancas->num_rows();
			$dados_consulta_criancas = $consultar_criancas->result_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_criancas,
			);

			return $dados;
		}
	}

	public function mostrarCriancasPaisPgDesativadas($id_usuario, $idPG, $x)
	{
		if ($x == 1) {
			$consultar_criancas = $this->db->query("SELECT * FROM criancas WHERE lider LIKE $id_usuario AND id_pg = $idPG AND ativo = 0 ORDER BY nome_crianca ASC");
			$row = $consultar_criancas->num_rows();
			$dados_consulta_criancas = $consultar_criancas->result_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_criancas,
			);

			return $dados;
		} else if ($x == 2) {
			$consultar_criancas = $this->db->query("SELECT * FROM criancas_2 WHERE lider LIKE $id_usuario AND id_pg = $idPG AND ativo = 0 ORDER BY nome_crianca ASC");
			$row = $consultar_criancas->num_rows();
			$dados_consulta_criancas = $consultar_criancas->result_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_criancas,
			);

			return $dados;
		}
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

	public function consultarCriancasNomeEIdade($nome, $idLider, $idPG, $nascimento, $opcao, $obs, $nome_responsavel, $x)
	{
		if ($x == 1) {
			$consultar_criancas = $this->db->query("SELECT * FROM criancas WHERE lider LIKE $idLider AND id_pg = $idPG AND nome_crianca = '$nome' AND nascimento = '$nascimento' AND cristao = $opcao AND observacao = '$obs' AND nome_responsavel = '$nome_responsavel'");
			$row = $consultar_criancas->num_rows();

			if ($row == 0) {
				return true;
			} else {
				return false;
			}
		} else if ($x == 2) {
			$consultar_criancas = $this->db->query("SELECT * FROM criancas_2 WHERE lider LIKE $idLider AND id_pg = $idPG AND nome_crianca = '$nome' AND nascimento = '$nascimento' AND cristao = $opcao AND observacao = '$obs' AND nome_responsavel = '$nome_responsavel'");
			$row = $consultar_criancas->num_rows();

			if ($row == 0) {
				return true;
			} else {
				return false;
			}
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

	public function consultaraisJaCadastrado($nome, $cpf, $cpf2, $email)
	{
		$consultar = $this->db->query("SELECT * FROM pais WHERE nome LIKE '$nome' OR cpf = '$cpf' OR cpf = '$cpf2' OR email = '$email'");
		$row = $consultar->num_rows();
		if ($row == 0) {
			return true;
		} else {
			return false;
		}
	}

	public function consultarUsuarioCadastrado($nome, $cpf, $cpf2, $email)
	{
		$consultar = $this->db->query("SELECT * FROM usuario WHERE nome LIKE '$nome' OR cpf = '$cpf' OR cpf = '$cpf2' OR email = '$email'");
		$row = $consultar->num_rows();
		if ($row == 0) {
			return true;
		} else {
			return false;
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
	public function getInfoLiderId($id)
	{
		$consultar_lider = $this->db->query("SELECT * FROM lider WHERE id_lider LIKE $id");
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
		$consultar_coordenador = $this->db->query("SELECT * FROM coordenador WHERE id_coordenador LIKE $id");
		$row = $consultar_coordenador->num_rows();
		$dados_consulta_coordenador = $consultar_coordenador->row_array();

		$dados = array(
			'row' => $row,
			'dados' => $dados_consulta_coordenador,
		);

		return $dados;
	}

	public function getLideres($id_usuario, $opc, $opc2, $datas)
	{
		if ($opc == 1 && $opc2 == 1) {
			// Consulta na tabela de líderes: líderes ativos pelo id coordenador
			$id_coordenador = $id_usuario[0];

			$consultar_lideres = $this->db->query("SELECT * FROM lider WHERE id_coordenador LIKE $id_coordenador AND confirmado = 2 ORDER BY nome_lider ASC");
			$row = $consultar_lideres->num_rows();
			$dados_consulta_lideres = $consultar_lideres->result_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_lideres,
			);

			return $dados;
		} else if ($opc2 == 'nao') {
			// Consulta na tabela de líderes entre datas geral
			$id_coordenador = $id_usuario[0];

			$data_inicio = $datas['dataInicio']; // antiga
			$data_final = $datas['dataFim']; // atual

			$consultar_lideres = $this->db->query("SELECT * FROM lider WHERE id_coordenador LIKE $id_coordenador AND data_cadastro BETWEEN '$data_inicio' AND '$data_final' ORDER BY nome_lider ASC");
			$row = $consultar_lideres->num_rows();
			$dados_consulta_lideres = $consultar_lideres->result_array();

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_lideres,
			);

			return $dados;
		} else if ($opc2 == 'sim') {
			// Consulta na tabela de líderes entre datas geral
			$id_coordenador = $id_usuario[0];

			$data_inicio = $datas['dataInicio']; // antiga
			$data_final = $datas['dataFim']; // atual

			//echo "Datas 1 - " . $data_inicio . " - " . $data_final . "<br>";

			$data_inicio_menos_um_ano = $datas['dataInicioAnoPassado']; // antiga - menos um ano
			$data_final_menos_um_ano = $datas['dataFimAnoPassado']; // atual - menos um ano

			//echo "Datas 2 - " . $data_inicio_menos_um_ano . " - " . $data_final_menos_um_ano;

			$consultar_lideres = $this->db->query("SELECT * FROM lider WHERE id_coordenador LIKE $id_coordenador AND data_cadastro BETWEEN '$data_inicio' AND '$data_final' ORDER BY nome_lider ASC");
			$row = $consultar_lideres->num_rows();
			$dados_consulta_lideres = $consultar_lideres->result_array();

			$consultar_lideres_menos_um_ano = $this->db->query("SELECT * FROM lider WHERE id_coordenador LIKE $id_coordenador AND data_cadastro BETWEEN '$data_inicio_menos_um_ano' AND '$data_final_menos_um_ano' ORDER BY nome_lider ASC");
			$row_menos_um_ano = $consultar_lideres_menos_um_ano->num_rows();
			$dados_consulta_lideres_menos_um_ano = $consultar_lideres_menos_um_ano->result_array();

			$newconsulta = array(
				'row' => $row_menos_um_ano,
				'dados' => $dados_consulta_lideres_menos_um_ano,
			);

			$lideres_ativos_comparacao = $this->lideresAtivos($newconsulta);

			$total_criancas_geral = $this->getNumerosCriancas([$id_coordenador], $newconsulta, 'criancas_coord_1');
			$total_criancas_ativos = $this->getNumerosCriancas([$id_coordenador], $lideres_ativos_comparacao, 'criancas_coord_1');

			$ativos_comparacao = $lideres_ativos_comparacao['row'];

			$comparacao = array(
				'lideres' => $row_menos_um_ano,
				'lideres_ativos' => $ativos_comparacao,
				'criancas' => $total_criancas_geral,
				'criancas_ativas' => $total_criancas_ativos,
			);

			$dados = array(
				'row' => $row,
				'dados' => $dados_consulta_lideres,
				'row_menos_um_ano' => $row_menos_um_ano,
				'comparacao' => $comparacao,
			);

			return $dados;
		}
	}

	public function getUsuario($nome, $email, $cpf)
	{
		$consultar_usuario = $this->db->query("SELECT * FROM usuario WHERE email = '$email' AND cpf = '$cpf' AND nome LIKE '$nome'");
		$dados_usuario = $consultar_usuario->row_array();
		$total_usuario = $consultar_usuario->num_rows();

		$dados = array(
			'row' => $total_usuario,
			'dados' => $dados_usuario,
		);

		return $dados;
	}
	public function getNumerosCriancas($id_usuario, $users, $opc)
	{

		$total_criancas = 0;

		if ($opc == 'criancas_coord_1') {
			$id_coordenador = $id_usuario[0];

			$consultar_criancas = $this->db->query("SELECT * FROM crianca WHERE lider = $id_coordenador");
			$row = $consultar_criancas->num_rows();

			$total_criancas = $total_criancas + $row;

			if ($users['row'] == 0) {
			} else {
				foreach ($users['dados'] as $key => $dados) {
					$id = $dados['id_lider'];

					$consultar_criancas_lider = $this->db->query("SELECT * FROM crianca WHERE lider = $id");
					$row_lider = $consultar_criancas_lider->num_rows();

					$total_criancas = $total_criancas + $row_lider;
				}
			}
		}

		return $total_criancas;
	}

	public function converterData($data)
	{
		$dia = $data[0] . $data[1];

		$mes = $data[3] . $data[4];

		$ano = $data[6] . $data[7] . $data[8] . $data[9];

		$data_nova = $ano . "-" . $mes . "-" . $dia;

		return $data_nova;
	}

	public function lideresAtivos($list)
	{
		$lista = $list['dados'];
		$total_ativos = 0;
		$dados_lider = [];

		if ($list['row'] == 0) {
		} else {
			foreach ($lista as $key => $lideres) {
				$id = $lideres['id_lider'];
				$nome = $lideres['nome_lider'];
				$email = $lideres['email'];
				$cpf = $lideres['cpf'];

				$usuario = $this->getUsuario($nome, $email, $cpf);

				$ativo = $usuario['row'] == 0 ? 0 : $usuario['dados']['ativo'];

				$check_lider_pg = $this->db->query("SELECT COUNT(1) FROM pg WHERE id_lider = $id");
				$total_pg = $check_lider_pg->num_rows();

				$consultar_criancas = $this->db->query("SELECT COUNT(1) FROM crianca WHERE lider = $id");
				$total_criancas = $consultar_criancas->num_rows();

				$check_lider_progresso = $this->db->query("SELECT COUNT(1) FROM progresso_pg WHERE id_lider = $id");
				$total_progresso = $check_lider_progresso->num_rows();

				if ($ativo == 0 || $total_pg == 0 || $total_criancas == 0 || $total_progresso == 0) {
				} else {
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
	}
}
