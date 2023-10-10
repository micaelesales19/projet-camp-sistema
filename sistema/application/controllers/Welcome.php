<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property input $input
 * @property FAlerta_model $FAlerta_model
 * @property FConsultas_model $FConsultas_model
 * @property FSistema_model $FSistema_model
 * @property db $db
 * @property email $email
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
	}

	public function cadastro()
	{
		$this->load->view('sistema/cadastro');
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
				$todosPG = $this->FConsultas_model->mostrarPG($id);

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

			$todosPG = $this->FConsultas_model->mostrarPG($id);

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

							$this->FSistema_model->editarPGProgressoData($id_pg, $anoNovo, $moduloNovo, $licaoNova, $data_envio);
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

			$todosPG = $this->FConsultas_model->mostrarPG($id);

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
								$this->FSistema_model->editarAtivo($id_pg, $id);
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

		if ($this->FAlerta_model->valida_cpf($cpf) or $this->FAlerta_model->validaNIF($cpf)) {
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
		} else {
			echo '
				<script>
					if(window.confirm("Erro, CPF inválido!")) {
						window.location="https://sistema.campbrasil.com/sistema/pais/cadastro";
					}else{
						window.location="https://sistema.campbrasil.com/sistema/pais/cadastro";
					}
				</script>
			';
		}
	}

	public function index()
	{
		$x = $this->input->get('x');
		$dados = array('x' => $x);

		$this->load->view('sistema/page_login', $dados);
	}

	public function autenticacao_login()
	{
		$email = $this->input->post('email');
		$cpf = $this->input->post('cpf');
		$x = $this->input->post('x_ir');

		$ponto = $cpf[3];

		$cpf_completo = "";

		if ($ponto == ".") {
			$cpf_completo .= $cpf;
		} else {
			$cpf_completo .= $cpf[0] . $cpf[1] . $cpf[2] . "." . $cpf[3] . $cpf[4] . $cpf[5] . "." . $cpf[6] . $cpf[7] . $cpf[8] . "-" . $cpf[9] . $cpf[10];
		}

		$consultar = $this->db->select("*")
			->from("usuario")
			->where("email", $email)
			->where("cpf", $cpf_completo)
			->or_where("cpf", $cpf)
			->get();
		$dados = $consultar->row_array();
		$total = $consultar->num_rows();

		if ($total == 0) {
			echo "Dados Inválidos";
			echo '
				<script>
					setTimeout(function(){ window.location="index?x=' . $x . '" }, 3000);
				</script>
			';
		} else {

			$id_usuario = $dados['id_usuario'];
			$nivel = $dados['nivel'];

			$_SESSION['usuario'] = $dados['nome'];
			$_SESSION['id_usuario'] = "";
			$_SESSION['id_usuario_2'] = "";

			$ativo = 1;
			$this->db->set('ativo', $ativo);
			$this->db->where('id_usuario', $id_usuario);
			$this->db->update('usuario');

			$consultar_lider = $this->db->select("*")
				->from("lider")
				->where("email", $email)
				->where("cpf", $cpf_completo)
				->get();
			$dados_lider = $consultar_lider->row_array();

			$consultar_pais = $this->db->select("*")
				->from("pais")
				->where("email", $email)
				->where("cpf", $cpf_completo)
				->get();
			$dados_pais = $consultar_pais->row_array();

			if ($nivel == 1) {
				/*if ($total_lider == 0) {
				} else {*/
				echo "Bem Vindo - " . $dados['nome'];

				$_SESSION['id_usuario'] .= $dados_lider['id_lider'];
				$_SESSION['id_usuario_2'] .= $id_usuario;

				$consultar_termos = $this->db->select("*")
					->from("termos")
					->where("id_usuario", $dados_lider['id_lider'])
					->get();
				$termos = $consultar_termos->num_rows();

				if ($termos == 0) {
					echo '
						<script>
							setTimeout(function(){ window.location="termos"}, 3000);
						</script>
					';
				} else {
					if ($x == 1) {
						echo '
							<script>
								setTimeout(function(){ window.location="lider/home"}, 3000);
							</script>
						';
					}
				}
			}

			// PAIS
			if ($nivel == 8) {

				echo "Bem Vindo - " . $dados['nome'];
				$_SESSION['id_usuario'] .= $dados_pais['id'];
				$_SESSION['id_usuario_2'] .= $id_usuario;

				$consultar_termos = $this->db->select("*")
					->from("termos")
					->where("id_usuario", $dados_pais['id'])
					->get();
				$termos = $consultar_termos->num_rows();

				if ($termos == 0) {
					echo '
						<script>
							setTimeout(function(){ window.location="termos?nivel=8"}, 2000);
						</script>
					';
				} else {
					if ($x == 1) {
						echo '
							<script>
								setTimeout(function(){ window.location="pais/home"}, 2000);
							</script>
						';
					}
				}
			}
		}
	}

	public function login()
	{
		$x = $this->input->get('x');
		$dados = array('x' => $x);

		$this->load->view('sistema/page_login', $dados);
	}


	public function PaginaDosTermos()
	{
		$x = $this->input->get('x');
		$nivel = $this->input->get('nivel');
		$dados = array('nivel' => $nivel, 'x' => $x,);

		$this->load->view('sistema/termos', $dados);
	}

	public function PrimeiroAcesso()
	{
		$id_usuario = $this->input->get('id_usuario');
		$nivel = $this->input->get('nivel');
		$check = $this->input->get('x_ir');

		if ($check == '2') {
			$confimacao = 1;
			$this->FSistema_model->aceitarTermos($id_usuario, $confimacao);
		}

		if ($nivel == 8) {
			$this->load->view('sistema/pais/primeiro_acesso');
		}
	}

	public function sair()
	{
		$id_usuario = $this->input->get("id_usuario");

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
		$id = $this->input->get("id");
		$idLider = $this->input->get("id_lider");
		$idPg = $this->input->get("id_pg");
		$title = $this->input->get("title");
		$download = $this->input->get("download");

		$dataEscolhida = $this->input->get("data");

		$dadosPg = $this->FConsultas_model->mostrarPGId($idLider, $idPg);

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

			$this->FSistema_model->editarData($idPg, $dataEscolhida, $data_fim, $dataEscolhida);
		}

		if ($id == 4) {
			$nme = "$title.ppsx";
		} else {
			$nme = "$title.pdf";
		}

		$pth = file_get_contents(base_url() . $download);
		force_download($nme, $pth);
	}

	public function modulo_trilha()
	{
		$this->load->view("../../import/sistema/arquivos/01/Trilha/Trilha.php");
	}

	public function modulo_mergulho()
	{
		$this->load->view("../../import/sistema/arquivos/01/Mergulho/Mergulho.php");
	}

	public function modulo_arco()
	{
		$this->load->view("../../import/sistema/arquivos/01/Arco/Arco.php");
	}

	public function modulo_estacao()
	{
		$this->load->view("../../import/sistema/arquivos/01/Estacao/Estacao.php");
	}

	public function modulo_santuario()
	{
		$this->load->view("../../import/sistema/arquivos/01/Santuario/Santuario.php");
	}
}
