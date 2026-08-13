<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property $db
 */

class Direcao extends CI_Controller
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

    // criar link de cadastro para supervisor
    public function criar_link($id_usuario)
    {
        $consultarLink = $this->db->select("*")
            ->from("link_cadastro")
            ->where("id_usuario", $id_usuario)
            ->get();
        $totalLink = $consultarLink->num_rows();
        $info_codigo = $consultarLink->row_array();

        if ($totalLink == 0) {
            $dados = "";
            $nivel = "5";
            $codigo = $this->FConsultas_model->gerarLink();
            $link = "https://sistemas.campbrasil.com/sistema/cadastro/" . $codigo;
            $data = date('Y-m-d');

            $inserir = [
                'id_usuario' => $id_usuario,
                'nivel' => $nivel,
                'codigo' => $codigo,
                'link' => $link,
                'dados' => $dados,
                'data' => $data
            ];

            if ($this->db->insert('link_cadastro', $inserir)) {
                echo json_encode(['link' => $link]);
            } else {
                echo json_encode(['erro' => true]);
            }
        } else {
            echo json_encode(['link' => $info_codigo['link']]);
        }
    }

    /* DIRECAO */

    public function home()
    {
        $this->load->view('sistema/direcao/home');
    }

    // Dados Pessoal ok
    public function pagina_editar_pessoal()
    {
        $this->load->view('sistema/direcao/edicao/pagina_editar_pessoal');
    }
    // ok
    public function e_pessoal()
    {
        $id = $this->input->post("id");
        $nome = $this->input->post("nome");
        $cpf = $this->input->post("cpf");
        $email = $this->input->post("email");
        $telefone_digitado = $this->input->post("telefone");
        $nascimento = $this->input->post("nascimento");

        $id_usuario = $this->input->post("id_usuario");
        $senha = $this->input->post("senha");

        $foto_antiga = $this->input->post("foto_antiga");

        $filesCount1 = count($_FILES['files']['name']);

        $mensagem = [];

        $telefone = $this->FConsultas_model->formatar_telefone($telefone_digitado, true);

        // editar direcao brasileiro
        if (!empty($cpf)) {
            $cpfSoNumeros = preg_replace('/\D/', '', $cpf);
            $total_numeros_cpf = strlen($cpfSoNumeros);

            $dataNascimentoSoNumeros = preg_replace('/\D/', '', $nascimento);
            $total_numeros_data_nascimento = strlen($dataNascimentoSoNumeros);
            if ($total_numeros_cpf == 11 && $total_numeros_data_nascimento == 8 && $this->FAlerta_model->valida_cpf($cpfSoNumeros)) {
                $cpf_completo = $cpfSoNumeros[0] . $cpfSoNumeros[1] . $cpfSoNumeros[2] . "." . $cpfSoNumeros[3] . $cpfSoNumeros[4] . $cpfSoNumeros[5] . "." . $cpfSoNumeros[6] . $cpfSoNumeros[7] . $cpfSoNumeros[8] . "-" . $cpfSoNumeros[9] . $cpfSoNumeros[10];
                $data_nascimento_completo = $dataNascimentoSoNumeros[0] . $dataNascimentoSoNumeros[1] . "/" . $dataNascimentoSoNumeros[2] . $dataNascimentoSoNumeros[3] . "/" . $dataNascimentoSoNumeros[4] . $dataNascimentoSoNumeros[5] . $dataNascimentoSoNumeros[6] . $dataNascimentoSoNumeros[7];

                // EDIÇÃO
                for ($i = 0; $i < $filesCount1; $i++) {
                    $_FILES['file']['name']     = $_FILES['files']['name'][$i];
                    $_FILES['file']['type']     = $_FILES['files']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                    $_FILES['file']['error']     = $_FILES['files']['error'][$i];
                    $_FILES['file']['size']     = $_FILES['files']['size'][$i];

                    $uploadPath = 'import/sistema/fotoU/direcao/';
                    $foto = 'fotoU/direcao/' . $_FILES['files']['name'][$i];

                    if ($_FILES['files']['name'][$i] == '') {
                        $edicao = $this->Direcaos->editar_direcao($id, $nome, $cpf_completo, $email, $telefone, $data_nascimento_completo, 1, $foto_antiga);
                        $editar_usuario = $this->Lideres->editar_usuario($id_usuario, $nome, $email, $cpf_completo, $senha);
                        if ($edicao && $editar_usuario) {
                            array_push($mensagem, "Sucesso! Seus Dados foram Editados!");
                        } else {
                            array_push($mensagem, "Erro! Seus dados estão inválidos!");
                        }
                    } else {
                        if ($foto_antiga == $foto) {
                            $edicao = $this->Direcaos->editar_direcao($id, $nome, $cpf_completo, $email, $telefone, $data_nascimento_completo, 1, $foto_antiga);
                            $editar_usuario = $this->Lideres->editar_usuario($id_usuario, $nome, $email, $cpf_completo, $senha);

                            if ($edicao && $editar_usuario) {
                                array_push($mensagem, "Sucesso! Seus Dados foram Editados!");
                            } else {
                                array_push($mensagem, "Erro! Seus dados estão inválidos!");
                            }
                        } else {
                            if (file_exists($foto)) {
                                $edicao = $this->Direcaos->editar_direcao($id, $nome, $cpf_completo, $email, $telefone, $data_nascimento_completo, 1, $foto_antiga);
                                $editar_usuario = $this->Lideres->editar_usuario($id_usuario, $nome, $email, $cpf_completo, $senha);

                                if ($edicao && $editar_usuario) {
                                    array_push($mensagem, "Sua foto já existe em nosso servidor, tente com outra foto com nome diferente!");
                                } else {
                                    array_push($mensagem, "Erro! Seus dados estão inválidos!");
                                }
                            } else {
                                // File upload configuration
                                $config['upload_path'] = $uploadPath;
                                $config['allowed_types'] = 'jpg|jpeg|png|gif';

                                // Load and initialize upload library
                                $this->load->library('upload', $config);
                                $this->upload->initialize($config);

                                // Upload file to server
                                if ($this->upload->do_upload('file')) {
                                    $edicao = $this->Direcaos->editar_direcao($id, $nome, $cpf_completo, $email, $telefone, $data_nascimento_completo, 1, $foto);
                                    $editar_usuario = $this->Lideres->editar_usuario($id_usuario, $nome, $email, $cpf_completo, $senha);

                                    if ($edicao && $editar_usuario) {
                                        array_push($mensagem, "Sucesso! Seus Dados foram Editados!");
                                    } else {
                                        array_push($mensagem, "Erro! Seus dados estão inválidos!");
                                    }
                                } else {
                                    $erros = $this->upload->display_errors() + " - meus dados pessoais";
                                    array_push($mensagem, $erros);
                                }
                            }
                        }
                    }
                }
            } else {
                array_push($mensagem, "Erro! Data de Nascimento e/ou CPF inválidos!");
            }
        } else {
            $dataNascimentoSoNumeros = preg_replace('/\D/', '', $nascimento);
            $total_numeros_data_nascimento = strlen($dataNascimentoSoNumeros);
            if ($total_numeros_data_nascimento == 8) {
                $data_nascimento_completo = $dataNascimentoSoNumeros[0] . $dataNascimentoSoNumeros[1] . "/" . $dataNascimentoSoNumeros[2] . $dataNascimentoSoNumeros[3] . "/" . $dataNascimentoSoNumeros[4] . $dataNascimentoSoNumeros[5] . $dataNascimentoSoNumeros[6] . $dataNascimentoSoNumeros[7];

                // EDIÇÃO
                for ($i = 0; $i < $filesCount1; $i++) {
                    $_FILES['file']['name']     = $_FILES['files']['name'][$i];
                    $_FILES['file']['type']     = $_FILES['files']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                    $_FILES['file']['error']     = $_FILES['files']['error'][$i];
                    $_FILES['file']['size']     = $_FILES['files']['size'][$i];

                    $uploadPath = 'import/sistema/fotoU/direcao/';
                    $foto = 'fotoU/direcao/' . $_FILES['files']['name'][$i];

                    if ($_FILES['files']['name'][$i] == '') {
                        $edicao = $this->Direcaos->editar_direcao($id, $nome, "", $email, $telefone, $data_nascimento_completo, 1, $foto_antiga);
                        $editar_usuario = $this->Lideres->editar_usuario($id_usuario, $nome, $email, "", $senha);

                        if ($edicao && $editar_usuario) {
                            array_push($mensagem, "Sucesso! Seus Dados foram Editados!");
                        } else {
                            array_push($mensagem, "Erro! Seus dados estão inválidos!");
                        }
                    } else {
                        if ($foto_antiga == $foto) {
                            $edicao = $this->Direcaos->editar_direcao($id, $nome, "", $email, $telefone, $data_nascimento_completo, 1, $foto_antiga);
                            $editar_usuario = $this->Lideres->editar_usuario($id_usuario, $nome, $email, "", $senha);

                            if ($edicao && $editar_usuario) {
                                array_push($mensagem, "Sucesso! Seus Dados foram Editados!");
                            } else {
                                array_push($mensagem, "Erro! Seus dados estão inválidos!");
                            }
                        } else {
                            if (file_exists($foto)) {
                                $edicao = $this->Direcaos->editar_direcao($id, $nome, "", $email, $telefone, $data_nascimento_completo, 1, $foto_antiga);
                                $editar_usuario = $this->Lideres->editar_usuario($id_usuario, $nome, $email, "", $senha);

                                if ($edicao && $editar_usuario) {
                                    array_push($mensagem, "Sua foto já existe em nosso servidor, tente com outra foto com nome diferente!");
                                } else {
                                    array_push($mensagem, "Erro! Seus dados estão inválidos!");
                                }
                            } else {
                                // File upload configuration
                                $config['upload_path'] = $uploadPath;
                                $config['allowed_types'] = 'jpg|jpeg|png|gif';

                                // Load and initialize upload library
                                $this->load->library('upload', $config);
                                $this->upload->initialize($config);

                                // Upload file to server
                                if ($this->upload->do_upload('file')) {
                                    $edicao = $this->Direcaos->editar_direcao($id, $nome, "", $email, $telefone, $data_nascimento_completo, 1, $foto);
                                    $editar_usuario = $this->Lideres->editar_usuario($id_usuario, $nome, $email, "", $senha);

                                    if ($edicao && $editar_usuario) {
                                        array_push($mensagem, "Sucesso! Seus Dados foram Editados!");
                                    } else {
                                        array_push($mensagem, "Erro! Seus dados estão inválidos!");
                                    }
                                } else {
                                    $erros = $this->upload->display_errors() + " - meus dados pessoais";
                                    array_push($mensagem, $erros);
                                }
                            }
                        }
                    }
                }
            } else {
                array_push($mensagem, "Erro! Data de Nascimento inválida!");
            }
        }

        // atualizarCriancas
        $nome_antigo = $this->input->post("nome_antigo");

        $consultarCriancas = $this->Criancas->query([$id], 'query_id_lider');

        if ($consultarCriancas['row'] == 0) {
        } else {
            foreach ($consultarCriancas['dados'] as $key => $dadosCriancas) {
                $id = $dadosCriancas['id_crianca'];
                $nome_responsavel = $dadosCriancas['nome_responsavel'];

                if ($nome_responsavel == $nome_antigo) {
                    $this->Criancas->editar_nome_responsavel_crianca($id, $nome, $email, $telefone);
                }
            }
        }

        $red = $this->input->post('red');

        //echo '<script>alert("' . implode("\\n", $mensagem) . '");</script>';
        echo '
			<script>
				if(window.confirm("' . implode("\\n", $mensagem) . '")) {
					window.location="' . $red . '";
				}else{
					window.location="' . $red . '";
				}
			</script>
		';
    }
    // Fim Dados Pessoal

    // PG ok
    public function pagina_visualizacao_pg()
    {
        $this->load->view('sistema/direcao/pages/pagina_pg_usuario');
    }

    public function pagina_licoes()
    {

        $id_pg = $this->input->post("id_pg");
        $id_lider = $this->input->post("id_lider");
        $ano = $this->input->post("ano");
        $routa = $this->input->post('routa');

        $modulos = $this->FConsultas_model->consultarModuloAno($ano);
        $dadosPg = $this->PG->query([$id_lider, $id_pg], 'query_id_lider_id_pg_ativo', 1);

        $pages = [];
        if ($routa == 'pg') {
            $page1 = array(
                "routa" => "../pg",
                "name" => "Meu PG",
                "icon" => "fa fa-group",
            );
            array_push($pages, $page1);
        } else if ($routa == 'super') {
            $dados_lider = $this->Lideres->infos([$id_lider], 'info_lider', '', '', '');

            $id_supervisor = $dados_lider['dados']['id_supervisorR'];
            $id_coordenador = $dados_lider['dados']['id_coordenador'];

            $page1 = array(
                "routa" => "../supervisores",
                "name" => "Supervisores",
                "icon" => "fa fa-group",
            );
            $page2 = array(
                "routa" => "../supervisor/$id_supervisor",
                "name" => "Coordenadores",
                "icon" => "fa fa-group",
            );
            $page3 = array(
                "routa" => "../supervisor/coordenador/lideres/$id_coordenador",
                "name" => "Líderes",
                "icon" => "fa fa-group",
            );
            $page4 = array(
                "routa" => "../supervisor/coordenador/lider/$id_lider",
                "name" => "Líder",
                "icon" => "fa fa-user",
            );

            array_push($pages, $page1);
            array_push($pages, $page2);
            array_push($pages, $page3);
            array_push($pages, $page4);
        } else if ($routa == 'coord') {
            $dados_lider = $this->Lideres->infos([$id_lider], 'info_lider', '', '', '');
            $id_coordenador = $dados_lider['dados']['id_coordenador'];
            $page1 = array(
                "routa" => "../coordenadores",
                "name" => "Coordenadores",
                "icon" => "fa fa-group",
            );
            $page2 = array(
                "routa" => "../coordenador/lideres/$id_coordenador",
                "name" => "Líderes",
                "icon" => "fa fa-group",
            );
            $page3 = array(
                "routa" => "../coordenador/lider/$id_lider",
                "name" => "Líder",
                "icon" => "fa fa-user",
            );

            array_push($pages, $page1);
            array_push($pages, $page2);
            array_push($pages, $page3);
        } else if ($routa == 'lider') {
            $page1 = array(
                "routa" => "../lideres",
                "name" => "Líderes",
                "icon" => "fa fa-group",
            );
            $page2 = array(
                "routa" => "../lider/$id_lider",
                "name" => "Líder",
                "icon" => "fa fa-user",
            );

            array_push($pages, $page1);
            array_push($pages, $page2);
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

        $this->load->view('sistema/direcao/pages/pg/licaos', $dados);
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
                "routa" => "../pg",
                "name" => "Meu PG",
                "icon" => "fa fa-group",
            );
            array_push($pages, $page1);
        } else if ($routa == 'super') {
            $dados_lider = $this->Lideres->infos([$id_lider], 'info_lider', '', '', '');

            $id_supervisor = $dados_lider['dados']['id_supervisorR'];
            $id_coordenador = $dados_lider['dados']['id_coordenador'];

            $page1 = array(
                "routa" => "../supervisores",
                "name" => "Supervisores",
                "icon" => "fa fa-group",
            );
            $page2 = array(
                "routa" => "../supervisor/$id_supervisor",
                "name" => "Coordenadores",
                "icon" => "fa fa-group",
            );
            $page3 = array(
                "routa" => "../supervisor/coordenador/lideres/$id_coordenador",
                "name" => "Líderes",
                "icon" => "fa fa-group",
            );
            $page4 = array(
                "routa" => "../supervisor/coordenador/lider/$id_lider",
                "name" => "Líder",
                "icon" => "fa fa-user",
            );

            array_push($pages, $page1);
            array_push($pages, $page2);
            array_push($pages, $page3);
            array_push($pages, $page4);
        } else if ($routa == 'coord') {
            $dados_lider = $this->Lideres->infos([$id_lider], 'info_lider', '', '', '');
            $id_coordenador = $dados_lider['dados']['id_coordenador'];
            $page1 = array(
                "routa" => "../coordenadores",
                "name" => "Coordenadores",
                "icon" => "fa fa-group",
            );
            $page2 = array(
                "routa" => "../coordenador/lideres/$id_coordenador",
                "name" => "Líderes",
                "icon" => "fa fa-group",
            );
            $page3 = array(
                "routa" => "../coordenador/lider/$id_lider",
                "name" => "Líder",
                "icon" => "fa fa-user",
            );

            array_push($pages, $page1);
            array_push($pages, $page2);
            array_push($pages, $page3);
        } else if ($routa == 'lider') {
            $page1 = array(
                "routa" => "../lideres",
                "name" => "Líderes",
                "icon" => "fa fa-group",
            );
            $page2 = array(
                "routa" => "../lider/$id_lider",
                "name" => "Líder",
                "icon" => "fa fa-user",
            );

            array_push($pages, $page1);
            array_push($pages, $page2);
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
            'ano' => $ano,
            'id_modulo' => $id_modulo,
            'licao' => $licao,
            'routa' => $routa,
            'pages' => $pages,
            'id_relatorio' => $id_relatorio,
            'red' => $red,
        );

        $this->load->view('sistema/direcao/pages/edicao_preenchimento_relatorio', $dados);
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
                "routa" => "../pg",
                "name" => "Meu PG",
                "icon" => "fa fa-group",
            );
            array_push($pages, $page1);
        } else if ($routa == 'super') {
            $dados_lider = $this->Lideres->infos([$id_lider], 'info_lider', '', '', '');

            $id_supervisor = $dados_lider['dados']['id_supervisorR'];
            $id_coordenador = $dados_lider['dados']['id_coordenador'];

            $page1 = array(
                "routa" => "../supervisores",
                "name" => "Supervisores",
                "icon" => "fa fa-group",
            );
            $page2 = array(
                "routa" => "../supervisor/$id_supervisor",
                "name" => "Coordenadores",
                "icon" => "fa fa-group",
            );
            $page3 = array(
                "routa" => "../supervisor/coordenador/lideres/$id_coordenador",
                "name" => "Líderes",
                "icon" => "fa fa-group",
            );
            $page4 = array(
                "routa" => "../supervisor/coordenador/lider/$id_lider",
                "name" => "Líder",
                "icon" => "fa fa-user",
            );

            array_push($pages, $page1);
            array_push($pages, $page2);
            array_push($pages, $page3);
            array_push($pages, $page4);
        } else if ($routa == 'coord') {
            $dados_lider = $this->Lideres->infos([$id_lider], 'info_lider', '', '', '');
            $id_coordenador = $dados_lider['dados']['id_coordenador'];
            $page1 = array(
                "routa" => "../coordenadores",
                "name" => "Coordenadores",
                "icon" => "fa fa-group",
            );
            $page2 = array(
                "routa" => "../coordenador/lideres/$id_coordenador",
                "name" => "Líderes",
                "icon" => "fa fa-group",
            );
            $page3 = array(
                "routa" => "../coordenador/lider/$id_lider",
                "name" => "Líder",
                "icon" => "fa fa-user",
            );

            array_push($pages, $page1);
            array_push($pages, $page2);
            array_push($pages, $page3);
        } else if ($routa == 'lider') {
            $page1 = array(
                "routa" => "../lideres",
                "name" => "Líderes",
                "icon" => "fa fa-group",
            );
            $page2 = array(
                "routa" => "../lider/$id_lider",
                "name" => "Líder",
                "icon" => "fa fa-user",
            );

            array_push($pages, $page1);
            array_push($pages, $page2);
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
            'ano' => $ano,
            'id_modulo' => $id_modulo,
            'licao' => $licao,
            'routa' => $routa,
            'pages' => $pages,
            'red' => $red,
        );

        $this->load->view('sistema/direcao/pages/preenchimento_relatorio', $dados);
    }


    public function consulta_criancas_relatorios()
    {
        $this->load->view('sistema/direcao/pages/consultas/retornar_infomacoes');
    }


    public function consulta_relatorio_pg()
    {
        $this->load->view('sistema/direcao/pages/consultas/retornar_infomacoes_relatorio_pg');
    }

    // Download de Material
    public function pagina_download_material()
    {
        $this->load->view('sistema/direcao/pages/download_material');
    }

    public function pagina_download_material_modulo()
    {
        $this->load->view('sistema/direcao/pages/download_material_modulo');
    }

    public function pagina_material_apoio_treinamento()
    {
        $this->load->view('sistema/direcao/pages/material_apoio_treinamento');
    }

    // Coordenadores
    public function pagina_ver_coordenadores()
    {
        $this->load->view('sistema/direcao/pages/pagina_ver_coordenadores');
    }

    public function pagina_ver_detalhes_coordenadores()
    {

        $id_coordenador_1 =  $this->uri->segment(6); // via supervisão
        $id_coordenador_2 =  $this->uri->segment(5); // direto

        $id_coordenador = "";

        if (empty($id_coordenador_1)) {
            $id_coordenador = $id_coordenador_2;
            $x = "is_page_coordenador";
        } else {
            $id_coordenador = $id_coordenador_1;
            $x = "is_page_supervisor_coordenador";
        }

        $dados_coordenador = $this->Coordenadores->infos([$id_coordenador], 'info_coordenador', '', '', '');
        $dados = array('id_coordenador' => $id_coordenador, 'dados_do_coordenador' => $dados_coordenador, 'x' => $x);
        $this->load->view('sistema/direcao/pages/coordenadores/pagina_ver_info_coordenador', $dados);
    }

    public function mostrar_table_coordenador() // ok
    {
        $dados_coordenador = $this->Funcoes->consultasBDCoordenadoresGeral();

        $dados = array(
            'info_coordenadores' => $dados_coordenador,
        );

        $this->load->view('sistema/direcao/pages/coordenadores/mostrar_tabela_coordenador', $dados);
    }

    public function pagina_ver_lideres_coordenadores()
    {
        $id_coordenador =  $this->uri->segment(5);
        $dados_coordenador = $this->Coordenadores->infos([$id_coordenador], 'info_coordenador', '', '', '');
        $dados = array('id_coordenador' => $id_coordenador, 'dados_do_coordenador' => $dados_coordenador);
        $this->load->view('sistema/direcao/pages/coordenadores/pagina_ver_lideres_coordenador', $dados);
    }

    public function mostrar_table_lideres_coordenador()
    {
        $id_user = $this->input->get("id_supervisor");
        $id_coordenador = $this->input->get("id_coordenador");
        $url_redirecionamento = $this->input->get("url_redirecionamento");

        $dados_usuario = $this->Coordenadores->infos([$id_coordenador], 'info_coordenador', '', '', '');
        $dados_coordenador = $this->Funcoes->consultasBDLideresCoordenador($id_coordenador);

        $dados = array(
            'id_user' => $id_user,
            'info_coordenadores' => $dados_coordenador,
            'info' => $dados_usuario,
            'url_redirecionamento' => $url_redirecionamento,
        );

        $this->load->view('sistema/direcao/pages/coordenadores/mostrar_tabela_lideres_coordenador', $dados);
    }

    public function pagina_ver_detalhes_lider()
    {
        $id_lider_1 =  $this->uri->segment(6); // pagina do supervisor
        $id_lider_2 =  $this->uri->segment(5); // pagina do coordenador
        $id_lider_3 =  $this->uri->segment(4); // pagina do lider

        $id_lider = "";

        if (empty($id_lider_1)) {
            $dados_lider = $this->Lideres->infos([$id_lider_2], 'info_lider', '', '', '');

            if ($dados_lider['row'] == 0) {
                $id_lider = $id_lider_3;
                $x = "is_page_inicial_lider";
            } else {
                $id_lider = $id_lider_2;
                $x = "is_page_coordenador";
            }
        } else {
            $id_lider = $id_lider_1;
            $x = "is_page_supervisor_coordenador";
        }

        $dados_lider = $this->Lideres->infos([$id_lider], 'info_lider', '', '', '');
        $dados = array('id_lider' => $id_lider, 'dados_do_lider' => $dados_lider, 'x' => $x);
        $this->load->view('sistema/direcao/pages/lideres/pagina_ver_info_lideres', $dados);
    }

    // líderes
    public function pagina_ver_lideres()
    {
        $this->load->view('sistema/direcao/pages/pagina_ver_lideres');
    }

    public function mostrar_table_lider()
    {
        $dados_lideres = $this->Funcoes->consultasBDLiderGeral();

        $dados = array(
            'info_lideres' => $dados_lideres,
        );

        $this->load->view('sistema/direcao/pages/lideres/mostrar_tabela_lider', $dados);
    }

    // Supervisores
    public function pagina_ver_supervisores() // ok
    {
        $this->load->view('sistema/direcao/pages/pagina_ver_supervisores');
    }

    public function pagina_ver_detalhes_supervisor() // ok
    {
        $id_supervisor =  $this->uri->segment(5);
        $dados_supervisor = $this->Supervisores->infos([$id_supervisor], 'info_supervisor', '', '', '');

        $dados = array('id_supervisor' => $id_supervisor, 'dados_supervisor' => $dados_supervisor);

        $this->load->view('sistema/direcao/pages/supervisores/pagina_ver_info_supervisor', $dados);
    }

    public function mostrar_table_supervisor() // ok
    {
        $dados_supervisor = $this->Funcoes->consultasBDSupervisorGeral();
        $dados = array(
            'info_supervisores' => $dados_supervisor,
        );
        $this->load->view('sistema/direcao/pages/supervisores/mostrar_tabela_supervisor', $dados);
    }

    public function pagina_ver_coordenadores_do_supervisor() // ok
    {
        $id_supervisor =  $this->uri->segment(4);
        $dados_supervisor = $this->Supervisores->infos([$id_supervisor], 'info_supervisor', '', '', '');

        $dados = array('id_supervisor' => $id_supervisor, 'dados_supervisor' => $dados_supervisor);

        $this->load->view('sistema/direcao/pages/supervisores/pagina_ver_coordenadores_do_supervisor', $dados);
    }

    public function mostrar_coordenadores_do_supervisor() // ok
    {
        $id_usuario =  $this->input->get("id_usuario");
        $id_supervisor =  $this->input->get("id_user");
        $url_redirecionamento = $this->input->get("url_redirecionamento");
        $dados_supervisor = $this->Supervisores->infos([$id_supervisor], 'info_supervisor', '', '', '');

        $dados_coordenador_do_supervisor = $this->Funcoes->consultasBDCoordenadordoSupervisor($id_supervisor);

        $dados = array(
            'id_usuario' => $id_usuario,
            'id_supervisor' => $id_supervisor,
            'dados_supervisor' => $dados_supervisor,
            'info_coordenadores' => $dados_coordenador_do_supervisor,
            'url_redirecionamento' => $url_redirecionamento,
            'total_criancas_do_supervisor' => $dados_coordenador_do_supervisor['total_criancas_do_supervisor'],
        );

        $this->load->view('sistema/direcao/pages/supervisores/motrar_tabela_coordenadores_do_supervisor', $dados);
    }

    public function pagina_ver_lideres_do_coordenadores_do_supervisor() // ok
    {
        $id_coordenador =  $this->uri->segment(6);
        $dados_coordenador = $this->Coordenadores->infos([$id_coordenador], 'info_coordenador', '', '', '');
        $dados = array('id_coordenador' => $id_coordenador, 'dados_do_coordenador' => $dados_coordenador);
        $this->load->view('sistema/direcao/pages/supervisores/pagina_ver_lideres_coordenador_supervisor', $dados);
    }

    public function mostrar_table_lideres_coordenador_supervisor() // ok
    {
        $id_user = $this->input->get("id_supervisor");
        $id_coordenador = $this->input->get("id_coordenador");
        $url_redirecionamento = $this->input->get("url_redirecionamento");

        $dados_usuario = $this->Coordenadores->infos([$id_coordenador], 'info_coordenador', '', '', '');
        $dados_coordenador = $this->Funcoes->consultasBDLideresCoordenador($id_coordenador);

        $dados = array(
            'id_user' => $id_user,
            'info_coordenadores' => $dados_coordenador,
            'info' => $dados_usuario,
            'url_redirecionamento' => $url_redirecionamento,
        );

        $this->load->view('sistema/direcao/pages/supervisores/mostrar_tabela_lideres_coordenador_supervisor', $dados);
    }
}
