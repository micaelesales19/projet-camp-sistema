<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property $input
 * @property FAlerta_model $FAlerta_model
 * @property FConsultas_model $FConsultas_model
 * @property FSistema_model $FSistema_model
 * @property $db
 * @property $email
 * @property $upload
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
	}

	public function offline()
	{
		$dados = array(
			'heading' => 'Você está Offline',
			'message' => 'Conect a internet e tente novamente',
		);

		$this->load->view('errors/html/error_404', $dados);
	}

	public function cadastro()
	{
		$this->load->view('sistema/cadastro');
	}

	// Colíderes
	public function cadastro_colider()
	{
		$idLider = $this->input->post('idLider');
		$nomeColider = $this->input->post('nomeColider');
		$emailColider = $this->input->post('emailColider');
		$cpfColider = $this->input->post('cpfColider');
		$telefoneColider = $this->input->post('telefoneColider');
		$nascimentoColider = $this->input->post('nascimentoColider');

		$consultarColider = $this->FConsultas_model->checkColider($nomeColider, $cpfColider, $emailColider, $telefoneColider);

		$red = $this->input->post('red') ?? 'pagina_editar_pessoal';
		$routa = "";

		if ($red == 'pagina_editar_pessoal') {
			$data = [];
			$routa = "../pagina_editar_pessoal";
		} else if ($red == 'lideres/detalhes') {
			$data = [];
			$routa = "../../page/lideres/detalhes/$idLider";
		} else {
			$data = [];
			$routa = "../pagina_editar_pessoal";
		}

		if ($consultarColider) {
			$cadastroColider = $this->FSistema_model->cadastrarColider($idLider, $nomeColider, $cpfColider, $emailColider, $telefoneColider, $nascimentoColider);

			if ($cadastroColider) {
				$this->FConsultas_model->mensagem('success', 'Sucesso!', ['Cadastro Relizado com Sucesso!']);
				$funcao = $this->FConsultas_model->red("$routa", 2000, $data);
				echo $funcao;
			} else {
				$this->FConsultas_model->mensagem('danger', 'Erro!', ['Tente Novamente!']);
				$funcao = $this->FConsultas_model->red("$routa", 2000, $data);
				echo $funcao;
			}
		} else {
			$this->FConsultas_model->mensagem('danger', 'Erro!', ['Colíder já cadastrado']);
			$funcao = $this->FConsultas_model->red("$routa", 2000, $data);
			echo $funcao;
		}
	}

	public function desativar_colider()
	{
		$idLider = $this->input->post("idLider");
		$idColider = $this->input->post("idColider");
		$nomeColider = $this->input->post("nomeColider");

		$idResponsavel = $this->input->post("idResponsavel");
		$motivo = $this->input->post("motivo");

		$reativar = $this->FSistema_model->excluirColider($idColider, $nomeColider, $idLider, $idResponsavel, $motivo);

		$red = $this->input->post('red') ?? 'pagina_editar_pessoal';
		$routa = "";

		if ($red == 'pagina_editar_pessoal') {
			$data = [];
			$routa = "../pagina_editar_pessoal";
		} else if ($red == 'lideres/detalhes') {
			$data = [];
			$routa = "../page/lideres/detalhes/$idLider";
		} else {
			$data = [];
			$routa = "../pagina_editar_pessoal";
		}

		if ($reativar) {
			$this->FConsultas_model->mensagem('success', 'Sucesso!', ['Atenção! Colíder Desativado com Sucesso!']);
			$funcao = $this->FConsultas_model->red("$routa", 2000, $data);
			echo $funcao;
		} else {
			$this->FConsultas_model->mensagem('danger', 'Erro!', ['Tente Novamente!']);
			$funcao = $this->FConsultas_model->red("$routa", 2000, $data);
			echo $funcao;
		}
	}

	public function ativar_colider()
	{
		$idLider = $this->input->post("idLider");
		$idColider = $this->input->post("opc");

		$reativar = $this->FSistema_model->reativarColider($idColider, $idLider);

		$red = $this->input->post('red') ?? 'pagina_editar_pessoal';
		$routa = "";

		if ($red == 'pagina_editar_pessoal') {
			$data = [];
			$routa = "../pagina_editar_pessoal";
		} else if ($red == 'lideres/detalhes') {
			$data = [];
			$routa = "../page/lideres/detalhes/$idLider";
		} else {
			$data = [];
			$routa = "../pagina_editar_pessoal";
		}

		if ($reativar) {
			$this->FConsultas_model->mensagem('success', 'Sucesso!', ['Atenção! Colíder Ativado com Sucesso!']);
			$funcao = $this->FConsultas_model->red("$routa", 2000, $data);
			echo $funcao;
		} else {
			$this->FConsultas_model->mensagem('danger', 'Erro!', ['Tente Novamente!']);
			$funcao = $this->FConsultas_model->red("$routa", 2000, $data);
			echo $funcao;
		}
	}

	public function excluir_colider_permanentemente()
	{
		$idLider = $this->input->post("idLider");
		$idUsuario = $this->input->post("idUsuario");
		$id_colider = $this->input->post("opc");

		$excluir = $this->FSistema_model->excluirColiderPermanentemente($id_colider, $idLider, $idUsuario);

		$red = $this->input->post('red') ?? 'pagina_editar_pessoal';

		$routa = "";
		if ($red == 'pagina_editar_pessoal') {
			$data = [];
			$routa = "../../pagina_editar_pessoal";
		} else if ($red == 'lideres/detalhes') {
			$data = [];
			$routa = "../../page/lideres/detalhes/$idLider";
		} else {
			$data = [];
			$routa = "../../pagina_editar_pessoal";
		}

		if ($excluir) {
			$this->FConsultas_model->mensagem('success', 'Sucesso!', ["Atenção! Colíder Excluido Permanentemente!"]);
			$funcao = $this->FConsultas_model->red("$routa", 2000, $data);
			echo $funcao;
		} else {
			$this->FConsultas_model->mensagem('danger', 'Erro!', ["Tente novamente!"]);
			$funcao = $this->FConsultas_model->red("$routa", 2000, $data);
			echo $funcao;
		}
	}

	public function listar_lideres_segundo_ciclo()
	{

		$consultar_pg = $this->db->query("SELECT * FROM pg WHERE ano = 2");
		$resultado = $consultar_pg->result_array();

		foreach ($resultado as $key => $pg) {
			$id_lider = $pg['id_lider'];

			$consultar_dados_lideres = $this->db->query("SELECT * FROM lider WHERE id_lider = $id_lider");
			$count_lideres = $consultar_dados_lideres->num_rows();
			$lideres = $consultar_dados_lideres->row_array();

			$consultar_dados_coordenador = $this->db->query("SELECT * FROM coordenador WHERE id_coordenador = $id_lider");
			$count_coordenador = $consultar_dados_coordenador->num_rows();
			$coordenador = $consultar_dados_coordenador->row_array();

			$consultar_dados_sr = $this->db->query("SELECT * FROM supervisorr WHERE id_supervisorR = $id_lider");
			$count_sr = $consultar_dados_sr->num_rows();
			$sr = $consultar_dados_sr->row_array();

			$consultar_dados_se = $this->db->query("SELECT * FROM supervisore WHERE id_supervisorEs = $id_lider");
			$count_se = $consultar_dados_se->num_rows();
			$se = $consultar_dados_se->row_array();

			$consultar_dados_criancas = $this->db->query("SELECT * FROM crianca WHERE lider = $id_lider");
			$count_criancas = $consultar_dados_criancas->num_rows();

			if ($count_lideres != 0) {
				echo $lideres['nome_lider'] . "(lider) Crianças: " . $count_criancas . " Módulo: " . $pg['id_modulo'] . "/" . $pg['n_licao'] . "<br>";
			} else if ($count_coordenador != 0) {
				echo $coordenador['nome_coordenador'] . "(coordenador) Crianças: " . $count_criancas . " Módulo: " . $pg['id_modulo'] . "/" . $pg['n_licao'] . "<br>";
			} else if ($count_sr != 0) {
				echo $sr['nome_supervisorR'] . "(sr) Crianças: " . $count_criancas . " Módulo: " . $pg['id_modulo'] . "/" . $pg['n_licao'] . "<br>";
			} else if ($count_se != 0) {
				echo $se['nome_supervisorE'] . "(se) Crianças: " . $count_criancas . " Módulo: " . $pg['id_modulo'] . "/" . $pg['n_licao'] . "<br>";
			}
		}
	}

	public function enviarEmailDevocionalDiario()
	{
		$todosPais = $this->FConsultas_model->mostrarTodosPais();

		$dataHj = date('m/d/Y');

		$hora = date('H');

		if ($hora >= 7 && $hora <= 21) {
			$controller = 0;
			foreach ($todosPais as $key => $pais) {

				$id = $pais['id'];
				$email = $pais['email'];
				$todosPG = $this->FConsultas_model->mostrarPG($id, 1);

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
											$this->FSistema_model->controlerDevocionais($id, $idPg, $anoPg, $modulo, $licao, $diaDevocional, 1);
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
		$todosPais = $this->FConsultas_model->mostrarTodosPais();

		$dataHj = date('m/d/Y');

		foreach ($todosPais as $key => $pais) {
			$id = $pais['id'];

			$todosPG = $this->FConsultas_model->mostrarPG($id, 1);

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

							$this->FSistema_model->editarPGProgressoData($id_pg, $anoNovo, $moduloNovo, $licaoNova, $data_envio, 1);
						} else {
						}
					}
				}
			}
		}
	}
	public function atualizarModuloMensal()
	{
		$todosPais = $this->FConsultas_model->mostrarTodosPais();

		$dataHj = date('m/d/Y');

		foreach ($todosPais as $key => $pais) {
			$id = $pais['id'];

			$todosPG = $this->FConsultas_model->mostrarPG($id, 1);

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
								$this->FSistema_model->editarAtivo($id_pg, $id, 1);
							} else {
							}
						} else {
						}
					}
				}
			}
		}
	}
	public function salvar_cadastro()
	{
		$nome = $this->input->post('nome');
		$cpf = $this->input->post('cpf');
		$email = $this->input->post('email');
		$telefone = $this->input->post('telefone');
		$igreja = $this->input->post('igreja');
		$pais = $this->input->post('pais');
		$estado1 = $this->input->post('estados');
		$cidade1 = $this->input->post('cidades');
		$estado2 = $this->input->post('estados2');
		$cidade2 = $this->input->post('cidades2');
		$nascimento = $this->input->post('nascimento');

		$estado = "";
		$cidade = "";

		// Colider
		$isColider = $this->input->post('isColider');
		$nomeColider = $this->input->post('nomeColider');
		$cpfColider = $this->input->post('cpfColider');
		$emailColider = $this->input->post('emailColider');
		$telefoneColider = $this->input->post('telefoneColider');
		$nascimentoColider = $this->input->post('nascimentoColider');

		if ($estado1 == "" and $cidade1 == "") {
			$estado .= $estado2;
			$cidade .= $cidade2;
		} else {
			$estado .= $estado1;
			$cidade .= $cidade1;
		}

		$ponto1 = $cpf[3];

		$cpf_completo = "";

		if ($ponto1 == ".") {
			$cpf_completo .= $cpf;
		} else {
			$cpf_completo .= $cpf[0] . $cpf[1] . $cpf[2] . "." . $cpf[3] . $cpf[4] . $cpf[5] . "." . $cpf[6] . $cpf[7] . $cpf[8] . "-" . $cpf[9] . $cpf[10];
		}

		//if ($this->FAlerta_model->valida_cpf($cpf) or $this->FAlerta_model->validaNIF($cpf)) {
		if ($this->FAlerta_model->ValidaData($nascimento)) {
			$consultarPais = $this->FConsultas_model->consultaraisJaCadastrado($nome, $cpf, $cpf_completo, $email);
			$consultarUsuario = $this->FConsultas_model->consultarUsuarioCadastrado($nome, $cpf,  $cpf_completo, $email);

			if ($consultarPais || $consultarUsuario) {

				$consultarTreinamento = $this->FConsultas_model->consultaraisJaTerminouOTreinamento($nome, $email, $nascimento);

				if (!$consultarTreinamento) {
					$supervisor = $this->FConsultas_model->selecionarSupervisorEstado($estado);
					$id_supervisor = $supervisor['id_supervisor'];
					$nome_supervisor = $supervisor['nome_supervisor'];
					$emailSupervisor = $supervisor['email'];
					$nivel = 8;
					$cadastro = $this->FSistema_model->cadastro_pais($nome, $cpf_completo, $email, $telefone, $igreja, $nascimento, $pais, $estado, $cidade, $id_supervisor);
					$cadastroUsuario = $this->FSistema_model->cadastrarUsuário($nome, $email, $cpf_completo, $nivel);
					if ($cadastro && $cadastroUsuario) {
						if ($isColider == '') {
						} else {
							$consultarDados = $this->FConsultas_model->consultaDadosPaisNomeCPFEMail($nome, $cpf, $cpf_completo, $email);
							$id_lider = $consultarDados['id'];
							$this->FSistema_model->cadastrarColider($id_lider, $nomeColider, $cpfColider, $emailColider, $telefoneColider, $nascimentoColider);
						}
						$this->FSistema_model->enviarEmailSupervisor($emailSupervisor, $nome_supervisor, $nome, $email, $telefone, $estado, $cidade);
						echo '
								<script>
									if(window.confirm("Sucesso!")) {
										window.location="https://sistema.campbrasil.com/";
									}else{
										window.location="https://sistema.campbrasil.com/";
									}
								</script>
							';
					} else {
						echo '
								<script>
									if(window.confirm("Erro, tente novamente!")) {
										window.location="https://sistema.campbrasil.com/sistema/pais/cadastro";
									}else{
										window.location="https://sistema.campbrasil.com/sistema/pais/cadastro";
									}
								</script>
							';
					}
				} else {
					echo '
							<script>
								if(window.confirm("Você não terminou o treinamento para pais!")) {
									window.location="https://treinamento.campbrasil.com/";
								}else{
									window.location="https://treinamento.campbrasil.com/";
								}
							</script>
						';
				}
			} else {
				echo '
						<script>
							if(window.confirm("Você já está cadastrado!")) {
								window.location="https://sistema.campbrasil.com/";
							}else{
								window.location="https://sistema.campbrasil.com/";
							}
						</script>
					';
			}
		} else {
			echo '
					<script>
						if(window.confirm("Erro, data de nascimento inválida!")) {
							window.location="https://sistema.campbrasil.com/sistema/pais/cadastro";
						}else{
							window.location="https://sistema.campbrasil.com/sistema/pais/cadastro";
						}
					</script>
				';
		}
		/*} else {
			echo '
				<script>
					if(window.confirm("Erro, CPF inválido!")) {
						window.location="https://sistema.campbrasil.com/sistema/pais/cadastro";
					}else{
						window.location="https://sistema.campbrasil.com/sistema/pais/cadastro";
					}
				</script>
			';
		}*/
	}
	public function index()
	{
		$x = $this->input->get('x');
		$dados = array('x' => $x);

		$this->load->view('sistema/page_login', $dados);
	}
	public function login()
	{
		$x = $this->input->get('x');
		$dados = array('x' => $x);

		$this->load->view('sistema/page_login', $dados);
	}

	public function autenticacao_login()
	{
		$email = $this->input->post('email');
		$cpf = $this->input->post('cpf');

		$nome = $this->input->post('nome');
		$senha = $this->input->post('senha');

		$x = $this->input->post('x_ir');

		$opc = $this->input->post('opc');

		if ($email == '' && $cpf == '' && $nome == '' && $senha == '') {
			echo "Dados Vazios";
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
				$consultar = $this->db->query("SELECT * FROM usuario WHERE email = '$email' AND (cpf = '$cpf' OR cpf = '$cpf_completo')");
				$dados = $consultar->row_array();
				$total = $consultar->num_rows();
			} else if ($opc == 2 || $opc == 4) {
				$consultar = $this->db->query("SELECT * FROM usuario WHERE email = '$email' AND senha = '$senha'");
				$dados = $consultar->row_array();
				$total = $consultar->num_rows();
			} else if ($opc == 3) {
				$consultar = $this->db->query("SELECT * FROM usuario WHERE nome LIKE '$nome%' AND senha = '$senha'");
				$dados = $consultar->row_array();
				$total = $consultar->num_rows();
			} else {
			}

			if ($total == 0) {
				echo "Dados Inválidos";
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

				$consultar_lider = $this->db->query("SELECT * FROM lider WHERE email = '$email' AND cpf = '$cpf_completo' AND (nome_lider LIKE '$nome' OR nome_lider LIKE '$nome_base')");
				$dados_lider = $consultar_lider->row_array();
				$total_lider = $consultar_lider->num_rows();

				$consultar_pais = $this->db->query("SELECT * FROM pais WHERE (email = '$email' OR cpf = '$cpf_completo') AND  (nome LIKE '$nome' OR nome LIKE '$nome_base')");
				$dados_pais = $consultar_pais->row_array();
				$total_pais = $consultar_pais->num_rows();

				$consultar_coordenador = $this->db->query("SELECT * FROM coordenador WHERE (email = '$email' OR cpf = '$cpf_completo') AND  (nome_coordenador LIKE '$nome' OR nome_coordenador LIKE '$nome_base')");
				$dados_coordenador = $consultar_coordenador->row_array();
				$total_coordenador = $consultar_coordenador->num_rows();

				$consultar_adm = $this->db->query("SELECT * FROM direcao WHERE email = '$email' AND cpf = '$cpf_completo' AND (nome_direcao LIKE '$nome' OR nome_direcao LIKE '$nome_base')");
				$dados_adm = $consultar_adm->row_array();
				$total_adm = $consultar_adm->num_rows();

				if ($nivel == 1) {
					if ($total_lider == 0) {
						echo "Não foi encontrado seus dados em nossas bases! Entre em contato com o suporte pelo e-mail campbrasilemail@gmail.com";
						$data = [
							"<input type='hidden' name='x' value='$x'>"
						];
						$funcao = $this->FConsultas_model->red('index', 2000, $data);
						echo $funcao;
					} else {
						echo "Bem Vindo - " . $dados['nome'];

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

							/*echo '
								<script>
									setTimeout(function(){ window.location="termos?nivel=1"}, 2000);
								</script>
							';*/
						} else {
							if ($x == 1) {

								$data = [];
								$funcao = $this->FConsultas_model->red('lider/home', 2000, $data);
								echo $funcao;

								/*echo '
									<script>
										setTimeout(function(){ window.location="lider/home"}, 3000);
									</script>
								';*/
							}
						}
					}
				} else if ($nivel == 6) { //admin
					if ($total_adm == 0) {
						echo "Não foi encontrado seus dados em nossas bases! Entre em contato com o suporte pelo e-mail campbrasilemail@gmail.com";
						echo '
						<script>
							setTimeout(function(){ window.location="index?x=' . $x . '" }, 3000);
						</script>
					';
					} else {
						echo "Bem Vindo - " . $dados['nome'];
						$_SESSION['id_usuario'] .= $dados_adm['id_direcao'];
						$_SESSION['id_usuario_2'] .= $id_usuario;

						echo '
						<script>
							setTimeout(function(){ window.location="adm/home"}, 2000);
						</script>
					';
					}
				} else if ($nivel == 8) { // pais
					if ($total_pais == 0) {
						echo "Não foi encontrado seus dados em nossas bases! Entre em contato com o suporte pelo e-mail campbrasilemail@gmail.com";
						$data = [
							"<input type='hidden' name='x' value='$x'>"
						];
						$funcao = $this->FConsultas_model->red('index', 2000, $data);
						echo $funcao;
					} else {
						echo "Bem Vindo - " . $dados['nome'];
						$_SESSION['id_usuario'] .= $dados_pais['id'];
						$_SESSION['id_usuario_2'] .= $id_usuario;

						$consultar_termos = $this->db->select("*")
							->from("termos")
							->where("id_usuario", $id_usuario)
							->get();
						$termos = $consultar_termos->num_rows();

						if ($termos == 0) {
							/*echo '
								<script>
									setTimeout(function(){ window.location="termos?nivel=8"}, 2000);
								</script>
							';*/
							$data = [
								"<input type='hidden' name='nivel' value='8'>"
							];
							$funcao = $this->FConsultas_model->red('termos', 2000, $data);
							echo $funcao;
						} else {
							if ($x == 1) {
								$data = [];
								$funcao = $this->FConsultas_model->red('pais/home', 2000, $data);
								echo $funcao;
							}
						}
					}
				} else if ($nivel == 3) { // coordenador
					if ($total_coordenador == 0) {
						echo "Não foi encontrado seus dados em nossas bases! Entre em contato com o suporte pelo e-mail campbrasilemail@gmail.com";
						$data = [
							"<input type='hidden' name='x' value='$x'>"
						];
						$funcao = $this->FConsultas_model->red('index', 2000, $data);
						echo $funcao;
					} else {
						echo "Bem Vindo - " . $dados['nome'];
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
				}
			}
		}
	}
	public function PaginaDosTermos()
	{
		$x = $this->input->post('x');
		$nivel = $this->input->post('nivel');
		$dados = array('nivel' => $nivel, 'x' => $x,);

		$this->load->view('sistema/termos', $dados);
	}

	public function PrimeiroAcesso()
	{
		$id_usuario = $this->input->post('id_usuario');
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
				$this->FSistema_model->aceitarTermos($id_usuario, $confimacao);
			}
		}

		if ($nivel == 8) {
			$consultarPG = $this->FConsultas_model->mostrarPG($id_usuario, 1);
			$consultaCriancas = $this->FConsultas_model->mostrarCriancasPais($id_usuario, 1);

			if ($consultarPG['row'] == 0 || $consultaCriancas['row'] == 0 || $check == 3) {
				$this->load->view('sistema/pais/primeiro_acesso');
			} else {
				$this->load->view('sistema/pais/home');
			}
		} else if ($nivel == 1) {
			$consultarPG = $this->FConsultas_model->mostrarPG($id_usuario, 2);
			$consultaCriancas = $this->FConsultas_model->mostrarCriancasPais($id_usuario, 2);

			if ($consultarPG['row'] == 0 || $consultaCriancas['row'] == 0 || $check == 3) {
				$this->load->view('sistema/lider/primeiro_acesso');
			} else {
				$this->load->view('sistema/lider/home');
			}
		} else if ($nivel == 3) {
			$this->load->view('sistema/coordenador/home');
		}
	}

	public function sair()
	{
		$id_usuario = $this->input->post("id_usuario");

		$ativo = 0;

		$this->db->set('ativo', $ativo);
		$this->db->where('id_usuario', $id_usuario);
		$this->db->update('usuario');

		echo "Fim de Sessão!!";
		echo '
			<script>
				setTimeout(function(){ window.location="index"}, 3000)
			</script>
		';
	}

	public function downloadMaterial()
	{
		$id = $this->input->post("id");
		$idLider = $this->input->post("id_lider");
		$idPg = $this->input->post("id_pg");
		$title = $this->input->post("title");
		$download = $this->input->post("download");

		$nivel = $this->input->post("nivel") == '' ? 1 : $this->input->post("nivel");
		$dataEscolhida = $this->input->post("data");

		$dadosPg = $this->FConsultas_model->mostrarPGId($idLider, $idPg, $nivel);

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

			$this->FSistema_model->editarData($idPg, $dataEscolhida, $data_fim, $dataEscolhida, $nivel);
		}

		if ($id == 4) {
			$nme = "$title.ppsx";
		} else {
			$nme = "$title.pdf";
		}

		$pth = file_get_contents(base_url() . $download);
		force_download($nme, $pth);
	}
	public function cadastro_crianca()
	{
		$nivel = $this->input->post("nivel") == '' ? 1 : $this->input->post("nivel");

		$total = $this->input->post('total');
		$lider = $this->input->post('id_lider');
		$nome = $this->input->post('nome');
		$id_pg = $this->input->post('id_pg');
		$nascimento = $this->input->post('nascimento');
		$obs = $this->input->post('obs');
		$opcao = $this->input->post('opcao');

		$responsavel_crianca = $this->input->post('responsavel_crianca');
		$nome_responsavel = $this->input->post('nome_responsavel');
		$email_responsavel = $this->input->post('email_responsavel');
		$telefone_responsavel = $this->input->post('telefone_responsavel');

		$dadosPais = $this->FConsultas_model->consultaDadosPaisId($lider, $nivel);

		$total_count = count($total);

		for ($i = 0; $i < $total_count; $i++) {

			$nascimento2 = $nascimento[$i];
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
				if ($nivel == 1) {
					$nomePai = $dadosPais['nome'];
					$emailPai = $dadosPais['email'];
					$telefonePai = $dadosPais['telefone_whatsapp'];
				} else if ($nivel == 2) {
					$nomePai = $dadosPais['nome_lider'];
					$emailPai = $dadosPais['email'];
					$telefonePai = $dadosPais['telefone_whatsapp'];
				}
			}

			$checkCriancas = $this->FConsultas_model->consultarCriancasNomeEIdade($nome2, $lider2, $id_pg2, $nascimento2, $opcao2, $obs2, $nomePai, $nivel);

			if ($checkCriancas) {
				$this->FSistema_model->cadastro_crianca($nome2, $nascimento2, $lider2, $id_pg2, $obs2, $opcao2, $nomePai, $emailPai, $telefonePai, $nivel);
			} else {
			}
		}

		/*echo '
			<script>
				window.location="../../criancas";
			</script>
		';*/

		$red = $this->input->post('red') ?? 'criancas';
		$routa = "";

		if ($red == 'criancas') {
			$data = [];
			$routa = "criancas";
		} else if ($red == 'lideres/detalhes') {
			$data = [
				"<input type='hidden' name='id_lider' value='$lider'>",
			];
			$routa = "lideres/detalhes/$lider";
		} else {
			$data = [];
			$routa = "criancas";
		}

		$this->FConsultas_model->mensagem('success', 'Sucesso!', ['Cadastro Relizado com Sucesso!']);
		$funcao = $this->FConsultas_model->red("../../$routa", 2000, $data);
		echo $funcao;
	}
	public function cadastro_crianca_inicial()
	{
		$total = $this->input->post('total');
		$lider = $this->input->post('id_lider');
		$nome = $this->input->post('nome');
		$id_pg = $this->input->post('id_pg');
		$nascimento = $this->input->post('nascimento');
		$obs = $this->input->post('obs');
		$opcao = $this->input->post('opcao');

		$nivel = $this->input->post('nivel');

		$nivel_2 = $this->input->post("nivel_2") == '' ? 1 : $this->input->post("nivel_2");

		$responsavel_crianca = $this->input->post('responsavel_crianca');
		$nome_responsavel = $this->input->post('nome_responsavel');
		$email_responsavel = $this->input->post('email_responsavel');
		$telefone_responsavel = $this->input->post('telefone_responsavel');

		$dadosPais = $this->FConsultas_model->consultaDadosPaisId($lider, $nivel_2);

		$total_count = count($total);

		for ($i = 0; $i < $total_count; $i++) {

			$nascimento2 = $nascimento[$i];
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
				if ($nivel_2 == 1) {
					$nomePai = $dadosPais['nome'];
					$emailPai = $dadosPais['email'];
					$telefonePai = $dadosPais['telefone_whatsapp'];
				} else if ($nivel_2 == 2) {
					$nomePai = $dadosPais['nome_lider'];
					$emailPai = $dadosPais['email'];
					$telefonePai = $dadosPais['telefone_whatsapp'];
				}
			}

			$checkCriancas = $this->FConsultas_model->consultarCriancasNomeEIdade($nome2, $lider2, $id_pg2, $nascimento2, $opcao2, $obs2, $nomePai, $nivel_2);

			if ($checkCriancas) {
				$this->FSistema_model->cadastro_crianca($nome2, $nascimento2, $lider2, $id_pg2, $obs2, $opcao2, $nomePai, $emailPai, $telefonePai, $nivel_2);
			} else {
			}
		}

		//header('Location: ../../../../primeiro_acesso?id_usuario=' . $lider . '&nivel=' . $nivel . '&x_ir=3');


		$data = [
			"<input type='hidden' name='id_usuario' value='$lider'>",
			"<input type='hidden' name='nivel' value='$nivel'>",
			"<input type='hidden' name='x_ir' value='3'>",
		];
		$funcao = $this->FConsultas_model->red('../../primeiro_acesso', 0, $data);
		echo $funcao;
	}
	public function editar_crianca()
	{
		$id_crianca = $this->input->post('idCrianca');
		$lider = $this->input->post('idLider');
		$nome = $this->input->post('nome');
		$id_pg = $this->input->post('idPg');
		$nascimento = $this->input->post('nascimento');
		$obs = $this->input->post('obs');
		$opcao = $this->input->post('opcao');

		$isResponsavel = $this->input->post('isResponsavel');

		$nivel = $this->input->post("nivel") == '' ? 1 : $this->input->post("nivel");

		$nome_responsavel = $isResponsavel == 2 || $isResponsavel == 0 ? $this->input->post('nome_responsavel_1') : $this->input->post('nome_responsavel');
		$email_responsavel = $isResponsavel == 2 || $isResponsavel == 0 ? $this->input->post('email_responsavel_1') : $this->input->post('email_responsavel');
		$telefone_responsavel = $isResponsavel == 2 || $isResponsavel == 0 ? $this->input->post('telefone_responsavel_1') : $this->input->post('telefone_responsavel');

		$checkCriancas = $this->FConsultas_model->consultarCriancasNomeEIdade($nome, $lider, $id_pg, $nascimento, $opcao, $obs, $nome_responsavel, $nivel);

		$red = $this->input->post('red') ?? 'criancas';
		$routa = "";

		if ($red == 'criancas') {
			$data = [];
			$routa = "criancas";
		} else if ($red == 'lideres/detalhes') {
			$data = [
				"<input type='hidden' name='id_lider' value='$lider'>",
			];
			$routa = "lideres/detalhes/$lider";
		} else {
			$data = [];
			$routa = "criancas";
		}

		if ($checkCriancas) {
			$editar = $this->FSistema_model->editaCrianca($id_crianca, $nome, $nascimento, $lider, $id_pg, $obs, $opcao, $nome_responsavel, $email_responsavel, $telefone_responsavel, $nivel);
			if ($editar) {
				$this->FConsultas_model->mensagem('success', 'Sucesso!', ['Edição Relizada com Sucesso!']);
				$funcao = $this->FConsultas_model->red("../../$routa", 2000, $data);
				echo $funcao;
			} else {
				$this->FConsultas_model->mensagem('danger', 'Erro!', ['Tente novamente!']);
				$funcao = $this->FConsultas_model->red("../../$routa", 2000, $data);
				echo $funcao;
			}
		} else {
			$this->FConsultas_model->mensagem('danget', 'Erro!', ['Já tem uma criança com esses dados!']);
			$funcao = $this->FConsultas_model->red("../../$routa", 2000, $data);
			echo $funcao;
		}
	}
	public function desativar_crianca()
	{
		$idCrianca = $this->input->post("idCrianca");
		$nomeCrianca = $this->input->post("nomeCrianca");
		$idLider = $this->input->post("idLider");
		$idResponsavel = $this->input->post("idResponsavel");
		$motivo = $this->input->post("motivo");

		$nivel = $this->input->post("nivel") == '' ? 1 : $this->input->post("nivel");

		$excluir = $this->FSistema_model->excluirCrianca($idCrianca, $nomeCrianca, $idLider, $idResponsavel, $motivo, $nivel);

		$red = $this->input->post('red') ?? 'criancas';
		$routa = "";

		if ($red == 'criancas') {
			$data = [];
			$routa = "criancas";
		} else if ($red == 'lideres/detalhes') {
			$data = [];
			$routa = "lideres/detalhes/$idLider";
		} else {
			$data = [];
			$routa = "criancas";
		}

		if ($excluir) {
			$this->FConsultas_model->mensagem('success', 'Sucesso!', ['Desativação Relizada com Sucesso!']);
			$funcao = $this->FConsultas_model->red("../../$routa", 2000, $data);
			echo $funcao;
		} else {
			$this->FConsultas_model->mensagem('danger', 'Erro!', ['Erro! Tente novamente!']);
			$funcao = $this->FConsultas_model->red("../../$routa", 2000, $data);
			echo $funcao;
		}
	}

	public function ativar_crianca()
	{
		$idLider = $this->input->post("idLider");
		$idCrianca = $this->input->post("opc");

		$nivel = $this->input->post("nivel") == '' ? 1 : $this->input->post("nivel");

		$reativar = $this->FSistema_model->reativarCrianca($idCrianca, $nivel);

		$red = $this->input->post('red') ?? 'criancas';
		$routa = "";

		if ($red == 'criancas') {
			$data = [];
			$routa = "criancas";
		} else if ($red == 'lideres/detalhes') {
			$data = [];
			$routa = "lideres/detalhes/$idLider";
		} else {
			$data = [];
			$routa = "criancas";
		}

		if ($reativar) {

			$this->FConsultas_model->mensagem('success', 'Sucesso!', ['Ativação Relizada com Sucesso!']);
			$funcao = $this->FConsultas_model->red("../../$routa", 2000, $data);
			echo $funcao;
		} else {
			$this->FConsultas_model->mensagem('danger', 'Erro!', ['Erro! Tente novamente!']);
			$funcao = $this->FConsultas_model->red("../../$routa", 2000, $data);
			echo $funcao;
		}
	}

	public function RelatoriosCriancas()
	{
		$idLider = $this->input->post("id");
		$nivel = $this->input->post("nivel");
		$opc = $this->input->post("opc");

		$dados = $this->FConsultas_model->consultaDadosPaisId($idLider, $nivel);

		$nivel = $this->input->post("nivel") == '' ? 1 : $this->input->post("nivel");

		$nome = $this->input->post("nivel") == 1 ? $dados['nome'] : $dados['nome_lider'];

		$pdf = new FPDF("L", "pt", "A4");
		$pdf->AddPage();
		$pdf->SetCreator('CAMP Brasil');

		$outraOpcao = explode(" ", $opc);

		// INFORMAÇÕES GERAIS
		if ($opc == "1") {

			$consultarPG = $this->FConsultas_model->mostrarPG($idLider, $nivel);
			$pdf->Image('import/sistema/dist/img/capa_relatorio.jpg', 200, 100, 500, 300);
			// imagem em pé - $pdf->Image('import/sistema/dist/img/capa_relatorio.jpg', 50, 300, 500, 300);

			$pdf->SetFont('arial', 'B', 12);
			$pdf->SetXY(70, 30);
			$pdf->Cell(350, 25, $pdf->textoUTF8('Relatórios / Informações Gerais das Crianças / CAMP Brasil'), 0, 1, 'L');
			//$pdf->Cell(350, 25, iconv('utf-8', 'cp1252', 'Relatórios / Informações Gerais das Crianças / CAMP Brasil'), 0, 1, 'L');
			$pdf->Image(base_url('import/sistema/dist/img/icone.png'), 30, 13, -100);
			$pdf->Ln(10);
			$pdf->Cell(0, 5, "", "B", 1, 'C');
			$pdf->Ln(8);
			/*$pdf->SetFont('arial', 'B', 12);
			$pdf->Cell(50, 20, $pdf->textoUTF8("Usuário:"), 0, 0, 'L');
			$pdf->SetFont('arial', '', 12);
			$pdf->Cell(0, 20, $pdf->textoUTF8($dados['nome']), 0, 1, 'L');
			$pdf->Ln(15);*/

			foreach ($consultarPG['dados'] as $key => $dadosPG) {
				$id_pg = $dadosPG['id_pg'];
				$id_modulo = $dadosPG['id_modulo'];
				$nome_pg = $dadosPG['nome_pg'];

				if ($consultarPG['row'] == 0) {
					$pdf->SetFont('arial', 'I', 12);
					$pdf->Cell(0, 50, $pdf->textoUTF8("Sem PG Cadastrado"), 0, 1, "C");
				} else {
					$consultaCriancas = $this->FConsultas_model->mostrarCriancasPaisPgTodos($idLider, $dadosPG['id_pg'], $nivel);

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

							$consultarProgresso = $this->FConsultas_model->consultarProgressoCriancaIndividual($id_pg, $idLider, $linha['id_crianca'], $id_modulo, $nivel);

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

			$consultarPG = $this->FConsultas_model->mostrarPG($idLider, $nivel);

			$pdf->Image('import/sistema/dist/img/capa_relatorio.jpg', 200, 100, 500, 300);

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
					$nome_pg = $pdf->textoUTF8($dadosPG['nome_pg']);

					$consultaCriancas = $this->FConsultas_model->mostrarCriancasPaisPg($idLider, $dadosPG['id_pg'], $nivel);

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

							$consultarProgresso = $this->FConsultas_model->consultarProgressoCriancaIndividual($id_pg, $idLider, $linha['id_crianca'], $id_modulo, $nivel);

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

			$consultarPG = $this->FConsultas_model->mostrarPG($idLider, $nivel);

			$pdf->Image('import/sistema/dist/img/capa_relatorio.jpg', 200, 100, 500, 300);
			// imagem em pé - $pdf->Image('import/sistema/dist/img/capa_relatorio.jpg', 50, 300, 500, 300);

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
					$nome_pg = $pdf->textoUTF8($dadosPG['nome_pg']);

					$consultaCriancas = $this->FConsultas_model->mostrarCriancasPaisPgDesativadas($idLider, $dadosPG['id_pg'], $nivel);

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

								$consultarMotivoExclusao = $this->FConsultas_model->mostrarCriancasPaisDesativadas($idLider, $linha['id_crianca']);

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
			$consultarPG = $this->FConsultas_model->mostrarPGId($idLider, $idPg, $nivel);

			$pdf->Image('import/sistema/dist/img/capa_relatorio.jpg', 200, 100, 500, 300);

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
				$nome_pg = $pdf->textoUTF8($dadosPG['nome_pg']);

				$consultaCriancas = $this->FConsultas_model->mostrarCriancasPaisPgTodos($idLider, $dadosPG['id_pg'], $nivel);

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

						$consultarProgresso = $this->FConsultas_model->consultarProgressoCriancaIndividual($id_pg, $idLider, $linha['id_crianca'], $id_modulo, $nivel);

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
			$consultarPG = $this->FConsultas_model->mostrarPGId($idLider, $idPg, $nivel);

			$pdf->Image('import/sistema/dist/img/capa_relatorio.jpg', 200, 100, 500, 300);

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
				$nome_pg = $pdf->textoUTF8($dadosPG['nome_pg']);

				$consultaCriancas = $this->FConsultas_model->mostrarCriancasPaisPgTodos($idLider, $dadosPG['id_pg'], $nivel);

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

							$consultarProgresso = $this->FConsultas_model->consultarProgressoCriancaIndividual($id_pg, $idLider, $linha['id_crianca'], $id_modulo, $nivel);

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

		$nomeCertificado = "Crianças - " . $nome . ".pdf";
		$pdf->Output('I', $nomeCertificado);
	}

	public function get_informacoes_pg()
	{

		$id_usuario = $this->input->get('id_usuario');
		$nivel = $this->input->get('nivel');

		$consultarPG = $this->FConsultas_model->mostrarPG($id_usuario, $nivel);

		$dados = array();

		foreach ($consultarPG['dados'] as $key => $pg) {
			$dados[] = $pg['id_pg'];
		}

		echo $dados;
	}

	public function cadastro_pg_inicial_pular()
	{
		$idLider = $this->input->post("idLider");
		$nome = $this->input->post("nome");
		$nivel = $this->input->post("nivel");

		$nivel_2 = $this->input->post("nivel_2") == '' ? 1 : $this->input->post("nivel_2");

		$this->FSistema_model->cadastro_pg_pular($idLider, $nome, $nivel_2);

		$data = [
			"<input type='hidden' name='id_usuario' value='$idLider'>",
			"<input type='hidden' name='nivel' value='$nivel'>",
			"<input type='hidden' name='x_ir' value='1'>",
		];
		$funcao = $this->FConsultas_model->red('../primeiro_acesso', 0, $data);
		echo $funcao;

		//header('Location: ../../../../primeiro_acesso?id_usuario=' . $idLider . '&nivel=' . $nivel . '&x_ir=1');
	}

	public function cadastro_pg_inicial()
	{
		$idLider = $this->input->post('idLider');
		$nome_pg = $this->input->post('nome_pg');
		$data_inicio = $this->input->post('data_inicio');
		$autorizacao = $this->input->post('autorizacao') == '' ? 0 : $this->input->post('autorizacao');
		$nivel = $this->input->post('nivel');

		$nivel_2 = $this->input->post("nivel_2") == '' ? 1 : $this->input->post("nivel_2");

		$this->FSistema_model->cadastro_pg($idLider, $nome_pg, $data_inicio, $autorizacao, $nivel_2);

		$data = [
			"<input type='hidden' name='id_usuario' value='$idLider'>",
			"<input type='hidden' name='nivel' value='$nivel'>",
			"<input type='hidden' name='x_ir' value='1'>",
		];
		$funcao = $this->FConsultas_model->red('../../primeiro_acesso', 0, $data);
		echo $funcao;

		//header('Location: ../../../../primeiro_acesso?id_usuario=' . $idLider . '&nivel=' . $nivel . '&x_ir=1');
	}

	public function cadastro_pg()
	{
		$idLider = $this->input->post('idLider');
		$nome_pg = $this->input->post('nome_pg');
		$data_inicio = $this->input->post('data_inicio');

		$nivel = $this->input->post("nivel") == '' ? 1 : $this->input->post("nivel");
		$autorizacao = $this->input->post('autorizacao') == '' ? 0 : $this->input->post('autorizacao');

		$consultarPg = $this->FConsultas_model->consultarPgCadastrado($idLider, $nome_pg, $nivel);

		$red = $this->input->post('red') ?? 'pg';
		$routa = "";

		if ($red == 'pg') {
			$data = [];
			$routa = "pg";
		} else if ($red == 'lideres/detalhes') {
			$data = [];
			$routa = "lideres/detalhes/$idLider";
		} else {
			$data = [];
			$routa = "pg";
		}

		if ($consultarPg) {
			$cadastro = $this->FSistema_model->cadastro_pg($idLider, $nome_pg, $data_inicio, $autorizacao, $nivel);

			if ($cadastro) {
				$this->FConsultas_model->mensagem('success', 'Sucesso!', ['Cadastro Realizado com Sucesso!']);
				$funcao = $this->FConsultas_model->red("../../$routa", 2000, $data);
				echo $funcao;
			} else {
				// ERRO
				$this->FConsultas_model->mensagem('danger', 'Erro!', ['Tente novamente!']);
				$funcao = $this->FConsultas_model->red("../../$routa", 2000, $data);
				echo $funcao;
			}
		} else {
			// PG JÁ CADASTRADO
			$this->FConsultas_model->mensagem('danger', 'Erro!', ['PG já Cadastrado!']);
			$funcao = $this->FConsultas_model->red("../../$routa", 2000, $data);
			echo $funcao;
		}
	}
	public function editar_pg()
	{
		$idLider = $this->input->post('idLider');
		$idPg = $this->input->post('idPg');
		$nome_pg = $this->input->post('nome_pg');
		$fotoOriginal = $this->input->post('fotoOriginal');
		$autorizacao = $this->input->post('autorizacao');

		$nivel = $this->input->post("nivel") == '' ? 1 : $this->input->post("nivel");

		$red = $this->input->post('red') ?? 'pg';

		$routa = "";

		if ($red == 'pg') {
			$data = [];
			$routa = "pg";
		} else if ($red == 'lideres/detalhes') {
			$data = [];
			$routa = "lideres/detalhes/$idLider";
		} else {
			$data = [];
			$routa = "pg";
		}

		if ($idPg == '' || $nome_pg == '') {
			/*echo '
				<script>
					if(window.confirm("DADOS VAZIOS! TENTE NOVAMENTE!")) {
						window.location="../../pg";
					}else{
						window.location="../../pg";
					}
				</script>
			';*/

			$this->FConsultas_model->mensagem('danger', 'Erro!', ['Dados Vazios! Tente novamente!']);
			$funcao = $this->FConsultas_model->red("../../$routa", 2000, $data);
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
					$funcao = $this->FConsultas_model->red("../../$routa", 2000, $data);
					echo $funcao;
				}
			}
			$editar = $this->FSistema_model->editarPG($idPg, $nome_pg, $nomeImagem, $autorizacao, $nivel);
			if ($editar) {
				$this->FConsultas_model->mensagem('success', 'Sucesso', ['Cadastro Realizado com Sucesso!']);
				$funcao = $this->FConsultas_model->red("../../$routa", 2000, $data);
				echo $funcao;
			} else {
				$this->FConsultas_model->mensagem('danger', 'Erro!', ["Tente novamente!"]);
				$funcao = $this->FConsultas_model->red("../../$routa", 2000, $data);
				echo $funcao;
			}
		}
	}
	public function desativar_pg()
	{
		$idPg = $this->input->post("idPg");
		$nomePg = $this->input->post("nomePg");
		$idLider = $this->input->post("idLider");
		$idResponsavel = $this->input->post("idResponsavel");
		$motivo = $this->input->post("motivo");

		$nivel = $this->input->post("nivel") == '' ? 1 : $this->input->post("nivel");

		$red = $this->input->post('red') ?? 'pg';

		$routa = "";
		if ($red == 'pg') {
			$data = [];
			$routa = "pg";
		} else if ($red == 'lideres/detalhes') {
			$data = [];
			$routa = "lideres/detalhes/$idLider";
		} else {
			$data = [];
			$routa = "pg";
		}

		$excluir = $this->FSistema_model->excluirPG($idPg, $nomePg, $idLider, $idResponsavel, $motivo, $nivel);

		if ($excluir) {
			$this->FConsultas_model->mensagem('success', 'Sucesso', ['PG desativado com Sucesso!']);
			$funcao = $this->FConsultas_model->red("../../$routa", 2000, $data);
			echo $funcao;
		} else {
			$this->FConsultas_model->mensagem('danger', 'Erro!', ["Tente novamente!"]);
			$funcao = $this->FConsultas_model->red("../../$routa", 2000, $data);
			echo $funcao;
		}
	}

	public function ativar_pg()
	{
		$idLider = $this->input->post("idLider");
		$idUsuario = $this->input->post("idUsuario");
		$id_pg = $this->input->post("id_pg");

		$nivel = $this->input->post("nivel") == '' ? 1 : $this->input->post("nivel");

		$reativar = $this->FSistema_model->reativarPg($id_pg, $idUsuario, $nivel);

		$red = $this->input->post('red') ?? 'pg';

		$routa = "";
		if ($red == 'pg') {
			$data = [];
			$routa = "pg";
		} else if ($red == 'lideres/detalhes') {
			$data = [];
			$routa = "lideres/detalhes/$idLider";
		} else {
			$data = [];
			$routa = "pg";
		}

		if ($reativar) {
			$this->FConsultas_model->mensagem('success', 'Sucesso!', ["PG Reativado com Sucesso!"]);
			$funcao = $this->FConsultas_model->red("../../$routa", 2000, $data);
			echo $funcao;
		} else {
			$this->FConsultas_model->mensagem('danger', 'Erro!', ["Tente novamente!"]);
			$funcao = $this->FConsultas_model->red("../../$routa", 2000, $data);
			echo $funcao;
		}
	}

	public function excluir_pg_permanentemente()
	{
		$idLider = $this->input->post("idLider");
		$idUsuario = $this->input->post("idUsuario");
		$id_pg = $this->input->post("id_pg");

		$nivel = $this->input->post("nivel") == '' ? 1 : $this->input->post("nivel");

		$excluir = $this->FSistema_model->excluirPgPermanentemente($id_pg, $idLider, $idUsuario, $nivel);

		$red = $this->input->post('red') ?? 'pg';

		$routa = "";
		if ($red == 'pg') {
			$data = [];
			$routa = "pg";
		} else if ($red == 'lideres/detalhes') {
			$data = [];
			$routa = "lideres/detalhes/$idLider";
		} else {
			$data = [];
			$routa = "pg";
		}

		if ($excluir) {
			$this->FConsultas_model->mensagem('success', 'Sucesso!', ["PG Excluido Permanentemente!"]);
			$funcao = $this->FConsultas_model->red("../../$routa", 2000, $data);
			echo $funcao;
		} else {
			$this->FConsultas_model->mensagem('danger', 'Erro!', ["Tente novamente!"]);
			$funcao = $this->FConsultas_model->red("../../$routa", 2000, $data);
			echo $funcao;
		}
	}

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

		$nivel = $this->input->post("nivel") == '' ? 1 : $this->input->post("nivel");

		$total = count($id_crianca);

		if ($licao == 1 || $licao == 3 || $licao == 5 || $licao == 7 || $licao == 9) {
			$isImpar = true;
		} else {
			$isImpar = false;
		}

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

			$preenchimento = $this->FSistema_model->relatorio_encontro($id_lider, $id_pg2, $qtd_crianca2, $id_crianca2, $versiculo2, $presenca2, $misterio2, $devocional2, $ano2, $modulo2, $licao2, $data_aula2, $nivel);
		}

		$data = [
			"<input type='hidden' name='id_pg' value='$id_pg'>",
			"<input type='hidden' name='id_lider' value='$id_lider'>",
			"<input type='hidden' name='ano' value='$ano'>",
		];

		if ($preenchimento == 'false') {
		} else {
		}

		$funcao = $this->FConsultas_model->red('../../pg/licoes', 0, $data);
		echo $funcao;
	}

	public function enviando_alerta_troca_de_css()
	{
		$id_usuario = $this->input->post('id_usuario');
		$id_lider = $this->input->post('id_lider');
		$id_troca_1 = $this->input->post('id_troca_1');
		$id_troca_2 = $this->input->post('id_troca_2');

		$str = explode(" ", $id_troca_1);

		if ($str[0] == 'coord') {
			$nivel = "Coordenador (a)";
		} else if ($str[0] == 'sl') {
			$nivel = "Supervisor Local";
		} else if ($str[0] == 'sr') {
			$nivel = "Supervisor Regional";
		}

		$dados = $this->FConsultas_model->getNomeUserId($str[1]);

		$nome = $dados['nome'];

		$motivo = " pediu a solicitação de troca do $nivel: $nome (id: $str[1]) para $nivel $id_troca_2";
		$acao = "SOLICITACAO_TROCA_CSS";

		$this->FAlerta_model->alerta_controle($id_usuario, $id_usuario, $motivo, $acao);

		$data = [
			"<input type='hidden' name='id_lider' value='$id_lider'>",
		];

		$this->FConsultas_model->mensagem('success', 'Solicitação Enviada com Sucesso', ['Aguarde, em breve entraremos em contato!']);

		$funcao = $this->FConsultas_model->red("../../coordenador/page/lideres/detalhes/$id_lider", 3000, $data);
		echo $funcao;
	}

	public function enviando_alerta_troca_de_lider_pg()
	{
		$id_usuario = $this->input->post('id_usuario');
		$id_lider = $this->input->post('id_lider');
		$id_pg = $this->input->post('id_pg');
		$id_lider_troca = $this->input->post('id_lider_troca');

		$dados = $this->FConsultas_model->getNomeUserId($id_usuario);

		$nome = $dados['nome'];

		$motivo = "O $nome pediu a solicitação de troca de líderes entre o PG ($id_pg) (id líder 1: $id_lider para $id_lider_troca";
		$acao = "SOLICITACAO_TROCA_LIDER_PG";

		$this->FAlerta_model->alerta_controle($id_usuario, $id_usuario, $motivo, $acao);

		$data = [
			"<input type='hidden' name='id_lider' value='$id_lider'>",
		];

		$this->FConsultas_model->mensagem('success', 'Solicitação Enviada com Sucesso', ['Aguarde, em breve entraremos em contato!']);

		$funcao = $this->FConsultas_model->red("../../coordenador/page/lideres/detalhes/$id_lider", 3000, $data);
		echo $funcao;
	}
}
