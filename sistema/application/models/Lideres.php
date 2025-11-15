<?php

/**
 * @property $db
 * @property $db3
 * @property $load
 * @property $uri
 * @property $FAlerta_model
 * @property $Criancas
 * @property $PG
 * @property $FConsultas_model
 */

class Lideres extends CI_Model
{
    public function infos($id_usuario, $opc, $order, $datas)
    {
        if ($opc == 'info_lider') { // ok
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
        } else if ($opc == 'info_lider_or_email_cpf_nome') { // ok
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
        } else if ($opc == 'info_lider_email_cpf') { // ok
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
        } else if ($opc == 'info_lider_nome_email_data_nascimento') { // ok
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
        } else if ($opc == 'info_usuario_and_email_cpf_nome') { // ok
            $email = $id_usuario[0];
            $cpf = $id_usuario[1];
            $nome = $id_usuario[2];
            $consultar_usuario = $this->db->query("SELECT * FROM usuario WHERE email = '$email' AND cpf = '$cpf' AND nome LIKE '$nome'");
            $dados_usuario = $consultar_usuario->row_array();
            $total_usuario = $consultar_usuario->num_rows();

            $dados = array(
                'row' => $total_usuario,
                'dados' => $dados_usuario,
            );

            return $dados;
        } else if ($opc == 'info_usuario_or_email_cpf_nome') { // ok
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
        } else if ($opc == 'info_usuario_and_email_cpf') { // ok
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
        } else if ($opc == 'info_usuario_or_email_nome') { // ok
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
        } else if ($opc == 'info_usuario_id_usuario') { // ok
            $id = $id_usuario[0];
            $consultar_lider = $this->db->query("SELECT * FROM usuario WHERE id_usuario = '$id'");
            $row = $consultar_lider->num_rows();
            $dados_consulta_lideres = $consultar_lider->row_array();

            $dados = array(
                'row' => $row,
                'dados' => $dados_consulta_lideres,
            );

            return $dados;
        } else if ($opc == 'query_lideres_id_coordenador') { // ok
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
        } else if ($opc == 'query_lideres_id_coordenador_datas_order_by_nome_lider') {  // ok // query_coordenador_supervisor_inicial
            // retornando todos os lideres do coordenador de acordo com uma data específica
            $id_usuario = $id_usuario[0];
            $data_1 = $datas['data_1']; // antiga
            $data_2 = $datas['data_2']; // atual

            $consultar_coordenador = $this->db->query("SELECT * FROM lider WHERE id_coordenador = $id_usuario AND data_cadastro BETWEEN '$data_1' AND '$data_2' ORDER BY nome_lider $order");
            $row = $consultar_coordenador->num_rows();
            $dados_consulta_coordenador = $consultar_coordenador->result_array();

            $dados = array(
                'row' => $row,
                'dados' => $dados_consulta_coordenador,
            );

            return $dados;
        } else if ($opc == 'query_lideres_id_coordenador_order_by_nome_lider') { // ok // query_coordenador_supervisor_inicial_2
            // retornando todos os lideres do coordenador
            $id_usuario = $id_usuario[0];

            $consultar_coordenador = $this->db->query("SELECT * FROM lider WHERE id_coordenador = $id_usuario ORDER BY nome_lider $order");
            $row = $consultar_coordenador->num_rows();
            $dados_consulta_coordenador = $consultar_coordenador->result_array();

            $dados = array(
                'row' => $row,
                'dados' => $dados_consulta_coordenador,
            );

            return $dados;
        } else if ($opc == 'query_lideres_id_coordenador_situacao_order_by_nome_lider') { // check_lider_situacao_cadastro_id_coordenador
            // Consulta na tabela de líderes se tem lider esperando autorização pelo ID COORDENADOR
            $id_coordenador = $id_usuario[0];
            $situacao = $id_usuario[1];
            $consultar_lider = $this->db->query("SELECT * FROM lider WHERE id_coordenador = '$id_coordenador' AND confirmado = $situacao ORDER BY nome_lider $order");
            $row = $consultar_lider->num_rows();
            $dados_consulta_lideres = $consultar_lider->result_array();

            $dados = array(
                'row' => $row,
                'dados' => $dados_consulta_lideres,
            );

            return $dados;
        } else if ($opc == 'query_lideres_id_supervisor_situacao_order_by_nome_lider') { // check_lider_situacao_cadastro_id_supervisor
            // Consulta na tabela de líderes se tem lider esperando autorização pelo ID SUPERVISOR
            $id_supervisor = $id_usuario[0];
            $situacao = $id_usuario[1];
            $consultar_lider = $this->db->query("SELECT * FROM lider WHERE id_supervisorR = '$id_supervisor' AND confirmado = $situacao ORDER BY nome_lider $order");
            $row = $consultar_lider->num_rows();
            $dados_consulta_lideres = $consultar_lider->result_array();

            $dados = array(
                'row' => $row,
                'dados' => $dados_consulta_lideres,
            );

            return $dados;
        } else if ($opc == 'query_all_lider_br') { // ok
            $dados = $this->db->query("SELECT * FROM lider WHERE confirmado LIKE 2 AND pais LIKE 'br'")->result_array();
            return $dados;
        }
    }

