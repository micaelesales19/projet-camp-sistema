<?php

/**
 *
 */
class Criancas extends CI_Model
{

    public function query($dados, $opc)
    {
        if ($opc == 'query_id_crianca') { // ok
            $id_crianca = $dados[0];
            $consultar_criancas = $this->db->query("SELECT * FROM criancas WHERE id_crianca LIKE '$id_crianca'");
            $row = $consultar_criancas->num_rows();
            $dados_consulta_criancas = $consultar_criancas->row_array();

            $dados = array(
                'row' => $row,
                'dados' => $dados_consulta_criancas,
            );
        } else if ($opc == 'query_id_lider') { // ok
            $id_usuario = $dados[0];
            $consultar_criancas = $this->db->query("SELECT * FROM criancas WHERE lider LIKE '$id_usuario'");
            $row = $consultar_criancas->num_rows();
            $dados_consulta_criancas = $consultar_criancas->result_array();

            $dados = array(
                'row' => $row,
                'dados' => $dados_consulta_criancas,
            );
        } else if ($opc == 'query_id_lider_ativo') { // ok
            $id_usuario = $dados[0];
            $ativo = $dados[1];
            $consultar_criancas = $this->db->query("SELECT * FROM criancas WHERE lider LIKE '$id_usuario' AND ativo = $ativo");
            $row = $consultar_criancas->num_rows();
            $dados_consulta_criancas = $consultar_criancas->result_array();

            $dados = array(
                'row' => $row,
                'dados' => $dados_consulta_criancas,
            );
        } else if ($opc == 'query_id_lider_id_pg_geral_order_by_nome_crianca') { // ok
            $id_usuario = $dados[0];
            $idPG = $dados[1];
            $order_by = $dados[2];
            $consultar_criancas = $this->db->query("SELECT * FROM criancas WHERE lider LIKE $id_usuario AND id_pg = $idPG ORDER BY nome_crianca $order_by");
            $row = $consultar_criancas->num_rows();
            $dados_consulta_criancas = $consultar_criancas->result_array();

            $dados = array(
                'row' => $row,
                'dados' => $dados_consulta_criancas,
            );
        } else  if ($opc == 'query_id_lider_id_pg_ativo_order_by_nome_crianca') { // ok
            $id_usuario = $dados[0];
            $idPG = $dados[1];
            $ativo = $dados[2];
            $order_by = $dados[3];
            $consultar_criancas = $this->db->query("SELECT * FROM criancas WHERE lider LIKE $id_usuario AND id_pg = $idPG AND ativo = $ativo ORDER BY nome_crianca $order_by");
            $row = $consultar_criancas->num_rows();
            $dados_consulta_criancas = $consultar_criancas->result_array();

            $dados = array(
                'row' => $row,
                'dados' => $dados_consulta_criancas,
            );
        } else if ($opc == 'query_id_lider_ativo_order_by_nome_crianca') { // ok
            $id_usuario = $dados[0];
            $ativo = $dados[1];
            $order_by = $dados[2];

            $consultar_criancas = $this->db->query("SELECT * FROM criancas WHERE lider LIKE $id_usuario AND ativo = $ativo ORDER BY nome_crianca $order_by");
            $row = $consultar_criancas->num_rows();
            $dados_consulta_criancas = $consultar_criancas->result_array();

            $dados = array(
                'row' => $row,
                'dados' => $dados_consulta_criancas,
            );
        } else if ($opc == 'query_id_lider_id_pg_id_crianca_ativo') { // ok
            $id_usuario = $dados[0];
            $idPG = $dados[1];
            $id_crianca = $dados[2];
            $ativo = $dados[3];

            $consultar_criancas = $this->db->query("SELECT * FROM criancas WHERE lider LIKE $id_usuario AND id_pg = $idPG AND ativo = $ativo AND id_crianca = $id_crianca");
            $row = $consultar_criancas->num_rows();
            $dados_consulta_criancas = $consultar_criancas->row_array();

            $dados = array(
                'row' => $row,
                'dados' => $dados_consulta_criancas,
            );
        }
        return $dados;
    }

    public function check_criancas_cadastrada($opc, $dados)
    {
        if ($opc == 'check_criancas_id_lider_id_pg_nome_crianca_nascimento_obs_responsavel_cristao') {
            $id_lider = $dados[0];
            $id_pg = $dados[1];
            $nome_crianca = $dados[2];
            $nascimento = $dados[3];
            $obs = $dados[4];
            $responsavel = $dados[5];
            $cristao = $dados[6];

            $consultar_criancas = $this->db->query("SELECT * FROM criancas WHERE lider LIKE $id_lider AND id_pg = $id_pg AND nome_crianca = '$nome_crianca' AND nascimento = '$nascimento' AND cristao = $cristao AND observacao = '$obs' AND nome_responsavel = '$responsavel'");
            $row = $consultar_criancas->num_rows();

            if ($row == 0) {
                return true;
            } else {
                return false;
            }
        } else if ($opc == 'check_criancas_id_crianca') {
            $id_crianca  = $dados[0];

            $consultar_criancas = $this->db->query("SELECT * FROM criancas WHERE id_crianca  = '$id_crianca'");
            $row = $consultar_criancas->num_rows();

            if ($row == 0) {
                return true;
            } else {
                return false;
            }
        } else if ($opc == 'check_criancas_id_lider') {
            $id_lider  = $dados[0];

            $consultar_criancas = $this->db->query("SELECT * FROM criancas WHERE lider  = '$id_lider'");
            $row = $consultar_criancas->num_rows();

            if ($row == 0) {
                return true;
            } else {
                return false;
            }
        }
    }

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

