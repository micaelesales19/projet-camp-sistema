<?php

class Funcoes extends CI_Model
{
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
