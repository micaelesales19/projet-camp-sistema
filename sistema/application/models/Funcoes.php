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

    // SUPERVISORES
    public function consultasBDSupervisorGeral()
    {
        $list_supervisores = [];
        $list_supervisores_comparacao = [];

        // consulta supervisores do período atual
        $supervisores = $this->db->query("
            SELECT * FROM supervisor_local
            ORDER BY nome_supervisorR ASC
        ")->result_array();

        $total_supervisores_ativos = 0;

        foreach ($supervisores as $s) {
            $id_supervisor = $s['id_supervisorR'];
            $ativo = $s['ativo'];

            $check_supervisor_ativo = $this->Supervisores->check_supervisor_ativo($id_supervisor, $ativo);

            $coordenadores = $this->db->query("
                SELECT * FROM coordenador
                WHERE id_supervisorR = $id_supervisor
                ORDER BY nome_coordenador ASC
            ")->result_array();

            $total_coordenadores_ativos = 0;

            foreach ($coordenadores as $c) {

                $id_coordenador = $c['id_coordenador'];
                $ativo = $c['ativo'];
                $check_coordenador_ativo = $this->Coordenadores->check_coordenador_ativo($id_coordenador, $ativo);

                $total_coordenadores_ativos = $total_coordenadores_ativos + $check_coordenador_ativo;
            }

            // crianças e crianças ativas usando uma única query por coordenador
            $total_criancas = 0;
            $total_criancas_ativos = 0;

            // líderes e líderes ativos
            $lideres_info = $this->Lideres->infos([$id_supervisor], 'query_lideres_id_supervisor', '', '', []);
            $lideres_ativos_info = $this->Lideres->lideresAtivos($lideres_info);

            if (!empty($lideres_info['dados'])) {
                $ids_lideres = array_column($lideres_info['dados'], 'id_lider');
                $ids_lideres_str = implode(',', array: $ids_lideres);

                // total crianças
                $query_criancas = $this->db->query("
                SELECT lider, COUNT(*) AS total
                FROM criancas
                WHERE lider IN ($ids_lideres_str)
                GROUP BY lider
            ")->result_array();

                $total_criancas = array_sum(array_column($query_criancas, 'total'));

                // total crianças líderes ativos
                if (!empty($lideres_ativos_info['dados'])) {
                    $ids_lideres_ativos = array_column($lideres_ativos_info['dados'], 'id_lider');
                    $ids_lideres_ativos_str = implode(',', $ids_lideres_ativos);

                    $query_criancas_ativos = $this->db->query("
                    SELECT lider, COUNT(*) AS total
                    FROM criancas
                    WHERE lider IN ($ids_lideres_ativos_str)
                    GROUP BY lider
                ")->result_array();
                    $total_criancas_ativos = array_sum(array_column($query_criancas_ativos, 'total'));
                }
            }

            // adiciona os totais ao coordenador
            $s['total_coordenadores'] = count($coordenadores);
            $s['total_coordenadores_ativos'] = $total_coordenadores_ativos;
            $s['total_lideres'] = $lideres_info['row'];
            $s['total_lideres_ativos'] = $lideres_ativos_info['row'];
            $s['total_criancas'] = $total_criancas;
            $s['total_criancas_ativos'] = $total_criancas_ativos;
            $s['check_supervisor_ativo'] = $check_supervisor_ativo;

            $list_supervisores[] = $s;
        }

        // comparação com o ano anterior, se necessário
        /*if ($opc2 == 'sim' && $opc3 == 'query_supervisor_inicial') {
            //if ($opc3 == 'query_supervisor_inicial') {
            $data_inicio_ano_passado = $datas['dataInicioAnoPassado'];
            $data_fim_ano_passado = $datas['dataFimAnoPassado'];
            $datas_2 = ['data_1' => $data_inicio_ano_passado, 'data_2' => $data_fim_ano_passado];

            $coordenadores_ano_passado = $this->db->query("
            SELECT * FROM coordenador
            WHERE id_supervisorR = $id_user
            AND data_cadastro BETWEEN '$data_inicio_ano_passado' AND '$data_fim_ano_passado'
            ORDER BY nome_coordenador ASC
        ")->result_array();

            foreach ($coordenadores_ano_passado as $c) {
                $id_coordenador = $c['id_coordenador'];

                $ativo = $c['ativo'];
                $check_coordenador_ativo = $this->Coordenadores->check_coordenador_ativo($id_coordenador, $ativo);

                $lideres_info = $this->Lideres->infos([$id_coordenador], 'query_lideres_id_coordenador_datas_order_by_nome_lider', '', 'asc', $datas_2);
                $lideres_ativos_info = $this->Lideres->lideresAtivos($lideres_info);

                $total_criancas = 0;
                $total_criancas_ativos = 0;

                if (!empty($lideres_info['dados'])) {
                    $ids_lideres = array_column($lideres_info['dados'], 'id_lider');
                    $ids_lideres_str = implode(',', $ids_lideres);

                    $query_criancas = $this->db->query("
                    SELECT lider, COUNT(*) AS total
                    FROM criancas
                    WHERE lider IN ($ids_lideres_str)
                    GROUP BY lider
                ")->result_array();
                    $total_criancas = array_sum(array_column($query_criancas, 'total'));

                    if (!empty($lideres_ativos_info['dados'])) {
                        $ids_lideres_ativos = array_column($lideres_ativos_info['dados'], 'id_lider');
                        $ids_lideres_ativos_str = implode(',', $ids_lideres_ativos);

                        $query_criancas_ativos = $this->db->query("
                        SELECT lider, COUNT(*) AS total
                        FROM criancas
                        WHERE lider IN ($ids_lideres_ativos_str)
                        GROUP BY lider
                    ")->result_array();
                        $total_criancas_ativos = array_sum(array_column($query_criancas_ativos, 'total'));
                    }
                }

                $c['total_lideres'] = $lideres_info['row'];
                $c['total_lideres_ativos'] = $lideres_ativos_info['row'];
                $c['total_criancas'] = $total_criancas;
                $c['total_criancas_ativos'] = $total_criancas_ativos;
                $c['check_coordenador_ativo'] = $check_coordenador_ativo;

                $list_coordenadores_comparacao[] = $c;
            }
        }*/

        return [
            'total_supervisores_ativos' => $total_supervisores_ativos,
            'dados_supervisores_gerais' => ['dados' => $list_supervisores],
            'dados_supervisores_gerais_comparacao' => ['dados' => $list_supervisores_comparacao],
        ];
    }

    public function consultasBDCoordenadordoSupervisor($id_user)
    {
        $list_coordenadores = [];
        $list_coordenadores_comparacao = [];

        // consulta coordenadores do período atual
        $coordenadores = $this->db->query("
            SELECT * FROM coordenador
            WHERE id_supervisorR = $id_user
            ORDER BY nome_coordenador ASC
        ")->result_array();

        $total_coordenadores_ativos = 0;

        foreach ($coordenadores as $c) {
            $id_coordenador = $c['id_coordenador'];
            $ativo = $c['ativo'];
            $check_coordenador_ativo = $this->Coordenadores->check_coordenador_ativo($id_coordenador, $ativo);

            $total_coordenadores_ativos = $total_coordenadores_ativos + $check_coordenador_ativo;
            // crianças e crianças ativas usando uma única query por coordenador
            $total_criancas = 0;
            $total_criancas_ativos = 0;

            // líderes e líderes ativos
            $lideres_info = $this->Lideres->infos([$id_coordenador], 'query_lideres_id_coordenador_order_by_nome_lider', 'asc', []);
            $lideres_ativos_info = $this->Lideres->lideresAtivos($lideres_info);

            if (!empty($lideres_info['dados'])) {
                $ids_lideres = array_column($lideres_info['dados'], 'id_lider');
                $ids_lideres_str = implode(',', array: $ids_lideres);

                // total crianças
                $query_criancas = $this->db->query("
                SELECT lider, COUNT(*) AS total
                FROM criancas
                WHERE lider IN ($ids_lideres_str)
                GROUP BY lider
            ")->result_array();
                $total_criancas = array_sum(array_column($query_criancas, 'total'));

                // total crianças líderes ativos
                if (!empty($lideres_ativos_info['dados'])) {
                    $ids_lideres_ativos = array_column($lideres_ativos_info['dados'], 'id_lider');
                    $ids_lideres_ativos_str = implode(',', $ids_lideres_ativos);

                    $query_criancas_ativos = $this->db->query("
                    SELECT lider, COUNT(*) AS total
                    FROM criancas
                    WHERE lider IN ($ids_lideres_ativos_str)
                    GROUP BY lider
                ")->result_array();
                    $total_criancas_ativos = array_sum(array_column($query_criancas_ativos, 'total'));
                }
            }

            // adiciona os totais ao coordenador
            //$c['total_lideres'] = 10;
            //$c['lista_lideres'] = $lideres_info;
            //$c['total_lideres_ativos'] = 10;
            $c['total_lideres'] = $lideres_info['row'];
            $c['total_lideres_ativos'] = $lideres_ativos_info['row'];
            $c['total_criancas'] = $total_criancas;
            $c['total_criancas_ativos'] = $total_criancas_ativos;
            $c['check_coordenador_ativo'] = $check_coordenador_ativo;

            $list_coordenadores[] = $c;
        }

        // comparação com o ano anterior, se necessário
        /*if ($opc2 == 'sim' && $opc3 == 'query_supervisor_inicial') {
            //if ($opc3 == 'query_supervisor_inicial') {
            $data_inicio_ano_passado = $datas['dataInicioAnoPassado'];
            $data_fim_ano_passado = $datas['dataFimAnoPassado'];
            $datas_2 = ['data_1' => $data_inicio_ano_passado, 'data_2' => $data_fim_ano_passado];

            $coordenadores_ano_passado = $this->db->query("
            SELECT * FROM coordenador
            WHERE id_supervisorR = $id_user
            AND data_cadastro BETWEEN '$data_inicio_ano_passado' AND '$data_fim_ano_passado'
            ORDER BY nome_coordenador ASC
        ")->result_array();

            foreach ($coordenadores_ano_passado as $c) {
                $id_coordenador = $c['id_coordenador'];

                $ativo = $c['ativo'];
                $check_coordenador_ativo = $this->Coordenadores->check_coordenador_ativo($id_coordenador, $ativo);

                $lideres_info = $this->Lideres->infos([$id_coordenador], 'query_lideres_id_coordenador_datas_order_by_nome_lider', '', 'asc', $datas_2);
                $lideres_ativos_info = $this->Lideres->lideresAtivos($lideres_info);

                $total_criancas = 0;
                $total_criancas_ativos = 0;

                if (!empty($lideres_info['dados'])) {
                    $ids_lideres = array_column($lideres_info['dados'], 'id_lider');
                    $ids_lideres_str = implode(',', $ids_lideres);

                    $query_criancas = $this->db->query("
                    SELECT lider, COUNT(*) AS total
                    FROM criancas
                    WHERE lider IN ($ids_lideres_str)
                    GROUP BY lider
                ")->result_array();
                    $total_criancas = array_sum(array_column($query_criancas, 'total'));

                    if (!empty($lideres_ativos_info['dados'])) {
                        $ids_lideres_ativos = array_column($lideres_ativos_info['dados'], 'id_lider');
                        $ids_lideres_ativos_str = implode(',', $ids_lideres_ativos);

                        $query_criancas_ativos = $this->db->query("
                        SELECT lider, COUNT(*) AS total
                        FROM criancas
                        WHERE lider IN ($ids_lideres_ativos_str)
                        GROUP BY lider
                    ")->result_array();
                        $total_criancas_ativos = array_sum(array_column($query_criancas_ativos, 'total'));
                    }
                }

                $c['total_lideres'] = $lideres_info['row'];
                $c['total_lideres_ativos'] = $lideres_ativos_info['row'];
                $c['total_criancas'] = $total_criancas;
                $c['total_criancas_ativos'] = $total_criancas_ativos;
                $c['check_coordenador_ativo'] = $check_coordenador_ativo;

                $list_coordenadores_comparacao[] = $c;
            }
        }*/

        return [
            'total_coordenadores_ativos' => $total_coordenadores_ativos,
            'dados_coordenadores_gerais' => ['dados' => $list_coordenadores],
            'dados_coordenadores_gerais_comparacao' => ['dados' => $list_coordenadores_comparacao],
        ];
    }

    // COORDENADORES
    public function consultasBDCoordenadoresGeral()
    {
        $list_coordenadores = [];
        $list_coordenadores_comparacao = [];

        // consulta coordenadores do período atual
        $coordenadores = $this->db->query("
            SELECT * FROM coordenador
            ORDER BY nome_coordenador ASC
        ")->result_array();

        $total_coordenadores_ativos = 0;

        foreach ($coordenadores as $c) {
            $id_coordenador = $c['id_coordenador'];
            $ativo = $c['ativo'];
            $check_coordenador_ativo = $this->Coordenadores->check_coordenador_ativo($id_coordenador, $ativo);

            $total_coordenadores_ativos = $total_coordenadores_ativos + $check_coordenador_ativo;
            // crianças e crianças ativas usando uma única query por coordenador
            $total_criancas = 0;
            $total_criancas_ativos = 0;

            // líderes e líderes ativos
            $lideres_info = $this->Lideres->infos([$id_coordenador], 'query_lideres_id_coordenador_order_by_nome_lider', '', 'asc', []);
            $lideres_ativos_info = $this->Lideres->lideresAtivos($lideres_info);

            if (!empty($lideres_info['dados'])) {
                $ids_lideres = array_column($lideres_info['dados'], 'id_lider');
                $ids_lideres_str = implode(',', array: $ids_lideres);

                // total crianças
                $query_criancas = $this->db->query("
                SELECT lider, COUNT(*) AS total
                FROM criancas
                WHERE lider IN ($ids_lideres_str)
                GROUP BY lider
            ")->result_array();
                $total_criancas = array_sum(array_column($query_criancas, 'total'));

                // total crianças líderes ativos
                if (!empty($lideres_ativos_info['dados'])) {
                    $ids_lideres_ativos = array_column($lideres_ativos_info['dados'], 'id_lider');
                    $ids_lideres_ativos_str = implode(',', $ids_lideres_ativos);

                    $query_criancas_ativos = $this->db->query("
                    SELECT lider, COUNT(*) AS total
                    FROM criancas
                    WHERE lider IN ($ids_lideres_ativos_str)
                    GROUP BY lider
                ")->result_array();
                    $total_criancas_ativos = array_sum(array_column($query_criancas_ativos, 'total'));
                }
            }

            // adiciona os totais ao coordenador
            //$c['total_lideres'] = 10;
            //$c['lista_lideres'] = $lideres_info;
            //$c['total_lideres_ativos'] = 10;
            $c['total_lideres'] = $lideres_info['row'];
            $c['total_lideres_ativos'] = $lideres_ativos_info['row'];
            $c['total_criancas'] = $total_criancas;
            $c['total_criancas_ativos'] = $total_criancas_ativos;
            $c['check_coordenador_ativo'] = $check_coordenador_ativo;

            $list_coordenadores[] = $c;
        }

        // comparação com o ano anterior, se necessário
        /*if ($opc2 == 'sim' && $opc3 == 'query_supervisor_inicial') {
            //if ($opc3 == 'query_supervisor_inicial') {
            $data_inicio_ano_passado = $datas['dataInicioAnoPassado'];
            $data_fim_ano_passado = $datas['dataFimAnoPassado'];
            $datas_2 = ['data_1' => $data_inicio_ano_passado, 'data_2' => $data_fim_ano_passado];

            $coordenadores_ano_passado = $this->db->query("
            SELECT * FROM coordenador
            WHERE id_supervisorR = $id_user
            AND data_cadastro BETWEEN '$data_inicio_ano_passado' AND '$data_fim_ano_passado'
            ORDER BY nome_coordenador ASC
        ")->result_array();

            foreach ($coordenadores_ano_passado as $c) {
                $id_coordenador = $c['id_coordenador'];

                $ativo = $c['ativo'];
                $check_coordenador_ativo = $this->Coordenadores->check_coordenador_ativo($id_coordenador, $ativo);

                $lideres_info = $this->Lideres->infos([$id_coordenador], 'query_lideres_id_coordenador_datas_order_by_nome_lider', '', 'asc', $datas_2);
                $lideres_ativos_info = $this->Lideres->lideresAtivos($lideres_info);

                $total_criancas = 0;
                $total_criancas_ativos = 0;

                if (!empty($lideres_info['dados'])) {
                    $ids_lideres = array_column($lideres_info['dados'], 'id_lider');
                    $ids_lideres_str = implode(',', $ids_lideres);

                    $query_criancas = $this->db->query("
                    SELECT lider, COUNT(*) AS total
                    FROM criancas
                    WHERE lider IN ($ids_lideres_str)
                    GROUP BY lider
                ")->result_array();
                    $total_criancas = array_sum(array_column($query_criancas, 'total'));

                    if (!empty($lideres_ativos_info['dados'])) {
                        $ids_lideres_ativos = array_column($lideres_ativos_info['dados'], 'id_lider');
                        $ids_lideres_ativos_str = implode(',', $ids_lideres_ativos);

                        $query_criancas_ativos = $this->db->query("
                        SELECT lider, COUNT(*) AS total
                        FROM criancas
                        WHERE lider IN ($ids_lideres_ativos_str)
                        GROUP BY lider
                    ")->result_array();
                        $total_criancas_ativos = array_sum(array_column($query_criancas_ativos, 'total'));
                    }
                }

                $c['total_lideres'] = $lideres_info['row'];
                $c['total_lideres_ativos'] = $lideres_ativos_info['row'];
                $c['total_criancas'] = $total_criancas;
                $c['total_criancas_ativos'] = $total_criancas_ativos;
                $c['check_coordenador_ativo'] = $check_coordenador_ativo;

                $list_coordenadores_comparacao[] = $c;
            }
        }*/

        return [
            'total_coordenadores_ativos' => $total_coordenadores_ativos,
            'dados_coordenadores_gerais' => ['dados' => $list_coordenadores],
            'dados_coordenadores_gerais_comparacao' => ['dados' => $list_coordenadores_comparacao],
        ];
    }

    public function consultasBDLideresCoordenador($id_user)
    {
        $list_lideres = [];

        // busca todos os líderes do coordenador
        $lideres_info = $this->Lideres->infos([$id_user], 'query_lideres_id_coordenador_order_by_nome_lider', '', 'asc', []);
        $lideres_ativos_info = $this->Lideres->lideresAtivos($lideres_info);

        if (!empty($lideres_info['dados'])) {
            // adiciona informações individuais por líder
            foreach ($lideres_info['dados'] as $lider) {
                $id_lider = $lider['id_lider'];

                $total_criancas_lider = 0;
                $total_criancas_ativas_lider = 0;

                // total de crianças desse líder
                $q1 = $this->db->query("
                SELECT COUNT(*) AS total
                FROM criancas
                WHERE lider = $id_lider
            ")->row_array();
                $total_criancas_lider = $q1['total'] ?? 0;

                // se o líder for ativo, conta crianças ativas também
                $lider_ativo = in_array($id_lider, array_column($lideres_ativos_info['dados'], 'id_lider'));
                if ($lider_ativo) {
                    $q2 = $this->db->query("
                    SELECT COUNT(*) AS total
                    FROM criancas
                    WHERE lider = $id_lider
                ")->row_array();
                    $total_criancas_ativas_lider = $q2['total'] ?? 0;
                }

                $lider['total_criancas'] = $total_criancas_lider;
                $lider['total_criancas_ativos'] = $total_criancas_ativas_lider;
                $lider['ativo'] = $lider_ativo ? 1 : 0;

                $list_lideres[] = $lider;
            }
        }
        return [
            'dados_lideres' => ['dados' => $list_lideres],
        ];
    }

    // LIDERES
    public function consultasBDLiderGeral()
    {
        $list_lideres = [];
        $list_lideres_comparacao = [];

        // Consulta líderes do supervisor
        $lideres = $this->db->query("
        SELECT * FROM lider
        ORDER BY nome_lider ASC
    ")->result_array();

        $lideres_info = array(
            'row' => count($lideres),
            'dados' => $lideres,
        );

        $lideres_ativos_info = $this->Lideres->lideresAtivos($lideres_info);

        $total_lideres_ativos = 0;

        // 🔹 1. Coleta todos os IDs de líderes de uma vez
        $ids = array_column($lideres, 'id_lider');
        /*if (empty($ids)) {
            return ['row' => 0, 'dados' => []];
        }*/

        // 🔹 2. Busca todas as crianças desses líderes de uma vez
        $criacas_por_lider = $this->Criancas->criacasPorLideres($ids);

        // 🔹 3. Busca todos os progressos de uma vez
        $progresso_por_lider = $this->PG->progressoPorLideres($ids);

        foreach ($lideres as $l) {
            $id_lider = $l['id_lider'];
            $ativo = $l['confirmado'];
            $data_cadastro = $l['data_cadastro'];

            // verifica se o líder está ativo (função já existente)
            $check_lider_ativo = $this->Lideres->check_lider_is_ativo_otimizado(
                $id_lider,
                $data_cadastro,
                $ativo,
                $criacas_por_lider,
                $progresso_por_lider
            );

            $total_lideres_ativos += $check_lider_ativo;

            // total de crianças do líder
            $query_criancas = $this->db->query("
            SELECT COUNT(*) AS total
            FROM criancas
            WHERE lider = $id_lider
        ")->row_array();
            $total_criancas = $query_criancas['total'] ?? 0;

            /*$total_criancas_ativas = 0;

            if ($check_lider_ativo == 0) {
            } else {*/
            // total de crianças ativas do líder
            $query_criancas_ativas = $this->db->query("
                    SELECT COUNT(*) AS total
                    FROM criancas
                    WHERE lider = $id_lider AND ativo = 1
                ")->row_array();
            $total_criancas_ativas = $query_criancas_ativas['total'] ?? 0;
            //}

            // adiciona os totais ao array do líder
            $l['total_criancas'] = $total_criancas;
            $l['total_criancas_ativos'] = $total_criancas_ativas;
            $l['check_lider_ativo'] = $check_lider_ativo;

            $list_lideres[] = $l;
        }

        // === COMPARAÇÃO COM O ANO ANTERIOR ===
        /*if ($opc2 == 'sim' && $opc3 == 'query_supervisor_inicial') {
            $data_inicio_ano_passado = $datas['dataInicioAnoPassado'];
            $data_fim_ano_passado = $datas['dataFimAnoPassado'];
            $datas_2 = ['data_1' => $data_inicio_ano_passado, 'data_2' => $data_fim_ano_passado];

            $lideres_ano_passado = $this->db->query("
            SELECT * FROM lider
            WHERE id_supervisorR = $id_user
            AND data_cadastro BETWEEN '$data_inicio_ano_passado' AND '$data_fim_ano_passado'
            ORDER BY nome_lider ASC
        ")->result_array();

            foreach ($lideres_ano_passado as $l) {
                $id_lider = $l['id_lider'];
                $ativo = $l['confirmado'];
                $data_cadastro = $l['data_cadastro'];

                // verifica se o líder está ativo (função já existente)
                $check_lider_ativo = $this->Lideres->check_lider_is_ativo_otimizado(
                    $id_lider,
                    $data_cadastro,
                    $ativo,
                    $criacas_por_lider,
                    $progresso_por_lider
                );

                // Total de crianças do ano passado
                $query_criancas = $this->db->query("
                SELECT COUNT(*) AS total
                FROM criancas
                WHERE lider = $id_lider
                AND data_cadastro BETWEEN '$data_inicio_ano_passado' AND '$data_fim_ano_passado'
            ")->row_array();
                $total_criancas = $query_criancas['total'] ?? 0;

                // Total de crianças ativas do ano passado
                $query_criancas_ativas = $this->db->query("
                SELECT COUNT(*) AS total
                FROM criancas
                WHERE lider = $id_lider
                AND ativo = 1
                AND data_cadastro BETWEEN '$data_inicio_ano_passado' AND '$data_fim_ano_passado'
            ")->row_array();
                $total_criancas_ativos = $query_criancas_ativas['total'] ?? 0;

                $l['total_criancas'] = $total_criancas;
                $l['total_criancas_ativos'] = $total_criancas_ativos;
                $l['check_lider_ativo'] = $check_lider_ativo;

                $list_lideres_comparacao[] = $l;
            }
        }*/

        return [
            'total_lideres' => count($lideres),
            'total_lideres_ativos' => $total_lideres_ativos,
            'dados_lideres_gerais' => ['dados' => $list_lideres],
            'dados_lideres_gerais_comparacao' => ['dados' => $list_lideres_comparacao], // deixei vazio, igual no original
        ];
    }

    public function consultasBDLider($id_user)
    {
        $list_lideres = [];
        $list_lideres_comparacao = [];

        // Consulta líderes do supervisor
        $lideres = $this->db->query("
        SELECT * FROM lider
        WHERE id_supervisorR = $id_user
        ORDER BY nome_lider ASC
    ")->result_array();

        $lideres_info = array(
            'row' => count($lideres),
            'dados' => $lideres,
        );

        $lideres_ativos_info = $this->Lideres->lideresAtivos($lideres_info);

        $total_lideres_ativos = 0;

        // 🔹 1. Coleta todos os IDs de líderes de uma vez
        $ids = array_column($lideres, 'id_lider');
        /*if (empty($ids)) {
            return ['row' => 0, 'dados' => []];
        }*/

        // 🔹 2. Busca todas as crianças desses líderes de uma vez
        $criacas_por_lider = $this->Criancas->criacasPorLideres($ids);

        // 🔹 3. Busca todos os progressos de uma vez
        $progresso_por_lider = $this->PG->progressoPorLideres($ids);

        foreach ($lideres as $l) {
            $id_lider = $l['id_lider'];
            $ativo = $l['confirmado'];
            $data_cadastro = $l['data_cadastro'];

            // verifica se o líder está ativo (função já existente)
            $check_lider_ativo = $this->Lideres->check_lider_is_ativo_otimizado(
                $id_lider,
                $data_cadastro,
                $ativo,
                $criacas_por_lider,
                $progresso_por_lider
            );

            $total_lideres_ativos += $check_lider_ativo;

            // total de crianças do líder
            $query_criancas = $this->db->query("
            SELECT COUNT(*) AS total
            FROM criancas
            WHERE lider = $id_lider
        ")->row_array();
            $total_criancas = $query_criancas['total'] ?? 0;

            /*$total_criancas_ativas = 0;

            if ($check_lider_ativo == 0) {
            } else {*/
            // total de crianças ativas do líder
            $query_criancas_ativas = $this->db->query("
                    SELECT COUNT(*) AS total
                    FROM criancas
                    WHERE lider = $id_lider AND ativo = 1
                ")->row_array();
            $total_criancas_ativas = $query_criancas_ativas['total'] ?? 0;
            //}

            // adiciona os totais ao array do líder
            $l['total_criancas'] = $total_criancas;
            $l['total_criancas_ativos'] = $total_criancas_ativas;
            $l['check_lider_ativo'] = $check_lider_ativo;

            $list_lideres[] = $l;
        }

        // === COMPARAÇÃO COM O ANO ANTERIOR ===
        /*if ($opc2 == 'sim' && $opc3 == 'query_supervisor_inicial') {
            $data_inicio_ano_passado = $datas['dataInicioAnoPassado'];
            $data_fim_ano_passado = $datas['dataFimAnoPassado'];
            $datas_2 = ['data_1' => $data_inicio_ano_passado, 'data_2' => $data_fim_ano_passado];

            $lideres_ano_passado = $this->db->query("
            SELECT * FROM lider
            WHERE id_supervisorR = $id_user
            AND data_cadastro BETWEEN '$data_inicio_ano_passado' AND '$data_fim_ano_passado'
            ORDER BY nome_lider ASC
        ")->result_array();

            foreach ($lideres_ano_passado as $l) {
                $id_lider = $l['id_lider'];
                $ativo = $l['confirmado'];
                $data_cadastro = $l['data_cadastro'];

                // verifica se o líder está ativo (função já existente)
                $check_lider_ativo = $this->Lideres->check_lider_is_ativo_otimizado(
                    $id_lider,
                    $data_cadastro,
                    $ativo,
                    $criacas_por_lider,
                    $progresso_por_lider
                );

                // Total de crianças do ano passado
                $query_criancas = $this->db->query("
                SELECT COUNT(*) AS total
                FROM criancas
                WHERE lider = $id_lider
                AND data_cadastro BETWEEN '$data_inicio_ano_passado' AND '$data_fim_ano_passado'
            ")->row_array();
                $total_criancas = $query_criancas['total'] ?? 0;

                // Total de crianças ativas do ano passado
                $query_criancas_ativas = $this->db->query("
                SELECT COUNT(*) AS total
                FROM criancas
                WHERE lider = $id_lider
                AND ativo = 1
                AND data_cadastro BETWEEN '$data_inicio_ano_passado' AND '$data_fim_ano_passado'
            ")->row_array();
                $total_criancas_ativos = $query_criancas_ativas['total'] ?? 0;

                $l['total_criancas'] = $total_criancas;
                $l['total_criancas_ativos'] = $total_criancas_ativos;
                $l['check_lider_ativo'] = $check_lider_ativo;

                $list_lideres_comparacao[] = $l;
            }
        }*/

        return [
            'total_lideres' => count($lideres),
            'total_lideres_ativos' => $total_lideres_ativos,
            'dados_lideres_gerais' => ['dados' => $list_lideres],
            'dados_lideres_gerais_comparacao' => ['dados' => $list_lideres_comparacao], // deixei vazio, igual no original
        ];
    }
}
