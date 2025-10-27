<?php

/**
 * @property $db
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
            // Consulta na tabela de líderes de acordo com o ID COORDENADOR
            $id_usuario = $id_usuario[0];
            $consultar_coordenador = $this->db->query("SELECT * FROM coordenador WHERE id_coordenador = '$id_usuario'");
            $row = $consultar_coordenador->num_rows();
            $dados_consulta_coordenadores = $consultar_coordenador->row_array();

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

    public function criar_link($id_usuario)
    {

        $consultarLink = $this->db->select("*")
            ->from("link_cadastro")
            ->where("id_usuario", $id_usuario)
            ->get();
        $totalLink = $consultarLink->num_rows();
        $info_codigo = $consultarLink->row_array();

        if ($totalLink == 0) {
            $dados_coordenador = $this->infos([$id_usuario], 'info_coordenador', '', '', '');
            //$dados_supervisor = $this->infos([$id_usuario], 'info_coordenador', '', '', '');

            $dados = "";
            $nivel = "";

            if ($dados_coordenador['row'] != 0) {
                $dados = $dados_coordenador['dados']['id_supervisorR'];
                $nivel = 3;
            } /*else if ($dados_supervisor['row'] == 0) {
            $nivel = 4;
        }*/

            $codigo = $this->FSistema_model->gerarLink();

            $link = "https://sistemas.campbrasil.com/sistema/cadastro/" . $codigo;

            //return $codigo;
            $data = date('Y-m-d');

            $inserir['id_usuario'] = NULL;
            $inserir['id_usuario'] = $id_usuario;
            $inserir['nivel'] = $nivel;
            $inserir['codigo'] = $codigo;
            $inserir['link'] = $link;
            $inserir['dados'] = $dados;
            $inserir['data'] = $data;

            if ($this->db->insert('link_cadastro', $inserir)) {
                return $link;
            } else {
                return false;
            }
        } else {
            return $info_codigo['link'];
        }
    }

    public function cadastro_coordenador($nome, $cpf, $email, $telefone, $nascimento, $pais, $estado, $cidade, $id_supervisor)
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
        $inserir['ativo'] = 1;
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
}
