<?php

/**
 * @property $db
 */

class Supervisores extends CI_Model
{
    public function infos($id_usuario, $opc, $order, $datas)
    {
        if ($opc == 'info_supervisor') {
            // Consulta na tabela de líderes de acordo com o ID SUPERVISOR
            $id_usuario = $id_usuario[0];
            $consultar_coordenador = $this->db->query("SELECT * FROM supervisor_local WHERE id_supervisorR = '$id_usuario'");
            $row = $consultar_coordenador->num_rows();
            $dados_consulta_coordenadores = $consultar_coordenador->row_array();

            $dados = array(
                'row' => $row,
                'dados' => $dados_consulta_coordenadores,
            );

            return $dados;
        } else if ($opc == 'info_supervisor_or_email_cpf_nome') {
            $email = $id_usuario[0];
            $cpf = $id_usuario[1];
            $cpf2 = $id_usuario[2];
            $nome = $id_usuario[3];
            $consultar_coordenador = $this->db->query("SELECT * FROM supervisor_local WHERE nome_supervisorR LIKE '$nome' OR cpf = '$cpf' OR cpf = '$cpf2' OR email = '$email'");
            $row = $consultar_coordenador->num_rows();
            $dados_consulta_coordenadores = $consultar_coordenador->row_array();

            $dados = array(
                'row' => $row,
                'dados' => $dados_consulta_coordenadores,
            );

            return $dados;
        } else if ($opc == 'info_supervisor_and_email_cpf_nome') {
            $email = $id_usuario[0];
            $cpf = $id_usuario[1];
            $nome = $id_usuario[2];
            $consultar_coordenador = $this->db->query("SELECT * FROM supervisor_local WHERE nome_supervisorR LIKE '$nome' AND cpf = '$cpf' AND email = '$email'");
            $row = $consultar_coordenador->num_rows();
            $dados_consulta_coordenadores = $consultar_coordenador->row_array();

            $dados = array(
                'row' => $row,
                'dados' => $dados_consulta_coordenadores,
            );

            return $dados;
        } else if ($opc == 'info_supervisor_nome_email_data_nascimento') {
            // Consulta na tabela de supervisor de acordo com o EMAIL, NOME E DATA DE NASCIMENTO
            $email = $id_usuario[0];
            $nome = $id_usuario[1];
            $data_nascimento = $id_usuario[2];
            $consultar_coordenador = $this->db->query("SELECT * FROM supervisor_local WHERE email = '$email' AND nome_supervisorR = '$nome' AND nascimento = '$data_nascimento'");
            $row = $consultar_coordenador->num_rows();
            $dados_consulta_coordenadores = $consultar_coordenador->row_array();

            $dados = array(
                'row' => $row,
                'dados' => $dados_consulta_coordenadores,
            );

            return $dados;
        } else if ($opc == 'query_supervisor') {
            $consultar_coordenador = $this->db->query("SELECT * FROM supervisor_local");
            $row = $consultar_coordenador->num_rows();
            $dados_consulta_coordenadores = $consultar_coordenador->result_array();

            $dados = array(
                'row' => $row,
                'dados' => $dados_consulta_coordenadores,
            );

            return $dados;
        } else if ($opc == 'query_supervisor_order_by_nome') {
            $consultar_coordenador = $this->db->query("SELECT * FROM supervisor_local ORDER BY nome_supervisorR $order");
            $row = $consultar_coordenador->num_rows();
            $dados_consulta_coordenadores = $consultar_coordenador->result_array();

            $dados = array(
                'row' => $row,
                'dados' => $dados_consulta_coordenadores,
            );

            return $dados;
        }
    }

    public function cadastro_supervisor($nome, $cpf, $email, $telefone, $nascimento, $pais, $estado, $cidade, $ativo)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $data_2 = date('Y-m-d');

        $foto = "fotoU/geral.jpg";

        $inserir['nome_supervisorR'] = $nome;
        $inserir['cpf'] = $cpf;
        $inserir['email'] = $email;
        $inserir['telefone_whatsapp'] = $telefone;
        $inserir['nascimento'] = $nascimento;
        $inserir['pais'] = $pais;
        $inserir['estado'] = $estado;
        $inserir['cidade'] = $cidade;
        $inserir['id_supervisorE'] = "";
        $inserir['foto'] = $foto;
        $inserir['ativo'] = $ativo;
        $inserir['data_cadastro'] = $data_2;

