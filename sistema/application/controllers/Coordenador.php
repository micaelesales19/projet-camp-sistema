<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property $input
 * @property FConsultas_model $FConsultas_model
 * @property FSistema_model $FSistema_model
 * @property Coordenadores $Coordenadores
 * @property $db
 * @property $upload
 * @property $email
 * @property $uri
 */

class Coordenador extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('America/Sao_Paulo');
		define(
			'LETRAS',
			['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z']
		);
	}
	/* COORDENADOR */

	public function home()
	{
		$id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";
		$link = $this->Coordenadores->criar_link($id_usuario);
		$dados = array('link' => $link);
		$this->load->view('sistema/coordenador/home', $dados);
	}
	// Dados Pessoal
	public function pagina_editar_pessoal()
	{
		$this->load->view('sistema/coordenador/edicao/pagina_editar_pessoal');
	}

	public function e_pessoal()
	{
		$id_usuario = $this->input->post("id_usuario");
		$id = $this->input->post("id");
		$nome = $this->input->post("nome");
		$cpf = $this->input->post("cpf");
		$email = $this->input->post("email");
		$telefone_digitado = $this->input->post("telefone");
		$nascimento = $this->input->post("nascimento");

		$senha = $this->input->post("senha");

		$pais = $this->input->post("pais");

		$is_br = $pais == 'br' || '' ? true : false;
		$estado1 = $this->input->post('estados');
		$cidade1 = $this->input->post('cidades');
		$estado2 = $this->input->post('estados2');
		$cidade2 = $this->input->post('cidades2');

		$estado = "";
		$cidade = "";

		if ($is_br) {
			$estado = $estado1;
			$cidade = $cidade1;
		} else {
			$estado = $estado2;
			$cidade = $cidade2;
		}

		$id_supervisor_local = $this->input->post('id_supervisor_local');
		$id_supervisor_regional = $this->input->post('id_supervisor_regional');

		$foto_antiga = $this->input->post("foto_antiga");

		$filesCount1 = count($_FILES['files']['name']);

		$mensagem = [];

		$telefone = $this->FSistema_model->formatar_telefone($telefone_digitado, $is_br);

		// editar lider brasileiro
		if ($is_br) {
			$cpfSoNumeros = preg_replace('/\D/', '', $cpf);
			$total_numeros_cpf = strlen($cpfSoNumeros);

			$dataNascimentoSoNumeros = preg_replace('/\D/', '', $nascimento);
			$total_numeros_data_nascimento = strlen($dataNascimentoSoNumeros);
			if ($total_numeros_cpf == 11 && $total_numeros_data_nascimento == 8 && $this->FAlerta_model->valida_cpf($cpfSoNumeros)) {
				$cpf_completo = $cpfSoNumeros[0] . $cpfSoNumeros[1] . $cpfSoNumeros[2] . "." . $cpfSoNumeros[3] . $cpfSoNumeros[4] . $cpfSoNumeros[5] . "." . $cpfSoNumeros[6] . $cpfSoNumeros[7] . $cpfSoNumeros[8] . "-" . $cpfSoNumeros[9] . $cpfSoNumeros[10];
				$data_nascimento_completo = $dataNascimentoSoNumeros[0] . $dataNascimentoSoNumeros[1] . "/" . $dataNascimentoSoNumeros[2] . $dataNascimentoSoNumeros[3] . "/" . $dataNascimentoSoNumeros[4] . $dataNascimentoSoNumeros[5] . $dataNascimentoSoNumeros[6] . $dataNascimentoSoNumeros[7];

				// EDIÇÃO
				for ($i = 0; $i < $filesCount1; $i++) {
					$_FILES['file']['name']     = $_FILES['files']['name'][$i];
					$_FILES['file']['type']     = $_FILES['files']['type'][$i];
					$_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
					$_FILES['file']['error']     = $_FILES['files']['error'][$i];
					$_FILES['file']['size']     = $_FILES['files']['size'][$i];

					$uploadPath = 'import/sistema/fotoU/coordenador/';
					$foto = 'fotoU/lider/' . $_FILES['files']['name'][$i];

					if ($_FILES['files']['name'][$i] == '') {
						$edicao = $this->Coordenadores->editar_coordenador($id, $nome, $cpf_completo, $email, $telefone, $data_nascimento_completo, $pais, $estado, $cidade, 2, $id_supervisor_local, $id_supervisor_regional, $foto_antiga);
						$editar_usuario = $this->FSistema_model->editar_usuario($id_usuario, $nome, $email, $cpf_completo, $senha);
						if ($edicao && $editar_usuario) {
							array_push($mensagem, "Sucesso! Seus Dados foram Editados!");
						} else {
							array_push($mensagem, "Erro! Seus dados estão inválidos!");
						}
					} else {
						if ($foto_antiga == $foto) {
							$edicao = $this->Coordenadores->editar_coordenador($id, $nome, $cpf_completo, $email, $telefone, $data_nascimento_completo, $pais, $estado, $cidade, 2, $id_supervisor_local, $id_supervisor_regional, $foto_antiga);
							$editar_usuario = $this->FSistema_model->editar_usuario($id_usuario, $nome, $email, $cpf_completo, $senha);

							if ($edicao && $editar_usuario) {
								array_push($mensagem, "Sucesso! Seus Dados foram Editados!");
							} else {
								array_push($mensagem, "Erro! Seus dados estão inválidos!");
							}
						} else {
							if (file_exists($foto)) {
								$edicao = $this->Coordenadores->editar_coordenador($id, $nome, $cpf_completo, $email, $telefone, $data_nascimento_completo, $pais, $estado, $cidade, 2, $id_supervisor_local, $id_supervisor_regional, $foto_antiga);
								$editar_usuario = $this->FSistema_model->editar_usuario($id_usuario, $nome, $email, $cpf_completo, $senha);

								if ($edicao && $editar_usuario) {
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
									$edicao = $this->Coordenadores->editar_coordenador($id, $nome, $cpf_completo, $email, $telefone, $data_nascimento_completo, $pais, $estado, $cidade, 2, $id_supervisor_local, $id_supervisor_regional, $foto);
									$editar_usuario = $this->FSistema_model->editar_usuario($id_usuario, $nome, $email, $cpf_completo, $senha);

									if ($edicao && $editar_usuario) {
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
			} else {
				array_push($mensagem, "Erro! Data de Nascimento e/ou CPF inválidos!");
			}
		} else {
			$dataNascimentoSoNumeros = preg_replace('/\D/', '', $nascimento);
			$total_numeros_data_nascimento = strlen($dataNascimentoSoNumeros);
			if ($total_numeros_data_nascimento == 8) {
				$data_nascimento_completo = $dataNascimentoSoNumeros[0] . $dataNascimentoSoNumeros[1] . "/" . $dataNascimentoSoNumeros[2] . $dataNascimentoSoNumeros[3] . "/" . $dataNascimentoSoNumeros[4] . $dataNascimentoSoNumeros[5] . $dataNascimentoSoNumeros[6] . $dataNascimentoSoNumeros[7];

				// EDIÇÃO
				for ($i = 0; $i < $filesCount1; $i++) {
					$_FILES['file']['name']     = $_FILES['files']['name'][$i];
					$_FILES['file']['type']     = $_FILES['files']['type'][$i];
					$_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
					$_FILES['file']['error']     = $_FILES['files']['error'][$i];
					$_FILES['file']['size']     = $_FILES['files']['size'][$i];

					$uploadPath = 'import/sistema/fotoU/coordenador/';
					$foto = 'fotoU/lider/' . $_FILES['files']['name'][$i];

					if ($_FILES['files']['name'][$i] == '') {
						$edicao = $this->Coordenadores->editar_coordenador($id, $nome, "", $email, $telefone, $data_nascimento_completo, $pais, $estado, $cidade, 2, $id_supervisor_local, $id_supervisor_regional, $foto_antiga);
						$editar_usuario = $this->FSistema_model->editar_usuario($id_usuario, $nome, $email, "", $senha);

						if ($edicao && $editar_usuario) {
							array_push($mensagem, "Sucesso! Seus Dados foram Editados!");
						} else {
							array_push($mensagem, "Erro! Seus dados estão inválidos!");
						}
					} else {
						if ($foto_antiga == $foto) {
							$edicao = $this->Coordenadores->editar_coordenador($id, $nome, "", $email, $telefone, $data_nascimento_completo, $pais, $estado, $cidade, 2, $id_supervisor_local, $id_supervisor_regional, $foto_antiga);
							$editar_usuario = $this->FSistema_model->editar_usuario($id_usuario, $nome, $email, "", $senha);

							if ($edicao && $editar_usuario) {
								array_push($mensagem, "Sucesso! Seus Dados foram Editados!");
							} else {
								array_push($mensagem, "Erro! Seus dados estão inválidos!");
							}
						} else {
							if (file_exists($foto)) {
								$edicao = $this->Coordenadores->editar_coordenador($id, $nome, "", $email, $telefone, $data_nascimento_completo, $pais, $estado, $cidade, 2, $id_supervisor_local, $id_supervisor_regional, $foto_antiga);
								$editar_usuario = $this->FSistema_model->editar_usuario($id_usuario, $nome, $email, "", $senha);

								if ($edicao && $editar_usuario) {
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
									$edicao = $this->Coordenadores->editar_coordenador($id, $nome, "", $email, $telefone, $data_nascimento_completo, $pais, $estado, $cidade, 2, $id_supervisor_local, $id_supervisor_regional, $foto);
									$editar_usuario = $this->FSistema_model->editar_usuario($id_usuario, $nome, $email, "", $senha);

									if ($edicao && $editar_usuario) {
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
			} else {
				array_push($mensagem, "Erro! Data de Nascimento inválida!");
			}
		}

		// atualizarCriancas
		$nome_antigo = $this->input->post("nome_antigo");

		$consultarCriancas = $this->Criancas->query_criancas_lider($id);

		if ($consultarCriancas['row'] == 0) {
		} else {
			foreach ($consultarCriancas['dados'] as $key => $dadosCriancas) {
				$id = $dadosCriancas['id_crianca'];
				$nome_responsavel = $dadosCriancas['nome_responsavel'];

				if ($nome_responsavel == $nome_antigo) {
					$this->Criancas->editar_nome_responsavel_crianca($id, $nome, $email, $telefone);
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

	// Líderes
	public function pagina_ver_lideres()
	{
		$id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";
		$link = $this->Coordenadores->criar_link($id_usuario);
		$dados = array('link' => $link);
		$this->load->view('sistema/coordenador/pages/pagina_ver_lideres', $dados);
	}

	public function pagina_ver_detalhes_lideres()
	{
		//$id_lider = $this->input->post('id_lider');

		$id_lider = $this->uri->segment(5);
		$dados_lider = $this->FConsultas_model->getInfoLiderId($id_lider);

		$dados = array(
			'dados_do_lider' => $dados_lider,
		);

		$this->load->view('sistema/coordenador/pages/lideres/pagina_ver_info_lideres', $dados);
	}

	public function editar_lideres()
	{
		$id_usuario = ($_SESSION["id_usuario_2"]) ? $_SESSION["id_usuario_2"] : "";

		$idLider = $this->input->post("id");
		$nome = $this->input->post("nome");
		$cpf = $this->input->post("cpf");
		$email = $this->input->post("email");
		$telefone = $this->input->post("telefone");
		$igreja = $this->input->post("igreja");
		$nascimento = $this->input->post("nascimento");
		$estado = $this->input->post("estados");
		$cidade = $this->input->post("cidades");

		$id_coordenador = $this->input->post("id_coordenador");
		$id_sl = $this->input->post("id_sl");
		$id_sr = $this->input->post("id_sr");

		$foto_antiga = $this->input->post("foto_antiga");

		$filesCount1 = count($_FILES['files']['name']);

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
				$cadastro = $this->FSistema_model->editarPessoalLider($idLider, $nome, $cpf, $email, $telefone, $igreja, $nascimento, $estado, $cidade, $id_coordenador, $id_sl, $id_sr, $foto_antiga);
				if ($cadastro) {
					array_push($mensagem, "Sucesso! Seus Dados foram Editados!");
				} else {
					array_push($mensagem, "Erro! Seus dados estão inválidos!");
				}
			} else {
				if ($foto_antiga == $foto) {
					$cadastro = $this->FSistema_model->editarPessoalLider($idLider, $nome, $cpf, $email, $telefone, $igreja, $nascimento, $estado, $cidade, $id_coordenador, $id_sl, $id_sr, $foto_antiga);
					if ($cadastro) {
						array_push($mensagem, "Sucesso! Seus Dados foram Editados!");
					} else {
						array_push($mensagem, "Erro! Seus dados estão inválidos!");
					}
				} else {
					if (file_exists($foto)) {
						$cadastro = $this->FSistema_model->editarPessoalLider($idLider, $nome, $cpf, $email, $telefone, $igreja, $nascimento, $estado, $cidade, $id_coordenador, $id_sl, $id_sr, $foto_antiga);
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
							$cadastro = $this->FSistema_model->editarPessoalLider($idLider, $nome, $cpf, $email, $telefone, $igreja, $nascimento, $estado, $cidade, $id_coordenador, $id_sl, $id_sr, $foto);
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

		$this->FSistema_model->editarUsuário($id_usuario, $nome, $email, $cpf);

		if ($nome_colider == '') {
		} else {

			$filesCount2 = count($_FILES['filesColider']['name']);
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
		}

		// atualizarCriancas
		$nome_antigo = $this->input->post("nome_antigo");

		$consultarCriancas = $this->FConsultas_model->mostrarCriancasPais($idLider, 2);

		if ($consultarCriancas['row'] == 0) {
		} else {
			foreach ($consultarCriancas['dados'] as $key => $dadosCriancas) {
				$id = $dadosCriancas['id_crianca'];
				$nome_responsavel = $dadosCriancas['nome_responsavel'];

				if ($nome_responsavel == $nome_antigo) {
					$this->FSistema_model->editaCriancaResponsavel($idLider, $nome, $email, $telefone, 2);
				}
			}
		}

		//echo '<script>alert("' . implode("\\n", $mensagem) . '");</script>';
		/*echo '
			<script>
				if(window.confirm("' . implode("\\n", $mensagem) . '")) {
					window.location="pagina_editar_pessoal";
				}else{
					window.location="pagina_editar_pessoal";
				}
			</script>
		';*/

		$data = [];

		$this->FConsultas_model->mensagem('success', 'Edição de Líderes!', $mensagem);
		$funcao = $this->FConsultas_model->red("../lideres/detalhes/$idLider", 2000, $data);
		echo $funcao;
	}
	public function editar_info_lideres()
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

		if ($nome_colider == '') {
		} else {
			$filesCount2 = count($_FILES['filesColider']['name']);
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

	public function mostrar_table_parte_1()
	{
		$id_coordenador = $this->input->get("id_coordenador");
		$opc1 = $this->input->get("opc1");
		$opc2 = $this->input->get("opc2");

		$dataInicio = $this->input->get("dataInicio");
		$dataFim = $this->input->get("dataAte");

		$dados = $this->consultasBD($id_coordenador, $opc1, $opc2, '', $dataInicio, $dataFim);

		$this->load->view('sistema/coordenador/pages/lideres/mostrar_tabela_lideres_1', $dados);
	}

	public function mostrar_table_parte_2()
	{
		$id_coordenador = $this->input->get("id_coordenador");
		$opc1 = $this->input->get("opc1");
		$opc2 = $this->input->get("opc2");
		$opc3 = $this->input->get("opc3");

		//echo 'OPC 1 - ' . $opc1 . ' OPC 2 - ' . $opc2;

		$dataInicio = $this->input->get("dataInicio");
		$dataFim = $this->input->get("dataAte");

		$dados = $this->consultasBD($id_coordenador, $opc1, $opc2, $opc3, $dataInicio, $dataFim);

		$this->load->view('sistema/coordenador/pages/lideres/mostrar_tabela_lideres_2', $dados);
	}

	public function consultasBD($id_coordenador, $opc1, $opc2, $opc3, $dataInicio, $dataFim)
	{
		$dados_coordenador = $this->FConsultas_model->getInfoCoordenadorId($id_coordenador);

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

		$list_lideres = $this->Lideres->infos(['coordenador', $id_coordenador], $opc1, $opc2, [false], $datas);
		$list_lideres_ativos = $this->Lideres->lideresAtivos($list_lideres);

		$total_criancas_geral = $this->Criancas->list_criancas([$id_coordenador], $list_lideres['dados'], 'criancas_coord_1');
		$total_criancas_ativos = $this->Criancas->list_criancas([$id_coordenador], $list_lideres_ativos['dados'], 'criancas_coord_1');

		if ($opc3 == 'lideres_ativos') {
			$dados = array(
				'dados_coordenador' => $dados_coordenador,
				'dados_lideres_gerais' => $list_lideres_ativos,
				'dados_lideres_ativos' => $list_lideres_ativos,
				'dados_criancas_gerais' => $total_criancas_geral,
				'dados_criancas_ativos' => $total_criancas_ativos,
				'mostrar_comparacao' => $opc2,
			);

			return $dados;
		} else {
			$dados = array(
				'dados_coordenador' => $dados_coordenador,
				'dados_lideres_gerais' => $list_lideres,
				'dados_lideres_ativos' => $list_lideres_ativos,
				'dados_criancas_gerais' => $total_criancas_geral,
				'dados_criancas_ativos' => $total_criancas_ativos,
				'mostrar_comparacao' => $opc2,
			);

			return $dados;
		}
	}

	// PG
	public function pagina_visualizacao_pg()
	{
		$this->load->view('sistema/coordenador/pages/pagina_pg_usuario');
	}

	public function pagina_licoes()
	{

		$id_pg = $this->input->post("id_pg");
		$id_lider = $this->input->post("id_lider");
		$ano = $this->input->post("ano");
		$routa = $this->input->post('routa');

		$modulos = $this->FConsultas_model->consultarModuloAno($ano);
		$dadosPg = $this->FConsultas_model->mostrarPGId($id_lider, $id_pg, 2);

		$pages = [];

		if ($routa == 'pg') {
			$page1 = array(
				"red" => "../pg",
				"name" => "Meu PG",
				"icon" => "fa fa-group",
			);
			array_push($pages, $page1);
		} else {

			$page1 = array(
				"red" => "../lideres",
				"name" => "Líderes",
				"icon" => "fa fa-group",
			);

			$page2 = array(
				"red" => "../lideres/detalhes/$id_lider",
				"name" => "Informações",
				"icon" => "fa fa-user",
			);

			array_push($pages, $page1);
			array_push($pages, $page2);
		}

		$dados = array(
			'id_lider' => $id_lider,
			'id_pg' => $id_pg,
			'modulos' => $modulos,
			'pg' => $dadosPg,
			'pages' => $pages,
			'routa' => $routa,
		);

		$this->load->view('sistema/coordenador/pages/pg/licaos', $dados);
	}

	public function pagina_visualizacao_relatorio_pg()
	{
		$id_pg = $this->input->post('id_pg');
		$id_relatorio = $this->input->post('id_relatorio');
		$id_lider = $this->input->post('id_lider');
		$ano = $this->input->post('ano');
		$id_modulo = $this->input->post('id_modulo');
		$licao = $this->input->post('licao');
		$routa = $this->input->post('routa');

		$pages = [];

		if ($routa == 'pg') {
			$page1 = array(
				"red" => "../pg",
				"name" => "Meu PG",
				"icon" => "fa fa-group",
			);
			array_push($pages, $page1);
		} else {

			$page1 = array(
				"red" => "../lideres",
				"name" => "Líderes",
				"icon" => "fa fa-group",
			);

			$page2 = array(
				"red" => "../lideres/detalhes/$id_lider",
				"name" => "Informações",
				"icon" => "fa fa-user",
			);

			array_push($pages, $page1);
			array_push($pages, $page2);
		}

		$dados = array(
			'id_lider' => $id_lider,
			'id_pg' => $id_pg,
			'ano' => $ano,
			'id_modulo' => $id_modulo,
			'licao' => $licao,
			'routa' => $routa,
			'pages' => $pages,
			'id_relatorio' => $id_relatorio,
		);

		$this->load->view('sistema/coordenador/pages/edicao_preenchimento_relatorio', $dados);
	}
	public function pagina_preenchimento_relatorio_pg()
	{
		$id_pg = $this->input->post('id_pg');
		$id_lider = $this->input->post('id_lider');
		$ano = $this->input->post('ano');
		$id_modulo = $this->input->post('id_modulo');
		$licao = $this->input->post('licao');
		$routa = $this->input->post('routa');

		$pages = [];

		if ($routa == 'pg') {
			$page1 = array(
				"red" => "../pg",
				"name" => "Meu PG",
				"icon" => "fa fa-group",
			);
			array_push($pages, $page1);
		} else {

			$page1 = array(
				"red" => "../lideres",
				"name" => "Líderes",
				"icon" => "fa fa-group",
			);

			$page2 = array(
				"red" => "../lideres/detalhes/$id_lider",
				"name" => "Informações",
				"icon" => "fa fa-user",
			);

			array_push($pages, $page1);
			array_push($pages, $page2);
		}

		$dados = array(
			'id_lider' => $id_lider,
			'id_pg' => $id_pg,
			'ano' => $ano,
			'id_modulo' => $id_modulo,
			'licao' => $licao,
			'routa' => $routa,
			'pages' => $pages,
		);

		$this->load->view('sistema/coordenador/pages/preenchimento_relatorio', $dados);
	}

	public function consulta_progresso_pg()
	{
		$id_lider = $this->input->get("id_lider");
		$id_pg = $this->input->get("id_pg");
		$id_modulo = $this->input->get("id_modulo");
		$ano = $this->input->get("ano");
		$total = $this->input->get("total"); // total de botões dos módulos escolhidos

		$id_crianca = $this->input->get("id_crianca");

		$page = $this->input->get('page') == '' ? 'inicial' : $this->input->get('page');

		// id_lider // id_pg
		$dadosPg = $this->PG->query([$id_lider, $id_pg], 'query_id_lider_id_pg_ativo', 1);

		$dados = array(
			'id_lider' => $id_lider,
			'id_pg' => $id_pg,
			'id_modulo' => $id_modulo,
			'total' => $total,
			'ano' => $ano,
			'page' => $page,
			'id_crianca' => $id_crianca,
			'pg' => $dadosPg['dados'],
		);


		if ($page == '' || $page == 'individual') {
			$this->load->view('sistema/lider/pages/pg/linha', $dados);
		} else {
			$this->load->view('sistema/lider/pages/pg/linha_geral', $dados);
		}
	}

	public function consulta_criancas_relatorios()
	{
		$this->load->view('sistema/coordenador/pages/consultas/retornar_infomacoes');
	}

	public function consulta_relatorio_pg()
	{
		$this->load->view('sistema/coordenador/pages/consultas/retornar_infomacoes_relatorio_pg');
	}
	// Fim PG

	// Download de Material
	public function pagina_download_material()
	{
		$this->load->view('sistema/coordenador/pages/download_material');
	}

	public function pagina_download_material_modulo()
	{
		$this->load->view('sistema/coordenador/pages/download_material_modulo');
	}

	public function pagina_material_apoio_treinamento()
	{
		$this->load->view('sistema/coordenador/pages/material_apoio_treinamento');
	}

	/* FIM COORDENADOR */
}
