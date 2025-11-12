<?php

$route['coordenador/home'] = 'Coordenador/home';

// Dados Pessoais
$route['coordenador/pagina_editar_pessoal'] = 'Coordenador/pagina_editar_pessoal';
$route['coordenador/salvar_edicao'] = 'Coordenador/e_pessoal';
// Fim Dados Pessoais

$route['coordenador/page/lideres'] = 'Coordenador/pagina_ver_lideres';
$route['coordenador/page/lideres/mostrar'] = 'Coordenador/mostrar_table_lider';

$route['coordenador/page/lideres/gerar_excel'] = 'Coordenador/gerar_excel';

$route['coordenador/page/lider/salvar'] = 'Lider/e_pessoal'; // ok
$route['coordenador/page/lider/desativar'] = 'welcome/desativar_lider'; // ok
$route['coordenador/page/lider/reativar'] = 'welcome/ativar_lider'; // ok
$route['coordenador/page/lider/excluir'] = 'welcome/excluir_lider_permanentemente'; // ok
$route['coordenador/page/lider/trocar-liderenca'] = 'welcome/trocar_liderenca'; // ok

$route['coordenador/page/lider/:any'] = 'Coordenador/pagina_ver_detalhes_lider';

// pg
$route['coordenador/page/pg/cadastro/salvar'] = 'welcome/cadastro_pg';
$route['coordenador/page/pg/edicao/salvar'] = 'welcome/editar_pg';
$route['coordenador/page/pg/exclusao/desativar'] = 'welcome/desativar_pg';
$route['coordenador/page/pg/exclusao/ativar'] = 'welcome/ativar_pg';
$route['coordenador/page/pg/exclusao/permanente'] = 'welcome/excluir_pg_permanentemente';

$route['coordenador/page/pg/consultarProgresso'] = 'Lider/consulta_progresso_pg';

$route['coordenador/page/pg/licoes'] = 'Coordenador/pagina_licoes';
$route['coordenador/page/pg/preenchimento'] = 'Coordenador/pagina_preenchimento_relatorio_pg';
$route['coordenador/page/pg/visualizar'] = 'Coordenador/pagina_visualizacao_relatorio_pg';
$route['coordenador/page/pg/consultas/retornar_informacoes_criancas_pg'] = 'Coordenador/consulta_criancas_relatorios';
$route['coordenador/page/pg/consultas/retornar_informacoes_relatorio_pg'] = 'Coordenador/consulta_relatorio_pg';
$route['coordenador/page/pg/preenchimento/salvar'] = 'welcome/salvar_relatorio';
$route['coordenador/page/pg/preenchimento/edicao'] = 'welcome/edicao_relatorio';

$route['coordenador/page/criancas/cadastro/salvar'] = 'welcome/cadastro_crianca';
$route['coordenador/page/criancas/edicao/salvar'] = 'welcome/editar_crianca';
$route['coordenador/page/criancas/exclusao/desativar'] = 'welcome/desativar_crianca';
$route['coordenador/page/criancas/exclusao/ativar'] = 'welcome/ativar_crianca';
$route['coordenador/page/criancas/exclusao/permanente'] = 'welcome/excluir_crianca_permanentemente';
$route['coordenador/page/criancas/gerar/relatorio'] = 'welcome/RelatoriosCriancas';

// Colíderes
$route['coordenador/colider/cadastro/salvar'] = 'welcome/cadastro_colider';
$route['coordenador/colider/desativar'] = 'welcome/desativar_colider';
$route['coordenador/colider/ativar'] = 'welcome/ativar_colider';
$route['coordenador/colider/exclusao/permanente'] = 'welcome/excluir_colider_permanentemente';
// Colíderes

// Material de Apoio Treinamento
$route['coordenador/page/material-apoio-treinamento'] = 'Coordenador/pagina_material_apoio_treinamento';

// Download de Material
$route['coordenador/page/download'] = 'Coordenador/pagina_download_material';
$route['coordenador/page/modulo'] = 'Coordenador/pagina_download_material_modulo';

// PG
$route['coordenador/page/pg'] = 'Coordenador/pagina_visualizacao_pg';

return $route;
