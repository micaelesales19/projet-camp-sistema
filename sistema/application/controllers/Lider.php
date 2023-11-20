<?php

defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property $input
 * @property $db
 * @property FSistema_model $FSistema_model
 * @property FConsultas_model $FConsultas_model
 * @property FAlerta_model $FAlerta_model
 * @property $upload
 * @property FAlerta_model $FAlerta_model
 */

class Lider extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	/* LÍDER */

	public function home_lider()
	{
		$this->load->view('sistema/lider/home');
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

	// ALERTA 		
	public function alerta()
	{
		$this->load->view('sistema/lider/partes/menu_lateral');
		$this->load->view('sistema/lider/alerta/visualizar_alerta');
	}

	public function excluir_alerta()
	{
		$id_alerta = $this->input->get("id_alerta");
		//$this->FSistema_model->excluir_alerta($id_alerta);
	}
	// FIM ALERTA

	// Colíder			
	public function v_pagina_ver_colider()
	{
		$this->load->view('sistema/lider/pages/pagina_ver_colider');
	}

	public function c_pagina_cadastro_colider()
	{
		$this->load->view('sistema/lider/cadastro/pagina_cadastro_colider');
	}

	public function pagina_editar_colider()
	{
		$this->load->view('sistema/lider/edicao/pagina_editar_colider');
	}

	public function relatorio_informacao_colider()
	{

		$id_usuario = $this->input->get('id_usuario');
		$dados = array('id_usuario' => $id_usuario);
		$this->load->view('sistema/lider/relatorio/relatorio_colider', $dados);
	}



	public function salvar_cadastro_colider()
	{
		$id_lider = $this->input->post("id_lider");
		$nome = $this->input->post("nome");
		$cpf = $this->input->post("cpf");
		$email = $this->input->post("email");
		$telefone = $this->input->post("telefone");
		$nascimento = $this->input->post("nascimento");
		$nivel = "7";

		$consultar_dados_pais = $this->FConsultas_model->mostrar_pais($id_lider);
		$consultar_registro = $this->FConsultas_model->mostrar_registro_tabela($email, $cpf);

		$valida_cpf = $this->FAlerta_model->valida_cpf($cpf);
		$validaNIF = $this->FAlerta_model->validaNIF($cpf);
		$validaData = $this->FAlerta_model->ValidaData($nascimento);

		if ($consultar_registro) {
			$cadastro = $this->FSistema_model->cadastrarColider($id_lider, $nome, $cpf, $email, $telefone, $nascimento);
			$cadastro_usuario = $this->FSistema_model->cadastrarUsuário($nome, $email, $cpf, $nivel);

			if ($validaData) {
				if ($consultar_dados_pais) {
					if ($valida_cpf or $validaNIF) {
						if ($cadastro && $cadastro_usuario) {
							echo "Sucesso";
							echo '
										<script>
											setTimeout(function(){ window.location="../visualizar"}, 3000)
										</script>
									';
						} else {
							echo "Erro no cadastro";
							echo '
										<script>
											setTimeout(function(){ window.location="../visualizar"}, 3000)
										</script>
									';
						}
					} else {
						echo "Erro, CPF inválido!";
						echo '
									<script>
										setTimeout(function(){ window.location="../visualizar"}, 3000)
									</script>
								';
					}
				} else {
					if ($cadastro && $cadastro_usuario) {
						echo "Sucesso";
						echo '<script>
								setTimeout(function(){ window.location="../visualizar"}, 3000)
							</script>
						';
					} else {
						echo "Erro no cadastro";
						echo '<script>
								setTimeout(function(){ window.location="../visualizar"}, 3000)
							</script>
							';
					}
				}
			} else {
				echo "Erro, data de nascimento, inválida!";
				echo '
					<script>
						setTimeout(function(){ window.location="../visualizar"}, 3000)
					</script>
				';
			}
		} else {
			echo "Erro, um registro já cadastrado!";
			echo '
				<script>
					setTimeout(function(){ window.location="../visualizar"}, 3000)
				</script>
			';
		}
	}

	public function e_colider()
	{
		$id = $this->input->post("id");
		$id_lider = $this->input->post("id_lider");
		$nome = $this->input->post("nome");
		$cpf = $this->input->post("cpf");
		$email = $this->input->post("email");
		$telefone = $this->input->post("telefone");
		$nascimento = $this->input->post("nascimento");
		$valida_cpf = $this->FAlerta_model->valida_cpf($cpf);
		$validaNIF = $this->FAlerta_model->validaNIF($cpf);
		$validaData = $this->FAlerta_model->ValidaData($nascimento);

		$foto = "";

		if ($valida_cpf or $validaNIF) {
			if ($validaData) {
				$edicao = $this->FSistema_model->editarColider($id, $nome, $cpf, $email, $telefone, $nascimento, $foto);
				$edicao_usuario = $this->FSistema_model->editarUsuário($id, $nome, $email, $cpf);
				if ($edicao && $edicao_usuario) {
					echo "Sucesso";
					echo '
						<script>
							setTimeout(function(){ window.location="../visualizar"}, 3000)
						</script>
					';
				} else {
					echo "Erro na edição";
					echo '
								<script>
									setTimeout(function(){ window.location="../visualizar"}, 3000)
								</script>
							';
				}
			} else {
				echo "Erro, data de nascimento, inválida!";
				echo '
							<script>
								setTimeout(function(){ window.location="../visualizar"}, 3000)
							</script>
						';
			}
		} else {
			echo "Erro, CPF inválido!";
			echo '
						<script>
							setTimeout(function(){ window.location="../visualizar"}, 3000)
						</script>
					';
		}
	}



	public function excluir_colider()
	{
		$id_colider = $this->input->post("id_colider");
		$nome_colider = $this->input->post("nome_colider");
		$email = $this->input->post("email");
		$cpf = $this->input->post("cpf");
		$id_lider = $this->input->post("id_lider");
		$id_responsavel = $this->input->post("id_responsavel");
		$motivo = $this->input->post("motivo");

		$excluir_colider = $this->FSistema_model->excluirColider($id_colider, $nome_colider, $id_lider, $id_responsavel, $motivo);
		$excluir_usuario = $this->FSistema_model->excluirUsuário($email, $cpf);

		if ($excluir_colider && $excluir_usuario) {

			echo "Colíder Excluido";

			echo '

						<script>

							setTimeout(function(){ window.location="visualizar"}, 3000)

						</script>

					';
		} else {

			echo "Erro na exclusão! Tente novamente!";

			echo '

						<script>

							setTimeout(function(){ window.location="visualizar"}, 3000)

						</script>

					';
		}
	}

	public function reativar_colider()
	{
		$id_colider = $this->input->post("id_colider");
		$id_responsavel = $this->input->post("id_responsavel");
		$dados_colider = $this->FConsultas_model->mostrarColider($id_colider);

		if ($dados_colider) {
			$nome = $dados_colider['nome_colider'];
			$email = $dados_colider['email'];
			$cpf = $dados_colider['cpf'];
			$nivel = "7";
			$reativar_usuario = $this->FSistema_model->reativarUsuário($nome, $email, $cpf, $nivel);
			$reativar_colider = $this->FSistema_model->reativarColider($id_colider, $id_responsavel);

			if ($reativar_colider && $reativar_usuario) {
				echo "Colíder Reativado";

				echo '

							<script>

								setTimeout(function(){ window.location="visualizar"}, 3000)

							</script>

						';
			} else {

				echo "Erro! Tente novamente!";

				echo '

							<script>

								setTimeout(function(){ window.location="visualizar"}, 3000)

							</script>

						';
			}
		} else {

			echo "Erro! Tente novamente!";

			echo '

						<script>

							setTimeout(function(){ window.location="visualizar"}, 3000)

						</script>

					';
		}
	}

	// Fim Colíder



	// Dados Pessoal			

	public function pagina_editar_pessoal()

	{

		$this->load->view('sistema/lider/partes/menu_lateral');

		$this->load->view('sistema/lider/edicao/pagina_editar_pessoal');
	}



	public function e_pessoal_lider()

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

		$id_pastor = $this->input->post("id_pastor");

		$id_coord = $this->input->post("id_coord");

		$id_sr = $this->input->post("id_sr");

		$id_se = $this->input->post("id_se");



		$opc = $this->input->post("opc");



		$ponto = $cpf[3];

		$parentese = $telefone[0];

		$barra = $nascimento[2];



		$cpf_completo = "";

		$telefone_completo = "";

		$nascimento_completo = "";



		if ($ponto == ".") {

			$cpf_completo .= $cpf;
		} else {

			$cpf_completo .= $cpf[0] . $cpf[1] . $cpf[2] . "." . $cpf[3] . $cpf[4] . $cpf[5] . "." . $cpf[6] . $cpf[7] . $cpf[8] . "-" . $cpf[9] . $cpf[10];
		}



		if ($parentese == "(") {

			$telefone_completo .= $telefone;
		} else {

			$telefone_completo .= "(" . $telefone[0] . $telefone[1] . ") " . $telefone[2] . $telefone[3] . $telefone[4] . $telefone[5] . $telefone[6] . "-" . $telefone[7] . $telefone[8] . $telefone[9] . $telefone[10];
		}



		if ($barra == "/") {

			$nascimento_completo .= $nascimento;
		} else {

			$nascimento_completo .= $nascimento[0] . $nascimento[1] . "/" . $nascimento[2] . $nascimento[3] . "/" . $nascimento[4] . $nascimento[5] . $nascimento[6] . $nascimento[7];
		}





		$arquivo = $this->input->post("arquivo2");



		if ($opc == "Sim") {



			$filesCount = count($_FILES['files']['name']);



			for ($i = 0; $i < $filesCount; $i++) {

				$_FILES['file']['name']     = $_FILES['files']['name'][$i];

				$_FILES['file']['type']     = $_FILES['files']['type'][$i];

				$_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];

				$_FILES['file']['error']     = $_FILES['files']['error'][$i];

				$_FILES['file']['size']     = $_FILES['files']['size'][$i];



				// File upload configuration

				$uploadPath = 'import/sistema/fotoU/';

				$config['upload_path'] = $uploadPath;

				$config['allowed_types'] = 'jpg|jpeg|png|gif';



				// Load and initialize upload library

				$this->load->library('upload', $config);

				$this->upload->initialize($config);



				$foto = 'fotoU/' . $_FILES['files']['name'][$i];

				// Upload file to server

				if ($this->upload->do_upload('file')) {

					/*$this->FSistema_model->editarPessoalLider($id, $nome, $cpf_completo, $email, $telefone_completo, $igreja, $nascimento_completo, $estado, $cidade, $id_pastor, $id_coord, $id_sr, $id_se, $foto);*/
				} else {

					echo "Erro no Upload das Fotos";

					echo $this->upload->display_errors();
				}
			}
		} else {

			/*$this->FSistema_model->editarPessoalLider($id, $nome, $cpf_completo, $email, $telefone_completo, $igreja, $nascimento_completo, $estado, $cidade, $id_pastor, $id_coord, $id_sr, $id_se, $arquivo);*/
		}
	}

	// Fim Dados Pessoal

	/* FIM LÍDER */
}
