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

class Adm extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('America/Sao_Paulo');
		require_once 'import/sistema/fpdf/fpdf.php';
		define('PDF_PATH', 'import/sistema/temp/');
	}

	/* HOME PAGE */
	public function index()
	{
		$this->load->view('sistema/adm/index');
	}

	public function mostrar_devocionais()
	{

		$mostrar_todos_devocionais = $this->FConsultas_model->consultarTodosDevocionais();
		$array = array(
			'devocionais' => $mostrar_todos_devocionais,
		);
		$this->load->view('sistema/adm/devocionais/index', $array);
	}

	public function cadastrar_devocionais()
	{
		$this->load->view('sistema/adm/devocionais/cadastrar');
	}

	public function salvar_cadastro_devocionais()
	{
		$id_ano = $this->input->post('id_ano');
		$id_modulo = $this->input->post('id_modulo');
		$n_licao = $this->input->post('n_licao');
		$dia = $this->input->post('dia');
		$titulo = $this->input->post('titulo');
		$titulo_ingles = $this->input->post('titulo_ingles');
		$texto = $this->input->post('texto');
		$texto_ingles = $this->input->post('texto_ingles');
		$imagem_url = $this->input->post('imagem_url');
		$imagem_url_ingles = $this->input->post('imagem_url_ingles');
		$file = $this->input->post('file');
		$file_ingles = $this->input->post('file_ingles');

		$n1 = "";
		$n2 = "";

		switch ($id_modulo) {
			case 1:
				$n1 = '1 - trilha';
				$n2 = '01';
				break;
			case 2:
				$n1 = '2 - mergulho';
				$n2 = '02';
				break;
			case 3:
				$n1 = '3 - santuario';
				$n2 = '03';
				break;
			case 4:
				$n1 = '4 - arco';
				$n2 = '04';
				break;
			case 5:
				$n1 = '5 - estacao';
				$n2 = '05';
				break;
			case 6:
				$n1 = '6 - segredos';
				$n2 = '06';
				break;
			case 7:
				$n1 = '7 - sobreviventes';
				$n2 = '07';
				break;
			case 8:
				$n1 = '8 - explradores';
				$n2 = '08';
				break;
			case 9:
				$n1 = '9 - colheita';
				$n2 = '09';
				break;
			case 10:
				$n1 = '10 - evolucao';
				$n2 = '10';
				break;
			default:
				$n1 = '1 - trilha';
				$n2 = '01';
				break;
		}

		$assets = "import/sistema/devocionais/" . $n1 . "/" . $n2 . "/" . $file;

		$cadastro = $this->FSistema_model->cadastroDevocionais($id_ano, $id_modulo, $n_licao, $dia, $titulo, $titulo_ingles, $texto, $texto_ingles, $imagem_url, $imagem_url_ingles, $assets, $file_ingles);

		if ($cadastro) {
			echo '
				<script>
					alert("Sucesso!");
					window.location = "cadastrar";
				</script>
			';
		} else {
			echo '
				<script>
					alert("Ero!");
					window.location = "cadastrar";
				</script>
			';
		}
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
}
