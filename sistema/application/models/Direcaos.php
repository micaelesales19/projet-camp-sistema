<?php

/**
 * @property $db
 */

class Direcaos extends CI_Model
{
    public function infos($id_usuario, $opc, $order, $datas)
    {
        if ($opc == 'info_direcao') {
            // Consulta na tabela de direção de acordo com o ID
            $id_usuario = $id_usuario[0];
            $consultar_direcao = $this->db->query("SELECT * FROM direcao WHERE id_direcao = '$id_usuario'");
            $row = $consultar_direcao->num_rows();
            $dados_consulta_direcao = $consultar_direcao->row_array();

            $dados = array(
                'row' => $row,
                'dados' => $dados_consulta_direcao,
            );

            return $dados;
        }
    }

    public function editar_direcao($id, $nome, $cpf, $email, $telefone, $nascimento, $ativo, $foto)
    {
        $this->db->set('nome_direcao', $nome);
        $this->db->set('cpf', $cpf);
        $this->db->set('email', $email);
        $this->db->set('telefone_whatsapp', $telefone);
        $this->db->set('nascimento', $nascimento);
        $this->db->set('foto', $foto);
        $this->db->set('ativo', $ativo);
        $this->db->where('id_direcao', $id);

        if ($this->db->update('direcao')) {
            return true;
        } else {
            return false;
        }
    }
}
