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

$route['offline'] = 'welcome/offline';

// admin
$route['atualizar_data'] = 'welcome/atualizar_data';
$route['migrar_criancas'] = 'welcome/migrar';
$route['migrar_pg'] = 'welcome/migrar_pg';
$route['login/2'] = 'welcome/login_c_parametros';

$route['gerar_certificado'] = 'welcome/gerar_certificado';

$route['index'] = 'welcome/index';
$route['loginpage'] = 'welcome/loginpage';
$route['sair'] = 'welcome/sair';
$route['login'] = 'welcome/login';
$route['acesso'] = 'welcome/autenticacao_login';
$route['atualizar_session'] = 'welcome/atualizar_session';
$route['sessao/pegar'] = 'welcome/pegar';

$route['termos'] = 'welcome/PaginaDosTermos';
$route['primeiro_acesso'] = 'welcome/PrimeiroAcesso';

$route['lider/salvar'] = 'welcome/cadastro_lider';

$route['download_material'] = 'welcome/downloadMaterial';
$route['download'] = 'welcome/download_material';

// Primeiro Acesso
$route['pg/cadastro/salvar'] = 'welcome/cadastro_pg_inicial'; // ok
$route['pg/pular'] = 'welcome/cadastro_pg_inicial_pular'; // ok
$route['criancas/cadastro/salvar'] = 'welcome/cadastro_crianca_inicial';

// CronJobs
$route['controller/devocionalDiario'] = 'welcome/enviarEmailDevocionalDiario';
$route['controller/atualizacaoModuloMensal'] = 'welcome/atualizarModuloMensal';
$route['controller/page/pg/progresso/atualizar'] = 'welcome/atualizarProgressoDevocional';

// PAIS
$route['aprovar'] = 'welcome/aprovar_acesso_lider';
$route['cadastro/salvar'] = 'welcome/salvar_cadastro';
$route['cadastro'] = 'welcome/cadastro';
$route['cadastro/:any'] = 'welcome/cadastro';

/* NÍVEL LÍDER */
require_once(APPPATH . '../import/sistema/routas/routas_lider.php');
// FIM LÍDER

/* NÍVEL COORDENADOR */
require_once(APPPATH . '../import/sistema/routas/routas_coordenador.php');
// FIM COORDENADOR

/* NÍVEL SUPERVISOR */
require_once(APPPATH . '../import/sistema/routas/routas_supervisor.php');
// FIM SUPERVISOR

/* NÍVEL DIREÇÃO */
require_once(APPPATH . '../import/sistema/routas/routas_direcao.php');
// FIM DIREÇÃO

// adm
$route['adm/home'] = 'adm/index';
$route['adm/devocionais/mostrar'] = 'adm/mostrar_devocionais';
$route['adm/devocionais/cadastrar'] = 'adm/cadastrar_devocionais';
$route['adm/devocionais/salvar'] = 'adm/salvar_cadastro_devocionais';

// alertas
$route['alerta/solicitar/troca_de_coordenador_supervisor'] = 'welcome/enviando_alerta_troca_de_cs'; // ok
$route['alerta/solicitar/troca_de_lider_pg'] = 'welcome/enviando_alerta_troca_de_lider_pg';
$route['alerta/solicitar/trocar_de_funcao'] = 'welcome/trocar_de_funcao'; // ok

// material
$route['pdf_modulo'] = 'welcome/ir_modulo';