    public function cadastro_crianca_id($id, $nome, $nascimento, $idLider, $id_pg, $obs, $opcao, $nomePai, $emailPai, $telefonePai)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $data = date('d/m/Y');

        $ativo = "1";

        $inserir['id_crianca '] = $id;
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

    public function edita_crianca($idCrianca, $nome, $nascimento, $idLider, $id_pg, $obs, $opcao, $nome_responsavel, $email_responsavel, $telefone_responsavel)
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

        if ($this->db->update('criancas')) {
            return true;
        } else {
            return false;
        }
    }

    public function editar_nome_responsavel_crianca($idCrianca, $nomeResponsavel, $emailResponsavel, $telefoneResponsavel)
    {
        $this->db->set('nome_responsavel', $nomeResponsavel);
        $this->db->set('email_responsavel', $emailResponsavel);
        $this->db->set('telefone_responsavel', $telefoneResponsavel);

        $this->db->where('id_crianca', $idCrianca);

        $this->db->error();

        if ($this->db->update('criancas')) {
            return true;
        } else {
            return false;
        }
    }

    public function editar_liderenca_crianca($id_pg, $id_lider_antigo, $id_lider_novo)
    {
        $this->db->set('lider', $id_lider_novo);
        $this->db->where('lider', $id_lider_antigo);
        $this->db->where('id_pg', $id_pg);
        $this->db->update('criancas');
    }

    public function excluir_crianca($id_crianca, $id_lider, $id_responsavel, $motivo)
    {
        date_default_timezone_set('America/Sao_Paulo');

        $acao = "EX_CRIANCAS_LIDERES";

        $this->db->set('ativo', 0);
        $this->db->where('id_crianca', $id_crianca);

        if ($this->db->update('criancas')) {
            $this->FAlerta_model->alerta_controle($id_responsavel, $id_crianca, $motivo, $acao);
            $this->FAlerta_model->alerta_para_coordenador($id_responsavel, $id_lider, $id_crianca, $motivo, $acao);
            return true;
        } else {
            return false;
        }
    }

    public function ativar_crianca($id_responsavel, $id_lider, $id_crianca)
    {
        $this->db->set('ativo', 1);
        $this->db->where('id_crianca', $id_crianca);

        $acao = "ATIVAR_CRIANCA";

        if ($this->db->update('criancas')) {
            $this->FAlerta_model->alerta_controle($id_responsavel, $id_crianca, "", $acao);
            $this->FAlerta_model->alerta_para_coordenador($id_responsavel, $id_lider, $id_crianca, "", $acao);
            return true;
        } else {
            return false;
        }
    }
    // Fim REATIVAR

    public function excluir_criancas_do_pg($id_pg, $id_lider, $id_usuario)
    {

        $lista_de_criancas = $this->query([$id_lider, $id_pg], 'query_id_lider_id_pg_geral_order_by_nome_crianca_asc');

        if ($lista_de_criancas['row'] == 0) {
        } else {
            foreach ($lista_de_criancas['dados'] as $key => $c) {
                $id = $c['id_crianca'];
                $nome = $c['nome_crianca'];
                $this->excluir_crianca_permanentemente($id, $nome, $id_lider, $id_usuario);
            }
        }
    }

    public function excluir_crianca_permanentemente($id_crianca, $nome_crianca, $id_lider, $id_responsavel)
    {
        $acao = "EX_CL_3";
        $motivo = "Excluiu seu PG Permanentemente";

        date_default_timezone_set('America/Sao_Paulo');
        $data = date('d/m/Y');

        $consultar_pg_desativado = $this->db3->query("SELECT * FROM alcancado_crianca WHERE id_crianca LIKE $id_crianca");
        $row = $consultar_pg_desativado->num_rows();

        if ($row == 0) {
            $inserir['id_exclusao'] = NULL;
            $inserir['id_crianca'] = $id_crianca;
            $inserir['nome_crianca'] = $nome_crianca;
            $inserir['id_lider'] = $id_lider;
            $inserir['id_responsavel'] = $id_responsavel;
            $inserir['motivo'] = $motivo;
            $inserir['data_saida'] = $data;
            $this->db3->insert('alcancado_crianca', $inserir);
            /*if () {
                return 'true';
            }*/
        } else {
            //return 'false';
        }

        $this->db->where('id_crianca', $id_crianca);

        if ($this->db->delete('criancas')) {
            $this->PG->excluir_progresso_crianca_id($id_crianca);
            $this->FAlerta_model->alerta_controle($id_responsavel, $id_crianca, $motivo, $acao);
            //return true;
        } else {
            //return false;
        }
    }

    public function query_alcancados_criancas($id_usuario, $id_crianca)
    {
        $consultar_criancas = $this->db3->query("SELECT * FROM alcancado_crianca WHERE id_lider LIKE $id_usuario AND id_crianca = $id_crianca");
        $row = $consultar_criancas->num_rows();
        $dados_consulta_criancas = $consultar_criancas->row_array();

        $dados = array(
            'row' => $row,
            'dados' => $dados_consulta_criancas,
        );

        return $dados;
    }

    public function criacasPorLideres($ids)
    {
        if (empty($ids)) return [];

        $ids_str = implode(',', array_map('intval', $ids));
        $query = $this->db->query("
        SELECT lider, COUNT(*) AS total
        FROM criancas
        WHERE lider IN ($ids_str)
        GROUP BY lider
    ");

        $result = [];
        foreach ($query->result_array() as $row) {
            $result[$row['lider']] = (int)$row['total'];
        }

        return $result;
    }
}
