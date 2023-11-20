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

class Pais extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('America/Sao_Paulo');
		require_once 'import/sistema/fpdf/fpdf.php';
		define('PDF_PATH', 'import/sistema/temp/');
	}
	/* PAIS */

	public function home_pais()
	{
		$this->load->view('sistema/pais/home');
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
					setTimeout(function(){ window.location="../index"}, 3000)
				</script>
			';
	}

	// Dados Pessoal
	public function pagina_editar_pessoal()
	{
		$this->load->view('sistema/pais/edicao/pagina_editar_pessoal');
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

			$uploadPath = 'import/sistema/fotoU/pais/';
			$foto = 'fotoU/pais/' . $_FILES['files']['name'][$i];

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

		$consultarCriancas = $this->FConsultas_model->mostrarCriancasPais($id);

		if ($consultarCriancas['row'] == 0) {
		} else {
			foreach ($consultarCriancas['dados'] as $key => $dadosCriancas) {
				$id = $dadosCriancas['id_crianca'];
				$nome_responsavel = $dadosCriancas['nome_responsavel'];

				if ($nome_responsavel == $nome_antigo) {
					$this->FSistema_model->editaCriancaResponsavel($id, $nome, $email, $telefone);
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
		$this->load->view('sistema/pais/pages/pagina_ver_criancas');
	}

	public function pagina_cadastro_criancas()
	{
		$this->load->view('sistema/pais/cadastro/pagina_cadastro_crianca');
	}

	public function cadastro_crianca()
	{
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

		$dadosPais = $this->FConsultas_model->consultaDadosPaisId($lider);

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
				$nomePai = $dadosPais['nome'];
				$emailPai = $dadosPais['email'];
				$telefonePai = $dadosPais['telefone_whatsapp'];
			}

			$checkCriancas = $this->FConsultas_model->consultarCriancasNomeEIdade($nome2, $lider2, $id_pg2, $nascimento2, $opcao2, $obs2, $nomePai);

			if ($checkCriancas) {
				$this->FSistema_model->cadastro_crianca($nome2, $nascimento2, $lider2, $id_pg2, $obs2, $opcao2, $nomePai, $emailPai, $telefonePai);
			} else {
			}
		}
		echo '
			<script>
				window.location="../../criancas";
			</script>
		';
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

		$responsavel_crianca = $this->input->post('responsavel_crianca');
		$nome_responsavel = $this->input->post('nome_responsavel');
		$email_responsavel = $this->input->post('email_responsavel');
		$telefone_responsavel = $this->input->post('telefone_responsavel');

		$dadosPais = $this->FConsultas_model->consultaDadosPaisId($lider);

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
				$nomePai = $dadosPais['nome'];
				$emailPai = $dadosPais['email'];
				$telefonePai = $dadosPais['telefone_whatsapp'];
			}

			$checkCriancas = $this->FConsultas_model->consultarCriancasNomeEIdade($nome2, $lider2, $id_pg2, $nascimento2, $opcao2, $obs2, $nomePai);

			if ($checkCriancas) {
				$this->FSistema_model->cadastro_crianca($nome2, $nascimento2, $lider2, $id_pg2, $obs2, $opcao2, $nomePai, $emailPai, $telefonePai);
			} else {
			}
		}

		header('Location: ../../../../primeiro_acesso?id_usuario=' . $lider . '&nivel=' . $nivel . '&x_ir=3');
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

		$nome_responsavel = $isResponsavel == 2 || $isResponsavel == 0 ? $this->input->post('nome_responsavel_1') : $this->input->post('nome_responsavel');
		$email_responsavel = $isResponsavel == 2 || $isResponsavel == 0 ? $this->input->post('email_responsavel_1') : $this->input->post('email_responsavel');
		$telefone_responsavel = $isResponsavel == 2 || $isResponsavel == 0 ? $this->input->post('telefone_responsavel_1') : $this->input->post('telefone_responsavel');

		$checkCriancas = $this->FConsultas_model->consultarCriancasNomeEIdade($nome, $lider, $id_pg, $nascimento, $opcao, $obs, $nome_responsavel);

		if ($checkCriancas) {
			$editar = $this->FSistema_model->editaCrianca($id_crianca, $nome, $nascimento, $lider, $id_pg, $obs, $opcao, $nome_responsavel, $email_responsavel, $telefone_responsavel);
			if ($editar) {
				echo '
				<script>
					window.location="../../criancas";
				</script>
			';
			} else {
				echo '
				<script>
					if(window.confirm("ERRO!")) {
						window.location="../../criancas";
					}else{
						window.location="../../criancas";
					}
				</script>
			';
			}
		} else {
			echo '
				<script>
					if(window.confirm("JÁ TEM UMA CRIANÇA COM ESSES DADOS!")) {
						window.location="../../criancas";
					}else{
						window.location="../../criancas";
					}
				</script>
			';
		}
	}

	public function desativar_crianca()
	{
		$idCrianca = $this->input->post("idCrianca");
		$nomeCrianca = $this->input->post("nomeCrianca");
		$idLider = $this->input->post("idLider");
		$idResponsavel = $this->input->post("idResponsavel");
		$motivo = $this->input->post("motivo");

		$excluir = $this->FSistema_model->excluirCrianca($idCrianca, $nomeCrianca, $idLider, $idResponsavel, $motivo);

		if ($excluir) {
			echo '
			<script>
				window.location="../../criancas";
			</script>
		';
		} else {
			echo '
			<script>
				if(window.confirm("ERRO!")) {
					window.location="../../criancas";
				}else{
					window.location="../../criancas";
				}
			</script>
		';
		}
	}

	public function ativar_crianca()
	{
		$idLider = $this->input->post("idLider");
		$idCrianca = $this->input->post("opc");

		$reativar = $this->FSistema_model->reativarCrianca($idCrianca);

		if ($reativar) {
			echo '
			<script>
				window.location="../criancas";
			</script>
		';
		} else {
			echo '
			<script>
				if(window.confirm("ERRO!")) {
					window.location="../criancas";
				}else{
					window.location="../criancas";
				}
			</script>
		';
		}
	}

	public function RelatoriosCriancas()
	{
		$idLider = $this->input->post("id");
		$opc = $this->input->post("opc");

		$dados = $this->FConsultas_model->consultaDadosPaisId($idLider);

		$nome = $dados['nome'];

		$pdf = new FPDF("L", "pt", "A4");
		$pdf->AddPage();
		$pdf->SetCreator('CAMP Brasil');

		$outraOpcao = explode(" ", $opc);

		// INFORMAÇÕES GERAIS
		if ($opc == "1") {

			$consultarPG = $this->FConsultas_model->mostrarPG($idLider);
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

				$pdf->SetFont('arial', 'B', 12);
				$pdf->Cell(40, 20, $pdf->textoUTF8("Crianças do PG: $nome_pg"), 0, 1, 'L');
				$pdf->Ln(10);

				if ($consultarPG['row'] == 0) {
					$pdf->SetFont('arial', 'I', 12);
					$pdf->Cell(0, 50, $pdf->textoUTF8("Sem PG Cadastrado"), 0, 1, "C");
				} else {
					$pdf->setFillColor(120, 120, 90);
					$pdf->SetFont('arial', 'B', 11);
					$pdf->Cell(250, 20, $pdf->textoUTF8("Nome"), 1, 0, "C", 1);
					$pdf->Cell(150, 20, $pdf->textoUTF8("Responsável"), 1, 0, "C", 1);
					$pdf->Cell(80, 20, $pdf->textoUTF8("Telefone"), 1, 0, "C", 1);
					$pdf->Cell(100, 20, $pdf->textoUTF8("D. Nascimento"), 1, 0, "C", 1);
					$pdf->Cell(80, 20, $pdf->textoUTF8("É Cristão?"), 1, 0, "C", 1);
					$pdf->Cell(90, 20, $pdf->textoUTF8("Situação"), 1, 1, "C", 1);

					$consultaCriancas = $this->FConsultas_model->mostrarCriancasPaisPgTodos($idLider, $dadosPG['id_pg']);

					if ($consultaCriancas) {
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

					$pdf->Ln(30);
					$pdf->SetX(120);

					$pdf->setFillColor(120, 120, 90);
					$pdf->SetFont('arial', 'B', 11);
					$pdf->Cell(250, 20, $pdf->textoUTF8("Nome"), 1, 0, "C", 1);
					$pdf->Cell(80, 20, $pdf->textoUTF8("Presença"), 1, 0, "C", 1);
					$pdf->Cell(100, 20, $pdf->textoUTF8("Versículo"), 1, 0, "C", 1);
					$pdf->Cell(80, 20, $pdf->textoUTF8("Mistério"), 1, 0, "C", 1);
					$pdf->Cell(90, 20, $pdf->textoUTF8("Pontuação"), 1, 1, "C", 1);

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

							$consultarProgresso = $this->FConsultas_model->consultarProgressoCriancaIndividual($id_pg, $idLider, $linha['id_crianca'], $id_modulo);

							if ($consultarProgresso['row'] == 0) {
							} else {
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

			$consultarPG = $this->FConsultas_model->mostrarPG($idLider);

			$pdf->Image('import/sistema/dist/img/capa_relatorio.jpg', 200, 100, 500, 300);

			$pdf->SetFont('arial', 'B', 12);
			$pdf->SetXY(70, 30);
			$pdf->Cell(0, 5, $pdf->textoUTF8("Relatórios / Informações das Crianças Ativas / CAMP Brasil"), 0, 1, 'L');
			$pdf->Image(base_url('import/sistema/dist/img/icone.png'), 30, 13, -100);
			$pdf->Ln(10);
			$pdf->Cell(0, 5, "", "B", 1, 'C');
			$pdf->Ln(8);
			/*$pdf->SetFont('arial', 'B', 12);
			$pdf->Cell(50, 20, $pdf->textoUTF8("Usuário:"), 0, 0, 'L');
			$pdf->SetFont('arial', '', 12);
			$pdf->Cell(0, 20, $pdf->textoUTF8($dados['nome']), 0, 1, 'L');
			$pdf->Ln(15);*/

			if ($consultarPG['row'] == 0) {
				$pdf->SetFont('arial', 'I', 12);
				$pdf->Cell(0, 50, $pdf->textoUTF8("Sem PG Cadastrado"), 0, 1, "C");
			} else {
				foreach ($consultarPG['dados'] as $key => $dadosPG) {
					$id_pg = $dadosPG['id_pg'];
					$id_modulo = $dadosPG['id_modulo'];
					$nome_pg = $pdf->textoUTF8($dadosPG['nome_pg']);

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

					$consultaCriancas = $this->FConsultas_model->mostrarCriancasPaisPg($idLider, $dadosPG['id_pg']);

					if ($consultaCriancas) {
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

					$pdf->Ln(30);
					$pdf->SetX(120);

					$pdf->setFillColor(120, 120, 90);
					$pdf->SetFont('arial', 'B', 11);
					$pdf->Cell(250, 20, $pdf->textoUTF8("Nome"), 1, 0, "C", 1);
					$pdf->Cell(80, 20, $pdf->textoUTF8("Presença"), 1, 0, "C", 1);
					$pdf->Cell(100, 20, $pdf->textoUTF8("Versículo"), 1, 0, "C", 1);
					$pdf->Cell(80, 20, $pdf->textoUTF8("Mistério"), 1, 0, "C", 1);
					$pdf->Cell(90, 20, $pdf->textoUTF8("Pontuação"), 1, 1, "C", 1);

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

							$consultarProgresso = $this->FConsultas_model->consultarProgressoCriancaIndividual($id_pg, $idLider, $linha['id_crianca'], $id_modulo);

							if ($consultarProgresso['row'] == 0) {
							} else {
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

			$consultarPG = $this->FConsultas_model->mostrarPG($idLider);

			$pdf->Image('import/sistema/dist/img/capa_relatorio.jpg', 200, 100, 500, 300);
			// imagem em pé - $pdf->Image('import/sistema/dist/img/capa_relatorio.jpg', 50, 300, 500, 300);

			$pdf->SetFont('arial', 'B', 12);
			$pdf->SetXY(70, 30);
			$pdf->Cell(0, 5, $pdf->textoUTF8("Relatórios / Informações das Crianças Desativadas / CAMP Brasil"), 0, 1, 'L');
			$pdf->Image(base_url('import/sistema/dist/img/icone.png'), 30, 13, -100);
			$pdf->Ln(10);
			$pdf->Cell(0, 5, "", "B", 1, 'C');
			$pdf->Ln(8);
			/*$pdf->SetFont('arial', 'B', 12);
			$pdf->Cell(50, 20, $pdf->textoUTF8("Usuário:"), 0, 0, 'L');
			$pdf->SetFont('arial', '', 12);
			$pdf->Cell(0, 20, $pdf->textoUTF8($dados['nome']), 0, 1, 'L');
			$pdf->Ln(15);*/

			if ($consultarPG['row'] == 0) {
				$pdf->SetFont('arial', 'I', 12);
				$pdf->Cell(0, 50, $pdf->textoUTF8("Sem PG Cadastrado"), 0, 1, "C");
			} else {
				foreach ($consultarPG['dados'] as $key => $dadosPG) {
					$id_pg = $dadosPG['id_pg'];
					$id_modulo = $dadosPG['id_modulo'];
					$nome_pg = $pdf->textoUTF8($dadosPG['nome_pg']);

					$pdf->SetFont('arial', 'B', 12);
					$pdf->Cell(40, 20, $pdf->textoUTF8("Crianças:"), 0, 1, 'L');
					$pdf->Ln(10);

					$pdf->setFillColor(120, 120, 90);
					$pdf->SetFont('arial', 'B', 12);
					$pdf->Cell(250, 20, $pdf->textoUTF8("Nome"), 1, 0, "C", 1);
					$pdf->Cell(150, 20, $pdf->textoUTF8("Responsável"), 1, 0, "C", 1);
					$pdf->Cell(80, 20, $pdf->textoUTF8("Telefone"), 1, 0, "C", 1);
					$pdf->Cell(100, 20, $pdf->textoUTF8("D. Nascimento"), 1, 0, "C", 1);
					$pdf->Cell(80, 20, $pdf->textoUTF8("É Cristão?"), 1, 0, "C", 1);
					$pdf->Cell(90, 20, $pdf->textoUTF8("Situação"), 1, 1, "C", 1);

					$consultaCriancas = $this->FConsultas_model->mostrarCriancasPaisPgDesativadas($idLider, $dadosPG['id_pg']);

					if ($consultaCriancas) {
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
		// PG
		else if ($outraOpcao[0] == "pg") {
			$idPg = preg_replace("/[^0-9]/", "", $opc);
			$consultarPG = $this->FConsultas_model->mostrarPGId($idLider, $idPg);

			$pdf->Image('import/sistema/dist/img/capa_relatorio.jpg', 200, 100, 500, 300);

			$pdf->SetFont('arial', 'B', 12);
			$pdf->SetXY(70, 30);
			$pdf->Cell(0, 5, $pdf->textoUTF8("Relatórios / Informações das Crianças por PG / CAMP Brasil"), 0, 1, 'L');
			$pdf->Image(base_url('import/sistema/dist/img/icone.png'), 30, 13, -100);
			$pdf->Ln(10);
			$pdf->Cell(0, 5, "", "B", 1, 'C');
			$pdf->Ln(8);
			/*$pdf->SetFont('arial', 'B', 12);
			$pdf->Cell(50, 20, $pdf->textoUTF8("Usuário:"), 0, 0, 'L');
			$pdf->SetFont('arial', '', 12);
			$pdf->Cell(0, 20, $pdf->textoUTF8($dados['nome']), 0, 1, 'L');
			$pdf->Ln(15);*/

			if ($consultarPG['row'] == 0) {
				$pdf->SetFont('arial', 'I', 12);
				$pdf->Cell(0, 50, $pdf->textoUTF8("Sem PG Cadastrado"), 0, 1, "C");
			} else {

				$dadosPG = $consultarPG['dados'];

				$id_pg = $dadosPG['id_pg'];
				$id_modulo = $dadosPG['id_modulo'];
				$nome_pg = $pdf->textoUTF8($dadosPG['nome_pg']);

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

				$consultaCriancas = $this->FConsultas_model->mostrarCriancasPaisPgTodos($idLider, $dadosPG['id_pg']);

				if ($consultaCriancas) {
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

				$pdf->Ln(30);
				$pdf->SetX(120);

				$pdf->setFillColor(120, 120, 90);
				$pdf->SetFont('arial', 'B', 11);
				$pdf->Cell(250, 20, $pdf->textoUTF8("Nome"), 1, 0, "C", 1);
				$pdf->Cell(80, 20, $pdf->textoUTF8("Presença"), 1, 0, "C", 1);
				$pdf->Cell(100, 20, $pdf->textoUTF8("Versículo"), 1, 0, "C", 1);
				$pdf->Cell(80, 20, $pdf->textoUTF8("Mistério"), 1, 0, "C", 1);
				$pdf->Cell(90, 20, $pdf->textoUTF8("Pontuação"), 1, 1, "C", 1);

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

						$consultarProgresso = $this->FConsultas_model->consultarProgressoCriancaIndividual($id_pg, $idLider, $linha['id_crianca'], $id_modulo);

						if ($consultarProgresso['row'] == 0) {
						} else {
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
			$consultarPG = $this->FConsultas_model->mostrarPGId($idLider, $idPg);

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

				$consultaCriancas = $this->FConsultas_model->mostrarCriancasPaisPgTodos($idLider, $dadosPG['id_pg']);

				$pdf->Ln(30);
				$pdf->SetX(120);

				$pdf->setFillColor(120, 120, 90);
				$pdf->SetFont('arial', 'B', 11);
				$pdf->Cell(250, 20, $pdf->textoUTF8("Nome"), 1, 0, "C", 1);
				$pdf->Cell(80, 20, $pdf->textoUTF8("Presença"), 1, 0, "C", 1);
				$pdf->Cell(100, 20, $pdf->textoUTF8("Versículo"), 1, 0, "C", 1);
				$pdf->Cell(80, 20, $pdf->textoUTF8("Mistério"), 1, 0, "C", 1);
				$pdf->Cell(90, 20, $pdf->textoUTF8("Pontuação"), 1, 1, "C", 1);

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

						$consultarProgresso = $this->FConsultas_model->consultarProgressoCriancaIndividual($id_pg, $idLider, $linha['id_crianca'], $id_modulo);

						if ($consultarProgresso['row'] == 0) {
						} else {
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

		$nomeCertificado = "Crianças - " . $nome . ".pdf";
		$pdf->Output('I', $nomeCertificado);
	}
	// Fim Crianças

	// PG
	public function pagina_visualizacao_pg()
	{
		$this->load->view('sistema/pais/pages/pagina_ver_pg');
	}

	public function pagina_ver_progresso()
	{
		$idLider = $this->input->get("id_lider");
		$idPg = $this->input->get("id_pg");

		$dadosPg = $this->FConsultas_model->mostrarPGId($idLider, $idPg);

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

			$this->load->view('sistema/pais/pages/pg/progresso', $dados);
		}
	}

	public function cadastro_pg_pagina_inicial()
	{
		$idLider = $this->input->get("idLider");
		$nivel = $this->input->get("nivel");
		$nome = $this->input->get("nome");

		$this->FSistema_model->cadastro_pg_pagina_inicial($idLider, $nome);

		header('Location: ../../../../primeiro_acesso?id_usuario=' . $idLider . '&nivel=' . $nivel . '&x_ir=1');
	}

	public function cadastro_pg_inicial()
	{
		$idLider = $this->input->post('idLider');
		$nome_pg = $this->input->post('nome_pg');
		$data_inicio = $this->input->post('data_inicio');
		$nivel = $this->input->post('nivel');

		$this->FSistema_model->cadastro_pg($idLider, $nome_pg, $data_inicio);
		header('Location: ../../../../primeiro_acesso?id_usuario=' . $idLider . '&nivel=' . $nivel . '&x_ir=1');
	}

	public function cadastro_pg()
	{
		$idLider = $this->input->post('idLider');
		$nome_pg = $this->input->post('nome_pg');
		$data_inicio = $this->input->post('data_inicio');

		$consultarPg = $this->FConsultas_model->consultarPgCadastrado($idLider, $nome_pg);

		if ($consultarPg) {
			$cadastro = $this->FSistema_model->cadastro_pg($idLider, $nome_pg, $data_inicio);

			if ($cadastro) {
				echo '
				<script>
					window.location="../../pg";
				</script>
			';
			} else {
				echo '
				<script>
					if(window.confirm("ERRO!")) {
						window.location="../../pg";
					}else{
						window.location="../../pg";
					}
				</script>
			';
			}
		} else {
			echo '
				<script>
					if(window.confirm("PG JÁ CADASTRADO, TENTE NOVAMENTE!")) {
						window.location="../../pg";
					}else{
						window.location="../../pg";
					}
				</script>
			';
		}
	}

	public function editar_pg()
	{
		$idPg = $this->input->post('idPg');
		$nome_pg = $this->input->post('nome_pg');
		$fotoOriginal = $this->input->post('fotoOriginal');

		if ($idPg == '' || $nome_pg == '') {
			echo '
				<script>
					if(window.confirm("DADOS VAZIOS! TENTE NOVAMENTE!")) {
						window.location="../../pg";
					}else{
						window.location="../../pg";
					}
				</script>
			';
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
					echo '
                    <script>
						if(window.confirm("Erro no upload da imagem do PG"+ ' . $erro1 . ')) {
							window.location="../../pg";
						}else{
							window.location="../../pg";
						}
                    </script>
                ';
				}
			}

			$editar = $this->FSistema_model->editarPG($idPg, $nome_pg, $nomeImagem);
			if ($editar) {
				echo '
				<script>
					window.location="../../pg";
				</script>
			';
			} else {
				echo '
				<script>
					if(window.confirm("ERRO!")) {
						window.location="../../pg";
					}else{
						window.location="../../pg";
					}
				</script>
			';
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

		$excluir = $this->FSistema_model->excluirPG($idPg, $nomePg, $idLider, $idResponsavel, $motivo);

		if ($excluir) {
			echo '
			<script>
				window.location="../../pg";
			</script>
		';
		} else {
			echo '
			<script>
				if(window.confirm("ERRO!")) {
					window.location="../../pg";
				}else{
					window.location="../../pg";
				}
			</script>
		';
		}
	}

	public function pagina_licoes()
	{

		$id_pg = $this->input->get("id_pg");
		$id_lider = $this->input->get("id_lider");
		$ano = $this->input->get("ano");

		$modulos = $this->FConsultas_model->consultarModuloAno($ano);
		$dadosPg = $this->FConsultas_model->mostrarPGId($id_lider, $id_pg);

		$dados = array(
			'id_lider' => $id_lider,
			'id_pg' => $id_pg,
			'modulos' => $modulos,
			'pg' => $dadosPg,
		);

		$this->load->view('sistema/pais/pages/pg/licaos', $dados);
	}

	public function pagina_preenchimento_relatorio_pg()
	{
		$this->load->view('sistema/pais/pages/preenchimento_relatorio');
	}

	public function consulta_criancas_relatorios()
	{
		$this->load->view('sistema/pais/pages/consultas/retornar_infomacoes');
	}

	public function consulta_progresso_pg()
	{
		$id_lider = $this->input->get("id_lider");
		$id_pg = $this->input->get("id_pg");
		$id_modulo = $this->input->get("id_modulo");
		$total = $this->input->get("total");

		$dadosPg = $this->FConsultas_model->mostrarPGId($id_lider, $id_pg);

		$dados = array(
			'id_lider' => $id_lider,
			'id_pg' => $id_pg,
			'id_modulo' => $id_modulo,
			'total' => $total,
			'pg' => $dadosPg['dados'],
		);

		$this->load->view('sistema/pais/pages/pg/linha', $dados);
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

			$preenchimento = $this->FSistema_model->relatorio_encontro($id_lider, $id_pg2, $qtd_crianca2, $id_crianca2, $versiculo2, $presenca2, $misterio2, $devocional2, $ano2, $modulo2, $licao2, $data_aula2);
		}

		if ($preenchimento == 'false') {
			/*echo '
				<script>
					alert("erro");
				</script>
			';*/
			echo '
				<script>
					if(window.confirm("ERRO!")) {
						window.location="../../pg";
					}else{
						window.location="../../pg";
					}
				</script>
			';
		} else {
			/*echo '
				<script>
					alert("SUCESSO");
				</script>
			';*/
			echo '
				<script>
					if(window.confirm("SUCESSO!")) {
						window.location="../../pg";
					}else{
						window.location="../../pg";
					}
				</script>
			';
		}
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

			$this->FSistema_model->editarData($idPg, $dataE, $dataE, $dataE);
		} else if ($data == '') {
		} else {
			$dataE = $data;

			$dia = $dataE[0] . $dataE[1];
			$mes = $dataE[3] . $dataE[4];
			$ano = $dataE[6] . $dataE[7] . $dataE[8] . $dataE[9];
			$data_trocada = $mes . "/" . $dia . "/" . $ano;

			$data_fim = date('d/m/Y', strtotime('+2 months', strtotime($data_trocada)));

			$this->FSistema_model->editarData($idPg, $data, $data_fim, $data);
		}

		header('Location: progresso?id_pg=' . $idPg . '&id_lider=' . $idLider . '');
	}
	// Fim PG

	// Download de Material
	public function pagina_download_material()
	{
		$this->load->view('sistema/pais/pages/download_material');
	}

	public function pagina_download_material_modulo()
	{
		$this->load->view('sistema/pais/pages/download_material_modulo');
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
