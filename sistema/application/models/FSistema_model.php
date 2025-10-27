<?php

/**
 *
 */

class FSistema_model extends CI_Model
{
	public function formatar_telefone($telefone, $is_br)
	{
		$telefone_formatado = '';
		if ($telefone == '') {
		} else {
			$numeroLimpo = preg_replace('/\D/', '', $telefone);
			if ($is_br) {
				if ($numeroLimpo[0] == '5') {
					$telefone_formatado = $numeroLimpo;
				} else {
					$telefone_formatado = "55" . $numeroLimpo;
				}
			} else {
				$telefone_formatado = $numeroLimpo;
			}
		}

		return $telefone_formatado;
	}

	function gerarCodigo($length = 10)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[Rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	function gerarLink()
	{
		for ($i = true; $i == true; $i) {

			$codigo = $this->gerarCodigo();

			$consultarLink = $this->db->select("*")
				->from("link_cadastro")
				->where("codigo", $codigo)
				->get();
			$totalLink = $consultarLink->num_rows();
			if ($totalLink == 0) {
				return $codigo;
			} else {
				return true;
			}
		}
	}

	function check_codigo($codigo)
	{
		$consultarLink = $this->db->select("*")
			->from("link_cadastro")
			->where("codigo", $codigo)
			->get();
		$totalLink = $consultarLink->num_rows();
		if ($totalLink == 0) {
			return false;
		} else {
			return true;
		}
	}


	function infos_codigo($codigo)
	{
		$consultarLink = $this->db->select("*")
			->from("link_cadastro")
			->where("codigo", $codigo)
			->get();
		$link = $consultarLink->row_array();
		return $link;
	}

	public function cadastrarUsuário($nome_usuario, $email, $cpf, $nivel, $senha)
	{
		$ativo = "0";

		$inserir['id_usuario'] = NULL;
		$inserir['nome'] = $nome_usuario;
		$inserir['email'] = $email;
		$inserir['cpf'] = $cpf;
		$inserir['senha'] = $senha;
		$inserir['nivel'] = $nivel;
		$inserir['ativo'] = $ativo;

		if ($this->db->insert('usuario', $inserir)) {
			return true;
		} else {
			return false;
		}
	}

	public function editar_usuario($id_usuario, $nome_usuario, $email, $cpf, $senha)
	{
		$this->db->set('nome', $nome_usuario);
		$this->db->set('cpf', $cpf);
		$this->db->set('email', $email);
		$this->db->set('senha', $senha);
		$this->db->where('id_usuario', $id_usuario);

		if ($this->db->update('usuario')) {
			return true;
		} else {
			return false;
		}
	}

	/*public function excluirUsuário($email, $cpf)
	{
		$this->db->where('cpf', $cpf);
		$this->db->where('email', $email);

		if ($this->db->delete('usuario')) {
			return true;
		} else {
			return false;
		}
	}*/

	public function desativarUsuário($nome_usuario, $email, $cpf)
	{
		$ativo = "0";

		$user = $this->FConsultas_model->getUsuario($nome_usuario, $email, $cpf);
		$row = $user['row'];

		if ($row == 0) {
			return false;
		} else {
			$this->db->set('ativo', $ativo);
			$this->db->where('id_usuario ', $user['dados']['id_usuario']);

			if ($this->db->update('usuario')) {
				return true;
			} else {
				return false;
			}
		}
	}

	public function desativarLider($id_lider)
	{
		$ativo = "3";

		$this->db->set('confirmado', $ativo);
		$this->db->where('id_lider ', $id_lider);

		if ($this->db->update('lider')) {
			return true;
		} else {
			return false;
		}
	}

	public function ativarUsuário($nome_usuario, $email, $cpf)
	{
		$ativo = "1";

		$user = $this->FConsultas_model->getUsuario($nome_usuario, $email, $cpf);
		$row = $user['row'];

		if ($row == 0) {
			return false;
		} else {
			$this->db->set('ativo', $ativo);
			$this->db->where('id_usuario ', $user['dados']['id_usuario']);

			if ($this->db->update('usuario')) {
				return true;
			} else {
				return false;
			}
		}
	}

	public function ativarLider($id_lider)
	{
		$ativo = "2";

		$this->db->set('confirmado', $ativo);
		$this->db->where('id_lider ', $id_lider);

		if ($this->db->update('lider')) {
			return true;
		} else {
			return false;
		}
	}
	public function excluirLiderPermanentemente($id_lider, $id_responsavel)
	{
		$acao = "EX_CL_4";
		$motivo = "Excluiu seu Líder Permanentemente";

		date_default_timezone_set('America/Sao_Paulo');
		$data = date('d/m/Y');

		$dados_lider = $this->FConsultas_model->getInfoLiderId($id_lider);

		$consultar_pg_desativado = $this->db->query("SELECT * FROM alcancado_lider WHERE id_lider LIKE $id_lider");
		$row = $consultar_pg_desativado->num_rows();

		if ($row == 0) {
			//$inserir['id_exclusao'] = NULL;
			$inserir['id_lider'] = $id_lider;
			$inserir['nome_lider'] = $dados_lider['dados']['nome_lider'];
			$inserir['id_responsavel'] = $id_responsavel;
			$inserir['motivo'] = $motivo;
			$inserir['data_saida'] = $data;

			if ($this->db->insert('alcancado_lider', $inserir)) {
			}
		} else {
		}

		$this->db->where('id_lider', $id_lider);
		if ($this->db->delete('lider')) {
			$this->FAlerta_model->alerta_controle($id_responsavel, $id_lider, $motivo, $acao);
			return true;
		} else {
			return false;
		}
	}
	public function excluirUsuarioPermanentemente($nome_usuario, $email, $cpf)
	{
		$user = $this->FConsultas_model->getUsuario($nome_usuario, $email, $cpf);

		$this->db->where('id_usuario ', $user['dados']['id_usuario']);

		if ($this->db->delete('usuario')) {
			return true;
		} else {
			return false;
		}
	}

	// Pais
	public function cadastro_pais($nome, $cpf, $email, $telefone, $igreja, $nascimento, $pais, $estado, $cidade, $id_supervisor)
	{
		date_default_timezone_set('America/Sao_Paulo');
		$data = date('d/m/Y');

		$foto = "fotoU/geral.jpg";

		$inserir['nome'] = $nome;
		$inserir['cpf'] = $cpf;
		$inserir['email'] = $email;
		$inserir['telefone_whatsapp'] = $telefone;
		$inserir['igreja'] = $igreja;
		$inserir['nascimento'] = $nascimento;
		$inserir['pais'] = $pais;
		$inserir['estado'] = $estado;
		$inserir['cidade'] = $cidade;
		$inserir['id_supervisor'] = $id_supervisor;
		$inserir['foto'] = $foto;
		$inserir['foto_2'] = '';
		$inserir['confirmado'] = 2;
		$inserir['data'] = $data;
		if ($this->db->insert("pais", $inserir)) {
			return true;
		} else {
			return false;
		}
	}

	// PG
	public function cadastro_pg_pular($idLider, $nome, $x)
	{
		date_default_timezone_set('America/Sao_Paulo');
		$data = date('d/m/Y');

		$foto = "import/sistema/fotoPG/geral.jpg";

		$ano_pg = "1";
		$modulo = "1";
		$licao = "1";

		$ativo = "1";
		$bonus = "0";
		$autorizacao = "0";

		$inserir['nome_pg'] = $nome;
		$inserir['id_lider'] = $idLider;
		$inserir['autorizacao'] = $autorizacao;
		$inserir['ano'] = $ano_pg;
		$inserir['id_modulo'] = $modulo;
		$inserir['n_licao'] = $licao;
		$inserir['data_cadastro'] = $data;
		$inserir['data_inicio'] = '';
		$inserir['data_previsao_termino'] = '';
		$inserir['data_semana'] = '';
		$inserir['ano_devocional'] = $ano_pg;
		$inserir['modulo_devocional'] = $modulo;
		$inserir['licao_devocional'] = $licao;
		$inserir['ativo'] = $ativo;
		$inserir['foto'] = $foto;
		$inserir['bonus'] = $bonus;
		$this->db->insert("pg", $inserir);

		/*if ($x == 1) {
			$this->db->insert("pg_pais", $inserir);
		} else if ($x == 2) {
			$this->db->insert("pg_2", $inserir);
		}*/
	}

	public function enviarEmailSupervisor($emailSupervisor, $nomeSupervisor, $nome, $email, $telefone, $estado, $cidade)
	{

		$this->email->set_mailtype('html');
		$this->email->from("camp@campbrasil.com", 'CAMP Brasil');
		$this->email->subject("Novo Pai Cadastrado!");
		$this->email->to($emailSupervisor);

		$link = 'https://api.whatsapp.com/send?phone=' . $telefone . '&text=Ol%C3%A1';

		$dados = array(
			'nomeSupervisor' => $nomeSupervisor,
			'nome' => $nome,
			'email' => $email,
			'telefone' => $telefone,
			'estado' => $estado,
			'cidade' => $cidade,
			'link' => $link,
		);

		$page = $this->load->view('email/corpo-mensagem', $dados, true);

		$this->email->message($page);

		if ($this->email->send()) {
			return true;
		} else {
			return false;
		}
	}

	public function cadastro_pg($idLider, $nome, $data_inicio, $autorizacao, $x)
	{
		date_default_timezone_set('America/Sao_Paulo');
		$data = date('d/m/Y');
		$foto = "import/sistema/fotoPG/geral.jpg";

		$ano_pg = "1";
		$modulo = "1";
		$licao = "1";

		$ativo = "1";
		$bonus = "0";

		if ($data_inicio == '') {
			$data_fim = '';
		} else {
			$dia = $data_inicio[0] . $data_inicio[1];
			$mes = $data_inicio[3] . $data_inicio[4];
			$anoData = $data_inicio[6] . $data_inicio[7] . $data_inicio[8] . $data_inicio[9];
			$data_trocada = $mes . "/" . $dia . "/" . $anoData;
			$data_fim = date('d/m/Y', strtotime('+2 months', strtotime($data_trocada)));
		}

		$inserir['nome_pg'] = $nome;
		$inserir['id_lider'] = $idLider;
		$inserir['autorizacao'] = $autorizacao;
		$inserir['ano'] = $ano_pg;
		$inserir['id_modulo'] = $modulo;
		$inserir['n_licao'] = $licao;
		$inserir['data_cadastro'] = $data;
		$inserir['data_inicio'] = $data_inicio;
		$inserir['data_previsao_termino'] = $data_fim;
		$inserir['data_semana'] = $data_inicio;
		$inserir['ano_devocional'] = $ano_pg;
		$inserir['modulo_devocional'] = $modulo;
		$inserir['licao_devocional'] = $licao;
		$inserir['ativo'] = $ativo;
		$inserir['foto'] = $foto;
		$inserir['bonus'] = $bonus;

		if ($x == 1) {
			if ($this->db->insert("pg", $inserir)) {
				//if ($this->db->insert("pg_pais", $inserir)) {
				return true;
			} else {
				return false;
			}
		} else if ($x == 2) {
			if ($this->db->insert("pg", $inserir)) {
				//if ($this->db->insert("pg_2", $inserir)) {
				return true;
			} else {
				return false;
			}
		}
	}

	public function editarPG($id, $nomePg, $foto, $autorizacao, $x)
	{
		$this->db->set('nome_pg', $nomePg);
		$this->db->set('foto', $foto);
		$this->db->set('autorizacao', $autorizacao);
		$this->db->where('id_pg ', $id);

		if ($x == 1) {
			if ($this->db->update('pg')) {
				//if ($this->db->update('pg_pais')) {
				return true;
			} else {
				return false;
			}
		} else if ($x == 2) {
			if ($this->db->update('pg')) {
				//if ($this->db->update('pg_2')) {
				return true;
			} else {
				return false;
			}
		}
	}

	public function editarData($id, $data1, $data2, $data3, $x)
	{
		$this->db->set('data_inicio', $data1);
		$this->db->set('data_previsao_termino', $data2);
		$this->db->set('data_semana', $data3);
		$this->db->where('id_pg ', $id);

		if ($x == 1) {
			if ($this->db->update('pg')) {
				//if ($this->db->update('pg_pais')) {
				return true;
			} else {
				return false;
			}
		} else if ($x == 2) {
			if ($this->db->update('pg')) {
				//if ($this->db->update('pg_2')) {
				return true;
			} else {
				return false;
			}
		}
	}
	public function editarPGProgressoData($id, $ano, $modulo, $licao, $data, $x)
	{
		if ($x == 1) {
			$this->db->set('data_semana', $data);
			$this->db->set('ano_devocional', $ano);
			$this->db->set('modulo_devocional', $modulo);
			$this->db->set('licao_devocional', $licao);
			$this->db->where('id_pg ', $id);

			if ($this->db->update('pg')) {
				//if ($this->db->update('pg_pais')) {
				return true;
			} else {
				return false;
			}
		} else if ($x == 2) {
			$this->db->set('data_semana', $data);
			$this->db->set('ano_devocional', $ano);
			$this->db->set('modulo_devocional', $modulo);
			$this->db->set('licao_devocional', $licao);
			$this->db->where('id_pg ', $id);

			if ($this->db->update('pg')) {
				//if ($this->db->update('pg_2')) {
				return true;
			} else {
				return false;
			}
		}
	}

	public function excluirPG($id_pg, $nome_pg, $id_lider, $id_responsavel, $motivo, $x)
	{
		date_default_timezone_set('America/Sao_Paulo');
		$data = date('d/m/Y');

		$ativo = "0";
		$acao = "EX_CL_2";

		$inserir['id_exclusao'] = NULL;
		$inserir['id_pg'] = $id_pg;
		$inserir['nome_pg'] = $nome_pg;
		$inserir['id_lider'] = $id_lider;
		$inserir['id_responsavel'] = $id_responsavel;
		$inserir['motivo'] = $motivo;
		$inserir['data_saida'] = $data;

		if ($this->db3->insert('alcancado_pg', $inserir)) {

			if ($x == 1) {
				$this->db->set('ativo', $ativo);
				$this->db->where('id_pg', $id_pg);

				if ($this->db->update('pg')) {
					//if ($this->db->update('pg_pais')) {
					$this->FAlerta_model->alerta_controle($id_responsavel, $id_pg, $motivo, $acao);
					$this->FAlerta_model->alerta_para_coordenador($id_responsavel, $id_lider, $id_pg, $motivo, $acao);
					return true;
				} else {
					return false;
				}
			} else if ($x == 2) {
				$this->db->set('ativo', $ativo);
				$this->db->where('id_pg', $id_pg);

				if ($this->db->update('pg')) {
					//if ($this->db->update('pg_2')) {
					$this->FAlerta_model->alerta_controle($id_responsavel, $id_pg, $motivo, $acao);
					$this->FAlerta_model->alerta_para_coordenador($id_responsavel, $id_lider, $id_pg, $motivo, $acao);
					return true;
				} else {
					return false;
				}
			}
		} else {
			return false;
		}
	}

	public function reativarPg($id_pg, $id_responsavel, $nivel)
	{
		$ativo = "1";
		$acao = "RE_PG_1";
		$motivo = "Reativou seu PG";

		$this->db->set('ativo', $ativo);
		$this->db->where('id_pg', $id_pg);

		if ($nivel == 1) {
			if ($this->db->update('pg')) {
				$this->FSistema_model->excluirPgAlcancado($id_pg);
				$this->FAlerta_model->alerta_controle($id_responsavel, $id_pg, $motivo, $acao);
				return true;
			} else {
				return false;
			}
		} else if ($nivel == 2) {
			if ($this->db->update('pg')) {
				//if ($this->db->update('pg_2')) {
				$this->FSistema_model->excluirPgAlcancado($id_pg);
				$this->FAlerta_model->alerta_controle($id_responsavel, $id_pg, $motivo, $acao);
				return true;
			} else {
				return false;
			}
		}
	}

	public function excluirPgPermanentemente($id_pg, $id_lider, $id_responsavel, $nivel)
	{
		$ativo = "1";
		$acao = "EX_PG_1";
		$motivo = "Excluiu seu PG Permanentemente";

		date_default_timezone_set('America/Sao_Paulo');
		$data = date('d/m/Y');

		$dadosPG = $this->FConsultas_model->mostrarPGId($id_lider, $id_pg, 2);

		$consultar_pg_desativado = $this->db3->query("SELECT * FROM alcancado_pg WHERE id_pg LIKE $id_pg");
		$row = $consultar_pg_desativado->num_rows();

		if ($row == 0) {
			$inserir['id_exclusao'] = NULL;
			$inserir['id_pg'] = $id_pg;
			$inserir['nome_pg'] = $dadosPG['dados']['nome_pg'];
			$inserir['id_lider'] = $id_lider;
			$inserir['id_responsavel'] = $id_responsavel;
			$inserir['motivo'] = $motivo;
			$inserir['data_saida'] = $data;

			if ($this->db3->insert('alcancado_pg', $inserir)) {
			}
		} else {
		}

		$this->db->where('id_pg', $id_pg);

		if ($nivel == 1) {
			if ($this->db->delete('pg')) {
				//if ($this->db->delete('pg_pais')) {
				$this->FSistema_model->excluirProgresso($id_pg, $id_lider);
				$this->FAlerta_model->alerta_controle($id_responsavel, $id_pg, $motivo, $acao);
				return true;
			} else {
				return false;
			}
		} else if ($nivel == 2) {
			if ($this->db->delete('pg')) {
				//if ($this->db->delete('pg_2')) {
				$this->FSistema_model->excluirProgresso($id_pg, $id_lider);
				$this->FAlerta_model->alerta_controle($id_responsavel, $id_pg, $motivo, $acao);
				return true;
			} else {
				return false;
			}
		}
	}
	// Fim PG

	public function excluirProgresso($id_pg, $id_lider)
	{

		$this->db->where('id_pg', $id_pg);
		$this->db->where('id_lider', $id_lider);
		$this->db->delete('progresso_pg');
	}

	public function excluirProgressoCriancaId($id_crianca)
	{
		$this->db->where('id_crianca_presente', $id_crianca);
		$this->db->delete('progresso_pg');
	}


	// EDIÇÃO DE DADOS PESSOAIS PAIS
	public function editarPessoalPais($id, $nome, $cpf, $email, $telefone, $igreja, $nascimento, $estado, $cidade, $foto)
	{
		$this->db->set('nome', $nome);
		$this->db->set('cpf', $cpf);
		$this->db->set('email', $email);
		$this->db->set('telefone_whatsapp', $telefone);
		$this->db->set('igreja', $igreja);
		$this->db->set('nascimento', $nascimento);
		$this->db->set('estado', $estado);
		$this->db->set('cidade', $cidade);
		$this->db->set('foto', $foto);
		$this->db->where('id', $id);

		if ($this->db->update('pais')) {
			return true;
		} else {
			return false;
		}
	}
	// Fim EDIÇÃO DE DADOS PESSOAIS PAIS

	/*Colíder*/
	// CADASTROS
	public function cadastrarColider($id_lider, $nome_colider, $cpf, $email, $telefone, $nascimento)
	{
		date_default_timezone_set('America/Sao_Paulo');
		$data = date('d/m/Y');
		$ativo = "1";
		$foto = "fotoU/geral.jpg";

		$inserir['id_colider'] = NULL;
		$inserir['nome_colider'] = $nome_colider;
		$inserir['email'] = $email;
		$inserir['cpf'] = $cpf;
		$inserir['telefone_whatsapp'] = $telefone;
		$inserir['nascimento'] = $nascimento;
		$inserir['id_lider'] = $id_lider;
		$inserir['foto'] = $foto;
		$inserir['ativo'] = $ativo;
		$inserir['data'] = $data;

		if ($this->db->insert('colider', $inserir)) {
			return true;
		} else {
			return false;
		}
	}
	// Fim CADASTROS

	// EDIÇÃO
	public function editarColider($id, $nome, $cpf, $email, $telefone, $nascimento, $foto)
	{
		$this->db->set('nome_colider', $nome);
		$this->db->set('cpf', $cpf);
		$this->db->set('email', $email);
		$this->db->set('telefone_whatsapp', $telefone);
		$this->db->set('nascimento', $nascimento);
		$this->db->set('foto', $foto);
		$this->db->where('id_colider', $id);

		if ($this->db->update('colider')) {
			return true;
		} else {
			return false;
		}
	}
	// Fim EDIÇÃO

	// EXCLUSÃO
	public function excluirColider($id_colider, $nome_colider, $id_lider, $id_responsavel, $motivo)
	{
		date_default_timezone_set('America/Sao_Paulo');
		$data = date('d/m/Y');

		$ativo = "0";
		$acao = "EX_CL_1";

		$inserir['id_exclusao'] = NULL;
		$inserir['id_colider'] = $id_colider;
		$inserir['nome_colider'] = $nome_colider;
		$inserir['id_lider'] = $id_lider;
		$inserir['id_responsavel'] = $id_responsavel;
		$inserir['motivo'] = $motivo;
		$inserir['data_saida'] = $data;

		if ($this->db->insert('alcancado_colider', $inserir)) {

			$this->db->set('ativo', $ativo);
			$this->db->where('id_colider', $id_colider);

			if ($this->db->update('colider')) {
				//$this->FAlerta_model->alerta_controle($id_responsavel, $id_colider, $motivo, $acao);
				//$this->FAlerta_model->alerta_para_coordenador($id_responsavel, $id_colider, $motivo, $acao);
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}


	public function excluirColiderPermanentemente($id_colider, $id_lider, $id_responsavel)
	{
		$acao = "EX_CL_1";
		$motivo = "Excluiu seu Colider Permanentemente";

		date_default_timezone_set('America/Sao_Paulo');
		$data = date('d/m/Y');

		$dadosColider = $this->FConsultas_model->getNomeUserId($id_colider);

		$consultar_pg_desativado = $this->db3->query("SELECT * FROM alcancado_colider WHERE id_colider = '$id_colider'");
		$row = $consultar_pg_desativado->num_rows();

		if ($row == 0) {
			$inserir['id_exclusao'] = NULL;
			$inserir['id_colider'] = $id_colider;
			$inserir['nome_colider'] = $dadosColider['nome'];
			$inserir['id_lider'] = $id_lider;
			$inserir['id_responsavel'] = $id_responsavel;
			$inserir['motivo'] = $motivo;
			$inserir['data_saida'] = $data;

			if ($this->db3->insert('alcancado_colider', $inserir)) {
			}
		} else {
		}

		$this->db->where('id_colider', $id_colider);

		if ($this->db->delete('colider')) {
			$this->FAlerta_model->alerta_controle($id_responsavel, $id_colider, $motivo, $acao);
			return true;
		} else {
			return false;
		}
	}
	// Fim EXCLUSÂO

	// EXCLUSÃO ALCANÇADO
	public function excluirColiderAlcancado($id_colider)
	{
		$this->db->where('id_colider', $id_colider);

		if ($this->db->delete('alcancado_colider')) {
			return true;
		} else {
			return false;
		}
	}

	public function excluirPgAlcancado($id_pg)
	{
		$this->db3->where('id_pg', $id_pg);

		if ($this->db3->delete('alcancado_pg')) {
			return true;
		} else {
			return false;
		}
	}
	public function excluirCriancaAlcancado($id_crianca)
	{
		$this->db->where('id_crianca', $id_crianca);

		if ($this->db->delete('alcancado_crianca')) {
			return true;
		} else {
			return false;
		}
	}
	// Fim EXCLUSÂO ALCANÇADO

	// REATIVAR
	public function reativarColider($id_colider, $id_responsavel)
	{
		$ativo = "1";
		$acao = "RE_CL_1";
		$motivo = "Reativou seu colíder";

		$this->db->set('ativo', $ativo);
		$this->db->where('id_colider', $id_colider);

		if ($this->db->update('colider')) {
			$this->FSistema_model->excluirColiderAlcancado($id_colider);
			$this->FAlerta_model->alerta_controle($id_responsavel, $id_colider, $motivo, $acao);
			return true;
		} else {
			return false;
		}
	}
	// Fim REATIVAR

	/*LÍDER*/

	// Crianças
	public function cadastro_crianca($nome, $nascimento, $idLider, $id_pg, $obs, $opcao, $nomePai, $emailPai, $telefonePai)
	{
		date_default_timezone_set('America/Sao_Paulo');
		$data = date('d/m/Y');

		$ativo = "1";

		$inserir['nome_crianca'] = $nome;
		$inserir['nascimento'] = $nascimento;
		$inserir['lider'] = $idLider;
		$inserir['id_pg'] = $id_pg;
		$inserir['observacao'] = $obs;
		$inserir['cristao'] = $opcao;
		$inserir['nome_responsavel'] = $nomePai;
		$inserir['email_responsavel'] = $emailPai;
		$inserir['telefone_responsavel'] = $telefonePai;
		$inserir['data'] = $data;
		$inserir['ativo'] = $ativo;

		if ($this->db->insert("criancas", $inserir)) {
			return true;
		} else {
			return false;
		}
	}

	public function editaCrianca($idCrianca, $nome, $nascimento, $idLider, $id_pg, $obs, $opcao, $nome_responsavel, $email_responsavel, $telefone_responsavel, $x)
	{
		$this->db->set('nome_crianca', $nome);
		$this->db->set('nascimento', $nascimento);
		$this->db->set('lider', $idLider);
		$this->db->set('id_pg', $id_pg);
		$this->db->set('observacao', $obs);
		$this->db->set('cristao', $opcao);
		$this->db->set('nome_responsavel', $nome_responsavel);
		$this->db->set('email_responsavel', $email_responsavel);
		$this->db->set('telefone_responsavel', $telefone_responsavel);

		$this->db->where('id_crianca', $idCrianca);

		$this->db->error();

		if ($x == 1) {
			if ($this->db->update('criancas')) {
				return true;
			} else {
				return false;
			}
		} else if ($x == 2) {
			if ($this->db->update('criancas_2')) {
				return true;
			} else {
				return false;
			}
		}
	}

	public function editaCriancaResponsavel($idCrianca, $nomeResponsavel, $emailResponsavel, $telefoneResponsavel, $x)
	{
		$this->db->set('nome_responsavel', $nomeResponsavel);
		$this->db->set('email_responsavel', $emailResponsavel);
		$this->db->set('telefone_responsavel', $telefoneResponsavel);

		$this->db->where('id_crianca', $idCrianca);

		$this->db->error();

		if ($x == 1) {
			if ($this->db->update('criancas')) {
				return true;
			} else {
				return false;
			}
		} else if ($x == 2) {
			if ($this->db->update('criancas_2')) {
				return true;
			} else {
				return false;
			}
		}
	}

	public function excluirCrianca($id_crianca, $nome_crianca, $id_lider, $id_responsavel, $motivo, $x)
	{
		date_default_timezone_set('America/Sao_Paulo');
		$data = date('d/m/Y');

		$ativo = "0";
		$acao = "EX_CL_3";

		$inserir['id_exclusao'] = NULL;
		$inserir['id_crianca'] = $id_crianca;
		$inserir['nome_crianca'] = $nome_crianca;
		$inserir['id_lider'] = $id_lider;
		$inserir['id_responsavel'] = $id_responsavel;
		$inserir['motivo'] = $motivo;
		$inserir['data_saida'] = $data;

		if ($this->db->insert('alcancado_crianca', $inserir)) {

			$this->db->set('ativo', $ativo);
			$this->db->where('id_crianca', $id_crianca);

			if ($x == 1) {
				if ($this->db->update('criancas')) {
					$this->FAlerta_model->alerta_controle($id_responsavel, $id_crianca, $motivo, $acao);
					$this->FAlerta_model->alerta_para_coordenador($id_responsavel, $id_lider, $id_crianca, $motivo, $acao);
					return true;
				} else {
					return false;
				}
			} else if ($x == 2) {
				if ($this->db->update('criancas_2')) {
					$this->FAlerta_model->alerta_controle($id_responsavel, $id_crianca, $motivo, $acao);
					$this->FAlerta_model->alerta_para_coordenador($id_responsavel, $id_lider, $id_crianca, $motivo, $acao);
					return true;
				} else {
					return false;
				}
			}
		} else {
			return false;
		}
	}

	// REATIVAR
	public function reativarCrianca($id_crianca, $x)
	{
		$ativo = "1";

		$this->db->set('ativo', $ativo);
		$this->db->where('id_crianca', $id_crianca);

		if ($x == 1) {
			if ($this->db->update('criancas')) {
				$this->FSistema_model->excluirCriancaAlcancado($id_crianca);
				return true;
			} else {
				return false;
			}
		} else if ($x == 2) {
			if ($this->db->update('criancas_2')) {
				$this->FSistema_model->excluirCriancaAlcancado($id_crianca);
				return true;
			} else {
				return false;
			}
		}
	}
	// Fim REATIVAR

	public function excluirCriancaPermanentemente($id_crianca, $id_lider, $id_responsavel, $nivel)
	{
		$ativo = "1";
		$acao = "EX_CL_3";
		$motivo = "Excluiu seu PG Permanentemente";

		date_default_timezone_set('America/Sao_Paulo');
		$data = date('d/m/Y');

		$dadosPG = $this->FConsultas_model->getInfoCrianca($id_lider, $nivel);

		$consultar_pg_desativado = $this->db->query("SELECT * FROM alcancado_crianca WHERE id_crianca LIKE $id_crianca");
		$row = $consultar_pg_desativado->num_rows();

		if ($row == 0) {
			$inserir['id_exclusao'] = NULL;
			$inserir['id_crianca'] = $id_crianca;
			$inserir['nome_crianca'] = $dadosPG['dados']['nome_crianca'];
			$inserir['id_lider'] = $id_lider;
			$inserir['id_responsavel'] = $id_responsavel;
			$inserir['motivo'] = $motivo;
			$inserir['data_saida'] = $data;

			if ($this->db->insert('alcancado_crianca', $inserir)) {
			}
		} else {
		}

		$this->db->where('id_crianca', $id_crianca);

		if ($nivel == 1) {
			if ($this->db->delete('crianca')) {
				$this->FSistema_model->excluirProgressoCriancaId($id_crianca);
				$this->FAlerta_model->alerta_controle($id_responsavel, $id_crianca, $motivo, $acao);
				return true;
			} else {
				return false;
			}
		} else if ($nivel == 2) {
			if ($this->db->delete('criancas_2')) {
				$this->FSistema_model->excluirProgressoCriancaId($id_crianca);
				$this->FAlerta_model->alerta_controle($id_responsavel, $id_crianca, $motivo, $acao);
				return true;
			} else {
				return false;
			}
		}
	}

	public function editarAtivo($id_pg, $idlider, $x)
	{

		$this->db->set('ativo', "1");
		$this->db->where('id_pg', $id_pg);
		$this->db->where('id_lider', $idlider);

		if ($this->db->update('pg')) {
			return true;
		} else {
			return false;
		}
	}

	public function relatorio_encontro($id_lider, $id_pg, $qtd_crianca, $id_crianca, $versiculo, $presenca, $misterio, $devocional, $ano, $modulo, $licao, $data_aula, $nivel)
	{
		$data = $data_aula;

		$consulta = $this->FConsultas_model->consultarProgressoPG($id_pg, $id_lider, $modulo, $licao, $nivel);
		$resultados = $consulta['row'];

		$consulta_pg = $this->FConsultas_model->mostrarPGId($id_lider, $id_pg, $nivel);

		$dadosP = $consulta_pg['dados'];
		$modulo_atual_pg = $dadosP['id_modulo'];
		$licao_atual_pg = $dadosP['n_licao'];

		$data_previsao_termino = $dadosP['data_previsao_termino'];

		$valor_presenca = "";
		$valor_versiculo = "";
		$valor_misterio = "";
		$valor_devocional = "";

		if ($presenca == 0) {
			$valor_presenca .= 0;
			$valor_versiculo .= 0;
			$valor_misterio .= 0;
			$valor_devocional .= 0;
		} else {
			$valor_presenca .= $presenca;
			$valor_versiculo .= $versiculo;
			$valor_misterio .= $misterio;
			$valor_devocional .= $devocional;
		}

		$inserir['id_pg'] = $id_pg;
		$inserir['id_lider'] = $id_lider;
		$inserir['id_crianca_presente'] = $id_crianca;
		$inserir['presenca'] = $valor_presenca;
		$inserir['versiculo_memorizado'] = $valor_versiculo;
		$inserir['misterio_respondido'] = $valor_misterio;
		$inserir['devocional_respondido'] = $valor_devocional;
		$inserir['ano'] = $ano;
		$inserir['id_modulo'] = $modulo;
		$inserir['numero_licao'] = $licao;
		$inserir['data_aula'] = $data;

		$n_modulo = $modulo + 1;

		$consultaMO = $this->FConsultas_model->consultarModuloId($modulo);
		$nome_modulo = $consultaMO['nome_modulo'];

		$consultaMO_N = $this->FConsultas_model->consultarModuloId($n_modulo);
		$novo_modulo = $consultaMO_N['nome_modulo'];

		if ($nivel == 1) {
			$consultaLI = $this->db->query("SELECT * FROM pais WHERE id LIKE $id_lider");
			$rowli = $consultaLI->row_array();

			$id_coordenador = $rowli['id_supervisor'];
		} else if ($nivel == 2) {
			$consultaLI = $this->db->query("SELECT * FROM lider WHERE id_lider LIKE $id_lider");
			$rowli = $consultaLI->row_array();

			$id_coordenador = $rowli['id_coordenador'];
		}
		$base = "";

		switch ($nivel) {
			case 1:
				$tabela = "progresso_pg_pais";
				break;
			case 2:
				$tabela = "progresso_pg";
				break;
			default:
				$tabela = "progresso_pg";
				break;
		}

		if ($qtd_crianca == $resultados) {
			$base .= "false";
		} else {
			if ($this->db->insert($tabela, $inserir)) {

				$data_inicio = $dadosP['data_inicio'];

				if ($data_inicio) {
				} else {
					$dia = $data[0] . $data[1];
					$mes = $data[3] . $data[4];
					$ano = $data[6] . $data[7] . $data[8] . $data[9];
					$data_trocada = $mes . "/" . $dia . "/" . $ano;
					$data_fim = date('d/m/Y', strtotime('+2 months', strtotime($data_trocada)));

					$this->db->set('data_inicio', $data);
					$this->db->set('data_previsao_termino', $data_fim);
					$this->db->set('data_semana', $data);
					$this->db->where('id_pg', $id_pg);

					if ($nivel == 1) {
						$this->db->set('data_inicio', $data);
						$this->db->set('data_previsao_termino', $data_fim);
						$this->db->set('data_semana', $data);
						$this->db->where('id_pg', $id_pg);
						$this->db->update('pg_pais');
					} else if ($nivel == 2) {
						$this->db->set('data_inicio', $data);
						$this->db->set('data_previsao_termino', $data_fim);
						$this->db->set('data_semana', $data);
						$this->db->where('id_pg', $id_pg);
						$this->db->update('pg_2');
					}
				}

				if ($licao == $consultaMO['n_licao']) {

					$data = date("d/m/Y");

					$licao_nova_modulo = "1";

					$licao_nova = "";

					if ($modulo < $modulo_atual_pg) {
						$licao_nova .= $licao_atual_pg;
					} else {
						$licao_nova .= $licao + 1;
					}

					$anoNovo = ($n_modulo == 11 ? 3 : ($n_modulo == 6 ? 2 : 1));

					$ativo = strtotime($data_previsao_termino) >= strtotime($data) ? 1 : 0;

					if ($nivel == 1) {

						$this->db->set('ano', $anoNovo);
						$this->db->set('ano_devocional', $anoNovo);
						$this->db->set('id_modulo', $n_modulo);
						$this->db->set('modulo_devocional', $n_modulo);
						$this->db->set('n_licao', $licao_nova_modulo);
						$this->db->set('licao_devocional', $licao_nova_modulo);
						$this->db->set('ativo', $ativo);
						$this->db->set('data_semana', $data);
						$this->db->where('id_pg', $id_pg);

						if ($this->db->update('pg_pais')) {
							$acao = "MUDANCA_DE_MODULO";
							$assunto = " mudou de módulo, módulo " . $nome_modulo . " para " . $novo_modulo . " autorize o novo módulo";

							$this->FAlerta_model->alerta_controle($id_lider, $id_lider, $assunto, $acao);
							$this->FAlerta_model->alerta_para_coordenador($id_coordenador, $id_lider, $id_crianca, $assunto, $acao);

							$base .= "fim_modulo?id_lider=$id_lider&id_pg=$id_pg";
						}
					} else if ($nivel == 2) {

						$this->db->set('ano', $anoNovo);
						$this->db->set('ano_devocional', $anoNovo);
						$this->db->set('id_modulo', $n_modulo);
						$this->db->set('modulo_devocional', $n_modulo);
						$this->db->set('n_licao', $licao_nova_modulo);
						$this->db->set('licao_devocional', $licao_nova_modulo);
						$this->db->set('ativo', $ativo);
						$this->db->set('data_semana', $data);
						$this->db->where('id_pg', $id_pg);

						if ($this->db->update('pg_2')) {
							$acao = "MUDANCA_DE_MODULO";
							$assunto = " mudou de módulo, módulo " . $nome_modulo . " para " . $novo_modulo . " autorize o novo módulo";

							$this->FAlerta_model->alerta_controle($id_lider, $id_lider, $assunto, $acao);
							$this->FAlerta_model->alerta_para_coordenador($id_coordenador, $id_lider, $id_crianca, $assunto, $acao);

							$base .= "fim_modulo?id_lider=$id_lider&id_pg=$id_pg";
						}
					}
				} else {

					$licao_nova = "";

					if ($modulo < $modulo_atual_pg) {
						$licao_nova .= $licao_atual_pg;
					} else {
						$licao_nova .= $licao + 1;
					}

					if ($licao_nova == $dadosP['n_licao']) {
					} else {

						$data_inicio = $dadosP['data_inicio'];

						if ($nivel == 1) {
							$this->db->set('n_licao', $licao_nova);
							$this->db->set('licao_devocional', $licao_nova);
							$this->db->set('data_semana', $data);
							$this->db->where('id_pg', $id_pg);

							if ($this->db->update('pg_pais')) {
								$base .= "pg";
							}
						} else if ($nivel == 2) {
							$this->db->set('n_licao', $licao_nova);
							$this->db->set('licao_devocional', $licao_nova);
							$this->db->set('data_semana', $data);
							$this->db->where('id_pg', $id_pg);

							if ($this->db->update('pg_2')) {
								$base .= "pg";
							}
						}
					}
				}
			} else {
				$base .= "false";
			}
		}

		return $base;
	}
	// Fim Crianças

	public function controlerDevocionais($idLider, $idPG, $ano, $modulo, $licao, $dia, $sucesso)
	{
		date_default_timezone_set('America/Sao_Paulo');
		$data = date('d/m/Y');

		$inserir['id'] = NULL;
		$inserir['idLider'] = $idLider;
		$inserir['idPG'] = $idPG;
		$inserir['anoController'] = $ano;
		$inserir['moduloController'] = $modulo;
		$inserir['licaoController'] = $licao;
		$inserir['dia'] = $dia;
		$inserir['sucesso'] = $sucesso;
		$inserir['data'] = $data;

		if ($this->db->insert('controle_envio_email_devocional', $inserir)) {
			return true;
		} else {
			return false;
		}
	}

	public function aceitarTermos($idUsuario, $confirmacao)
	{
		date_default_timezone_set('America/Sao_Paulo');
		$data = date('d/m/Y');
		$hora = date('h:i');

		$inserir['id_termo'] = NULL;
		$inserir['id_usuario'] = $idUsuario;
		$inserir['confirmacao'] = $confirmacao;
		$inserir['data'] = $data;
		$inserir['hora'] = $hora;

		if ($this->db->insert('termos', $inserir)) {
			return true;
		} else {
			return false;
		}
	}

	public function cadastroDevocionais($id_ano, $id_modulo, $n_licao, $dia, $titulo, $titulo_ingles, $texto, $texto_ingles, $imagem_url, $imagem_url_ingles, $file, $file_ingles)
	{
		$inserir['id '] = NULL;
		$inserir['id_ano'] = $id_ano;
		$inserir['id_modulo'] = $id_modulo;
		$inserir['n_licao'] = $n_licao;
		$inserir['titulo'] = $titulo;
		$inserir['titulo_ingles'] = $titulo_ingles;
		$inserir['dia'] = $dia;
		$inserir['texto'] = $texto;
		$inserir['texto_ingles'] = $texto_ingles;
		$inserir['imagem'] = $imagem_url;
		$inserir['imagem_ingles'] = $imagem_url_ingles;
		$inserir['file'] = $file;
		$inserir['file_ingles'] = $file_ingles;

		if ($this->db->insert('semanarios', $inserir)) {
			return true;
		} else {
			return false;
		}
	}

	// EDIÇÃO DE DADOS PESSOAIS LÍDER
	public function editarPessoalLider($id, $nome, $cpf, $email, $telefone, $igreja, $nascimento, $estado, $cidade, $id_coord, $id_sl, $id_sr, $foto)
	{
		$this->db->set('nome_lider', $nome);
		$this->db->set('cpf', $cpf);
		$this->db->set('email', $email);
		$this->db->set('telefone_whatsapp', $telefone);
		$this->db->set('igreja', $igreja);
		$this->db->set('nascimento', $nascimento);
		$this->db->set('estado', $estado);
		$this->db->set('cidade', $cidade);
		$this->db->set('id_coordenador', $id_coord);
		$this->db->set('id_supervisorR', $id_sl);
		$this->db->set('id_supervisorE', $id_sr);
		$this->db->set('foto', $foto);
		$this->db->where('id_lider', $id);

		if ($this->db->update('lider')) {
			return true;
		} else {
			return false;
		}
	}
	// Fim EDIÇÃO DE DADOS PESSOAIS LÍDER

	/*COORDENADOR*/
	public function cadastro_coordenador($nome, $cpf, $email, $telefone, $nascimento, $pais, $estado, $cidade, $id_slocal, $id_sregional)
	{
		date_default_timezone_set('America/Sao_Paulo');
		$data = date('d/m/Y'); // tirar
		$data_2 = date('Y-m-d');

		$foto = "fotoU/geral.jpg";

		$inserir['nome_coordenador'] = $nome;
		$inserir['cpf'] = $cpf;
		$inserir['email'] = $email;
		$inserir['telefone_whatsapp'] = $telefone;
		$inserir['nascimento'] = $nascimento;
		$inserir['pais'] = $pais;
		$inserir['estado'] = $estado;
		$inserir['cidade'] = $cidade;
		$inserir['id_supervisorR'] = $id_slocal;
		$inserir['id_supervisorE'] = $id_sregional;
		$inserir['foto'] = $foto;
		$inserir['ativo'] = 1;
		$inserir['data_cadastro'] = $data_2;

		if ($this->db->insert("coordenador", $inserir)) {
			return true;
		} else {
			return false;
		}
	}

	public function desativar_coordenador($id_coordenador)
	{
		$ativo = "0";

		$this->db->set('ativo', $ativo);
		$this->db->where('id_coordenador ', $id_coordenador);

		if ($this->db->update('coordenador')) {
			return true;
		} else {
			return false;
		}
	}
	public function ativar_coordenador($id_coordenador)
	{
		$ativo = "1";

		$this->db->set('ativo', $ativo);
		$this->db->where('id_coordenador ', $id_coordenador);

		if ($this->db->update('coordenador')) {
			return true;
		} else {
			return false;
		}
	}
	public function excluirCoordenadorPermanentemente($id_coordenador, $id_responsavel)
	{
		$motivo = "Excluiu seu Coordenador Permanentemente";
		$acao = "EX_COORD_1";

		date_default_timezone_set('America/Sao_Paulo');
		$data = date('d/m/Y');

		$dados_lider = $this->FConsultas_model->getInfoCoordenadorId($id_coordenador);

		$consultar_pg_desativado = $this->db->query("SELECT * FROM alcancado_coordenador WHERE id_pastor LIKE '$id_coordenador'");
		$row = $consultar_pg_desativado->num_rows();

		if ($row == 0) {
			//$inserir['id_exclusao'] = NULL;
			$inserir['id_pastor'] = $id_coordenador;
			$inserir['nome_coordenador'] = $dados_lider['dados']['nome_coordenador'];
			$inserir['id_responsavel'] = $id_responsavel;
			$inserir['motivo'] = $motivo;
			$inserir['data_saida'] = $data;

			if ($this->db->insert('alcancado_coordenador', $inserir)) {
			}
		} else {
		}

		$this->db->where('id_coordenador', $id_coordenador);
		if ($this->db->delete('coordenador')) {
			$this->FAlerta_model->alerta_controle($id_responsavel, $id_coordenador, $motivo, $acao);
			return true;
		} else {
			return false;
		}
	}

	public function editar_lider_exclusao_coord($id_lider, $id_coordenador, $id_responsavel)
	{
		$acao = "EX_CL_1";
		$motivo = "Excluiu seu coordenador ($id_coordenador) permanentemente, e seu líder ($id_lider) foi atualizado para o coordenador padrão";

		$this->db->set('id_coordenador', 3000);
		$this->db->where('id_lider', $id_lider);

		if ($this->db->update('lider')) {
			$this->FAlerta_model->alerta_controle($id_responsavel, $id_lider, $motivo, $acao);
			return true;
		} else {
			return false;
		}
	}

	// SREGIONAL
	public function cadastro_sregional($nome, $cpf, $email, $telefone, $nascimento, $pais, $estado)
	{
		date_default_timezone_set('America/Sao_Paulo');
		$data = date('Y-m-d');

		$foto = "fotoU/geral.jpg";

		$inserir['nome_supervisorE'] = $nome;
		$inserir['cpf'] = $cpf;
		$inserir['email'] = $email;
		$inserir['telefone_whatsapp'] = $telefone;
		$inserir['nascimento'] = $nascimento;
		$inserir['estado'] = $estado;
		$inserir['pais'] = $pais;
		$inserir['foto'] = $foto;
		$inserir['ativo'] = 1;
		$inserir['data_cadastro'] = $data;

		if ($this->db->insert("supervisore", $inserir)) {
			return true;
		} else {
			return false;
		}
	}

	public function editarSRegional($id, $nome, $cpf, $email, $telefone, $nascimento, $pais, $estado, $foto)
	{
		$this->db->set('nome_supervisorE', $nome);
		$this->db->set('cpf', $cpf);
		$this->db->set('email', $email);
		$this->db->set('telefone_whatsapp', $telefone);
		$this->db->set('nascimento', $nascimento);
		$this->db->set('estado', $estado);
		$this->db->set('pais', $pais);
		$this->db->set('foto', $foto);
		$this->db->where('id_supervisorEs', $id);

		if ($this->db->update('supervisore')) {
			return true;
		} else {
			return false;
		}
	}

	public function desativar_sregional($id_sregional)
	{
		$ativo = "0";

		$this->db->set('ativo', $ativo);
		$this->db->where('id_supervisorEs', $id_sregional);

		if ($this->db->update('supervisore')) {
			return true;
		} else {
			return false;
		}
	}
	public function ativar_sregional($id_sregional)
	{
		$ativo = "1";

		$this->db->set('ativo', $ativo);
		$this->db->where('id_supervisorEs', $id_sregional);

		if ($this->db->update('supervisore')) {
			return true;
		} else {
			return false;
		}
	}

	public function excluirSRegionalPermanentemente($id_sregional, $id_responsavel)
	{
		$motivo = "Excluiu seu Supervisor Regional Permanentemente";
		$acao = "EX_SREGIONAL_DIRECAO";

		date_default_timezone_set('America/Sao_Paulo');
		$data = date('d/m/Y');

		$dados_lider = $this->FConsultas_model->getInfoSRegionalId($id_sregional);

		$consultar_sregional_desativado = $this->db->query("SELECT * FROM alcancado_surpe WHERE id_supervisorE LIKE '$id_sregional'");
		$row = $consultar_sregional_desativado->num_rows();

		if ($row == 0) {
			//$inserir['id_exclusao'] = NULL;
			$inserir['id_supervisorE'] = $id_sregional;
			$inserir['nome_supervisorE'] = $dados_lider['dados']['nome_supervisorE'];
			$inserir['id_responsavel'] = $id_responsavel;
			$inserir['motivo'] = $motivo;
			$inserir['data_saida'] = $data;

			if ($this->db->insert('alcancado_surpe', $inserir)) {
			}
		} else {
		}

		$this->db->where('id_supervisorEs', $id_sregional);
		if ($this->db->delete('supervisore')) {
			$this->FAlerta_model->alerta_controle($id_responsavel, $id_sregional, $motivo, $acao);
			return true;
		} else {
			return false;
		}
	}

	public function editar_lider_exclusao_sregional($id_lider, $id_sregional, $id_responsavel)
	{
		$acao = "EX_SREGIONAL_DIRECAO";
		$motivo = "Excluiu o supervisor regional ($id_sregional) permanentemente, e seus líderes ($id_lider) foram atualizados para o supervisor padrão";

		$this->db->set('id_supervisorE', 0);
		$this->db->where('id_lider', $id_lider);

		if ($this->db->update('lider')) {
			$this->FAlerta_model->alerta_controle($id_responsavel, $id_lider, $motivo, $acao);
			return true;
		} else {
			return false;
		}
	}
	public function editar_coordenador_exclusao_sregional($id_coordenador, $id_sregional, $id_responsavel)
	{
		$acao = "EX_SREGIONAL_DIRECAO";
		$motivo = "Excluiu o supervisor regional ($id_sregional) permanentemente, e seus coordenadores ($id_coordenador) foram atualizados para o supervisor padrão";

		$this->db->set('id_supervisorE', 0);
		$this->db->where('id_coordenador', $id_coordenador);

		if ($this->db->update('coordenador')) {
			$this->FAlerta_model->alerta_controle($id_responsavel, $id_coordenador, $motivo, $acao);
			return true;
		} else {
			return false;
		}
	}
	public function editar_slocal_exclusao_sregional($id_slocal, $id_sregional, $id_responsavel)
	{
		$acao = "EX_SREGIONAL_DIRECAO";
		$motivo = "Excluiu o supervisor regional ($id_sregional) permanentemente, e seus supervisores locais ($id_slocal) foram atualizados para o supervisor padrão";

		$this->db->set('id_supervisorE', 0);
		$this->db->where('id_supervisorR', $id_slocal);

		if ($this->db->update('supervisorr')) {
			$this->FAlerta_model->alerta_controle($id_responsavel, $id_slocal, $motivo, $acao);
			return true;
		} else {
			return false;
		}
	}

	// slocal
	public function cadastro_slocal($nome, $cpf, $email, $telefone, $nascimento, $pais, $estado, $cidade, $id_sregional)
	{
		date_default_timezone_set('America/Sao_Paulo');
		$data = date('Y-m-d');

		$foto = "fotoU/geral.jpg";

		$inserir['nome_supervisorR'] = $nome;
		$inserir['cpf'] = $cpf;
		$inserir['email'] = $email;
		$inserir['telefone_whatsapp'] = $telefone;
		$inserir['nascimento'] = $nascimento;
		$inserir['pais'] = $pais;
		$inserir['estado'] = $estado;
		$inserir['cidade'] = $cidade;
		$inserir['id_supervisorE'] = $id_sregional;
		$inserir['foto'] = $foto;
		$inserir['ativo'] = 1;
		$inserir['data_cadastro'] = $data;

		if ($this->db->insert("supervisorr", $inserir)) {
			return true;
		} else {
			return false;
		}
	}

	public function editarSLocal($id, $nome, $cpf, $email, $telefone, $nascimento, $pais, $estado, $cidade, $id_sregional, $foto)
	{
		$this->db->set('nome_supervisorR', $nome);
		$this->db->set('cpf', $cpf);
		$this->db->set('email', $email);
		$this->db->set('telefone_whatsapp', $telefone);
		$this->db->set('nascimento', $nascimento);
		$this->db->set('pais', $pais);
		$this->db->set('estado', $estado);
		$this->db->set('cidade', $cidade);
		$this->db->set('id_supervisorE', $id_sregional);
		$this->db->set('foto', $foto);
		$this->db->where('id_supervisorR', $id);

		if ($this->db->update('supervisorr')) {
			return true;
		} else {
			return false;
		}
	}

	public function desativar_slocal($id_slocal)
	{
		$ativo = "0";

		$this->db->set('ativo', $ativo);
		$this->db->where('id_supervisorR', $id_slocal);

		if ($this->db->update('supervisorr')) {
			return true;
		} else {
			return false;
		}
	}
	public function ativar_slocal($id_slocal)
	{
		$ativo = "1";

		$this->db->set('ativo', $ativo);
		$this->db->where('id_supervisorR', $id_slocal);

		if ($this->db->update('supervisorr')) {
			return true;
		} else {
			return false;
		}
	}

	public function excluirSLocalPermanentemente($id_slocal, $id_responsavel)
	{
		$motivo = "Excluiu seu Supervisor Local Permanentemente";
		$acao = "EX_SLOCAL_DIRECAO";

		date_default_timezone_set('America/Sao_Paulo');
		$data = date('d/m/Y');

		$dados_slocal = $this->FConsultas_model->getInfoSLocalId($id_slocal);

		$consultar_sregional_desativado = $this->db->query("SELECT * FROM alcancado_surpe WHERE id_supervisorE LIKE '$id_slocal'");
		$row = $consultar_sregional_desativado->num_rows();

		if ($row == 0) {
			//$inserir['id_exclusao'] = NULL;
			$inserir['id_supervisorR'] = $id_slocal;
			$inserir['nome_supervisorR'] = $dados_slocal['dados']['nome_supervisorR'];
			$inserir['id_responsavel'] = $id_responsavel;
			$inserir['motivo'] = $motivo;
			$inserir['data_saida'] = $data;

			if ($this->db->insert('alcancado_surpr', $inserir)) {
			}
		} else {
		}

		$this->db->where('id_supervisorR', $id_slocal);
		if ($this->db->delete('supervisorr')) {
			$this->FAlerta_model->alerta_controle($id_responsavel, $id_slocal, $motivo, $acao);
			return true;
		} else {
			return false;
		}
	}
	public function editar_lider_exclusao_slocal($id_lider, $id_slocal, $id_responsavel)
	{
		$acao = "EX_SLOCAL_DIRECAO";
		$motivo = "Excluiu o supervisor local ($id_slocal) permanentemente, e seus líderes ($id_lider) foram atualizados para o supervisor padrão";

		$this->db->set('id_supervisorR', 0);
		$this->db->where('id_lider', $id_lider);

		if ($this->db->update('lider')) {
			$this->FAlerta_model->alerta_controle($id_responsavel, $id_lider, $motivo, $acao);
			return true;
		} else {
			return false;
		}
	}
	public function editar_coordenador_exclusao_slocal($id_coordenador, $id_slocal, $id_responsavel)
	{
		$acao = "EX_SLOCAL_DIRECAO";
		$motivo = "Excluiu o supervisor local ($id_slocal) permanentemente, e seus coordenadores ($id_coordenador) foram atualizados para o supervisor padrão";

		$this->db->set('id_supervisorR', 0);
		$this->db->where('id_coordenador', $id_coordenador);

		if ($this->db->update('coordenador')) {
			$this->FAlerta_model->alerta_controle($id_responsavel, $id_coordenador, $motivo, $acao);
			return true;
		} else {
			return false;
		}
	}

	public function retornando_so_id($chave, $lista)
	{
		$lista_de_id = [];
		foreach ($lista as $key => $dados) {
			$id = $dados[$chave];
			array_push($lista_de_id, $id);
		}

		return $lista_de_id;
	}

	public function format_dates($opc1, $opc2, $dataInicio, $dataFim)
	{
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

		return $datas;
	}
}
