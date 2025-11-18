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
}