    public function lideresAtivos($list)
    {
        $lista = $list['dados'];
        $dados_lider = [];
        $total_ativos = 0;

        if ($list['row'] == 0) {
            return ['row' => 0, 'dados' => []];
        }

        // 🔹 1. Coleta todos os IDs de líderes de uma vez
        $ids = array_column($lista, 'id_lider');
        if (empty($ids)) {
            return ['row' => 0, 'dados' => []];
        }

        // 🔹 2. Busca todas as crianças desses líderes de uma vez
        $criacas_por_lider = $this->Criancas->criacasPorLideres($ids);

        // 🔹 3. Busca todos os progressos de uma vez
        $progresso_por_lider = $this->PG->progressoPorLideres($ids);

        // 🔹 4. Itera pelos líderes e checa se cada um é ativo
        foreach ($lista as $lider) {
            $id_lider = $lider['id_lider'];
            $ativo = $lider['confirmado'];
            $data_cadastro = $lider['data_cadastro'];

            $check = $this->check_lider_is_ativo_otimizado(
                $id_lider,
                $data_cadastro,
                $ativo,
                $criacas_por_lider,
                $progresso_por_lider
            );

            if ($check) {
                $dados_lider[] = $lider;
                $total_ativos++;
            }
        }

        return [
            'row' => $total_ativos,
            'dados' => $dados_lider
        ];
    }
    public function check_lider_is_ativo_otimizado($id_lider, $data_cadastro, $ativo, $criacas_por_lider, $progresso_por_lider)
    {
        $data = date('Y-m-d');
        $data_mais_um_mes = date('Y-m-d', strtotime('+1 month', strtotime($data_cadastro)));

        // 🔸 Inativo pelos status
        if (in_array($ativo, [0, 1, 3])) {
            return 0;
        }

        // 🔸 Ativo por ser novo (menos de 1 mês)
        if (strtotime($data_mais_um_mes) > strtotime($data)) {
            return 1;
        }

        // 🔸 Busca os dados em cache (sem nova query)
        $tem_criancas = !empty($criacas_por_lider[$id_lider]);
        $progresso = $progresso_por_lider[$id_lider] ?? [];

        // 🔸 Se não tem PG, nem crianças, nem progresso → inativo
        if (!$tem_criancas && empty($progresso)) {
            return 0;
        }

        // 🔸 Busca data do último relatório
        $datas = array_column($progresso, 'data_aula');
        if (empty($datas)) {
            return 0;
        }

        rsort($datas);
        $data_ultimo_relatorio = $datas[0];
        //$data_ultimo_relatorio = $data_ultimo_relatorio == '' ? "zero" : $data_ultimo_relatorio;

        $data_convertida = $this->FConsultas_model->converterData($data_ultimo_relatorio);
        if ($data_convertida === false) {
            // data inválida: decide o que fazer (aqui tratamos como inativo)
            // opcional: error_log("Data inválida para líder $id_lider: $data_ultimo_relatorio");
            return 0;
        }
        $data_mais_2_meses = date('Y-m-d', strtotime('+2 months', strtotime($data_convertida)));

        // 🔸 Inativo se passou mais de 2 meses sem relatório
        if (strtotime($data_mais_2_meses) < strtotime($data)) {
            return 0;
        }

        return 1;
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

    public function check_colider($nome, $cpf, $email, $telefone)
    {
        $consultar_colider = $this->db->query("SELECT * FROM colider WHERE nome_colider LIKE '$nome' OR email LIKE '$email' OR cpf LIKE '$cpf' OR telefone_whatsapp LIKE '$telefone'");
        $row = $consultar_colider->num_rows();
        return $row;
    }

    public function mostrar_colider_do_lider($id_usuario)
    {
        $consultar_colider = $this->db->query("SELECT * FROM colider WHERE id_lider LIKE $id_usuario AND ativo = 1 ORDER BY nome_colider ASC");
        $row = $consultar_colider->num_rows();
        $dados_consula_colider = $consultar_colider->row_array();

        if ($row == 0) {
            return false;
        } else {
            return $dados_consula_colider;
        }
    }

    public function mostrar_colider_do_lider_desativados($id_usuario)
    {
        $consultar_colider = $this->db->query("SELECT * FROM colider WHERE id_lider LIKE $id_usuario AND ativo = 0 ORDER BY nome_colider ASC");
        $row = $consultar_colider->num_rows();
        $dados_consula_colider = $consultar_colider->result_array();

        $dados = array(
            'row' => $row,
            'dados' => $dados_consula_colider,
        );

        return $dados;
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

    public function editar_lider($id, $nome, $cpf, $email, $telefone, $igreja, $nascimento, $pais, $estado, $cidade, $ativo, $id_coordenador, $id_supervisor, $foto)
    {
        $this->db->set('nome_lider', $nome);
        $this->db->set('cpf', $cpf);
        $this->db->set('email', $email);
        $this->db->set('telefone_whatsapp', $telefone);
        $this->db->set('igreja', $igreja);
        $this->db->set('nascimento', $nascimento);
        $this->db->set('pais', $pais);
        $this->db->set('estado', $estado);
        $this->db->set('cidade', $cidade);
        $this->db->set('id_coordenador', $id_coordenador);
        $this->db->set('id_supervisorR', $id_supervisor);
        $this->db->set('id_supervisorE', $id_supervisor);
        $this->db->set('foto', $foto);
        $this->db->set('confirmado', $ativo);
        $this->db->where('id_lider', $id);

        if ($this->db->update('lider')) {
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

        $dados_lider = $this->Lideres->infos([$id_lider], 'info_lider', '', '', '');

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

    // EDITAR COLIDER
    public function editarColider($id, $nome, $cpf, $email, $telefone, $nascimento, $foto)
    {
        $this->db->set('nome_colider', $nome);
        $this->db->set('cpf', $cpf);
        $this->db->set('email', $email);
        $this->db->set('telefone_whatsapp', $telefone);
        $this->db->set('nascimento', $nascimento);
        $this->db->set('foto', $foto);
        $this->db->where('id_colider', $id);

        if ($this->db->update('colider')) {
            return true;
        } else {
            return false;
        }
    }

    // EXCLUSÃO
    public function excluirColider($id_colider, $nome_colider, $id_lider, $id_responsavel, $motivo)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $data = date('d/m/Y');

        $ativo = "0";
        $acao = "EX_CL_1";

        $inserir['id_exclusao'] = NULL;
        $inserir['id_colider'] = $id_colider;
        $inserir['nome_colider'] = $nome_colider;
        $inserir['id_lider'] = $id_lider;
        $inserir['id_responsavel'] = $id_responsavel;
        $inserir['motivo'] = $motivo;
        $inserir['data_saida'] = $data;

        if ($this->db3->insert('alcancado_colider', $inserir)) {

            $this->db->set('ativo', $ativo);
            $this->db->where('id_colider', $id_colider);

            if ($this->db->update('colider')) {
                $this->FAlerta_model->alerta_controle($id_responsavel, $id_colider, $motivo, $acao);
                //$this->FAlerta_model->alerta_para_coordenador($id_responsavel, $id_colider, $motivo, $acao);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    // REATIVAR
    public function reativarColider($id_colider, $id_responsavel)
    {
        $ativo = "1";
        $acao = "RE_CL_1";
        $motivo = "Reativou seu colíder";

        $this->db->set('ativo', $ativo);
        $this->db->where('id_colider', $id_colider);

        if ($this->db->update('colider')) {
            $this->excluirColiderAlcancado($id_colider);
            $this->FAlerta_model->alerta_controle($id_responsavel, $id_colider, $motivo, $acao);
            return true;
        } else {
            return false;
        }
    }

    public function excluirColiderPermanentemente($id_colider, $id_lider, $id_responsavel)
    {
        $acao = "EX_P_CL_1";
        $motivo = "Excluiu seu Colider Permanentemente";

        date_default_timezone_set('America/Sao_Paulo');
        $data = date('d/m/Y');

        $dadosColider = $this->FConsultas_model->getNomeUserId($id_colider);

        $consultar_pg_desativado = $this->db3->query("SELECT * FROM alcancado_colider WHERE id_colider = '$id_colider'");
        $row = $consultar_pg_desativado->num_rows();

        if ($row == 0) {
            $inserir['id_exclusao'] = NULL;
            $inserir['id_colider'] = $id_colider;
            $inserir['nome_colider'] = $dadosColider['nome'];
            $inserir['id_lider'] = $id_lider;
            $inserir['id_responsavel'] = $id_responsavel;
            $inserir['motivo'] = $motivo;
            $inserir['data_saida'] = $data;

            if ($this->db3->insert('alcancado_colider', $inserir)) {
            }
        } else {
        }

        $this->db->where('id_colider', $id_colider);

        if ($this->db->delete('colider')) {
            $this->FAlerta_model->alerta_controle($id_responsavel, $id_colider, $motivo, $acao);
            return true;
        } else {
            return false;
        }
    }
    // Fim EXCLUSÂO

    // EXCLUSÃO ALCANÇADO
    public function excluirColiderAlcancado($id_colider)
    {
        $this->db3->where('id_colider', $id_colider);

        if ($this->db3->delete('alcancado_colider')) {
            return true;
        } else {
            return false;
        }
    }

    // trocar coordenação
    public function trocar_coordenacao_do_lider($id_coordenador, $id_novo_coordenador)
    {
        $this->db->set('id_coordenador', $id_novo_coordenador);
        $this->db->where('id_coordenador', $id_coordenador);
        $this->db->update('lider');
    }

    // usuário
    public function cadastrarUsuário($nome_usuario, $email, $cpf, $nivel, $senha)
    {
        $ativo = "0";

        $inserir['id_usuario'] = NULL;
        $inserir['nome'] = $nome_usuario;
        $inserir['email'] = $email;
        $inserir['cpf'] = $cpf;
        $inserir['senha'] = $senha;
        $inserir['nivel'] = $nivel;
        $inserir['ativo'] = $ativo;

        if ($this->db->insert('usuario', $inserir)) {
            return true;
        } else {
            return false;
        }
    }

    public function editar_usuario($id_usuario, $nome_usuario, $email, $cpf, $senha)
    {
        $this->db->set('nome', $nome_usuario);
        $this->db->set('cpf', $cpf);
        $this->db->set('email', $email);
        $this->db->set('senha', $senha);
        $this->db->where('id_usuario', $id_usuario);

        if ($this->db->update('usuario')) {
            return true;
        } else {
            return false;
        }
    }

    public function excluirUsuário($email, $cpf)
    {
        $this->db->where('cpf', $cpf);
        $this->db->where('email', $email);

        if ($this->db->delete('usuario')) {
            return true;
        } else {
            return false;
        }
    }

    public function excluirUsuarioPermanentemente($nome_usuario, $email, $cpf)
    {
        $user = $this->infos([$email, $cpf, $nome_usuario], 'info_usuario_and_email_cpf_nome', '', '');
        $this->db->where('id_usuario ', $user['dados']['id_usuario']);
        if ($this->db->delete('usuario')) {
            return true;
        } else {
            return false;
        }
    }

    public function ativarUsuario($nome_usuario, $email, $cpf)
    {
        $ativo = "1";

        $user = $this->infos([$email, $cpf, $nome_usuario], 'info_usuario_and_email_cpf_nome', '', '');
        $row = $user['row'];

        if ($row == 0) {
            return false;
        } else {
            $this->db->set('ativo', $ativo);
            $this->db->where('id_usuario ', $user['dados']['id_usuario']);

            if ($this->db->update('usuario')) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function desativarUsuário($nome_usuario, $email, $cpf)
    {
        $ativo = "0";

        $user = $this->infos([$email, $cpf, $nome_usuario], 'info_usuario_and_email_cpf_nome', '', '');
        $row = $user['row'];

        if ($row == 0) {
            return false;
        } else {
            $this->db->set('ativo', $ativo);
            $this->db->where('id_usuario ', $user['dados']['id_usuario']);
            if ($this->db->update('usuario')) {
                return true;
            } else {
                return false;
            }
        }
    }
}
