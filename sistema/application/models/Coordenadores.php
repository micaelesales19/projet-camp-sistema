<?php

/**
 * @property $db
 * @property $db3
 * @property Lideres $Lideres
 * @property FSistema_model $FSistema_model
 */

class Coordenadores extends CI_Model
{
    public function infos($id_usuario, $opc, $opc2, $order, $datas)
    {
        if ($opc == 1 && $opc2 == 1 && $order[0] == true) {
            // Consulta na tabela de líderes de acordo com o ID COORDENADOR ordenado
            $id_usuario = $id_usuario[0];
            $consultar_lideres = $this->db->query("SELECT * FROM lider WHERE id_coordenador = $id_usuario ORDER BY nome_lider $order[1]");
            $row = $consultar_lideres->num_rows();
            $dados_consulta_lideres = $consultar_lideres->result_array();

            $dados = array(
                'row' => $row,
                'dados' => $dados_consulta_lideres,
            );

            return $dados;
        } else if ($opc == 1 && $opc2 == 1 && $order[0] == false) {
            // Consulta na tabela de líderes de acordo com o ID COORDENADOR
            $id_usuario = $id_usuario[0];
            $consultar_lideres = $this->db->query("SELECT * FROM lider WHERE id_coordenador = $id_usuario");
            $row = $consultar_lideres->num_rows();
            $dados_consulta_lideres = $consultar_lideres->result_array();

            $dados = array(
                'row' => $row,
                'dados' => $dados_consulta_lideres,
            );

            return $dados;
        } else if ($opc == 'info_coordenador') {
            // Consulta na tabela de coordenador de acordo com o ID COORDENADOR
            $id_usuario = $id_usuario[0];
            $consultar_coordenador = $this->db->query("SELECT * FROM coordenador WHERE id_coordenador = '$id_usuario'");
            $row = $consultar_coordenador->num_rows();
            $dados_consulta_coordenadores = $consultar_coordenador->row_array();

            $dados = array(
                'row' => $row,
                'dados' => $dados_consulta_coordenadores,
            );

            return $dados;
        } else if ($opc == 'info_coordenador_or_email_cpf_nome') {
            $email = $id_usuario[0];
            $cpf = $id_usuario[1];
            $cpf2 = $id_usuario[2];
            $nome = $id_usuario[3];
            $consultar_coordenador = $this->db->query("SELECT * FROM coordenador WHERE nome_coordenador LIKE '$nome' OR cpf = '$cpf' OR cpf = '$cpf2' OR email = '$email'");
            $row = $consultar_coordenador->num_rows();
            $dados_consulta_coordenadores = $consultar_coordenador->row_array();

            $dados = array(
                'row' => $row,
                'dados' => $dados_consulta_coordenadores,
            );

            return $dados;
        } else if ($opc == 'info_coordenador_nome_email_data_nascimento') {
            // Consulta na tabela de coordenador de acordo com o EMAIL, NOME E DATA DE NASCIMENTO
            $email = $id_usuario[0];
            $nome = $id_usuario[1];
            $data_nascimento = $id_usuario[2];
            $consultar_coordenador = $this->db->query("SELECT * FROM coordenador WHERE email = '$email' AND nome_coordenador = '$nome' AND nascimento = '$data_nascimento'");
            $row = $consultar_coordenador->num_rows();
            $dados_consulta_coordenadores = $consultar_coordenador->row_array();

            $dados = array(
                'row' => $row,
                'dados' => $dados_consulta_coordenadores,
            );

            return $dados;
        } else if ($opc == 'info_coordenador_id_supervisor') {
            // Consulta na tabela de coordenadores de acordo com o ID SUPERVISOR
            $id_supervisor = $id_usuario[0];
            $consultar_coordenador = $this->db->query("SELECT * FROM coordenador WHERE id_supervisorR = '$id_supervisor'");
            $row = $consultar_coordenador->num_rows();
            $dados_consulta_coordenadores = $consultar_coordenador->result_array();

            $dados = array(
                'row' => $row,
                'dados' => $dados_consulta_coordenadores,
            );

            return $dados;
        }
    }

