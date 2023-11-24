<?php

/**
 * 
 */

class FSistema_model extends CI_Model
{
	public function cadastrarUsuário($nome_usuario, $email, $cpf, $nivel)
	{
		$ativo = "0";

		$inserir['id_usuario'] = NULL;
		$inserir['nome'] = $nome_usuario;
		$inserir['email'] = $email;
		$inserir['cpf'] = $cpf;
		$inserir['nivel'] = $nivel;
		$inserir['ativo'] = $ativo;

		if ($this->db->insert('usuario', $inserir)) {
			return true;
		} else {
			return false;
		}
	}

	public function editarUsuário($id_usuario, $nome_usuario, $email, $cpf)
	{
		$ponto1 = $cpf[3];
		$ponto2 = $cpf[7];
		$ponto3 = $cpf[11];
		$cpf_completo = "";

		if ($ponto1 == "." && $ponto2 == "." && $ponto3 == "-") {
			$cpf_completo .= $cpf;
		} else {
			$cpf_completo .= $cpf[0] . $cpf[1] . $cpf[2] . "." . $cpf[3] . $cpf[4] . $cpf[5] . "." . $cpf[6] . $cpf[7] . $cpf[8] . "-" . $cpf[9] . $cpf[10];
		}

		$this->db->set('nome', $nome_usuario);
		$this->db->set('cpf', $cpf_completo);
		$this->db->set('email', $email);
		$this->db->where('id_usuario', $id_usuario);

		if ($this->db->update('usuario')) {
			return true;
		} else {
			return false;
		}
	}

	public function excluirUsuário($email, $cpf)
	{
		$this->db->where('cpf', $cpf);
		$this->db->where('email', $email);

		if ($this->db->delete('usuario')) {
			return true;
		} else {
			return false;
		}
	}

	public function reativarUsuário($nome_usuario, $email, $cpf, $nivel)
	{
		$ativo = "0";

		$ponto1 = $cpf[3];
		$ponto2 = $cpf[7];
		$ponto3 = $cpf[11];

		$cpf_completo = "";
		$nascimento_completo = "";

		if ($ponto1 == "." && $ponto2 == "." && $ponto3 == "-") {
			$cpf_completo .= $cpf;
		} else {
			$cpf_completo .= $cpf[0] . $cpf[1] . $cpf[2] . "." . $cpf[3] . $cpf[4] . $cpf[5] . "." . $cpf[6] . $cpf[7] . $cpf[8] . "-" . $cpf[9] . $cpf[10];
		}

		$inserir['id_usuario'] = NULL;
		$inserir['nome'] = $nome_usuario;
		$inserir['email'] = $email;
		$inserir['cpf'] = $cpf_completo;
		$inserir['nivel'] = $nivel;
		$inserir['ativo'] = $ativo;

		if ($this->db->insert('usuario', $inserir)) {
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
	public function cadastro_pg_pagina_inicial($idLider, $nome, $x)
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

		if ($x == 1) {
			$this->db->insert("pg_pais", $inserir);
		} else if ($x == 2) {
			$this->db->insert("pg_2", $inserir);
		}
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
			if ($this->db->insert("pg_pais", $inserir)) {
				return true;
			} else {
				return false;
			}
		} else if ($x == 2) {
			if ($this->db->insert("pg_2", $inserir)) {
				return true;
			} else {
				return false;
			}
		}
	}

	public function editarPG($id, $nomePg, $foto)
	{
		$this->db->set('nome_pg', $nomePg);
		$this->db->set('foto', $foto);
		$this->db->where('id_pg ', $id);

		if ($this->db->update('pg_pais')) {
			return true;
		} else {
			return false;
		}
	}

	public function editarData($id, $data1, $data2, $data3, $x)
	{
		$this->db->set('data_inicio', $data1);
		$this->db->set('data_previsao_termino', $data2);
		$this->db->set('data_semana', $data3);
		$this->db->where('id_pg ', $id);

		if ($x == 1) {
			if ($this->db->update('pg_pais')) {
				return true;
			} else {
				return false;
			}
		} else if ($x == 2) {
			if ($this->db->update('pg_2')) {
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

			if ($this->db->update('pg_pais')) {
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

			if ($this->db->update('pg_2')) {
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

		if ($this->db->insert('alcancado_pg', $inserir)) {

			if ($x == 1) {
				$this->db->set('ativo', $ativo);
				$this->db->where('id_pg', $id_pg);

				if ($this->db->update('pg_pais')) {
					$this->FAlerta_model->alerta_controle($id_responsavel, $id_pg, $motivo, $acao);
					$this->FAlerta_model->alerta_para_coordenador($id_responsavel, $id_lider, $id_pg, $motivo, $acao);
					return true;
				} else {
					return false;
				}
			} else if ($x == 2) {
				$this->db->set('ativo', $ativo);
				$this->db->where('id_pg', $id_pg);

				if ($this->db->update('pg_2')) {
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
	// Fim PG

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
	/*Colíder*/

	// Crianças
	public function cadastro_crianca($nome, $nascimento, $idLider, $id_pg, $obs, $opcao, $nomePai, $emailPai, $telefonePai, $x)
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

		if ($x == 1) {
			if ($this->db->insert("criancas", $inserir)) {
				return true;
			} else {
				return false;
			}
		} else if ($x == 2) {
			if ($this->db->insert("criancas_2", $inserir)) {
				return true;
			} else {
				return false;
			}
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

	public function editarAtivo($id_pg, $idlider, $x)
	{

		$this->db->set('ativo', "1");
		$this->db->where('id_pg', $id_pg);
		$this->db->where('id_lider', $idlider);

		if ($x == 1) {
			if ($this->db->update('pg_pais')) {
				return true;
			} else {
				return false;
			}
		} else if ($x == 2) {
			if ($this->db->update('pg_2')) {
				return true;
			} else {
				return false;
			}
		}
	}

	public function relatorio_encontro($id_lider, $id_pg, $qtd_crianca, $id_crianca, $versiculo, $presenca, $misterio, $devocional, $ano, $modulo, $licao, $data_aula, $nivel)
	{
		$data = $data_aula;

		$consulta = $this->FConsultas_model->consultarProgressoPG($id_pg, $modulo, $licao, $nivel);
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
}
