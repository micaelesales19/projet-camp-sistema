<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property $input
 * @property FConsultas_model $FConsultas_model
 * @property FSistema_model $FSistema_model
 * @property $db
 * @property $upload
 * @property $email
 * @property $uri
 */

class SLocal extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('America/Sao_Paulo');
	}
	/* COORDENADOR */

	public function home()
	{
		$this->load->view('sistema/slocal/home');
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
		$id_user = $this->input->post("id_user");

		$pages = [];

		if ($id_user == '') {
			$page1 = array(
				"red" => "../home",
				"name" => "Home",
				"icon" => "fa fa-home",
			);
			array_push($pages, $page1);
		} else {

			$page1 = array(
				"red" => "../home",
				"name" => "Home",
				"icon" => "fa fa-home",
			);

			$page2 = array(
				"red" => "../coordenadores",
				"name" => "Coordenadores",
				"icon" => "fa fa-group",
			);

			array_push($pages, $page1);
			array_push($pages, $page2);
		}

		$dados = array(
			'id_user' => $id_user,
			'pages' => $pages,
		);

		$this->load->view('sistema/slocal/pages/pagina_ver_lideres', $dados);
	}

	public function pagina_ver_detalhes_lideres()
	{

		$id_lider = $this->uri->segment(5);
		$dados_lider = $this->FConsultas_model->getInfoLiderId($id_lider);

		$id_coord = $this->input->post('id_coord') ?? '';
		$nivel = $this->input->post('nivel') ?? 'lider';

		$pages = [];

		if ($nivel == 'lider') {
			$page1 = array(
				"red" => "../../../home",
				"name" => "Home",
				"icon" => "fa fa-home",
			);

			$page2 = array(
				"red" => "../../lideres",
				"name" => "Líderes",
				"icon" => "fa fa-group",
			);

			array_push($pages, $page1);
			array_push($pages, $page2);
		} else {
			$page1 = array(
				"red" => "../../../home",
				"name" => "Home",
				"icon" => "fa fa-home",
			);

			$page2 = array(
				"red" => "../../coordenadores",
				"name" => "Coordenador",
				"icon" => "fa fa-group",
			);

			$page3 = array(
				"red" => "../../lideres_do_coordenador/$id_coord",
				"name" => "Líderes",
				"icon" => "fa fa-group",
			);

			array_push($pages, $page1);
			array_push($pages, $page2);
			array_push($pages, $page3);
		}

		$dados = array(
			'dados_do_lider' => $dados_lider,
			'pages' => $pages,
			'id_coord' => $id_coord,
		);

		$this->load->view('sistema/slocal/pages/lideres/pagina_ver_info_lideres', $dados);
	}

	public function editar_lideres()
	{
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


		$red = $this->input->post('red') ?? 'lideres/detalhes';

		$routa = "";
		$data = [];

		if ($red == 'lideres/detalhes') {
			$routa = "lideres/detalhes/$idLider";
		} else if ($red == 'slocal/detalhes') {
			$routa = "slocal/detalhes/$idLider";
		} else {
			$routa = "lideres/detalhes/$idLider";
		}

		$this->FConsultas_model->mensagem('success', 'Edição de Líderes!', $mensagem);
		$funcao = $this->FConsultas_model->red("../$routa", 2000, $data);
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

	public function pagina_ver_coordenadores()
	{
		$this->load->view('sistema/slocal/pages/pagina_ver_coordenadores');
	}

	// PG
	public function pagina_visualizacao_pg()
	{
		$this->load->view('sistema/slocal/pages/pagina_pg_usuario');
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

		$nivel_routa = $this->input->post("nivel_routa") ?? 'lider';
		$id_coord = $this->input->post("id_coord");

		if ($routa == 'pg') {
			$page1 = array(
				"red" => "../pg",
				"name" => "Meu PG",
				"icon" => "fa fa-group",
			);
			array_push($pages, $page1);
		} else {
			if ($nivel_routa == 'lider') {
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
			} else {

				$page1 = array(
					"red" => "../coordenadores",
					"name" => "Coordenador",
					"icon" => "fa fa-group",
				);

				$page2 = array(
					"red" => "../../lideres_do_coordenador/$id_coord",
					"name" => "Líderes",
					"icon" => "fa fa-group",
				);

				$page3 = array(
					"red" => "../lideres/detalhes/$id_lider",
					"name" => "Informações",
					"icon" => "fa fa-user",
				);

				array_push($pages, $page1);
				array_push($pages, $page2);
				array_push($pages, $page3);
			}
		}

		$dados = array(
			'id_lider' => $id_lider,
			'id_pg' => $id_pg,
			'modulos' => $modulos,
			'pg' => $dadosPg,
			'pages' => $pages,
			'routa' => $routa,
			'nivel_routa' => $nivel_routa,
			'id_coord' => $id_coord,
		);

		$this->load->view('sistema/slocal/pages/pg/licaos', $dados);
	}

	public function pagina_preenchimento_relatorio_pg()
	{
		$id_pg = $this->input->post('id_pg');
		$id_lider = $this->input->post('id_lider');
		$ano = $this->input->post('ano');
		$id_modulo = $this->input->post('id_modulo');
		$licao = $this->input->post('licao');
		$routa = $this->input->post('routa');

		$nivel_routa = $this->input->post("nivel_routa") ?? 'lider';
		$id_coord = $this->input->post("id_coord");

		$pages = [];

		if ($routa == 'pg') {
			$page1 = array(
				"red" => "../pg",
				"name" => "Meu PG",
				"icon" => "fa fa-group",
			);
			array_push($pages, $page1);
		} else {
			if ($nivel_routa == 'lider') {
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
			} else {
				$page1 = array(
					"red" => "../coordenadores",
					"name" => "Coordenador",
					"icon" => "fa fa-group",
				);

				$page2 = array(
					"red" => "../../lideres_do_coordenador/$id_coord",
					"name" => "Líderes",
					"icon" => "fa fa-group",
				);

				$page3 = array(
					"red" => "../lideres/detalhes/$id_lider",
					"name" => "Informações",
					"icon" => "fa fa-user",
				);

				array_push($pages, $page1);
				array_push($pages, $page2);
				array_push($pages, $page3);
			}
		}

		$dados = array(
			'id_lider' => $id_lider,
			'id_pg' => $id_pg,
			'ano' => $ano,
			'id_modulo' => $id_modulo,
			'licao' => $licao,
			'routa' => $routa,
			'pages' => $pages,
			'nivel_routa' => $nivel_routa,
			'id_coord' => $id_coord,
		);

		$this->load->view('sistema/slocal/pages/preenchimento_relatorio', $dados);
	}

	public function consulta_criancas_relatorios()
	{
		$this->load->view('sistema/slocal/pages/consultas/retornar_infomacoes');
	}
	// Fim PG

	// Download de Material
	public function pagina_download_material()
	{
		$this->load->view('sistema/slocal/pages/download_material');
	}

	public function pagina_download_material_modulo()
	{
		$this->load->view('sistema/slocal/pages/download_material_modulo');
	}

	public function pagina_material_apoio_treinamento()
	{
		$this->load->view('sistema/slocal/pages/material_apoio_treinamento');
	}
	/* FIM COORDENADOR */
}
