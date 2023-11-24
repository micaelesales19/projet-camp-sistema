<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property $input
 * @property FConsultas_model $FConsultas_model
 * @property FSistema_model $FSistema_model
 * @property $db
 * @property $upload
 * @property $email
 */

class Lider extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('America/Sao_Paulo');
		require_once 'import/sistema/fpdf/fpdf.php';
		define('PDF_PATH', 'import/sistema/temp/');
	}
	/* LÍDER */

	public function home()
	{
		$this->load->view('sistema/lider/home');
	}
	// Dados Pessoal
	public function pagina_editar_pessoal()
	{
		$this->load->view('sistema/lider/edicao/pagina_editar_pessoal');
	}

	public function e_pessoal()
	{
		$id = $this->input->post("id");
		$nome = $this->input->post("nome");
		$cpf = $this->input->post("cpf");
		$email = $this->input->post("email");
		$telefone = $this->input->post("telefone");
		$igreja = $this->input->post("igreja");
		$nascimento = $this->input->post("nascimento");
		$estado = $this->input->post("estados");
		$cidade = $this->input->post("cidades");

		$foto_antiga = $this->input->post("foto_antiga");

		$filesCount1 = count($_FILES['files']['name']);
		$filesCount2 = count($_FILES['filesColider']['name']);

		// Colider
		$id_colider = $this->input->post("id_colider");
		$nome_colider = $this->input->post("nome_colider");
		$cpf_colider = $this->input->post("cpf_colider");
		$email_colider = $this->input->post("email_colider");
		$telefone_colider = $this->input->post("telefone_colider");
		$nascimento_colider = $this->input->post("nascimento_colider");
		$foto_antiga_colider = $this->input->post("foto_antiga_colider");

		$mensagem = [];

		// Pais
		for ($i = 0; $i < $filesCount1; $i++) {
			$_FILES['file']['name']     = $_FILES['files']['name'][$i];
			$_FILES['file']['type']     = $_FILES['files']['type'][$i];
			$_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
			$_FILES['file']['error']     = $_FILES['files']['error'][$i];
			$_FILES['file']['size']     = $_FILES['files']['size'][$i];

			$uploadPath = 'import/sistema/fotoU/lider/';
			$foto = 'fotoU/lider/' . $_FILES['files']['name'][$i];

			if ($_FILES['files']['name'][$i] == '') {
				$cadastro = $this->FSistema_model->editarPessoalPais($id, $nome, $cpf, $email, $telefone, $igreja, $nascimento, $estado, $cidade, $foto_antiga);
				if ($cadastro) {
					array_push($mensagem, "Sucesso! Seus Dados foram Editados!");
				} else {
					array_push($mensagem, "Erro! Seus dados estão inválidos!");
				}
			} else {
				if ($foto_antiga == $foto) {
					$cadastro = $this->FSistema_model->editarPessoalPais($id, $nome, $cpf, $email, $telefone, $igreja, $nascimento, $estado, $cidade, $foto_antiga);
					if ($cadastro) {
						array_push($mensagem, "Sucesso! Seus Dados foram Editados!");
					} else {
						array_push($mensagem, "Erro! Seus dados estão inválidos!");
					}
				} else {
					if (file_exists($foto)) {
						$cadastro = $this->FSistema_model->editarPessoalPais($id, $nome, $cpf, $email, $telefone, $igreja, $nascimento, $estado, $cidade, $foto_antiga);
						if ($cadastro) {
							array_push($mensagem, "Sua foto já existe em nosso servidor, tente com outra foto com nome diferente!");
						} else {
							array_push($mensagem, "Erro! Seus dados estão inválidos!");
						}
					} else {
						// File upload configuration
						$config['upload_path'] = $uploadPath;
						$config['allowed_types'] = 'jpg|jpeg|png|gif';

						// Load and initialize upload library
						$this->load->library('upload', $config);
						$this->upload->initialize($config);

						// Upload file to server
						if ($this->upload->do_upload('file')) {
							$cadastro = $this->FSistema_model->editarPessoalPais($id, $nome, $cpf, $email, $telefone, $igreja, $nascimento, $estado, $cidade, $foto);
							if ($cadastro) {
								array_push($mensagem, "Sucesso! Seus Dados foram Editados!");
							} else {
								array_push($mensagem, "Erro! Seus dados estão inválidos!");
							}
						} else {
							$erros = $this->upload->display_errors() + " - meus dados pessoais";
							array_push($mensagem, $erros);
						}
					}
				}
			}
		}

		// Colíder
		for ($i = 0; $i < $filesCount2; $i++) {
			$_FILES['file']['name']     = $_FILES['filesColider']['name'][$i];
			$_FILES['file']['type']     = $_FILES['filesColider']['type'][$i];
			$_FILES['file']['tmp_name'] = $_FILES['filesColider']['tmp_name'][$i];
			$_FILES['file']['error']     = $_FILES['filesColider']['error'][$i];
			$_FILES['file']['size']     = $_FILES['filesColider']['size'][$i];

			$uploadPath = 'import/sistema/fotoU/colider/';
			$foto = 'fotoU/colider/' . $_FILES['filesColider']['name'][$i];

			if ($_FILES['filesColider']['name'][$i] == '') {
				$cadastro = $this->FSistema_model->editarColider($id_colider, $nome_colider, $cpf_colider, $email_colider, $telefone_colider, $nascimento_colider, $foto_antiga_colider);
				if ($cadastro) {
					array_push($mensagem, "Sucesso! Dados do seu colíder foram Editados!");
				} else {
					array_push($mensagem, "Erro! Dados do colíder estão inválidos!");
				}
			} else {
				if ($foto_antiga_colider == $foto) {
					$cadastro = $this->FSistema_model->editarColider($id_colider, $nome_colider, $cpf_colider, $email_colider, $telefone_colider, $nascimento_colider, $foto_antiga_colider);
					if ($cadastro) {
						array_push($mensagem, "Sucesso! Dados do seu colíder foram Editados!");
					} else {
						array_push($mensagem, "Erro! Dados do colíder estão inválidos!");
					}
				} else {
					if (file_exists($foto)) {
						$cadastro = $this->FSistema_model->editarColider($id_colider, $nome_colider, $cpf_colider, $email_colider, $telefone_colider, $nascimento_colider, $foto_antiga);
						if ($cadastro) {
							array_push($mensagem, "A foto do seu colíder já existe em nosso servidor, tente com outra foto com nome diferente!");
						} else {
							array_push($mensagem, "Erro! Dados do colíder estão inválidos!");
						}
					} else {
						// File upload configuration
						$config['upload_path'] = $uploadPath;
						$config['allowed_types'] = 'jpg|jpeg|png|gif';

						// Load and initialize upload library
						$this->load->library('upload', $config);
						$this->upload->initialize($config);

						// Upload file to server
						if ($this->upload->do_upload('file')) {
							$cadastro = $this->FSistema_model->editarColider($id_colider, $nome_colider, $cpf_colider, $email, $telefone_colider, $nascimento_colider, $foto);
							if ($cadastro) {
								array_push($mensagem, "Sucesso! Dados do seu colíder foram Editados!");
							} else {
								array_push($mensagem, "Erro! Dados do colíder estão inválidos!");
							}
						} else {
							$erros = $this->upload->display_errors() . " - colíder";
							array_push($mensagem, $erros);
						}
					}
				}
			}
		}

		// atualizarCriancas
		$nome_antigo = $this->input->post("nome_antigo");

		$consultarCriancas = $this->FConsultas_model->mostrarCriancasPais($id, 2);

		if ($consultarCriancas['row'] == 0) {
		} else {
			foreach ($consultarCriancas['dados'] as $key => $dadosCriancas) {
				$id = $dadosCriancas['id_crianca'];
				$nome_responsavel = $dadosCriancas['nome_responsavel'];

				if ($nome_responsavel == $nome_antigo) {
					$this->FSistema_model->editaCriancaResponsavel($id, $nome, $email, $telefone, 2);
				}
			}
		}

		//echo '<script>alert("' . implode("\\n", $mensagem) . '");</script>';
		echo '
			<script>
				if(window.confirm("' . implode("\\n", $mensagem) . '")) {
					window.location="pagina_editar_pessoal";
				}else{
					window.location="pagina_editar_pessoal";
				}
			</script>
		';
	}
	// Fim Dados Pessoal

	// Crianças
	public function pagina_visualizacao_criancas()
	{
		$this->load->view('sistema/lider/pages/pagina_ver_criancas');
	}

	public function pagina_cadastro_criancas()
	{
		$this->load->view('sistema/lider/cadastro/pagina_cadastro_crianca');
	}
	// Fim Crianças

	// PG
	public function pagina_visualizacao_pg()
	{
		$this->load->view('sistema/lider/pages/pagina_ver_pg');
	}

	public function pagina_ver_progresso()
	{
		$idLider = $this->input->get("id_lider");
		$idPg = $this->input->get("id_pg");

		$dadosPg = $this->FConsultas_model->mostrarPGId($idLider, $idPg, 2);

		if ($dadosPg['row'] == 0) {
			echo '
			<script>
				if(window.confirm("DADOS NÃO ENCONTRADO!")) {
					window.location="../pg";
				}else{
					window.location="../pg";
				}
			</script>
		';
		} else {
			$ano = $dadosPg['dados']['ano'];
			$modulo = $dadosPg['dados']['modulo_devocional'];
			$licao = $dadosPg['dados']['licao_devocional'];

			$dadosDevocionais = $this->FConsultas_model->consultarDevocionalModuloLicao($ano, $modulo, $licao);

			$dados = array(
				'pg' => $dadosPg['dados'],
				'devocionais_consulta' => $dadosDevocionais,
			);

			$this->load->view('sistema/lider/pages/pg/progresso', $dados);
		}
	}
	public function pagina_licoes()
	{

		$id_pg = $this->input->get("id_pg");
		$id_lider = $this->input->get("id_lider");
		$ano = $this->input->get("ano");

		$modulos = $this->FConsultas_model->consultarModuloAno($ano);
		$dadosPg = $this->FConsultas_model->mostrarPGId($id_lider, $id_pg, 2);

		$dados = array(
			'id_lider' => $id_lider,
			'id_pg' => $id_pg,
			'modulos' => $modulos,
			'pg' => $dadosPg,
		);

		$this->load->view('sistema/lider/pages/pg/licaos', $dados);
	}

	public function pagina_preenchimento_relatorio_pg()
	{
		$this->load->view('sistema/lider/pages/preenchimento_relatorio');
	}

	public function consulta_criancas_relatorios()
	{
		$this->load->view('sistema/lider/pages/consultas/retornar_infomacoes');
	}

	public function consulta_progresso_pg()
	{
		$id_lider = $this->input->get("id_lider");
		$id_pg = $this->input->get("id_pg");
		$id_modulo = $this->input->get("id_modulo");
		$total = $this->input->get("total");

		$dadosPg = $this->FConsultas_model->mostrarPGId($id_lider, $id_pg, 2);

		$dados = array(
			'id_lider' => $id_lider,
			'id_pg' => $id_pg,
			'id_modulo' => $id_modulo,
			'total' => $total,
			'pg' => $dadosPg['dados'],
		);

		$this->load->view('sistema/lider/pages/pg/linha', $dados);
	}
	public function enviarEmailcomArquivo()
	{

		/*Header("Content-type: image/png");
		$texto = $_GET["texto"];
		if ($texto == "") //Se a variavel estiver vazia preencha com um texto qualquer
		{
			$texto = "SALVA A AMAZONIA!";
		}

		$img_handle = imageCreateFromPNG("import/sistema/dist/img/modelo-2.png"); // informe o caminho e nome da imagem
		$color = ImageColorAllocate($img_handle, 100, 100, 100);
		$ip = $_SERVER['REMOTE_ADDR'];
		ImageString($img_handle, 331, 200, 300,  $texto . "   Seu IP: $ip", $color);
		ImagePng($img_handle);
		ImageDestroy($img_handle);

		$url = $img_handle;

		$ch = curl_init($url);

		$fp = fopen('diretorio/imagem-' . $i . '.jpg', 'wb');

		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);*/

		/*$pdf = new FPDF("L", "pt", array(1200, 700));
		$pdf->AddPage();
		$pdf->SetCreator('CAMP Brasil');
		$pdf->SetTitle('Tempo de Conversa - ' . $diaTexto . '');
		$pdf->Image('import/sistema/dist/img/modelo-1.jpg', 0, 168, 1200, 532);
		$pdf->SetXY(70, 30);
		$pdf->Image(base_url('import/sistema/dist/img/icone.png'), 30, 13, -100);
		$pdf->Ln(50);
		$pdf->SetFont('Helvetica', 'B', 32);
		$pdf->Cell(0, 5, $pdf->textoUTF8("Tempo de Conversa"), 0, 1, 'C');

		$pdf->SetFont('Helvetica', 'B', 30);
		$pdf->TextWithRotation(80, 478, $tituloTexto, 12, 0);
		$pdf->TextWithRotation(95, 580, $diaTexto, -5, 0);

		$pdf->SetFont('Helvetica', '', 22);
		$pdf->SetXY(650, 300);
		$pdf->MultiCell(350, 25, iconv('utf-8', 'cp1252', $dadosDevocionais['texto']), 0, 'J');

		$nomeFicheiro = "teste.pdf";
		//$pdf->Output('I', "teste.pdf");
		$pdf->Output(PDF_PATH . $nomeFicheiro, 'F');*/
	}

	public function atualizarDataPG()
	{
		$idPg = $this->input->get('id_pg');
		$idLider = $this->input->get('id_lider');
		$check = $this->input->get('check');
		$data = $this->input->get('data');

		if ($check == 'true' && $data == '') {

			$dataE = '00';

			$this->FSistema_model->editarData($idPg, $dataE, $dataE, $dataE, 2);
		} else if ($data == '') {
		} else {
			$dataE = $data;

			$dia = $dataE[0] . $dataE[1];
			$mes = $dataE[3] . $dataE[4];
			$ano = $dataE[6] . $dataE[7] . $dataE[8] . $dataE[9];
			$data_trocada = $mes . "/" . $dia . "/" . $ano;

			$data_fim = date('d/m/Y', strtotime('+2 months', strtotime($data_trocada)));

			$this->FSistema_model->editarData($idPg, $data, $data_fim, $data, 2);
		}

		header('Location: progresso?id_pg=' . $idPg . '&id_lider=' . $idLider . '');
	}
	// Fim PG

	// Download de Material
	public function pagina_download_material()
	{
		$this->load->view('sistema/lider/pages/download_material');
	}

	public function pagina_download_material_modulo()
	{
		$this->load->view('sistema/lider/pages/download_material_modulo');
	}
	/* FIM LÍDER */

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

		if ($consultarColider) {
			$cadastroColider = $this->FSistema_model->cadastrarColider($idLider, $nomeColider, $cpfColider, $emailColider, $telefoneColider, $nascimentoColider);

			if ($cadastroColider) {
				echo '
				<script>
					window.location="../../pagina_editar_pessoal";
				</script>
			';
			} else {
				echo '
				<script>
					if(window.confirm("ERRO!")) {
						window.location="../../pagina_editar_pessoal";
					}else{
						window.location="../../pagina_editar_pessoal";
					}
				</script>
			';
			}
		} else {
			echo '
				<script>
					if(window.confirm("COLÍDER JÁ CADASTRADO, TENTE NOVAMENTE!")) {
						window.location="../../pagina_editar_pessoal";
					}else{
						window.location="../../pagina_editar_pessoal";
					}
				</script>
			';
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

		if ($reativar) {
			echo '
			<script>
				window.location="../pagina_editar_pessoal";
			</script>
		';
		} else {
			echo '
			<script>
				if(window.confirm("ERRO!")) {
					window.location="../pagina_editar_pessoal";
				}else{
					window.location="../pagina_editar_pessoal";
				}
			</script>
		';
		}
	}

	public function ativar_colider()
	{
		$idLider = $this->input->post("idLider");
		$idColider = $this->input->post("opc");

		$reativar = $this->FSistema_model->reativarColider($idColider, $idLider);

		if ($reativar) {
			echo '
			<script>
				window.location="../pagina_editar_pessoal";
			</script>
		';
		} else {
			echo '
			<script>
				if(window.confirm("ERRO!")) {
					window.location="../pagina_editar_pessoal";
				}else{
					window.location="../pagina_editar_pessoal";
				}
			</script>
		';
		}
	}
}
