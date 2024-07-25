<?php

$route['slocal/home'] = 'SLocal/home';

// lideres
$route['slocal/page/lideres'] = 'SLocal/pagina_ver_lideres';
$route['slocal/page/lideres/mostrar1'] = 'welcome/mostrar_table_parte_1';
$route['slocal/page/lideres/mostrar2'] = 'welcome/mostrar_table_parte_2';
$route['slocal/page/lideres/detalhes/:any'] = 'SLocal/pagina_ver_detalhes_lideres';
$route['slocal/page/lideres/gerar_excel'] = 'welcome/gerar_excel';

$route['slocal/page/lideres/salvar'] = 'SLocal/editar_lideres';
$route['slocal/page/lideres/desativar'] = 'welcome/desativar_lider';
$route['slocal/page/lideres/exclusao/ativar'] = 'welcome/ativar_lider';
$route['slocal/page/lideres/exclusao/permanente'] = 'welcome/excluir_lider_permanentemente';

// coordenadores
$route['slocal/page/coordenadores'] = 'SLocal/pagina_ver_coordenadores';
$route['slocal/page/coordenadores/salvar'] = 'welcome/cadastrar_coordenador';
$route['slocal/page/coordenadores/desativar'] = 'welcome/desativar_coordenador';
$route['slocal/page/coordenadores/exclusao/ativar'] = 'welcome/ativar_coordenador';
$route['slocal/page/coordenadores/exclusao/permanente'] = 'welcome/excluir_coordenador_permanentemente';

$route['slocal/page/coordenadores/detalhes/:any'] = 'SLocal/pagina_ver_detalhes_coordenadores';
$route['slocal/page/coordenadores/mostrar1'] = 'welcome/mostrar_table_parte_1';

$route['slocal/page/coordenadores/gerar_excel'] = 'welcome/gerar_excel';

// red
$route['slocal/page/lideres_do_coordenador/:any'] = 'welcome/red_lideres_coord';
$route['slocal/page/info_lider_pessoal/:any/:any'] = 'welcome/red_lideres_info_licao';

// pg
$route['slocal/page/pg/cadastro/salvar'] = 'welcome/cadastro_pg';
$route['slocal/page/pg/edicao/salvar'] = 'welcome/editar_pg';
$route['slocal/page/pg/exclusao/desativar'] = 'welcome/desativar_pg';
$route['slocal/page/pg/exclusao/ativar'] = 'welcome/ativar_pg';
$route['slocal/page/pg/exclusao/permanente'] = 'welcome/excluir_pg_permanentemente';

$route['slocal/page/pg/licoes'] = 'SLocal/pagina_licoes';
$route['slocal/page/pg/preenchimento'] = 'SLocal/pagina_preenchimento_relatorio_pg';
$route['slocal/page/pg/consultas/retornar_informacoes_criancas_pg'] = 'SLocal/consulta_criancas_relatorios';
$route['slocal/page/pg/preenchimento/salvar'] = 'welcome/salvar_relatorio';

$route['slocal/page/criancas/cadastro/salvar'] = 'welcome/cadastro_crianca';
$route['slocal/page/criancas/edicao/salvar'] = 'welcome/editar_crianca';
$route['slocal/page/criancas/exclusao/desativar'] = 'welcome/desativar_crianca';
$route['slocal/page/criancas/exclusao/ativar'] = 'welcome/ativar_crianca';
$route['slocal/page/criancas/exclusao/permanente'] = 'welcome/excluir_crianca_permanentemente';
$route['slocal/page/criancas/gerar/relatorio'] = 'welcome/RelatoriosCriancas';

// Colíderes
$route['slocal/colider/cadastro/salvar'] = 'welcome/cadastro_colider';
$route['slocal/colider/desativar'] = 'welcome/desativar_colider';
$route['slocal/colider/ativar'] = 'welcome/ativar_colider';
$route['slocal/colider/exclusao/permanente'] = 'welcome/excluir_colider_permanentemente';
// Colíderes

// Material de Apoio Treinamento
$route['slocal/page/material-apoio-treinamento'] = 'SLocal/pagina_material_apoio_treinamento';

// Download de Material
$route['slocal/page/download'] = 'SLocal/pagina_download_material';
$route['slocal/page/modulo'] = 'SLocal/pagina_download_material_modulo';

// PG
$route['slocal/page/pg'] = 'SLocal/pagina_visualizacao_pg';

return $route;
