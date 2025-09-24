<?php

/**
 * @property $db
 * @property $db3
 * @property $load
 * @property $uri
 * @property $FSistema_model
 * @property $FAlerta_model
 * @property $Criancas
 * @property $PG
 * @property $FConsultas_model
 */

class Lideres extends CI_Model
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
        } else if ($opc == 'info_lider') {
            // Consulta na tabela de líderes de acordo com o ID LIDER
            $id_usuario = $id_usuario[0];
            $consultar_lider = $this->db->query("SELECT * FROM lider WHERE id_lider = '$id_usuario'");
            $row = $consultar_lider->num_rows();
            $dados_consulta_lideres = $consultar_lider->row_array();

            $dados = array(
                'row' => $row,
                'dados' => $dados_consulta_lideres,
            );

            return $dados;
        } else if ($opc == 'info_lider_or_email_cpf_nome') {
            $email = $id_usuario[0];
            $cpf = $id_usuario[1];
            $cpf2 = $id_usuario[2];
            $nome = $id_usuario[3];
            $consultar_lider = $this->db->query("SELECT * FROM lider WHERE nome_lider LIKE '$nome' OR cpf = '$cpf' OR cpf = '$cpf2' OR email = '$email'");
            $row = $consultar_lider->num_rows();
            $dados_consulta_lideres = $consultar_lider->row_array();

            $dados = array(
                'row' => $row,
                'dados' => $dados_consulta_lideres,
            );

            return $dados;
        } else if ($opc == 'info_usuario_or_email_cpf_nome') {
            $email = $id_usuario[0];
            $cpf = $id_usuario[1];
            $nome = $id_usuario[2];
            $consultar_lider = $this->db->query("SELECT * FROM usuario WHERE email = '$email' OR cpf = '$cpf' OR nome = '$nome'");
            $row = $consultar_lider->num_rows();
            $dados_consulta_lideres = $consultar_lider->row_array();

            $dados = array(
                'row' => $row,
                'dados' => $dados_consulta_lideres,
            );

            return $dados;
        } else if ($opc == 'info_usuario_and_email_cpf') {
            $email = $id_usuario[0];
            $cpf = $id_usuario[1];
            $consultar_lider = $this->db->query("SELECT * FROM usuario WHERE email = '$email' AND cpf = '$cpf'");
            $row = $consultar_lider->num_rows();
            $dados_consulta_lideres = $consultar_lider->row_array();

            $dados = array(
                'row' => $row,
                'dados' => $dados_consulta_lideres,
            );

            return $dados;
        } else if ($opc == 'info_usuario_or_email_nome') {
            $email = $id_usuario[0];
            $nome = $id_usuario[1];
            $consultar_lider = $this->db->query("SELECT * FROM usuario WHERE email = '$email' OR nome = '$nome'");
            $row = $consultar_lider->num_rows();
            $dados_consulta_lideres = $consultar_lider->row_array();

            $dados = array(
                'row' => $row,
                'dados' => $dados_consulta_lideres,
            );

            return $dados;
        } else if ($opc == 'info_lider_email_cpf') {
            // Consulta na tabela de líderes de acordo com o ID LIDER
            $email = $id_usuario[0];
            $cpf = $id_usuario[1];
            $consultar_lider = $this->db->query("SELECT * FROM lider WHERE email = '$email' AND cpf = '$cpf'");
            $row = $consultar_lider->num_rows();
            $dados_consulta_lideres = $consultar_lider->row_array();

            $dados = array(
                'row' => $row,
                'dados' => $dados_consulta_lideres,
            );

            return $dados;
        } else if ($opc == 'info_lider_nome_email_data_nascimento') {
            // Consulta na tabela de líderes de acordo com o ID LIDER
            $email = $id_usuario[0];
            $nome = $id_usuario[1];
            $data_nascimento = $id_usuario[2];
            $consultar_lider = $this->db->query("SELECT * FROM lider WHERE email = '$email' AND nome_lider = '$nome' AND nascimento = '$data_nascimento'");
            $row = $consultar_lider->num_rows();
            $dados_consulta_lideres = $consultar_lider->row_array();

            $dados = array(
                'row' => $row,
                'dados' => $dados_consulta_lideres,
            );

            return $dados;
        } else if ($opc == 'check_lider_situacao_cadastro_id_coordenador') {
            // Consulta na tabela de líderes se tem lider esperando autorização pelo ID COORDENADOR
            $id_coordenador = $id_usuario[0];
            $situacao = $id_usuario[1];
            $consultar_lider = $this->db->query("SELECT * FROM lider WHERE id_coordenador = '$id_coordenador' AND confirmado = $situacao ORDER BY nome_lider ASC");
            $row = $consultar_lider->num_rows();
            $dados_consulta_lideres = $consultar_lider->result_array();

            $dados = array(
                'row' => $row,
                'dados' => $dados_consulta_lideres,
            );

            return $dados;
        } else if ($opc2 == 'nao' && $id_usuario[0] == 'coordenador') {
            // Consulta na tabela de líderes entre datas
            $data_inicio = $datas['dataInicio']; // antiga
            $data_final = $datas['dataFim']; // atual

            $id_coordenador = $id_usuario[1];

            $consultar_lideres = $this->db->query("SELECT * FROM lider WHERE id_coordenador = '$id_coordenador' AND data_cadastro BETWEEN '$data_inicio' AND '$data_final' ORDER BY nome_lider ASC");
            $row = $consultar_lideres->num_rows();
            $dados_consulta_lideres = $consultar_lideres->result_array();

            /*$dados = array(
                'row' => 0,
                'dados' => [],
            );*/

            $dados = array(
                'row' => $row,
                'dados' => $dados_consulta_lideres,
            );
            return $dados;
        } else if ($opc2 == 'sim' && $id_usuario[0] == 'coordenador') {
            // Consulta na tabela de líderes entre datas geral
            $id_coordenador = $id_usuario[0];

            //$data_inicio = $datas['dataInicio']; // antiga
            //$data_final = $datas['dataFim']; // atual

            $data_inicio_menos_um_ano = $datas['dataInicioAnoPassado']; // antiga - menos um ano
            $data_final_menos_um_ano = $datas['dataFimAnoPassado']; // atual - menos um ano

            /*$consultar_lideres = $this->db->query("SELECT * FROM lider WHERE id_coordenador = '$id_coordenador' AND data_cadastro BETWEEN '$data_inicio' AND '$data_final' ORDER BY nome_lider ASC");
            $row_4 = $consultar_lideres->num_rows();
            $dados_consulta_lideres = $consultar_lideres->result_array();

            $dados = array(
                'row' => $row_4,
                'dados' => $dados_consulta_lideres,
            );
            $lideresAtivos = $this->lideresAtivos($dados);
            array_push($dados, $lideresAtivos);

            $lista_de_id_1 = $this->FSistema_model->retornando_so_id('id_lider', $dados['dados']);
            $total_criancas_lider = $this->getNumerosCriancas($id_usuario, $lista_de_id_1, 'direcao');
            array_push($dados, $total_criancas_lider);

            $lista_de_id_1_ativos = $this->FSistema_model->retornando_so_id('id_lider', $lideresAtivos['dados']);
            $total_criancas_lider_ativos = $this->getNumerosCriancas($id_usuario, $lista_de_id_1_ativos, 'direcao');
            array_push($dados, $total_criancas_lider_ativos);*/

            // comparação do ano passado
            $consultar_lider_mesmo_ano = $this->db->query("SELECT * FROM lider WHERE id_coordenador = '$id_coordenador' AND data_cadastro BETWEEN '$data_inicio_menos_um_ano' AND '$data_final_menos_um_ano' ORDER BY nome_lider ASC");
            $row_1_mesmo_ano = $consultar_lider_mesmo_ano->num_rows();
            $dados_consulta_lider_mesmo_ano = $consultar_lider_mesmo_ano->result_array();

            $dados1_mesmo_ano = array(
                'row' => $row_1_mesmo_ano,
                'dados' => $dados_consulta_lider_mesmo_ano,
            );

            /*$lideresAtivos_mesmo_ano = $this->lideresAtivos($dados1_mesmo_ano);
            array_push($dados, $dados1_mesmo_ano); // lideres comparados ao ao passado
            array_push($dados, $lideresAtivos_mesmo_ano); // lideres ativos comparado ao ano passado

            $lista_de_id_1_mesmo_ano = $this->FSistema_model->retornando_so_id('id_lider', $dados1_mesmo_ano['dados']);
            $total_criancas_lider_mesmo_ano = $this->getNumerosCriancas($id_usuario, $lista_de_id_1_mesmo_ano, 'direcao');
            array_push($dados, $total_criancas_lider_mesmo_ano);

            $lista_de_id_1_ativos_mesmo_ano = $this->FSistema_model->retornando_so_id('id_lider', $lideresAtivos_mesmo_ano['dados']);
            $total_criancas_lider_ativos_mesmo_ano = $this->getNumerosCriancas($id_usuario, $lista_de_id_1_ativos_mesmo_ano, 'direcao');
            array_push($dados, $total_criancas_lider_ativos_mesmo_ano);*/

            return $dados1_mesmo_ano;
        }
    }

    public function lideresAtivos($list)
    {
        $lista = $list['dados'];
        $total_ativos = 0;
        $dados_lider = [];

        if ($list['row'] == 0) {
        } else {
            foreach ($lista as $key => $lideres) {
                $id_lider = $lideres['id_lider'];
                $ativo = $lideres['confirmado'];
                $data_cadastro = $lideres['data_cadastro'];

                $check = $this->check_lider_is_ativo($id_lider, $data_cadastro, $ativo);

                if (!$check) {
                } else {
                    // líder novo
                    array_push($dados_lider, $lideres);
                    $total_ativos = $total_ativos + 1;
                }
            }
        }

        $dados = array(
            'row' => $total_ativos,
            'dados' => $dados_lider,
        );
        return $dados;
    }
    public function check_lider_is_ativo($id_lider, $data_cadastro, $ativo)
    {
        $data = date('Y-m-d');
        $data_mais_um_mes = date('Y-m-d', strtotime('+1 month', strtotime($data_cadastro)));

        $qtd_criancas = $this->FConsultas_model->mostrarCriancasPais($id_lider);
        $qtd_criancas_ativas = $this->FConsultas_model->mostrarCriancasPais($id_lider);

        $pgs = $this->PG->query([$id_lider], 1, 1);

        if ($ativo == 0 || $ativo == 1 || $ativo == 3) {
            return false;
        } else {
            if (strtotime($data_mais_um_mes) > strtotime($data)) {
                return true;
            } else {
                if ($pgs['row'] == 0 && $qtd_criancas_ativas['row'] == 0 && $qtd_criancas['row'] == 0) {
                    // inativo por n ter pg e nem crianças
                    return false;
                } else {
                    $id_modulo = $pgs['dados']['id_modulo'] ?? 1;
                    $numero_licao = $pgs['dados']['n_licao'] ?? 1;
                    $modulo = $this->FConsultas_model->consultarModuloId($id_modulo);
                    $progresso = $this->PG->consultarProgressoGeral($id_lider, 2);
                    $data_ultimo_relatorio = "";
                    $i = 0;
                    foreach ($progresso['dados'] as $key => $p) {
                        $data_ultimo = $p['data_aula'];
                        $i++;
                        if ($i == $progresso['row']) {
                            $data_ultimo_relatorio = $data_ultimo;
                        }
                    }

                    if ($data_ultimo_relatorio == '') {
                        // inativo por não preenchimento de relatórios
                        return false;
                    } else {
                        $data_convertida = $this->FConsultas_model->converterData($data_ultimo_relatorio);
                        $data_mais_2_meses = date('Y-m-d', strtotime('+2 months', strtotime($data_convertida)));

                        if (strtotime($data_mais_2_meses) < strtotime($data)) {
                            // inativo por ter passado mais de 2 meses inativos
                            return false;
                        } else if ($id_modulo == 10 && $numero_licao == $modulo['n_licao']) {
                            return true;
                        } else {
                            return true;
                        }
                    }
                }
            }
        }
    }

    public function check_cadastro($opc, $data)
    {
        if ($opc == 'consultar_por_2_cpf_email_nome') {
            $nome = $data[0];
            $cpf = $data[1];
            $cpf2 = $data[2];
            $email = $data[3];

            $consultar_1 = $this->db->query("SELECT * FROM lider WHERE nome_lider LIKE '$nome' OR cpf = '$cpf' OR cpf = '$cpf2' OR email = '$email'");
            $row_1 = $consultar_1->num_rows();

            $consultar_2 = $this->db->query("SELECT * FROM coordenador WHERE nome_coordenador LIKE '$nome' OR cpf = '$cpf' OR cpf = '$cpf2' OR email = '$email'");
            $row_2 = $consultar_2->num_rows();

            $consultar_3 = $this->db->query("SELECT * FROM supervisor_local WHERE nome_supervisorR LIKE '$nome' OR cpf = '$cpf' OR cpf = '$cpf2' OR email = '$email'");
            $row_3 = $consultar_3->num_rows();

            $consultar_4 = $this->db->query("SELECT * FROM supervisor_regional WHERE nome_supervisorE LIKE '$nome' OR cpf = '$cpf' OR cpf = '$cpf2' OR email = '$email'");
            $row_4 = $consultar_4->num_rows();

            $consultar_5 = $this->db->query("SELECT * FROM direcao WHERE nome_direcao LIKE '$nome' OR cpf = '$cpf' OR cpf = '$cpf2' OR email = '$email'");
            $row_5 = $consultar_5->num_rows();

            if ($row_1 != 0 || $row_2 != 0 || $row_3 != 0 || $row_4 != 0 || $row_5 != 0) {
                return 1;
            } else {
                return 0;
            }
        } else if ($opc == 'consultar_por_email_nome_data_nascimento') {
            $nome = $data[0];
            $email = $data[1];
            $data_nascimento = $data[2];

            $consultar_1 = $this->db->query("SELECT * FROM lider WHERE nome_lider LIKE '$nome' OR email = '$email' OR nascimento = '$data_nascimento'");
            $row_1 = $consultar_1->num_rows();

            $consultar_2 = $this->db->query("SELECT * FROM coordenador WHERE nome_coordenador LIKE '$nome' OR email = '$email' OR nascimento = '$data_nascimento'");
            $row_2 = $consultar_2->num_rows();

            $consultar_3 = $this->db->query("SELECT * FROM supervisor_local WHERE nome_supervisorR LIKE '$nome' OR email = '$email' OR nascimento = '$data_nascimento'");
            $row_3 = $consultar_3->num_rows();

            $consultar_4 = $this->db->query("SELECT * FROM supervisor_regional WHERE nome_supervisorE LIKE '$nome' OR email = '$email' OR nascimento = '$data_nascimento'");
            $row_4 = $consultar_4->num_rows();

            $consultar_5 = $this->db->query("SELECT * FROM direcao WHERE nome_direcao LIKE '$nome' OR email = '$email' OR nascimento = '$data_nascimento'");
            $row_5 = $consultar_5->num_rows();

            if ($row_1 != 0 || $row_2 != 0 || $row_3 != 0 || $row_4 != 0 || $row_5 != 0) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    public function check_cadastro_usuario($opc, $data)
    {
        if ($opc == 'check_nome_2_cpf_email') {
            $nome = $data[0];
            $cpf = $data[1];
            $cpf2 = $data[2];
            $email = $data[3];

            $consultar = $this->db->query("SELECT * FROM usuario WHERE nome LIKE '$nome' OR cpf = '$cpf' OR cpf = '$cpf2' OR email = '$email'");
            $row = $consultar->num_rows();

            return $row;
        } else if ($opc == 'check_nome_email') {
            $nome = $data[0];
            $email = $data[1];
            $consultar = $this->db->query("SELECT * FROM usuario WHERE nome LIKE '$nome' OR email = '$email'");
            $row = $consultar->num_rows();

            return $row;
        }
    }
    public function cadastro_lider($nome, $cpf, $email, $telefone, $igreja, $nascimento, $id_pastor, $pais, $estado, $cidade, $id_coordenador, $id_slocal, $id_sregional, $confirmado)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $data = date('d/m/Y'); // tirar
        $data_2 = date('Y-m-d');

        $foto = "fotoU/geral.jpg";

        $inserir['nome_lider'] = $nome;
        $inserir['cpf'] = $cpf;
        $inserir['email'] = $email;
        $inserir['telefone_whatsapp'] = $telefone;
        $inserir['igreja'] = $igreja;
        $inserir['nascimento'] = $nascimento;
        $inserir['id_pastor'] = $id_pastor;
        $inserir['pais'] = $pais;
        $inserir['estado'] = $estado;
        $inserir['cidade'] = $cidade;
        $inserir['id_coordenador'] = $id_coordenador;
        $inserir['id_supervisorR'] = $id_slocal;
        $inserir['id_supervisorE'] = $id_sregional;
        $inserir['foto'] = $foto;
        $inserir['foto_2'] = '';
        $inserir['confirmado'] = $confirmado;
        $inserir['data'] = $data;
        $inserir['data_cadastro'] = $data_2;

        if ($this->db->insert("lider", $inserir)) {
            return true;
        } else {
            return false;
        }
    }

    public function editar_autorizacao_lider($id_lider, $x)
    {
        $this->db->set('confirmado', $x);
        $this->db->where('id_lider', $id_lider);

        if ($this->db->update('lider')) {
            return true;
        } else {
            return false;
        }
    }

    public function desativar_lider($id_lider)
    {
        $ativo = "3";

        $this->db->set('confirmado', $ativo);
        $this->db->where('id_lider ', $id_lider);

        if ($this->db->update('lider')) {
            return true;
        } else {
            return false;
        }
    }

    public function ativar_lider($id_lider)
    {
        $ativo = "2";

        $this->db->set('confirmado', $ativo);
        $this->db->where('id_lider ', $id_lider);

        if ($this->db->update('lider')) {
            return true;
        } else {
            return false;
        }
    }

    public function excluir_lider_permanentemente($id_lider, $id_responsavel, $motivo)
    {
        $acao = "EX_CL_4";
        $motivo = "Excluiu seu Líder Permanentemente, motivo ($motivo)";

        date_default_timezone_set('America/Sao_Paulo');
        $data = date('d/m/Y');

        $dados_lider = $this->FConsultas_model->getInfoLiderId($id_lider);

        $consultar_pg_desativado = $this->db3->query("SELECT * FROM alcancado_lider WHERE id_lider LIKE $id_lider");
        $row = $consultar_pg_desativado->num_rows();

        if ($row == 0) {
            //$inserir['id_exclusao'] = NULL;
            $inserir['id_lider'] = $id_lider;
            $inserir['nome_lider'] = $dados_lider['dados']['nome_lider'];
            $inserir['id_responsavel'] = $id_responsavel;
            $inserir['motivo'] = $motivo;
            $inserir['data_saida'] = $data;

            if ($this->db3->insert('alcancado_lider', $inserir)) {
            }
        } else {
        }

        $this->db->where('id_lider', $id_lider);
        if ($this->db->delete('lider')) {
            $this->FAlerta_model->alerta_controle($id_responsavel, $id_lider, $motivo, $acao);
            return true;
        } else {
            return false;
        }
    }

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
}