    public function coordenadoresAtivos($list)
    {
        $lista = $list['dados'];
        $total_ativos = 0;
        $dados_coordenador = [];

        if ($list['row'] == 0) {
        } else {
            foreach ($lista as $key => $coordenador) {
                $coordenador_ativo = 0;
                $id = $coordenador['id_coordenador'];
                $ativo = $coordenador['ativo'];

                $consultar_se_o_coordenador_tem_lider = $this->db->query("SELECT * FROM lider WHERE id_coordenador = $id");
                $total_lideres_do_coordenador = $consultar_se_o_coordenador_tem_lider->num_rows();
                $dados_lider = $consultar_se_o_coordenador_tem_lider->result_array();

                if ($ativo == 0 || $total_lideres_do_coordenador == 0) {
                } else {
                    foreach ($dados_lider as $key => $lideres) {
                        $id_lider = $lideres['id_lider'];
                        $ativo = $lideres['confirmado'];
                        $data_cadastro = $lideres['data_cadastro'];

                        $check = $this->Lideres->check_lider_is_ativo($id_lider, $data_cadastro, $ativo);

                        if ($check == 0) {
                        } else {
                            $coordenador_ativo = 1;
                        }
                    }
                }

                if ($coordenador_ativo == 0) {
                } else {
                    // coordenador ativo
                    array_push($dados_coordenador, $coordenador);
                    $total_ativos = $total_ativos + 1;
                }
            }
        }

        $dados = array(
            'row' => $total_ativos,
            'dados' => $dados_coordenador,
        );
        return $dados;
    }

    public function check_coordenador_ativo($id, $ativo)
    {
        $coordenador_ativo = 0;

        $consultar_se_o_coordenador_tem_lider = $this->db->query("SELECT * FROM lider WHERE id_coordenador = $id");
        $total_lideres_do_coordenador = $consultar_se_o_coordenador_tem_lider->num_rows();
        $dados_lider = $consultar_se_o_coordenador_tem_lider->result_array();

        if ($ativo == 0 || $total_lideres_do_coordenador == 0) {
        } else {
            foreach ($dados_lider as $key => $lideres) {
                $id_lider = $lideres['id_lider'];
                $ativo = $lideres['confirmado'];
                $data_cadastro = $lideres['data_cadastro'];

                $check = $this->Lideres->check_lider_is_ativo($id_lider, $data_cadastro, $ativo);
                if ($check == 0) {
                } else {
                    $coordenador_ativo = 1;
                }
            }
        }
        return $coordenador_ativo;
    }

    public function cadastro_coordenador($nome, $cpf, $email, $telefone, $nascimento, $pais, $estado, $cidade, $id_supervisor, $ativo)
    {
        date_default_timezone_set('America/Sao_Paulo');
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
        $inserir['id_supervisorR'] = $id_supervisor;
        $inserir['id_supervisorE'] = $id_supervisor;
        $inserir['foto'] = $foto;
        $inserir['ativo'] = $ativo;
        $inserir['data_cadastro'] = $data_2;

        if ($this->db->insert("coordenador", $inserir)) {
            return true;
        } else {
            return false;
        }
    }

    public function editar_coordenador($id, $nome, $cpf, $email, $telefone, $nascimento, $pais, $estado, $cidade, $ativo, $id_sl, $id_sr, $foto)
    {
        $this->db->set('nome_coordenador', $nome);
        $this->db->set('cpf', $cpf);
        $this->db->set('email', $email);
        $this->db->set('telefone_whatsapp', $telefone);
        $this->db->set('nascimento', $nascimento);
        $this->db->set('pais', $pais);
        $this->db->set('estado', $estado);
        $this->db->set('cidade', $cidade);
        $this->db->set('id_supervisorR', $id_sl);
        $this->db->set('id_supervisorE', $id_sr);
        $this->db->set('foto', $foto);
        $this->db->set('ativo', $ativo);
        $this->db->where('id_coordenador', $id);

        if ($this->db->update('coordenador')) {
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
        $acao = "EX_COORD_P_1";

        date_default_timezone_set('America/Sao_Paulo');
        $data = date('d/m/Y');

        $dados_lider = $this->FConsultas_model->getInfoCoordenadorId($id_coordenador);

        $consultar_pg_desativado = $this->db3->query("SELECT * FROM alcancado_coordenador WHERE id_pastor LIKE '$id_coordenador'");
        $row = $consultar_pg_desativado->num_rows();

        if ($row == 0) {
            //$inserir['id_exclusao'] = NULL;
            $inserir['id_pastor'] = $id_coordenador;
            $inserir['nome_coordenador'] = $dados_lider['dados']['nome_coordenador'];
            $inserir['id_responsavel'] = $id_responsavel;
            $inserir['motivo'] = $motivo;
            $inserir['data_saida'] = $data;

            if ($this->db3->insert('alcancado_coordenador', $inserir)) {
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
}
