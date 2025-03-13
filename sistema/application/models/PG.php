<?php

/**
 * @property $db
 * @property $load
 * @property $uri
 * @property $FSistema_model
 * @property $FAlerta_model
 * @property $FConsultas_model
 */

class PG extends CI_Model
{
    public function query($dados, $opc, $ativo)
    {
        if ($opc == 'query_pg_id_lider_id_pg') {
            $id_usuario = $dados[0];
            $id_pg = $dados[1];
            $query_consulta_pg = $this->db->query("SELECT * FROM pg WHERE id_lider LIKE $id_usuario AND id_pg = $id_pg");
            $row = $query_consulta_pg->num_rows();
            $consultar_pg = $query_consulta_pg->row_array();
            $dados = array(
                'row' => $row,
                'dados' => $consultar_pg,
            );
        } else if ($opc == 1) {
            $id_usuario = $dados[0];
            $query_consulta_pg = $this->db->query("SELECT * FROM pg WHERE id_lider LIKE $id_usuario AND ativo = $ativo");
            $row = $query_consulta_pg->num_rows();
            $consultar_pg = $query_consulta_pg->result_array();

            $dados = array(
                'row' => $row,
                'dados' => $consultar_pg,
            );
        } else if ($opc == 2) {
            $id_usuario = $dados[0];
            $query_consulta_pg = $this->db->query("SELECT * FROM pg WHERE id_lider LIKE $id_usuario AND ativo = $ativo ORDER BY id_modulo ASC LIMIT 1");
            $row = $query_consulta_pg->num_rows();
            $consultar_pg = $query_consulta_pg->result_array();

            $dados = array(
                'row' => $row,
                'dados' => $consultar_pg,
            );
        } else if ($opc == 'query_lider_ativo_order_by_nome_pg_asc') {
            $id_usuario = $dados[0];
            $consultar_pg = $this->db->query("SELECT * FROM pg WHERE id_lider LIKE $id_usuario AND ativo = $ativo ORDER BY nome_pg ASC");
            $row = $consultar_pg->num_rows();
            $dados_consulta_pg = $consultar_pg->result_array();

            $dados = array(
                'row' => $row,
                'dados' => $dados_consulta_pg,
            );
        } else if ($opc == 'query_id_lider_id_pg_ativo') {
            $id_usuario = $dados[0];
            $idPG = $id_usuario[1];

            $consultar_pg = $this->db->query("SELECT * FROM pg WHERE id_lider LIKE $id_usuario AND id_pg = $idPG AND ativo = $ativo");
            $row = $consultar_pg->num_rows();
            $dados_consulta_pg = $consultar_pg->row_array();

            $dados = array(
                'row' => $row,
                'dados' => $dados_consulta_pg,
            );
        } else if ($opc == 'query_id_lider_ativo_order_by_modulo_desc_limit_1_download_material') {
            $id_usuario = $dados[0];

            $consultar_pg = $this->db->query("SELECT * FROM pg WHERE id_lider LIKE $id_usuario AND ativo = $ativo ORDER BY id_modulo DESC LIMIT 1");
            $row = $consultar_pg->num_rows();
            $dados_consulta_pg = $consultar_pg->row_array();

            $dados = array(
                'row' => $row,
                'dados' => $dados_consulta_pg,
            );
        }

        return $dados;
    }

    public function mostrarPGId($id_usuario, $idPG)
    {
        $consultar_pg = $this->db->query("SELECT * FROM pg WHERE id_lider LIKE $id_usuario AND id_pg = $idPG AND ativo = 1");
        $row = $consultar_pg->num_rows();
        $dados_consulta_pg = $consultar_pg->row_array();

        $dados = array(
            'row' => $row,
            'dados' => $dados_consulta_pg,
        );
        return $dados;
    }

