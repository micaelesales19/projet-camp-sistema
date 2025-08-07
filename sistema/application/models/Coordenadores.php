<?php

/**
 * @property $db
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
}
