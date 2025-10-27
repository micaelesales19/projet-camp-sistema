<?php

/**
 * @property $db
 * @property $FSistema_model
 */

class Supervisores extends CI_Model
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
        } else if ($opc == 'info_supervisor') {
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
        }
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
            $dados_supervisor = $this->infos([$id_usuario], 'info_supervisor', '', '', '');

            $dados = "";
            $nivel = "4";

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
}
