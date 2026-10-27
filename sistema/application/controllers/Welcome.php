<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property $input
 * @property FAlerta_model $FAlerta_model
 * @property FConsultas_model $FConsultas_model
 * @property Criancas $Criancas
 * @property Lideres $Lideres
 * @property Coordenadores $Coordenadores
 * @property Supervisores $Supervisores
 * @property PG $PG
 * @property $db
 * @property $email
 * @property $upload
 * @property $uri
 */

class Welcome extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('America/Sao_Paulo');
		require_once 'import/sistema/fpdf/fpdf.php';
		define('PDF_PATH', 'import/sistema/temp/');
		$this->connect();

		//require_once 'import/PHPExcel/Classes/PHPExcel.php';
		define(
			'LETRAS',
			['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z']
		);
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

		$db3 = $this->load->database('camp', TRUE);
		$this->db3 = $db3;
	}

	public function index()
	{
		$x = $this->input->get('x');
		$dados = array('x' => $x);

		$this->load->view('sistema/page_login', $dados);
	}

	public function loginpage()
	{
		$x = $this->input->get('x');
		$dados = array('x' => $x);

		$this->load->view('sistema/page_login_back', $dados);
	}

	/*public function migrar()
	{
		$consultar_criancas = $this->db->query("SELECT * FROM crianca");
		$row = $consultar_criancas->num_rows();
		$dados_consulta_criancas = $consultar_criancas->result_array();

		foreach ($dados_consulta_criancas as $key => $crianca) {
			$id_crianca  = $crianca['id_crianca'];
			$id_lider = $crianca['lider'];
			$id_pg = $crianca['id_pg'];
			$nascimento = $crianca['nascimento'];
			$observacao = $crianca['observacao'];
			$nome_crianca = $crianca['nome_crianca'];

			$checkCriancas = $this->Criancas->check_criancas_cadastrada('check_criancas_id_crianca', [$id_crianca]);

			if ($checkCriancas) {
				$this->Criancas->cadastro_crianca_id($id_crianca, $nome_crianca, $nascimento, $id_lider, $id_pg, $observacao, '', '', '', '');
			} else {
			}
		}
	}

	public function migrar_pg()
	{
		$consultar_pg = $this->db->query("SELECT * FROM pg_2");
		$dados_consulta_pg = $consultar_pg->result_array();

		foreach ($dados_consulta_pg as $key => $crianca) {
			$id_pg  = $crianca['id_pg'];
			$id_lider = $crianca['id_lider'];
			$nome_pg = $crianca['nome_pg'];
			$ano_pg = $crianca['ano'];
			$id_modulo = $crianca['id_modulo'];
			$n_licao = $crianca['n_licao'];

			$data_cadastro = "";
			$data_inicio = $crianca['data_inicio'];
			$data_fim = $crianca['data_previsao_termino'];

			$ativo = $crianca['ativo'];
			$foto = "import/sistema/fotoPG/geral.jpg";
			$bonus = $crianca['bonus'];

			$checkPG = $this->PG->check_cadastro_pg('check_id_pg', [$id_pg]);

			if ($checkPG) {
				$this->PG->cadastro_pg_c_infos($id_pg, $id_lider, $nome_pg, $ano_pg, $id_modulo, $n_licao, $data_cadastro, $data_inicio, $data_fim, $ativo, $foto, $bonus);
			} else {
			}
		}
	}*/

	public function login()
	{
		$x = $this->input->get('x');
		$dados = array('x' => $x);

		$this->load->view('sistema/page_login', $dados);
	}

	public function autenticacao_login()
	{
		$email = $this->input->post('email') ?? $this->input->get('email');
		$cpf = $this->input->post('cpf') ?? $this->input->get('cpf');

		$nome = $this->input->post('nome') ?? $this->input->get('nome');
		$senha = $this->input->post('senha') ?? $this->input->get('senha');

		$x = $this->input->post('x_ir') ?? $this->input->get('x_ir');

		$opc = $this->input->post('opc') ?? $this->input->get('opc');

		if ($email == '' && $cpf == '' && $nome == '' && $senha == '') {
			$this->FConsultas_model->mensagem('danger', 'Erro!', ["Dados Vazios"]);
			$data = [
				"<input type='hidden' name='x' value='$x'>"
			];
			$funcao = $this->FConsultas_model->red('index', 2000, $data);
			echo $funcao;
		} else {
			$cpf_completo = "";

			if ($opc == 1) {
				$ponto = $cpf[3];
				if ($ponto == ".") {
					$cpf_completo .= $cpf;
				} else {
					$cpf_completo .= $cpf[0] . $cpf[1] . $cpf[2] . "." . $cpf[3] . $cpf[4] . $cpf[5] . "." . $cpf[6] . $cpf[7] . $cpf[8] . "-" . $cpf[9] . $cpf[10];
				}
				$consultar = $this->db->query("SELECT * FROM usuario WHERE email = '$email' AND (cpf = '$cpf' OR cpf = '$cpf_completo') LIMIT 1");
				$dados = $consultar->row_array();
				$total = $consultar->num_rows();
			} else if ($opc == 2) {
				$consultar = $this->db->query("SELECT * FROM usuario WHERE email = '$email' AND senha = '$senha'  LIMIT 1");
				$dados = $consultar->row_array();
				$total = $consultar->num_rows();
			} else if ($opc == 3) {
				$consultar = $this->db->query("SELECT * FROM usuario WHERE nome LIKE '$nome%' AND senha = '$senha'  LIMIT 1");
				$dados = $consultar->row_array();
				$total = $consultar->num_rows();
			} else {
			}

			if ($total == 0) {
				$this->FConsultas_model->mensagem('danger', 'Erro!', ["Dados Inválidos"]);
				$data = [
					"<input type='hidden' name='x' value='$x'>"
				];
				$funcao = $this->FConsultas_model->red('index', 2000, $data);
				echo $funcao;
			} else {

				$id_usuario = $dados['id_usuario'];
				$nivel = $dados['nivel'];
				$nome_base = $dados['nome'];

				$_SESSION['usuario'] = $dados['nome'];
				$_SESSION['id_usuario'] = "";
				$_SESSION['id_usuario_2'] = "";

				$ativo = 1;
				$this->db->set('ativo', $ativo);
				$this->db->where('id_usuario', $id_usuario);
				$this->db->update('usuario');

				$consultar_lider = $this->db->query("SELECT * FROM lider WHERE (email = '$email' OR cpf = '$cpf_completo') AND  (nome_lider LIKE '$nome' OR nome_lider LIKE '$nome_base')");
				$dados_lider = $consultar_lider->row_array();
				$total_lider = $consultar_lider->num_rows();

				$consultar_coordenador = $this->db->query("SELECT * FROM coordenador WHERE (email = '$email' OR cpf = '$cpf_completo') AND  (nome_coordenador LIKE '$nome' OR nome_coordenador LIKE '$nome_base')");
				$dados_coordenador = $consultar_coordenador->row_array();
				$total_coordenador = $consultar_coordenador->num_rows();

				$consultar_slocal = $this->db->query("SELECT * FROM supervisor_local WHERE (email = '$email' OR cpf = '$cpf_completo') AND  (nome_supervisorR LIKE '$nome' OR nome_supervisorR LIKE '$nome_base')");
				$dados_slocal = $consultar_slocal->row_array();
				$total_slocal = $consultar_slocal->num_rows();

				$consultar_sregional = $this->db->query("SELECT * FROM supervisor_regional WHERE (email = '$email' OR cpf = '$cpf_completo') AND  (nome_supervisorE LIKE '$nome' OR nome_supervisorE LIKE '$nome_base')");
				$dados_sregional = $consultar_sregional->row_array();
				$total_sregional = $consultar_sregional->num_rows();

				$consultar_adm = $this->db->query("SELECT * FROM direcao WHERE (email = '$email' OR cpf = '$cpf_completo') AND (nome_direcao LIKE '$nome' OR nome_direcao LIKE '$nome_base')");
				$dados_adm = $consultar_adm->row_array();
				$total_adm = $consultar_adm->num_rows();

				if ($nivel == 1) {
					//echo "nome: $nome nome 2: $nome_base cpf: $cpf_completo email: $email";

					if ($total_lider == 0) {
						$this->FConsultas_model->mensagem('danger', 'Erro!', ["Não foi encontrado seus dados em nossas bases! Entre em contato com o suporte pelo e-mail campbrasilemail@gmail.com"]);
						$data = [
							"<input type='hidden' name='x' value='$x'>"
						];
						$funcao = $this->FConsultas_model->red('index', 2000, $data);
						echo $funcao;
					} else {
						$nome = $dados['nome'];
						$this->FConsultas_model->mensagem('success', 'Olá!', ["Bem Vindo $nome"]);

						$_SESSION['id_usuario'] .= $dados_lider['id_lider'];
						$_SESSION['id_usuario_2'] .= $id_usuario;

						$consultar_termos = $this->db->select("*")
							->from("termos")
							->where("id_usuario", $id_usuario)
							->get();
						$termos = $consultar_termos->num_rows();

						if ($termos == 0) {
							$data = [
								"<input type='hidden' name='nivel' value='1'>"
							];
							$funcao = $this->FConsultas_model->red('termos', 2000, $data);
							echo $funcao;
						} else {
							if ($x == 1) {
								$data = [];
								$funcao = $this->FConsultas_model->red('lider/home', 2000, $data);
								echo $funcao;
							}
						}
					}
				} else if ($nivel == 6) { // direção
					if ($total_adm == 0) {
						$this->FConsultas_model->mensagem('danger', 'Erro!', ["Não foi encontrado seus dados em nossas bases! Entre em contato com o suporte pelo e-mail campbrasilemail@gmail.com"]);
						$data = [
							"<input type='hidden' name='x' value='$x'>"
						];
						$funcao = $this->FConsultas_model->red('index', 2000, $data);
						echo $funcao;
					} else {
						$nome = $dados['nome'];
						$this->FConsultas_model->mensagem('success', 'Olá!', ["Bem Vindo $nome"]);

						$_SESSION['id_usuario'] .= $dados_adm['id_direcao'];
						$_SESSION['id_usuario_2'] .= $id_usuario;

						$data = [];
						$funcao = $this->FConsultas_model->red('direcao/home', 2000, $data);
						echo $funcao;
					}
				} else if ($nivel == 3) { // coordenador
					if ($total_coordenador == 0) {
						$this->FConsultas_model->mensagem('danger', 'Erro!', ["Não foi encontrado seus dados em nossas bases! Entre em contato com o suporte pelo e-mail campbrasilemail@gmail.com"]);
						$data = [
							"<input type='hidden' name='x' value='$x'>"
						];
						$funcao = $this->FConsultas_model->red('index', 2000, $data);
						echo $funcao;
					} else {
						$nome = $dados['nome'];
						$this->FConsultas_model->mensagem('success', 'Olá!', ["Bem Vindo $nome"]);
						$_SESSION['id_usuario'] .= $dados_coordenador['id_coordenador'];
						$_SESSION['id_usuario_2'] .= $id_usuario;

						$consultar_termos = $this->db->select("*")
							->from("termos")
							->where("id_usuario", $id_usuario)
							->get();
						$termos = $consultar_termos->num_rows();

						if ($termos == 0) {
							$data = [
								"<input type='hidden' name='nivel' value='3'>"
							];
							$funcao = $this->FConsultas_model->red('termos', 2000, $data);
							echo $funcao;
						} else {
							if ($x == 1) {
								$data = [];
								$funcao = $this->FConsultas_model->red('coordenador/home', 2000, $data);
								echo $funcao;
							}
						}
					}
				} else if ($nivel == 4) { // slocal
					if ($total_slocal == 0) {
						$this->FConsultas_model->mensagem('danger', 'Erro!', ["Não foi encontrado seus dados em nossas bases! Entre em contato com o suporte pelo e-mail campbrasilemail@gmail.com"]);
						$data = [
							"<input type='hidden' name='x' value='$x'>"
						];
						$funcao = $this->FConsultas_model->red('index', 2000, $data);
						echo $funcao;
					} else {
						$nome = $dados['nome'];
						$this->FConsultas_model->mensagem('success', 'Olá!', ["Bem Vindo $nome"]);
						$_SESSION['id_usuario'] .= $dados_slocal['id_supervisorR'];
						$_SESSION['id_usuario_2'] .= $id_usuario;

						$consultar_termos = $this->db->select("*")
							->from("termos")
							->where("id_usuario", $id_usuario)
							->get();
						$termos = $consultar_termos->num_rows();

						if ($termos == 0) {
							$data = [
								"<input type='hidden' name='nivel' value='4'>"
							];
							$funcao = $this->FConsultas_model->red('termos', 2000, $data);
							echo $funcao;
						} else {
							if ($x == 1) {
								$data = [];
								$funcao = $this->FConsultas_model->red('supervisor/home', 2000, $data);
								echo $funcao;
							}
						}
					}
				} /*else if ($nivel == 5) { // sregional
					if ($total_sregional == 0) {
						echo "Não foi encontrado seus dados em nossas bases! Entre em contato com o suporte pelo e-mail campbrasilemail@gmail.com";
						$data = [
							"<input type='hidden' name='x' value='$x'>"
						];
						$funcao = $this->FConsultas_model->red('index', 2000, $data);
						echo $funcao;
					} else {
						echo "Bem Vindo - " . $dados['nome'];
						$_SESSION['id_usuario'] .= $dados_sregional['id_supervisorEs'];
						$_SESSION['id_usuario_2'] .= $id_usuario;

						$consultar_termos = $this->db->select("*")
							->from("termos")
							->where("id_usuario", $id_usuario)
							->get();
						$termos = $consultar_termos->num_rows();

						if ($termos == 0) {
							$data = [
								"<input type='hidden' name='nivel' value='5'>"
							];
							$funcao = $this->FConsultas_model->red('termos', 2000, $data);
							echo $funcao;
						} else {
							if ($x == 1) {
								$data = [];
								$funcao = $this->FConsultas_model->red('sregional/home', 2000, $data);
								echo $funcao;
							}
						}
					}
				}*/ else {
					echo '
				<script>
					alert("Olá, ' . $dados['nome'] . '! Estamos trabalhando no seu nível, por favor tente novamente mais tarde!");
					window.location="../";
				</script>
			';
				}
			}
		}
	}

	// ok
	public function PaginaDosTermos()
	{
		$x = $this->input->post('x');
		$nivel = $this->input->post('nivel');
		$dados = array('nivel' => $nivel, 'x' => $x,);

		$this->load->view('sistema/termos', $dados);
	}

	public function aceitarTermos($idUsuario, $confirmacao)
	{
		date_default_timezone_set('America/Sao_Paulo');
		$data = date('d/m/Y');
		$hora = date('h:i');

		$inserir['id_termo'] = NULL;
		$inserir['id_usuario'] = $idUsuario;
		$inserir['confirmacao'] = $confirmacao;
		$inserir['data'] = $data;
		$inserir['hora'] = $hora;

		if ($this->db->insert('termos', $inserir)) {
			return true;
		} else {
			return false;
		}
	}

	// ok
	public function PrimeiroAcesso()
	{
		$id_usuario = $this->input->post('id_usuario');
		$id_lider = $this->input->post('id_lider');
		$nivel = $this->input->post('nivel');
		$check = $this->input->post('x_ir');

		if ($check == '2') {
			$consultar_termos = $this->db->select("*")
				->from("termos")
				->where("id_usuario", $id_usuario)
				->get();
			$termos = $consultar_termos->num_rows();

			if ($termos == 0) {
				$confimacao = 1;
				$this->aceitarTermos($id_usuario, $confimacao);
			}
		}

		if ($nivel == 1) {
			$dados_user = $this->Lideres->infos([$id_lider], 'info_lider', '', []);

			if ($dados_user['row'] == 0) {
			} else {
				$email = $dados_user['dados']['email'];
				$cpf = $dados_user['dados']['cpf'];

				$dados_lider = $this->Lideres->infos([$email, $cpf], 'info_lider_email_cpf', '', []);

				if ($dados_lider['row'] == 0) {
				} else {
					$id_lider = $dados_lider['dados']['id_lider'];

					//echo "id lider - " . $id_lider;

					$consultarPG = $this->PG->check_cadastro_pg('check_id_lider', [$id_lider]);
					$consultaCriancas = $this->Criancas->check_criancas_cadastrada('check_criancas_id_lider', [$id_lider]);

					//echo " tem pg - $consultarPG tem criança $consultaCriancas";

					if ($consultarPG || $consultaCriancas || $check == 3) {
						$this->load->view('sistema/lider/primeiro_acesso');
					} else {
						//$this->load->view('sistema/lider/home');
						echo '
							<script>
								setTimeout(function(){ window.location="lider/home"}, 0)
							</script>
						';
					}
				}
			}
		} else if ($nivel == 3) {
			//$this->load->view('sistema/coordenador/home');
			echo '
				<script>
					setTimeout(function(){ window.location="coordenador/home"}, 0)
				</script>
			';
		} else if ($nivel == 4) {
			echo '
				<script>
					setTimeout(function(){ window.location="supervisor/home"}, 0)
				</script>
			';
			//$this->load->view('sistema/slocal/home');
		}
	}

	public function sair()
	{
		$id_usuario = $this->input->post("id_usuario");

		$ativo = 0;

		$this->db->set('ativo', $ativo);
		$this->db->where('id_usuario', $id_usuario);
		$this->db->update('usuario');

		$this->FConsultas_model->mensagem('success', 'Adeus!', ["Fim de Sessão!!"]);
		//echo "Fim de Sessão!!";
		echo '
			<script>
				setTimeout(function(){ window.location="index"}, 3000)
			</script>
		';
	}

	// página de cadastro de líder - via link
	public function cadastro()
	{
		$codigo =  $this->uri->segment(2);

		if ($codigo == '') {
			$dados = array(
				'titulo' => "Discipulando no Lar",
				'mensagem_1' => "Link Inválido",
				'mensagem_2' => "Peça o seu coodenador/supervisor para gerar um novo link",
				'rodape' => "Se tiver alguma dúvida ou precisar de mais informações, por favor não hesite em entrar em contato conosco.",
			);

			$this->load->view('partes/mensagem', $dados);
		} else {

			$check = $this->FConsultas_model->check_codigo($codigo);

			if ($check) {

				$consultar_codigo = $this->db->query("SELECT * FROM link_cadastro WHERE codigo = '$codigo'");
				$dados_codigo = $consultar_codigo->row_array();

				$dados = array(
					'codigo' => $codigo,
					'dados' => $dados_codigo,
				);

				$this->load->view('sistema/cadastro', $dados);
			} else {
				$dados = array(
					'titulo' => "Discipulando no Lar",
					'mensagem_1' => "Link Inválido",
					'mensagem_2' => "Peça o seu coodenador/supervisor para gerar um novo link",
					'rodape' => "Se tiver alguma dúvida ou precisar de mais informações, por favor não hesite em entrar em contato conosco.",
				);

				$this->load->view('partes/mensagem', $dados);
			}
		}
	}

	// cadastro lider via link
	public function salvar_cadastro()
	{
		$nome = $this->input->post('nome');
		$cpf = $this->input->post('cpf');
		$email = $this->input->post('email');
		$telefone_digitado = $this->input->post('telefone');
		$igreja = $this->input->post('igreja');
		$pais = $this->input->post('pais');
		$estado1 = $this->input->post('estados');
		$cidade1 = $this->input->post('cidades');
		$estado2 = $this->input->post('estados2');
		$cidade2 = $this->input->post('cidades2');
		$nascimento = $this->input->post('nascimento');

		$senha = $this->input->post('senha');

		$is_br = $pais == 'br' || '' ? true : false;

		$telefone = $this->FConsultas_model->formatar_telefone($telefone_digitado, $is_br);

		$codigo = $this->input->post('codigo');

		$estado = "";
		$cidade = "";

		// Colider
		$isColider = $this->input->post('isColider');
		$nomeColider = $this->input->post('nomeColider');
		$cpfColider = $this->input->post('cpfColider');
		$emailColider = $this->input->post('emailColider');
		$telefoneColider_digitado = $this->input->post('telefoneColider');
		$nascimentoColider = $this->input->post('nascimentoColider');

		$nome_digitado_pais = $this->input->post('nome_pais');

		$nome_pais = "";

		if ($pais == "br") {
			$nome_pais = "Brasil";
		} else {
			$nome_pais = $nome_digitado_pais;
		}

		if ($estado1 == "" and $cidade1 == "") {
			$estado = $estado2;
			$cidade = $cidade2;
		} else {
			$estado = $estado1;
			$cidade = $cidade1;
		}

		$infocodigo = $this->FConsultas_model->infos_codigo($codigo);

		// cadastro líder pais = brasil
		if ($is_br) {
			$cpfSoNumeros = preg_replace('/\D/', '', $cpf);
			$total_numeros_cpf = strlen($cpfSoNumeros);

			$dataNascimentoSoNumeros = preg_replace('/\D/', '', $nascimento);
			$total_numeros_data_nascimento = strlen($dataNascimentoSoNumeros);

			$liberado = false;

			if ($isColider == '') {
				$liberado = true;
			} else {
				$cpfColiderSoNumeros = preg_replace('/\D/', '', $cpfColider);
				$total_numeros_cpf_colider = strlen($cpfColiderSoNumeros);

				$dataNascimentoColiderSoNumeros = preg_replace('/\D/', '', $nascimentoColider);
				$total_numeros_data_nascimento_colider = strlen($dataNascimentoColiderSoNumeros);

				if ($total_numeros_cpf_colider == 11 && $total_numeros_data_nascimento_colider == 8 && $this->FAlerta_model->valida_cpf($cpfColiderSoNumeros)) {
					$liberado = true;
				} else {
					$liberado = false;
				}
			}

			if ($liberado) {
				if ($total_numeros_cpf == 11 && $total_numeros_data_nascimento == 8 && $this->FAlerta_model->valida_cpf($cpfSoNumeros)) {
					$cpf_completo = $cpfSoNumeros[0] . $cpfSoNumeros[1] . $cpfSoNumeros[2] . "." . $cpfSoNumeros[3] . $cpfSoNumeros[4] . $cpfSoNumeros[5] . "." . $cpfSoNumeros[6] . $cpfSoNumeros[7] . $cpfSoNumeros[8] . "-" . $cpfSoNumeros[9] . $cpfSoNumeros[10];
					$data_nascimento_completo = $dataNascimentoSoNumeros[0] . $dataNascimentoSoNumeros[1] . "/" . $dataNascimentoSoNumeros[2] . $dataNascimentoSoNumeros[3] . "/" . $dataNascimentoSoNumeros[4] . $dataNascimentoSoNumeros[5] . $dataNascimentoSoNumeros[6] . $dataNascimentoSoNumeros[7];

					$id_coordenador = "";
					$id_supervisor = "";

					$codigo_id_c = $infocodigo['dados'];
					if ($codigo_id_c == '') {
						$id_coordenador = $infocodigo['id_usuario'];
						$id_supervisor = 4000;
					} else {
						$id_coordenador = $infocodigo['id_usuario'];
						$id_supervisor = $infocodigo['dados'];
					}

					$liderjacadastrado = $this->Lideres->check_cadastro('consultar_por_2_cpf_email_nome', [$nome, $cpfSoNumeros, $cpf_completo, $email]);
					$usuariojatacadastrado = $this->Lideres->check_cadastro_usuario('check_nome_2_cpf_email', [$nome, $cpfSoNumeros, $cpf_completo, $email]);

					if ($liderjacadastrado == 0 && $usuariojatacadastrado == 0) {
						$nivel = 1;
						$cadastro = $this->Lideres->cadastro_lider($nome, $cpf_completo, $email, $telefone, $igreja, $data_nascimento_completo, 2000, $nome_pais, $estado, $cidade, $id_coordenador, $id_supervisor, $id_supervisor, 1);
						$cadastroUsuario = $this->Lideres->cadastrarUsuário($nome, $email, $cpf_completo, $nivel, $senha);
						if ($cadastro && $cadastroUsuario) {
							$consultarDados = $this->Lideres->infos([$email, $cpfSoNumeros, $cpf_completo, $nome], 'info_lider_or_email_cpf_nome', '', '');
							$id_lider = $consultarDados['dados']['id_lider'];

							$consultarDadosUsuario = $this->Lideres->infos([$email, $cpf_completo], 'info_usuario_and_email_cpf', '', '');
							$id_usuario = $consultarDadosUsuario['dados']['id_usuario'];

							if ($isColider == '') {
							} else {

								$cpfColiderSoNumeros = preg_replace('/\D/', '', $cpfColider);
								$total_numeros_cpf_colider = strlen($cpfColiderSoNumeros);

								$dataNascimentoColiderSoNumeros = preg_replace('/\D/', '', $nascimentoColider);
								$total_numeros_data_nascimento_colider = strlen($dataNascimentoColiderSoNumeros);

								if ($total_numeros_cpf_colider == 11 && $total_numeros_data_nascimento_colider == 8 && $this->FAlerta_model->valida_cpf($cpfColiderSoNumeros)) {
									$cpf_completo_colider = $cpfColiderSoNumeros[0] . $cpfColiderSoNumeros[1] . $cpfColiderSoNumeros[2] . "." . $cpfColiderSoNumeros[3] . $cpfColiderSoNumeros[4] . $cpfColiderSoNumeros[5] . "." . $cpfColiderSoNumeros[6] . $cpfColiderSoNumeros[7] . $cpfColiderSoNumeros[8] . "-" . $cpfColiderSoNumeros[9] . $cpfColiderSoNumeros[10];

									$data_nascimento_colider_completo = $dataNascimentoColiderSoNumeros[0] . $dataNascimentoColiderSoNumeros[1] . "/" . $dataNascimentoColiderSoNumeros[2] . $dataNascimentoColiderSoNumeros[3] . "/" . $dataNascimentoColiderSoNumeros[4] . $dataNascimentoColiderSoNumeros[5] . $dataNascimentoColiderSoNumeros[6] . $dataNascimentoColiderSoNumeros[7];

									$telefoneColider = $this->FConsultas_model->formatar_telefone($telefoneColider_digitado, $is_br);

									$this->Lideres->cadastrarColider($id_lider, $nomeColider, $cpf_completo_colider, $emailColider, $telefoneColider, $data_nascimento_colider_completo);
								} else {
								}
							}

							$this->enviar_email_coordenador_liberacao_sistema_do_lider($id_coordenador, $id_usuario, $id_lider);
							$this->enviar_email_direcao_liberacao_sistema($id_supervisor, $id_usuario, $id_lider);

							$this->FConsultas_model->mensagem('success', 'Sucesso!', ["Cadastro Realizado com Sucesso! Aguarde! Em breve retornaremos com mais Informações"]);
							echo '
							<script>
								setTimeout(function(){ window.location="https://site.campbrasil.com/" }, 3000);
							</script>
						';
						} else {
							$link = $infocodigo['link'];
							$this->FConsultas_model->mensagem('danger', 'Erro!', ["Tente Novamente!"]);
							echo '
							<script>
								setTimeout(function(){ window.location="' . $link . '" }, 3000);
							</script>
						';
						}
					} else {
						$info_usuario = $this->Lideres->infos([$email, $cpf, $nome], 'info_usuario_or_email_cpf_nome', '', '');

						if ($info_usuario['row'] == 0) {
							$mensagem = "Link Inválido!\nDados não Encontrado";
							$link = "https://sistemas.campbrasil.com";
						} else {
							$nome_usuario = $info_usuario['dados']['nome'];
							$email_usuario = $info_usuario['dados']['email'];
							$cpf_usuario = $info_usuario['dados']['cpf'];
							$senha = $info_usuario['dados']['senha'];
							$mensagem = "Sucesso!\nLíder Liberado!";
							$link = "https://sistemas.campbrasil.com/sistema/acesso?email=$email_usuario&cpf=$cpf_usuario&nome=$nome_usuario&senha=$senha&x_ir=1&opc=1";
						}

						$this->FConsultas_model->mensagem('danger', 'Você já está cadastrado! Você será redirecionado!', [$mensagem]);
						echo '
						<script>
							setTimeout(function(){ window.location="' . $link . '" }, 3000);
						</script>
					';
					}
				} else {
					$link = $infocodigo['link'];
					$this->FConsultas_model->mensagem('danger', 'Erro!', ["Informações de CPF e/ou Data de Nascimento Inválidas!"]);
					echo '
				<script>
					setTimeout(function(){ window.location="' . $link . '" }, 3000);
				</script>
			';
				}
			} else {
				$link = $infocodigo['link'];
				$this->FConsultas_model->mensagem('danger', 'Erro!', ["Informações do Colíder (CPF e/ou Data de Nascimento) Inválidas!"]);
				echo '
					<script>
						setTimeout(function(){ window.location="' . $link . '" }, 3000);
					</script>
				';
			}
		} else {
			// cadastro líder outro pais
			$dataNascimentoSoNumeros = preg_replace('/\D/', '', $nascimento);
			$total_numeros_data_nascimento = strlen($dataNascimentoSoNumeros);

			$liberado = false;

			if ($isColider == '') {
				$liberado = true;
			} else {
				$dataNascimentoColiderSoNumeros = preg_replace('/\D/', '', $nascimentoColider);
				$total_numeros_data_nascimento_colider = strlen($dataNascimentoColiderSoNumeros);

				if ($total_numeros_data_nascimento_colider == 8) {
					$liberado = true;
				} else {
					$liberado = false;
				}
			}

			if ($liberado) {
				if ($total_numeros_data_nascimento == 8) {
					$id_coordenador = "";
					$id_supervisor = "";

					$data_nascimento_completo = $dataNascimentoSoNumeros[0] . $dataNascimentoSoNumeros[1] . "/" . $dataNascimentoSoNumeros[2] . $dataNascimentoSoNumeros[3] . "/" . $dataNascimentoSoNumeros[4] . $dataNascimentoSoNumeros[5] . $dataNascimentoSoNumeros[6] . $dataNascimentoSoNumeros[7];

					$codigo_id_c = $infocodigo['dados'];
					if ($codigo_id_c == '') {
						$id_coordenador = $infocodigo['id_usuario'];
						$id_supervisor = 4000;
					} else {
						$id_coordenador = $infocodigo['id_usuario'];
						$id_supervisor = $infocodigo['dados'];
					}

					$liderjacadastrado = $this->Lideres->check_cadastro('consultar_por_email_nome_data_nascimento', [$nome, $email, $data_nascimento_completo]);
					$usuariojatacadastrado = $this->Lideres->check_cadastro_usuario('check_nome_email', [$nome, $email]);

					if ($liderjacadastrado == 0 && $usuariojatacadastrado == 0) {
						$nivel = 1;
						$cadastro = $this->Lideres->cadastro_lider($nome, "", $email, $telefone, $igreja, $data_nascimento_completo, 2000, $nome_pais, $estado, $cidade, $id_coordenador, $id_supervisor, $id_supervisor, 1);
						$cadastroUsuario = $this->Lideres->cadastrarUsuário($nome, $email, '', $nivel, $senha);
						if ($cadastro && $cadastroUsuario) {
							$consultarDados = $this->Lideres->infos([$email, $nome, $data_nascimento_completo], 'info_lider_nome_email_data_nascimento', '', '');
							$id_lider = $consultarDados['dados']['id_lider'];

							$consultarDadosUsuario = $this->Lideres->infos([$email, $nome], 'info_usuario_or_email_nome', '', '');
							$id_usuario = $consultarDadosUsuario['dados']['id_usuario'];

							if ($isColider == '') {
							} else {
								$dataNascimentoColiderSoNumeros = preg_replace('/\D/', '', $nascimentoColider);
								$total_numeros_data_nascimento_colider = strlen($dataNascimentoColiderSoNumeros);

								if ($total_numeros_data_nascimento_colider == 8) {
									$data_nascimento_colider_completo = $dataNascimentoColiderSoNumeros[0] . $dataNascimentoColiderSoNumeros[1] . "/" . $dataNascimentoColiderSoNumeros[2] . $dataNascimentoColiderSoNumeros[3] . "/" . $dataNascimentoColiderSoNumeros[4] . $dataNascimentoColiderSoNumeros[5] . $dataNascimentoColiderSoNumeros[6] . $dataNascimentoColiderSoNumeros[7];

									$telefoneColider = $this->FConsultas_model->formatar_telefone($telefoneColider_digitado, $is_br);

									$this->Lideres->cadastrarColider($id_lider, $nomeColider, "", $emailColider, $telefoneColider, $data_nascimento_colider_completo);
								} else {
								}
							}

							$this->enviar_email_coordenador_liberacao_sistema_do_lider($id_coordenador, $id_usuario, $id_lider);
							$this->enviar_email_direcao_liberacao_sistema($id_supervisor, $id_usuario, $id_lider);

							$this->FConsultas_model->mensagem('success', 'Sucesso!', ["Cadastro Realizado com Sucesso! Aguarde! Em breve retornaremos com mais Informações"]);
							echo '
							<script>
								setTimeout(function(){ window.location="https://site.campbrasil.com/" }, 3000);
							</script>
						';
						} else {
							$link = $infocodigo['link'];
							$this->FConsultas_model->mensagem('danger', 'Erro!', ["Tente Novamente!"]);
							echo '
							<script>
								setTimeout(function(){ window.location="' . $link . '" }, 3000);
							</script>
						';
						}
					} else {
						$info_usuario = $this->Lideres->infos([$email, $nome], 'info_usuario_or_email_nome', '', '');

						if ($info_usuario['row'] == 0) {
							$mensagem = "Link Inválido!\nDados não Encontrado";
							$link = "https://sistemas.campbrasil.com";
						} else {
							$nome_usuario = $info_usuario['dados']['nome'];
							$email_usuario = $info_usuario['dados']['email'];
							$cpf_usuario = $info_usuario['dados']['cpf'];
							$senha = $info_usuario['dados']['senha'];
							$mensagem = "Sucesso!\nLíder Liberado!";
							$link = "https://sistemas.campbrasil.com/sistema/acesso?email=$email_usuario&cpf=$cpf_usuario&nome=$nome_usuario&senha=$senha&x_ir=1&opc=2";
						}

						$this->FConsultas_model->mensagem('danger', 'Você já está cadastrado! Você será redirecionado!', [$mensagem]);
						echo '
						<script>
							setTimeout(function(){ window.location="' . $link . '" }, 3000);
						</script>
					';
					}
				} else {
					$link = $infocodigo['link'];
					$this->FConsultas_model->mensagem('danger', 'Erro!', ["Informações de CPF e/ou Data de Nascimento Inválidas!"]);
					echo '
				<script>
					setTimeout(function(){ window.location="' . $link . '" }, 3000);
				</script>
			';
				}
			} else {
				$link = $infocodigo['link'];
				$this->FConsultas_model->mensagem('danger', 'Erro!', ["Informações do Colíder (CPF e/ou Data de Nascimento) Inválidas!"]);
				echo '
					<script>
						setTimeout(function(){ window.location="' . $link . '" }, 3000);
					</script>
				';
			}
		}
	}

	// coordenador aprovar via link email
	public function aprovar_acesso_lider()
	{
		$id_operador = $this->input->get('id_operador');

		$id_usuario = $this->input->get('id_usuario');
		$id_lider = $this->input->get('id_lider');

		$mensagem = "";
		$link = "https://sistemas.campbrasil.com";

		if ($id_operador == '' || $id_usuario == '' || $id_lider == '') {
			$mensagem = "Link Inválido!\nDados Vazios";
		} else {

			$info_lider = $this->FConsultas_model->getInfoUserId($id_lider);
			if ($info_lider['row'] == 0) {
				$mensagem = "Link Inválido!\nDados não Encontrado";
			} else {
				$email = $info_lider['dados']['email'];
				$cpf = $info_lider['dados']['cpf'];
				$nome = $this->FConsultas_model->getNomeUserId($id_lider)['nome'];

				$info_usuario = $this->Lideres->infos([$email, $cpf, $nome], 'info_usuario_and_email_cpf_nome', '', '');

				if ($info_usuario['row'] == 0) {
					$mensagem = "Link Inválido!\nDados não Encontrado";
				} else {
					$senha = $info_usuario['dados']['senha'];
					$mensagem = "Sucesso!\nLíder Liberado!";
					$link_lider = "https://sistemas.campbrasil.com/sistema/acesso?email=$email&cpf=$cpf&nome=$nome&senha=$senha&x_ir=1&opc=1";

					$this->Lideres->editar_autorizacao_lider($id_lider, 2);
					$this->enviar_email_lider_liberacao_sistema($id_lider, $link_lider);
				}
			}

			// gerar link acesso coordenador/supervisor
			$dados_coordenador = $this->Coordenadores->infos([$id_operador], 'info_coordenador', '', '');

			if ($dados_coordenador['row'] == 0) {

				$dados_supervisor = $this->Supervisores->infos([$id_operador], 'info_supervisor', '', '');
				if ($dados_supervisor['row'] == 0) {
				} else {
					$email = $dados_coordenador['dados']['email'];
					$cpf = $dados_coordenador['dados']['cpf'];
					$nome = $dados_coordenador['dados']['nome_coordenador'];
					$info_usuario = $this->Lideres->infos([$email, $cpf, $nome], 'info_usuario_and_email_cpf_nome', '', '');
					$senha = $info_usuario['dados']['senha'];
					$link = "https://sistemas.campbrasil.com/sistema/acesso?email=$email&cpf=$cpf&nome=$nome&senha=$senha&x_ir=1&opc=1";
				}
			} else {
				$email = $dados_coordenador['dados']['email'];
				$cpf = $dados_coordenador['dados']['cpf'];
				$nome = $dados_coordenador['dados']['nome_coordenador'];
				$info_usuario = $this->Lideres->infos([$email, $cpf, $nome], 'info_usuario_and_email_cpf_nome', '', '');
				$senha = $info_usuario['dados']['senha'];
				$link = "https://sistemas.campbrasil.com/sistema/acesso?email=$email&cpf=$cpf&nome=$nome&senha=$senha&x_ir=1&opc=1";
			}
		}

		$dados = array(
			'titulo' => "Discipulando no Lar",
			'mensagem_1' => $mensagem,
			'mensagem_2' => "Aguarde você será redirecionado.",
			'rodape' => "Se tiver alguma dúvida ou precisar de mais informações, por favor não hesite em entrar em contato conosco.",
		);

		$this->load->view('partes/mensagem', $dados);

		echo '
				<script>
					setTimeout(function(){ window.location="' . $link . '" }, 3000);
				</script>
			';
	}

	// liberar acesso via plataforma sem ser no link do email
	public function liberar_acesso(): void
	{
		$id_lider = $this->input->post('id_lider');
		$id_usuario = $this->input->post('id_usuario');

		$info_lider = $this->Lideres->infos([$id_lider], 'info_lider', '', '');
		$is_br = $info_lider['dados']['pais'] == 'br' || '' ? true : false;

		$telefone = $this->FConsultas_model->formatar_telefone($info_lider['dados']['telefone_whatsapp'], $is_br);
		$mensagem = "Bem-Vindo ao sistema do CAMP Brasil!";

		$routa = $this->input->post('routa');

		$mudar = $this->Lideres->editar_autorizacao_lider($id_lider, 2);

		$email = $info_lider['dados']['email'];
		$cpf = $info_lider['dados']['cpf'];
		$nome = $info_lider['dados']['nome_lider'];
		$info_usuario = $this->Lideres->infos([$email, $cpf, $nome], 'info_usuario_and_email_cpf_nome', '', '');
		$senha = $info_usuario['dados']['senha'];

		if ($is_br) {
			$opc = 1;
		} else {
			$opc = 2;
		}

		$link_lider = "https://sistemas.campbrasil.com/sistema/acesso?email=$email&cpf=$cpf&nome=$nome&senha=$senha&x_ir=1&opc=$opc";
		$this->enviar_email_lider_liberacao_sistema($id_lider, $link_lider);

		if ($mudar) {
			$this->FAlerta_model->alerta_controle($id_usuario, $id_lider, "autorizou com sucesso seu lider", 'coord_autoriza_lider');

			$this->FConsultas_model->mensagem('success', 'Sucesso!', ['Sucesso!']);
			$funcao = $this->FConsultas_model->red("$routa", 2000, []);

			echo $funcao;

			echo '<script>
				const newTab = window.open("about:blank");
				setTimeout(function() {
				newTab.location.href = "https://api.whatsapp.com/send?phone=' . $telefone . '&text=' . $mensagem . '";
				}, 0);
			</script>';
		}
	}

	// ok
	public function cadastro_crianca()
	{
		$total = $this->input->post('total');
		$lider = $this->input->post('id_lider');
		$nome = $this->input->post('nome');
		$id_pg = $this->input->post('id_pg');
		$obs = $this->input->post('obs');
		$opcao = $this->input->post('opcao');

		$nascimento_digitado = $this->input->post('nascimento');

		$responsavel_crianca = $this->input->post('responsavel_crianca');
		$nome_responsavel = $this->input->post('nome_responsavel');
		$email_responsavel = $this->input->post('email_responsavel');
		$telefone_responsavel = $this->input->post('telefone_responsavel');

		$dadosusuario = $this->FConsultas_model->getInfoUserId($lider);
		$dadosnomeusuario = $this->FConsultas_model->getNomeUserId($lider);

		$total_count = count($total);

		for ($i = 0; $i < $total_count; $i++) {

			$nascimento2_digitado = $nascimento_digitado[$i];
			$dataNascimentoSoNumeros = preg_replace('/\D/', '', $nascimento2_digitado);

			$nascimento2 = $dataNascimentoSoNumeros[0] . $dataNascimentoSoNumeros[1] . "/" . $dataNascimentoSoNumeros[2] . $dataNascimentoSoNumeros[3] . "/" . $dataNascimentoSoNumeros[4] . $dataNascimentoSoNumeros[5] . $dataNascimentoSoNumeros[6] . $dataNascimentoSoNumeros[7];

			$nome2 = $nome[$i];
			$lider2 = $lider;
			$id_pg2 = $id_pg;
			$obs2 = $obs[$i];
			$opcao2 = $opcao[$i];

			$responsavel_crianca2 = $responsavel_crianca[$i];

			$nomePai = "";
			$emailPai = "";
			$telefonePai = "";

			if ($responsavel_crianca2 == 'outro') {
				$nomePai = $nome_responsavel[$i];
				$emailPai = $email_responsavel[$i];
				$telefonePai = $telefone_responsavel[$i];
			} else {
				$nomePai = $dadosnomeusuario['nome'];
				$emailPai = $dadosusuario['dados']['email'];
				$telefonePai = $dadosusuario['dados']['telefone_whatsapp'];
			}

			$checkCriancas = $this->Criancas->check_criancas_cadastrada('check_criancas_id_lider_id_pg_nome_crianca_nascimento_obs_responsavel_cristao', [$lider2, $id_pg2, $nome2, $nascimento2, $obs2, $nomePai, $opcao2]);

			if ($checkCriancas) {
				$this->Criancas->cadastro_crianca($nome2, $nascimento2, $lider2, $id_pg2, $obs2, $opcao2, $nomePai, $emailPai, $telefonePai);
			} else {
			}
		}

		$red = $this->input->post('red');
		$data = [];

		$this->FConsultas_model->mensagem('success', 'Sucesso!', ['Cadastro Relizado com Sucesso!']);
		$funcao = $this->FConsultas_model->red($red, 2000, $data);
		echo $funcao;
	}

	// ok
	public function cadastro_crianca_inicial()
	{
		$total = $this->input->post('total');
		$lider = $this->input->post('id_lider');
		$nome = $this->input->post('nome');
		$id_pg = $this->input->post('id_pg');
		$obs = $this->input->post('obs');
		$opcao = $this->input->post('opcao');
		$nascimento_digitado = $this->input->post('nascimento');

		$nivel = $this->input->post('nivel');

		$responsavel_crianca = $this->input->post('responsavel_crianca');
		$nome_responsavel = $this->input->post('nome_responsavel');
		$email_responsavel = $this->input->post('email_responsavel');
		$telefone_responsavel = $this->input->post('telefone_responsavel');

		$dadosPais = $this->Lideres->infos([$lider], 'info_lider', '', '');

		$total_count = count($total);

		for ($i = 0; $i < $total_count; $i++) {

			$nascimento2_digitado = $nascimento_digitado[$i];
			$dataNascimentoSoNumeros = preg_replace('/\D/', '', $nascimento2_digitado);

			$nascimento2 = $dataNascimentoSoNumeros[0] . $dataNascimentoSoNumeros[1] . "/" . $dataNascimentoSoNumeros[2] . $dataNascimentoSoNumeros[3] . "/" . $dataNascimentoSoNumeros[4] . $dataNascimentoSoNumeros[5] . $dataNascimentoSoNumeros[6] . $dataNascimentoSoNumeros[7];

			$nome2 = $nome[$i];
			$lider2 = $lider;
			$id_pg2 = $id_pg;
			$obs2 = $obs[$i];
			$opcao2 = $opcao[$i];

			$responsavel_crianca2 = $responsavel_crianca[$i];

			$nomePai = "";
			$emailPai = "";
			$telefonePai = "";

			if ($responsavel_crianca2 == 'outro') {
				$nomePai = $nome_responsavel[$i];
				$emailPai = $email_responsavel[$i];
				$telefonePai = $telefone_responsavel[$i];
			} else {
				$nomePai = $dadosPais['dados']['nome_lider'];
				$emailPai = $dadosPais['dados']['email'];
				$telefonePai = $dadosPais['telefone_whatsapp'] ?? "";
			}

			$checkCriancas = $this->Criancas->check_criancas_cadastrada('check_criancas_id_lider_id_pg_nome_crianca_nascimento_obs_responsavel_cristao', [$lider2, $id_pg2, $nome2, $nascimento2, $obs2, $nomePai, $opcao2]);

			if ($checkCriancas) {
				$this->Criancas->cadastro_crianca($nome2, $nascimento2, $lider2, $id_pg2, $obs2, $opcao2, $nomePai, $emailPai, $telefonePai);
			} else {
			}
		}

		$data = [
			"<input type='hidden' name='id_lider' value='$lider'>",
			"<input type='hidden' name='nivel' value='$nivel'>",
			"<input type='hidden' name='x_ir' value='3'>",
		];
		$funcao = $this->FConsultas_model->red('../../primeiro_acesso', 0, $data);
		echo $funcao;
	}

	// ok
	public function editar_crianca()
	{
		$id_crianca = $this->input->post('idCrianca');
		$lider = $this->input->post('idLider');
		$nome = $this->input->post('nome');
		$id_pg = $this->input->post('idPg');
		$obs = $this->input->post('obs');
		$opcao = $this->input->post('opcao');

		$nascimento_digitado = $this->input->post('nascimento');
		$dataNascimentoSoNumeros = preg_replace('/\D/', '', $nascimento_digitado);
		$nascimento = $dataNascimentoSoNumeros[0] . $dataNascimentoSoNumeros[1] . "/" . $dataNascimentoSoNumeros[2] . $dataNascimentoSoNumeros[3] . "/" . $dataNascimentoSoNumeros[4] . $dataNascimentoSoNumeros[5] . $dataNascimentoSoNumeros[6] . $dataNascimentoSoNumeros[7];

		$isResponsavel = $this->input->post('isResponsavel');

		$nome_responsavel = $isResponsavel == 2 || $isResponsavel == 0 ? $this->input->post('nome_responsavel_1') : $this->input->post('nome_responsavel');
		$email_responsavel = $isResponsavel == 2 || $isResponsavel == 0 ? $this->input->post('email_responsavel_1') : $this->input->post('email_responsavel');
		$telefone_responsavel = $isResponsavel == 2 || $isResponsavel == 0 ? $this->input->post('telefone_responsavel_1') : $this->input->post('telefone_responsavel');

		$checkCriancas = $this->Criancas->check_criancas_cadastrada('check_criancas_id_lider_id_pg_nome_crianca_nascimento_obs_responsavel_cristao', [$lider, $id_pg, $nome, $nascimento, $obs, $nome_responsavel, $opcao]);

		$red = $this->input->post('red');
		$data = [];

		if ($checkCriancas) {
			$editar = $this->Criancas->edita_crianca($id_crianca, $nome, $nascimento, $lider, $id_pg, $obs, $opcao, $nome_responsavel, $email_responsavel, $telefone_responsavel);
			if ($editar) {
				$this->FConsultas_model->mensagem('success', 'Sucesso!', ['Edição Relizada com Sucesso!']);
				$funcao = $this->FConsultas_model->red($red, 2000, $data);
				echo $funcao;
			} else {
				$this->FConsultas_model->mensagem('danger', 'Erro!', ['Tente novamente!']);
				$funcao = $this->FConsultas_model->red($red, 2000, $data);
				echo $funcao;
			}
		} else {
			$this->FConsultas_model->mensagem('danger', 'Erro!', ['Já tem uma criança com esses dados!']);
			$funcao = $this->FConsultas_model->red($red, 2000, $data);
			echo $funcao;
		}
	}

	// ok
	public function desativar_crianca()
	{
		$idCrianca = $this->input->post("idCrianca");
		$idLider = $this->input->post("idLider");
		$idResponsavel = $this->input->post("idResponsavel");
		$motivo = $this->input->post("motivo");

		$excluir = $this->Criancas->excluir_crianca($idCrianca, $idLider, $idResponsavel, $motivo);

		$red = $this->input->post('red');
		$data = [];

		if ($excluir) {
			$this->FConsultas_model->mensagem('success', 'Sucesso!', ['Desativação Relizada com Sucesso!']);
			$funcao = $this->FConsultas_model->red($red, 2000, $data);
			echo $funcao;
		} else {
			$this->FConsultas_model->mensagem('danger', 'Erro!', ['Erro! Tente novamente!']);
			$funcao = $this->FConsultas_model->red($red, 2000, $data);
			echo $funcao;
		}
	}

	// ok
	public function ativar_crianca()
	{
		$id_responsavel = $this->input->post("idUsuario");

		$idLider = $this->input->post("idLider");
		$idCrianca = $this->input->post("opc");

		$reativar = $this->Criancas->ativar_crianca($id_responsavel, $idLider, $idCrianca);

		$red = $this->input->post('red');
		$data = [];

		if ($reativar) {
			$this->FConsultas_model->mensagem('success', 'Sucesso!', ['Ativação Relizada com Sucesso!']);
			$funcao = $this->FConsultas_model->red($red, 2000, $data);
			echo $funcao;
		} else {
			$this->FConsultas_model->mensagem('danger', 'Erro!', ['Erro! Tente novamente!']);
			$funcao = $this->FConsultas_model->red($red, 2000, $data);
			echo $funcao;
		}
	}

	// ok
	public function excluir_crianca_permanentemente()
	{
		$idLider = $this->input->post("idLider");
		$idUsuario = $this->input->post("idUsuario");

		$id_cri = $this->input->post("opc");

		$info_criancas = $this->Criancas->query([$id_cri], 'query_id_crianca');
		$nomeCrianca = $info_criancas['dados']['nome_crianca'];

		$this->Criancas->excluir_crianca_permanentemente($id_cri, $nomeCrianca, $idLider, $idUsuario);

		$red = $this->input->post('red');
		$data = [];

		$this->FConsultas_model->mensagem('success', 'Sucesso!', ['Atenção! Criança Excluida Permanentemente!']);
		$funcao = $this->FConsultas_model->red($red, 2000, $data);
		echo $funcao;

		/*if ($excluir == 'true') {
		} else {
			$this->FConsultas_model->mensagem('danger', 'Erro!', ['Erro! Tente novamente!']);
			$funcao = $this->FConsultas_model->red($red, 2000, $data);
			//echo $funcao;
		}*/
	}

	public function RelatoriosCriancas()
	{
		$idLider = $this->input->post("id");
		$opc = $this->input->post("opc");

		$data_hj = date('d-m-Y');
		$dados = $this->FConsultas_model->getNomeUserId($idLider);

		$nome = $dados['nome'];

		$pdf = new FPDF("L", "pt", "A4");
		$pdf->AddPage();
		$pdf->SetCreator('CAMP Brasil');

		$outraOpcao = explode(" ", $opc);

		// INFORMAÇÕES GERAIS
		if ($opc == "1") {
			$consultarPG = $this->PG->query([$idLider], 'query_lider_ativo_order_by_nome_pg_asc', 1);
			$pdf->Image('import/sistema/dist/img/capa_relatorio.jpg', 200, 100, 500, 300);

			$pdf->SetTitle($pdf->textoUTF8('Relatórios / Informações Gerais das Crianças / CAMP Brasil'));

			$pdf->SetFont('arial', 'B', 12);
			$pdf->SetXY(70, 30);
			$pdf->Cell(350, 25, $pdf->textoUTF8('Relatórios / Informações Gerais das Crianças / CAMP Brasil'), 0, 1, 'L');
			$pdf->Image(base_url('import/sistema/dist/img/icone.png'), 30, 13, -100);
			$pdf->Ln(10);
			$pdf->Cell(0, 5, "", "B", 1, 'C');
			$pdf->Ln(8);

			foreach ($consultarPG['dados'] as $key => $dadosPG) {
				$id_pg = $dadosPG['id_pg'];
				$id_modulo = $dadosPG['id_modulo'];
				$nome_pg = $dadosPG['nome_pg'];

				if ($consultarPG['row'] == 0) {
					$pdf->SetFont('arial', 'I', 12);
					$pdf->Cell(0, 50, $pdf->textoUTF8("Sem PG Cadastrado"), 0, 1, "C");
				} else {
					$consultaCriancas = $this->Criancas->query([$idLider, $dadosPG['id_pg'], 'asc'], 'query_id_lider_id_pg_geral_order_by_nome_crianca');

					if ($consultaCriancas) {
						if ($consultaCriancas['row'] == 0) {
							$pdf->SetFont('arial', 'I', 12);
							$pdf->Cell(0, 50, $pdf->textoUTF8("Sem Crianças Cadastradas"), 0, 1, "C");
						} else {

							$pdf->SetFont('arial', 'B', 12);
							$pdf->Cell(40, 20, $pdf->textoUTF8("Crianças do PG: $nome_pg"), 0, 1, 'L');
							$pdf->Ln(10);

							$pdf->setFillColor(120, 120, 90);
							$pdf->SetFont('arial', 'B', 11);

							$pdf->Cell(250, 20, $pdf->textoUTF8("Nome"), 1, 0, "C", 1);
							$pdf->Cell(150, 20, $pdf->textoUTF8("Responsável"), 1, 0, "C", 1);
							$pdf->Cell(80, 20, $pdf->textoUTF8("Telefone"), 1, 0, "C", 1);
							$pdf->Cell(100, 20, $pdf->textoUTF8("D. Nascimento"), 1, 0, "C", 1);
							$pdf->Cell(80, 20, $pdf->textoUTF8("É Cristão?"), 1, 0, "C", 1);
							$pdf->Cell(90, 20, $pdf->textoUTF8("Situação"), 1, 1, "C", 1);

							foreach ($consultaCriancas['dados'] as $key => $linha) {
								$nome_crianca = $pdf->textoUTF8($linha['nome_crianca']);
								$cristao = $linha['cristao'] == 1 ? "Sim" : "Não";
								$situacao = $linha['ativo'] == 1 ? "Ativo" : "Desativado";

								$pdf->SetFont('arial', '', 9);
								$pdf->setFillColor(255, 255, 255);

								$pdf->Cell(250, 20, $nome_crianca, 1, 0, "C", 1);
								$pdf->Cell(150, 20, $pdf->textoUTF8($linha['nome_responsavel']), 1, 0, "C", 1);
								$pdf->Cell(80, 20, $pdf->textoUTF8($linha['telefone_responsavel']), 1, 0, "C", 1);
								$pdf->Cell(100, 20, $linha['nascimento'], 1, 0, "C", 1);
								$pdf->Cell(80, 20, $pdf->textoUTF8($cristao), 1, 0, "C", 1);
								$pdf->Cell(90, 20, $pdf->textoUTF8($situacao), 1, 1, "C", 1);
							}
						}
					}

					$pontuacao = 0;

					$qtdPresenca = "0";
					$qtdVersiculo = "0";
					$qtdMisterio = "0";

					if ($consultaCriancas) {
						$consultarModuloId = $this->FConsultas_model->consultarModuloId($id_modulo);

						$qtdPresenca = $qtdPresenca + $consultarModuloId['n_licao'];
						$qtdVersiculo = $qtdVersiculo + $consultarModuloId['qtdVersiculo'];
						$qtdMisterio = $qtdMisterio + $consultarModuloId['qtdMisterios'];

						foreach ($consultaCriancas['dados'] as $key => $linha) {

							$consultarProgresso = $this->PG->consultar_progresso('query_id_pg_id_lider_id_crianca_id_modulo', [$id_pg, $idLider, $linha['id_crianca'], $id_modulo]);

							if ($consultarProgresso['row'] == 0) {
							} else {
								$pdf->Ln(30);
								$pdf->SetX(120);

								$pdf->setFillColor(120, 120, 90);
								$pdf->SetFont('arial', 'B', 11);
								$pdf->Cell(250, 20, $pdf->textoUTF8("Nome"), 1, 0, "C", 1);
								$pdf->Cell(80, 20, $pdf->textoUTF8("Presença"), 1, 0, "C", 1);
								$pdf->Cell(100, 20, $pdf->textoUTF8("Versículo"), 1, 0, "C", 1);
								$pdf->Cell(80, 20, $pdf->textoUTF8("Mistério"), 1, 0, "C", 1);
								$pdf->Cell(90, 20, $pdf->textoUTF8("Pontuação"), 1, 1, "C", 1);

								foreach ($consultarProgresso['dados'] as $key => $progresso) {
									$presenca = $progresso['presenca'];
									$versiculo = $progresso['versiculo_memorizado'];
									$misterio = $progresso['misterio_respondido'];
									$devocional = $progresso['devocional_respondido'];

									$pontuacao = ($presenca == 1 ? 5 : 0);
									$pontuacao = $pontuacao + ($versiculo == 1 ? 10 : 0);
									$pontuacao = $pontuacao + ($misterio == 1 ? 8 : 0);
									$pontuacao = $pontuacao + ($devocional   == 1 ? 5 : 0);

									$nome_crianca = $pdf->textoUTF8($linha['nome_crianca']);

									$presencaTotal = $presenca . "/" . $qtdPresenca;
									$misterioTotal = $misterio . "/" . $qtdMisterio;
									$versiculoTotal = $versiculo . "/" . $qtdVersiculo;
								}

								$pdf->SetFont('arial', '', 9);
								$pdf->setFillColor(255, 255, 255);
								$pdf->SetX(120);

								$pdf->Cell(250, 20, $nome_crianca, 1, 0, "C", 1);
								$pdf->Cell(80, 20, $presencaTotal, 1, 0, "C", 1);
								$pdf->Cell(100, 20, $versiculoTotal, 1, 0, "C", 1);
								$pdf->Cell(80, 20, $misterioTotal, 1, 0, "C", 1);
								$pdf->Cell(90, 20, $pontuacao, 1, 1, "C", 1);
							}
						}
					}
				}
			}
		}
		// CRIANÇAS ATIVAS
		else if ($opc == "2") {

			$consultarPG = $this->PG->query([$idLider], 'query_lider_ativo_order_by_nome_pg_asc', 1);

			$pdf->Image('import/sistema/dist/img/capa_relatorio.jpg', 200, 100, 500, 300);

			$pdf->SetTitle($pdf->textoUTF8('Relatórios / Informações das Crianças Ativas / CAMP Brasil'));

			$pdf->SetFont('arial', 'B', 12);
			$pdf->SetXY(70, 30);
			$pdf->Cell(0, 5, $pdf->textoUTF8("Relatórios / Informações das Crianças Ativas / CAMP Brasil"), 0, 1, 'L');
			$pdf->Image(base_url('import/sistema/dist/img/icone.png'), 30, 13, -100);
			$pdf->Ln(10);
			$pdf->Cell(0, 5, "", "B", 1, 'C');
			$pdf->Ln(8);

			if ($consultarPG['row'] == 0) {
				$pdf->SetFont('arial', 'I', 12);
				$pdf->Cell(0, 50, $pdf->textoUTF8("Sem PG Cadastrado"), 0, 1, "C");
			} else {
				foreach ($consultarPG['dados'] as $key => $dadosPG) {
					$id_pg = $dadosPG['id_pg'];
					$id_modulo = $dadosPG['id_modulo'];
					$nome_pg = $dadosPG['nome_pg'];

					$consultaCriancas = $this->Criancas->query([$idLider, $id_pg, 1, 'asc'], 'query_id_lider_id_pg_ativo_order_by_nome_crianca');

					if ($consultaCriancas) {
						if ($consultaCriancas['row'] == 0) {
							$pdf->SetFont('arial', 'I', 12);
							$pdf->Cell(0, 50, $pdf->textoUTF8("Sem Crianças Cadastradas"), 0, 1, "C");
						} else {
							$pdf->SetFont('arial', 'B', 12);
							$pdf->Cell(40, 20, $pdf->textoUTF8("Crianças do PG: $nome_pg"), 0, 1, 'L');
							$pdf->Ln(10);

							$pdf->setFillColor(120, 120, 90);
							$pdf->SetFont('arial', 'B', 11);
							$pdf->Cell(250, 20, $pdf->textoUTF8("Nome"), 1, 0, "C", 1);
							$pdf->Cell(150, 20, $pdf->textoUTF8("Responsável"), 1, 0, "C", 1);
							$pdf->Cell(80, 20, $pdf->textoUTF8("Telefone"), 1, 0, "C", 1);
							$pdf->Cell(100, 20, $pdf->textoUTF8("D. Nascimento"), 1, 0, "C", 1);
							$pdf->Cell(80, 20, $pdf->textoUTF8("É Cristão?"), 1, 0, "C", 1);
							$pdf->Cell(90, 20, $pdf->textoUTF8("Situação"), 1, 1, "C", 1);

							foreach ($consultaCriancas['dados'] as $key => $linha) {
								$nome_crianca = $pdf->textoUTF8($linha['nome_crianca']);
								$cristao = $linha['cristao'] == 1 ? "Sim" : "Não";
								$situacao = $linha['ativo'] == 1 ? "Ativo" : "Desativado";

								$pdf->SetFont('arial', '', 9);
								$pdf->setFillColor(255, 255, 255);

								$pdf->Cell(250, 20, $nome_crianca, 1, 0, "C", 1);
								$pdf->Cell(150, 20, $pdf->textoUTF8($linha['nome_responsavel']), 1, 0, "C", 1);
								$pdf->Cell(80, 20, $pdf->textoUTF8($linha['telefone_responsavel']), 1, 0, "C", 1);
								$pdf->Cell(100, 20, $linha['nascimento'], 1, 0, "C", 1);
								$pdf->Cell(80, 20, $pdf->textoUTF8($cristao), 1, 0, "C", 1);
								$pdf->Cell(90, 20, $pdf->textoUTF8($situacao), 1, 1, "C", 1);
							}
						}
					}

					if ($consultaCriancas) {

						$pontuacao = 0;

						$qtdPresenca = "0";
						$qtdVersiculo = "0";
						$qtdMisterio = "0";

						$consultarModuloId = $this->FConsultas_model->consultarModuloId($id_modulo);

						$qtdPresenca = $qtdPresenca + $consultarModuloId['n_licao'];
						$qtdVersiculo = $qtdVersiculo + $consultarModuloId['qtdVersiculo'];
						$qtdMisterio = $qtdMisterio + $consultarModuloId['qtdMisterios'];

						foreach ($consultaCriancas['dados'] as $key => $linha) {

							$consultarProgresso = $this->PG->consultar_progresso('query_id_pg_id_lider_id_crianca_id_modulo', [$id_pg, $idLider, $linha['id_crianca'], $id_modulo]);

							if ($consultarProgresso['row'] == 0) {
							} else {
								$pdf->Ln(30);
								$pdf->SetX(120);

								$pdf->setFillColor(120, 120, 90);
								$pdf->SetFont('arial', 'B', 11);
								$pdf->Cell(250, 20, $pdf->textoUTF8("Nome"), 1, 0, "C", 1);
								$pdf->Cell(80, 20, $pdf->textoUTF8("Presença"), 1, 0, "C", 1);
								$pdf->Cell(100, 20, $pdf->textoUTF8("Versículo"), 1, 0, "C", 1);
								$pdf->Cell(80, 20, $pdf->textoUTF8("Mistério"), 1, 0, "C", 1);
								$pdf->Cell(90, 20, $pdf->textoUTF8("Pontuação"), 1, 1, "C", 1);
								foreach ($consultarProgresso['dados'] as $key => $progresso) {
									$presenca = $progresso['presenca'];
									$versiculo = $progresso['versiculo_memorizado'];
									$misterio = $progresso['misterio_respondido'];
									$devocional = $progresso['devocional_respondido'];

									$pontuacao = ($presenca == 1 ? 5 : 0);
									$pontuacao = $pontuacao + ($versiculo == 1 ? 10 : 0);
									$pontuacao = $pontuacao + ($misterio == 1 ? 8 : 0);
									$pontuacao = $pontuacao + ($devocional   == 1 ? 5 : 0);

									$nome_crianca = $pdf->textoUTF8($linha['nome_crianca']);

									$presencaTotal = $presenca . "/" . $qtdPresenca;
									$misterioTotal = $misterio . "/" . $qtdMisterio;
									$versiculoTotal = $versiculo . "/" . $qtdVersiculo;
								}

								$pdf->SetFont('arial', '', 9);
								$pdf->setFillColor(255, 255, 255);
								$pdf->SetX(120);

								$pdf->Cell(250, 20, $nome_crianca, 1, 0, "C", 1);
								$pdf->Cell(80, 20, $presencaTotal, 1, 0, "C", 1);
								$pdf->Cell(100, 20, $versiculoTotal, 1, 0, "C", 1);
								$pdf->Cell(80, 20, $misterioTotal, 1, 0, "C", 1);
								$pdf->Cell(90, 20, $pontuacao, 1, 1, "C", 1);
							}
						}
					}
				}
			}
		}
		// CRIANÇAS DESATIVADAS
		else if ($opc == "3") {

			$consultarPG = $this->PG->query([$idLider], 'query_lider_ativo_order_by_nome_pg_asc', 1);

			$pdf->Image('import/sistema/dist/img/capa_relatorio.jpg', 200, 100, 500, 300);

			$pdf->SetTitle($pdf->textoUTF8('Relatórios / Informações das Crianças Desativadas / CAMP Brasil'));

			$pdf->SetFont('arial', 'B', 12);
			$pdf->SetXY(70, 30);
			$pdf->Cell(0, 5, $pdf->textoUTF8("Relatórios / Informações das Crianças Desativadas / CAMP Brasil"), 0, 1, 'L');
			$pdf->Image(base_url('import/sistema/dist/img/icone.png'), 30, 13, -100);
			$pdf->Ln(10);
			$pdf->Cell(0, 5, "", "B", 1, 'C');
			$pdf->Ln(8);

			if ($consultarPG['row'] == 0) {
				$pdf->SetFont('arial', 'I', 12);
				$pdf->Cell(0, 50, $pdf->textoUTF8("Sem PG Cadastrado"), 0, 1, "C");
			} else {
				foreach ($consultarPG['dados'] as $key => $dadosPG) {
					$id_pg = $dadosPG['id_pg'];
					$id_modulo = $dadosPG['id_modulo'];
					$nome_pg = $dadosPG['nome_pg'];

					$consultaCriancas = $this->Criancas->query([$idLider, $dadosPG['id_pg'], 0, 'asc'], 'query_id_lider_id_pg_ativo_order_by_nome_crianca');

					if ($consultaCriancas) {

						if ($consultaCriancas['row'] == 0) {
							$pdf->SetFont('arial', 'I', 12);
							$pdf->Cell(0, 50, $pdf->textoUTF8("Sem Crianças Desativadas!"), 0, 1, "C");
						} else {

							$pdf->SetFont('arial', 'B', 12);
							$pdf->Cell(40, 20, $pdf->textoUTF8("Crianças do PG: $nome_pg"), 0, 1, 'L');
							$pdf->Ln(10);

							$pdf->setFillColor(120, 120, 90);
							$pdf->SetFont('arial', 'B', 12);
							$pdf->Cell(250, 20, $pdf->textoUTF8("Nome"), 1, 0, "C", 1);
							$pdf->Cell(150, 20, $pdf->textoUTF8("Responsável"), 1, 0, "C", 1);
							$pdf->Cell(80, 20, $pdf->textoUTF8("Telefone"), 1, 0, "C", 1);
							$pdf->Cell(100, 20, $pdf->textoUTF8("D. Nascimento"), 1, 0, "C", 1);
							$pdf->Cell(80, 20, $pdf->textoUTF8("É Cristão?"), 1, 0, "C", 1);
							$pdf->Cell(90, 20, $pdf->textoUTF8("Situação"), 1, 1, "C", 1);

							foreach ($consultaCriancas['dados'] as $key => $linha) {
								$nome_crianca = $pdf->textoUTF8($linha['nome_crianca']);
								$cristao = $linha['cristao'] == 1 ? "Sim" : "Não";
								$situacao = $linha['ativo'] == 1 ? "Ativo" : "Desativado";

								$consultarMotivoExclusao = $this->Criancas->query_alcancados_criancas($idLider, $linha['id_crianca']);

								$pdf->SetFont('arial', '', 9);
								$pdf->setFillColor(255, 255, 255);

								$pdf->Cell(250, 20, $nome_crianca, 1, 0, "C", 1);
								$pdf->Cell(150, 20, $pdf->textoUTF8($linha['nome_responsavel']), 1, 0, "C", 1);
								$pdf->Cell(80, 20, $pdf->textoUTF8($linha['telefone_responsavel']), 1, 0, "C", 1);
								$pdf->Cell(100, 20, $linha['nascimento'], 1, 0, "C", 1);
								$pdf->Cell(80, 20, $pdf->textoUTF8($cristao), 1, 0, "C", 1);
								$pdf->Cell(90, 20, $pdf->textoUTF8($situacao), 1, 1, "C", 1);

								if ($consultarMotivoExclusao['row'] == 0) {
								} else {
									$motivo = $pdf->textoUTF8($consultarMotivoExclusao['dados']['motivo']);
									$pdf->Cell(690, 20, $motivo, 1, 0, "C", 1);
									$pdf->Cell(90, 20, $consultarMotivoExclusao['dados']['data_saida'], 1, 1, "C", 1);
								}
							}
						}
					}
				}
			}
		}
		// PG
		else if ($outraOpcao[0] == "pg") {
			$idPg = preg_replace("/[^0-9]/", "", $opc);

			$consultarPG = $this->PG->query([$idLider, $idPg], 'query_pg_id_lider_id_pg', '');

			$pdf->Image('import/sistema/dist/img/capa_relatorio.jpg', 200, 100, 500, 300);

			$pdf->SetTitle($pdf->textoUTF8('Relatórios / Informações das Crianças por PG / CAMP Brasil'));

			$pdf->SetFont('arial', 'B', 12);
			$pdf->SetXY(70, 30);
			$pdf->Cell(0, 5, $pdf->textoUTF8("Relatórios / Informações das Crianças por PG / CAMP Brasil"), 0, 1, 'L');
			$pdf->Image(base_url('import/sistema/dist/img/icone.png'), 30, 13, -100);
			$pdf->Ln(10);
			$pdf->Cell(0, 5, "", "B", 1, 'C');
			$pdf->Ln(8);

			if ($consultarPG['row'] == 0) {
				$pdf->SetFont('arial', 'I', 12);
				$pdf->Cell(0, 50, $pdf->textoUTF8("Sem PG Cadastrado"), 0, 1, "C");
			} else {

				$dadosPG = $consultarPG['dados'];

				$id_pg = $dadosPG['id_pg'];
				$id_modulo = $dadosPG['id_modulo'];
				$nome_pg = $dadosPG['nome_pg'];

				$consultaCriancas = $this->Criancas->query([$idLider, $id_pg, 1, 'asc'], 'query_id_lider_id_pg_ativo_order_by_nome_crianca');

				if ($consultaCriancas) {
					if ($consultaCriancas['row'] == 0) {
						$pdf->SetFont('arial', 'I', 12);
						$pdf->Cell(0, 50, $pdf->textoUTF8("Sem Crianças Cadastradas"), 0, 1, "C");
					} else {

						$pdf->SetFont('arial', 'B', 12);
						$pdf->Cell(40, 20, $pdf->textoUTF8("Crianças do PG: $nome_pg"), 0, 1, 'L');
						$pdf->Ln(10);

						$pdf->setFillColor(120, 120, 90);
						$pdf->SetFont('arial', 'B', 12);
						$pdf->Cell(250, 20, $pdf->textoUTF8("Nome"), 1, 0, "C", 1);
						$pdf->Cell(150, 20, $pdf->textoUTF8("Responsável"), 1, 0, "C", 1);
						$pdf->Cell(80, 20, $pdf->textoUTF8("Telefone"), 1, 0, "C", 1);
						$pdf->Cell(100, 20, $pdf->textoUTF8("D. Nascimento"), 1, 0, "C", 1);
						$pdf->Cell(80, 20, $pdf->textoUTF8("É Cristão?"), 1, 0, "C", 1);
						$pdf->Cell(90, 20, $pdf->textoUTF8("Situação"), 1, 1, "C", 1);

						foreach ($consultaCriancas['dados'] as $key => $linha) {
							$nome_crianca = $pdf->textoUTF8($linha['nome_crianca']);
							$cristao = $linha['cristao'] == 1 ? "Sim" : "Não";
							$situacao = $linha['ativo'] == 1 ? "Ativo" : "Desativado";

							$pdf->SetFont('arial', '', 9);
							$pdf->setFillColor(255, 255, 255);

							$pdf->Cell(250, 20, $nome_crianca, 1, 0, "C", 1);
							$pdf->Cell(150, 20, $pdf->textoUTF8($linha['nome_responsavel']), 1, 0, "C", 1);
							$pdf->Cell(80, 20, $pdf->textoUTF8($linha['telefone_responsavel']), 1, 0, "C", 1);
							$pdf->Cell(100, 20, $linha['nascimento'], 1, 0, "C", 1);
							$pdf->Cell(80, 20, $pdf->textoUTF8($cristao), 1, 0, "C", 1);
							$pdf->Cell(90, 20, $pdf->textoUTF8($situacao), 1, 1, "C", 1);
						}
					}
				}

				$pontuacao = 0;

				$qtdPresenca = "0";
				$qtdVersiculo = "0";
				$qtdMisterio = "0";

				if ($consultaCriancas) {
					$consultarModuloId = $this->FConsultas_model->consultarModuloId($id_modulo);

					$qtdPresenca = $qtdPresenca + $consultarModuloId['n_licao'];
					$qtdVersiculo = $qtdVersiculo + $consultarModuloId['qtdVersiculo'];
					$qtdMisterio = $qtdMisterio + $consultarModuloId['qtdMisterios'];
					foreach ($consultaCriancas['dados'] as $key => $linha) {

						$consultarProgresso = $this->PG->consultar_progresso('query_id_pg_id_lider_id_crianca_id_modulo', [$id_pg, $idLider, $linha['id_crianca'], $id_modulo]);

						if ($consultarProgresso['row'] == 0) {
						} else {

							$pdf->Ln(30);
							$pdf->SetX(120);

							$pdf->setFillColor(120, 120, 90);
							$pdf->SetFont('arial', 'B', 11);
							$pdf->Cell(250, 20, $pdf->textoUTF8("Nome"), 1, 0, "C", 1);
							$pdf->Cell(80, 20, $pdf->textoUTF8("Presença"), 1, 0, "C", 1);
							$pdf->Cell(100, 20, $pdf->textoUTF8("Versículo"), 1, 0, "C", 1);
							$pdf->Cell(80, 20, $pdf->textoUTF8("Mistério"), 1, 0, "C", 1);
							$pdf->Cell(90, 20, $pdf->textoUTF8("Pontuação"), 1, 1, "C", 1);

							foreach ($consultarProgresso['dados'] as $key => $progresso) {
								$presenca = $progresso['presenca'];
								$versiculo = $progresso['versiculo_memorizado'];
								$misterio = $progresso['misterio_respondido'];
								$devocional = $progresso['devocional_respondido'];

								$pontuacao = ($presenca == 1 ? 5 : 0);
								$pontuacao = $pontuacao + ($versiculo == 1 ? 10 : 0);
								$pontuacao = $pontuacao + ($misterio == 1 ? 8 : 0);
								$pontuacao = $pontuacao + ($devocional   == 1 ? 5 : 0);

								$nome_crianca = $pdf->textoUTF8($linha['nome_crianca']);

								$presencaTotal = $presenca . "/" . $qtdPresenca;
								$misterioTotal = $misterio . "/" . $qtdMisterio;
								$versiculoTotal = $versiculo . "/" . $qtdVersiculo;
							}

							$pdf->SetFont('arial', '', 9);
							$pdf->setFillColor(255, 255, 255);
							$pdf->SetX(120);

							$pdf->Cell(250, 20, $nome_crianca, 1, 0, "C", 1);
							$pdf->Cell(80, 20, $presencaTotal, 1, 0, "C", 1);
							$pdf->Cell(100, 20, $versiculoTotal, 1, 0, "C", 1);
							$pdf->Cell(80, 20, $misterioTotal, 1, 0, "C", 1);
							$pdf->Cell(90, 20, $pontuacao, 1, 1, "C", 1);
						}
					}
				}
			}
		}
		// Pontuação
		else if ($outraOpcao[0] == "pontuacao") {
			$idPg = preg_replace("/[^0-9]/", "", $opc);
			$consultarPG = $this->PG->query([$idLider, $idPg], 'query_pg_id_lider_id_pg', '');

			$pdf->Image('import/sistema/dist/img/capa_relatorio.jpg', 200, 100, 500, 300);

			$pdf->SetTitle($pdf->textoUTF8('Relatórios / Pontuação das Crianças / CAMP Brasil'));

			$pdf->SetFont('arial', 'B', 12);
			$pdf->SetXY(70, 30);
			$pdf->Cell(0, 5, $pdf->textoUTF8("Relatórios / Pontuação das Crianças / CAMP Brasil"), 0, 1, 'L');
			$pdf->Image(base_url('import/sistema/dist/img/icone.png'), 30, 13, -100);
			$pdf->Ln(10);
			$pdf->Cell(0, 5, "", "B", 1, 'C');
			$pdf->Ln(8);

			if ($consultarPG['row'] == 0) {
				$pdf->SetFont('arial', 'I', 12);
				$pdf->Cell(0, 50, $pdf->textoUTF8("Sem PG Cadastrado"), 0, 1, "C");
			} else {
				$dadosPG = $consultarPG['dados'];

				$id_pg = $dadosPG['id_pg'];
				$id_modulo = $dadosPG['id_modulo'];
				$nome_pg = $dadosPG['nome_pg'];

				$consultaCriancas = $this->Criancas->query([$idLider, $dadosPG['id_pg'], 'asc'], 'query_id_lider_id_pg_geral_order_by_nome_crianca');

				$pontuacao = 0;

				$qtdPresenca = "0";
				$qtdVersiculo = "0";
				$qtdMisterio = "0";

				if ($consultaCriancas) {
					if ($consultaCriancas['row'] == 0) {
						$pdf->SetFont('arial', 'I', 12);
						$pdf->Cell(0, 50, $pdf->textoUTF8("Sem Crianças Cadastradas"), 0, 1, "C");
					} else {

						$consultarModuloId = $this->FConsultas_model->consultarModuloId($id_modulo);

						$qtdPresenca = $qtdPresenca + $consultarModuloId['n_licao'];
						$qtdVersiculo = $qtdVersiculo + $consultarModuloId['qtdVersiculo'];
						$qtdMisterio = $qtdMisterio + $consultarModuloId['qtdMisterios'];
						foreach ($consultaCriancas['dados'] as $key => $linha) {

							$consultarProgresso = $this->PG->consultar_progresso('query_id_pg_id_lider_id_crianca_id_modulo', [$id_pg, $idLider, $linha['id_crianca'], $id_modulo]);

							if ($consultarProgresso['row'] == 0) {
								$pdf->SetFont('arial', 'I', 12);
								$pdf->Cell(0, 50, $pdf->textoUTF8("Sem Relatórios Preenchidos"), 0, 1, "C");
							} else {

								$pdf->Ln(30);
								$pdf->SetX(120);

								$pdf->setFillColor(120, 120, 90);
								$pdf->SetFont('arial', 'B', 11);
								$pdf->Cell(250, 20, $pdf->textoUTF8("Nome"), 1, 0, "C", 1);
								$pdf->Cell(80, 20, $pdf->textoUTF8("Presença"), 1, 0, "C", 1);
								$pdf->Cell(100, 20, $pdf->textoUTF8("Versículo"), 1, 0, "C", 1);
								$pdf->Cell(80, 20, $pdf->textoUTF8("Mistério"), 1, 0, "C", 1);
								$pdf->Cell(90, 20, $pdf->textoUTF8("Pontuação"), 1, 1, "C", 1);

								foreach ($consultarProgresso['dados'] as $key => $progresso) {
									$presenca = $progresso['presenca'];
									$versiculo = $progresso['versiculo_memorizado'];
									$misterio = $progresso['misterio_respondido'];
									$devocional = $progresso['devocional_respondido'];

									$pontuacao = ($presenca == 1 ? 5 : 0);
									$pontuacao = $pontuacao + ($versiculo == 1 ? 10 : 0);
									$pontuacao = $pontuacao + ($misterio == 1 ? 8 : 0);
									$pontuacao = $pontuacao + ($devocional   == 1 ? 5 : 0);

									$nome_crianca = $pdf->textoUTF8($linha['nome_crianca']);

									$presencaTotal = $presenca . "/" . $qtdPresenca;
									$misterioTotal = $misterio . "/" . $qtdMisterio;
									$versiculoTotal = $versiculo . "/" . $qtdVersiculo;
								}

								$pdf->SetFont('arial', '', 9);
								$pdf->setFillColor(255, 255, 255);
								$pdf->SetX(120);

								$pdf->Cell(250, 20, $nome_crianca, 1, 0, "C", 1);
								$pdf->Cell(80, 20, $presencaTotal, 1, 0, "C", 1);
								$pdf->Cell(100, 20, $versiculoTotal, 1, 0, "C", 1);
								$pdf->Cell(80, 20, $misterioTotal, 1, 0, "C", 1);
								$pdf->Cell(90, 20, $pontuacao, 1, 1, "C", 1);
							}
						}
					}
				}
			}
		}

		$nomeCertificado = "RELATÓRIO DE CRIANCAS CAMP BRASIL - " . $nome . " " . $data_hj . ".pdf";
		$pdf->Output('I', $pdf->textoUTF8($nomeCertificado));
	}

	// ok
	public function cadastro_pg_inicial_pular()
	{
		$idLider = $this->input->post("idLider");
		$nome = $this->input->post("nome");
		$nivel = $this->input->post("nivel");

		$this->PG->cadastro_pg_pular($idLider, $nome);

		$data = [
			"<input type='hidden' name='id_lider' value='$idLider'>",
			"<input type='hidden' name='nivel' value='$nivel'>",
			"<input type='hidden' name='x_ir' value='1'>",
		];
		$funcao = $this->FConsultas_model->red('../primeiro_acesso', 0, $data);
		echo $funcao;
	}

	// ok
	public function cadastro_pg_inicial()
	{
		$idLider = $this->input->post('idLider');
		$nome_pg = $this->input->post('nome_pg');
		$autorizacao = $this->input->post('autorizacao') == '' ? 0 : $this->input->post('autorizacao');
		$nivel = $this->input->post('nivel');

		$data_inicio_digitado = $this->input->post('data_inicio');
		$dataInicioSoNumero = preg_replace('/\D/', '', $data_inicio_digitado);
		$data_inicio = $dataInicioSoNumero[0] . $dataInicioSoNumero[1] . "/" . $dataInicioSoNumero[2] . $dataInicioSoNumero[3] . "/" . $dataInicioSoNumero[4] . $dataInicioSoNumero[5] . $dataInicioSoNumero[6] . $dataInicioSoNumero[7];


		$this->PG->cadastro_pg($idLider, $nome_pg, $data_inicio, $autorizacao);

		$data = [
			"<input type='hidden' name='id_lider' value='$idLider'>",
			"<input type='hidden' name='nivel' value='$nivel'>",
			"<input type='hidden' name='x_ir' value='1'>",
		];
		$funcao = $this->FConsultas_model->red('../../primeiro_acesso', 0, $data);
		echo $funcao;
	}

	// ok
	public function cadastro_pg()
	{
		$idLider = $this->input->post('idLider');
		$nome_pg = $this->input->post('nome_pg');
		$data_inicio = $this->input->post('data_inicio');

		$datadeiniciosonumero = preg_replace('/\D/', '', $data_inicio);
		$total_numeros_data_inicio = strlen(string: $datadeiniciosonumero);

		$autorizacao = $this->input->post('autorizacao') == '' ? 0 : $this->input->post('autorizacao');

		$consultarPg = $this->PG->check_cadastro_pg('check_id_lider_nome', [$idLider, $nome_pg]);

		$red = $this->input->post('red');
		$data = [];

		if ($total_numeros_data_inicio == 8) {
			if ($consultarPg) {
				$cadastro = $this->PG->cadastro_pg($idLider, $nome_pg, $data_inicio, $autorizacao);

				if ($cadastro) {
					$this->FConsultas_model->mensagem('success', 'Sucesso!', ['Cadastro Realizado com Sucesso!']);
					$funcao = $this->FConsultas_model->red($red, 2000, $data);
					echo $funcao;
				} else {
					// ERRO
					$this->FConsultas_model->mensagem('danger', 'Erro!', ['Tente novamente!']);
					$funcao = $this->FConsultas_model->red($red, 2000, $data);
					echo $funcao;
				}
			} else {
				// PG JÁ CADASTRADO
				$this->FConsultas_model->mensagem('danger', 'Erro!', ['PG já Cadastrado!']);
				$funcao = $this->FConsultas_model->red($red, 2000, $data);
				echo $funcao;
			}
		} else {
			// DATA INVÁLIDA
			$this->FConsultas_model->mensagem('danger', 'Erro!', ['Data de Nascimento Inválido!']);
			$funcao = $this->FConsultas_model->red($red, 2000, $data);
			echo $funcao;
		}
	}

	// ok
	public function editar_pg()
	{
		$idLider = $this->input->post('idLider');
		$idPg = $this->input->post('idPg');
		$nome_pg = $this->input->post('nome_pg');
		$fotoOriginal = $this->input->post('fotoOriginal');
		$autorizacao = $this->input->post('autorizacao');

		$red = $this->input->post('red');
		$data = [];

		if ($idPg == '' || $nome_pg == '') {
			$this->FConsultas_model->mensagem('danger', 'Erro!', ['Dados Vazios! Tente novamente!']);
			$funcao = $this->FConsultas_model->red($red, 2000, $data);
			echo $funcao;
		} else {
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$config['upload_path'] = 'import/sistema/fotoPG/';
			$this->load->library('upload', $config);

			$imagemPG = $_FILES['imagemPG'];

			if ($imagemPG['name'] == '' || $imagemPG['size'] == 0) {
				$nomeImagem = $fotoOriginal;
			} else {
				$upp1 = $this->upload->do_upload('imagemPG');
				if ($upp1) {
					$nomeImagem = 'import/sistema/fotoPG/' . $this->upload->data('file_name');
				} else {
					$erro1 = $this->upload->display_errors();
					$this->FConsultas_model->mensagem('danger', 'Erro!', ["Erro no upload da imagem do PG $erro1"]);
					$funcao = $this->FConsultas_model->red($red, 2000, $data);
					echo $funcao;
				}
			}
			$editar = $this->PG->editar_pg($idLider, $idPg, $nome_pg, $nomeImagem, $autorizacao);
			if ($editar) {
				$this->FConsultas_model->mensagem('success', 'Sucesso', ['Edição Realizada com Sucesso!']);
				$funcao = $this->FConsultas_model->red($red, 2000, $data);
				echo $funcao;
			} else {
				$this->FConsultas_model->mensagem('danger', 'Erro!', ["Tente novamente!"]);
				$funcao = $this->FConsultas_model->red($red, 2000, $data);
				echo $funcao;
			}
		}
	}

	// ok
	public function desativar_pg()
	{
		$idPg = $this->input->post("idPg");
		$idLider = $this->input->post("idLider");
		$idResponsavel = $this->input->post("idResponsavel");
		$motivo = $this->input->post("motivo");

		$red = $this->input->post('red');
		$data = [];

		$excluir = $this->PG->excluir_pg($idPg, $idLider, $idResponsavel, $motivo);

		if ($excluir) {
			$this->FConsultas_model->mensagem('success', 'Sucesso', ['PG desativado com Sucesso!']);
			$funcao = $this->FConsultas_model->red($red, 2000, $data);
			echo $funcao;
		} else {
			$this->FConsultas_model->mensagem('danger', 'Erro!', ["Tente novamente!"]);
			$funcao = $this->FConsultas_model->red($red, 2000, $data);
			echo $funcao;
		}
	}

	// ok
	public function ativar_pg()
	{
		$idUsuario = $this->input->post("idUsuario");
		$id_pg = $this->input->post("id_pg");

		$reativar = $this->PG->reativar_pg($id_pg, id_responsavel: $idUsuario);

		$red = $this->input->post('red');
		$data = [];

		if ($reativar) {
			$this->FConsultas_model->mensagem('success', 'Sucesso!', ["PG Reativado com Sucesso!"]);
			$funcao = $this->FConsultas_model->red($red, 2000, $data);
			echo $funcao;
		} else {
			$this->FConsultas_model->mensagem('danger', 'Erro!', ["Tente novamente!"]);
			$funcao = $this->FConsultas_model->red($red, 2000, $data);
			echo $funcao;
		}
	}

	// ok
	public function excluir_pg_permanentemente()
	{
		$idLider = $this->input->post("idLider");
		$idUsuario = $this->input->post("idUsuario");
		$id_pg = $this->input->post("id_pg");

		$excluir = $this->PG->excluir_pg_permanentemente($id_pg, $idLider, $idUsuario);

		$red = $this->input->post('red');
		$data = [];

		if ($excluir) {
			$this->FConsultas_model->mensagem('success', 'Sucesso!', ["PG Excluido Permanentemente!"]);
		} else {
			$this->FConsultas_model->mensagem('danger', 'Erro!', ["Tente novamente!"]);
		}
		$funcao = $this->FConsultas_model->red($red, 2000, $data);
		echo $funcao;
	}

	// ok
	public function salvar_relatorio()
	{
		$id_lider = $this->input->post('id_lider');
		$id_pg = $this->input->post('id_pg');
		$qtd_crianca = $this->input->post('qtd_crianca');
		$id_crianca = $this->input->post('id_crianca');
		$presenca = $this->input->post('presenca');
		$versiculo = $this->input->post('versiculo');
		$misterio = $this->input->post('misterio');
		$devocional = $this->input->post('devocional');
		$modulo = $this->input->post('id_modulo');
		$ano = $this->input->post('ano');
		$licao = $this->input->post('licao');
		$data_aula = $this->input->post('data_aula');

		$total = count($id_crianca) ?? 0;

		if ($licao == 1 || $licao == 3 || $licao == 5 || $licao == 7 || $licao == 9) {
			$isImpar = true;
		} else {
			$isImpar = false;
		}

		if ($total == 0) {
		} else {
			for ($i = 0; $i < $total; $i++) {
				$id_pg2 = $id_pg;
				$qtd_crianca2 = $qtd_crianca;
				$id_crianca2 = $id_crianca[$i];
				$presenca2 = $presenca[$i];
				$versiculo2 = $isImpar ? 0 : $versiculo[$i];
				$misterio2 = $isImpar ? 0 : $misterio[$i];
				$devocional2 = $isImpar ? 0 : $devocional[$i];
				$ano2 = $ano;
				$modulo2 = $modulo;
				$licao2 = $licao;
				$data_aula2 = $data_aula;

				$preenchimento = $this->PG->relatorio_encontro($id_lider, $id_pg2, $qtd_crianca2, $id_crianca2, $versiculo2, $presenca2, $misterio2, $devocional2, $ano2, $modulo2, $licao2, $data_aula2);
			}
		}

		$red = $this->input->post('red');
		$routa = $this->input->post('routa');

		$data = [
			"<input type='hidden' name='id_pg' value='$id_pg'>",
			"<input type='hidden' name='id_lider' value='$id_lider'>",
			"<input type='hidden' name='ano' value='$ano'>",
			"<input type='hidden' name='routa' value='$routa'>",
		];

		if ($preenchimento == 'false') {
			$this->FConsultas_model->mensagem('danget', 'Error!', ["Aconteceu algum problema, tente novamente!"]);
			$funcao = $this->FConsultas_model->red($red, 2000, $data);
			echo $funcao;
		} else {
			$this->FConsultas_model->mensagem('success', 'Sucesso!', ["Relatório Preenchido com Sucesso!"]);
			$funcao = $this->FConsultas_model->red($red, 2000, $data);
			echo $funcao;
		}

		/*$routa = "";

		$nivel_routa = $this->input->post("nivel_routa") ?? 'lider';
		$id_coord = $this->input->post("id_coord");

		if ($red == 'pg') {
			$data = [
				"<input type='hidden' name='id_pg' value='$id_pg'>",
				"<input type='hidden' name='id_lider' value='$id_lider'>",
				"<input type='hidden' name='ano' value='$ano'>",
				"<input type='hidden' name='routa' value='$red'>",
			];
			$routa = "pg/licoes";
		} else if ($red == 'lideres/detalhes') {
			$data = [
				"<input type='hidden' name='id_coord' value='$id_coord'>",
				"<input type='hidden' name='nivel_routa' value='$nivel_routa'>"
			];
			$routa = "lideres/detalhes/$id_lider";
		} else {
			$data = [
				"<input type='hidden' name='id_pg' value='$id_pg'>",
				"<input type='hidden' name='id_lider' value='$id_lider'>",
				"<input type='hidden' name='ano' value='$ano'>",
				"<input type='hidden' name='routa' value='$red'>",
			];
			$routa = "pg/licoes";
		}*/
	}

	// ok
	public function edicao_relatorio()
	{
		$id_lider = $this->input->post('id_lider');
		$id_relatorio = $this->input->post('id_relatorio');
		$id_pg = $this->input->post('id_pg');
		$qtd_crianca = $this->input->post('qtd_crianca');
		$id_crianca = $this->input->post('id_crianca');
		$presenca = $this->input->post('presenca');
		$versiculo = $this->input->post('versiculo');
		$misterio = $this->input->post('misterio');
		$devocional = $this->input->post('devocional');
		$modulo = $this->input->post('id_modulo');
		$ano = $this->input->post('ano');
		$licao = $this->input->post('licao');
		$data_aula = $this->input->post('data_aula');

		$total = count($id_crianca) ?? 0;

		if ($licao == 1 || $licao == 3 || $licao == 5 || $licao == 7 || $licao == 9) {
			$isImpar = true;
		} else {
			$isImpar = false;
		}

		for ($i = 0; $i < $total; $i++) {
			$id_relatorio2 = $id_relatorio[$i];
			$id_pg2 = $id_pg;
			$qtd_crianca2 = $qtd_crianca;
			$id_crianca2 = $id_crianca[$i];
			$presenca2 = $presenca[$i] == '' ? 0 : $presenca[$i];
			$versiculo2 = $isImpar ? 0 : $versiculo[$i];
			$misterio2 = $isImpar ? 0 : $misterio[$i];
			$devocional2 = $devocional[$i] == '' ? 0 : $devocional[$i];
			$ano2 = $ano;
			$modulo2 = $modulo;
			$licao2 = $licao;
			$data_aula2 = $data_aula;

			if ($id_relatorio2 == '') {
				$preenchimento = $this->PG->relatorio_encontro_edicao($id_lider, $id_pg2, $id_crianca2, $versiculo2, $presenca2, $misterio2, $devocional2, $ano2, $modulo2, $licao2, $data_aula2);
			} else {
				$preenchimento = $this->PG->editar_relatorio_encontro($id_relatorio2, $versiculo2, $presenca2, $misterio2, $devocional2);
			}
		}

		$red = $this->input->post('red');
		$routa = $this->input->post('routa');

		$data = [
			"<input type='hidden' name='id_pg' value='$id_pg'>",
			"<input type='hidden' name='id_lider' value='$id_lider'>",
			"<input type='hidden' name='ano' value='$ano'>",
			"<input type='hidden' name='routa' value='$routa'>",
		];

		if ($preenchimento == 'false') {
			$this->FConsultas_model->mensagem('danget', 'Error!', ["Aconteceu algum problema, tente novamente!"]);
			$funcao = $this->FConsultas_model->red($red, 2000, $data);
			echo $funcao;
		} else {
			$this->FConsultas_model->mensagem('success', 'Sucesso!', ["Relatório Editado com Sucesso!"]);
			$funcao = $this->FConsultas_model->red($red, 2000, $data);
			echo $funcao;
		}

		/*$red = $this->input->post('red') ?? 'pg';
		$routa = "";

		$nivel_routa = $this->input->post("nivel_routa") ?? 'lider';
		$id_coord = $this->input->post("id_coord");

		if ($red == 'pg') {
			$data = [
				"<input type='hidden' name='id_pg' value='$id_pg'>",
				"<input type='hidden' name='id_lider' value='$id_lider'>",
				"<input type='hidden' name='ano' value='$ano'>",
				"<input type='hidden' name='routa' value='$red'>",
			];
			$routa = "pg/licoes";
		} else if ($red == 'lideres/detalhes') {
			$data = [
				"<input type='hidden' name='id_coord' value='$id_coord'>",
				"<input type='hidden' name='nivel_routa' value='$nivel_routa'>"
			];
			$routa = "lideres/detalhes/$id_lider";
		} else {
			$data = [
				"<input type='hidden' name='id_pg' value='$id_pg'>",
				"<input type='hidden' name='id_lider' value='$id_lider'>",
				"<input type='hidden' name='ano' value='$ano'>",
				"<input type='hidden' name='routa' value='$red'>",
			];
			$routa = "pg/licoes";
		}

		$this->FConsultas_model->mensagem('success', 'Sucesso!', ["Relatório Preenchido com Sucesso!"]);
		$funcao = $this->FConsultas_model->red("../../$routa", 2000, $data);
		echo $funcao;*/
	}

	// ok
	public function enviando_alerta_troca_de_cs()
	{
		$id_usuario = $this->input->post('id_usuario');
		$id_lider = $this->input->post('id_lider');
		$id_troca_1 = $this->input->post('id_troca_1');
		$id_troca_2 = $this->input->post('id_troca_2');

		$str = explode(" ", $id_troca_1);

		if ($str[0] == 'coord') {
			$nivel = "Coordenador (a)";
		} else if ($str[0] == 'super') {
			$nivel = "Supervisor";
		}

		$dados = $this->FConsultas_model->getNomeUserId($str[1]);
		$nome = $dados['nome'];

		$dados_novos = $this->FConsultas_model->getNomeUserId($id_troca_2);
		$nome_novo = $dados_novos['nome'];

		$dados_lider = $this->FConsultas_model->getNomeUserId($id_lider);
		$nome_lider = $dados_lider['nome'];

		$motivo = " pediu a solicitação de troca do $nivel: $nome (id: $str[1]) do líder $nome_lider (id: $id_lider) para $nome_novo (id: $id_troca_2)";
		$acao = "SOLICITACAO_TROCA_CS";

		$this->FAlerta_model->alerta_controle($id_usuario, $id_usuario, $motivo, $acao);

		$red = $this->input->post('red');
		$data = [];

		$this->FConsultas_model->mensagem('success', 'Solicitação Enviada com Sucesso', ['Aguarde, em breve entraremos em contato!']);

		$funcao = $this->FConsultas_model->red("$red", 3000, $data);
		echo $funcao;
	}

	// ok
	public function trocar_de_funcao()
	{
		$id_usuario = $this->input->post('id_usuario');
		$id_change = $this->input->post('id_change');

		$dados = $this->FConsultas_model->getNomeUserId($id_usuario);
		$nome_usuario = $dados['nome'];
		$nome = $this->FConsultas_model->getNomeUserId($id_change)['nome'];

		$funcao_atiga = $this->input->post('funcao_atiga');
		$funcao_nova = $this->input->post('funcao_nova');

		$ids = $this->input->post('ids_coordenadores');

		$motivo = "";
		$acao = "";

		if ($funcao_atiga == 'coordenador' && $funcao_nova == 'supervisor') {
			$motivo = "O $nome_usuario pediu a solicitação de troca de função do coordenador $nome (id: $id_change) para supervisor. Coordenadores que passarão para essa supervisão: $ids";
			$acao = "SOLICITACAO_TROCA_COORDENADOR_TO_SUPERVISOR";
		} else if ($funcao_atiga == 'lider' && $funcao_nova == 'coordenador') {
			$motivo = "O $nome_usuario pediu a solicitação de troca de função do líder $nome (id: $id_change) para coordenador. Líderes que passarão para essa coordenação: $ids";
			$acao = "SOLICITACAO_TROCA_LIDER_TO_COORDENADOR";
		} else if ($funcao_atiga == 'coordenador' && $funcao_nova == 'lider') {
			$motivo = "O $nome_usuario pediu a solicitação de troca de função do coordenador $nome (id: $id_change) para líder. Líderes que passarão para essa coordenação: $ids";
			$acao = "SOLICITACAO_TROCA_COORDENADOR_TO_LIDER";
		}

		$this->FAlerta_model->alerta_controle($id_usuario, $id_usuario, $motivo, $acao);

		$red = $this->input->post('red');

		$this->FConsultas_model->mensagem('success', 'Solicitação Enviada com Sucesso', ['Aguarde, em breve entraremos em contato!']);

		$funcao = $this->FConsultas_model->red("$red", 3000, []);
		echo $funcao;
	}

	// ok
	public function trocar_liderenca()
	{
		$id_usuario = $this->input->post("id_usuario");
		$id_lider = $this->input->post("id_lider");
		$id_lider_novo = $this->input->post("id_lider_novo");
		$id_pg = $this->input->post("id_pg");

		$this->_trocar_lideranca($id_usuario, $id_lider, $id_lider_novo, $id_pg);

		$red = $this->input->post("red");

		$this->FConsultas_model->mensagem('success', 'Sucesso!', ["Troca efetuada com sucesso!"]);
		$funcao = $this->FConsultas_model->red($red, 2000, []);
		echo $funcao;
	}

	// ok
	public function _trocar_lideranca($id_usuario, $id_lider, $id_lider_novo, $id_pg)
	{
		// trocar PG
		$this->PG->trocar_lideranca_pg($id_pg, $id_lider, $id_lider_novo);
		// trocar relatórios
		$this->PG->editar_lideranca_relatorio($id_pg, $id_lider,  $id_lider_novo);
		// trocar crianças
		$this->Criancas->editar_liderenca_crianca($id_pg, $id_lider, $id_lider_novo);

		$motivo = "trocou o PG, antigo liderança ($id_lider) para novo líder ($id_lider_novo)";

		$this->FAlerta_model->alerta_controle($id_usuario, 6003, $motivo, "TROCAR_LIDERANCA_DE_PG");
	}

	// ok
	public function gerar_pontuacao($id_lider, $id_pg)
	{
		$dados_pg = $this->PG->query([$id_lider, $id_pg], 'query_id_lider_id_pg_ativo', 1);

		$ano = $dados_pg['id'];

		$modulos = $this->FConsultas_model->consultarModuloAno($ano);

		$somaTotalPresencaModulo = 0;
		$somaTotalVersiculoModulo = 0;
		$somaTotalMisterioModulo = 0;

		$somaTotalPresencaPG = 0;
		$somaTotalVersiculoPG = 0;
		$somaTotalMisterioPG = 0;
		$somaTotalPontuacaoPG = 0;

		if ($modulos) {

			$consultaCriancas = $this->Criancas->query([$id_lider, $id_pg, 1, 'asc'], 'query_id_lider_id_pg_ativo_order_by_nome_crianca');

			$qtdPresenca = 0;
			$qtdVersiculo = 0;
			$qtdMisterio = 0;

			$id_modulos  = [];

			foreach ($modulos as $key => $m) {
				$id_modulos[] = $m['id_modulo'];
			}

			$i = 0;
			foreach ($modulos as $key => $m) {

				$total_aulas = $m['n_licao'];

				$consultarModuloId = $this->FConsultas_model->consultarModuloId($m['id_modulo']);
				$qtdPresenca = $consultarModuloId['n_licao'];
				$qtdVersiculo =  $consultarModuloId['qtdVersiculo'];
				$qtdMisterio =  $consultarModuloId['qtdMisterios'];

				$qtdPresenca = $qtdPresenca * $consultaCriancas['row'];
				$qtdVersiculo = $qtdVersiculo * $consultaCriancas['row'];
				$qtdMisterio = $qtdMisterio * $consultaCriancas['row'];

				$somaTotalPresencaModulo = $somaTotalPresencaModulo + $qtdPresenca;
				$somaTotalVersiculoModulo = $somaTotalVersiculoModulo + $qtdVersiculo;
				$somaTotalMisterioModulo = $somaTotalMisterioModulo + $qtdMisterio;

				$pontuacao = 0;
				$presencaTotal = 0;
				$versiculoTotal = 0;
				$misterioTotal = 0;

				if ($consultaCriancas['row'] == 0) {
				} else {
					foreach ($consultaCriancas['dados'] as $key => $linha) {
						$consultarProgresso1 = $this->PG->consultar_progresso([$id_pg, $id_lider, $linha['id_crianca'], $id_modulos[0]], 'query_id_pg_id_lider_id_crianca_id_modulo');
						$consultarProgresso2 = $this->PG->consultar_progresso([$id_pg, $id_lider, $linha['id_crianca'], $id_modulos[1]], 'query_id_pg_id_lider_id_crianca_id_modulo');
						$consultarProgresso3 = $this->PG->consultar_progresso([$id_pg, $id_lider, $linha['id_crianca'], $id_modulos[2]], 'query_id_pg_id_lider_id_crianca_id_modulo');
						$consultarProgresso4 = $this->PG->consultar_progresso([$id_pg, $id_lider, $linha['id_crianca'], $id_modulos[3]], 'query_id_pg_id_lider_id_crianca_id_modulo');
						$consultarProgresso5 = $this->PG->consultar_progresso([$id_pg, $id_lider, $linha['id_crianca'], $id_modulos[4]], 'query_id_pg_id_lider_id_crianca_id_modulo');
						//$consultarProgresso = array_merge($consultarProgresso1['dados'], $consultarProgresso2['dados'], $consultarProgresso3['dados'], $consultarProgresso4['dados'], $consultarProgresso5['dados'],);
					}
				}
				//$totalRelatorio = count($consultarProgresso);

				$query = [];

				if ($consultaCriancas['row'] == 0) {
				} else {
					if ($i == 0) {
						if ($consultarProgresso1['row'] == 0) {
							$presencaTotal = 0;
							$versiculoTotal = 0;
							$misterioTotal = 0;
							$pontuacao = 0;
						} else {
							$query = $consultarProgresso1['dados'];
							foreach ($query as $key => $value) {
								$presenca = $value['presenca'];
								$versiculo = $value['versiculo_memorizado'];
								$misterio = $value['misterio_respondido'];
								$devocional = $value['devocional_respondido'];

								$presencaTotal = $presencaTotal + $presenca;
								$versiculoTotal = $versiculoTotal + $versiculo;
								$misterioTotal = $misterioTotal + $misterio;

								$pontuacao = $pontuacao + ($presenca == 1 ? 5 : 0);
								$pontuacao = $pontuacao + ($versiculo == 1 ? 10 : 0);
								$pontuacao = $pontuacao + ($misterio == 1 ? 8 : 0);
								$pontuacao = $pontuacao + ($devocional   == 1 ? 5 : 0);
							}
							$somaTotalPresencaPG = $somaTotalPresencaPG + $presencaTotal;
							$somaTotalVersiculoPG = $somaTotalVersiculoPG + $versiculoTotal;
							$somaTotalMisterioPG = $somaTotalMisterioPG + $misterioTotal;
							$somaTotalPontuacaoPG = $somaTotalPontuacaoPG + $pontuacao;
						}
					} else  if ($i == 1) {
						if ($consultarProgresso2['row'] == 0) {

							$presencaTotal = 0;
							$versiculoTotal = 0;
							$misterioTotal = 0;

							$pontuacao = 0;
						} else {
							$query = $consultarProgresso2['dados'];
							foreach ($query as $key => $value) {

								$presenca = $value['presenca'];
								$versiculo = $value['versiculo_memorizado'];
								$misterio = $value['misterio_respondido'];
								$devocional = $value['devocional_respondido'];

								$presencaTotal = $presencaTotal + $presenca;
								$versiculoTotal = $versiculoTotal + $versiculo;
								$misterioTotal = $misterioTotal + $misterio;

								$pontuacao = $pontuacao + ($presenca == 1 ? 5 : 0);
								$pontuacao = $pontuacao + ($versiculo == 1 ? 10 : 0);
								$pontuacao = $pontuacao + ($misterio == 1 ? 8 : 0);
								$pontuacao = $pontuacao + ($devocional   == 1 ? 5 : 0);
							}
							$somaTotalPresencaPG = $somaTotalPresencaPG + $presencaTotal;
							$somaTotalVersiculoPG = $somaTotalVersiculoPG + $versiculoTotal;
							$somaTotalMisterioPG = $somaTotalMisterioPG + $misterioTotal;
							$somaTotalPontuacaoPG = $somaTotalPontuacaoPG + $pontuacao;
						}
					} else  if ($i == 2) {
						if ($consultarProgresso3['row'] == 0) {

							$presencaTotal = 0;
							$versiculoTotal = 0;
							$misterioTotal = 0;

							$pontuacao = 0;
						} else {
							$query = $consultarProgresso3['dados'];
							foreach ($query as $key => $value) {
								$presenca = $value['presenca'];
								$versiculo = $value['versiculo_memorizado'];
								$misterio = $value['misterio_respondido'];
								$devocional = $value['devocional_respondido'];

								$presencaTotal = $presencaTotal + $presenca;
								$versiculoTotal = $versiculoTotal + $versiculo;
								$misterioTotal = $misterioTotal + $misterio;

								$pontuacao = $pontuacao + ($presenca == 1 ? 5 : 0);
								$pontuacao = $pontuacao + ($versiculo == 1 ? 10 : 0);
								$pontuacao = $pontuacao + ($misterio == 1 ? 8 : 0);
								$pontuacao = $pontuacao + ($devocional   == 1 ? 5 : 0);
							}
							$somaTotalPresencaPG = $somaTotalPresencaPG + $presencaTotal;
							$somaTotalVersiculoPG = $somaTotalVersiculoPG + $versiculoTotal;
							$somaTotalMisterioPG = $somaTotalMisterioPG + $misterioTotal;
							$somaTotalPontuacaoPG = $somaTotalPontuacaoPG + $pontuacao;
						}
					} else  if ($i == 3) {
						if ($consultarProgresso4['row'] == 0) {

							$presencaTotal = 0;
							$versiculoTotal = 0;
							$misterioTotal = 0;

							$pontuacao = 0;
						} else {
							$query = $consultarProgresso4['dados'];
							foreach ($query as $key => $value) {
								$presenca = $value['presenca'];
								$versiculo = $value['versiculo_memorizado'];
								$misterio = $value['misterio_respondido'];
								$devocional = $value['devocional_respondido'];

								$presencaTotal = $presencaTotal + $presenca;
								$versiculoTotal = $versiculoTotal + $versiculo;
								$misterioTotal = $misterioTotal + $misterio;

								$pontuacao = $pontuacao + ($presenca == 1 ? 5 : 0);
								$pontuacao = $pontuacao + ($versiculo == 1 ? 10 : 0);
								$pontuacao = $pontuacao + ($misterio == 1 ? 8 : 0);
								$pontuacao = $pontuacao + ($devocional   == 1 ? 5 : 0);
							}
							$somaTotalPresencaPG = $somaTotalPresencaPG + $presencaTotal;
							$somaTotalVersiculoPG = $somaTotalVersiculoPG + $versiculoTotal;
							$somaTotalMisterioPG = $somaTotalMisterioPG + $misterioTotal;
							$somaTotalPontuacaoPG = $somaTotalPontuacaoPG + $pontuacao;
						}
					} else  if ($i == 4) {
						if ($consultarProgresso5['row'] == 0) {

							$presencaTotal = 0;
							$versiculoTotal = 0;
							$misterioTotal = 0;

							$pontuacao = 0;
						} else {
							$query = $consultarProgresso5['dados'];
							foreach ($query as $key => $value) {
								$presenca = $value['presenca'];
								$versiculo = $value['versiculo_memorizado'];
								$misterio = $value['misterio_respondido'];
								$devocional = $value['devocional_respondido'];

								$presencaTotal = $presencaTotal + $presenca;
								$versiculoTotal = $versiculoTotal + $versiculo;
								$misterioTotal = $misterioTotal + $misterio;

								$pontuacao = $pontuacao + ($presenca == 1 ? 5 : 0);
								$pontuacao = $pontuacao + ($versiculo == 1 ? 10 : 0);
								$pontuacao = $pontuacao + ($misterio == 1 ? 8 : 0);
								$pontuacao = $pontuacao + ($devocional   == 1 ? 5 : 0);
							}
							$somaTotalPresencaPG = $somaTotalPresencaPG + $presencaTotal;
							$somaTotalVersiculoPG = $somaTotalVersiculoPG + $versiculoTotal;
							$somaTotalMisterioPG = $somaTotalMisterioPG + $misterioTotal;
							$somaTotalPontuacaoPG = $somaTotalPontuacaoPG + $pontuacao;
						}
					}
				}
			}
		}
	}

	// coordenador
	// cadastro coordenador via link
	public function cadastro_coordenador_via_link()
	{
		$nome = $this->input->post('nome');
		$cpf = $this->input->post('cpf');
		$email = $this->input->post('email');
		$telefone_digitado = $this->input->post('telefone');
		$pais = $this->input->post('pais');
		$estado1 = $this->input->post('estados');
		$cidade1 = $this->input->post('cidades');
		$estado2 = $this->input->post('estados2');
		$cidade2 = $this->input->post('cidades2');
		$nascimento = $this->input->post('nascimento');

		$senha = $this->input->post('senha');

		$is_br = $pais == 'br' || '' ? true : false;

		$telefone = $this->FConsultas_model->formatar_telefone($telefone_digitado, $is_br);

		$nome_digitado_pais = $this->input->post('nome_pais');

		$nome_pais = "";
		$estado = "";
		$cidade = "";

		if ($pais == "br") {
			$nome_pais = "Brasil";
		} else {
			$nome_pais = $nome_digitado_pais;
		}

		if ($estado1 == "" and $cidade1 == "") {
			$estado = $estado2;
			$cidade = $cidade2;
		} else {
			$estado = $estado1;
			$cidade = $cidade1;
		}

		$dataNascimentoSoNumeros = preg_replace('/\D/', '', $nascimento);
		$total_numeros_data_nascimento = strlen($dataNascimentoSoNumeros);

		$codigo = $this->input->post('codigo');
		$infocodigo = $this->FConsultas_model->infos_codigo($codigo);
		$link_codigo = $infocodigo['link'];

		$codigo_id_c = $infocodigo['dados'];
		if ($codigo_id_c == '') {
			$id_supervisor = 4000;
		} else {
			$id_supervisor = $infocodigo['id_usuario'];
		}

		echo $link_codigo;

		// cadastrando coordenador pais = brasil
		if ($is_br) {
			$cpfSoNumeros = preg_replace('/\D/', '', $cpf);
			$total_numeros_cpf = strlen($cpfSoNumeros);
			if ($total_numeros_cpf == 11 && $total_numeros_data_nascimento == 8 && $this->FAlerta_model->valida_cpf($cpfSoNumeros)) {

				$cpf_completo = $cpfSoNumeros[0] . $cpfSoNumeros[1] . $cpfSoNumeros[2] . "." . $cpfSoNumeros[3] . $cpfSoNumeros[4] . $cpfSoNumeros[5] . "." . $cpfSoNumeros[6] . $cpfSoNumeros[7] . $cpfSoNumeros[8] . "-" . $cpfSoNumeros[9] . $cpfSoNumeros[10];

				$data_nascimento_completo = $dataNascimentoSoNumeros[0] . $dataNascimentoSoNumeros[1] . "/" . $dataNascimentoSoNumeros[2] . $dataNascimentoSoNumeros[3] . "/" . $dataNascimentoSoNumeros[4] . $dataNascimentoSoNumeros[5] . $dataNascimentoSoNumeros[6] . $dataNascimentoSoNumeros[7];

				$coordenadorjacadastrado = $this->Lideres->check_cadastro('consultar_por_2_cpf_email_nome', [$nome, $cpfSoNumeros, $cpf_completo, $email]);
				$usuariojatacadastrado = $this->Lideres->check_cadastro_usuario('check_nome_2_cpf_email', [$nome, $cpfSoNumeros, $cpf_completo, $email]);

				if ($coordenadorjacadastrado == 0 && $usuariojatacadastrado == 0) {
					$nivel = 3;

					$cadastro = $this->Coordenadores->cadastro_coordenador($nome, $cpf_completo, $email, $telefone, $data_nascimento_completo, $nome_pais, $estado, $cidade, $id_supervisor, 3);
					$cadastroUsuario = $this->Lideres->cadastrarUsuário($nome, $email, $cpf_completo, $nivel, $senha);

					if ($cadastro && $cadastroUsuario) {

						$consultarDados = $this->Coordenadores->infos([$email, $cpfSoNumeros, $cpf_completo, $nome], 'info_coordenador_or_email_cpf_nome', '', '');
						$id_coordenador = $consultarDados['dados']['id_coordenador'];

						$link_lider = "https://sistemas.campbrasil.com/sistema/acesso?email=$email&cpf=$cpf_completo&nome=$nome&senha=$senha&x_ir=1&opc=1";
						$this->enviar_email_coordenador_liberacao_sistema($id_coordenador, $link_lider);

						$this->FConsultas_model->mensagem('success', 'Sucesso!', ["Cadastro Realizado com Sucesso! Aguarde! Em breve retornaremos com mais Informações"]);
						echo '
							<script>
								setTimeout(function(){ window.location="https://site.campbrasil.com/" }, 3000);
							</script>
						';
					} else {
						$this->FConsultas_model->mensagem('danger', 'Erro!', ["Tente Novamente!"]);
						echo '
							<script>
								setTimeout(function(){ window.location="' . $link_codigo . '" }, 3000);
							</script>
						';
					}
				} else {
					$info_usuario = $this->Lideres->infos([$email, $cpf, $nome], 'info_usuario_or_email_cpf_nome', '', '');

					if ($info_usuario['row'] == 0) {
						$mensagem = "Link Inválido!\nDados não Encontrado";
						$link = "https://sistemas.campbrasil.com";
					} else {
						$nome_usuario = $info_usuario['dados']['nome'];
						$email_usuario = $info_usuario['dados']['email'];
						$cpf_usuario = $info_usuario['dados']['cpf'];
						$senha = $info_usuario['dados']['senha'];
						$mensagem = "Sucesso!\nLíder Liberado!";
						$link = "https://sistemas.campbrasil.com/sistema/acesso?email=$email_usuario&cpf=$cpf_usuario&nome=$nome_usuario&senha=$senha&x_ir=1&opc=1";
					}

					$this->FConsultas_model->mensagem('danger', 'Você já está cadastrado! Você será redirecionado!', [$mensagem]);
					echo '
						<script>
							setTimeout(function(){ window.location="' . $link . '" }, 3000);
						</script>
					';
				}
			} else {
				$this->FConsultas_model->mensagem('danger', 'Erro!', ["Data de Nascimento Inválida!"]);
				echo '
				<script>
					setTimeout(function(){ window.location="' . $link_codigo . '" }, 3000);
				</script>
			';
			}
		} else {
			// cadastro coordenador outro pais
			if ($total_numeros_data_nascimento == 8) {
				$data_nascimento_completo = $dataNascimentoSoNumeros[0] . $dataNascimentoSoNumeros[1] . "/" . $dataNascimentoSoNumeros[2] . $dataNascimentoSoNumeros[3] . "/" . $dataNascimentoSoNumeros[4] . $dataNascimentoSoNumeros[5] . $dataNascimentoSoNumeros[6] . $dataNascimentoSoNumeros[7];

				$liderjacadastrado = $this->Lideres->check_cadastro('consultar_por_email_nome_data_nascimento', [$nome, $email, $data_nascimento_completo]);
				$usuariojatacadastrado = $this->Lideres->check_cadastro_usuario('check_nome_email', [$nome, $email]);

				if ($liderjacadastrado == 0 && $usuariojatacadastrado == 0) {
					$nivel = 3;
					$cadastro = $this->Coordenadores->cadastro_coordenador($nome, "", $email, $telefone, $data_nascimento_completo, $nome_pais, $estado, $cidade, $id_supervisor, 3);
					$cadastroUsuario = $this->Lideres->cadastrarUsuário($nome, $email, "", $nivel, $senha);

					if ($cadastro && $cadastroUsuario) {
						$consultarDados = $this->Coordenadores->infos([$email, $nome, $data_nascimento_completo], 'info_coordenador_nome_email_data_nascimento', '', '');

						$id_coordenador = $consultarDados['dados']['id_coordenador'];

						$link_lider = "https://sistemas.campbrasil.com/sistema/acesso?email=$email&cpf=&nome=$nome&senha=$senha&x_ir=1&opc=2";
						$this->enviar_email_coordenador_liberacao_sistema($id_coordenador, $link_lider);

						$this->FConsultas_model->mensagem('success', 'Sucesso!', ["Cadastro Realizado com Sucesso! Aguarde! Em breve retornaremos com mais Informações"]);
						echo '
							<script>
								setTimeout(function(){ window.location="https://site.campbrasil.com/" }, 3000);
							</script>
						';
					} else {
						$this->FConsultas_model->mensagem('danger', 'Erro!', ["Tente Novamente!"]);
						echo '
							<script>
								setTimeout(function(){ window.location="' . $link_codigo . '" }, 3000);
							</script>
						';
					}
				} else {
					$info_usuario = $this->Lideres->infos([$email, $nome], 'info_usuario_or_email_nome', '', '');

					if ($info_usuario['row'] == 0) {
						$mensagem = "Link Inválido!\nDados não Encontrado";
						$link = $link_codigo;
					} else {
						$nome_usuario = $info_usuario['dados']['nome'];
						$email_usuario = $info_usuario['dados']['email'];
						$cpf_usuario = $info_usuario['dados']['cpf'];
						$senha = $info_usuario['dados']['senha'];
						$mensagem = "Sucesso!\nLíder Liberado!";
						$link = "https://sistemas.campbrasil.com/sistema/acesso?email=$email_usuario&cpf=$cpf_usuario&nome=$nome_usuario&senha=$senha&x_ir=1&opc=2";
					}

					$this->FConsultas_model->mensagem('danger', 'Você já está cadastrado! Você será redirecionado!', [$mensagem]);
					echo '
						<script>
							setTimeout(function(){ window.location="' . $link . '" }, 3000);
						</script>
					';
				}
			} else {
				$this->FConsultas_model->mensagem('danger', 'Erro!', ["Data de Nascimento Inválida!"]);
				echo '
					<script>
						setTimeout(function(){ window.location="' . $link_codigo . '" }, 3000);
					</script>
				';
			}
		}

		/*$red = $this->input->post('red');
		$funcao = $this->FConsultas_model->red("$red", 2000, []);
		echo $funcao;*/
	}

	// cadastro coordenador na plataforma (ok)
	public function cadastro_coordenador()
	{
		$nome = $this->input->post('nome');
		$cpf = $this->input->post('cpf');
		$email = $this->input->post('email');
		$telefone_digitado = $this->input->post('telefone');
		$pais = $this->input->post('pais');
		$estado1 = $this->input->post('estados');
		$cidade1 = $this->input->post('cidades');
		$estado2 = $this->input->post('estados2');
		$cidade2 = $this->input->post('cidades2');
		$nascimento = $this->input->post('nascimento');

		$senha = $this->input->post('senha');

		$is_br = $pais == 'br' || '' ? true : false;

		$telefone = $this->FConsultas_model->formatar_telefone($telefone_digitado, $is_br);

		$nome_digitado_pais = $this->input->post('nome_pais');

		$id_supervisor = $this->input->post('id_supervisor');

		$nome_pais = "";
		$estado = "";
		$cidade = "";

		if ($pais == "br") {
			$nome_pais = "br";
		} else {
			$nome_pais = $nome_digitado_pais;
		}

		if ($estado1 == "" and $cidade1 == "") {
			$estado = $estado2;
			$cidade = $cidade2;
		} else {
			$estado = $estado1;
			$cidade = $cidade1;
		}

		$dataNascimentoSoNumeros = preg_replace('/\D/', '', $nascimento);
		$total_numeros_data_nascimento = strlen($dataNascimentoSoNumeros);

		// cadastrando coordenador pais = brasil
		if ($is_br) {
			$cpfSoNumeros = preg_replace('/\D/', '', $cpf);
			$total_numeros_cpf = strlen($cpfSoNumeros);
			if ($total_numeros_cpf == 11 && $total_numeros_data_nascimento == 8 && $this->FAlerta_model->valida_cpf($cpfSoNumeros)) {

				$cpf_completo = $cpfSoNumeros[0] . $cpfSoNumeros[1] . $cpfSoNumeros[2] . "." . $cpfSoNumeros[3] . $cpfSoNumeros[4] . $cpfSoNumeros[5] . "." . $cpfSoNumeros[6] . $cpfSoNumeros[7] . $cpfSoNumeros[8] . "-" . $cpfSoNumeros[9] . $cpfSoNumeros[10];

				$data_nascimento_completo = $dataNascimentoSoNumeros[0] . $dataNascimentoSoNumeros[1] . "/" . $dataNascimentoSoNumeros[2] . $dataNascimentoSoNumeros[3] . "/" . $dataNascimentoSoNumeros[4] . $dataNascimentoSoNumeros[5] . $dataNascimentoSoNumeros[6] . $dataNascimentoSoNumeros[7];

				$coordenadorjacadastrado = $this->Lideres->check_cadastro('consultar_por_2_cpf_email_nome', [$nome, $cpfSoNumeros, $cpf_completo, $email]);
				$usuariojatacadastrado = $this->Lideres->check_cadastro_usuario('check_nome_2_cpf_email', [$nome, $cpfSoNumeros, $cpf_completo, $email]);

				if ($coordenadorjacadastrado == 0 && $usuariojatacadastrado == 0) {
					$nivel = 3;

					$cadastro = $this->Coordenadores->cadastro_coordenador($nome, $cpf_completo, $email, $telefone, $data_nascimento_completo, $nome_pais, $estado, $cidade, $id_supervisor, 2);
					$cadastroUsuario = $this->Lideres->cadastrarUsuário($nome, $email, $cpf_completo, $nivel, $senha);

					if ($cadastro && $cadastroUsuario) {

						$consultarDados = $this->Coordenadores->infos([$email, $cpfSoNumeros, $cpf_completo, $nome], 'info_coordenador_or_email_cpf_nome', '', '');
						$id_coordenador = $consultarDados['dados']['id_coordenador'];

						$link_lider = "https://sistemas.campbrasil.com/sistema/acesso?email=$email&cpf=$cpf_completo&nome=$nome&senha=$senha&x_ir=1&opc=1";
						$this->enviar_email_coordenador_liberacao_sistema($id_coordenador, $link_lider);

						$this->FConsultas_model->mensagem('success', 'Sucesso!', ["Coordenador cadastrado com Sucesso!"]);
					} else {
						$this->FConsultas_model->mensagem('danger', 'Erro!', ["Tente Novamente!"]);
					}
				} else {
					$this->FConsultas_model->mensagem('danger', 'Erro!', ["Coordenador já Cadastrado!"]);
				}
			} else {
				$this->FConsultas_model->mensagem('danger', 'Erro!', ["Data de Nascimento Inválida!"]);
			}
		} else {
			// cadastro coordenador outro pais
			if ($total_numeros_data_nascimento == 8) {
				$data_nascimento_completo = $dataNascimentoSoNumeros[0] . $dataNascimentoSoNumeros[1] . "/" . $dataNascimentoSoNumeros[2] . $dataNascimentoSoNumeros[3] . "/" . $dataNascimentoSoNumeros[4] . $dataNascimentoSoNumeros[5] . $dataNascimentoSoNumeros[6] . $dataNascimentoSoNumeros[7];

				$liderjacadastrado = $this->Lideres->check_cadastro('consultar_por_email_nome_data_nascimento', [$nome, $email, $data_nascimento_completo]);
				$usuariojatacadastrado = $this->Lideres->check_cadastro_usuario('check_nome_email', [$nome, $email]);

				if ($liderjacadastrado == 0 && $usuariojatacadastrado == 0) {
					$nivel = 3;
					$cadastro = $this->Coordenadores->cadastro_coordenador($nome, "", $email, $telefone, $data_nascimento_completo, $nome_pais, $estado, $cidade, $id_supervisor, 2);
					$cadastroUsuario = $this->Lideres->cadastrarUsuário($nome, $email, "", $nivel, $senha);

					if ($cadastro && $cadastroUsuario) {

						$consultarDados = $this->Coordenadores->infos([$email, $nome, $data_nascimento_completo], 'info_coordenador_nome_email_data_nascimento', '', '');

						$id_coordenador = $consultarDados['dados']['id_coordenador'];

						$link_lider = "https://sistemas.campbrasil.com/sistema/acesso?email=$email&cpf=&nome=$nome&senha=$senha&x_ir=1&opc=2";
						$this->enviar_email_coordenador_liberacao_sistema($id_coordenador, $link_lider);

						$this->FConsultas_model->mensagem('success', 'Sucesso!', ["Coordenador cadastrado com Sucesso!"]);
					} else {
						$this->FConsultas_model->mensagem('danger', 'Erro!', ["Tente Novamente!"]);
					}
				}
			} else {
				$this->FConsultas_model->mensagem('danger', 'Erro!', ["Data de Nascimento Inválida!"]);
			}
		}

		$red = $this->input->post('red');
		$funcao = $this->FConsultas_model->red("$red", 2000, []);
		echo $funcao;
	}


	// liberar acesso via plataforma sem ser no link do email
	public function liberar_acesso_coordenador()
	{
		$id_coordenador = $this->input->post('id_coordenador');
		$id_usuario = $this->input->post('id_usuario');

		$info_coordenador = $this->Coordenadores->infos([$id_coordenador], 'info_coordenador', '', '');
		$is_br = $info_coordenador['dados']['pais'] == 'br' || '' ? true : false;

		$telefone = $this->FConsultas_model->formatar_telefone($info_coordenador['dados']['telefone_whatsapp'], $is_br);
		$mensagem = "Bem-Vindo ao sistema do CAMP Brasil!";

		$routa = $this->input->post('routa');

		$mudar = $this->Coordenadores->editar_autorizacao_coordenador($id_coordenador, 1);

		$email = $info_coordenador['dados']['email'];
		$cpf = $info_coordenador['dados']['cpf'];
		$nome = $info_coordenador['dados']['nome_coordenador'];
		$info_usuario = $this->Lideres->infos([$email, $cpf, $nome], 'info_usuario_and_email_cpf_nome', '', '');
		$senha = $info_usuario['dados']['senha'];

		if ($is_br) {
			$opc = 1;
		} else {
			$opc = 2;
		}

		$link_lider = "https://sistemas.campbrasil.com/sistema/acesso?email=$email&cpf=$cpf&nome=$nome&senha=$senha&x_ir=1&opc=$opc";

		$this->enviar_email_coordenador_liberacao_sistema($id_coordenador, $link_lider);

		if ($mudar) {
			$this->FAlerta_model->alerta_controle($id_usuario, $id_coordenador, "autorizou com sucesso seu lider", 'coord_autoriza_lider');

			$this->FConsultas_model->mensagem('success', 'Sucesso!', ['Sucesso!']);
			$funcao = $this->FConsultas_model->red("$routa", 2000, []);

			//echo "LINK: $link_lider";

			echo $funcao;

			echo '<script>
				const newTab = window.open("about:blank");
				setTimeout(function() {
				newTab.location.href = "https://api.whatsapp.com/send?phone=' . $telefone . '&text=' . $mensagem . '";
				}, 0);
			</script>';
		}
	}

	// ok
	public function desativar_coordenador()
	{
		$id_coordenador = $this->input->post("id_coordenador");
		$id_usuario = $this->input->post("idUsuario");
		$motivo = $this->input->post("motivo");

		$dados_lideres = $this->Lideres->infos([$id_coordenador], 'query_lideres_id_coordenador', '', '');

		if ($dados_lideres['row'] == 0) {
		} else {
			foreach ($dados_lideres['dados'] as $key => $lider) {
				$id_lider = $lider['id_lider'];
				$this->_desativar($id_lider, $id_usuario, $motivo, 'EX_L_2');
				$this->Lideres->desativar_lider($id_lider);
			}
		}

		$this->_desativar($id_coordenador, $id_usuario, $motivo, 'EX_C_1');
		$this->Coordenadores->desativar_coordenador($id_coordenador);

		$red = $this->input->post('red');
		$data = [];

		$this->FConsultas_model->mensagem('success', 'Sucesso!', ["Coordenador desativado!"]);
		$funcao = $this->FConsultas_model->red("$red", 2000, $data);
		echo $funcao;
	}

	// ok
	public function ativar_coordenador()
	{
		$id_coordenador = $this->input->post("id_coordenador");
		$id_usuario = $this->input->post("idUsuario");

		$dados_lideres = $this->Lideres->infos([$id_coordenador], 'query_lideres_id_coordenador', '', '');

		if ($dados_lideres['row'] == 0) {
		} else {
			foreach ($dados_lideres['dados'] as $key => $lider) {
				$id_lider = $lider['id_lider'];
				$this->_ativar($id_lider, $id_usuario);
				$this->Lideres->ativar_lider($id_lider);
			}
		}

		$this->_ativar($id_coordenador, $id_usuario);
		$this->Coordenadores->ativar_coordenador($id_coordenador);

		$red = $this->input->post('red') ?? 'coordenador';
		$data = [];

		$this->FConsultas_model->mensagem('success', 'Sucesso!', ["Coordenador Ativado!"]);
		$funcao = $this->FConsultas_model->red("$red", 2000, $data);
		echo $funcao;
	}

	// ok
	public function excluir_coordenador_permanentemente()
	{
		$id_coordenador = $this->input->post("opc");
		$id_coordenador_novo = $this->input->post("id_novo_coordenador");
		$id_usuario = $this->input->post("idUsuario");

		if ($id_coordenador_novo == 0) {
		} else {
			$this->Lideres->trocar_coordenacao_do_lider($id_coordenador, $id_coordenador_novo);
		}

		$this->_excluir_permanentemente($id_coordenador, $id_usuario);
		$this->Coordenadores->excluirCoordenadorPermanentemente($id_coordenador, $id_usuario);

		$red = $this->input->post('red');
		$data = [];

		$this->FConsultas_model->mensagem('success', 'Sucesso!', ["Coordenador Excluido Permanentemente!"]);
		$funcao = $this->FConsultas_model->red("$red", 2000, $data);
		echo $funcao;
	}

	// cadastro lider via sistema
	public function cadastro_lider()
	{
		$nome = $this->input->post('nome');
		$cpf = $this->input->post('cpf');
		$email = $this->input->post('email');
		$telefone_digitado = $this->input->post('telefone');
		$igreja = $this->input->post('igreja');
		$pais = $this->input->post('pais');
		$estado1 = $this->input->post('estados');
		$cidade1 = $this->input->post('cidades');
		$estado2 = $this->input->post('estados2');
		$cidade2 = $this->input->post('cidades2');
		$nascimento = $this->input->post('nascimento');

		$senha = $this->input->post('senha');

		$is_br = $pais == 'br' || '' ? true : false;

		$telefone = $this->FConsultas_model->formatar_telefone($telefone_digitado, $is_br);

		$id_pastor = 2000;
		//$id_pastor = $this->input->post('id_pastor');
		$id_coordenador = $this->input->post('id_coordenador');
		$id_slocal = $this->input->post('id_supervisor');
		$id_sregional = $this->input->post('id_supervisor');

		$estado = "";
		$cidade = "";

		if ($estado1 == "" and $cidade1 == "") {
			$estado = $estado2;
			$cidade = $cidade2;
		} else {
			$estado = $estado1;
			$cidade = $cidade1;
		}

		$red = $this->input->post('red') ?? 'coordenador/lideres';
		$data = [];

		$dataNascimentoSoNumeros = preg_replace('/\D/', '', $nascimento);
		$total_numeros_data_nascimento = strlen($dataNascimentoSoNumeros);

		// cadastrando lider pais = brasil
		if ($is_br) {
			$cpfSoNumeros = preg_replace('/\D/', '', $cpf);
			$total_numeros_cpf = strlen($cpfSoNumeros);

			if ($total_numeros_cpf == 11 && $total_numeros_data_nascimento == 8 && $this->FAlerta_model->valida_cpf($cpfSoNumeros)) {

				$cpf_completo = $cpfSoNumeros[0] . $cpfSoNumeros[1] . $cpfSoNumeros[2] . "." . $cpfSoNumeros[3] . $cpfSoNumeros[4] . $cpfSoNumeros[5] . "." . $cpfSoNumeros[6] . $cpfSoNumeros[7] . $cpfSoNumeros[8] . "-" . $cpfSoNumeros[9] . $cpfSoNumeros[10];
				$data_nascimento_completo = $dataNascimentoSoNumeros[0] . $dataNascimentoSoNumeros[1] . "/" . $dataNascimentoSoNumeros[2] . $dataNascimentoSoNumeros[3] . "/" . $dataNascimentoSoNumeros[4] . $dataNascimentoSoNumeros[5] . $dataNascimentoSoNumeros[6] . $dataNascimentoSoNumeros[7];

				$liderjacadastrado = $this->Lideres->check_cadastro('consultar_por_2_cpf_email_nome', [$nome, $cpfSoNumeros, $cpf_completo, $email]);
				$usuariojatacadastrado = $this->Lideres->check_cadastro_usuario('check_nome_2_cpf_email', [$nome, $cpfSoNumeros, $cpf_completo, $email]);

				if ($liderjacadastrado == 0 && $usuariojatacadastrado == 0) {
					$nivel = 1;
					$cadastro = $this->Lideres->cadastro_lider($nome, $cpf_completo, $email, $telefone, $igreja, $data_nascimento_completo, $id_pastor, $pais, $estado, $cidade, $id_coordenador, $id_slocal, $id_sregional, 2);
					$cadastroUsuario = $this->Lideres->cadastrarUsuário($nome, $email, $cpf_completo, $nivel, $senha);
					if ($cadastro && $cadastroUsuario) {
						$consultarDados = $this->Lideres->infos([$email, $cpfSoNumeros, $cpf_completo, $nome], 'info_lider_or_email_cpf_nome', '', '');
						$id_lider = $consultarDados['dados']['id_lider'];

						$link_lider = "https://sistemas.campbrasil.com/sistema/acesso?email=$email&cpf=$cpf_completo&nome=$nome&senha=$senha&x_ir=1&opc=1";
						$this->enviar_email_lider_liberacao_sistema($id_lider, $link_lider);

						$this->FConsultas_model->mensagem('success', 'Sucesso!', ["Líder cadastrado com Sucesso!"]);
					} else {
						$this->FConsultas_model->mensagem('danger', 'Erro!', ["Tente Novamente!"]);
					}
				} else {
					$this->FConsultas_model->mensagem('danger', 'Erro!', ["Líder já Cadastrado!"]);
				}
			} else {
				$this->FConsultas_model->mensagem('danger', 'Erro!', ["CPF ou Data de Nascimento Inválido!"]);
			}
		} else {
			// cadastro líder outro pais
			if ($total_numeros_data_nascimento == 8) {
				$data_nascimento_completo = $dataNascimentoSoNumeros[0] . $dataNascimentoSoNumeros[1] . "/" . $dataNascimentoSoNumeros[2] . $dataNascimentoSoNumeros[3] . "/" . $dataNascimentoSoNumeros[4] . $dataNascimentoSoNumeros[5] . $dataNascimentoSoNumeros[6] . $dataNascimentoSoNumeros[7];

				$liderjacadastrado = $this->Lideres->check_cadastro('consultar_por_email_nome_data_nascimento', [$nome, $email, $data_nascimento_completo]);
				$usuariojatacadastrado = $this->Lideres->check_cadastro_usuario('check_nome_email', [$nome, $email]);

				if ($liderjacadastrado == 0 && $usuariojatacadastrado == 0) {
					$nivel = 1;
					$cadastro = $this->Lideres->cadastro_lider($nome, "", $email, $telefone, $igreja, $data_nascimento_completo, $id_pastor, $pais, $estado, $cidade, $id_coordenador, $id_slocal, $id_sregional, 2);
					$cadastroUsuario = $this->Lideres->cadastrarUsuário($nome, $email, "", $nivel, $senha);
					if ($cadastro && $cadastroUsuario) {
						$consultarDados = $this->Lideres->infos([$email, $nome, $data_nascimento_completo], 'info_lider_nome_email_data_nascimento', '', '');
						$id_lider = $consultarDados['dados']['id_lider'];

						$link_lider = "https://sistemas.campbrasil.com/sistema/acesso?email=$email&cpf=&nome=$nome&senha=$senha&x_ir=1&opc=2";
						$this->enviar_email_lider_liberacao_sistema($id_lider, $link_lider);

						$this->FConsultas_model->mensagem('success', 'Sucesso!', ["Líder cadastrado com Sucesso!"]);
					} else {
						$this->FConsultas_model->mensagem('danger', 'Erro!', ["Tente Novamente!"]);
					}
				} else {
					$this->FConsultas_model->mensagem('danger', 'Erro!', ["Líder já Cadastrado!"]);
				}
			} else {
				$this->FConsultas_model->mensagem('danger', 'Erro!', ["CPF ou Data de Nascimento Inválido!"]);
			}
		}

		$funcao = $this->FConsultas_model->red("$red", 2000, $data);
		echo $funcao;
	}

	public function desativar_lider()
	{
		$id_lider = $this->input->post("id_lider");
		$id_usuario = $this->input->post("id_usuario");
		$motivo = $this->input->post("motivo");
		$acao = $this->input->post("acao");
		$acao = !empty($acao) ? $acao : "EXCLUSAO";

		$this->_desativar($id_lider, $id_usuario, $motivo, $acao);
		$this->Lideres->desativar_lider($id_lider);

		$red = $this->input->post('red');
		$data = [];

		$this->FConsultas_model->mensagem('success', 'Sucesso!', ["Líder desativado!"]);
		$funcao = $this->FConsultas_model->red("$red", 2000, $data);
		echo $funcao;
	}

	public function _desativar($id_lider, $id_usuario, $motivo_txt, $acao)
	{

		$infos = $this->FConsultas_model->getInfoUserId($id_lider);
		$infonome = $this->FConsultas_model->getNomeUserId($id_lider);

		$motivo = "O usuário de ID ($id_usuario) desativou esse líder - $motivo_txt";

		// desativar pg
		$consultaPG = $this->PG->query([$id_lider], 'query_lider_ativo_order_by_nome_pg_asc', 1);
		$dadosPG = $consultaPG['dados'];

		if ($consultaPG['row'] == 0) {
		} else {
			foreach ($dadosPG as $key => $pg) {
				$this->PG->excluir_pg($pg['id_pg'], $id_lider,  $id_usuario, $motivo);
			}
		}

		// desativar crianças
		$consultaCriancas = $this->Criancas->query([$id_lider], 'query_id_lider');
		$dadosCriancas = $consultaCriancas['dados'];

		if ($consultaCriancas['row'] == 0) {
		} else {
			foreach ($dadosCriancas as $key => $criancas) {
				$this->Criancas->excluir_crianca($criancas['id_crianca'],  $id_lider, $id_usuario, $motivo);
			}
		}

		// mudar o ativo do líder
		$this->Lideres->desativarUsuário($infonome['nome'], $infos['dados']['email'], $infos['dados']['cpf']);
		$this->FAlerta_model->alerta_controle($id_usuario, $id_lider, $motivo, $acao);
	}
	public function ativar_lider(): void
	{
		$id_lider = $this->input->post("id_lider");
		$id_usuario = $this->input->post("id_usuario");

		$this->_ativar($id_lider, $id_usuario);
		$this->Lideres->ativar_lider($id_lider);

		$red = $this->input->post('red');
		$data = [];

		$this->FConsultas_model->mensagem('success', 'Sucesso!', ["Líder Ativado!"]);
		$funcao = $this->FConsultas_model->red("$red", 2000, $data);
		echo $funcao;
	}
	public function _ativar($id_lider, $id_usuario)
	{
		$infos = $this->FConsultas_model->getInfoUserId($id_lider);
		$infonome = $this->FConsultas_model->getNomeUserId($id_lider);

		// desativar pg
		$consultaPG = $this->PG->query([$id_lider], 'query_lider_ativo_order_by_nome_pg_asc', 0);
		$dadosPG = $consultaPG['dados'];

		if ($consultaPG['row'] == 0) {
		} else {
			foreach ($dadosPG as $key => $pg) {
				$this->PG->reativar_pg($pg['id_pg'], $id_usuario);
			}
		}

		// desativar crianças
		$consultaCriancas = $this->Criancas->query([$id_lider], 'query_id_lider');
		$dadosCriancas = $consultaCriancas['dados'];

		if ($consultaCriancas['row'] == 0) {
		} else {
			foreach ($dadosCriancas as $key => $criancas) {
				$this->Criancas->ativar_crianca($id_usuario, $id_lider, $criancas['id_crianca']);
			}
		}
		// mudar o ativo do líder
		$this->Lideres->ativarUsuario($infonome['nome'], $infos['dados']['email'], $infos['dados']['cpf']);
	}
	public function excluir_lider_permanentemente()
	{
		$id_lider = $this->input->post("id_lider");
		$id_usuario = $this->input->post("id_usuario");
		$motivo = $this->input->post("motivo");
		$id_novo_lider = $this->input->post("id_novo_lider");

		if ($id_novo_lider == '0') {
		} else {

			$dados_pg_antigo_lider = $this->PG->query([$id_lider], 'query_pg_id_lider_all', '');

			if ($dados_pg_antigo_lider['row'] == 0) {
			} else {
				foreach ($dados_pg_antigo_lider['dados'] as $key => $pg) {
					$id_pg = $pg['id_pg'];
					$this->_trocar_lideranca($id_usuario, $id_lider, $id_novo_lider, $id_pg);
				}
			}
		}

		$this->_excluir_permanentemente($id_lider, $id_usuario);
		$this->Lideres->excluir_lider_permanentemente($id_lider, $id_usuario, $motivo);

		$red = $this->input->post('red');
		$data = [];

		$this->FConsultas_model->mensagem('success', 'Sucesso!', ["Líder Excluido Permanentemente!"]);
		$funcao = $this->FConsultas_model->red("$red", 2000, $data);
		echo $funcao;
	}

	public function _excluir_permanentemente($id_lider, $id_usuario)
	{
		$infos = $this->FConsultas_model->getInfoUserId($id_lider);
		$infonome = $this->FConsultas_model->getNomeUserId($id_lider);

		// desativar pg
		$consultaPG = $this->PG->query([$id_lider], 'query_pg_id_lider_all', 0);
		$dadosPG = $consultaPG['dados'];

		if ($consultaPG['row'] == 0) {
		} else {
			foreach ($dadosPG as $key => $pg) {
				$this->PG->excluir_pg_permanentemente($pg['id_pg'], $id_lider, $id_usuario);
			}
		}

		// desativar crianças
		$consultaCriancas = $this->Criancas->query([$id_lider], 'query_id_lider');
		$dadosCriancas = $consultaCriancas['dados'];

		if ($consultaCriancas['row'] == 0) {
		} else {
			foreach ($dadosCriancas as $key => $criancas) {
				$this->Criancas->excluir_crianca_permanentemente($criancas['id_crianca'], $criancas['nome_crianca'], $id_lider, $id_usuario);
			}
		}

		$dados_colider = $this->Lideres->mostrar_colider_do_lider($id_lider);

		if ($dados_colider) {
			$this->Lideres->excluirColiderPermanentemente($dados_colider['id_colider'], $id_lider, $id_usuario);
		} else {
		}

		// mudar o ativo do líder
		$this->Lideres->excluirUsuarioPermanentemente($infonome['nome'], $infos['dados']['email'], $infos['dados']['cpf']);
	}

	// Colíderes
	public function cadastro_colider() // ok
	{
		$idLider = $this->input->post('idLider');
		$nomeColider = $this->input->post('nomeColider');
		$emailColider = $this->input->post('emailColider');
		$cpfColider = $this->input->post('cpfColider');
		$telefoneColider = $this->input->post('telefoneColider');
		$nascimentoColider = $this->input->post('nascimentoColider');

		$consultarColider = $this->Lideres->check_colider($nomeColider, $cpfColider, $emailColider, $telefoneColider);

		$red = $this->input->post('red');
		$data = [];

		if ($consultarColider == 0) {
			$cadastroColider = $this->Lideres->cadastrarColider($idLider, $nomeColider, $cpfColider, $emailColider, $telefoneColider, $nascimentoColider);

			if ($cadastroColider) {
				$this->FConsultas_model->mensagem('success', 'Sucesso!', ['Cadastro Relizado com Sucesso!']);
				$funcao = $this->FConsultas_model->red("$red", 2000, $data);
				echo $funcao;
			} else {
				$this->FConsultas_model->mensagem('danger', 'Erro!', ['Tente Novamente!']);
				$funcao = $this->FConsultas_model->red("$red", 2000, $data);
				echo $funcao;
			}
		} else {
			$this->FConsultas_model->mensagem('danger', 'Erro!', ['Colíder já cadastrado']);
			$funcao = $this->FConsultas_model->red("$red", 2000, $data);
			echo $funcao;
		}
	}

	// ok

	public function desativar_colider()
	{
		$idLider = $this->input->post("idLider");
		$idColider = $this->input->post("idColider");
		$nomeColider = $this->input->post("nomeColider");

		$idResponsavel = $this->input->post("idResponsavel");
		$motivo = $this->input->post("motivo");

		$reativar = $this->Lideres->excluirColider($idColider, $nomeColider, $idLider, $idResponsavel, $motivo);

		$red = $this->input->post('red') ?? 'pagina_editar_pessoal';
		$data = [];

		if ($reativar) {
			$this->FConsultas_model->mensagem('success', 'Sucesso!', ['Atenção! Colíder Desativado com Sucesso!']);
			$funcao = $this->FConsultas_model->red("$red", 2000, $data);
			echo $funcao;
		} else {
			$this->FConsultas_model->mensagem('danger', 'Erro!', ['Tente Novamente!']);
			$funcao = $this->FConsultas_model->red("$red", 2000, $data);
			echo $funcao;
		}
	}

	// ok
	public function ativar_colider()
	{
		$idLider = $this->input->post("idLider");
		$idColider = $this->input->post("opc");

		$reativar = $this->Lideres->reativarColider($idColider, $idLider);

		$red = $this->input->post('red');
		$data = [];

		if ($reativar) {
			$this->FConsultas_model->mensagem('success', 'Sucesso!', ['Atenção! Colíder Ativado com Sucesso!']);
			$funcao = $this->FConsultas_model->red("$red", 2000, $data);
			echo $funcao;
		} else {
			$this->FConsultas_model->mensagem('danger', 'Erro!', ['Tente Novamente!']);
			$funcao = $this->FConsultas_model->red("$red", 2000, $data);
			echo $funcao;
		}
	}

	// ok
	public function excluir_colider_permanentemente()
	{
		$idLider = $this->input->post("idLider");
		$idUsuario = $this->input->post("idUsuario");
		$id_colider = $this->input->post("opc");

		$excluir = $this->Lideres->excluirColiderPermanentemente($id_colider, $idLider, $idUsuario);

		$red = $this->input->post('red');
		$data = [];

		if ($excluir) {
			$this->FConsultas_model->mensagem('success', 'Sucesso!', ["Atenção! Colíder Excluido Permanentemente!"]);
			$funcao = $this->FConsultas_model->red("$red", 2000, $data);
			echo $funcao;
		} else {
			$this->FConsultas_model->mensagem('danger', 'Erro!', ["Tente novamente!"]);
			$funcao = $this->FConsultas_model->red("$red", 2000, $data);
			echo $funcao;
		}
	}

	public function downloadMaterial()
	{
		$id = $this->input->post("id");
		$idLider = $this->input->post("id_lider");
		$idPg = $this->input->post("id_pg");
		$title = $this->input->post("title");
		$download = $this->input->post("download");

		$nivel = $this->input->post("nivel") == '' ? 1 : $this->input->post("nivel");
		if ($nivel == '2') {
		} else {
			$dataEscolhida = $this->input->post("data");
			$dadosPg = $this->PG->query([$idLider, $idPg], 'query_id_lider_id_pg_ativo', 1);

			$data = $dadosPg['dados']['data_inicio'];
			$dataHj = date('d/m/Y');

			//echo "A data de hj é " . $dataEscolhida . "<br>";
			if ($id == 2 && $data == '') {
				$dataE = $dataEscolhida == '' ? $dataHj : $dataEscolhida;
				//echo "A data de E é " . $dataE;

				$dia = $dataE[0] . $dataE[1];
				$mes = $dataE[3] . $dataE[4];
				$ano = $dataE[6] . $dataE[7] . $dataE[8] . $dataE[9];
				$data_trocada = $mes . "/" . $dia . "/" . $ano;
				$data_fim = date('d/m/Y', strtotime('+2 months', strtotime($data_trocada)));

				$this->PG->editar_data($idPg, $dataEscolhida, $data_fim, $dataEscolhida);
			}
		}

		if ($id == 4) {
			$nme = "$title.ppsx";
		} else {
			$nme = "$title.pdf";
		}

		//$this->load->view('import/sistema/arquivos/01/Trilha/Trilha');
		$pth = file_get_contents(base_url() . $download);
		force_download($nme, $pth);
	}
	public function download_material()
	{
		$nome = $this->input->post("nome");
		$download = $this->input->post("download");
		$pth = file_get_contents($download);
		force_download($nome, $pth);
	}

	public function gerar_certificado()
	{

		$nome = $this->input->post('nome');

		$opc = $this->input->post('opc');

		$img = $this->input->post('img');
		$nome_user = $this->input->post('nome_user');
		$nome_curso = "";

		$pdf = new FPDF("L", "mm", "A4");
		$pdf->SetCreator('CAMP Brasil');

		//$name = text to be added, $x= x cordinate, $y = y coordinate, $a = alignment , $f= Font Name, $t = Bold / Italic, $s = Font Size, $r = Red, $g = Green Font color, $b = Blue Font Color
		function AddText2($pdf, $text, $x, $y, $a, $f, $t, $s, $r, $g, $b)
		{
			$pdf->SetFont($f, $t, $s);
			$pdf->SetXY($x, $y);
			$pdf->SetTextColor($r, $g, $b);
			$pdf->Cell(0, 10, $pdf->textoUTF8($text), 0, 0, $a);
		}

		function AddText($pdf, $text, $x, $y, $a, $f, $t, $s, $r, $g, $b)
		{
			AddText2($pdf, $text, $x, $y, $a, $f, $t, $s, $r, $g, $b);
			AddText2($pdf, $text, $x, $y, $a, $f, $t, $s, $r, $g, $b);
			AddText2($pdf, $text, $x, $y, $a, $f, $t, $s, $r, $g, $b);
		}

		if ($opc == 1) {
			$nome_curso = "Certificado Treinamento Presencial";
			$carga_horaria = $this->input->post('carga_horaria');
			$data_treinamento = $this->input->post('data_treinamento');

			$nome_carga_horaria = "";

			if ($carga_horaria <= 1) {
				$nome_carga_horaria = $carga_horaria . " hora";
			} else {
				$nome_carga_horaria = $carga_horaria . " horas";
			}

			$dia = $data_treinamento[0] . $data_treinamento[1];
			$mes = $data_treinamento[3] . $data_treinamento[4];
			$ano = $data_treinamento[6] . $data_treinamento[7] . $data_treinamento[8] . $data_treinamento[9];

			$pdf->AddPage();
			$pdf->SetTitle($nome_curso, true);
			$pdf->Image($img, 0, 0, 297, 210);
			$x_letra = strlen($nome);
			$font1 = $x_letra < 40 ? 16 : 14;
			AddText($pdf, $nome, 71, 95, 'L', 'Helvetica', 'B', $font1, 0, 0, 0);
			AddText($pdf, $nome_user, 60, 125, 'L', 'Helvetica', 'B', 16, 0, 0, 0);
			AddText($pdf, $dia, 30, 137, 'L', 'Helvetica', 'B', 20, 0, 0, 0);
			AddText($pdf, $mes, 70, 137, 'L', 'Helvetica', 'B', 20, 0, 0, 0);
			AddText($pdf, $ano, 110, 137, 'L', 'Helvetica', 'B', 20, 0, 0, 0);
			AddText($pdf, $nome_carga_horaria, 60, 148, 'L', 'Helvetica', 'B', 20, 0, 0, 0);
		} else if ($opc == 2) {

			$nome_curso = "Certificado LOL 1";

			$de = $this->input->post('de_1');
			$ate = $this->input->post('ate_1');
			$mes = $this->input->post('mes_1');
			$ano = $this->input->post('ano_1');
			$estado = $this->input->post('estado');
			$cidade = $this->input->post('cidade');

			$nome_estado = $estado . ", " . $cidade;

			$pdf->AddPage();
			$pdf->SetTitle($nome_curso, true);
			$pdf->Image($img, 0, 0, 297, 210);
			$x_letra = strlen($nome);
			$font1 = $x_letra < 40 ? 16 : 14;
			AddText($pdf, $nome, 71, 93, 'L', 'Helvetica', 'B', $font1, 0, 0, 0);
			AddText($pdf, $nome_user, 132, 126, 'L', 'Helvetica', 'B', 20, 0, 0, 0);
			AddText($pdf, $de, 110, 136, 'L', 'Helvetica', 'B', 20, 0, 0, 0);
			AddText($pdf, $ate, 126, 136, 'L', 'Helvetica', 'B', 20, 0, 0, 0);
			AddText($pdf, $mes, 145, 136, 'L', 'Helvetica', 'B', 18, 0, 0, 0);
			AddText($pdf, $ano, 189, 136, 'L', 'Helvetica', 'B', 20, 0, 0, 0);
			AddText($pdf, $nome_estado, 120, 146, 'L', 'Helvetica', 'B', 20, 0, 0, 0);
		} else if ($opc == 3) {

			$nome_curso = "Certificado LOL 2";

			$img2 = $this->input->post('img2');
			$mes = $this->input->post('mes_2');
			$ano = $this->input->post('ano_2');

			$pdf->AddPage();
			$pdf->SetTitle($nome_curso, true);
			$pdf->Image($img, 0, 0, 297, 210);
			$x_letra = strlen($nome);
			$font1 = $x_letra < 40 ? 16 : 14;
			AddText($pdf, $nome, 91, 99, 'L', 'Helvetica', 'B', $font1, 0, 0, 0);
			AddText($pdf, $mes, 195, 139, 'L', 'Helvetica', 'B', 18, 0, 0, 0);
			AddText($pdf, $ano, 255, 139, 'L', 'Helvetica', 'B', 20, 0, 0, 0);

			$pdf->AddPage();
			$pdf->Image($img2, 0, 0, 297, 210);
		}

		$nome_arquivo = $nome_curso . " - " . $nome . ".pdf";
		$pdf->Output('D', $nome_arquivo);
	}

	public function offline()
	{
		$dados = array(
			'heading' => 'Você está Offline',
			'message' => 'Conect a internet e tente novamente',
		);

		$this->load->view('errors/html/error_404', $dados);
	}

	public function ir_modulo()
	{
		require_once('import/sistema/arquivos/01/Trilha/Trilha.php');
		//$this->load->view('import/sistema/arquivos/01/Arco/Arco.php');
	}

	public function enviar_email_lider_liberacao_sistema($id_lider, $link)
	{
		$dados_lider = $this->Lideres->infos([$id_lider], 'info_lider', '', '');
		if ($dados_lider['row'] == 0) {
			// enviar alerta p direção
		} else {
			$lider = $dados_lider['dados'];
			$email = $lider['email'];
			// Suucesso
			$assunto = "Bem-Vindo(a) " . $lider['nome_lider'] . " ao nosso sistema de discipulado infantil!";

			$dados = array(
				'dados_lider' => $lider,
				'link' => $link,
			);

			$page = $this->load->view('email/bem-vindo-sistema', $dados, TRUE);
			//$this->load->view('email/bem-vindo-sistema', $dados);

			$this->email->from("camp@campbrasil.com", 'CAMP Brasil');
			$this->email->subject($assunto);
			$this->email->to($email);
			$this->email->message($page);

			if ($this->email->send()) {
				//echo "\nsucesso";
			} else {
				//echo "\nerro\n";
				//echo $this->email->print_debugger();
			}
		}
	}

	public function enviar_email_coordenador_liberacao_sistema($id_coordenador, $link)
	{
		$dados_coordenador = $this->Coordenadores->infos([$id_coordenador], 'info_coordenador', '', '');
		if ($dados_coordenador['row'] == 0) {
			// enviar alerta p direção
		} else {
			$coordenador = $dados_coordenador['dados'];
			$email = $coordenador['email'];
			// Suucesso
			$assunto = "Bem-Vindo(a) " . $coordenador['nome_coordenador'] . " ao nosso sistema de discipulado infantil!";

			$dados = array(
				'dados_coordenador' => $coordenador,
				'link' => $link,
			);

			$page = $this->load->view('email/bem-vindo-sistema-coordenador', $dados, TRUE);
			//$this->load->view('email/bem-vindo-sistema', $dados);

			$this->email->from("camp@campbrasil.com", 'CAMP Brasil');
			$this->email->subject($assunto);
			$this->email->to($email);
			$this->email->message($page);

			if ($this->email->send()) {
				//echo "\nsucesso";
			} else {
				//echo "\nerro\n";
				//echo $this->email->print_debugger();
			}
		}
	}

	public function enviar_email_coordenador_liberacao_sistema_do_lider($id_coordenador, $id_usuario, $id_lider)
	{
		$dados_lider = $this->Lideres->infos([$id_lider], 'info_lider', '', '');
		$dados_coordenador = $this->Coordenadores->infos([$id_coordenador], 'info_coordenador', '', '');
		$data_hoje = date('d/m/Y');

		if ($dados_lider['row'] == 0) {
		} else {

			$lider = $dados_lider['dados'];
			$assunto = "Alerta de novo cadastrado no sistema - $data_hoje";

			if ($dados_coordenador['row'] == 0) {
				$dados = array(
					'dados_lider' => $lider,
					'nome' => 'Micaele Sales Ribeiro',
					'link' => "https://sistemas.campbrasil.com/sistema/aprovar?id_operador=$id_coordenador&id_usuario=$id_usuario&id_lider=$id_lider",
				);

				$page = $this->load->view('email/alerta_c-novo-lider', $dados, TRUE);
				//$this->load->view('email/alerta_c-novo-lider', $dados);

				$this->email->from("camp@campbrasil.com", 'CAMP Brasil');
				$this->email->subject($assunto);
				$this->email->to("sales.micaele1911@gmail.com");
				$this->email->message($page);

				if ($this->email->send()) {
					//echo "\nsucesso";
				} else {
					//echo "\nerro\n";
					//echo $this->email->print_debugger();
				}
			} else {
				$nome_coordenador = $dados_coordenador['dados']['nome_coordenador'];
				$email = $dados_coordenador['dados']['email'];
				// Suucesso

				$dados = array(
					'dados_lider' => $lider,
					'nome' => $nome_coordenador,
					'link' => "https://sistemas.campbrasil.com/sistema/aprovar?id_operador=$id_coordenador&id_usuario=$id_usuario&id_lider=$id_lider",
				);

				$page = $this->load->view('email/alerta_c-novo-lider', $dados, TRUE);
				//$this->load->view('email/alerta_c-novo-lider', $dados);

				$this->email->from("camp@campbrasil.com", 'CAMP Brasil');
				$this->email->subject($assunto);
				$this->email->to($email);
				$this->email->message($page);

				if ($this->email->send()) {
					//echo "\nsucesso";
				} else {
					//echo "\nerro\n";
					//echo $this->email->print_debugger();
				}
			}
		}
	}

	public function enviar_email_supervisor_liberacao_sistema($id_supervisor, $link)
	{
		$dados_supervisor = $this->Supervisores->infos([$id_supervisor], 'info_supervisor', '', '');
		if ($dados_supervisor['row'] == 0) {
			// enviar alerta p direção
		} else {
			$supervisor = $dados_supervisor['dados'];
			$email = $supervisor['email'];
			// Suucesso
			$assunto = "Bem-Vindo(a) " . $supervisor['nome_supervisorR'] . " ao nosso sistema de discipulado infantil!";

			$dados = array(
				'dados_supervisor' => $supervisor,
				'link' => $link,
			);

			$page = $this->load->view('email/bem-vindo-sistema-supervisor', $dados, TRUE);

			$this->email->from("camp@campbrasil.com", 'CAMP Brasil');
			$this->email->subject($assunto);
			$this->email->to($email);
			$this->email->message($page);

			if ($this->email->send()) {
				//echo "\nsucesso";
			} else {
				//echo "\nerro\n";
				//echo $this->email->print_debugger();
			}
		}
	}

	public function enviar_email_direcao_liberacao_sistema($id_supervisor, $id_usuario, $id_lider)
	{
		$dados_lider = $this->Lideres->infos([$id_lider], 'info_lider', '', '');
		$dados_supervisor = $this->Supervisores->infos([$id_supervisor], 'info_supervisor', '', '');
		$data_hoje = date('d/m/Y');

		if ($dados_lider['row'] == 0) {
		} else {

			$lider = $dados_lider['dados'];
			$assunto = "Alerta de novo cadastrado no sistema - $data_hoje";

			if ($dados_supervisor['row'] == 0) {
				$dados = array(
					'dados_lider' => $lider,
					'nome' => 'Micaele Sales Ribeiro',
					'link' => "https://sistemas.campbrasil.com/sistema/aprovar?id_operador=$id_supervisor&id_usuario=$id_usuario&id_lider=$id_lider",
				);

				$page = $this->load->view('email/alerta_c-novo-lider', $dados, TRUE);
				//$this->load->view('email/alerta_c-novo-lider', $dados);

				$this->email->from("camp@campbrasil.com", 'CAMP Brasil');
				$this->email->subject($assunto);
				$this->email->to("sales.micaele1911@gmail.com");
				$this->email->message($page);

				if ($this->email->send()) {
					//echo "\nsucesso";
				} else {
					//echo "\nerro\n";
					//echo $this->email->print_debugger();
				}
			} else {
				$nome_coordenador = $dados_supervisor['dados']['nome_supervisorR'];
				$email = $dados_supervisor['dados']['email'];
				// Suucesso

				$dados = array(
					'dados_lider' => $lider,
					'nome' => $nome_coordenador,
					'link' => "https://sistemas.campbrasil.com/sistema/aprovar?id_operador=$id_supervisor&id_usuario=$id_usuario&id_lider=$id_lider",
				);

				$page = $this->load->view('email/alerta_c-novo-lider', $dados, TRUE);
				//$this->load->view('email/alerta_c-novo-lider', $dados);

				$this->email->from("camp@campbrasil.com", 'CAMP Brasil');
				$this->email->subject($assunto);
				$this->email->to($email);
				$this->email->message($page);

				if ($this->email->send()) {
					//echo "\nsucesso";
				} else {
					//echo "\nerro\n";
					//echo $this->email->print_debugger();
				}
			}
		}
	}

	// cadastro supervisor na plataforma
	public function cadastro_supervisor()
	{
		$nome = $this->input->post('nome');
		$cpf = $this->input->post('cpf');
		$email = $this->input->post('email');
		$telefone_digitado = $this->input->post('telefone');
		$pais = $this->input->post('pais');
		$estado1 = $this->input->post('estados');
		$cidade1 = $this->input->post('cidades');
		$estado2 = $this->input->post('estados2');
		$cidade2 = $this->input->post('cidades2');
		$nascimento = $this->input->post('nascimento');

		$senha = $this->input->post('senha');

		$is_br = $pais == 'br' || '' ? true : false;

		$telefone = $this->FConsultas_model->formatar_telefone($telefone_digitado, $is_br);

		$nome_digitado_pais = $this->input->post('nome_pais');

		$nome_pais = "";
		$estado = "";
		$cidade = "";

		if ($pais == "br") {
			$nome_pais = "br";
		} else {
			$nome_pais = $nome_digitado_pais;
		}

		if ($estado1 == "" and $cidade1 == "") {
			$estado = $estado2;
			$cidade = $cidade2;
		} else {
			$estado = $estado1;
			$cidade = $cidade1;
		}

		$dataNascimentoSoNumeros = preg_replace('/\D/', '', $nascimento);
		$total_numeros_data_nascimento = strlen($dataNascimentoSoNumeros);

		// cadastrando supervisor pais = brasil
		if ($is_br) {
			$cpfSoNumeros = preg_replace('/\D/', '', $cpf);
			$total_numeros_cpf = strlen($cpfSoNumeros);
			if ($total_numeros_cpf == 11 && $total_numeros_data_nascimento == 8 && $this->FAlerta_model->valida_cpf($cpfSoNumeros)) {

				$cpf_completo = $cpfSoNumeros[0] . $cpfSoNumeros[1] . $cpfSoNumeros[2] . "." . $cpfSoNumeros[3] . $cpfSoNumeros[4] . $cpfSoNumeros[5] . "." . $cpfSoNumeros[6] . $cpfSoNumeros[7] . $cpfSoNumeros[8] . "-" . $cpfSoNumeros[9] . $cpfSoNumeros[10];

				$data_nascimento_completo = $dataNascimentoSoNumeros[0] . $dataNascimentoSoNumeros[1] . "/" . $dataNascimentoSoNumeros[2] . $dataNascimentoSoNumeros[3] . "/" . $dataNascimentoSoNumeros[4] . $dataNascimentoSoNumeros[5] . $dataNascimentoSoNumeros[6] . $dataNascimentoSoNumeros[7];

				$supervisorjacadastrado = $this->Lideres->check_cadastro('consultar_por_2_cpf_email_nome', [$nome, $cpfSoNumeros, $cpf_completo, $email]);
				$usuariojatacadastrado = $this->Lideres->check_cadastro_usuario('check_nome_2_cpf_email', [$nome, $cpfSoNumeros, $cpf_completo, $email]);

				if ($supervisorjacadastrado == 0 && $usuariojatacadastrado == 0) {
					$nivel = 4;

					$cadastro = $this->Supervisores->cadastro_supervisor($nome, $cpf_completo, $email, $telefone, $data_nascimento_completo, $nome_pais, $estado, $cidade, 1);
					$cadastroUsuario = $this->Lideres->cadastrarUsuário($nome, $email, $cpf_completo, $nivel, $senha);

					if ($cadastro && $cadastroUsuario) {

						$consultarDados = $this->Supervisores->infos([$email, $cpfSoNumeros, $cpf_completo, $nome], 'info_supervisor_or_email_cpf_nome', '', '');
						$id_supervisor = $consultarDados['dados']['id_supervisorR'];

						$link_lider = "https://sistemas.campbrasil.com/sistema/acesso?email=$email&cpf=$cpf_completo&nome=$nome&senha=$senha&x_ir=1&opc=1";
						$this->enviar_email_supervisor_liberacao_sistema($id_supervisor, $link_lider);

						$this->FConsultas_model->mensagem('success', 'Sucesso!', ["Supervisor cadastrado com Sucesso!"]);
					} else {
						$this->FConsultas_model->mensagem('danger', 'Erro!', ["Tente Novamente!"]);
					}
				} else {
					$this->FConsultas_model->mensagem('danger', 'Erro!', ["Supervisor já Cadastrado!"]);
				}
			} else {
				$this->FConsultas_model->mensagem('danger', 'Erro!', ["Data de Nascimento Inválida!"]);
			}
		} else {
			// cadastro coordenador outro pais
			if ($total_numeros_data_nascimento == 8) {
				$data_nascimento_completo = $dataNascimentoSoNumeros[0] . $dataNascimentoSoNumeros[1] . "/" . $dataNascimentoSoNumeros[2] . $dataNascimentoSoNumeros[3] . "/" . $dataNascimentoSoNumeros[4] . $dataNascimentoSoNumeros[5] . $dataNascimentoSoNumeros[6] . $dataNascimentoSoNumeros[7];

				$supervisorjacadastrado = $this->Lideres->check_cadastro('consultar_por_email_nome_data_nascimento', [$nome, $email, $data_nascimento_completo]);
				$usuariojatacadastrado = $this->Lideres->check_cadastro_usuario('check_nome_email', [$nome, $email]);

				if ($supervisorjacadastrado == 0 && $usuariojatacadastrado == 0) {
					$nivel = 4;

					$cadastro = $this->Supervisores->cadastro_supervisor($nome, "", $email, $telefone, $data_nascimento_completo, $nome_pais, $estado, $cidade, 1);

					$cadastroUsuario = $this->Lideres->cadastrarUsuário($nome, $email, "", $nivel, $senha);

					if ($cadastro && $cadastroUsuario) {

						$consultarDados = $this->Supervisores->infos([$email, $nome, $data_nascimento_completo], 'info_supervisor_nome_email_data_nascimento', '', '');

						$id_supervisor = $consultarDados['dados']['id_supervisorR'];

						$link_lider = "https://sistemas.campbrasil.com/sistema/acesso?email=$email&cpf=&nome=$nome&senha=$senha&x_ir=1&opc=2";
						$this->enviar_email_supervisor_liberacao_sistema($id_supervisor, $link_lider);

						$this->FConsultas_model->mensagem('success', 'Sucesso!', ["Supervisor cadastrado com Sucesso!"]);
					} else {
						$this->FConsultas_model->mensagem('danger', 'Erro!', ["Tente Novamente!"]);
					}
				} else {
					$this->FConsultas_model->mensagem('danger', 'Erro!', ["Supervisor já Cadastrado!"]);
				}
			} else {
				$this->FConsultas_model->mensagem('danger', 'Erro!', ["Data de Nascimento Inválida!"]);
			}
		}

		$red = $this->input->post('red');
		$funcao = $this->FConsultas_model->red("$red", 2000, []);
		echo $funcao;
	}

	// ok
	public function desativar_supervisor()
	{
		$id_supervisor = $this->input->post("id_supervisor");
		$id_usuario = $this->input->post("idUsuario");
		$motivo = $this->input->post("motivo");

		$dados_coordenadores = $this->Coordenadores->infos([$id_supervisor], 'info_coordenador_id_supervisor', '', '');

		if ($dados_coordenadores['row'] == 0) {
		} else {
			foreach ($dados_coordenadores['dados'] as $key => $lider) {
				$id_coordenador = $lider['id_coordenador'];
				$this->_desativar($id_coordenador, $id_usuario, $motivo, 'EX_L_2');
				$this->Coordenadores->desativar_coordenador($id_coordenador);
			}
		}

		$dados_lideres = $this->Lideres->infos([$id_supervisor], 'query_lideres_id_supervisor', '', '');

		if ($dados_lideres['row'] == 0) {
		} else {
			foreach ($dados_lideres['dados'] as $key => $lider) {
				$id_lider = $lider['id_lider'];
				$this->_desativar($id_lider, $id_usuario, $motivo, 'EX_L_2');
				$this->Lideres->desativar_lider($id_lider);
			}
		}

		$this->_desativar($id_supervisor, $id_usuario, $motivo, 'EX_C_1');
		$this->Supervisores->desativar_supervisor($id_supervisor);

		$red = $this->input->post('red');
		$data = [];

		$this->FConsultas_model->mensagem('success', 'Sucesso!', ["Supervisor desativado!"]);
		$funcao = $this->FConsultas_model->red("$red", 2000, $data);
		echo $funcao;
	}

	// ok
	public function ativar_supervisor()
	{
		$id_supervisor = $this->input->post("id_supervisor");
		$id_usuario = $this->input->post("idUsuario");

		$dados_coordenadores = $this->Coordenadores->infos([$id_supervisor], 'info_coordenador_id_supervisor', '', '');

		if ($dados_coordenadores['row'] == 0) {
		} else {
			foreach ($dados_coordenadores['dados'] as $key => $lider) {
				$id_coordenador = $lider['id_coordenador'];
				$this->_ativar($id_coordenador, $id_usuario);
				$this->Coordenadores->ativar_coordenador($id_coordenador);
			}
		}

		$dados_lideres = $this->Lideres->infos([$id_supervisor], 'query_lideres_id_supervisor', '', '');

		if ($dados_lideres['row'] == 0) {
		} else {
			foreach ($dados_lideres['dados'] as $key => $lider) {
				$id_lider = $lider['id_lider'];
				$this->_ativar($id_lider, $id_usuario);
				$this->Lideres->ativar_lider($id_lider);
			}
		}

		$this->_ativar($id_supervisor, $id_usuario);
		$this->Supervisores->ativar_supervisor($id_supervisor);

		$red = $this->input->post('red');
		$data = [];

		$this->FConsultas_model->mensagem('success', 'Sucesso!', ["Supervisor Ativado!"]);
		$funcao = $this->FConsultas_model->red("$red", 2000, $data);
		echo $funcao;
	}

	// ok
	public function excluir_supervisor_permanentemente()
	{
		$id_supervisor = $this->input->post("opc");
		$id_supervisor_novo = $this->input->post("id_novo_supervisor");
		$id_usuario = $this->input->post("idUsuario");

		if ($id_supervisor_novo == 0) {
		} else {
			$this->Coordenadores->trocar_supervisao_do_coordenador($id_supervisor, $id_supervisor_novo);
			$this->Lideres->trocar_supervisao_do_lider($id_supervisor, $id_supervisor_novo);
		}

		$this->_excluir_permanentemente($id_supervisor, $id_usuario);
		$this->Supervisores->excluirSupervisorPermanentemente($id_supervisor, $id_usuario);

		$red = $this->input->post('red');
		$data = [];

		$this->FConsultas_model->mensagem('success', 'Sucesso!', ["Supervisor Excluido Permanentemente!"]);
		$funcao = $this->FConsultas_model->red("$red", 2000, $data);
		echo $funcao;
	}
	public function enviarEmailDevocionalDiario()

	{
		$todosPais = $this->Lideres->infos([], 'query_all_lider_br', '', '');

		$dataHj = date('m/d/Y');

		$hora = date('H');

		if ($hora >= 7 && $hora <= 21) {
			$controller = 0;
			foreach ($todosPais as $key => $pais) {

				$id = $pais['id'];
				$email = $pais['email'];
				$todosPG = $this->PG->query([$id], 'query_pg_id_lider_all', '');

				if ($controller < 10) {
					foreach ($todosPG['dados'] as $key => $pg) {

						$idPg = $pg['id_pg'];

						$checks = $pg['autorizacao'];
						$ativoPG = $pg['ativo'];
						$nivelPg = $pg['nivel'];

						$anoPg = $pg['ano'];
						$modulo = $pg['modulo_devocional'];
						$licao = $pg['licao_devocional'];
						$diaComecou = $pg['data_semana'];

						if ($checks == 0 || $ativoPG == 0 || $diaComecou == '' || $nivelPg == 2) {
						} else {

							$dia = $diaComecou[0] . $diaComecou[1];
							$mes = $diaComecou[3] . $diaComecou[4];
							$ano = $diaComecou[6] . $diaComecou[7] . $diaComecou[8] . $diaComecou[9];
							$data_trocada = $mes . "/" . $dia . "/" . $ano;

							$dia1 = date('m/d/Y', strtotime('+1 day', strtotime($data_trocada)));
							$dia2 = date('m/d/Y', strtotime('+2 day', strtotime($data_trocada)));
							$dia3 = date('m/d/Y', strtotime('+3 day', strtotime($data_trocada)));
							$dia4 = date('m/d/Y', strtotime('+4 day', strtotime($data_trocada)));
							$dia5 = date('m/d/Y', strtotime('+5 day', strtotime($data_trocada)));
							$dia6 = date('m/d/Y', strtotime('+6 day', strtotime($data_trocada)));

							$check_day_1 = strtotime($dia1) == strtotime($dataHj) ? true : false;
							$check_day_2 = strtotime($dia2) == strtotime($dataHj) ? true : false;
							$check_day_3 = strtotime($dia3) == strtotime($dataHj) ? true : false;
							$check_day_4 = strtotime($dia4) == strtotime($dataHj) ? true : false;
							$check_day_5 = strtotime($dia5) == strtotime($dataHj) ? true : false;
							$check_day_6 = strtotime($dia6) == strtotime($dataHj) ? true : false;

							if ($check_day_1) {
								$diaDevocional = 1;
							} else if ($check_day_2) {
								$diaDevocional = 2;
							} else if ($check_day_3) {
								$diaDevocional = 3;
							} else if ($check_day_4) {
								$diaDevocional = 4;
							} else if ($check_day_5) {
								$diaDevocional = 5;
							} else if ($check_day_6) {
								$diaDevocional = 6;
							}

							if (strtotime($data_trocada) == strtotime($dataHj)) {
							} else {
								$check = $this->FConsultas_model->checkControler($id, $idPg, $anoPg, $modulo, $licao, $diaDevocional);

								if ($check == 0) {
									$dadosDevocionais = $this->FConsultas_model->consultarDevocionalModuloLicaoDia($anoPg, $modulo, $licao, $diaDevocional);
									if ($dadosDevocionais) {

										// Suucesso
										$assunto = "Devocional Dia " . $dadosDevocionais['dia'] . " - " . $dadosDevocionais['titulo'];

										$dados = array(
											'devocionais' => $dadosDevocionais,
											'nome' => $pais['nome'],
										);

										$page = $this->load->view('sistema/pais/partes/corpo-mensagem-devocional', $dados, TRUE);
										$this->email->from("camp@campbrasil.com", 'CAMP Brasil');
										$this->email->subject($assunto);
										$this->email->to($email);
										$this->email->message($page);
										$this->email->attach($dadosDevocionais['file'] ?? "");
										if ($this->email->send()) {
											$controller = $controller + 1;
											$this->Funcoes->controlerDevocionais($id, $idPg, $anoPg, $modulo, $licao, $diaDevocional, 1);
										} else {
										}
									} else {
									}
								} else {
									// enviar um email de erro p administração, com os dados p reenviar
								}
							}
						}
					}
				}
			}
		}
	}
	public function atualizarProgressoDevocional()
	{
		$todosPais = $this->Lideres->infos([], 'query_all_lider_br', '', '');

		$dataHj = date('m/d/Y');

		foreach ($todosPais as $key => $pais) {
			$id = $pais['id'];

			$todosPG = $this->PG->query([$id], 'query_pg_id_lider_all', '');

			if ($todosPG['row'] == 0) {
			} else {
				foreach ($todosPG['dados'] as $key => $pg) {

					$id_pg = $pg['id_pg'];
					$data_inicio = $pg['data_inicio'];
					$diaComecou = $pg['data_semana'];
					$modulo = $pg['modulo_devocional'];
					$licao = $pg['licao_devocional'];

					$n_modulo = $modulo + 1;

					$consultaMO = $this->FConsultas_model->consultarModuloId($modulo);

					if ($data_inicio == '' or $diaComecou == '') {
					} else {
						$dia = $diaComecou[0] . $diaComecou[1];
						$mes = $diaComecou[3] . $diaComecou[4];
						$ano = $diaComecou[6] . $diaComecou[7] . $diaComecou[8] . $diaComecou[9];
						$data_trocada = $mes . "/" . $dia . "/" . $ano;

						$data_troca = date('m/d/Y', strtotime('+7 day', strtotime($data_trocada)));
						$data_envio = date('d/m/Y', strtotime('+7 day', strtotime($data_trocada)));

						if (strtotime($dataHj) == strtotime($data_troca)) {

							$licao_nova = $licao + 1;

							$moduloNovo = $licao == $consultaMO['n_licao'] ? $n_modulo : $modulo;

							$licaoNova = $licao == $consultaMO['n_licao'] ? 1 : $licao_nova;

							$anoNovo = ($moduloNovo == 11 ? 3 : ($moduloNovo == 6 ? 2 : 1));

							$this->PG->editar_progresso_data($id_pg, $anoNovo, $moduloNovo, $licaoNova, $data_envio);
						} else {
						}
					}
				}
			}
		}
	}
	public function atualizarModuloMensal()
	{
		$todosPais = $this->Lideres->infos([], 'query_all_lider_br', '', '');

		$dataHj = date('m/d/Y');

		foreach ($todosPais as $key => $pais) {
			$id = $pais['id'];

			$todosPG = $this->PG->query([$id], 'query_pg_id_lider_all', '');

			if ($todosPG['row'] == 0) {
			} else {
				foreach ($todosPG['dados'] as $key => $pg) {

					$id_pg = $pg['id_pg'];

					$id_modulo_1 = $pg['id_modulo'];
					$id_modulo_2 = $pg['modulo_devocional'];

					$data_fim = $pg['data_previsao_termino'];

					if ($data_fim == '') {
					} else {
						if ($id_modulo_1 != $id_modulo_2) {
							if (strtotime($data_fim) >= strtotime($dataHj)) {
								$this->PG->editar_ativo($id_pg, $id);
							} else {
							}
						} else {
						}
					}
				}
			}
		}
	}

	public function trocar_de_funcao_2()
	{
		$funcao_atiga = $this->input->post('funcao_atiga');
		$funcao_nova = $this->input->post('funcao_nova');

		$id_usuario = $this->input->post('id_usuario');
		$dados = $this->FConsultas_model->getNomeUserId($id_usuario);
		$nome_usuario = $dados['nome'];

		$id_change = $this->input->post('id_change');
		$nome = $this->FConsultas_model->getNomeUserId($id_change)['nome'];
		$red = "";
		$red_erro = $this->input->post('red');

		if ($funcao_atiga == 'supervisor' && $funcao_nova == 'coordenador') { // ok
			$id_troca = $this->input->post('id_troca'); // novo supervisor

			$dados_do_supervisor = $this->Supervisores->infos([$id_change], 'info_supervisor', '', '');

			if ($dados_do_supervisor['row'] == 0) {
				$red = $red_erro;
				$this->FConsultas_model->mensagem('danger', 'Erro!', ['Dados do Supervisor não Encontrado!']);
			} else {
				$dados_supervisor = $dados_do_supervisor['dados'];

				// check se já tem algum coordenador cadastrado
				$coordenadorjacadastrado = $this->Coordenadores->infos([$dados_supervisor['email'], $dados_supervisor['nome_supervisorR'], $dados_supervisor['nascimento']], 'info_coordenador_nome_email_data_nascimento', '', '');

				// cadastro coordenador
				if ($coordenadorjacadastrado['row'] == 0) {
					$this->Coordenadores->cadastro_coordenador_2($dados_supervisor['nome_supervisorR'], $dados_supervisor['cpf'], $dados_supervisor['email'], $dados_supervisor['telefone_whatsapp'], $dados_supervisor['nascimento'], $dados_supervisor['pais'], $dados_supervisor['estado'], $dados_supervisor['cidade'], $id_troca, 1, $dados_supervisor['foto']);
				}

				// atualizar o nível do usuário
				$dadosusuario = $this->Lideres->infos([$dados_supervisor['email'], $dados_supervisor['cpf'], $dados_supervisor['nome_supervisorR']], 'info_usuario_and_email_cpf_nome', '', '');

				$coordenador_novo = $this->Coordenadores->infos([$dados_supervisor['email'], $dados_supervisor['nome_supervisorR'], $dados_supervisor['nascimento']], 'info_coordenador_nome_email_data_nascimento', '', '');

				if ($coordenador_novo['row'] == 0) {
					$red = $red_erro;
				} else {
					$this->Lideres->editar_usuario_nivel($dadosusuario['dados']['id_usuario'], 3);

					// apagar o supervisor
					$this->Supervisores->delete_supervisor_local_id($id_change);

					$id_coordenador_novo = $coordenador_novo['dados']['id_coordenador'];

					$this->Coordenadores->trocar_supervisao_do_coordenador($id_change, $id_troca);
					$this->Lideres->trocar_supervisao_do_lider($id_change, $id_troca);

					// atualizazr PG
					$this->PG->trocar_lideranca_pg_2($id_change, $id_coordenador_novo);
					// atualizar relatório
					$this->PG->editar_lideranca_relatorio_2($id_change, $id_coordenador_novo);
					// atualizar criancas
					$this->Criancas->editar_liderenca_crianca_2($id_change, $id_coordenador_novo);

					$red = "https://sistemas.campbrasil.com/sistema/direcao/page/coordenador/detalhes/$id_coordenador_novo";
				}

				$motivo = "O $nome_usuario efetuou troca de função do supervisor $nome (id: $id_change) para coordenador. Coordenadores e Líderes passarão para essa supervisão: $id_troca";
				$acao = "TROCA_SUPERVISOR_TO_COORDENADOR";

				$this->FAlerta_model->alerta_controle($id_usuario, $id_troca, $motivo, $acao);
				$this->FAlerta_model->alerta_controle($id_usuario, $id_change, $motivo, $acao);
				$this->FConsultas_model->mensagem('success', 'Sucesso!', ['Troca de Função!']);
			}
		} else if ($funcao_atiga == 'supervisor' && $funcao_nova == 'lider') { // ok
			$id_troca_1 = $this->input->post('id_troca_1'); // novo supervisor
			$id_troca_2 = $this->input->post('id_troca_2'); // novo coordenador

			$dados_do_supervisor = $this->Supervisores->infos([$id_change], 'info_supervisor', '', '');

			if ($dados_do_supervisor['row'] == 0) {
				$red = $red_erro;
				$this->FConsultas_model->mensagem('danger', 'Erro!', ['Dados do Supervisor não Encontrado!']);
			} else {
				$dados_supervisor = $dados_do_supervisor['dados'];

				// check se já tem algum lider está cadastrado
				$liderjacadastrado = $this->Lideres->infos([$dados_supervisor['email'], $dados_supervisor['nome_supervisorR'], $dados_supervisor['nascimento']], 'info_lider_nome_email_data_nascimento', '', '');

				// cadastro lider
				if ($liderjacadastrado['row'] == 0) {
					$this->Lideres->cadastro_lider_2($dados_supervisor['nome_supervisorR'], $dados_supervisor['cpf'], $dados_supervisor['email'], $dados_supervisor['telefone_whatsapp'], "", $dados_supervisor['nascimento'], 2000, $dados_supervisor['pais'], $dados_supervisor['estado'], $dados_supervisor['cidade'], $id_troca_2, $id_troca_1, $id_troca_1, 2, $dados_supervisor['foto']);
				}

				// atualizar o nível do usuário
				$dadosusuario = $this->Lideres->infos([$dados_supervisor['email'], $dados_supervisor['cpf'], $dados_supervisor['nome_supervisorR']], 'info_usuario_and_email_cpf_nome', '', '');

				$lider_novo = $this->Lideres->infos([$dados_supervisor['email'], $dados_supervisor['nome_supervisorR'], $dados_supervisor['nascimento']], 'info_lider_nome_email_data_nascimento', '', '');

				if ($lider_novo['row'] == 0) {
					$red = $red_erro;
				} else {
					$this->Lideres->editar_usuario_nivel($dadosusuario['dados']['id_usuario'], 1);

					// apagar o supervisor
					$this->Supervisores->delete_supervisor_local_id($id_change);

					$id_lider_novo = $lider_novo['dados']['id_coordenador'];

					$this->Lideres->trocar_supervisao_do_lider($id_change, $id_troca_1);
					$this->Coordenadores->trocar_supervisao_do_coordenador($id_change, $id_troca_1);

					// atualizazr PG
					$this->PG->trocar_lideranca_pg_2($id_change, $id_lider_novo);
					// atualizar relatório
					$this->PG->editar_lideranca_relatorio_2($id_change, $id_lider_novo);
					// atualizar criancas
					$this->Criancas->editar_liderenca_crianca_2($id_change, $id_lider_novo);

					$red = "https://sistemas.campbrasil.com/sistema/direcao/page/lider/$id_lider_novo";
				}

				$motivo = "O $nome_usuario efetuou troca de função do supervisor $nome (id: $id_change) para lider. Coordenadores e Líderes passarão para essa supervisão: $id_troca_1";
				$acao = "TROCA_SUPERVISOR_TO_LIDER";

				$this->FAlerta_model->alerta_controle($id_usuario, $id_troca_1, $motivo, $acao);
				$this->FAlerta_model->alerta_controle($id_usuario, $id_change, $motivo, $acao);
				$this->FConsultas_model->mensagem('success', 'Sucesso!', ['Troca de Função!']);
			}
		} else if ($funcao_atiga == 'coordenador' && $funcao_nova == 'lider') {
			$id_troca = $this->input->post('id_troca'); // novo supervisor

			$dados_do_coordenador = $this->Coordenadores->infos([$id_change], 'info_coordenador', '', '');

			if ($dados_do_coordenador['row'] == 0) {
				$red = $red_erro;
				$this->FConsultas_model->mensagem('danger', 'Erro!', ['Dados do Coordenador não Encontrado!']);
			} else {
				$dados_coordenador = $dados_do_coordenador['dados'];

				// check se já tem algum lider está cadastrado
				$liderjacadastrado = $this->Lideres->infos([$dados_coordenador['email'], $dados_coordenador['nome_coordenador'], $dados_coordenador['nascimento']], 'info_lider_nome_email_data_nascimento', '', datas: '');

				// cadastro lider
				if ($liderjacadastrado['row'] == 0) {
					$this->Lideres->cadastro_lider_2($dados_coordenador['nome_coordenador'], $dados_coordenador['cpf'], $dados_coordenador['email'], $dados_coordenador['telefone_whatsapp'], "", $dados_coordenador['nascimento'], 2000, $dados_coordenador['pais'], $dados_coordenador['estado'], $dados_coordenador['cidade'], $id_troca, $dados_coordenador['id_supervisorR'], $dados_coordenador['id_supervisorR'], 2, $dados_coordenador['foto']);
				}

				// atualizar o nível do usuário
				$dadosusuario = $this->Lideres->infos([$dados_coordenador['email'], $dados_coordenador['cpf'], $dados_coordenador['nome_coordenador']], 'info_usuario_and_email_cpf_nome', '', '');

				$lider_novo = $this->Lideres->infos([$dados_coordenador['email'], $dados_coordenador['nome_coordenador'], $dados_coordenador['nascimento']], 'info_lider_nome_email_data_nascimento', '', datas: '');

				if ($lider_novo['row'] == 0) {
					$red = $red_erro;
				} else {
					$this->Lideres->editar_usuario_nivel($dadosusuario['dados']['id_usuario'], 1);

					// apagar o supervisor
					$this->Coordenadores->delete_coordenador_id($id_change);

					$id_lider_novo = $lider_novo['dados']['id_coordenador'];

					$this->Lideres->trocar_coordenacao_do_lider($id_change, $id_troca);

					// atualizazr PG
					$this->PG->trocar_lideranca_pg_2($id_change, $id_lider_novo);
					// atualizar relatório
					$this->PG->editar_lideranca_relatorio_2($id_change, $id_lider_novo);
					// atualizar criancas
					$this->Criancas->editar_liderenca_crianca_2($id_change, $id_lider_novo);

					$red = "https://sistemas.campbrasil.com/sistema/direcao/page/lider/$id_lider_novo";
				}

				$motivo = "O $nome_usuario efetuou troca de função do coordenador $nome (id: $id_change) para lider. Líderes passarão para essa coordenador: $id_troca";
				$acao = "TROCA_COORDENADOR_TO_LIDER";

				$this->FAlerta_model->alerta_controle($id_usuario, $id_troca, $motivo, $acao);
				$this->FAlerta_model->alerta_controle($id_usuario, $id_change, $motivo, $acao);
				$this->FConsultas_model->mensagem('success', 'Sucesso!', ['Troca de Função!']);
			}
		} else if ($funcao_atiga == 'coordenador' && $funcao_nova == 'supervisor') {
			$id_troca = $this->input->post('ids_coordenadores'); // coordenadores para adicionar a nova coordenação
			$lista_ids = explode(",", $id_troca);

			$dados_do_coordenador = $this->Coordenadores->infos([$id_change], 'info_coordenador', '', '');

			if ($dados_do_coordenador['row'] == 0) {
				$red = $red_erro;
				$this->FConsultas_model->mensagem('danger', 'Erro!', ['Dados do Coordenador não Encontrado!']);
			} else {
				$dados_coordenador = $dados_do_coordenador['dados'];

				// check se já tem algum supervisor está cadastrado
				$supervisorjacadastrado = $this->Supervisores->infos([$dados_coordenador['email'], $dados_coordenador['cpf'], $dados_coordenador['nome_coordenador']], 'info_supervisor_and_email_cpf_nome', '', '');

				// cadastro supervisor
				if ($supervisorjacadastrado['row'] == 0) {
					$this->Supervisores->cadastro_supervisor_2($dados_coordenador['nome_coordenador'], $dados_coordenador['cpf'], $dados_coordenador['email'], $dados_coordenador['telefone_whatsapp'], $dados_coordenador['nascimento'], $dados_coordenador['pais'], $dados_coordenador['estado'], $dados_coordenador['cidade'], 1, $dados_coordenador['foto']);
				}

				// consultar informações na tabela USUÁRIO
				$dadosusuario = $this->Lideres->infos([$dados_coordenador['email'], $dados_coordenador['cpf'], $dados_coordenador['nome_coordenador']], 'info_usuario_and_email_cpf_nome', '', '');

				$supervisor_novo = $this->Supervisores->infos([$dados_coordenador['email'], $dados_coordenador['cpf'], $dados_coordenador['nome_coordenador']], 'info_supervisor_and_email_cpf_nome', '', datas: '');

				if ($supervisor_novo['row'] == 0) {
					$red = $red_erro;
				} else {
					$this->Lideres->editar_usuario_nivel($dadosusuario['dados']['id_usuario'], 4);

					// apagar o supervisor
					$this->Coordenadores->delete_coordenador_id($id_change);

					$id_supervisor_novo = $supervisor_novo['dados']['id_supervisorR'];

					// Agora você pode percorrer cada ID
					foreach ($lista_ids as $id) {
						// trocando os coordenadores para a supervisão
						$this->Coordenadores->trocar_supervisao_do_coordenador_especifico($id, $id_supervisor_novo);

						// trocando os lideres para a nova supervisão
						$this->Lideres->trocar_supervisao_de_lideres_coordenador_especifico($id, $id_supervisor_novo);
					}

					// atualizazr PG
					$this->PG->trocar_lideranca_pg_2($id_change, $id_supervisor_novo);
					// atualizar relatório
					$this->PG->editar_lideranca_relatorio_2($id_change, $id_supervisor_novo);
					// atualizar criancas
					$this->Criancas->editar_liderenca_crianca_2($id_change, $id_supervisor_novo);

					$red = "https://sistemas.campbrasil.com/sistema/direcao/page/supervisor/$id_supervisor_novo";
				}

				$motivo = "O $nome_usuario efetuou troca de função do coordenador $nome (id: $id_change) para lider. Líderes passarão para essa coordenador: $id_troca";
				$acao = "TROCA_COORDENADOR_TO_LIDER";

				$this->FAlerta_model->alerta_controle($id_usuario, $id_troca, $motivo, $acao);
				$this->FAlerta_model->alerta_controle($id_usuario, $id_change, $motivo, $acao);
				$this->FConsultas_model->mensagem('success', 'Sucesso!', ['Troca de Função!']);
			}
		} else if ($funcao_atiga == 'lider' && $funcao_nova == 'coordenador') { // ok
			$id_troca = $this->input->post('ids_lideres'); // coordenadores para adicionar a nova coordenação
			$lista_ids = explode(",", $id_troca);

			$dados_do_lider = $this->Lideres->infos([$id_change], 'info_lider', '', '');

			if ($dados_do_lider['row'] == 0) {
				$red = $red_erro;
				$this->FConsultas_model->mensagem('danger', 'Erro!', ['Dados do Líder não Encontrado!']);
			} else {
				$dados_lider = $dados_do_lider['dados'];

				// check se já tem algum coordenador cadastrado
				$coordenadorjacadastrado = $this->Coordenadores->infos([$dados_lider['email'], $dados_lider['nome_lider'], $dados_lider['nascimento']], 'info_coordenador_nome_email_data_nascimento', '', '');

				// cadastro supervisor
				if ($coordenadorjacadastrado['row'] == 0) {
					$this->Coordenadores->cadastro_coordenador_2($dados_lider['nome_lider'], $dados_lider['cpf'], $dados_lider['email'], $dados_lider['telefone_whatsapp'], $dados_lider['nascimento'], $dados_lider['pais'], $dados_lider['estado'], $dados_lider['cidade'], $dados_lider['id_supervisorR'], 1, $dados_lider['foto']);
				}

				// consultar informações na tabela USUÁRIO
				$dadosusuario = $this->Lideres->infos([$dados_lider['email'], $dados_lider['cpf'], $dados_lider['nome_lider']], 'info_usuario_and_email_cpf_nome', '', '');

				$coordenador_novo = $this->Coordenadores->infos([$dados_lider['email'], $dados_lider['nome_lider'], $dados_lider['nascimento']], 'info_coordenador_nome_email_data_nascimento', '', datas: '');

				if ($coordenador_novo['row'] == 0) {
					$red = $red_erro;
				} else {
					$this->Lideres->editar_usuario_nivel($dadosusuario['dados']['id_usuario'], nivel: 3);

					// apagar o supervisor
					$this->Lideres->delete_lider_id($id_change);

					$id_coordenador_novo = $coordenador_novo['dados']['id_coordenador'];

					// Agora você pode percorrer cada ID
					foreach ($lista_ids as $id) {
						// trocando os lideres para a nova coordenação
						$this->Lideres->trocar_coordenacao_do_lider_especifico($id, $id_coordenador_novo);
					}

					// atualizazr PG
					$this->PG->trocar_lideranca_pg_2($id_change, $id_coordenador_novo);
					// atualizar relatório
					$this->PG->editar_lideranca_relatorio_2($id_change, $id_coordenador_novo);
					// atualizar criancas
					$this->Criancas->editar_liderenca_crianca_2($id_change, $id_coordenador_novo);

					$red = "https://sistemas.campbrasil.com/sistema/direcao/page/supervisor/coordenador/lideres/$id_coordenador_novo";
				}

				$motivo = "O $nome_usuario efetuou troca de função do lider $nome (id: $id_change) para coordenador. Líderes passaram para essa coordenador: $id_troca";
				$acao = "TROCA_LIDER_TO_COORDENADOR";

				$this->FAlerta_model->alerta_controle($id_usuario, $id_troca, $motivo, $acao);
				$this->FAlerta_model->alerta_controle($id_usuario, $id_change, $motivo, $acao);
				$this->FConsultas_model->mensagem('success', 'Sucesso!', ['Troca de Função!']);
			}
		} else if ($funcao_atiga == 'lider' && $funcao_nova == 'supervisor') { // ok
			$id_troca = $this->input->post('ids_coordenadores'); // coordenadores para adicionar a nova coordenação
			$lista_ids = explode(",", $id_troca);

			$dados_do_lider = $this->Lideres->infos([$id_change], 'info_lider', '', '');

			if ($dados_do_lider['row'] == 0) {
				$red = $red_erro;
				$this->FConsultas_model->mensagem('danger', 'Erro!', ['Dados do Líder não Encontrado!']);
			} else {
				$dados_lider = $dados_do_lider['dados'];

				// check se já tem algum supervisor cadastrado
				$supervisorjacadastrado = $this->Supervisores->infos([$dados_lider['email'], $dados_lider['cpf'], $dados_lider['nome_lider']], 'info_supervisor_and_email_cpf_nome', '', '');

				// cadastro supervisor
				if ($supervisorjacadastrado['row'] == 0) {
					$this->Supervisores->cadastro_supervisor_2($dados_lider['nome_lider'], $dados_lider['cpf'], $dados_lider['email'], $dados_lider['telefone_whatsapp'], $dados_lider['nascimento'], $dados_lider['pais'], $dados_lider['estado'], $dados_lider['cidade'], 1, $dados_lider['foto']);
				}

				// consultar informações na tabela USUÁRIO
				$dadosusuario = $this->Lideres->infos([$dados_lider['email'], $dados_lider['cpf'], $dados_lider['nome_lider']], 'info_usuario_and_email_cpf_nome', '', '');

				$supervisor_novo = $this->Supervisores->infos([$dados_lider['email'], $dados_lider['cpf'], $dados_lider['nome_lider']], 'info_supervisor_and_email_cpf_nome', '', '');

				if ($supervisor_novo['row'] == 0) {
					$red = $red_erro;
				} else {
					$this->Lideres->editar_usuario_nivel($dadosusuario['dados']['id_usuario'], nivel: 4);

					// apagar o supervisor
					$this->Lideres->delete_lider_id($id_change);

					$id_supervisor_novo = $supervisor_novo['dados']['id_supervisorR'];

					// Agora você pode percorrer cada ID
					foreach ($lista_ids as $id) {
						// trocando os lideres para a nova coordenação
						$this->Coordenadores->trocar_supervisao_do_coordenador_especifico($id, $id_supervisor_novo);
						// trocando os lideres para a nova coordenação
						$this->Lideres->trocar_supervisao_de_lideres_coordenador_especifico($id, $id_supervisor_novo);
					}

					// atualizazr PG
					$this->PG->trocar_lideranca_pg_2($id_change, $id_supervisor_novo);
					// atualizar relatório
					$this->PG->editar_lideranca_relatorio_2($id_change, $id_supervisor_novo);
					// atualizar criancas
					$this->Criancas->editar_liderenca_crianca_2($id_change, $id_supervisor_novo);

					$red = "https://sistemas.campbrasil.com/sistema/direcao/page/supervisor/$id_supervisor_novo";
				}

				$motivo = "O $nome_usuario efetuou troca de função do lider $nome (id: $id_change) para supervisor. Coordenadores passaram para essa supervisão: $id_troca";
				$acao = "TROCA_LIDER_TO_SUPERVISOR";

				$this->FAlerta_model->alerta_controle($id_usuario, $id_troca, $motivo, $acao);
				$this->FAlerta_model->alerta_controle($id_usuario, $id_change, $motivo, $acao);
				$this->FConsultas_model->mensagem('success', 'Sucesso!', ['Troca de Função!']);
			}
		}

		$funcao = $this->FConsultas_model->red("$red", 3000, []);
		echo $funcao;
	}
}