        if ($this->db->insert("supervisor_local", $inserir)) {
            return true;
        } else {
            return false;
        }
    }

    public function cadastro_supervisor_2($nome, $cpf, $email, $telefone, $nascimento, $pais, $estado, $cidade, $ativo, $foto)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $data_2 = date('Y-m-d');

        $inserir['nome_supervisorR'] = $nome;
        $inserir['cpf'] = $cpf;
        $inserir['email'] = $email;
        $inserir['telefone_whatsapp'] = $telefone;
        $inserir['nascimento'] = $nascimento;
        $inserir['pais'] = $pais;
        $inserir['estado'] = $estado;
        $inserir['cidade'] = $cidade;
        $inserir['id_supervisorE'] = "";
        $inserir['foto'] = $foto;
        $inserir['ativo'] = $ativo;
        $inserir['data_cadastro'] = $data_2;

        if ($this->db->insert("supervisor_local", $inserir)) {
            return true;
        } else {
            return false;
        }
    }

    public function editar_supervisor($id, $nome, $cpf, $email, $telefone, $nascimento, $pais, $estado, $cidade, $ativo, $foto)
    {
        $this->db->set('nome_supervisorR', $nome);
        $this->db->set('cpf', $cpf);
        $this->db->set('email', $email);
        $this->db->set('telefone_whatsapp', $telefone);
        $this->db->set('nascimento', $nascimento);
        $this->db->set('pais', $pais);
        $this->db->set('estado', $estado);
        $this->db->set('cidade', $cidade);
        $this->db->set('foto', $foto);
        $this->db->set('ativo', $ativo);
        $this->db->where('id_supervisorR', $id);

        if ($this->db->update('supervisor_local')) {
            return true;
        } else {
            return false;
        }
    }

    public function check_supervisor_ativo($id, $ativo)
    {
        $supervisor_ativo = 0;

        $consultar_se_o_supervisor_tem_coordenador = $this->db->query("SELECT * FROM coordenador WHERE id_supervisorR = $id");
        $total_coordenadores_do_supervisor = $consultar_se_o_supervisor_tem_coordenador->num_rows();
        //$dados_coordenador = $consultar_se_o_supervisor_tem_coordenador->result_array();

        $consultar_se_o_supervisor_tem_lider = $this->db->query("SELECT * FROM lider WHERE id_supervisorR = $id");
        $total_lideres_do_supervisor = $consultar_se_o_supervisor_tem_lider->num_rows();
        $dados_lider = $consultar_se_o_supervisor_tem_lider->result_array();

        if ($ativo == 0 || $total_coordenadores_do_supervisor == 0 || $total_lideres_do_supervisor == 0) {
        } else {
            // 🔹 1. Coleta todos os IDs de líderes de uma vez
            $ids = array_column($dados_lider, 'id_lider');

            // 🔹 2. Busca todas as crianças desses líderes de uma vez
            $criacas_por_lider = $this->Criancas->criacasPorLideres($ids);

            // 🔹 3. Busca todos os progressos de uma vez
            $progresso_por_lider = $this->PG->progressoPorLideres($ids);

            foreach ($dados_lider as $key => $lideres) {
                $id_lider = $lideres['id_lider'];
                $ativo = $lideres['confirmado'];
                $data_cadastro = $lideres['data_cadastro'];

                $check = $this->Lideres->check_lider_is_ativo_otimizado(
                    $id_lider,
                    $data_cadastro,
                    $ativo,
                    $criacas_por_lider,
                    $progresso_por_lider
                );
                if ($check == 0) {
                } else {
                    $supervisor_ativo = 1;
                }
            }
        }
        return $supervisor_ativo;
    }

    public function desativar_supervisor($id_supervisor)
    {
        $ativo = "0";

        $this->db->set('ativo', $ativo);
        $this->db->where('id_supervisorR', $id_supervisor);

        if ($this->db->update('supervisor_local')) {
            return true;
        } else {
            return false;
        }
    }
    public function ativar_supervisor($id_supervisor)
    {
        $ativo = "1";

        $this->db->set('ativo', $ativo);
        $this->db->where('id_supervisorR', $id_supervisor);

        if ($this->db->update('supervisor_local')) {
            return true;
        } else {
            return false;
        }
    }
    public function excluirSupervisorPermanentemente($id_supervisor, $id_responsavel)
    {
        $motivo = "Excluiu seu Supervisor Permanentemente";
        $acao = "EX_SUPER_P_1";

        date_default_timezone_set('America/Sao_Paulo');
        $data = date('d/m/Y');

        $dados_supervisor = $this->infos([$id_supervisor], 'info_supervisor', '', '');

        $consultar_pg_desativado = $this->db3->query("SELECT * FROM alcancado_surpr WHERE id_supervisorR LIKE '$id_supervisor'");
        $row = $consultar_pg_desativado->num_rows();

        if ($row == 0) {
            //$inserir['id_exclusao'] = NULL;
            $inserir['id_supervisorR'] = $id_supervisor;
            $inserir['nome_supervisorR'] = $dados_supervisor['dados']['nome_supervisorR'];
            $inserir['id_responsavel'] = $id_responsavel;
            $inserir['motivo'] = $motivo;
            $inserir['data_saida'] = $data;

            if ($this->db3->insert('alcancado_surpr', $inserir)) {
            }
        } else {
        }

        $this->db->where('id_supervisorR', $id_supervisor);
        if ($this->db->delete('supervisor_local')) {
            $this->FAlerta_model->alerta_controle($id_responsavel, $id_supervisor, $motivo, $acao);
            return true;
        } else {
            return false;
        }
    }

    public function delete_supervisor_local_id($id_supervisor)
    {
        $this->db->where('id_supervisorR', $id_supervisor);
        if ($this->db->delete('supervisor_local')) {
            return true;
        } else {
            return false;
        }
    }
}
