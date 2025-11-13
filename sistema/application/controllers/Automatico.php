<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Automatico extends CI_Controller
{
    public function enviar_email_lider_liberacao_sistema($id_lider, $link): void
    {
        $dados_lider = $this->Lideres->infos([$id_lider], 'info_lider', '', '', '');
        if ($dados_lider['row'] == 0) {
            // enviar alerta p direção
        } else {
            $lider = $dados_lider['dados'];
            $email = $lider['email'];
            // Suucesso
            $assunto = "Bem-Vindo(a) " . $lider['nome_lider'] . " ao nosso sistema de discipulado infantil!";

            $dados = array(
                'dados_lider' => $lider,
                'link' => $link,
            );

            $page = $this->load->view('email/bem-vindo-sistema', $dados, TRUE);
            //$this->load->view('email/bem-vindo-sistema', $dados);

            $this->email->from("camp@campbrasil.com", 'CAMP Brasil');
            $this->email->subject($assunto);
            $this->email->to($email);
            $this->email->message($page);

            if ($this->email->send()) {
                //echo "\nsucesso";
            } else {
                //echo "\nerro\n";
                //echo $this->email->print_debugger();
            }
        }
    }

    public function enviar_email_coordenador_liberacao_sistema($id_coordenador, $link): void
    {
        $dados_coordenador = $this->Coordenadores->infos([$id_coordenador], 'info_coordenador', '', '', '');
        if ($dados_coordenador['row'] == 0) {
            // enviar alerta p direção
        } else {
            $coordenador = $dados_coordenador['dados'];
            $email = $coordenador['email'];
            // Suucesso
            $assunto = "Bem-Vindo(a) " . $coordenador['nome_coordenador'] . " ao nosso sistema de discipulado infantil!";

            $dados = array(
                'dados_coordenador' => $coordenador,
                'link' => $link,
            );

            $page = $this->load->view('email/bem-vindo-sistema-coordenador', $dados, TRUE);
            //$this->load->view('email/bem-vindo-sistema', $dados);

            $this->email->from("camp@campbrasil.com", 'CAMP Brasil');
            $this->email->subject($assunto);
            $this->email->to($email);
            $this->email->message($page);

            if ($this->email->send()) {
                //echo "\nsucesso";
            } else {
                //echo "\nerro\n";
                //echo $this->email->print_debugger();
            }
        }
    }

    public function enviar_email_coordenador_liberacao_sistema_do_lider($id_coordenador, $id_usuario, $id_lider)
    {
        $dados_lider = $this->Lideres->infos([$id_lider], 'info_lider', '', '', '');
        $dados_coordenador = $this->Coordenadores->infos([$id_coordenador], 'info_coordenador', '', '', '');
        $data_hoje = date('d/m/Y');

        if ($dados_lider['row'] == 0) {
        } else {

            $lider = $dados_lider['dados'];
            $assunto = "Alerta de novo cadastrado no sistema - $data_hoje";

            if ($dados_coordenador['row'] == 0) {
                $dados = array(
                    'dados_lider' => $lider,
                    'nome' => 'Micaele Sales Ribeiro',
                    'link' => "https://sistemas.campbrasil.com/sistema/aprovar?id_operador=$id_coordenador&id_usuario=$id_usuario&id_lider=$id_lider",
                );

                $page = $this->load->view('email/alerta_c-novo-lider', $dados, TRUE);
                //$this->load->view('email/alerta_c-novo-lider', $dados);

                $this->email->from("camp@campbrasil.com", 'CAMP Brasil');
                $this->email->subject($assunto);
                $this->email->to("sales.micaele1911@gmail.com");
                $this->email->message($page);

                if ($this->email->send()) {
                    //echo "\nsucesso";
                } else {
                    //echo "\nerro\n";
                    //echo $this->email->print_debugger();
                }
            } else {
                $nome_coordenador = $dados_coordenador['dados']['nome_coordenador'];
                $email = $dados_coordenador['dados']['email'];
                // Suucesso

                $dados = array(
                    'dados_lider' => $lider,
                    'nome' => $nome_coordenador,
                    'link' => "https://sistemas.campbrasil.com/sistema/aprovar?id_operador=$id_coordenador&id_usuario=$id_usuario&id_lider=$id_lider",
                );

                $page = $this->load->view('email/alerta_c-novo-lider', $dados, TRUE);
                //$this->load->view('email/alerta_c-novo-lider', $dados);

                $this->email->from("camp@campbrasil.com", 'CAMP Brasil');
                $this->email->subject($assunto);
                $this->email->to($email);
                $this->email->message($page);

                if ($this->email->send()) {
                    //echo "\nsucesso";
                } else {
                    //echo "\nerro\n";
                    //echo $this->email->print_debugger();
                }
            }
        }
    }

    public function enviar_email_supervisor_liberacao_sistema($id_supervisor, $id_usuario, $id_lider)
    {
        $dados_lider = $this->Lideres->infos([$id_lider], 'info_lider', '', '', '');
        $dados_supervisor = $this->Supervisores->infos([$id_supervisor], 'info_supervisor', '', '', '');
        $data_hoje = date('d/m/Y');

        if ($dados_lider['row'] == 0) {
        } else {

            $lider = $dados_lider['dados'];
            $assunto = "Alerta de novo cadastrado no sistema - $data_hoje";

            if ($dados_supervisor['row'] == 0) {
                $dados = array(
                    'dados_lider' => $lider,
                    'nome' => 'Micaele Sales Ribeiro',
                    'link' => "https://sistemas.campbrasil.com/sistema/aprovar?id_operador=$id_supervisor&id_usuario=$id_usuario&id_lider=$id_lider",
                );

                $page = $this->load->view('email/alerta_c-novo-lider', $dados, TRUE);
                //$this->load->view('email/alerta_c-novo-lider', $dados);

                $this->email->from("camp@campbrasil.com", 'CAMP Brasil');
                $this->email->subject($assunto);
                $this->email->to("sales.micaele1911@gmail.com");
                $this->email->message($page);

                if ($this->email->send()) {
                    //echo "\nsucesso";
                } else {
                    //echo "\nerro\n";
                    //echo $this->email->print_debugger();
                }
            } else {
                $nome_coordenador = $dados_supervisor['dados']['nome_supervisorR'];
                $email = $dados_supervisor['dados']['email'];
                // Suucesso

                $dados = array(
                    'dados_lider' => $lider,
                    'nome' => $nome_coordenador,
                    'link' => "https://sistemas.campbrasil.com/sistema/aprovar?id_operador=$id_supervisor&id_usuario=$id_usuario&id_lider=$id_lider",
                );

                $page = $this->load->view('email/alerta_c-novo-lider', $dados, TRUE);
                //$this->load->view('email/alerta_c-novo-lider', $dados);

                $this->email->from("camp@campbrasil.com", 'CAMP Brasil');
                $this->email->subject($assunto);
                $this->email->to($email);
                $this->email->message($page);

                if ($this->email->send()) {
                    //echo "\nsucesso";
                } else {
                    //echo "\nerro\n";
                    //echo $this->email->print_debugger();
                }
            }
        }
    }

    public function enviarEmailDevocionalDiario()

    {
        $todosPais = $this->Lideres->infos([], 'query_all_lider_br', '', '', '');

        $dataHj = date('m/d/Y');

        $hora = date('H');

        if ($hora >= 7 && $hora <= 21) {
            $controller = 0;
            foreach ($todosPais as $key => $pais) {

                $id = $pais['id'];
                $email = $pais['email'];
                $todosPG = $this->PG->query([$id], 'query_pg_id_lider_all', '');

                if ($controller < 10) {
                    foreach ($todosPG['dados'] as $key => $pg) {

                        $idPg = $pg['id_pg'];

                        $checks = $pg['autorizacao'];
                        $ativoPG = $pg['ativo'];
                        $nivelPg = $pg['nivel'];

                        $anoPg = $pg['ano'];
                        $modulo = $pg['modulo_devocional'];
                        $licao = $pg['licao_devocional'];
                        $diaComecou = $pg['data_semana'];

                        if ($checks == 0 || $ativoPG == 0 || $diaComecou == '' || $nivelPg == 2) {
                        } else {

                            $dia = $diaComecou[0] . $diaComecou[1];
                            $mes = $diaComecou[3] . $diaComecou[4];
                            $ano = $diaComecou[6] . $diaComecou[7] . $diaComecou[8] . $diaComecou[9];
                            $data_trocada = $mes . "/" . $dia . "/" . $ano;

                            $dia1 = date('m/d/Y', strtotime('+1 day', strtotime($data_trocada)));
                            $dia2 = date('m/d/Y', strtotime('+2 day', strtotime($data_trocada)));
                            $dia3 = date('m/d/Y', strtotime('+3 day', strtotime($data_trocada)));
                            $dia4 = date('m/d/Y', strtotime('+4 day', strtotime($data_trocada)));
                            $dia5 = date('m/d/Y', strtotime('+5 day', strtotime($data_trocada)));
                            $dia6 = date('m/d/Y', strtotime('+6 day', strtotime($data_trocada)));

                            $check_day_1 = strtotime($dia1) == strtotime($dataHj) ? true : false;
                            $check_day_2 = strtotime($dia2) == strtotime($dataHj) ? true : false;
                            $check_day_3 = strtotime($dia3) == strtotime($dataHj) ? true : false;
                            $check_day_4 = strtotime($dia4) == strtotime($dataHj) ? true : false;
                            $check_day_5 = strtotime($dia5) == strtotime($dataHj) ? true : false;
                            $check_day_6 = strtotime($dia6) == strtotime($dataHj) ? true : false;

                            if ($check_day_1) {
                                $diaDevocional = 1;
                            } else if ($check_day_2) {
                                $diaDevocional = 2;
                            } else if ($check_day_3) {
                                $diaDevocional = 3;
                            } else if ($check_day_4) {
                                $diaDevocional = 4;
                            } else if ($check_day_5) {
                                $diaDevocional = 5;
                            } else if ($check_day_6) {
                                $diaDevocional = 6;
                            }

                            if (strtotime($data_trocada) == strtotime($dataHj)) {
                            } else {
                                $check = $this->FConsultas_model->checkControler($id, $idPg, $anoPg, $modulo, $licao, $diaDevocional);

                                if ($check == 0) {
                                    $dadosDevocionais = $this->FConsultas_model->consultarDevocionalModuloLicaoDia($anoPg, $modulo, $licao, $diaDevocional);
                                    if ($dadosDevocionais) {

                                        // Suucesso
                                        $assunto = "Devocional Dia " . $dadosDevocionais['dia'] . " - " . $dadosDevocionais['titulo'];

                                        $dados = array(
                                            'devocionais' => $dadosDevocionais,
                                            'nome' => $pais['nome'],
                                        );

                                        $page = $this->load->view('sistema/pais/partes/corpo-mensagem-devocional', $dados, TRUE);
                                        $this->email->from("camp@campbrasil.com", 'CAMP Brasil');
                                        $this->email->subject($assunto);
                                        $this->email->to($email);
                                        $this->email->message($page);
                                        $this->email->attach($dadosDevocionais['file'] ?? "");
                                        if ($this->email->send()) {
                                            $controller = $controller + 1;
                                            $this->FSistema_model->controlerDevocionais($id, $idPg, $anoPg, $modulo, $licao, $diaDevocional, 1);
                                        } else {
                                        }
                                    } else {
                                    }
                                } else {
                                    // enviar um email de erro p administração, com os dados p reenviar
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    public function atualizarProgressoDevocional()
    {
        $todosPais = $this->Lideres->infos([], 'query_all_lider_br', '', '', '');

        $dataHj = date('m/d/Y');

        foreach ($todosPais as $key => $pais) {
            $id = $pais['id'];

            $todosPG = $this->PG->query([$id], 'query_pg_id_lider_all', '');

            if ($todosPG['row'] == 0) {
            } else {
                foreach ($todosPG['dados'] as $key => $pg) {

                    $id_pg = $pg['id_pg'];
                    $data_inicio = $pg['data_inicio'];
                    $diaComecou = $pg['data_semana'];
                    $modulo = $pg['modulo_devocional'];
                    $licao = $pg['licao_devocional'];

                    $n_modulo = $modulo + 1;

                    $consultaMO = $this->FConsultas_model->consultarModuloId($modulo);

                    if ($data_inicio == '' or $diaComecou == '') {
                    } else {
                        $dia = $diaComecou[0] . $diaComecou[1];
                        $mes = $diaComecou[3] . $diaComecou[4];
                        $ano = $diaComecou[6] . $diaComecou[7] . $diaComecou[8] . $diaComecou[9];
                        $data_trocada = $mes . "/" . $dia . "/" . $ano;

                        $data_troca = date('m/d/Y', strtotime('+7 day', strtotime($data_trocada)));
                        $data_envio = date('d/m/Y', strtotime('+7 day', strtotime($data_trocada)));

                        if (strtotime($dataHj) == strtotime($data_troca)) {

                            $licao_nova = $licao + 1;

                            $moduloNovo = $licao == $consultaMO['n_licao'] ? $n_modulo : $modulo;

                            $licaoNova = $licao == $consultaMO['n_licao'] ? 1 : $licao_nova;

                            $anoNovo = ($moduloNovo == 11 ? 3 : ($moduloNovo == 6 ? 2 : 1));

                            $this->FSistema_model->editarPGProgressoData($id_pg, $anoNovo, $moduloNovo, $licaoNova, $data_envio, 1);
                        } else {
                        }
                    }
                }
            }
        }
    }
    public function atualizarModuloMensal()
    {
        $todosPais = $this->Lideres->infos([], 'query_all_lider_br', '', '', '');

        $dataHj = date('m/d/Y');

        foreach ($todosPais as $key => $pais) {
            $id = $pais['id'];

            $todosPG = $this->PG->query([$id], 'query_pg_id_lider_all', '');

            if ($todosPG['row'] == 0) {
            } else {
                foreach ($todosPG['dados'] as $key => $pg) {

                    $id_pg = $pg['id_pg'];

                    $id_modulo_1 = $pg['id_modulo'];
                    $id_modulo_2 = $pg['modulo_devocional'];

                    $data_fim = $pg['data_previsao_termino'];

                    if ($data_fim == '') {
                    } else {
                        if ($id_modulo_1 != $id_modulo_2) {
                            if (strtotime($data_fim) >= strtotime($dataHj)) {
                                $this->FSistema_model->editarAtivo($id_pg, $id, 1);
                            } else {
                            }
                        } else {
                        }
                    }
                }
            }
        }
    }
}
