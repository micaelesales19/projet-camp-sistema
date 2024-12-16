<?php
$route['lider/home'] = 'Lider/home';

// Dados Pessoais
$route['lider/pagina_editar_pessoal'] = 'Lider/pagina_editar_pessoal';
$route['lider/salvar_edicao'] = 'Lider/e_pessoal';
// Fim Dados Pessoais

// Crianças
$route['lider/page/criancas'] = 'Lider/pagina_visualizacao_criancas';
$route['lider/page/criancas/cadastro'] = 'Lider/pagina_cadastro_criancas';

$route['lider/page/criancas/cadastro/salvar'] = 'welcome/cadastro_crianca';
$route['lider/page/criancas/edicao/salvar'] = 'welcome/editar_crianca';
$route['lider/page/criancas/exclusao/desativar'] = 'welcome/desativar_crianca';
$route['lider/page/criancas/ativar'] = 'welcome/ativar_crianca';
$route['lider/page/criancas/gerar/relatorio'] = 'welcome/RelatoriosCriancas';
// Fim das Crianças

// PG
$route['lider/page/pg'] = 'Lider/pagina_visualizacao_pg';

$route['lider/page/pg/cadastro/salvar'] = 'welcome/cadastro_pg';
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
$route['lider/colider/cadastro/salvar'] = 'welcome/cadastro_colider';
$route['lider/colider/desativar'] = 'welcome/desativar_colider';
$route['lider/colider/ativar'] = 'welcome/ativar_colider';
// Colíderes

// Download de Material
$route['lider/page/download'] = 'Lider/pagina_download_material';
$route['lider/page/modulo'] = 'Lider/pagina_download_material_modulo';

return $route;
