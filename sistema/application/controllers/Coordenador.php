<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property $input
 * @property FConsultas_model $FConsultas_model
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

	// ok
	public function criar_link($id_usuario)
	{
		$consultarLink = $this->db->select("*")
			->from("link_cadastro")
			->where("id_usuario", $id_usuario)
			->get();
		$totalLink = $consultarLink->num_rows();
		$info_codigo = $consultarLink->row_array();

		if ($totalLink == 0) {
			$dados_coordenador = $this->Coordenadores->infos([$id_usuario], 'info_coordenador', '', '');

			if ($dados_coordenador['row'] != 0) {
				$dados = $dados_coordenador['dados']['id_supervisorR'];
				$nivel = 3;
			}/* else if ($dados_supervisor['row'] == 0) {
				$nivel = 4;
			}*/

			$codigo = $this->FConsultas_model->gerarLink();
			$link = "https://sistemas.campbrasil.com/sistema/cadastro/" . $codigo;
			$data = date('Y-m-d');

			$inserir = [
				'id_usuario' => $id_usuario,
				'nivel' => $nivel,
				'codigo' => $codigo,
				'link' => $link,
				'dados' => $dados,
				'data' => $data
			];

			if ($this->db->insert('link_cadastro', $inserir)) {
				echo json_encode(['link' => $link]);
			} else {
				echo json_encode(['erro' => true]);
			}
		} else {
			echo json_encode(['link' => $info_codigo['link']]);
		}
	}

	/* COORDENADOR */
	public function home()
	{
		$this->load->view('sistema/coordenador/home');
	}
	// Dados Pessoal ok
	public function pagina_editar_pessoal()
	{
		$this->load->view('sistema/coordenador/edicao/pagina_editar_pessoal');
	}

	// ok
	public function e_pessoal()
	{
		$id = $this->input->post("id");
		$nome = $this->input->post("nome");
		$cpf = $this->input->post("cpf");
		$email = $this->input->post("email");
		$telefone_digitado = $this->input->post("telefone");
		$nascimento = $this->input->post("nascimento");

		$id_usuario = $this->input->post("id_usuario");
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

		$id_supervisor = $this->input->post('id_supervisor');

		$foto_antiga = $this->input->post("foto_antiga");

		$filesCount1 = count($_FILES['files']['name']);

		$mensagem = [];

		$telefone = $this->FConsultas_model->formatar_telefone($telefone_digitado, $is_br);

		// editar coordenador brasileiro
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
					$foto = 'fotoU/coordenador/' . $_FILES['files']['name'][$i];

					if ($_FILES['files']['name'][$i] == '') {
						$edicao = $this->Coordenadores->editar_coordenador($id, $nome, $cpf_completo, $email, $telefone, $data_nascimento_completo, $pais, $estado, $cidade, 2, $id_supervisor, $id_supervisor, $foto_antiga);
						$editar_usuario = $this->Lideres->editar_usuario($id_usuario, $nome, $email, $cpf_completo, $senha);
						if ($edicao && $editar_usuario) {
							array_push($mensagem, "Sucesso! Seus Dados foram Editados!");
						} else {
							array_push($mensagem, "Erro! Seus dados estão inválidos!");
						}
					} else {
						if ($foto_antiga == $foto) {
							$edicao = $this->Coordenadores->editar_coordenador($id, $nome, $cpf_completo, $email, $telefone, $data_nascimento_completo, $pais, $estado, $cidade, 2, $id_supervisor, $id_supervisor, $foto_antiga);
							$editar_usuario = $this->Lideres->editar_usuario($id_usuario, $nome, $email, $cpf_completo, $senha);

							if ($edicao && $editar_usuario) {
								array_push($mensagem, "Sucesso! Seus Dados foram Editados!");
							} else {
								array_push($mensagem, "Erro! Seus dados estão inválidos!");
							}
						} else {
							if (file_exists($foto)) {
								$edicao = $this->Coordenadores->editar_coordenador($id, $nome, $cpf_completo, $email, $telefone, $data_nascimento_completo, $pais, $estado, $cidade, 2, $id_supervisor, $id_supervisor, $foto_antiga);
								$editar_usuario = $this->Lideres->editar_usuario($id_usuario, $nome, $email, $cpf_completo, $senha);

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
									$edicao = $this->Coordenadores->editar_coordenador($id, $nome, $cpf_completo, $email, $telefone, $data_nascimento_completo, $pais, $estado, $cidade, 2, $id_supervisor, $id_supervisor, $foto);
									$editar_usuario = $this->Lideres->editar_usuario($id_usuario, $nome, $email, $cpf_completo, $senha);

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
					$foto = 'fotoU/coordenador/' . $_FILES['files']['name'][$i];

					if ($_FILES['files']['name'][$i] == '') {
						$edicao = $this->Coordenadores->editar_coordenador($id, $nome, "", $email, $telefone, $data_nascimento_completo, $pais, $estado, $cidade, 2, $id_supervisor, $id_supervisor, $foto_antiga);
						$editar_usuario = $this->Lideres->editar_usuario($id_usuario, $nome, $email, "", $senha);

						if ($edicao && $editar_usuario) {
							array_push($mensagem, "Sucesso! Seus Dados foram Editados!");
						} else {
							array_push($mensagem, "Erro! Seus dados estão inválidos!");
						}
					} else {
						if ($foto_antiga == $foto) {
							$edicao = $this->Coordenadores->editar_coordenador($id, $nome, "", $email, $telefone, $data_nascimento_completo, $pais, $estado, $cidade, 2, $id_supervisor, $id_supervisor, $foto_antiga);
							$editar_usuario = $this->Lideres->editar_usuario($id_usuario, $nome, $email, "", $senha);

							if ($edicao && $editar_usuario) {
								array_push($mensagem, "Sucesso! Seus Dados foram Editados!");
							} else {
								array_push($mensagem, "Erro! Seus dados estão inválidos!");
							}
						} else {
							if (file_exists($foto)) {
								$edicao = $this->Coordenadores->editar_coordenador($id, $nome, "", $email, $telefone, $data_nascimento_completo, $pais, $estado, $cidade, 2, $id_supervisor, $id_supervisor, $foto_antiga);
								$editar_usuario = $this->Lideres->editar_usuario($id_usuario, $nome, $email, "", $senha);

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
									$edicao = $this->Coordenadores->editar_coordenador($id, $nome, "", $email, $telefone, $data_nascimento_completo, $pais, $estado, $cidade, 2, $id_supervisor, $id_supervisor, $foto);
									$editar_usuario = $this->Lideres->editar_usuario($id_usuario, $nome, $email, "", $senha);

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

		$consultarCriancas = $this->Criancas->query([$id], 'query_id_lider');

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

		$red = $this->input->post('red');

		//echo '<script>alert("' . implode("\\n", $mensagem) . '");</script>';
		echo '
			<script>
				if(window.confirm("' . implode("\\n", $mensagem) . '")) {
					window.location="' . $red . '";
				}else{
					window.location="' . $red . '";
				}
			</script>
		';
	}
	// Fim Dados Pessoal

	// PG // ok
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
		$dadosPg = $this->PG->query([$id_lider, $id_pg], 'query_id_lider_id_pg_ativo', 1);

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
				"red" => "../lider/$id_lider",
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

		$red = $this->input->post('red');

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
			'red' => $red,
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

		$red = $this->input->post('red');
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
				"red" => "../lider/$id_lider",
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
			'red' => $red,
		);

		$this->load->view('sistema/coordenador/pages/preenchimento_relatorio', $dados);
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

	// líderes
	public function pagina_ver_lideres() // ok
	{
		$this->load->view('sistema/coordenador/pages/pagina_ver_lideres');
	}

	public function mostrar_table_lider() // ok
	{
		$id_user = $this->input->get("id_user");

		$dados_usuario = $this->Coordenadores->infos([$id_user], 'info_coordenador', '', '');
		$dados_lideres = $this->consultasBDLider($id_user);

		$dados = array(
			'info_lideres' => $dados_lideres,
			'info' => $dados_usuario,
		);

		//print_r($dados_lideres);

		$this->load->view('sistema/coordenador/pages/lideres/mostrar_tabela_lider', $dados);
	}

	public function consultasBDLider($id_user)
	{
		$list_lideres = [];
		$list_lideres_comparacao = [];

		// Consulta líderes do supervisor
		$lideres = $this->db->query("
        SELECT * FROM lider
        WHERE id_coordenador = $id_user
        ORDER BY nome_lider ASC
    ")->result_array();

		$total_lideres_ativos = 0;

		// 🔹 1. Coleta todos os IDs de líderes de uma vez
		$ids = array_column($lideres, 'id_lider');

		/*if (empty($ids)) {
			return ['row' => 0, 'dados' => []];
		}*/

		// 🔹 2. Busca todas as crianças desses líderes de uma vez
		$criacas_por_lider = $this->Criancas->criacasPorLideres($ids);

		// 🔹 3. Busca todos os progressos de uma vez
		$progresso_por_lider = $this->PG->progressoPorLideres($ids);

		foreach ($lideres as $l) {
			$id_lider = $l['id_lider'];
			$ativo = $l['confirmado'];
			$data_cadastro = $l['data_cadastro'];

			// verifica se o líder está ativo (função já existente)
			$check_lider_ativo = $this->Lideres->check_lider_is_ativo_otimizado(
				$id_lider,
				$data_cadastro,
				$ativo,
				$criacas_por_lider,
				$progresso_por_lider
			);

			$total_lideres_ativos += $check_lider_ativo;

			// total de crianças do líder
			$query_criancas = $this->db->query("
            SELECT COUNT(*) AS total
            FROM criancas
            WHERE lider = $id_lider
        ")->row_array();
			$total_criancas = $query_criancas['total'] ?? 0;

			/*$total_criancas_ativas = 0;

            if ($check_lider_ativo == 0) {
            } else {*/
			// total de crianças ativas do líder
			$query_criancas_ativas = $this->db->query("
                    SELECT COUNT(*) AS total
                    FROM criancas
                    WHERE lider = $id_lider AND ativo = 1
                ")->row_array();
			$total_criancas_ativas = $query_criancas_ativas['total'] ?? 0;
			//}

			// adiciona os totais ao array do líder
			$l['total_criancas'] = $total_criancas;
			$l['total_criancas_ativos'] = $total_criancas_ativas;
			$l['check_lider_ativo'] = $check_lider_ativo;

			$list_lideres[] = $l;
		}

		// === COMPARAÇÃO COM O ANO ANTERIOR ===
		/*if ($opc2 == 'sim' && $opc3 == 'query_supervisor_inicial') {
            $data_inicio_ano_passado = $datas['dataInicioAnoPassado'];
            $data_fim_ano_passado = $datas['dataFimAnoPassado'];
            $datas_2 = ['data_1' => $data_inicio_ano_passado, 'data_2' => $data_fim_ano_passado];

            $lideres_ano_passado = $this->db->query("
            SELECT * FROM lider
            WHERE id_supervisorR = $id_user
            AND data_cadastro BETWEEN '$data_inicio_ano_passado' AND '$data_fim_ano_passado'
            ORDER BY nome_lider ASC
        ")->result_array();

            foreach ($lideres_ano_passado as $l) {
                $id_lider = $l['id_lider'];
                $ativo = $l['confirmado'];
                $data_cadastro = $l['data_cadastro'];

                // verifica se o líder está ativo (função já existente)
                $check_lider_ativo = $this->Lideres->check_lider_is_ativo_otimizado(
                    $id_lider,
                    $data_cadastro,
                    $ativo,
                    $criacas_por_lider,
                    $progresso_por_lider
                );

                // Total de crianças do ano passado
                $query_criancas = $this->db->query("
                SELECT COUNT(*) AS total
                FROM criancas
                WHERE lider = $id_lider
                AND data_cadastro BETWEEN '$data_inicio_ano_passado' AND '$data_fim_ano_passado'
            ")->row_array();
                $total_criancas = $query_criancas['total'] ?? 0;

                // Total de crianças ativas do ano passado
                $query_criancas_ativas = $this->db->query("
                SELECT COUNT(*) AS total
                FROM criancas
                WHERE lider = $id_lider
                AND ativo = 1
                AND data_cadastro BETWEEN '$data_inicio_ano_passado' AND '$data_fim_ano_passado'
            ")->row_array();
                $total_criancas_ativos = $query_criancas_ativas['total'] ?? 0;

                $l['total_criancas'] = $total_criancas;
                $l['total_criancas_ativos'] = $total_criancas_ativos;
                $l['check_lider_ativo'] = $check_lider_ativo;

                $list_lideres_comparacao[] = $l;
            }
        }*/

		return [
			'total_lideres' => count($lideres),
			'total_lideres_ativos' => $total_lideres_ativos,
			'dados_lideres_gerais' => ['dados' => $list_lideres],
			'dados_lideres_gerais_comparacao' => ['dados' => $list_lideres_comparacao], // deixei vazio, igual no original
		];
	}
	public function pagina_ver_detalhes_lider() // ok
	{
		$id_lider =  $this->uri->segment(4);

		$dados_lider = $this->Lideres->infos([$id_lider], 'info_lider', '', '', '');
		$dados = array(
			'id_lider' => $id_lider,
			'dados_do_lider' => $dados_lider,
		);
		$this->load->view('sistema/coordenador/pages/lideres/pagina_ver_info_lideres', $dados);
	}
	/* FIM COORDENADOR */
}
