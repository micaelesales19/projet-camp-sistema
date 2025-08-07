<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//$route['offline'] = 'welcome/offline';
$route['atualizar_data'] = 'welcome/atualizar_data';

$route['gerar_certificado'] = 'welcome/gerar_certificado';

$route['index'] = 'welcome/index';
$route['sair'] = 'welcome/sair';
$route['login'] = 'welcome/login';
$route['acesso'] = 'welcome/autenticacao_login';
$route['atualizar_session'] = 'welcome/atualizar_session';

$route['termos'] = 'welcome/PaginaDosTermos';
$route['primeiro_acesso'] = 'welcome/PrimeiroAcesso';

$route['lider/salvar'] = 'welcome/cadastro_lider';

$route['download_material'] = 'welcome/downloadMaterial';
$route['download'] = 'welcome/download_material';

// Primeiro Acesso
$route['pg/cadastro/salvar'] = 'welcome/cadastro_pg_inicial';
$route['pg/pular'] = 'welcome/cadastro_pg_inicial_pular';
$route['criancas/cadastro/salvar'] = 'welcome/cadastro_crianca_inicial';

// CronJobs
$route['controller/devocionalDiario'] = 'welcome/enviarEmailDevocionalDiario';
$route['controller/atualizacaoModuloMensal'] = 'welcome/atualizarModuloMensal';
$route['controller/page/pg/progresso/atualizar'] = 'welcome/atualizarProgressoDevocional';

// PAIS	
$route['cadastro/:any'] = 'welcome/cadastro';
$route['cadastro/salvar'] = 'welcome/salvar_cadastro';

/* NÍVEL PAIS */
$route['pais/home'] = 'Pais/home';

// Dados Pessoais
$route['pais/pagina_editar_pessoal'] = 'Pais/pagina_editar_pessoal';
$route['pais/salvar_edicao'] = 'Pais/e_pessoal';
// Fim Dados Pessoais

// Crianças
$route['pais/page/criancas'] = 'Pais/pagina_visualizacao_criancas';
$route['pais/page/criancas/cadastro'] = 'Pais/pagina_cadastro_criancas';

$route['pais/page/criancas/cadastro/salvar'] = 'welcome/cadastro_crianca';
$route['pais/page/criancas/edicao/salvar'] = 'welcome/editar_crianca';
$route['pais/page/criancas/exclusao/desativar'] = 'welcome/desativar_crianca';
$route['pais/page/criancas/ativar'] = 'welcome/ativar_crianca';
$route['pais/page/criancas/gerar/relatorio'] = 'welcome/RelatoriosCriancas';
// Fim das Crianças

// PG
$route['pais/page/pg'] = 'Pais/pagina_visualizacao_pg';
$route['pais/page/pg/get-informacoes-pg'] = 'welcome/get_informacoes_pg';

$route['pais/page/pg/cadastro/salvar'] = 'welcome/cadastro_pg';
$route['pais/page/pg/edicao/salvar'] = 'welcome/editar_pg';
$route['pais/page/pg/exclusao/desativar'] = 'welcome/desativar_pg';

$route['pais/page/pg/licoes'] = 'Pais/pagina_licoes';
$route['pais/page/pg/preenchimento'] = 'Pais/pagina_preenchimento_relatorio_pg';
$route['pais/page/pg/preenchimento/salvar'] = 'welcome/salvar_relatorio';
$route['pais/page/pg/consultas/retornar_informacoes_criancas_pg'] = 'Pais/consulta_criancas_relatorios';

$route['pais/page/pg/atualizar_data_pg'] = 'Pais/atualizarDataPG';
$route['pais/page/pg/consultarProgresso'] = 'Pais/consulta_progresso_pg';
// Fim das PG

// Colíderes
$route['pais/colider/cadastro/salvar'] = 'welcome/cadastro_colider';
$route['pais/colider/desativar'] = 'welcome/desativar_colider';
$route['pais/colider/ativar'] = 'welcome/ativar_colider';
// Colíderes

// Download de Material
$route['pais/page/download'] = 'Pais/pagina_download_material';
$route['pais/page/modulo'] = 'Pais/pagina_download_material_modulo';
// FIM PAIS

/* NÍVEL LÍDER */
require_once(APPPATH . '../import/sistema/routas/routas_lider.php');
// FIM LÍDER

/* NÍVEL COORDENADOR */
require_once(APPPATH . '../import/sistema/routas/routas_coordenador.php');
// FIM COORDENADOR

/* NÍVEL SUPERVISOR LOCAL */
require_once(APPPATH . '../import/sistema/routas/routas_slocal.php');
// FIM SUPERVISOR LOCAL

/* NÍVEL SUPERVISOR REGIONAL */
require_once(APPPATH . '../import/sistema/routas/routas_sregional.php');
// FIM SUPERVISOR REGIONAL

/* NÍVEL DIREÇÃO */
require_once(APPPATH . '../import/sistema/routas/routas_direcao.php');
// FIM DIREÇÃO

// adm
$route['adm/home'] = 'adm/index';
$route['adm/devocionais/mostrar'] = 'adm/mostrar_devocionais';
$route['adm/devocionais/cadastrar'] = 'adm/cadastrar_devocionais';
$route['adm/devocionais/salvar'] = 'adm/salvar_cadastro_devocionais';

// alertas
$route['alerta/solicitar/troca_de_css'] = 'welcome/enviando_alerta_troca_de_css';
$route['alerta/solicitar/troca_de_lider_pg'] = 'welcome/enviando_alerta_troca_de_lider_pg';
$route['alerta/solicitar/tornar_de_funcao'] = 'welcome/trocar_de_funcao';





$route['alerta/solicitar/tornar_slocal'] = 'welcome/tornar_coord_slocal';
$route['alerta/solicitar/tornar_coord_lider'] = 'welcome/tornar_coord_lider';
