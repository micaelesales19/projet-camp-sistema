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
		require_once 'import/PHPExcel.php';
		define(
			'LETRAS',
			['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z']
		);
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
		$this->load->view('sistema/slocal/pages/pagina_ver_lideres');
	}

	public function pagina_ver_detalhes_lideres()
	{
		//$id_lider = $this->input->post('id_lider');

		$id_lider = $this->uri->segment(5);
		$dados_lider = $this->FConsultas_model->getInfoLiderId($id_lider);

		$dados = array(
			'dados_do_lider' => $dados_lider,
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

	public function mostrar_table_parte_1()
	{
		$id_coordenador = $this->input->get("id_coordenador");
		$opc1 = $this->input->get("opc1");
		$opc2 = $this->input->get("opc2");

		$dataInicio = $this->input->get("dataInicio");
		$dataFim = $this->input->get("dataAte");

		//echo 'OPC 1 - ' . $opc1 . ' OPC 2 - ' . $opc2 . "<br>";

		$dados = $this->consultasBD($id_coordenador, $opc1, $opc2, '', $dataInicio, $dataFim);

		$this->load->view('sistema/slocal/pages/lideres/mostrar_tabela_lideres_1', $dados);
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

		$this->load->view('sistema/slocal/pages/lideres/mostrar_tabela_lideres_2', $dados);
	}

	public function consultasBD($id_coordenador, $opc1, $opc2, $opc3, $dataInicio, $dataFim)
	{
		$dados_slocal = $this->FConsultas_model->getInfoSLocalId($id_coordenador);

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

		$consultarLideres = $this->FConsultas_model->getLideres([$id_coordenador], $opc1, $opc2, $datas);
		$consultarLideresAtivos = $this->FConsultas_model->lideresAtivos($consultarLideres);

		$total_criancas_geral = $this->FConsultas_model->getNumerosCriancas([$id_coordenador], $consultarLideres, 'criancas_coord_1');
		$total_criancas_ativos = $this->FConsultas_model->getNumerosCriancas([$id_coordenador], $consultarLideresAtivos, 'criancas_coord_1');

		if ($opc3 == 'lideres_ativos') {
			$dados = array(
				'dados_slocal' => $dados_slocal,
				'dados_lideres_gerais' => $consultarLideresAtivos,
				'dados_lideres_ativos' => $consultarLideresAtivos,
				'dados_criancas_gerais' => $total_criancas_geral,
				'dados_criancas_ativos' => $total_criancas_ativos,
				'mostrar_comparacao' => $opc2,
			);

			return $dados;
		} else {
			$dados = array(
				'dados_slocal' => $dados_slocal,
				'dados_lideres_gerais' => $consultarLideres,
				'dados_lideres_ativos' => $consultarLideresAtivos,
				'dados_criancas_gerais' => $total_criancas_geral,
				'dados_criancas_ativos' => $total_criancas_ativos,
				'mostrar_comparacao' => $opc2,
			);

			return $dados;
		}
	}

	public function gerar_excel()
	{
		$id_coordenador = $this->input->post("id_coordenador");
		$opc1 = $this->input->post("opc1");
		$opc2 = $this->input->post("opc2");

		$dataInicio = $this->input->post("dataInicio");
		$dataFim = $this->input->post("dataAte");

		$this->excel($id_coordenador, $opc1, $opc2, $dataInicio, $dataFim);
	}

	public function excel($id_coordenador, $opc1, $opc2, $dataInicio, $dataFim)
	{
		ob_start();

		$data = date('d/m/Y');

		$dados = $this->consultasBD($id_coordenador, $opc1, $opc2, '', $dataInicio, $dataFim);

		$total_lideres_gerais = $dados['dados_lideres_gerais']['row'];
		$dados_lideres_gerais = $dados['dados_lideres_gerais']['dados'];

		$total_lideres_ativos = $dados['dados_lideres_ativos']['row'];
		$dados_lideres_ativos = $dados['dados_lideres_ativos']['dados'];

		$columns = $this->input->post("columns");

		$letras = LETRAS;

		//create PHPExcel object
		$excel = new PHPExcel();
		$excel->setActiveSheetIndex(0);

		$table1 = new PHPExcel_Worksheet($excel, 'Líderes');
		$excel->addSheet($table1);

		$table2 = new PHPExcel_Worksheet($excel, 'Informações Gerais');
		$excel->addSheet($table2);

		$excel->getActiveSheet()->setTitle("Crianças");

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

		// planilha informações gerais
		$row = 5;

		//tile
		$excel->getSheet(2)->setCellValue('B2', 'CAMP Brasil');

		$colunas_titulo_1 = "B2";
		$excel->getSheet(2)->getStyle('B2')->getAlignment()->setHorizontal('center');

		$i_cl_1 = 1;

		foreach ($columns as $key => $coluna) {
			$excel->getSheet(2)->getColumnDimension($letras[$i_cl_1])->setAutoSize(true);
			if ($coluna == 'total_lideres_1') {
				$excel->getSheet(2)->setCellValue($letras[$i_cl_1] . '4', 'Total de Líderes');
				$excel->getSheet(2)->setCellValue($letras[$i_cl_1] . $row, $total_lideres_gerais);
				$i_cl_1++; // 2
			} else if ($coluna == 'total_lideres_2') {
				$excel->getSheet(2)->setCellValue($letras[$i_cl_1] . '4', 'Total de Líderes Ativos');
				$excel->getSheet(2)->setCellValue($letras[$i_cl_1] . $row, $total_lideres_ativos);
				$i_cl_1++; // 3
			} else if ($coluna == 'total_criancas_1') {
				$excel->getSheet(2)->setCellValue($letras[$i_cl_1] . '4', 'Total de Crianças');
				$excel->getSheet(2)->setCellValue($letras[$i_cl_1] . $row, $dados['dados_criancas_gerais']);
				$i_cl_1++; // 4
			} else if ($coluna == 'total_criancas_2') {
				$excel->getSheet(2)->setCellValue($letras[$i_cl_1] . '4', 'Total de Crianças Ativas');
				$excel->getSheet(2)->setCellValue($letras[$i_cl_1]  . $row, $dados['dados_criancas_ativos']);
				$i_cl_1++; // 5
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
		}

		if ($i_cl_1 == 1) {
		} else {
			$excel->getSheet(2)->mergeCells($colunas_titulo_1);
		}

		// style to title
		$excel->getSheet(2)->getStyle($colunas_titulo_1)->applyFromArray(
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
		$excel->getSheet(2)->getStyle($colunas_descricao)->applyFromArray(
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
		$excel->getSheet(2)->getStyle($colunas_dados_lideres)->applyFromArray(
			array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				),
			)
		);
		// style to columns descricao

		// informações dos pgs

		$columns3 = $this->input->post("columns_pg");

		$i_cl_pg = 1;

		$bol_check_col_1 = false;
		$bol_check_col_2 = false;
		$bol_check_col_3 = false;
		$bol_check_col_4 = false;

		$row++;
		$row++;

		$excel->getSheet(2)->setCellValue($letras[$i_cl_pg] . $row, 'Líder');
		$i_cl_pg++;

		foreach ($columns3 as $key => $coluna) {
			$excel->getSheet(2)->getColumnDimension($letras[$i_cl_pg])->setAutoSize(true);

			if ($coluna == 'column1') {
				$bol_check_col_1 = true;
				$excel->getSheet(2)->setCellValue($letras[$i_cl_pg] . $row, 'Quantidade de Crianças');
				$i_cl_pg++;
			} else if ($coluna == 'column2') {
				$bol_check_col_2 = true;
				$excel->getSheet(2)->setCellValue($letras[$i_cl_pg] . $row, 'Ciclo');
				$i_cl_pg++;
			} else if ($coluna == 'column3') {
				$bol_check_col_3 = true;
				$excel->getSheet(2)->setCellValue($letras[$i_cl_pg] . $row, 'Módulo');
				$i_cl_pg++;
			} else if ($coluna == 'column4') {
				$bol_check_col_4 = true;
				$excel->getSheet(2)->setCellValue($letras[$i_cl_pg] . $row, 'Lição');
				$i_cl_pg++;
			}
		}

		if ($i_cl_pg == 1 || $i_cl_pg == 2) {
		} else if ($i_cl_pg == 3) {
			$colunas_titulo_2 = $colunas_titulo_2 . ":C2";
		} else if ($i_cl_pg == 4) {
			$colunas_titulo_2 = $colunas_titulo_2 . ":D2";
		} else if ($i_cl_pg == 5) {
			$colunas_titulo_2 = $colunas_titulo_2 . ":E2";
		} else if ($i_cl_pg == 6) {
			$colunas_titulo_2 = $colunas_titulo_2 . ":F2";
		}

		$colunas_lideres = $letras[1] . $row . ":" . $letras[$i_cl_pg - 1] . $row;

		// style to columns descricao
		$excel->getSheet(2)->getStyle($colunas_lideres)->applyFromArray(
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

		for ($i = 0; $i < count($dados_lideres_gerais); $i++) {
			$lider = $dados_lideres_gerais[$i];
			$id_lider = $lider['id_lider'];
			$data_cadastro = $lider['data_cadastro'];
			$ativo = $lider['ativo'];
			$confirmado = $lider['confirmado'];

			$excel->getSheet(2)->getColumnDimension($letras[$i_cl_pg2])->setAutoSize(true);

			$info_criancas = $this->FConsultas_model->mostrarCriancasPais($id_lider, 3);
			$info_pg = $this->FConsultas_model->mostrarPG($id_lider, 3);

			$check = $this->FConsultas_model->check_lider_is_ativo($id_lider, $data_cadastro, $ativo, $confirmado);

			if (!$check) {
				array_push($pg_n_ativos_row, $row2);
			} else {
			}

			$excel->getSheet(2)->setCellValue($letras[$i_cl_pg2] . $row2, $lider['nome_lider']);
			$i_cl_pg2++;

			if ($bol_check_col_1) {
				$excel->getSheet(2)->setCellValue($letras[$i_cl_pg2] . $row2, $info_criancas['row']);
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
				$excel->getSheet(2)->setCellValue($letras[$i_cl_pg2] . $row2, $nome_ciclo);
				$i_cl_pg2++;
			}
			if ($bol_check_col_3) {
				$id_modulo = $info_pg['dados']['id_modulo'];
				$modulo = $this->FConsultas_model->consultarModuloId($id_modulo);
				$nome_modulo = $modulo['nome_modulo'];
				$excel->getSheet(2)->setCellValue($letras[$i_cl_pg2] . $row2, $nome_modulo);
				$i_cl_pg2++;
			}
			if ($bol_check_col_4) {
				$excel->getSheet(2)->setCellValue($letras[$i_cl_pg2] . $row2, $info_pg['dados']['n_licao']);
				$i_cl_pg2++;
			}
			$row2++;
			$i_cl_pg2 = 1;
		}

		$linhas_2 = $row2 - 1;
		$colunas_dados_lideres = $letras[1] . $row . ":" . $letras[$i_cl_pg - 1] . $linhas_2;

		// style to columns descricao
		$excel->getSheet(2)->getStyle($colunas_dados_lideres)->applyFromArray(
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
			$excel->getSheet(2)->getStyle($colunas_dados_lideres)->applyFromArray(
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

		$excel->getSheet(2)->getStyle('B4:Z' . $row2)->getAlignment()->setHorizontal('center');
		// planilha informações gerais

		header('Content-Type: text/csv; charset=UTF-8');
		header('Content-Disposition: attachment; filename=Planilha CAMP Brasil - Líderes (' . $data . ').csv');
		header('Cache-Control: max-age=0');

		$file = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');

		ob_end_clean();
		$file->save('php://output');
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