    public function check_cadastro_pg($opc, $dados)
    {
        if ($opc == 'check_id_lider_nome') {
            $idLider = $dados[0];
            $nomePg = $dados[1];
            $consultar_pg = $this->db->query("SELECT * FROM pg WHERE id_lider = $idLider AND nome_pg LIKE '$nomePg'");
            $row = $consultar_pg->num_rows();

            if ($row == 0) {
                return true;
            } else {
                return false;
            }
        } else if ($opc == 'check_id_lider') {
            $idLider = $dados[0];
            $consultar_pg = $this->db->query("SELECT * FROM pg WHERE id_lider = $idLider");
            $row = $consultar_pg->num_rows();

            if ($row == 0) {
                return true;
            } else {
                return false;
            }
        } else if ($opc == 'check_id_pg') {
            $idPG = $dados[0];
            $consultar_pg = $this->db->query("SELECT * FROM pg WHERE id_pg = $idPG");
            $row = $consultar_pg->num_rows();

            if ($row == 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function cadastro_pg($idLider, $nome, $data_inicio, $autorizacao)
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

        if ($this->db->insert("pg", $inserir)) {
            return true;
        } else {
            return false;
        }
    }

    public function cadastro_pg_c_infos($id_pg, $idLider, $nome, $ano_pg, $id_modulo, $n_licao, $data_cadastro, $data_inicio, $data_fim, $ativo, $foto, $bonus)
    {
        $autorizacao = "0"; // autorização envio de emails

        $inserir['id_pg'] = $id_pg;
        $inserir['nome_pg'] = $nome;
        $inserir['id_lider'] = $idLider;
        $inserir['autorizacao'] = $autorizacao;
        $inserir['ano'] = $ano_pg;
        $inserir['id_modulo'] = $id_modulo;
        $inserir['n_licao'] = $n_licao;
        $inserir['data_cadastro'] = $data_cadastro;
        $inserir['data_inicio'] = $data_inicio;
        $inserir['data_previsao_termino'] = $data_fim;
        $inserir['data_semana'] = $data_inicio;
        $inserir['ano_devocional'] = $ano_pg;
        $inserir['modulo_devocional'] = $id_modulo;
        $inserir['licao_devocional'] = $n_licao;
        $inserir['ativo'] = $ativo;
        $inserir['foto'] = $foto;
        $inserir['bonus'] = $bonus;

        if ($this->db->insert("pg", $inserir)) {
            return true;
        } else {
            return false;
        }
    }
    public function editar_pg($id, $nomePg, $foto, $autorizacao)
    {
        $this->db->set('nome_pg', $nomePg);
        $this->db->set('foto', $foto);
        $this->db->set('autorizacao', $autorizacao);
        $this->db->where('id_pg ', $id);

        if ($this->db->update('pg')) {
            return true;
        } else {
            return false;
        }
    }
    public function excluir_pg($id_pg, $id_lider, $id_responsavel, $motivo)
    {
        $ativo = "0";
        $acao = "EX_CL_2";

        $this->db->set('ativo', $ativo);
        $this->db->where('id_pg', $id_pg);
        if ($this->db->update('pg')) {
            $this->FAlerta_model->alerta_controle($id_responsavel, $id_pg, $motivo, $acao);
            $this->FAlerta_model->alerta_para_coordenador($id_responsavel, $id_lider, $id_pg, $motivo, $acao);
            return true;
        } else {
            return false;
        }
    }

    public function reativar_pg($id_pg, $id_responsavel)
    {
        $ativo = "1";
        $acao = "RE_PG_1";
        $motivo = "Reativou seu PG";

        $this->db->set('ativo', $ativo);
        $this->db->where('id_pg', $id_pg);

        if ($this->db->update('pg')) {
            $this->FSistema_model->excluirPgAlcancado($id_pg);
            $this->FAlerta_model->alerta_controle($id_responsavel, $id_pg, $motivo, $acao);
            return true;
        } else {
            return false;
        }
    }

    public function excluir_pg_permanentemente($id_pg, $id_lider, $id_responsavel, $nivel)
    {
        $ativo = "1";
        $acao = "EX_PG_1";
        $motivo = "Excluiu seu PG Permanentemente";

        date_default_timezone_set('America/Sao_Paulo');
        $data = date('d/m/Y');

        $dadosPG = $this->mostrarPGId($id_lider, $id_pg);

        $consultar_pg_desativado = $this->db->query("SELECT * FROM alcancado_pg WHERE id_pg LIKE $id_pg");
        $row = $consultar_pg_desativado->num_rows();

        if ($row == 0) {
            $inserir['id_exclusao'] = NULL;
            $inserir['id_pg'] = $id_pg;
            $inserir['nome_pg'] = $dadosPG['dados']['nome_pg'];
            $inserir['id_lider'] = $id_lider;
            $inserir['id_responsavel'] = $id_responsavel;
            $inserir['motivo'] = $motivo;
            $inserir['data_saida'] = $data;

            if ($this->db->insert('alcancado_pg', $inserir)) {
            }
        } else {
        }

        $this->db->where('id_pg', $id_pg);

        if ($nivel == 1) {
            if ($this->db->delete('pg_pais')) {
                $this->FSistema_model->excluirProgresso($id_pg, $id_lider);
                $this->FAlerta_model->alerta_controle($id_responsavel, $id_pg, $motivo, $acao);
                return true;
            } else {
                return false;
            }
        } else if ($nivel == 2) {
            if ($this->db->delete('pg_2')) {
                $this->FSistema_model->excluirProgresso($id_pg, $id_lider);
                $this->FAlerta_model->alerta_controle($id_responsavel, $id_pg, $motivo, $acao);
                return true;
            } else {
                return false;
            }
        }
    }

    // progresso
    public function consultarProgressoGeral($id_lider, $x)
    {
        if ($x == 1) {
            $consultar = $this->db->query("SELECT * FROM progresso_pg_pais WHERE id_lider = $id_lider");
            $row = $consultar->num_rows();
            $dados = $consultar->result_array();

            $array = array(
                'row' => $row,
                'dados' => $dados,
            );

            return $array;
        } else if ($x == 2) {
            $consultar = $this->db->query("SELECT * FROM progresso_pg WHERE id_lider = $id_lider");
            $row = $consultar->num_rows();
            $dados = $consultar->result_array();

            $array = array(
                'row' => $row,
                'dados' => $dados,
            );

            return $array;
        }
    }

    public function consultar_progresso($opc, $dados)
    {
        if ($opc == 'query_id_pg_id_lider_id_crianca_id_modulo') {
            $id_pg = $dados[0];
            $id_lider = $dados[1];
            $id_crianca = $dados[2];
            $id_modulo = $dados[3];
            $consultar = $this->db->query("SELECT * FROM progresso_pg WHERE id_pg = $id_pg AND id_lider = $id_lider AND id_crianca_presente = $id_crianca AND id_modulo = $id_modulo");
            $row = $consultar->num_rows();
            $dados = $consultar->result_array();

            $array = array(
                'row' => $row,
                'dados' => $dados,
            );
        } else if ($opc == 'query_id_pg_id_lider_id_modulo_licao') {

            $id_pg = $dados[0];
            $id_lider = $dados[1];
            $id_modulo = $dados[2];
            $numero_licao = $dados[3];

            $consultar = $this->db->query("SELECT * FROM progresso_pg WHERE id_pg = $id_pg AND id_lider = '$id_lider' AND id_modulo = '$id_modulo' AND numero_licao = '$numero_licao'");
            $row = $consultar->num_rows();
            $dados = $consultar->row_array();

            $array = array(
                'row' => $row,
                'dados' => $dados,
            );
        }


        return $array;
    }

    public function relatorio_encontro($id_lider, $id_pg, $qtd_crianca, $id_crianca, $versiculo, $presenca, $misterio, $devocional, $ano, $modulo, $licao, $data_aula)
    {
        $data = $data_aula;

        $consulta = $this->consultar_progresso('query_id_pg_id_lider_id_modulo_licao', [$id_pg, $id_lider, $modulo, $licao]);
        $resultados = $consulta['row'];

        $consulta_pg = $this->mostrarPGId($id_lider, $id_pg);

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

        $base = "";

        if ($qtd_crianca == $resultados) {
            $base .= "false";
        } else {
            if ($this->db->insert("progresso_pg", $inserir)) {

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
                    $this->db->update('pg');
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

                    $ativo = strtotime($data_previsao_termino) >= strtotime($data) ? 1 : 1;
                    //$ativo = strtotime($data_previsao_termino) >= strtotime($data) ? 1 : 0;

                    $this->db->set('ano', $anoNovo);
                    $this->db->set('ano_devocional', $anoNovo);
                    $this->db->set('id_modulo', $n_modulo);
                    $this->db->set('modulo_devocional', $n_modulo);
                    $this->db->set('n_licao', $licao_nova_modulo);
                    $this->db->set('licao_devocional', $licao_nova_modulo);
                    $this->db->set('ativo', $ativo);
                    $this->db->set('data_semana', $data);
                    $this->db->where('id_pg', $id_pg);

                    if ($this->db->update('pg')) {
                        $acao = "MUDANCA_DE_MODULO";
                        $assunto = " mudou de módulo, módulo " . $nome_modulo . " para " . $novo_modulo . " autorize o novo módulo";

                        $this->FAlerta_model->alerta_controle($id_lider, $id_lider, $assunto, $acao);
                        //$this->FAlerta_model->alerta_para_coordenador($id_coordenador, $id_lider, $id_crianca, $assunto, $acao);

                        $base .= "fim_modulo?id_lider=$id_lider&id_pg=$id_pg";
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

                        $this->db->set('n_licao', $licao_nova);
                        $this->db->set('licao_devocional', $licao_nova);
                        $this->db->set('data_semana', $data);
                        $this->db->where('id_pg', $id_pg);

                        if ($this->db->update('pg')) {
                            $base .= "pg";
                        }
                    }
                }
            } else {
                $base .= "false";
            }
        }

        return $base;
    }

    public function excluir_progresso($id_pg, $id_lider)
    {

        $this->db->where('id_pg', $id_pg);
        $this->db->where('id_lider', $id_lider);
        $this->db->delete('progresso_pg');
    }

    public function excluir_progresso_crianca_id($id_crianca)
    {
        $this->db->where('id_crianca_presente', $id_crianca);
        $this->db->delete('progresso_pg');
    }
}
