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
 * @property $image_lib
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

		require_once 'import/PHPExcel.php';
		define(
			'LETRAS',
			['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z']
		);
	}

	public function atualizar_data()
	{
		// coordenadores
		$coordenadores = $this->FConsultas_model->mostrar_all_coordenador();

		foreach ($coordenadores['dados'] as $key => $coord) {
			echo $coord['id_coordenador'] . ": " . $coord['nome_coordenador'] . "<br>";
			$lideres = $this->FConsultas_model->getLideres([$coord['id_coordenador']], 1, 2, []);

			$data = "";

			if ($lideres['row'] == 0) {
				//echo "<b><i>O coordenador não tem líder cadastrado</i></b><br>";
				// consultando de o coordenador tem pg
				$pg = $this->FConsultas_model->mostrarPG($coord['id_coordenador'], 4);

				if ($pg['row'] == 0) {
					// o coordenador não tem pg

					// 1ª consulta - SUPERVISOR LOCAL
					$id_local = $coord['id_supervisorR'];
					$lideres_sr = $this->FConsultas_model->getLideres([$id_local], 2, 2, []);
					if ($lideres_sr['row'] == 0) {

						// o supervisor local não tem lideres vê se ele tem pg
						$pg_sr = $this->FConsultas_model->mostrarPG($id_local, 4);

						if ($pg_sr['row'] == 0) {
							// 2ª consulta - SUPERVISOR REGIONAL
						} else {
							$data_pg_sr = $pg_sr['dados'][0]['data_inicio'];

							if ($data_pg_sr == '') {
								echo "<b><i>Data Vazia</i></b><br>";
							} else {
								$dia = $data_pg_sr[0] . $data_pg_sr[1];
								$mes = $data_pg_sr[3] . $data_pg_sr[4];
								$ano = $data_pg_sr[6] . $data_pg_sr[7] . $data_pg_sr[8] . $data_pg_sr[9];

								$data = $ano . "-" . $mes . "-" . $dia;
							}
						}
					} else {
						$data = $lideres_sr['dados'][0]['data_cadastro'];
					}
				} else {
					// o coordenador tem pg - add a data de inicio do pg
					$data_pg = $pg['dados'][0]['data_inicio'];
					if ($data_pg == '') {
						echo "<b><i>Data Vazia</i></b><br>";
					} else {
						$dia = $data_pg[0] . $data_pg[1];
						$mes = $data_pg[3] . $data_pg[4];
						$ano = $data_pg[6] . $data_pg[7] . $data_pg[8] . $data_pg[9];
						$data = $ano . "-" . $mes . "-" . $dia;
					}
				}
			} else {
				if ($coord['id_coordenador'] == '3000' || $coord['id_coordenador'] == '3003' || $coord['id_coordenador'] == '3004' || $coord['id_coordenador'] == '3006' || $coord['id_coordenador'] == '3015' || $coord['id_coordenador'] == '3017'  || $coord['id_coordenador'] == '3033') {
					$data = "2017-02-18";
				} else {
					$data = $lideres['dados'][0]['data_cadastro'];
				}
			}

			echo $data . "<br><br>";
			$this->db->set('data_cadastro', $data);
			$this->db->where('id_coordenador  ', $coord['id_coordenador']);
			$this->db->update('coordenador');
		}
	}

	public function offline()
	{
		$dados = array(
			'heading' => 'Você está Offline',
			'message' => 'Conect a internet e tente novamente',
		);

		$this->load->view('errors/html/error_404', $dados);
	}

	public function red_lideres_coord()
	{

		$id_coord = $this->uri->segment(4);

		$data = [
			"<input type='hidden' name='id_user' value='$id_coord'>"
		];

		$funcao = $this->FConsultas_model->red('../lideres', 0, $data);
		echo $funcao;
	}

	public function red_lideres_info_licao()
	{

		$id_coord = $this->uri->segment(4);
		$id_lider = $this->uri->segment(5);

		$data = [
			"<input type='hidden' name='id_coord' value='$id_coord'>"
		];

		$funcao = $this->FConsultas_model->red("../../lideres/detalhes/$id_lider", 0, $data);
		echo $funcao;
	}

	public function atualizar_session()
	{
		$dados = json_decode(file_get_contents('php://input'), true);

		$_SESSION[$dados['session']] = $dados['valor'];

		echo json_encode($_SESSION[$dados['session']]);
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

		$nivel = $this->input->post("nivel_routa") ?? 'lider';
		$id_coord = $this->input->post("id_coord");

		$red = $this->input->post('red') ?? 'pagina_editar_pessoal';
		$routa = "";

		if ($red == 'pagina_editar_pessoal') {
			$data = [];
			$routa = "../pagina_editar_pessoal";
		} else if ($red == 'lideres/detalhes') {
			$data = [
				"<input type='hidden' name='id_coord' value='$id_coord'>",
				"<input type='hidden' name='nivel_routa' value='$nivel'>"
			];
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

		$nivel = $this->input->post("nivel_routa") ?? 'lider';
		$id_coord = $this->input->post("id_coord");

		$reativar = $this->FSistema_model->excluirColider($idColider, $nomeColider, $idLider, $idResponsavel, $motivo);

		$red = $this->input->post('red') ?? 'pagina_editar_pessoal';
		$routa = "";

		if ($red == 'pagina_editar_pessoal') {
			$data = [];
			$routa = "../pagina_editar_pessoal";
		} else if ($red == 'lideres/detalhes') {
			$data = [
				"<input type='hidden' name='id_coord' value='$id_coord'>",
				"<input type='hidden' name='nivel_routa' value='$nivel'>"
			];
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

		$nivel = $this->input->post("nivel_routa") ?? 'lider';
		$id_coord = $this->input->post("id_coord");

		$reativar = $this->FSistema_model->reativarColider($idColider, $idLider);

		$red = $this->input->post('red') ?? 'pagina_editar_pessoal';
		$routa = "";

		if ($red == 'pagina_editar_pessoal') {
			$data = [];
			$routa = "../pagina_editar_pessoal";
		} else if ($red == 'lideres/detalhes') {
			$data = [
				"<input type='hidden' name='id_coord' value='$id_coord'>",
				"<input type='hidden' name='nivel_routa' value='$nivel'>"
			];
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

		$nivel = $this->input->post("nivel_routa") ?? 'lider';
		$id_coord = $this->input->post("id_coord");

		$red = $this->input->post('red') ?? 'pagina_editar_pessoal';

		$routa = "";
		if ($red == 'pagina_editar_pessoal') {
			$data = [];
			$routa = "../../pagina_editar_pessoal";
		} else if ($red == 'lideres/detalhes' || $red == 'slocal/detalhes') {
			$data = [
				"<input type='hidden' name='id_coord' value='$id_coord'>",
				"<input type='hidden' name='nivel_routa' value='$nivel'>"
			];
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

				$consultar_slocal = $this->db->query("SELECT * FROM supervisorr WHERE (email = '$email' OR cpf = '$cpf_completo') AND  (nome_supervisorR LIKE '$nome' OR nome_supervisorR LIKE '$nome_base')");
				$dados_slocal = $consultar_slocal->row_array();
				$total_slocal = $consultar_slocal->num_rows();

				$consultar_sregional = $this->db->query("SELECT * FROM supervisore WHERE (email = '$email' OR cpf = '$cpf_completo') AND  (nome_supervisorE LIKE '$nome' OR nome_supervisorE LIKE '$nome_base')");
				$dados_sregional = $consultar_sregional->row_array();
				$total_sregional = $consultar_sregional->num_rows();

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
				} else if ($nivel == 4) { // slocal
					if ($total_slocal == 0) {
						echo "Não foi encontrado seus dados em nossas bases! Entre em contato com o suporte pelo e-mail campbrasilemail@gmail.com";
						$data = [
							"<input type='hidden' name='x' value='$x'>"
						];
						$funcao = $this->FConsultas_model->red('index', 2000, $data);
						echo $funcao;
					} else {
						echo "Bem Vindo - " . $dados['nome'];
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
								$funcao = $this->FConsultas_model->red('slocal/home', 2000, $data);
								echo $funcao;
							}
						}
					}
				} else if ($nivel == 5) { // sregional
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
				//$this->load->view('sistema/pais/home');
				echo '
					<script>
						setTimeout(function(){ window.location="pais/home"}, 0)
					</script>
				';
			}
		} else if ($nivel == 1) {
			$consultarPG = $this->FConsultas_model->mostrarPG($id_usuario, 2);
			$consultaCriancas = $this->FConsultas_model->mostrarCriancasPais($id_usuario, 2);

			if ($consultarPG['row'] == 0 || $consultaCriancas['row'] == 0 || $check == 3) {
				$this->load->view('sistema/lider/primeiro_acesso');
			} else {
				//$this->load->view('sistema/lider/home');
				echo '
					<script>
						setTimeout(function(){ window.location="lider/home"}, 0)
					</script>
				';
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
					setTimeout(function(){ window.location="slocal/home"}, 0)
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
		if ($nivel == '2') {
		} else {
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
		}

		if ($id == 4) {
			$nme = "$title.ppsx";
		} else {
			$nme = "$title.pdf";
		}

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

		$dadosusuario = $this->FConsultas_model->getInfoUserId($lider);
		$dadosnomeusuario = $this->FConsultas_model->getNomeUserId($lider);

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
				$nomePai = $dadosnomeusuario['nome'];
				$emailPai = $dadosusuario['dados']['email'];
				$telefonePai = $dadosusuario['dados']['telefone_whatsapp'];
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

		$nivel_routa = $this->input->post("nivel_routa") ?? 'lider';
		$id_coord = $this->input->post("id_coord");

		$data = [];

		if ($red == 'criancas') {
			$routa = "criancas";
		} else if ($red == 'lideres/detalhes') {
			$data = [
				"<input type='hidden' name='id_coord' value='$id_coord'>",
				"<input type='hidden' name='nivel_routa' value='$nivel_routa'>"
			];
			$routa = "lideres/detalhes/$lider";
		} else if ($red == 'pg') {
			$routa = "pg";
		} else {
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

		$nivel_routa = $this->input->post("nivel_routa") ?? 'lider';
		$id_coord = $this->input->post("id_coord");

		$data = [];

		if ($red == 'criancas') {
			$routa = "criancas";
		} else if ($red == 'lideres/detalhes') {
			$data = [
				"<input type='hidden' name='id_coord' value='$id_coord'>",
				"<input type='hidden' name='nivel_routa' value='$nivel_routa'>"
			];
			$routa = "lideres/detalhes/$lider";
		} else if ($red == 'pg') {
			$routa = "pg";
		} else {
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

		$nivel_routa = $this->input->post("nivel_routa") ?? 'lider';
		$id_coord = $this->input->post("id_coord");

		$red = $this->input->post('red') ?? 'criancas';
		$routa = "";
		$data = [];

		if ($red == 'criancas') {
			$routa = "criancas";
		} else if ($red == 'lideres/detalhes') {
			$data = [
				"<input type='hidden' name='id_coord' value='$id_coord'>",
				"<input type='hidden' name='nivel_routa' value='$nivel_routa'>"
			];
			$routa = "lideres/detalhes/$idLider";
		} else if ($red == 'pg') {
			$routa = "pg";
		} else {
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

		$nivel_routa = $this->input->post("nivel_routa") ?? 'lider';
		$id_coord = $this->input->post("id_coord");

		$data = [];

		if ($red == 'criancas') {
			$routa = "criancas";
		} else if ($red == 'lideres/detalhes') {
			$data = [
				"<input type='hidden' name='id_coord' value='$id_coord'>",
				"<input type='hidden' name='nivel_routa' value='$nivel_routa'>"
			];
			$routa = "lideres/detalhes/$idLider";
		} else if ($red == 'pg') {
			$routa = "pg";
		} else {
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

	public function excluir_crianca_permanentemente()
	{
		$idLider = $this->input->post("idLider");
		$idUsuario = $this->input->post("idUsuario");

		$id_cri = $this->input->post("opc");
		$nivel = $this->input->post("nivel") == '' ? 1 : $this->input->post("nivel");

		$excluir = $this->FSistema_model->excluirCriancaPermanentemente($id_cri, $idLider, $idUsuario, $nivel);

		$red = $this->input->post('red') ?? 'criancas';

		$nivel_routa = $this->input->post("nivel_routa") ?? 'lider';
		$id_coord = $this->input->post("id_coord");

		$data = [];

		if ($red == 'criancas') {
			$routa = "criancas";
		} else if ($red == 'lideres/detalhes') {
			$data = [
				"<input type='hidden' name='id_coord' value='$id_coord'>",
				"<input type='hidden' name='nivel_routa' value='$nivel_routa'>"
			];
			$routa = "lideres/detalhes/$idLider";
		} else if ($red == 'pg') {
			$routa = "pg";
		} else {
			$routa = "criancas";
		}

		if ($excluir) {
			$this->FConsultas_model->mensagem('success', 'Sucesso!', ['Atenção! Criança Excluida Permanentemente!']);
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

		$dados = $this->FConsultas_model->getNomeUserId($idLider);

		$nome = $dados['nome'];

		$nivel = $this->input->post("nivel") == '' ? 1 : $this->input->post("nivel");

		$pdf = new FPDF("L", "pt", "A4");
		$pdf->AddPage();
		$pdf->SetCreator('CAMP Brasil');

		$outraOpcao = explode(" ", $opc);

		// INFORMAÇÕES GERAIS
		if ($opc == "1") {
			$consultarPG = $this->FConsultas_model->mostrarPG($idLider, $nivel);
			$pdf->Image('import/sistema/dist/img/capa_relatorio.jpg', 200, 100, 500, 300);
			// imagem em pé - $pdf->Image('import/sistema/dist/img/capa_relatorio.jpg', 50, 300, 500, 300);

			$pdf->SetTitle($pdf->textoUTF8('Relatórios / Informações Gerais das Crianças / CAMP Brasil'));

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

		$data = [];

		$nivel_routa = $this->input->post("nivel_routa") ?? 'lider';
		$id_coord = $this->input->post("id_coord");

		if ($red == 'pg') {
			$routa = "pg";
		} else if ($red == 'lideres/detalhes') {
			$data = [
				"<input type='hidden' name='id_coord' value='$id_coord'>",
				"<input type='hidden' name='nivel_routa' value='$nivel_routa'>"
			];
			$routa = "lideres/detalhes/$idLider";
		} else {
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

		$nivel_routa = $this->input->post("nivel_routa") ?? 'lider';
		$id_coord = $this->input->post("id_coord");

		$routa = "";
		$data = [];

		if ($red == 'pg') {
			$routa = "pg";
		} else if ($red == 'lideres/detalhes') {
			$data = [
				"<input type='hidden' name='id_coord' value='$id_coord'>",
				"<input type='hidden' name='nivel_routa' value='$nivel_routa'>"
			];
			$routa = "lideres/detalhes/$idLider";
		} else {
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
				$this->FConsultas_model->mensagem('success', 'Sucesso', ['Edição Realizada com Sucesso!']);
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

		$nivel_routa = $this->input->post("nivel_routa") ?? 'lider';
		$id_coord = $this->input->post("id_coord");

		$routa = "";
		$data = [];

		if ($red == 'pg') {
			$routa = "pg";
		} else if ($red == 'lideres/detalhes') {
			$data = [
				"<input type='hidden' name='id_coord' value='$id_coord'>",
				"<input type='hidden' name='nivel_routa' value='$nivel_routa'>"
			];
			$routa = "lideres/detalhes/$idLider";
		} else {
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

		$nivel_routa = $this->input->post("nivel_routa") ?? 'lider';
		$id_coord = $this->input->post("id_coord");

		$routa = "";
		$data = [];

		if ($red == 'pg') {
			$routa = "pg";
		} else if ($red == 'lideres/detalhes') {
			$data = [
				"<input type='hidden' name='id_coord' value='$id_coord'>",
				"<input type='hidden' name='nivel_routa' value='$nivel_routa'>"
			];
			$routa = "lideres/detalhes/$idLider";
		} else {
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

		$nivel_routa = $this->input->post("nivel_routa") ?? 'lider';
		$id_coord = $this->input->post("id_coord");

		$routa = "";
		$data = [];

		if ($red == 'pg') {
			$routa = "pg";
		} else if ($red == 'lideres/detalhes') {
			$data = [
				"<input type='hidden' name='id_coord' value='$id_coord'>",
				"<input type='hidden' name='nivel_routa' value='$nivel_routa'>"
			];
			$routa = "lideres/detalhes/$idLider";
		} else {
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

		if ($preenchimento == 'false') {
		} else {
		}

		$red = $this->input->post('red') ?? 'pg';
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

		$red = $this->input->post('red') ?? 'coordenador';

		$nivel_routa = $this->input->post('nivel_routa') ?? 'lider';
		$id_coord = $this->input->post('id_coord');

		$routa = "";
		if ($red == 'coordenador') {
			$data = [
				"<input type='hidden' name='id_coord' value='$id_coord'>",
				"<input type='hidden' name='nivel_routa' value='$nivel_routa'>"
			];
			$routa = "coordenador/page/lideres/detalhes/$id_lider";
		} else if ($red == 'slocal') {
			$data = [
				"<input type='hidden' name='id_coord' value='$id_coord'>",
				"<input type='hidden' name='nivel_routa' value='$nivel_routa'>"
			];
			$routa = "slocal/page/lideres/detalhes/$id_lider";
		} else if ($red == 'slocal/coord') {
			$data = [
				"<input type='hidden' name='id_coord' value='$id_coord'>",
				"<input type='hidden' name='nivel_routa' value='$nivel_routa'>"
			];
			$routa = "slocal/page/coordenadores/detalhes/$id_lider";
		} else if ($red == 'sregional') {
			$data = [
				"<input type='hidden' name='id_coord' value='$id_coord'>",
				"<input type='hidden' name='nivel_routa' value='$nivel_routa'>"
			];
			$routa = "sregional/page/lideres/detalhes/$id_lider";
		} else {
			$data = [
				"<input type='hidden' name='id_lider' value='$id_lider'>",
			];
			$routa = "lideres/detalhes/$id_lider";
		}

		$this->FConsultas_model->mensagem('success', 'Solicitação Enviada com Sucesso', ['Aguarde, em breve entraremos em contato!']);

		$funcao = $this->FConsultas_model->red("../../$routa", 3000, $data);
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

		$red = $this->input->post('red') ?? 'coordenador';

		$nivel_routa = $this->input->post('nivel_routa') ?? 'lider';
		$id_coord = $this->input->post('id_coord');

		$routa = "";
		if ($red == 'coordenador') {
			$data = [
				"<input type='hidden' name='id_coord' value='$id_coord'>",
				"<input type='hidden' name='nivel_routa' value='$nivel_routa'>"
			];
			$routa = "coordenador/page/lideres/detalhes/$id_lider";
		} else if ($red == 'slocal') {
			$data = [
				"<input type='hidden' name='id_coord' value='$id_coord'>",
				"<input type='hidden' name='nivel_routa' value='$nivel_routa'>"
			];
			$routa = "slocal/page/lideres/detalhes/$id_lider";
		} else {
			$data = [
				"<input type='hidden' name='id_lider' value='$id_lider'>",
			];
			$routa = "coordenador/page/lideres/detalhes/$id_lider";
		}

		$this->FConsultas_model->mensagem('success', 'Solicitação Enviada com Sucesso', ['Aguarde, em breve entraremos em contato!']);

		$funcao = $this->FConsultas_model->red("../../$routa", 3000, $data);
		echo $funcao;
	}

	public function tornar_lider_coordenador()
	{
		$id_usuario = $this->input->post('id_usuario');
		$id_lider = $this->input->post('id_lider');

		$dados = $this->FConsultas_model->getNomeUserId($id_usuario);
		$nomelider = $this->FConsultas_model->getNomeUserId($id_lider)['nome'];

		$nome = $dados['nome'];

		$motivo = "O $nome pediu a solicitação de troca de função do líder $nomelider (id líder: $id_lider) para coordenador.";
		$acao = "SOLICITACAO_TROCA_LIDER_P_COORDENADOR";

		$this->FAlerta_model->alerta_controle($id_usuario, $id_usuario, $motivo, $acao);

		$red = $this->input->post('red') ?? 'coordenador';

		$nivel_routa = $this->input->post('nivel_routa') ?? 'lider';
		$id_coord = $this->input->post('id_coord');

		$routa = "";
		if ($red == 'coordenador') {
			$data = [
				"<input type='hidden' name='id_coord' value='$id_coord'>",
				"<input type='hidden' name='nivel_routa' value='$nivel_routa'>"
			];
			$routa = "coordenador/page/lideres/detalhes/$id_lider";
		} else if ($red == 'slocal') {
			$data = [
				"<input type='hidden' name='id_coord' value='$id_coord'>",
				"<input type='hidden' name='nivel_routa' value='$nivel_routa'>"
			];
			$routa = "slocal/page/lideres/detalhes/$id_lider";
		} else {
			$data = [
				"<input type='hidden' name='id_lider' value='$id_lider'>",
			];
			$routa = "coordenador/page/lideres/detalhes/$id_lider";
		}

		$this->FConsultas_model->mensagem('success', 'Solicitação Enviada com Sucesso', ['Aguarde, em breve entraremos em contato!']);

		$funcao = $this->FConsultas_model->red("../../$routa", 3000, $data);
		echo $funcao;
	}

	public function tornar_coord_slocal()
	{
		$id_usuario = $this->input->post('id_usuario');
		$id_coordenador = $this->input->post('id_coordenador');

		$dados = $this->FConsultas_model->getNomeUserId($id_usuario);
		$nomecoordenador = $this->FConsultas_model->getNomeUserId($id_coordenador)['nome'];

		$nome = $dados['nome'];

		$motivo = "O $nome pediu a solicitação de troca de função do coordenador $nomecoordenador (id coordenador: $id_coordenador) para supervisor local.";
		$acao = "SOLICITACAO_TROCA_COORDENADOR_P_SLOCAL";

		$this->FAlerta_model->alerta_controle($id_usuario, $id_usuario, $motivo, $acao);

		$red = $this->input->post('red') ?? 'slocal/coord';

		$routa = "";
		$data = [];

		if ($red == 'slocal/coord') {
			$routa = "slocal/page/coordenadores/detalhes/$id_coordenador";
		} else {
			$routa = "slocal/page/coordenadores/detalhes/$id_coordenador";
		}

		$this->FConsultas_model->mensagem('success', 'Solicitação Enviada com Sucesso', ['Aguarde, em breve entraremos em contato!']);

		$funcao = $this->FConsultas_model->red("../../$routa", 3000, $data);
		echo $funcao;
	}

	public function tornar_coord_lider()
	{
		$id_usuario = $this->input->post('id_usuario');
		$id_coordenador = $this->input->post('id_coordenador');

		$dados = $this->FConsultas_model->getNomeUserId($id_usuario);
		$nomecoordenador = $this->FConsultas_model->getNomeUserId($id_coordenador)['nome'];

		$nome = $dados['nome'];

		$motivo = "O $nome pediu a solicitação de troca de função do coordenador $nomecoordenador (id coordenador: $id_coordenador) para líder.";
		$acao = "SOLICITACAO_TROCA_COORDENADOR_P_LIDER";

		$this->FAlerta_model->alerta_controle($id_usuario, $id_usuario, $motivo, $acao);

		$red = $this->input->post('red') ?? 'slocal/coord';

		$routa = "";
		$data = [];

		if ($red == 'slocal/coord') {
			$routa = "slocal/page/coordenadores/detalhes/$id_coordenador";
		} else {
			$routa = "slocal/page/coordenadores/detalhes/$id_coordenador";
		}

		$this->FConsultas_model->mensagem('success', 'Solicitação Enviada com Sucesso', ['Aguarde, em breve entraremos em contato!']);

		$funcao = $this->FConsultas_model->red("../../$routa", 3000, $data);
		echo $funcao;
	}

	// líder
	public function cadastro_lider()
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

		$id_pastor = $this->input->post('id_pastor');
		$id_coordenador = $this->input->post('id_coordenador');
		$id_slocal = $this->input->post('id_slocal');
		$id_sregional = $this->input->post('id_sregional');

		$estado = "";
		$cidade = "";

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

		$red = $this->input->post('red') ?? 'coordenador/lideres';
		$routa = "";

		$nivel_routa = $this->input->post("nivel_routa") ?? 'lider';

		if ($red == 'coordenador/lideres') {
			$data = [];
			$routa = "coordenador/page/lideres";
		} else if ($red == 'slocal/lideres') {
			if ($nivel_routa == 'lider') {
				$data = [];
			} else {
				$data = [
					"<input type='hidden' name='id_user' value='$id_coordenador'>"
				];
			}
			$routa = "slocal/page/lideres";
		} else {
			$data = [];
			$routa = "coordenador/page/lideres";
		}

		if ($this->FAlerta_model->ValidaData($nascimento)) {
			$consultarLider = $this->FConsultas_model->consultarLiderJaCadastrado($nome, $cpf, $cpf_completo, $email);
			$consultarUsuario = $this->FConsultas_model->consultarUsuarioCadastrado($nome, $cpf,  $cpf_completo, $email);

			if ($consultarLider || $consultarUsuario) {
				$nivel = 1;
				$cadastro = $this->FSistema_model->cadastro_lider($nome, $cpf_completo, $email, $telefone, $igreja, $nascimento, $id_pastor, $pais, $estado, $cidade, $id_coordenador, $id_slocal, $id_sregional);
				$cadastroUsuario = $this->FSistema_model->cadastrarUsuário($nome, $email, $cpf_completo, $nivel);
				if ($cadastro && $cadastroUsuario) {
					$this->FConsultas_model->mensagem('success', 'Sucesso!', ["Líder cadastrado com Sucesso!"]);
					$funcao = $this->FConsultas_model->red("../$routa", 2000, $data);
					echo $funcao;
				} else {
					$this->FConsultas_model->mensagem('danger', 'Erro!', ["Tente Novamente!"]);
					$funcao = $this->FConsultas_model->red("../$routa", 2000, $data);
					echo $funcao;
				}
			} else {
				$this->FConsultas_model->mensagem('danger', 'Erro!', ["Líder já Cadastrado!"]);
				$funcao = $this->FConsultas_model->red("../$routa", 2000, $data);
				echo $funcao;
			}
		} else {
			$this->FConsultas_model->mensagem('danger', 'Erro!', ["Data de Nascimento Inválida!"]);
			$funcao = $this->FConsultas_model->red("../$routa", 2000, $data);
			echo $funcao;
		}
	}

	public function desativar_lider()
	{
		$id_lider = $this->input->post("id_lider");
		$id_usuario = $this->input->post("id_usuario");
		$motivo = "O usuário de ID (" . $id_usuario . ") desativou esse líder";

		$infos = $this->FConsultas_model->getInfoUserId($id_lider);
		$infonome = $this->FConsultas_model->getNomeUserId($id_lider);

		// desativar pg
		$consultaPG = $this->FConsultas_model->mostrarPG($id_lider, 5);
		$dadosPG = $consultaPG['dados'];

		if ($consultaPG['row'] == 0) {
		} else {
			foreach ($dadosPG as $key => $pg) {
				$this->FSistema_model->excluirPG($pg['id_pg'], $pg['nome_pg'], $id_lider, $id_usuario, $motivo, 2);
			}
		}

		// desativar crianças
		$consultaCriancas = $this->FConsultas_model->mostrarCriancasPais($id_lider, 2);
		$dadosCriancas = $consultaCriancas['dados'];

		if ($consultaCriancas['row'] == 0) {
		} else {
			foreach ($dadosCriancas as $key => $criancas) {
				$this->FSistema_model->excluirCrianca($criancas['id_crianca'], $criancas['nome_crianca'], $id_lider, $id_usuario, $motivo, 2);
			}
		}

		// mudar o ativo do líder
		$this->FSistema_model->desativarUsuário($infonome['nome'], $infos['dados']['email'], $infos['dados']['cpf']);
		$this->FSistema_model->desativarLider($id_lider);

		$this->FAlerta_model->alerta_controle($id_usuario, $id_lider, $motivo, "EX_CL_4");

		$nivel_routa = $this->input->post('nivel_routa') ?? 'lider';
		$id_coord = $this->input->post('id_coord');

		$red = $this->input->post('red') ?? 'lideres/detalhes';
		$routa = "";
		$data = [];

		if ($red == 'lideres/detalhes') {
			$data = [
				"<input type='hidden' name='id_coord' value='$id_coord'>",
				"<input type='hidden' name='nivel_routa' value='$nivel_routa'>"
			];
			$routa = "page/lideres/detalhes/$id_lider";
		} else {
			$data = [
				"<input type='hidden' name='id_user' value='$id_coord'>",
			];
			$routa = "coordenador/page/lideres";
		}

		$this->FConsultas_model->mensagem('success', 'Sucesso!', ["Líder desativado!"]);
		$funcao = $this->FConsultas_model->red("../../$routa", 2000, $data);
		echo $funcao;
	}

	public function ativar_lider()
	{
		$id_lider = $this->input->post("opc");
		$id_usuario = $this->input->post("idUsuario");
		$infos = $this->FConsultas_model->getInfoUserId($id_lider);
		$infonome = $this->FConsultas_model->getNomeUserId($id_lider);

		// desativar pg
		$consultaPG = $this->FConsultas_model->mostrarPG($id_lider, 5);
		$dadosPG = $consultaPG['dados'];

		if ($consultaPG['row'] == 0) {
		} else {
			foreach ($dadosPG as $key => $pg) {
				$this->FSistema_model->reativarPg($pg['id_pg'], $id_usuario, 2);
			}
		}

		// desativar crianças
		$consultaCriancas = $this->FConsultas_model->mostrarCriancasPais($id_lider, 2);
		$dadosCriancas = $consultaCriancas['dados'];

		if ($consultaCriancas['row'] == 0) {
		} else {
			foreach ($dadosCriancas as $key => $criancas) {
				$this->FSistema_model->reativarCrianca($criancas['id_crianca'], 2);
			}
		}

		// mudar o ativo do líder
		$this->FSistema_model->ativarUsuário($infonome['nome'], $infos['dados']['email'], $infos['dados']['cpf']);
		$this->FSistema_model->ativarLider($id_lider);

		$nivel_routa = $this->input->post('nivel_routa') ?? 'lider';
		$id_coord = $this->input->post('id_coord');

		$red = $this->input->post('red') ?? 'lideres';
		$routa = "";

		if ($red == 'lideres') {
			$data = [
				"<input type='hidden' name='id_user' value='$id_coord'>",
			];
			$routa = "lideres";
		} else if ($red == 'lideres/detalhes') {
			$data = [
				"<input type='hidden' name='id_coord' value='$id_coord'>",
				"<input type='hidden' name='nivel_routa' value='$nivel_routa'>"
			];
			$routa = "lideres/detalhes/$id_lider";
		} else {
			$data = [
				"<input type='hidden' name='id_user' value='$id_coord'>",
			];
			$routa = "lideres";
		}

		$this->FConsultas_model->mensagem('success', 'Sucesso!', ["Líder Ativado!"]);
		$funcao = $this->FConsultas_model->red("../../$routa", 2000, $data);
		echo $funcao;
	}

	public function excluir_lider_permanentemente()
	{
		$id_lider = $this->input->post("opc");
		$id_usuario = $this->input->post("idUsuario");

		$infos = $this->FConsultas_model->getInfoUserId($id_lider);
		$infonome = $this->FConsultas_model->getNomeUserId($id_lider);

		// desativar pg
		$consultaPG = $this->FConsultas_model->mostrarPG($id_lider, 5);
		$dadosPG = $consultaPG['dados'];

		if ($consultaPG['row'] == 0) {
		} else {
			foreach ($dadosPG as $key => $pg) {
				$this->FSistema_model->excluirPgPermanentemente($pg['id_pg'], $id_lider, $id_usuario, 2);
			}
		}

		// desativar crianças
		$consultaCriancas = $this->FConsultas_model->mostrarCriancasPais($id_lider, 2);
		$dadosCriancas = $consultaCriancas['dados'];

		if ($consultaCriancas['row'] == 0) {
		} else {
			foreach ($dadosCriancas as $key => $criancas) {
				$this->FSistema_model->excluirCriancaPermanentemente($criancas['id_crianca'], $id_lider, $id_usuario, 2);
			}
		}

		$dados_colider = $this->FConsultas_model->mostrarColiderDoLider($id_lider);

		if ($dados_colider) {
			$this->FSistema_model->excluirColiderPermanentemente($dados_colider['id_colider'], $id_lider, $id_usuario);
		} else {
		}

		// mudar o ativo do líder
		$this->FSistema_model->excluirUsuarioPermanentemente($infonome['nome'], $infos['dados']['email'], $infos['dados']['cpf']);
		$this->FSistema_model->excluirLiderPermanentemente($id_lider, $id_usuario);

		$nivel_routa = $this->input->post('nivel_routa') ?? 'lider';
		$id_coord = $this->input->post('id_coord');

		$red = $this->input->post('red') ?? 'lideres';
		$routa = "";
		$data = [];

		if ($red == 'lideres') {
			$routa = "lideres";
		} else if ($red == 'lideres/detalhes') {
			if ($nivel_routa == 'lider') {
			} else {
				$data = [
					"<input type='hidden' name='id_user' value='$id_coord'>",
				];
			}
			$routa = "lideres";
		} else {
			$routa = "lideres";
		}

		$this->FConsultas_model->mensagem('success', 'Sucesso!', ["Líder Excluido Permanentemente!"]);
		$funcao = $this->FConsultas_model->red("../../$routa", 2000, $data);
		echo $funcao;
	}

	public function gerar_pontuacao($id_lider, $id_pg)
	{
		$dados_pg = $this->FConsultas_model->mostrarPGId($id_lider, $id_pg, 3);

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

			$consultaCriancas = $this->FConsultas_model->mostrarCriancasPaisPg($id_lider, $id_pg, 2);

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
						$consultarProgresso1 = $this->FConsultas_model->consultarProgressoCriancaIndividual($id_pg, $id_lider, $linha['id_crianca'], $id_modulos[0], 2);
						$consultarProgresso2 = $this->FConsultas_model->consultarProgressoCriancaIndividual($id_pg, $id_lider, $linha['id_crianca'], $id_modulos[1], 2);
						$consultarProgresso3 = $this->FConsultas_model->consultarProgressoCriancaIndividual($id_pg, $id_lider, $linha['id_crianca'], $id_modulos[2], 2);
						$consultarProgresso4 = $this->FConsultas_model->consultarProgressoCriancaIndividual($id_pg, $id_lider, $linha['id_crianca'], $id_modulos[3], 2);
						$consultarProgresso5 = $this->FConsultas_model->consultarProgressoCriancaIndividual($id_pg, $id_lider, $linha['id_crianca'], $id_modulos[4], 2);
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

	public function mostrar_table_parte_1()
	{
		$id_user = $this->input->get("id_user");
		$opc1 = $this->input->get("opc1");
		$opc2 = $this->input->get("opc2");

		$dataInicio = $this->input->get("dataInicio");
		$dataFim = $this->input->get("dataAte");

		$nivel = $this->input->get("nivel") ?? "lideres";
		$check_is_coord_query = $this->input->get("check_is_coord_query") ?? false;

		$dados = $this->consultasBD($id_user, $opc1, $opc2, '', $dataInicio, $dataFim, $nivel, $check_is_coord_query);

		if ($nivel == 'lideres') {
			$this->load->view('sistema/slocal/pages/lideres/mostrar_tabela_lideres_1', $dados);
		} else if ($nivel == 'coordenadores') {
			$this->load->view('sistema/slocal/pages/coordenadores/mostrar_tabela_coord_1', $dados);
		}
	}

	public function mostrar_table_parte_2()
	{
		$id_user = $this->input->get("id_user");
		$opc1 = $this->input->get("opc1");
		$opc2 = $this->input->get("opc2");
		$opc3 = $this->input->get("opc3");

		//echo 'OPC 1 - ' . $opc1 . ' OPC 2 - ' . $opc2;

		$dataInicio = $this->input->get("dataInicio");
		$dataFim = $this->input->get("dataAte");

		$nivel = $this->input->get("nivel") ?? "lideres";
		$check_is_coord_query = $this->input->get("check_is_coord_query") ?? false;

		$dados = $this->consultasBD($id_user, $opc1, $opc2, $opc3, $dataInicio, $dataFim, $nivel, $check_is_coord_query);

		if ($nivel == 'lideres') {
			$this->load->view('sistema/slocal/pages/lideres/mostrar_tabela_lideres_2', $dados);
		} else if ($nivel == 'coordenadores') {
			$this->load->view('sistema/slocal/pages/coordenadores/mostrar_tabela_coordenador_2', $dados);
		}
	}

	public function format_dates($opc1, $opc2, $dataInicio, $dataFim)
	{
		$data = date('Y-m-d');
		$data_menos_um_ano = date('Y-m-d', strtotime('-1 year', strtotime($data)));

		$data_formatada_1 = "";
		$data_formatada_2 = "";

		if ($opc2 == 'nao') {
			if ($opc1 == 'opc1') {
				// consulta baseada no ultimo mês
				$menos_um_mes = date('Y-m-d', strtotime('-1 month', strtotime($data)));
				$data_formatada_1 = $menos_um_mes;
				$data_formatada_2 = $data;
			} else if ($opc1 == 'opc2') {
				// consulta baseada nos últimos 6 meses
				$data_menos_seis_meses = date('Y-m-d', strtotime('-6 month', strtotime($data)));
				$data_formatada_1 = $data_menos_seis_meses;
				$data_formatada_2 = $data;
			} else if ($opc1 == 'opc3') {
				// desde o inicio
				$data_formatada_1 = "01-02-2017";
				$data_formatada_2 = $data;
			} else if ($opc1 == 'opc4') {
				if ($dataInicio == '' || $dataFim == '') {
				} else {
					$data_formatada_1 = $dataInicio;
					$data_formatada_2 = $dataFim;
				}
			}

			$datas = array(
				'dataInicio' => $data_formatada_1,
				'dataFim' => $data_formatada_2,
			);
		} else {
			if ($opc1 == 'opc1') {
				// consulta baseada no ultimo mês
				$menos_um_mes = date('Y-m-d', strtotime('-1 month', strtotime($data)));
				$menos_um_mes_ano = date('Y-m-d', strtotime('-1 year', strtotime($menos_um_mes)));
				$data_formatada_1 = $menos_um_mes;
				$data_formatada_2 = $data;
				$data_formatada_3 = $menos_um_mes_ano;
				$data_formatada_4 = $data_menos_um_ano;
			} else if ($opc1 == 'opc2') {
				// consulta baseada nos últimos 6 meses
				$data_menos_seis_meses = date('Y-m-d', strtotime('-6 month', strtotime($data)));
				$menos_seis_meses_ano = date('Y-m-d', strtotime('-1 year', strtotime($data_menos_seis_meses)));
				$data_formatada_1 = $data_menos_seis_meses;
				$data_formatada_2 = $data;
				$data_formatada_3 = $menos_seis_meses_ano;
				$data_formatada_4 = $data_menos_um_ano;
			} else if ($opc1 == 'opc4') {
				if ($dataInicio == '' || $dataFim == '') {
				} else {
					$data_inicio_menos_um_ano = date('Y-m-d', strtotime('-1 year', strtotime($dataInicio)));
					$data_fim_menos_um_ano = date('Y-m-d', strtotime('-1 year', strtotime($dataFim)));

					$data_formatada_1 = $dataInicio;
					$data_formatada_2 = $dataFim;
					$data_formatada_3 = $data_inicio_menos_um_ano;
					$data_formatada_4 = $data_fim_menos_um_ano;
				}
			}

			$datas = array(
				'dataInicio' => $data_formatada_1,
				'dataFim' => $data_formatada_2,
				'dataInicioAnoPassado' => $data_formatada_3,
				'dataFimAnoPassado' => $data_formatada_4,
			);
		}

		return $datas;
	}

	public function consultasBD($id_user, $opc1, $opc2, $opc3, $dataInicio, $dataFim, $nivel, $check_is_coord_query)
	{

		$datas = $this->format_dates($opc1, $opc2, $dataInicio, $dataFim);

		if ($nivel == 'lideres') {

			$consultarLideres = $this->FConsultas_model->getLideres([$id_user], $opc1, $opc2, $datas);
			$consultarLideresAtivos = $this->FConsultas_model->lideresAtivos($consultarLideres);

			$total_criancas_geral = $this->FConsultas_model->getNumerosCriancas([$id_user], $consultarLideres, 'criancas_coord_1');
			$total_criancas_ativos = $this->FConsultas_model->getNumerosCriancas([$id_user], $consultarLideresAtivos, 'criancas_coord_1');

			if ($opc3 == 'lideres_ativos') {
				$dados = array(
					'id_user' => $id_user,
					'dados_lideres_gerais' => $consultarLideresAtivos,
					'dados_lideres_ativos' => $consultarLideresAtivos,
					'dados_criancas_gerais' => $total_criancas_geral,
					'dados_criancas_ativos' => $total_criancas_ativos,
					'mostrar_comparacao' => $opc2,
					'check_is_coord_query' => $check_is_coord_query,
				);

				return $dados;
			} else {
				$dados = array(
					'id_user' => $id_user,
					'dados_lideres_gerais' => $consultarLideres,
					'dados_lideres_ativos' => $consultarLideresAtivos,
					'dados_criancas_gerais' => $total_criancas_geral,
					'dados_criancas_ativos' => $total_criancas_ativos,
					'mostrar_comparacao' => $opc2,
					'check_is_coord_query' => $check_is_coord_query,
				);

				return $dados;
			}
		} else if ($nivel == 'coordenadores') {

			$consultarCoordenadores = $this->FConsultas_model->getCoordenador([$id_user], $opc1, $opc2, $datas);
			$consultarCoordenadoresAtivos = $this->FConsultas_model->coordenadoresAtivos($consultarCoordenadores);

			$consultarLideres = $consultarCoordenadores['lideres'];
			$consultarLideresAtivos = $consultarCoordenadores['lideres_ativos'];

			$total_criancas_geral = $this->FConsultas_model->getNumerosCriancas([$id_user], $consultarLideres, 'criancas_coord_1');
			$total_criancas_ativos = $this->FConsultas_model->getNumerosCriancas([$id_user], $consultarLideresAtivos, 'criancas_coord_1');

			if ($opc3 == 'coordenadores_ativos') {
				$dados = array(
					'id_user' => $id_user,
					'dados_coordenadores_gerais' => $consultarCoordenadores,
					'dados_coordenadores_ativos' => $consultarCoordenadoresAtivos,
					'dados_lideres_gerais' => $consultarLideresAtivos,
					'dados_lideres_ativos' => $consultarLideresAtivos,
					'dados_criancas_gerais' => $total_criancas_geral,
					'dados_criancas_ativos' => $total_criancas_ativos,
					'mostrar_comparacao' => $opc2,
					'check_is_coord_query' => $check_is_coord_query,
				);

				return $dados;
			} else {
				$dados = array(
					'id_user' => $id_user,
					'dados_coordenadores_gerais' => $consultarCoordenadores,
					'dados_coordenadores_ativos' => $consultarCoordenadoresAtivos,
					'dados_lideres_gerais' => $consultarLideres,
					'dados_lideres_ativos' => $consultarLideresAtivos,
					'dados_criancas_gerais' => $total_criancas_geral,
					'dados_criancas_ativos' => $total_criancas_ativos,
					'mostrar_comparacao' => $opc2,
					'check_is_coord_query' => $check_is_coord_query,
				);

				return $dados;
			}
		}
	}

	public function gerar_excel()
	{
		$id_coordenador = $this->input->post("id_coordenador");
		$opc1 = $this->input->post("opc1");
		$opc2 = $this->input->post("opc2");

		$dataInicio = $this->input->post("dataInicio");
		$dataFim = $this->input->post("dataAte");

		$nivel = $this->input->post("nivel") ?? "lideres";

		$this->excel($id_coordenador, $opc1, $opc2, $dataInicio, $dataFim, $nivel);
	}

	public function excel($id_coordenador, $opc1, $opc2, $dataInicio, $dataFim, $nivel)
	{
		ob_start();

		$data = date('d/m/Y');

		$dados = $this->consultasBD($id_coordenador, $opc1, $opc2, '', $dataInicio, $dataFim, $nivel, false);

		$base = array(
			'opc1' => $opc1,
			'opc2' => $opc2,
			'dataInicio' => $dataInicio,
			'dataFim' => $dataFim,
		);

		$total_lideres_gerais = $dados['dados_lideres_gerais']['row'];
		$dados_lideres_gerais = $dados['dados_lideres_gerais']['dados'];

		$total_lideres_ativos = $dados['dados_lideres_ativos']['row'];
		$dados_lideres_ativos = $dados['dados_lideres_ativos']['dados'];

		$total_coordenadores_gerais = 0;
		$dados_coordenadores_gerais = [];

		$total_coordenadores_ativos = 0;
		$dados_coordenadores_ativos = [];

		$columns = $this->input->post("columns");
		$columns_pg = $this->input->post("columns_pg");
		$columns_coordenador = $this->input->post("columns_coordenador");

		$letras = LETRAS;

		//create PHPExcel object
		$excel = new PHPExcel();
		$excel->setActiveSheetIndex(0);

		if ($nivel == 'lideres') {
			$table1 = new PHPExcel_Worksheet($excel, 'Líderes');
			$excel->addSheet($table1);

			$table2 = new PHPExcel_Worksheet($excel, 'Informações Gerais');
			$excel->addSheet($table2);

			$excel->getActiveSheet()->setTitle("Crianças");

			$infos1 = array(
				'total_lideres_gerais' => $total_lideres_gerais,
				'total_lideres_ativos' => $total_lideres_ativos,
				'dados_lideres_gerais' => $dados_lideres_gerais,
				'total_cri_geral' => $dados['dados_criancas_gerais'],
				'total_cri_ativas' => $dados['dados_criancas_ativos'],
			);

			//$this->planilha_info_gerais($excel, 2, $columns, $columns_pg, $infos1);
			//$this->planilha_info_criancas($excel, $total_lideres_gerais, $dados_lideres_gerais);
			//$this->planilha_info_lideres($excel, $dados_lideres_gerais, $dados_lideres_ativos);
		} else {
			$table1 = new PHPExcel_Worksheet($excel, 'Líderes');
			$excel->addSheet($table1);

			$table2 = new PHPExcel_Worksheet($excel, 'Coordenadores');
			$excel->addSheet($table2);

			$table3 = new PHPExcel_Worksheet($excel, 'Informações Gerais');
			$excel->addSheet($table3);

			$excel->getActiveSheet()->setTitle("Crianças");

			$total_coordenadores_gerais = $dados['dados_coordenadores_gerais']['row'];
			$dados_coordenadores_gerais = $dados['dados_coordenadores_gerais']['dados'];

			$total_coordenadores_ativos = $dados['dados_coordenadores_ativos']['row'];
			$dados_coordenadores_ativos = $dados['dados_coordenadores_ativos']['dados'];

			$infos1 = array(
				'total_coordenadores_gerais' => $total_coordenadores_gerais,
				'total_coordenadores_ativos' => $total_coordenadores_ativos,
				'dados_coordenadores_gerais' => $dados_coordenadores_gerais,
				'total_lideres_gerais' => $total_lideres_gerais,
				'total_lideres_ativos' => $total_lideres_ativos,
				'dados_lideres_gerais' => $dados_lideres_gerais,
				'total_cri_geral' => $dados['dados_criancas_gerais'],
				'total_cri_ativas' => $dados['dados_criancas_ativos'],
			);

			$this->planilha_info_gerais($excel, 3, $columns, $columns_coordenador, $columns_pg, $infos1, $base, $nivel);
			//$this->planilha_info_criancas($excel, $total_lideres_gerais, $dados_lideres_gerais);
			//$this->planilha_info_lideres($excel, $dados_lideres_gerais, $dados_lideres_ativos);
		}

		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats- officedocument.spreadsheetml.sheet; charset=UTF-8');
		header('Content-Disposition: attachment; filename=Planilha CAMP Brasil - Líderes (' . $data . ').xlsx');
		header('Cache-Control: max-age=0');
		$file = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$file->save('php://output');
		exit;
	}

	public function planilha_info_criancas($excel, $total_lideres_gerais, $dados_lideres_gerais)
	{
		$letras = LETRAS;

		// planilha crianças
		$colunas_titulo_3 = "B2";
		$excel->getSheet(0)->getStyle('B2')->getAlignment()->setHorizontal('center');
		$excel->getSheet(0)->setCellValue('B2', 'Crianças');

		$row3 = 4;
		$i_cl_5 = 1;
		$i_cl_6 = 1;
		$i_cl_7 = 1;

		$linha_descricao_para_pintar = [];
		$linha_nenhuma_crianca = [];
		$linha_borda = [];

		$columns2 = $this->input->post("columns_criancas");
		$bol_check_2_col_1 = false;
		$bol_check_2_col_2 = false;


		if ($total_lideres_gerais == 0) {
		} else {

			$excel->getSheet(0)->setCellValue($letras[$i_cl_5] . $row3, 'Líder');
			$i_cl_5++;

			foreach ($columns2 as $key => $coluna) {
				if ($coluna == 'column1') {
					$bol_check_2_col_1 = true;
					$excel->getSheet(0)->setCellValue($letras[$i_cl_5] . $row3, "Nome");
					$i_cl_5++;
				} else if ($coluna == 'column2') {
					$bol_check_2_col_2 = true;
					$excel->getSheet(0)->setCellValue($letras[$i_cl_5] . $row3, "Nascimento");
					$i_cl_5++;
				}
			}
			array_push($linha_descricao_para_pintar, $row3);
			$row3++;

			for ($i = 0; $i < count($dados_lideres_gerais); $i++) {

				$lider = $dados_lideres_gerais[$i];
				$id_lider = $lider['id_lider'];

				$info_criancas = $this->FConsultas_model->mostrarCriancasPais($id_lider, 3);

				if ($info_criancas['row'] == 0) {
					$excel->getSheet(0)->getColumnDimension($letras[$i_cl_7])->setAutoSize(true);
					$excel->getSheet(0)->setCellValue($letras[$i_cl_7] . $row3, $lider['nome_lider']);
					array_push($linha_borda, $letras[$i_cl_7] . $row3);
					$i_cl_7++;
					$excel->getSheet(0)->setCellValue($letras[$i_cl_7] . $row3, "Nenhuma Criança");
					array_push($linha_nenhuma_crianca, $row3);
					$i_cl_7 = 1;
					$row3++;
				} else {
					foreach ($info_criancas['dados'] as $linha  => $crianca) {
						$excel->getSheet(0)->getColumnDimension($letras[$i_cl_7])->setAutoSize(true);
						$excel->getSheet(0)->setCellValue($letras[$i_cl_7] . $row3, $lider['nome_lider']);
						array_push($linha_borda, $letras[$i_cl_7] . $row3);
						$i_cl_7++;
						if ($bol_check_2_col_1) {
							$excel->getSheet(0)->getColumnDimension($letras[$i_cl_7])->setAutoSize(true);
							$excel->getSheet(0)->setCellValue($letras[$i_cl_7] . $row3, $crianca['nome_crianca']);
							array_push($linha_borda, $letras[$i_cl_7] . $row3);
							$i_cl_7++;
						}
						if ($bol_check_2_col_2) {
							$excel->getSheet(0)->getColumnDimension($letras[$i_cl_7])->setAutoSize(true);
							$excel->getSheet(0)->setCellValue($letras[$i_cl_7] . $row3, $crianca['nascimento']);
							array_push($linha_borda, $letras[$i_cl_7] . $row3);
							$i_cl_7++;
						}
						$i_cl_7 = 1;
						$row3++;
					}
				}
			}
		}

		if ($bol_check_2_col_1) {
			$i_cl_6 = $i_cl_6 + 1;
		}
		if ($bol_check_2_col_2) {
			$i_cl_6 = $i_cl_6 + 1;
		}

		// style title
		$colunas_titulo_3 = "";
		if ($i_cl_6 == 1 || $i_cl_6 == 2) {
			$colunas_titulo_3 = "B2";
		} else {
			$colunas_titulo_3 = "B2:D2";
		}

		if ($i_cl_6 == 1 || $i_cl_6 == 2) {
		} else {
			$excel->getSheet(0)->mergeCells($colunas_titulo_3);
		}

		$excel->getSheet(0)->getStyle($colunas_titulo_3)->applyFromArray(
			array(
				'font' => array(
					'bold' => true,
					'size' => 24,
				),
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
					'rotation' => 90,
					'startcolor' => array(
						'argb' => 'FFA0A0A0',
					),
					'endcolor' => array(
						'argb' => 'FFFFFFFF',
					),
				),
			)
		);
		// fim title

		// style colunas info crianças
		foreach ($linha_descricao_para_pintar as $key => $linha) {
			$linhas_descricoes_criancas = $letras[1] . $linha . ":" . $letras[$i_cl_5 - 1] . $linha;
			$excel->getSheet(0)->getStyle($linhas_descricoes_criancas)->applyFromArray(
				array(
					'font' => array(
						'bold' => true
					),
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						)
					),
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'rotation' => 90,
						'startcolor' => array(
							'argb' => 'FFA0A0A0',
						),
					),
				)
			);
		}
		// style colunas info crianças

		// style bordas nenhuma criança
		foreach ($linha_nenhuma_crianca as $key => $linha) {
			$nenhuma_crianca = $letras[2] . $linha . ":" . $letras[$i_cl_6] . $linha;
			$nenhuma_crianca2 = $letras[1] . $linha . ":" . $letras[$i_cl_6] . $linha;
			$excel->getSheet(0)->mergeCells($nenhuma_crianca);
			$excel->getSheet(0)->getStyle($nenhuma_crianca2)->applyFromArray(
				array(
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						)
					), 'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'rotation' => 90,
						'startcolor' => array(
							'argb' => 'FFE58782',
						),
					),
				)
			);
		}
		// style bordas nenhuma criança

		// style bordas
		foreach ($linha_borda as $key => $linha) {
			$excel->getSheet(0)->getStyle($linha)->applyFromArray(
				array(
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						)
					),
				)
			);
		}
		// style bordas

		$excel->getSheet(0)->getStyle('B4:Z' . $row3)->getAlignment()->setHorizontal('center');
		// planilha crianças
	}

	public function planilha_info_lideres($excel, $dados_lideres_gerais, $dados_lideres_ativos)
	{
		$letras = LETRAS;

		// planilha líderes
		$colunas_titulo_2 = "B2";
		$excel->getSheet(1)->getStyle('B2')->getAlignment()->setHorizontal('center');
		$excel->getSheet(1)->setCellValue('B2', 'Líderes');

		$i_cl_2 = 1;

		$columns1 = $this->input->post("columns_lideres");

		$bol_check_col_1 = false;
		$bol_check_col_2 = false;
		$bol_check_col_3 = false;
		$bol_check_col_4 = false;
		$bol_check_col_5 = false;
		$bol_check_col_6 = false;

		foreach ($columns1 as $key => $coluna) {
			$excel->getSheet(1)->getColumnDimension($letras[$i_cl_2])->setAutoSize(true);
			if ($coluna == 'column1') {
				$bol_check_col_1 = true;
				$excel->getSheet(1)->setCellValue($letras[$i_cl_2] . '4', 'Nome');
				$i_cl_2++;
			} else if ($coluna == 'column2') {
				$bol_check_col_2 = true;
				$excel->getSheet(1)->setCellValue($letras[$i_cl_2] . '4', 'E-mail');
				$i_cl_2++;
			} else if ($coluna == 'column3') {
				$bol_check_col_3 = true;
				$excel->getSheet(1)->setCellValue($letras[$i_cl_2] . '4', 'Telefone');
				$i_cl_2++;
			} else if ($coluna == 'column4') {
				$bol_check_col_4 = true;
				$excel->getSheet(1)->setCellValue($letras[$i_cl_2] . '4', 'Pais');
				$i_cl_2++;
			} else if ($coluna == 'column5') {
				$bol_check_col_5 = true;
				$excel->getSheet(1)->setCellValue($letras[$i_cl_2] . '4', 'Estado');
				$i_cl_2++;
			} else if ($coluna == 'column6') {
				$bol_check_col_6 = true;
				$excel->getSheet(1)->setCellValue($letras[$i_cl_2] . '4', 'Cidade');
				$i_cl_2++;
			}
		}

		if ($i_cl_2 == 1 || $i_cl_2 == 2) {
		} else if ($i_cl_2 == 3) {
			$colunas_titulo_2 = $colunas_titulo_2 . ":C2";
		} else if ($i_cl_2 == 4) {
			$colunas_titulo_2 = $colunas_titulo_2 . ":D2";
		} else if ($i_cl_2 == 5) {
			$colunas_titulo_2 = $colunas_titulo_2 . ":E2";
		} else if ($i_cl_2 == 6) {
			$colunas_titulo_2 = $colunas_titulo_2 . ":F2";
		} else if ($i_cl_2 == 7) {
			$colunas_titulo_2 = $colunas_titulo_2 . ":G2";
		}

		if ($i_cl_2 == 1 || $i_cl_2 == 2) {
		} else {
			$excel->getSheet(1)->mergeCells($colunas_titulo_2);
		}

		// style to title
		$excel->getSheet(1)->getStyle($colunas_titulo_2)->applyFromArray(
			array(
				'font' => array(
					'bold' => true,
					'size' => 24,
				),
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
					'rotation' => 90,
					'startcolor' => array(
						'argb' => 'FFA0A0A0',
					),
					'endcolor' => array(
						'argb' => 'FFFFFFFF',
					),
				),
			)
		);
		// fim title

		$colunas_lideres = $letras[1] . "4:" . $letras[$i_cl_2 - 1] . "4";

		// style to columns descricao
		$excel->getSheet(1)->getStyle($colunas_lideres)->applyFromArray(
			array(
				'font' => array(
					'bold' => true
				),
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'rotation' => 90,
					'startcolor' => array(
						'argb' => 'FFA0A0A0',
					),
				),
			)
		);
		// style to columns descricao

		$row2 = 5;

		$i_cl_3 = 1;
		$lideres_n_ativos_row = [];

		for ($i = 0; $i < count($dados_lideres_gerais); $i++) {
			$excel->getSheet(1)->getColumnDimension($letras[$i_cl_3])->setAutoSize(true);
			$lideres = $dados_lideres_gerais[$i];

			if (in_array($lideres, $dados_lideres_ativos)) {
			} else {
				array_push($lideres_n_ativos_row, $row2);
			}

			if ($bol_check_col_1) {
				$excel->getSheet(1)->setCellValue($letras[$i_cl_3] . $row2, $lideres['nome_lider']);
				$i_cl_3++;
			}
			if ($bol_check_col_2) {
				$excel->getSheet(1)->setCellValue($letras[$i_cl_3] . $row2, $lideres['email']);
				$i_cl_3++;
			}
			if ($bol_check_col_3) {
				$excel->getSheet(1)->setCellValue($letras[$i_cl_3] . $row2, $lideres['telefone_whatsapp']);
				$i_cl_3++;
			}
			if ($bol_check_col_4) {
				$nome_pais = "";
				if ($lideres['pais'] == 'br') {
					$nome_pais = "Brasil";
				} else {
					$nome_pais = $lideres['pais'];
				}
				$excel->getSheet(1)->setCellValue($letras[$i_cl_3] . $row2, $nome_pais);
				$i_cl_3++;
			}
			if ($bol_check_col_5) {
				$excel->getSheet(1)->setCellValue($letras[$i_cl_3] . $row2, $lideres['estado']);
				$i_cl_3++;
			}
			if ($bol_check_col_6) {
				$excel->getSheet(1)->setCellValue($letras[$i_cl_3] . $row2, $lideres['cidade']);
			}
			$row2++;
			$i_cl_3 = 1;
		}

		$linhas_2 = $row2 - 1;
		$colunas_dados_lideres = $letras[1] . "4:" . $letras[$i_cl_2 - 1] . $linhas_2;

		// style to columns descricao
		$excel->getSheet(1)->getStyle($colunas_dados_lideres)->applyFromArray(
			array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				),
			)
		);

		foreach ($lideres_n_ativos_row as $key => $linha) {
			$colunas_dados_lideres = $letras[1] . $linha . ":" . $letras[$i_cl_2 - 1] . $linha;

			// style to columns descricao
			$excel->getSheet(1)->getStyle($colunas_dados_lideres)->applyFromArray(
				array(
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'rotation' => 90,
						'startcolor' => array(
							'argb' => 'FFE58782',
						),
					),
				)
			);
		}
		// style to columns descricao
		$excel->getSheet(1)->getStyle('B4:Z' . $row2)->getAlignment()->setHorizontal('center');
		// planilha líderes
	}

	public function planilha_info_gerais($excel, $table, $columns, $columns_coord, $columns_pg, $infos, $base, $nivel)
	{
		$letras = LETRAS;
		// planilha informações gerais
		$row = 5;

		//tile
		$excel->getSheet($table)->setCellValue('B2', 'CAMP Brasil');

		$colunas_titulo_1 = "B2";
		$excel->getSheet($table)->getStyle('B2')->getAlignment()->setHorizontal('center');

		$i_cl_1 = 1;

		foreach ($columns as $key => $coluna) {
			$excel->getSheet($table)->getColumnDimension($letras[$i_cl_1])->setAutoSize(true);
			if ($coluna == 'total_coordenadores_1') {
				$excel->getSheet($table)->setCellValue($letras[$i_cl_1] . '4', 'Total de Coordenadores');
				$excel->getSheet($table)->setCellValue($letras[$i_cl_1] . $row, $infos['total_coordenadores_gerais']);
				$i_cl_1++; // 2
			} else if ($coluna == 'total_coordenadores_2') {
				$excel->getSheet($table)->setCellValue($letras[$i_cl_1] . '4', 'Total de Coordenadores Ativos');
				$excel->getSheet($table)->setCellValue($letras[$i_cl_1] . $row, $infos['total_coordenadores_gerais']);
				$i_cl_1++; // 3
			} else if ($coluna == 'total_lideres_1') {
				$excel->getSheet($table)->setCellValue($letras[$i_cl_1] . '4', 'Total de Líderes');
				$excel->getSheet($table)->setCellValue($letras[$i_cl_1] . $row, $infos['total_lideres_gerais']);
				$i_cl_1++; // 4
			} else if ($coluna == 'total_lideres_2') {
				$excel->getSheet($table)->setCellValue($letras[$i_cl_1] . '4', 'Total de Líderes Ativos');
				$excel->getSheet($table)->setCellValue($letras[$i_cl_1] . $row, $infos['total_lideres_ativos']);
				$i_cl_1++; // 5
			} else if ($coluna == 'total_criancas_1') {
				$excel->getSheet($table)->setCellValue($letras[$i_cl_1] . '4', 'Total de Crianças');
				$excel->getSheet($table)->setCellValue($letras[$i_cl_1] . $row, $infos['total_cri_geral']);
				$i_cl_1++; // 6
			} else if ($coluna == 'total_criancas_2') {
				$excel->getSheet($table)->setCellValue($letras[$i_cl_1] . '4', 'Total de Crianças Ativas');
				$excel->getSheet($table)->setCellValue($letras[$i_cl_1]  . $row, $infos['total_cri_ativas']);
				$i_cl_1++; // 7
			}
		}

		$colunas_descricao = "";

		if ($i_cl_1 == 1 || $i_cl_1 == 2) {
			$colunas_descricao = "B4";
		} else if ($i_cl_1 == 3) {
			$colunas_titulo_1 = $colunas_titulo_1 . ":C2";
			$colunas_descricao = "B4:C4";
		} else if ($i_cl_1 == 4) {
			$colunas_titulo_1 = $colunas_titulo_1 . ":D2";
			$colunas_descricao = "B4:D4";
		} else if ($i_cl_1 == 5) {
			$colunas_titulo_1 = $colunas_titulo_1 . ":E2";
			$colunas_descricao = "B4:E4";
		} else if ($i_cl_1 == 6) {
			$colunas_titulo_1 = $colunas_titulo_1 . ":F2";
			$colunas_descricao = "B4:F4";
		} else if ($i_cl_1 == 7) {
			$colunas_titulo_1 = $colunas_titulo_1 . ":G2";
			$colunas_descricao = "B4:G4";
		}

		if ($i_cl_1 == 1) {
		} else {
			$excel->getSheet($table)->mergeCells($colunas_titulo_1);
		}

		// style to title
		$excel->getSheet($table)->getStyle($colunas_titulo_1)->applyFromArray(
			array(
				'font' => array(
					'bold' => true,
					'size' => 24,
				),
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
					'rotation' => 90,
					'startcolor' => array(
						'argb' => 'FFA0A0A0',
					),
					'endcolor' => array(
						'argb' => 'FFFFFFFF',
					),
				),
			)
		);
		// fim title

		// style to columns descricao
		$excel->getSheet($table)->getStyle($colunas_descricao)->applyFromArray(
			array(
				'font' => array(
					'bold' => true
				),
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'rotation' => 90,
					'startcolor' => array(
						'argb' => 'FFA0A0A0',
					),
				),
			)
		);

		$colunas_dados_lideres = $letras[1] . "5:" . $letras[$i_cl_1 - 1] . "5";

		// style to columns descricao
		$excel->getSheet($table)->getStyle($colunas_dados_lideres)->applyFromArray(
			array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				),
			)
		);
		// style to columns descricao

		// informações dos coordenadores
		if ($nivel == 'coordenadores') {
			$i_cl_coord = 1;

			$bol_check_col_1 = false;
			$bol_check_col_2 = false;
			$bol_check_col_3 = false;
			$bol_check_col_4 = false;

			$row++;
			$row++;

			$excel->getSheet($table)->setCellValue($letras[$i_cl_coord] . $row, 'Coordenador');
			$i_cl_coord++;

			foreach ($columns_coord as $key => $coluna) {
				$excel->getSheet($table)->getColumnDimension($letras[$i_cl_coord])->setAutoSize(true);

				if ($coluna == 'column7') {
					$bol_check_col_1 = true;
					$excel->getSheet($table)->setCellValue($letras[$i_cl_coord] . $row, 'Total de Líderes');
					$i_cl_coord++;
				} else if ($coluna == 'column8') {
					$bol_check_col_2 = true;
					$excel->getSheet($table)->setCellValue($letras[$i_cl_coord] . $row, 'Total de Líderes Ativos');
					$i_cl_coord++;
				} else if ($coluna == 'column9') {
					$bol_check_col_3 = true;
					$excel->getSheet($table)->setCellValue($letras[$i_cl_coord] . $row, 'Total de Crianças');
					$i_cl_coord++;
				} else if ($coluna == 'column10') {
					$bol_check_col_4 = true;
					$excel->getSheet($table)->setCellValue($letras[$i_cl_coord] . $row, 'Total de Crianças Ativas');
					$i_cl_coord++;
				}
			}

			$colunas_coordenadores = $letras[1] . $row . ":" . $letras[$i_cl_coord - 1] . $row;

			// style to columns descricao
			$excel->getSheet($table)->getStyle($colunas_coordenadores)->applyFromArray(
				array(
					'font' => array(
						'bold' => true
					),
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						)
					),
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'rotation' => 90,
						'startcolor' => array(
							'argb' => 'FFA0A0A0',
						),
					),
				)
			);
			// style to columns descricao

			$row++;
			$row3 = $row;

			$i_cl_coord_2 = 1;
			$coord_n_ativos_row = [];

			$columns_coordenador_2 = $this->input->post("columns_coordenador_2");

			$mostar_info_todos_coord = true;
			$so_mostrar_coord_ativos = false;
			$so_mostrar_coord_inativos = false;

			if (count($columns_coordenador_2) == 0 || count($columns_coordenador_2) == 2) {
			} else {
				foreach ($columns_coordenador_2 as $key => $coluna) {
					if ($coluna == 'column11') {
						$so_mostrar_coord_ativos = true;
					}

					if ($coluna == 'column12') {
						$so_mostrar_coord_inativos = true;
					}
				}
			}


			for ($i = 0; $i < count($infos['dados_coordenadores_gerais']); $i++) {
				$coordenador = $infos['dados_coordenadores_gerais'][$i];
				$id_coordenador = $coordenador['id_coordenador'];

				$excel->getSheet($table)->getColumnDimension($letras[$i_cl_pg2])->setAutoSize(true);

				$dados_coord = $this->consultasBD([$id_coordenador], $base['opc1'], $base['opc2'], '', $base['dataInicio'], $base['dataFim'], $nivel, false);

				if ($mostar_info_todos_coord) {
					/*if (!$check) {
						array_push($pg_n_ativos_row, $row2);
					} else {
					}*/
					$excel->getSheet($table)->setCellValue($letras[$i_cl_pg2] . $row2, $coordenador['nome_coordenador']);
					$i_cl_pg2++;

					if ($bol_check_col_1) {
						$excel->getSheet($table)->setCellValue($letras[$i_cl_pg2] . $row2, $dados_coord['dados_lideres_gerais']['row']);
						$i_cl_pg2++;
					}
					if ($bol_check_col_2) {
						$excel->getSheet($table)->setCellValue($letras[$i_cl_pg2] . $row2, $dados_coord['dados_lideres_ativos']['row']);
						$i_cl_pg2++;
					}
					if ($bol_check_col_3) {
						$excel->getSheet($table)->setCellValue($letras[$i_cl_pg2] . $row2, $dados_coord['dados_criancas_gerais']);
						$i_cl_pg2++;
					}
					if ($bol_check_col_4) {
						$excel->getSheet($table)->setCellValue($letras[$i_cl_pg2] . $row2, $dados_coord['dados_criancas_ativos']);
						$i_cl_pg2++;
					}
					$row2++;
					$i_cl_pg2 = 1;
				}
			}
		} else {
		}

		// informações dos pgs
		$i_cl_pg = 1;

		$bol_check_col_1 = false;
		$bol_check_col_2 = false;
		$bol_check_col_3 = false;
		$bol_check_col_4 = false;

		$row++;
		$row++;

		$excel->getSheet($table)->setCellValue($letras[$i_cl_pg] . $row, 'Líder');
		$i_cl_pg++;

		foreach ($columns_pg as $key => $coluna) {
			$excel->getSheet($table)->getColumnDimension($letras[$i_cl_pg])->setAutoSize(true);

			if ($coluna == 'column1') {
				$bol_check_col_1 = true;
				$excel->getSheet($table)->setCellValue($letras[$i_cl_pg] . $row, 'Quantidade de Crianças');
				$i_cl_pg++;
			} else if ($coluna == 'column2') {
				$bol_check_col_2 = true;
				$excel->getSheet($table)->setCellValue($letras[$i_cl_pg] . $row, 'Ciclo');
				$i_cl_pg++;
			} else if ($coluna == 'column3') {
				$bol_check_col_3 = true;
				$excel->getSheet($table)->setCellValue($letras[$i_cl_pg] . $row, 'Módulo');
				$i_cl_pg++;
			} else if ($coluna == 'column4') {
				$bol_check_col_4 = true;
				$excel->getSheet($table)->setCellValue($letras[$i_cl_pg] . $row, 'Lição');
				$i_cl_pg++;
			}
		}

		$colunas_lideres = $letras[1] . $row . ":" . $letras[$i_cl_pg - 1] . $row;

		// style to columns descricao
		$excel->getSheet($table)->getStyle($colunas_lideres)->applyFromArray(
			array(
				'font' => array(
					'bold' => true
				),
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'rotation' => 90,
					'startcolor' => array(
						'argb' => 'FFA0A0A0',
					),
				),
			)
		);
		// style to columns descricao

		$row++;
		$row2 = $row;

		$i_cl_pg2 = 1;
		$pg_n_ativos_row = [];

		$columns_pg_2 = $this->input->post("columns_pg_2");

		$mostar_info_todos_pg = true;
		$so_mostrar_ativos = false;
		$so_mostrar_inativos = false;

		if (count($columns_pg_2) == 0 || count($columns_pg_2) == 2) {
		} else {
			foreach ($columns_pg_2 as $key => $coluna) {
				if ($coluna == 'pg_ativos') {
					$so_mostrar_ativos = true;
				}

				if ($coluna == 'pg_inativos') {
					$so_mostrar_inativos = true;
				}
			}
		}

		for ($i = 0; $i < count($infos['dados_lideres_gerais']); $i++) {
			$lider = $infos['dados_lideres_gerais'][$i];
			$id_lider = $lider['id_lider'];
			$data_cadastro = $lider['data_cadastro'];
			$confirmado = $lider['confirmado'];

			$excel->getSheet($table)->getColumnDimension($letras[$i_cl_pg2])->setAutoSize(true);

			$info_criancas = $this->FConsultas_model->mostrarCriancasPais($id_lider, 3);
			$info_pg = $this->FConsultas_model->mostrarPG($id_lider, 3);

			$check = $this->FConsultas_model->check_lider_is_ativo($id_lider, $data_cadastro, $confirmado);

			if ($mostar_info_todos_pg) {
				if (!$check) {
					array_push($pg_n_ativos_row, $row2);
				} else {
				}
				$excel->getSheet($table)->setCellValue($letras[$i_cl_pg2] . $row2, $lider['nome_lider']);
				$i_cl_pg2++;

				if ($bol_check_col_1) {
					$excel->getSheet($table)->setCellValue($letras[$i_cl_pg2] . $row2, $info_criancas['row']);
					$i_cl_pg2++;
				}
				if ($bol_check_col_2) {
					$nome_ciclo = "";
					if ($info_pg['dados']['ano'] == 1) {
						$nome_ciclo = "1º Ciclo";
					} else if ($info_pg['dados']['ano'] == 2) {
						$nome_ciclo = "2º Ciclo";
					} else if ($info_pg['dados']['ano'] == 3) {
						$nome_ciclo = "3º Ciclo";
					}
					$excel->getSheet($table)->setCellValue($letras[$i_cl_pg2] . $row2, $nome_ciclo);
					$i_cl_pg2++;
				}
				if ($bol_check_col_3) {
					$id_modulo = $info_pg['dados']['id_modulo'];
					$modulo = $this->FConsultas_model->consultarModuloId($id_modulo);
					$nome_modulo = $modulo['nome_modulo'];
					$excel->getSheet($table)->setCellValue($letras[$i_cl_pg2] . $row2, $nome_modulo);
					$i_cl_pg2++;
				}
				if ($bol_check_col_4) {
					$excel->getSheet($table)->setCellValue($letras[$i_cl_pg2] . $row2, $info_pg['dados']['n_licao']);
					$i_cl_pg2++;
				}
				$row2++;
				$i_cl_pg2 = 1;
			} else if ($so_mostrar_ativos) {
				if ($check) {
					$excel->getSheet($table)->setCellValue($letras[$i_cl_pg2] . $row2, $lider['nome_lider']);
					$i_cl_pg2++;

					if ($bol_check_col_1) {
						$excel->getSheet($table)->setCellValue($letras[$i_cl_pg2] . $row2, $info_criancas['row']);
						$i_cl_pg2++;
					}
					if ($bol_check_col_2) {
						$nome_ciclo = "";
						if ($info_pg['dados']['ano'] == 1) {
							$nome_ciclo = "1º Ciclo";
						} else if ($info_pg['dados']['ano'] == 2) {
							$nome_ciclo = "2º Ciclo";
						} else if ($info_pg['dados']['ano'] == 3) {
							$nome_ciclo = "3º Ciclo";
						}
						$excel->getSheet($table)->setCellValue($letras[$i_cl_pg2] . $row2, $nome_ciclo);
						$i_cl_pg2++;
					}
					if ($bol_check_col_3) {
						$id_modulo = $info_pg['dados']['id_modulo'];
						$modulo = $this->FConsultas_model->consultarModuloId($id_modulo);
						$nome_modulo = $modulo['nome_modulo'];
						$excel->getSheet($table)->setCellValue($letras[$i_cl_pg2] . $row2, $nome_modulo);
						$i_cl_pg2++;
					}
					if ($bol_check_col_4) {
						$excel->getSheet($table)->setCellValue($letras[$i_cl_pg2] . $row2, $info_pg['dados']['n_licao']);
						$i_cl_pg2++;
					}
					$row2++;
					$i_cl_pg2 = 1;
				} else {
				}
			} else if ($so_mostrar_inativos) {
				if (!$check) {
					array_push($pg_n_ativos_row, $row2);
					$excel->getSheet($table)->setCellValue($letras[$i_cl_pg2] . $row2, $lider['nome_lider']);
					$i_cl_pg2++;

					if ($bol_check_col_1) {
						$excel->getSheet($table)->setCellValue($letras[$i_cl_pg2] . $row2, $info_criancas['row']);
						$i_cl_pg2++;
					}
					if ($bol_check_col_2) {
						$nome_ciclo = "";
						if ($info_pg['dados']['ano'] == 1) {
							$nome_ciclo = "1º Ciclo";
						} else if ($info_pg['dados']['ano'] == 2) {
							$nome_ciclo = "2º Ciclo";
						} else if ($info_pg['dados']['ano'] == 3) {
							$nome_ciclo = "3º Ciclo";
						}
						$excel->getSheet($table)->setCellValue($letras[$i_cl_pg2] . $row2, $nome_ciclo);
						$i_cl_pg2++;
					}
					if ($bol_check_col_3) {
						$id_modulo = $info_pg['dados']['id_modulo'];
						$modulo = $this->FConsultas_model->consultarModuloId($id_modulo);
						$nome_modulo = $modulo['nome_modulo'];
						$excel->getSheet($table)->setCellValue($letras[$i_cl_pg2] . $row2, $nome_modulo);
						$i_cl_pg2++;
					}
					if ($bol_check_col_4) {
						$excel->getSheet($table)->setCellValue($letras[$i_cl_pg2] . $row2, $info_pg['dados']['n_licao']);
						$i_cl_pg2++;
					}
					$row2++;
					$i_cl_pg2 = 1;
				} else {
				}
			}
		}

		$linhas_2 = $row2 - 1;
		$colunas_dados_lideres = $letras[1] . $row . ":" . $letras[$i_cl_pg - 1] . $linhas_2;

		// style to columns descricao
		$excel->getSheet($table)->getStyle($colunas_dados_lideres)->applyFromArray(
			array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				),
			)
		);

		foreach ($pg_n_ativos_row as $key => $linha) {
			$colunas_dados_lideres = $letras[1] . $linha . ":" . $letras[$i_cl_pg - 1] . $linha;

			// style to columns descricao
			$excel->getSheet($table)->getStyle($colunas_dados_lideres)->applyFromArray(
				array(
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'rotation' => 90,
						'startcolor' => array(
							'argb' => 'FFE58782',
						),
					),
				)
			);
		}
		// style to columns descricao*/

		$excel->getSheet($table)->getStyle('B4:Z' . $row2)->getAlignment()->setHorizontal('center');
		// planilha informações gerais
	}

	// coordenador
	public function cadastrar_coordenador()
	{
		$nome = $this->input->post('nome');
		$cpf = $this->input->post('cpf');
		$email = $this->input->post('email');
		$telefone = $this->input->post('telefone');
		$pais = $this->input->post('pais');
		$estado1 = $this->input->post('estados');
		$cidade1 = $this->input->post('cidades');
		$estado2 = $this->input->post('estados2');
		$cidade2 = $this->input->post('cidades2');
		$nascimento = $this->input->post('nascimento');

		$id_slocal = $this->input->post('id_slocal');
		$id_sregional = $this->input->post('id_sregional');

		$estado = "";
		$cidade = "";

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

		$red = $this->input->post('red') ?? 'slocal';
		$nivel_routa = $this->input->post("nivel_routa") ?? 'lider';
		$routa = "coordenadores";
		$data = [];

		if ($this->FAlerta_model->ValidaData($nascimento)) {
			$consultarCoord = $this->FConsultas_model->consultarLiderJaCadastrado($nome, $cpf, $cpf_completo, $email);
			$consultarUsuario = $this->FConsultas_model->consultarUsuarioCadastrado($nome, $cpf,  $cpf_completo, $email);

			if ($consultarCoord || $consultarUsuario) {
				$nivel = 1;
				$cadastro = $this->FSistema_model->cadastro_coordenador($nome, $cpf_completo, $email, $telefone, $nascimento, $pais, $estado, $cidade, $id_slocal, $id_sregional);
				$cadastroUsuario = $this->FSistema_model->cadastrarUsuário($nome, $email, $cpf_completo, $nivel);
				if ($cadastro && $cadastroUsuario) {
					$this->FConsultas_model->mensagem('success', 'Sucesso!', ["Coordenador cadastrado com Sucesso!"]);
					$funcao = $this->FConsultas_model->red("../$routa", 2000, $data);
					echo $funcao;
				} else {
					$this->FConsultas_model->mensagem('danger', 'Erro!', ["Tente Novamente!"]);
					$funcao = $this->FConsultas_model->red("../$routa", 2000, $data);
					echo $funcao;
				}
			} else {
				$this->FConsultas_model->mensagem('danger', 'Erro!', ["Coordenador já Cadastrado!"]);
				$funcao = $this->FConsultas_model->red("../$routa", 2000, $data);
				echo $funcao;
			}
		} else {
			$this->FConsultas_model->mensagem('danger', 'Erro!', ["Data de Nascimento Inválida!"]);
			$funcao = $this->FConsultas_model->red("../$routa", 2000, $data);
			echo $funcao;
		}
	}

	public function desativar_coordenador()
	{
		$id_coordenador = $this->input->post("id_coordenador");
		$id_usuario = $this->input->post("id_usuario");
		$motivo = "O usuário de ID (" . $id_usuario . ") desativou esse líder";

		$infos = $this->FConsultas_model->getInfoUserId($id_coordenador);
		$infonome = $this->FConsultas_model->getNomeUserId($id_coordenador);

		// desativar pg
		$consultaPG = $this->FConsultas_model->mostrarPG($id_coordenador, 5);
		$dadosPG = $consultaPG['dados'];

		if ($consultaPG['row'] == 0) {
		} else {
			foreach ($dadosPG as $key => $pg) {
				$this->FSistema_model->excluirPG($pg['id_pg'], $pg['nome_pg'], $id_coordenador, $id_usuario, $motivo, 2);
			}
		}

		// desativar crianças
		$consultaCriancas = $this->FConsultas_model->mostrarCriancasPais($id_coordenador, 2);
		$dadosCriancas = $consultaCriancas['dados'];

		if ($consultaCriancas['row'] == 0) {
		} else {
			foreach ($dadosCriancas as $key => $criancas) {
				$this->FSistema_model->excluirCrianca($criancas['id_crianca'], $criancas['nome_crianca'], $id_coordenador, $id_usuario, $motivo, 2);
			}
		}

		// mudar o ativo do líder
		$this->FSistema_model->desativarUsuário($infonome['nome'], $infos['dados']['email'], $infos['dados']['cpf']);
		$this->FSistema_model->desativar_coordenador($id_coordenador);

		$this->FAlerta_model->alerta_controle($id_usuario, $id_coordenador, $motivo, "EX_CL_4");

		$nivel_routa = $this->input->post('nivel_routa') ?? 'lider';
		$id_coord = $this->input->post('id_coord');

		$red = $this->input->post('red') ?? 'coordenador';
		$routa = "";
		$data = [];

		if ($red == 'coordenador') {
			$routa = "page/coordenadores/detalhes/$id_coordenador";
		} else {
			$routa = "page/coordenadores/detalhes/$id_coordenador";
		}

		$this->FConsultas_model->mensagem('success', 'Sucesso!', ["Coordenador desativado!"]);
		$funcao = $this->FConsultas_model->red("../../$routa", 2000, $data);
		echo $funcao;
	}

	public function ativar_coordenador()
	{
		$id_coordenador = $this->input->post("opc");
		$id_usuario = $this->input->post("idUsuario");
		$infos = $this->FConsultas_model->getInfoUserId($id_coordenador);
		$infonome = $this->FConsultas_model->getNomeUserId($id_coordenador);

		// desativar pg
		$consultaPG = $this->FConsultas_model->mostrarPG($id_coordenador, 5);
		$dadosPG = $consultaPG['dados'];

		if ($consultaPG['row'] == 0) {
		} else {
			foreach ($dadosPG as $key => $pg) {
				$this->FSistema_model->reativarPg($pg['id_pg'], $id_usuario, 2);
			}
		}

		// desativar crianças
		$consultaCriancas = $this->FConsultas_model->mostrarCriancasPais($id_coordenador, 2);
		$dadosCriancas = $consultaCriancas['dados'];

		if ($consultaCriancas['row'] == 0) {
		} else {
			foreach ($dadosCriancas as $key => $criancas) {
				$this->FSistema_model->reativarCrianca($criancas['id_crianca'], 2);
			}
		}

		// mudar o ativo do líder
		$this->FSistema_model->ativarUsuário($infonome['nome'], $infos['dados']['email'], $infos['dados']['cpf']);
		$this->FSistema_model->ativar_coordenador($id_coordenador);

		$red = $this->input->post('red') ?? 'coordenador';
		$routa = "";
		$data = [];

		if ($red == 'coordenador') {
			$routa = "page/coordenadores";
		} else if ($red == 'coordenador/detalhes') {
			$routa = "page/coordenadores/detalhes/$id_coordenador";
		} else {
			$routa = "page/coordenadores";
		}

		$this->FConsultas_model->mensagem('success', 'Sucesso!', ["Coordenador Ativado!"]);
		$funcao = $this->FConsultas_model->red("../../../$routa", 2000, $data);
		echo $funcao;
	}

	public function excluir_coordenador_permanentemente()
	{
		$id_coordenador = $this->input->post("opc");
		$id_usuario = $this->input->post("idUsuario");

		$infos = $this->FConsultas_model->getInfoUserId($id_coordenador);
		$infonome = $this->FConsultas_model->getNomeUserId($id_coordenador);

		// desativar pg
		$consultaPG = $this->FConsultas_model->mostrarPG($id_coordenador, 5);
		$dadosPG = $consultaPG['dados'];

		if ($consultaPG['row'] == 0) {
		} else {
			foreach ($dadosPG as $key => $pg) {
				$this->FSistema_model->excluirPgPermanentemente($pg['id_pg'], $id_coordenador, $id_usuario, 2);
			}
		}

		// desativar crianças
		$consultaCriancas = $this->FConsultas_model->mostrarCriancasPais($id_coordenador, 2);
		$dadosCriancas = $consultaCriancas['dados'];

		if ($consultaCriancas['row'] == 0) {
		} else {
			foreach ($dadosCriancas as $key => $criancas) {
				$this->FSistema_model->excluirCriancaPermanentemente($criancas['id_crianca'], $id_coordenador, $id_usuario, 2);
			}
		}

		$dados_colider = $this->FConsultas_model->mostrarColiderDoLider($id_coordenador);

		if ($dados_colider) {
			$this->FSistema_model->excluirColiderPermanentemente($dados_colider['id_colider'], $id_coordenador, $id_usuario);
		} else {
		}

		$dados_lider = $this->FConsultas_model->getLideres([$id_coordenador], 1, 2, []);

		if ($dados_lider['row'] == 0) {
		} else {
			foreach ($dados_lider['dados'] as $key => $lider) {
				$this->FSistema_model->editar_lider_exclusao_coord($lider['id_lider'], $id_coordenador, $id_usuario);
			}
		}

		// mudar o ativo do líder
		$this->FSistema_model->excluirUsuarioPermanentemente($infonome['nome'], $infos['dados']['email'], $infos['dados']['cpf']);
		$this->FSistema_model->excluirCoordenadorPermanentemente($id_coordenador, $id_usuario);

		$nivel_routa = $this->input->post('nivel_routa') ?? 'lider';
		$id_coord = $this->input->post('id_coord');

		$red = $this->input->post('red') ?? 'coordenador';
		$routa = "";
		$data = [];

		if ($red == 'coordenador') {
			$routa = "coordenadores";
		} else {
			$routa = "coordenadores";
		}

		$this->FConsultas_model->mensagem('success', 'Sucesso!', ["Líder Excluido Permanentemente!"]);
		$funcao = $this->FConsultas_model->red("../../$routa", 2000, $data);
		echo $funcao;
	}
}
