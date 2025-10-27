<?php

$route['supervisor/home'] = 'Supervisor/home'; // ok

// lideres
$route['supervisor/page/lideres'] = 'Supervisor/pagina_ver_lideres';
$route['supervisor/page/lideres/mostrar1'] = 'welcome/mostrar_table_parte_1';
$route['supervisor/page/lideres/mostrar2'] = 'welcome/mostrar_table_parte_2';
$route['supervisor/page/lideres/detalhes/:any'] = 'Supervisor/pagina_ver_detalhes_lideres';
$route['supervisor/page/lideres/gerar_excel'] = 'welcome/gerar_excel';

$route['supervisor/page/lideres/salvar'] = 'Supervisor/editar_lideres';
$route['supervisor/page/lideres/desativar'] = 'welcome/desativar_lider';
$route['supervisor/page/lideres/exclusao/ativar'] = 'welcome/ativar_lider';
$route['supervisor/page/lideres/exclusao/permanente'] = 'welcome/excluir_lider_permanentemente';

// coordenadores
$route['supervisor/page/coordenadores'] = 'Supervisor/pagina_ver_coordenadores';
$route['supervisor/page/coordenadores/salvar'] = 'welcome/cadastrar_coordenador';
$route['supervisor/page/coordenadores/desativar'] = 'welcome/desativar_coordenador';
$route['supervisor/page/coordenadores/exclusao/ativar'] = 'welcome/ativar_coordenador';
$route['supervisor/page/coordenadores/exclusao/permanente'] = 'welcome/excluir_coordenador_permanentemente';

//$route['supervisor/page/coordenadores/mostrar1'] = 'Supervisor/mostrar_table_coordenador_parte_1';
//$route['supervisor/page/coordenadores/mostrar2'] = 'Supervisor/mostrar_table_coordenador_parte_2';
$route['supervisor/page/coordenadores/mostrar'] = 'Supervisor/mostrar_table_coordenador';

$route['supervisor/page/coordenadores/detalhes/:any'] = 'Supervisor/pagina_ver_detalhes_coordenadores';

$route['supervisor/page/coordenadores/gerar_excel'] = 'welcome/gerar_excel';

// red
$route['supervisor/page/lideres_do_coordenador/:any'] = 'welcome/red_lideres_coord';
$route['supervisor/page/info_lider_pessoal/:any/:any'] = 'welcome/red_lideres_info_licao';

// pg
$route['supervisor/page/pg/cadastro/salvar'] = 'welcome/cadastro_pg';
$route['supervisor/page/pg/edicao/salvar'] = 'welcome/editar_pg';
$route['supervisor/page/pg/exclusao/desativar'] = 'welcome/desativar_pg';
$route['supervisor/page/pg/exclusao/ativar'] = 'welcome/ativar_pg';
$route['supervisor/page/pg/exclusao/permanente'] = 'welcome/excluir_pg_permanentemente';

$route['supervisor/page/pg/consultarProgresso'] = 'Lider/consulta_progresso_pg';

$route['supervisor/page/pg/licoes'] = 'Supervisor/pagina_licoes';
$route['supervisor/page/pg/preenchimento'] = 'Supervisor/pagina_preenchimento_relatorio_pg';
$route['supervisor/page/pg/visualizar'] = 'Supervisor/pagina_visualizacao_relatorio_pg';
$route['supervisor/page/pg/consultas/retornar_informacoes_criancas_pg'] = 'Supervisor/consulta_criancas_relatorios';
$route['supervisor/page/pg/consultas/retornar_informacoes_relatorio_pg'] = 'Supervisor/consulta_relatorio_pg';
$route['supervisor/page/pg/preenchimento/salvar'] = 'welcome/salvar_relatorio';
$route['supervisor/page/pg/preenchimento/edicao'] = 'welcome/edicao_relatorio';

$route['supervisor/page/criancas/cadastro/salvar'] = 'welcome/cadastro_crianca';
$route['supervisor/page/criancas/edicao/salvar'] = 'welcome/editar_crianca';
$route['supervisor/page/criancas/exclusao/desativar'] = 'welcome/desativar_crianca';
$route['supervisor/page/criancas/exclusao/ativar'] = 'welcome/ativar_crianca';
$route['supervisor/page/criancas/exclusao/permanente'] = 'welcome/excluir_crianca_permanentemente';
$route['supervisor/page/criancas/gerar/relatorio'] = 'welcome/RelatoriosCriancas';

// Colíderes
$route['supervisor/colider/cadastro/salvar'] = 'welcome/cadastro_colider';
$route['supervisor/colider/desativar'] = 'welcome/desativar_colider';
$route['supervisor/colider/ativar'] = 'welcome/ativar_colider';
$route['supervisor/colider/exclusao/permanente'] = 'welcome/excluir_colider_permanentemente';
// Colíderes

// Material de Apoio Treinamento
$route['supervisor/page/material-apoio-treinamento'] = 'Supervisor/pagina_material_apoio_treinamento'; // ok

// Download de Material
$route['supervisor/page/download'] = 'Supervisor/pagina_download_material'; // ok
$route['supervisor/page/modulo'] = 'Supervisor/pagina_download_material_modulo'; // ok

// PG
$route['supervisor/page/pg'] = 'Supervisor/pagina_visualizacao_pg';

return $route;
