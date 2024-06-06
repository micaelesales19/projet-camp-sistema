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

class Coordenador extends CI_Controller
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
	/* LÍDER */

	public function home()
	{
		$this->load->view('sistema/coordenador/home');
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
		$this->load->view('sistema/coordenador/pages/pagina_ver_lideres');
	}

	public function mudar_data()
	{
		$consultar_lideres = $this->db->query("SELECT * FROM lider");
		$dados_consulta_lideres = $consultar_lideres->result_array();

		foreach ($dados_consulta_lideres as $key => $value) {
			$id = $value['id_lider'];
			$data = $value['data'];

			//echo $id . ": ";

			if ($data == '') {
				$consultar_pg = $this->db->query("SELECT * FROM pg WHERE id_lider = $id");
				$dados_consulta_pg = $consultar_pg->row_array();
				$row = $consultar_pg->num_rows();

				if ($row == 0) {
					$data_nova = '2018-08-10';
					//echo $data_nova . "<br>";
				} else {
					$data2 = $dados_consulta_pg['data_inicio'];
					if ($data2 == '') {
						$data_nova = '2018-08-10';
						//echo $data_nova . "<br>";
					} else {
						$dia = $data2[0] . $data2[1];
						$mes = $data2[3] . $data2[4];
						$ano = $data2[6] . $data2[7] . $data2[8] . $data2[9];
						$data_nova = $ano . "-" . $mes . "-" . $dia;

						//echo $data_nova . "<br>";
					}
				}
			} else {

				$dia = $data[0] . $data[1];
				$mes = $data[3] . $data[4];
				$ano = $data[6] . $data[7] . $data[8] . $data[9];
				$data_nova = $ano . "-" . $mes . "-" . $dia;

				//echo $data_nova . "<br>";
			}

			$this->db->set('data_cadastro', $data_nova);
			$this->db->where('id_lider', $id);
			$this->db->update('lider');
		}
	}

	public function mostrar_table_parte_1()
	{
		$id_coordenador = $this->input->get("id_coordenador");
		$opc1 = $this->input->get("opc1");
		$opc2 = $this->input->get("opc2");

		$dataInicio = $this->input->get("dataInicio");
		$dataFim = $this->input->get("dataAte");

		$dados = $this->consultasBD($id_coordenador, $opc1, $opc2, $dataInicio, $dataFim);

		$this->load->view('sistema/coordenador/pages/consultas/mostrar_tabela_lideres_1', $dados);
	}

	public function mostrar_table_parte_2()
	{
		$id_coordenador = $this->input->get("id_coordenador");
		$opc1 = $this->input->get("opc1");
		$opc2 = $this->input->get("opc2");

		$dataInicio = $this->input->get("dataInicio");
		$dataFim = $this->input->get("dataAte");

		$dados = $this->consultasBD($id_coordenador, $opc1, $opc2, $dataInicio, $dataFim);

		$this->load->view('sistema/coordenador/pages/consultas/mostrar_tabela_lideres_2', $dados);
	}

	public function consultasBD($id_coordenador, $opc1, $opc2, $dataInicio, $dataFim)
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

		$consultarLideres = $this->FConsultas_model->getLideres([$id_coordenador], $opc1, $opc2, $datas);
		$consultarLideresAtivos = $this->FConsultas_model->lideresAtivos($consultarLideres);

		$total_criancas_geral = $this->FConsultas_model->getNumerosCriancas([$id_coordenador], $consultarLideres, 'criancas_coord_1');
		$total_criancas_ativos = $this->FConsultas_model->getNumerosCriancas([$id_coordenador], $consultarLideresAtivos, 'criancas_coord_1');

		$dados = array(
			'dados_coordenador' => $dados_coordenador,
			'dados_lideres_gerais' => $consultarLideres,
			'dados_lideres_ativos' => $consultarLideresAtivos,
			'dados_criancas_gerais' => $total_criancas_geral,
			'dados_criancas_ativos' => $total_criancas_ativos,
			'mostrar_comparacao' => $opc2,
		);

		return $dados;
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

		$dados = $this->consultasBD($id_coordenador, $opc1, $opc2, $dataInicio, $dataFim);

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

			$excel->getSheet(2)->getColumnDimension($letras[$i_cl_pg2])->setAutoSize(true);

			$info_criancas = $this->FConsultas_model->mostrarCriancasPais($id_lider, 3);
			$info_pg = $this->FConsultas_model->mostrarPG($id_lider, 3);

			if ($info_criancas['row'] == 0) {
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

	public function pagina_licoes()
	{

		$id_pg = $this->input->post("id_pg");
		$id_lider = $this->input->post("id_lider");
		$ano = $this->input->post("ano");

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
		$ano = $this->input->get("ano");
		$total = $this->input->get("total"); // total de botões dos módulos escolhidos

		$id_crianca = $this->input->get("id_crianca");

		$page = $this->input->get('page') == '' ? 'inicial' : $this->input->get('page');

		$dadosPg = $this->FConsultas_model->mostrarPGId($id_lider, $id_pg, 1);

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

	public function atualizarDataPG()
	{
		$idPg = $this->input->post('id_pg');
		$idLider = $this->input->post('id_lider');
		$check = $this->input->post('check');
		$data = $this->input->post('data');

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

		$data = [
			"<input type='hidden' name='id_pg' value='$idPg'>",
			"<input type='hidden' name='id_lider' value='$idLider'>",
		];
		$funcao = $this->FConsultas_model->red('../pg', 0, $data);
		echo $funcao;
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
				$data = [];
				$funcao = $this->FConsultas_model->red('../../pagina_editar_pessoal', 0, $data);
				echo $funcao;
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
			$data = [];
			$funcao = $this->FConsultas_model->red('../pagina_editar_pessoal', 0, $data);
			echo $funcao;
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
			$data = [];
			$funcao = $this->FConsultas_model->red('../pagina_editar_pessoal', 0, $data);
			echo $funcao;
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
