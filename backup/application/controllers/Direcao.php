<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property input $input
 * @property FConsultas_model $FConsultas_model
 * @property FSistema_model $FSistema_model
 * @property db $db
 * @property upload $upload
 * @property email $email
 * @property uri $uri
 */

class Direcao extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('America/Sao_Paulo');
	}
	/* COORDENADOR */

	public function home()
	{
		$this->load->view('sistema/direcao/home');
	}
	// Dados Pessoal
	public function pagina_editar_pessoal()
	{
		$this->load->view('sistema/sregional/edicao/pagina_editar_pessoal');
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

	// S Regional
	public function pagina_ver_sregional()
	{
		$id_sregional = $this->uri->segment(4);

		$pages = [];

		if ($id_sregional == '') {
			$page1 = array(
				"red" => "../home",
				"name" => "Home",
				"icon" => "fa fa-home",
			);
			array_push($pages, $page1);
		} else {
			$page1 = array(
				"red" => "../../home",
				"name" => "Home",
				"icon" => "fa fa-home",
			);
			array_push($pages, $page1);
			$page2 = array(
				"red" => "../equipe",
				"name" => "Equipe",
				"icon" => "fa fa-users",
			);
			array_push($pages, $page2);
		}

		$dados = array(
			'id_sregional' => $id_sregional,
			'pages' => $pages,
		);

		$this->load->view('sistema/direcao/pages/pagina_ver_sregional', $dados);
	}

	public function pagina_ver_detalhes_sregional()
	{

		$segmento = $this->uri->segment(4);
		$id_sregional = $this->uri->segment(5);
		$dados_sregional = $this->FConsultas_model->getInfoSRegionalId($id_sregional);

		$pages = [];

		if ($id_sregional == '') {
			$page1 = array(
				"red" => "../home",
				"name" => "Home",
				"icon" => "fa fa-home",
			);
			array_push($pages, $page1);
		} else {
			if ($segmento == 'sregional') {
				$page1 = array(
					"red" => "../../home",
					"name" => "Home",
					"icon" => "fa fa-home",
				);
				array_push($pages, $page1);
				$page2 = array(
					"red" => "../equipe",
					"name" => "Equipe",
					"icon" => "fa fa-users",
				);
				array_push($pages, $page2);
			} else {
				$page1 = array(
					"red" => "../../../home",
					"name" => "Home",
					"icon" => "fa fa-home",
				);
				array_push($pages, $page1);
				$page2 = array(
					"red" => "../../equipe",
					"name" => "Equipe",
					"icon" => "fa fa-users",
				);
				array_push($pages, $page2);
				$page2 = array(
					"red" => "../$id_sregional",
					"name" => "Lista",
					"icon" => "fa fa-user",
				);
				array_push($pages, $page2);
			}
		}

		$dados = array(
			'dados' => $dados_sregional,
			'pages' => $pages,
			'id_sregional' => $id_sregional,
		);

		$this->load->view('sistema/direcao/pages/sregional/pagina_ver_info_sregional', $dados);
	}

	public function mostrar_info_sregional()
	{
		$id_user = $this->input->get("id_user");
		$opc1 = $this->input->get("opc1");
		$opc2 = $this->input->get("opc2");
		$opc3 = $this->input->get("opc3");

		$dataInicio = $this->input->get("dataInicio");
		$dataFim = $this->input->get("dataAte");

		$nivel = $this->input->get("nivel") ?? "lideres";
		$check_is_coord_query = $this->input->get("check_is_coord_query") ?? false;

		$datas = $this->FSistema_model->format_dates($opc1, $opc2, $dataInicio, $dataFim);

		$dados_sregional = $this->FConsultas_model->getSRegional(['direcao'], $opc1, $opc2, $datas);

		$dados_slocal = $this->FConsultas_model->getSLocal(['direcao'], $opc1, $opc2, $datas);
		$dados_coordenadores = $this->FConsultas_model->getCoordenador(['direcao'], $opc1, $opc2, $datas);
		$dados_lideres = $this->FConsultas_model->getLideres(['direcao'], $opc1, $opc2, $datas);
		$total_criancas_lider = $dados_lideres[1];
		$total_criancas_lider_ativos = $dados_lideres[2];

		$comparacao = [];
		$comparacao_ativos = [];

		// criando a comparação
		if ($opc2 == 'sim') {
			$comparacao_sregional = $dados_sregional[1];
			$comparacao_sregional_ativos = $dados_sregional[2];

			array_push($comparacao, $comparacao_sregional);
			array_push($comparacao_ativos, $comparacao_sregional_ativos);

			$comparacao_slocal = $dados_slocal[1];
			$comparacao_slocal_ativos = $dados_slocal[2];

			array_push($comparacao, $comparacao_slocal);
			array_push($comparacao_ativos, $comparacao_slocal_ativos);

			$comparacao_coordenadores = $dados_coordenadores[1];
			$comparacao_coordenadores_ativos = $dados_coordenadores[2];

			array_push($comparacao, $comparacao_coordenadores);
			array_push($comparacao_ativos, $comparacao_coordenadores_ativos);

			$comparacao_lideres = $dados_lideres[3];
			$comparacao_lideres_ativos = $dados_lideres[4];

			array_push($comparacao, $comparacao_lideres);
			array_push($comparacao_ativos, $comparacao_lideres_ativos);

			$total_criancas_lider_comparacao = $dados_lideres[5];
			$total_criancas_lider_ativos_comparacao = $dados_lideres[6];

			$lista_de_id_1 = $this->FSistema_model->retornando_so_id('id_supervisorEs', $comparacao_sregional['dados']);
			$lista_de_id_2 = $this->FSistema_model->retornando_so_id('id_supervisorR', $comparacao_slocal['dados']);
			$lista_de_id_3 = $this->FSistema_model->retornando_so_id('id_coordenador', $comparacao_coordenadores['dados']);

			$id_gerais_comparacao = array_merge($lista_de_id_1, $lista_de_id_2, $lista_de_id_3);

			$total_criancas_geral_comparacao = $total_criancas_lider_comparacao + $this->FConsultas_model->getNumerosCriancas($id_user, $id_gerais_comparacao, 'direcao');

			array_push($comparacao, $total_criancas_geral_comparacao);

			$lista_de_id_1_ativos = $this->FSistema_model->retornando_so_id('id_supervisorEs', $comparacao_sregional_ativos['dados']);
			$lista_de_id_2_ativos = $this->FSistema_model->retornando_so_id('id_supervisorR', $comparacao_slocal_ativos['dados']);
			$lista_de_id_3_ativos = $this->FSistema_model->retornando_so_id('id_coordenador', $comparacao_coordenadores_ativos['dados']);

			$id_ativos_comparacao = array_merge($lista_de_id_1_ativos, $lista_de_id_2_ativos, $lista_de_id_3_ativos);

			$total_criancas_geral_ativos_comparacao = $total_criancas_lider_ativos_comparacao +  $this->FConsultas_model->getNumerosCriancas($id_user, $id_ativos_comparacao, 'direcao');

			array_push($comparacao_ativos, $total_criancas_geral_ativos_comparacao);
		}

		$lista = $opc3 == 'sregionais_ativos' ? $dados_sregional[0]['dados'] : $dados_sregional['dados'];
		$dados_mostrar = $opc3 == 'sregionais_ativos' ? $dados_sregional[0] : $dados_sregional;

		$lista_de_id_1 = $this->FSistema_model->retornando_so_id('id_supervisorEs', $dados_sregional['dados']);
		$lista_de_id_2 = $this->FSistema_model->retornando_so_id('id_supervisorR', $dados_slocal['dados']);
		$lista_de_id_3 = $this->FSistema_model->retornando_so_id('id_coordenador', $dados_coordenadores['dados']);

		$id_gerais = array_merge($lista_de_id_1, $lista_de_id_2, $lista_de_id_3);

		$total_criancas_geral = $total_criancas_lider + $this->FConsultas_model->getNumerosCriancas($id_user, $id_gerais, 'direcao');

		$lista_de_id_1_ativos = $this->FSistema_model->retornando_so_id('id_supervisorEs', $dados_sregional[0]['dados']);
		$lista_de_id_2_ativos = $this->FSistema_model->retornando_so_id('id_supervisorR', $dados_slocal[0]['dados']);
		$lista_de_id_3_ativos = $this->FSistema_model->retornando_so_id('id_coordenador', $dados_coordenadores[0]['dados']);

		$id_ativos = array_merge($lista_de_id_1_ativos, $lista_de_id_2_ativos, $lista_de_id_3_ativos);

		$total_criancas_geral_ativos = $total_criancas_lider_ativos +  $this->FConsultas_model->getNumerosCriancas($id_user, $id_ativos, 'direcao');

		$dados_new = [];

		$array = array(
			'id_user' => $id_user,
			'dados_sregional' => $dados_sregional['row'],
			'dados_sregional_ativos' => $dados_sregional[0]['row'],
			'dados_slocal_gerais' => $dados_slocal['row'],
			'dados_slocal_ativos' => $dados_slocal[0]['row'],
			'dados_coordenadores_gerais' => $dados_coordenadores['row'],
			'dados_coordenadores_ativos' => $dados_coordenadores[0]['row'],
			'dados_lideres_gerais' => $dados_lideres['row'],
			'dados_lideres_ativos' => $dados_lideres[0]['row'],
			'dados_criancas_gerais' => $total_criancas_geral,
			'dados_criancas_ativos' => $total_criancas_geral_ativos,
			'mostrar_comparacao' => $opc2,
			'check_is_coord_query' => $check_is_coord_query,
			'comparacao' => $comparacao,
			'comparacao_ativos' => $comparacao_ativos,
		);
		$dados_new = $array;
		$this->load->view('sistema/direcao/pages/sregional/mostrar_tabela_sregional_1', $dados_new);
	}

	// S Local
	public function pagina_ver_slocal()
	{
		$id_slocal = $this->uri->segment(4);

		$pages = [];

		if ($id_slocal == '') {
			$page1 = array(
				"red" => "../home",
				"name" => "Home",
				"icon" => "fa fa-home",
			);
			array_push($pages, $page1);
		} else {
			$page1 = array(
				"red" => "../../home",
				"name" => "Home",
				"icon" => "fa fa-home",
			);
			array_push($pages, $page1);

			$page2 = array(
				"red" => "../slocal",
				"name" => "Equipe",
				"icon" => "fa fa-users",
			);
			array_push($pages, $page2);
		}

		$dados = array(
			'id_slocal' => $id_slocal,
			'pages' => $pages,
		);

		$this->load->view('sistema/direcao/pages/pagina_ver_slocal', $dados);
	}

	public function pagina_ver_detalhes_slocal()
	{

		$segmento = $this->uri->segment(4);
		$id_slocal = $this->uri->segment(5);
		$dados_slocal = $this->FConsultas_model->getInfoSLocalId($id_slocal);

		$pages = [];

		if ($id_slocal == '') {
			$page1 = array(
				"red" => "../home",
				"name" => "Home",
				"icon" => "fa fa-home",
			);
			array_push($pages, $page1);
		} else {
			if ($segmento == 'slocal') {
				$page1 = array(
					"red" => "../../home",
					"name" => "Home",
					"icon" => "fa fa-home",
				);
				array_push($pages, $page1);
				$page2 = array(
					"red" => "../slocal",
					"name" => "Equipe",
					"icon" => "fa fa-users",
				);
				array_push($pages, $page2);
			} else {
				$page1 = array(
					"red" => "../../../home",
					"name" => "Home",
					"icon" => "fa fa-home",
				);
				array_push($pages, $page1);
				$page2 = array(
					"red" => "../../slocal",
					"name" => "Equipe",
					"icon" => "fa fa-users",
				);
				array_push($pages, $page2);
				$page2 = array(
					"red" => "../$id_slocal",
					"name" => "Lista",
					"icon" => "fa fa-user",
				);
				array_push($pages, $page2);
			}
		}

		$dados = array(
			'dados' => $dados_slocal,
			'pages' => $pages,
			'id_slocal' => $id_slocal,
		);

		$this->load->view('sistema/direcao/pages/slocal/pagina_ver_info_slocal', $dados);
	}

	// Coordenadores
	public function pagina_ver_coordenador()
	{
		$id_coordenador = $this->uri->segment(4);

		$pages = [];

		if ($id_coordenador == '') {
			$page1 = array(
				"red" => "../home",
				"name" => "Home",
				"icon" => "fa fa-home",
			);
			array_push($pages, $page1);
		} else {
			$page1 = array(
				"red" => "../../home",
				"name" => "Home",
				"icon" => "fa fa-home",
			);
			array_push($pages, $page1);

			$page2 = array(
				"red" => "../slocal",
				"name" => "Equipe",
				"icon" => "fa fa-users",
			);
			array_push($pages, $page2);
		}

		$dados = array(
			'id_coordenador' => $id_coordenador,
			'pages' => $pages,
		);

		$this->load->view('sistema/direcao/pages/pagina_ver_coordenadores', $dados);
	}
	public function pagina_ver_detalhes_coordenadores()
	{

		$id_coord = $this->uri->segment(5);
		$dados_coordenador = $this->FConsultas_model->getInfoCoordenadorId($id_coord);

		/*$id_coord = $this->input->post('id_coord') ?? '';
		$nivel = $this->input->post('nivel_routa') ?? 'lider';*/

		$pages = [];

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


		$dados = array(
			'dados_do_coordenador' => $dados_coordenador,
			'pages' => $pages,
			'id_coord' => $id_coord,
		);

		$this->load->view('sistema/sregional/pages/coordenadores/pagina_ver_info_coordenador', $dados);
	}

	// Líderes
	public function pagina_ver_lideres()
	{
		$id_user = $this->input->post("id_user");
		$id_user_2 = $this->input->post("id_user_2");

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
				"red" => "coordenadores",
				"name" => "Coordenadores",
				"icon" => "fa fa-group",
			);

			array_push($pages, $page1);
			array_push($pages, $page2);
		}

		$dados = array(
			'id_user' => $id_user,
			'id_user_2' => $id_user_2,
			'pages' => $pages,
		);

		$this->load->view('sistema/sregional/pages/pagina_ver_lideres', $dados);
	}

	public function pagina_ver_detalhes_lideres()
	{

		$id_lider = $this->uri->segment(5);
		$dados_lider = $this->FConsultas_model->getInfoLiderId($id_lider);

		$id_coord = $this->input->post('id_coord') ?? '';
		$nivel = $this->input->post('nivel_routa') ?? 'lider';

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

		$this->load->view('sistema/sregional/pages/lideres/pagina_ver_info_lideres', $dados);
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

		$red = $this->input->post('red') ?? 'lideres/detalhes';

		$nivel_routa = $this->input->post("nivel_routa") ?? 'lider';
		$id_coord = $this->input->post("id_coord");

		$routa = "";
		$data = [
			"<input type='hidden' name='id_coord' value='$id_coord'>",
			"<input type='hidden' name='nivel_routa' value='$nivel_routa'>"
		];

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

	// PG
	public function pagina_visualizacao_pg()
	{
		$this->load->view('sistema/sregional/pages/pagina_pg_usuario');
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
					"red" => "../lideres_do_coordenador/$id_coord",
					"name" => "Líderes",
					"icon" => "fa fa-group",
				);

				$page3 = array(
					"red" => "../info_lider_pessoal/$id_coord/$id_lider",
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

		$this->load->view('sistema/sregional/pages/pg/licaos', $dados);
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
					"red" => "../lideres_do_coordenador/$id_coord",
					"name" => "Líderes",
					"icon" => "fa fa-group",
				);

				$page3 = array(
					"red" => "../info_lider_pessoal/$id_coord/$id_lider",
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

		$this->load->view('sistema/sregional/pages/preenchimento_relatorio', $dados);
	}

	public function consulta_criancas_relatorios()
	{
		$this->load->view('sistema/sregional/pages/consultas/retornar_infomacoes');
	}
	// Fim PG

	// Download de Material
	public function pagina_download_material()
	{
		$this->load->view('sistema/sregional/pages/download_material');
	}

	public function pagina_download_material_modulo()
	{
		$this->load->view('sistema/sregional/pages/download_material_modulo');
	}

	public function pagina_material_apoio_treinamento()
	{
		$this->load->view('sistema/sregional/pages/material_apoio_treinamento');
	}
	/* FIM COORDENADOR */
}
