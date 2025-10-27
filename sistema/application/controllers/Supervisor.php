<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Supervisor extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('America/Sao_Paulo');
        define(
            'LETRAS',
            ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z']
        );
    }

    /* SUPERVISOR */
    // ok
    public function home()
    {
        $id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";
        $link = $this->Supervisores->criar_link($id_usuario);
        $dados = array('link' => $link);
        $this->load->view('sistema/supervisor/home', $dados);
    }

    // PG
    public function pagina_visualizacao_pg()
    {
        $this->load->view('sistema/supervisor/pages/pagina_pg_usuario');
    }

    public function pagina_licoes()
    {

        $id_pg = $this->input->post("id_pg");
        $id_lider = $this->input->post("id_lider");
        $ano = $this->input->post("ano");
        $routa = $this->input->post('routa');

        $modulos = $this->FConsultas_model->consultarModuloAno($ano);
        $dadosPg = $this->FConsultas_model->mostrarPGId($id_lider, $id_pg, 2);

        $pages = [];

        if ($routa == 'pg') {
            $page1 = array(
                "routa" => "../pg",
                "name" => "Meu PG",
                "icon" => "fa fa-group",
            );
            array_push($pages, $page1);
        } else {

            $page1 = array(
                "routa" => "../lideres",
                "name" => "Líderes",
                "icon" => "fa fa-group",
            );

            $page2 = array(
                "routa" => "../lideres/detalhes/$id_lider",
                "name" => "Informações",
                "icon" => "fa fa-user",
            );

            array_push($pages, $page1);
            array_push($pages, $page2);
        }

        $dados = array(
            'id_lider' => $id_lider,
            'id_pg' => $id_pg,
            'modulos' => $modulos,
            'pg' => $dadosPg,
            'pages' => $pages,
            'routa' => $routa,
        );

        $this->load->view('sistema/supervisor/pages/pg/licaos', $dados);
    }

    public function pagina_visualizacao_relatorio_pg()
    {
        $id_pg = $this->input->post('id_pg');
        $id_relatorio = $this->input->post('id_relatorio');
        $id_lider = $this->input->post('id_lider');
        $ano = $this->input->post('ano');
        $id_modulo = $this->input->post('id_modulo');
        $licao = $this->input->post('licao');
        $routa = $this->input->post('routa');

        $red = $this->input->post('red');

        $pages = [];

        if ($routa == 'pg') {
            $page1 = array(
                "red" => "../pg",
                "name" => "Meu PG",
                "icon" => "fa fa-group",
            );
            array_push($pages, $page1);
        } else {

            $page1 = array(
                "red" => "../lideres",
                "name" => "Líderes",
                "icon" => "fa fa-group",
            );

            $page2 = array(
                "red" => "../lideres/detalhes/$id_lider",
                "name" => "Informações",
                "icon" => "fa fa-user",
            );

            array_push($pages, $page1);
            array_push($pages, $page2);
        }

        $dados = array(
            'id_lider' => $id_lider,
            'id_pg' => $id_pg,
            'ano' => $ano,
            'id_modulo' => $id_modulo,
            'licao' => $licao,
            'routa' => $routa,
            'pages' => $pages,
            'id_relatorio' => $id_relatorio,
            'red' => $red,
        );

        $this->load->view('sistema/supervisor/pages/edicao_preenchimento_relatorio', $dados);
    }

    public function pagina_preenchimento_relatorio_pg()
    {
        $id_pg = $this->input->post('id_pg');
        $id_lider = $this->input->post('id_lider');
        $ano = $this->input->post('ano');
        $id_modulo = $this->input->post('id_modulo');
        $licao = $this->input->post('licao');

        $red = $this->input->post('red');

        $routa = $this->input->post('routa');

        $pages = [];

        if ($routa == 'pg') {
            $page1 = array(
                "red" => "../pg",
                "name" => "Meu PG",
                "icon" => "fa fa-group",
            );
            $page2 = array(
                "red" => "licoes",
                "name" => "Lições",
                "icon" => "fa fa-book",
            );
            array_push($pages, $page1);
            array_push($pages, $page2);
        } else {
            $page1 = array(
                "red" => "../lideres",
                "name" => "Líderes",
                "icon" => "fa fa-group",
            );

            $page2 = array(
                "red" => "../lideres/detalhes/$id_lider",
                "name" => "Informações",
                "icon" => "fa fa-user",
            );

            array_push($pages, $page1);
            array_push($pages, $page2);
        }

        $dados = array(
            'id_lider' => $id_lider,
            'id_pg' => $id_pg,
            'ano' => $ano,
            'id_modulo' => $id_modulo,
            'licao' => $licao,
            'routa' => $routa,
            'pages' => $pages,
            'red' => $red,
        );

        $this->load->view('sistema/supervisor/pages/preenchimento_relatorio', $dados);
    }

    public function consulta_progresso_pg()
    {
        $id_lider = $this->input->get("id_lider");
        $id_pg = $this->input->get("id_pg");
        $id_modulo = $this->input->get("id_modulo");
        $ano = $this->input->get("ano");
        $total = $this->input->get("total"); // total de botões dos módulos escolhidos

        $id_crianca = $this->input->get("id_crianca");

        $page = $this->input->get('page') == '' ? 'inicial' : $this->input->get('page');

        // id_lider // id_pg
        $dadosPg = $this->PG->query([$id_lider, $id_pg], 'query_id_lider_id_pg_ativo', 1);

        $dados = array(
            'id_lider' => $id_lider,
            'id_pg' => $id_pg,
            'id_modulo' => $id_modulo,
            'total' => $total,
            'ano' => $ano,
            'page' => $page,
            'id_crianca' => $id_crianca,
            'pg' => $dadosPg['dados'],
        );


        if ($page == '' || $page == 'individual') {
            $this->load->view('sistema/lider/pages/pg/linha', $dados);
        } else {
            $this->load->view('sistema/lider/pages/pg/linha_geral', $dados);
        }
    }

    public function consulta_criancas_relatorios()
    {
        $this->load->view('sistema/supervisor/pages/consultas/retornar_infomacoes');
    }

    public function consulta_relatorio_pg()
    {
        $this->load->view('sistema/supervisor/pages/consultas/retornar_infomacoes_relatorio_pg');
    }

    // Download de Material
    public function pagina_download_material() // ok
    {
        $this->load->view('sistema/supervisor/pages/download_material');
    }

    public function pagina_download_material_modulo() // ok
    {
        $this->load->view('sistema/supervisor/pages/download_material_modulo');
    }

    public function pagina_material_apoio_treinamento() // ok
    {
        $this->load->view('sistema/supervisor/pages/material_apoio_treinamento');
    }

    // Coordenadores
    public function pagina_ver_coordenadores()
    {
        $id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";
        $link = $this->Supervisores->criar_link($id_usuario);
        $dados = array('link' => $link);
        $this->load->view('sistema/supervisor/pages/pagina_ver_coordenadores', $dados);
    }

    /*public function mostrar_table_coordenador_parte_1()
    {
        $id_user = $this->input->get("id_user");
        $opc1 = $this->input->get("opc1");
        $opc2 = $this->input->get("opc2");
        $opc3 = $this->input->get("opc3");
        $opc4 = $this->input->get("opc4");

        $dataInicio = $this->input->get("dataInicio");
        $dataFim = $this->input->get("dataAte");

        // opc1 = periodo - ultimo mês (opc1) ultimo 6 meses (opc2) desde 2017 (opc3) data (opc4)
        // opc2 = comparar com o ultimo ano - sim nao
        $data = date('Y-m-d');
        $data_menos_um_ano = date('Y-m-d', strtotime('-1 year', strtotime($data)));

        $data_formatada_1 = "";
        $data_formatada_2 = "";

        if ($opc2 == 'nao') {
            if ($opc1 == 'opc1') {
                // consulta baseada no ultimo mês
                $menos_um_mes = date('Y-m-d', strtotime('-1 month', strtotime($data)));
                $data_formatada_1 = $menos_um_mes;
                $data_formatada_2 = $data;
            } else if ($opc1 == 'opc2') {
                // consulta baseada nos últimos 6 meses
                //$data_menos_seis_meses = date('Y-m-d', strtotime('-6 month', strtotime($data)));
                $data_menos_seis_meses = date('Y-m-d', strtotime('-6 month', strtotime($data)));
                $data_formatada_1 = $data_menos_seis_meses;
                $data_formatada_2 = $data;
            } else if ($opc1 == 'opc3') {
                // desde o inicio
                $data_formatada_1 = "01-02-2017";
                $data_formatada_2 = $data;
            } else if ($opc1 == 'opc4') {
                if ($dataInicio == '' || $dataFim == '') {
                } else {
                    $data_formatada_1 = $dataInicio;
                    $data_formatada_2 = $dataFim;
                }
            }

            $datas = array(
                'dataInicio' => $data_formatada_1,
                'dataFim' => $data_formatada_2,
            );
        } else {
            if ($opc1 == 'opc1') {
                // consulta baseada no ultimo mês
                $menos_um_mes = date('Y-m-d', strtotime('-1 month', strtotime($data)));
                $menos_um_mes_ano = date('Y-m-d', strtotime('-1 year', strtotime($menos_um_mes)));
                $data_formatada_1 = $menos_um_mes;
                $data_formatada_2 = $data;
                $data_formatada_3 = $menos_um_mes_ano;
                $data_formatada_4 = $data_menos_um_ano;
            } else if ($opc1 == 'opc2') {
                // consulta baseada nos últimos 6 meses
                $data_menos_seis_meses = date('Y-m-d', strtotime('-6 month', strtotime($data)));
                $menos_seis_meses_ano = date('Y-m-d', strtotime('-1 year', strtotime($data_menos_seis_meses)));
                $data_formatada_1 = $data_menos_seis_meses;
                $data_formatada_2 = $data;
                $data_formatada_3 = $menos_seis_meses_ano;
                $data_formatada_4 = $data_menos_um_ano;
            } else if ($opc1 == 'opc4') {
                if ($dataInicio == '' || $dataFim == '') {
                } else {
                    $data_inicio_menos_um_ano = date('Y-m-d', strtotime('-1 year', strtotime($dataInicio)));
                    $data_fim_menos_um_ano = date('Y-m-d', strtotime('-1 year', strtotime($dataFim)));

                    $data_formatada_1 = $dataInicio;
                    $data_formatada_2 = $dataFim;
                    $data_formatada_3 = $data_inicio_menos_um_ano;
                    $data_formatada_4 = $data_fim_menos_um_ano;
                }
            }

            $datas = array(
                'dataInicio' => $data_formatada_1,
                'dataFim' => $data_formatada_2,
                'dataInicioAnoPassado' => $data_formatada_3,
                'dataFimAnoPassado' => $data_formatada_4,
            );
        }

        $dados_usuario = $this->Supervisores->infos([$id_user], 'info_supervisor', '', '', '');
        // 'mostrar_comparacao' => $opc2,
        $dados_coordenador = $this->consultasBDCoordenador($id_user, $opc2, $opc3, $opc4, $datas);

        $dados = array(
            'info' => $dados_usuario,
            'info_coordenadores' => $dados_coordenador,
        );

        $this->load->view('sistema/supervisor/pages/coordenadores/mostrar_tabela_coord_1', $dados);
    }*/

    public function mostrar_table_coordenador()
    {
        $id_user = $this->input->get("id_user");

        // opc2 = comparar com o ultimo ano - sim nao
        $opc2 = $this->input->get("comparar_ultimo_ano");

        // nivel da consulta
        $opc3 = $this->input->get("query");

        // depois é para remover a data inicio e data fim vai ser usado só a session
        $dataInicio = $this->input->get("dataInicio");
        $dataFim = $this->input->get("dataAte");

        // opc1 = periodo - ultimo mês (opc1) ultimo 6 meses (opc2) desde 2017 (opc3) data (opc4)
        $data = date('Y-m-d');
        $data_menos_um_ano = date('Y-m-d', strtotime('-1 year', strtotime($data)));

        $data_formatada_1 = "";
        $data_formatada_2 = "";

        $data_menos_seis_meses = date('Y-m-d', strtotime('-6 month', strtotime($data)));
        $data_formatada_1 = $data_menos_seis_meses;
        $data_formatada_2 = $data;

        $datas = array(
            'dataInicio' => $data_formatada_1,
            'dataFim' => $data_formatada_2,
        );

        $dados_usuario = $this->Supervisores->infos([$id_user], 'info_supervisor', '', '', '');
        // 'mostrar_comparacao' => $opc2,
        $dados_coordenador = $this->consultasBDCoordenador($id_user, $opc2, $opc3, $datas);

        $dados = array(
            "opc2" => $opc2,
            "opc3" => $opc3,
            'info' => $dados_usuario,
            'info_coordenadores' => $dados_coordenador,
            'datas' => $datas,
        );

        //print_r($dados);
        $this->load->view('sistema/supervisor/pages/coordenadores/mostrar_tabela_coordenador_2', $dados);
    }

    public function consultasBDCoordenador($id_user, $opc2, $opc3, $datas)
    {
        $list_coordenadores = [];
        $list_coordenadores_comparacao = [];

        // datas atuais
        $data_inicio = $datas['dataInicio'];
        $data_final = $datas['dataFim'];
        $datas_1 = ['data_1' => $data_inicio, 'data_2' => $data_final];

        // consulta coordenadores do período atual
        //AND data_cadastro BETWEEN '$data_inicio' AND '$data_final'
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
            $lideres_info = $this->Lideres->infos([$id_coordenador], 'query_coordenador_supervisor_inicial', '', [], $datas_1);
            $lideres_ativos_info = $this->Lideres->lideresAtivos($lideres_info);

            if (!empty($lideres_info['dados'])) {
                $ids_lideres = array_column($lideres_info['dados'], 'id_lider');
                $ids_lideres_str = implode(',', $ids_lideres);

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
            $c['total_lideres'] = $lideres_info['row'];
            $c['total_lideres_ativos'] = $lideres_ativos_info['row'];
            $c['total_criancas'] = $total_criancas;
            $c['total_criancas_ativos'] = $total_criancas_ativos;
            $c['check_coordenador_ativo'] = $check_coordenador_ativo;

            $list_coordenadores[] = $c;
        }

        // comparação com o ano anterior, se necessário
        if ($opc2 == 'sim' && $opc3 == 'query_supervisor_inicial') {
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

                $lideres_info = $this->Lideres->infos([$id_coordenador], 'query_coordenador_supervisor_inicial', '', [], $datas_2);
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
        }

        /*if ($opc4 == 'ativos') {
            $dados_c = array(
                'row' => count($coordenadores),
                'dados' => $coordenadores
            );
            $coordenadores_ativos = $this->Coordenadores->coordenadoresAtivos($dados_c);
            $list_c = $coordenadores_ativos['dados'];
        } else {
            $list_c = $coordenadores;
        }*/

        return [
            'total_coordenadores_ativos' => $total_coordenadores_ativos,
            'dados_coordenadores_gerais' => ['dados' => $list_coordenadores],
            'dados_coordenadores_gerais_comparacao' => ['dados' => $list_coordenadores_comparacao],
        ];
    }
}
