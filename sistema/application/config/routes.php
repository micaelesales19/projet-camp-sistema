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

$route['index'] = 'welcome/index';
$route['sair'] = 'welcome/sair';
$route['login'] = 'welcome/login';
$route['acesso'] = 'welcome/autenticacao_login'; //ok

$route['termos'] = 'welcome/PaginaDosTermos';
$route['primeiro_acesso'] = 'welcome/PrimeiroAcesso';

$route['download_material'] = 'welcome/downloadMaterial';

// PAIS	
$route['cadastro'] = 'welcome/cadastro';
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
$route['pais/page/criancas/cadastro/paginaInicial'] = 'welcome/cadastro_crianca_inicial';
$route['pais/page/criancas/edicao/salvar'] = 'welcome/editar_crianca';
$route['pais/page/criancas/exclusao/desativar'] = 'welcome/desativar_crianca';
$route['pais/page/criancas/ativar'] = 'welcome/ativar_crianca';
$route['pais/page/criancas/gerar/relatorio'] = 'welcome/RelatoriosCriancas';
// Fim das Crianças

// PG
$route['pais/page/pg'] = 'Pais/pagina_visualizacao_pg';
$route['pais/page/pg/get-informacoes-pg'] = 'welcome/get_informacoes_pg';

$route['pais/page/pg/cadastro/salvar'] = 'welcome/cadastro_pg';
$route['pais/page/pg/cadastro/paginaInicial'] = 'welcome/cadastro_pg_inicial';
$route['pais/page/pg/cadastro/primeiroAcesso'] = 'welcome/cadastro_pg_pagina_inicial';
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
$route['pais/colider/cadastro/salvar'] = 'Pais/cadastro_colider';
$route['pais/colider/desativar'] = 'Pais/desativar_colider';
$route['pais/colider/ativar'] = 'Pais/ativar_colider';
// Colíderes

// CronJobs
$route['controller/devocionalDiario'] = 'welcome/enviarEmailDevocionalDiario';
$route['controller/atualizacaoModuloMensal'] = 'welcome/atualizarModuloMensal';
$route['controller/page/pg/progresso/atualizar'] = 'welcome/atualizarProgressoDevocional';

// Download de Material
$route['pais/page/download'] = 'Pais/pagina_download_material';
$route['pais/page/modulo'] = 'Pais/pagina_download_material_modulo';
// FIM PAIS

/* NÍVEL LÍDER */
$route['lider/home'] = 'Lider/home';

// Dados Pessoais
$route['lider/pagina_editar_pessoal'] = 'Lider/pagina_editar_pessoal';
$route['lider/salvar_edicao'] = 'Lider/e_pessoal';
// Fim Dados Pessoais

// Crianças
$route['lider/page/criancas'] = 'Lider/pagina_visualizacao_criancas';
$route['lider/page/criancas/cadastro'] = 'Lider/pagina_cadastro_criancas';

$route['lider/page/criancas/cadastro/salvar'] = 'welcome/cadastro_crianca';
$route['lider/page/criancas/cadastro/paginaInicial'] = 'welcome/cadastro_crianca_inicial';
$route['lider/page/criancas/edicao/salvar'] = 'welcome/editar_crianca';
$route['lider/page/criancas/exclusao/desativar'] = 'welcome/desativar_crianca';
$route['lider/page/criancas/ativar'] = 'welcome/ativar_crianca';
$route['lider/page/criancas/gerar/relatorio'] = 'welcome/RelatoriosCriancas';
// Fim das Crianças

// PG
$route['lider/page/pg'] = 'Lider/pagina_visualizacao_pg';

$route['lider/page/pg/progresso'] = 'Lider/pagina_ver_progresso';

$route['lider/page/pg/cadastro/salvar'] = 'welcome/cadastro_pg';
$route['lider/page/pg/cadastro/paginaInicial'] = 'welcome/cadastro_pg_inicial';
$route['lider/page/pg/cadastro/primeiroAcesso'] = 'welcome/cadastro_pg_pagina_inicial';
$route['lider/page/pg/edicao/salvar'] = 'welcome/editar_pg';
$route['lider/page/pg/exclusao/desativar'] = 'welcome/desativar_pg';

$route['lider/page/pg/licoes'] = 'Lider/pagina_licoes';
$route['lider/page/pg/preenchimento'] = 'Lider/pagina_preenchimento_relatorio_pg';
$route['lider/page/pg/preenchimento/salvar'] = 'welcome/salvar_relatorio';
$route['lider/page/pg/consultas/retornar_informacoes_criancas_pg'] = 'Lider/consulta_criancas_relatorios';

$route['lider/page/pg/atualizar_data_pg'] = 'Lider/atualizarDataPG';
$route['lider/page/pg/consultarProgresso'] = 'Lider/consulta_progresso_pg';
// Fim das PG

// Colíderes
$route['lider/colider/cadastro/salvar'] = 'Lider/cadastro_colider';
$route['lider/colider/desativar'] = 'Lider/desativar_colider';
$route['lider/colider/ativar'] = 'Lider/ativar_colider';
// Colíderes

// Download de Material
$route['lider/page/download'] = 'Lider/pagina_download_material';
$route['lider/page/modulo'] = 'Lider/pagina_download_material_modulo';
// FIM LÍDER

// MÓDULOS
$route['modulo/trilha'] = 'welcome/modulo_trilha';
$route['modulo/mergulho'] = 'welcome/modulo_mergulho';
$route['modulo/santuario'] = 'welcome/modulo_santuario';
$route['modulo/arco'] = 'welcome/modulo_arco';
$route['modulo/estacao'] = 'welcome/modulo_estacao';

// adm
$route['adm/home'] = 'adm/index';
$route['adm/devocionais/mostrar'] = 'adm/mostrar_devocionais';
$route['adm/devocionais/cadastrar'] = 'adm/cadastrar_devocionais';
$route['adm/devocionais/salvar'] = 'adm/salvar_cadastro_devocionais';
