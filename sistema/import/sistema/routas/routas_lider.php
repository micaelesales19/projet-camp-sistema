<?php
$route['lider/home'] = 'Lider/home';

// Dados Pessoais
$route['lider/pagina_editar_pessoal'] = 'Lider/pagina_editar_pessoal'; // ok
$route['lider/salvar_edicao'] = 'Lider/e_pessoal'; // ok
// Fim Dados Pessoais

// Crianças
$route['lider/page/criancas'] = 'Lider/pagina_visualizacao_criancas'; // ok
$route['lider/page/criancas/cadastro/salvar'] = 'welcome/cadastro_crianca'; //ok
$route['lider/page/criancas/edicao/salvar'] = 'welcome/editar_crianca'; // ok
$route['lider/page/criancas/exclusao/desativar'] = 'welcome/desativar_crianca'; //ok
$route['lider/page/criancas/exclusao/permanente'] = 'welcome/excluir_crianca_permanentemente'; // ok
$route['lider/page/criancas/ativar'] = 'welcome/ativar_crianca'; // ok
$route['lider/page/criancas/gerar/relatorio'] = 'welcome/RelatoriosCriancas'; // ok
// Fim das Crianças

// PG
$route['lider/page/pg'] = 'Lider/pagina_visualizacao_pg'; // ok
$route['lider/page/pg/cadastro/salvar'] = 'welcome/cadastro_pg'; // ok
$route['lider/page/pg/edicao/salvar'] = 'welcome/editar_pg'; // ok
$route['lider/page/pg/exclusao/desativar'] = 'welcome/desativar_pg'; // ok
$route['lider/page/pg/exclusao/permanente'] = 'welcome/excluir_pg_permanentemente'; // ok

$route['lider/page/pg/licoes'] = 'Lider/pagina_licoes'; // ok
$route['lider/page/pg/visualizar'] = 'Lider/pagina_visualizacao_relatorio_pg'; // ok
$route['lider/page/pg/preenchimento'] = 'Lider/pagina_preenchimento_relatorio_pg'; // ok
$route['lider/page/pg/atualizar_data_pg'] = 'Lider/atualizarDataPG'; // ok
$route['lider/page/pg/consultarProgresso'] = 'Lider/consulta_progresso_pg'; // ok

$route['lider/page/pg/consultas/retornar_informacoes_criancas_pg'] = 'Lider/consulta_criancas_relatorios';
$route['lider/page/pg/consultas/retornar_informacoes_relatorio_pg'] = 'Lider/consulta_relatorio_pg';
$route['lider/page/pg/preenchimento/salvar'] = 'welcome/salvar_relatorio'; // ok
$route['lider/page/pg/preenchimento/edicao'] = 'welcome/edicao_relatorio'; // ok
// Fim das PG

// Colíderes
$route['lider/colider/cadastro/salvar'] = 'welcome/cadastro_colider'; // ok
$route['lider/colider/desativar'] = 'welcome/desativar_colider'; // ok
$route['lider/colider/ativar'] = 'welcome/ativar_colider'; // ok
$route['lider/colider/exclusao/permanente'] = 'welcome/excluir_colider_permanentemente'; // ok
// Colíderes

// Download de Material
$route['lider/page/download'] = 'Lider/pagina_download_material'; // ok
$route['lider/page/modulo'] = 'Lider/pagina_download_material_modulo'; // ok

return $route;
