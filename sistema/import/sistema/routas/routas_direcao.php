<?php

$route['direcao/home'] = 'Direcao/home';

// lideres
$route['sregional/page/lideres'] = 'SRegional/pagina_ver_lideres';
$route['sregional/page/lideres/mostrar1'] = 'welcome/mostrar_table_parte_1';
$route['sregional/page/lideres/mostrar2'] = 'welcome/mostrar_table_parte_2';
$route['sregional/page/lideres/detalhes/:any'] = 'SRegional/pagina_ver_detalhes_lideres';
$route['sregional/page/lideres/gerar_excel'] = 'welcome/gerar_excel';

$route['sregional/page/lideres/salvar'] = 'SRegional/editar_lideres';
$route['sregional/page/lideres/desativar'] = 'welcome/desativar_lider';
$route['sregional/page/lideres/exclusao/ativar'] = 'welcome/ativar_lider';
$route['sregional/page/lideres/exclusao/permanente'] = 'welcome/excluir_lider_permanentemente';

// coordenadores
$route['sregional/page/coordenadores'] = 'SRegional/pagina_ver_coordenadores';
$route['sregional/page/coordenadores/salvar'] = 'welcome/cadastrar_coordenador';
$route['sregional/page/coordenadores/desativar'] = 'welcome/desativar_coordenador';
$route['sregional/page/coordenadores/exclusao/ativar'] = 'welcome/ativar_coordenador';
$route['sregional/page/coordenadores/exclusao/permanente'] = 'welcome/excluir_coordenador_permanentemente';

$route['sregional/page/coordenadores/detalhes/:any'] = 'SRegional/pagina_ver_detalhes_coordenadores';
$route['sregional/page/coordenadores/mostrar1'] = 'welcome/mostrar_table_parte_1';

$route['sregional/page/coordenadores/gerar_excel'] = 'welcome/gerar_excel';

// equipe - tudo
$route['direcao/page/equipe'] = 'Direcao/pagina_ver_equipe';
$route['direcao/page/equipe/mostrar1'] = 'welcome/mostrar_table_parte_1';
$route['direcao/page/equipe/mostrar2'] = 'welcome/mostrar_table_parte_2';

// sregional
$route['direcao/page/sregional/cadastro/salvar'] = 'welcome/cadastro_sregional';

$route['direcao/page/sregional/mostrar1'] = 'welcome/mostrar_table_parte_1';
$route['direcao/page/sregional/mostrar2'] = 'welcome/mostrar_table_parte_2';
$route['direcao/page/sregional/salvar'] = 'welcome/editar_info_sregional';

$route['direcao/page/sregional/desativar'] = 'welcome/desativar_sregional';
$route['direcao/page/sregional/exclusao/ativar'] = 'welcome/ativar_sregional';
$route['direcao/page/sregional/exclusao/permanente'] = 'welcome/excluir_sregional_permanentemente';

$route['direcao/page/sregional/:any'] = 'Direcao/pagina_ver_sregional';
$route['direcao/page/sregional/detalhes/:any'] = 'Direcao/pagina_ver_detalhes_sregional';

// slocal
$route['direcao/page/slocal'] = 'Direcao/pagina_ver_slocal';
$route['direcao/page/slocal/mostrar1'] = 'welcome/mostrar_table_parte_1';
$route['direcao/page/slocal/mostrar2'] = 'welcome/mostrar_table_parte_2';

$route['direcao/page/slocal/desativar'] = 'welcome/desativar_slocal';
$route['direcao/page/slocal/exclusao/ativar'] = 'welcome/ativar_slocal';
$route['direcao/page/slocal/exclusao/permanente'] = 'welcome/excluir_slocal_permanentemente';

$route['direcao/page/slocal/:any'] = 'Direcao/pagina_ver_slocal';
$route['direcao/page/slocal/detalhes/:any'] = 'Direcao/pagina_ver_detalhes_slocal';

// coordenador
$route['direcao/page/coordenador/mostrar1'] = 'welcome/mostrar_table_parte_1';
$route['direcao/page/coordenador/mostrar2'] = 'welcome/mostrar_table_parte_2';

$route['sregional/page/lideres_do_coordenador/:any'] = 'welcome/red_lideres_coord';
$route['sregional/page/info_lider_pessoal/:any/:any'] = 'welcome/red_lideres_info_licao';

// pg
$route['sregional/page/pg/cadastro/salvar'] = 'welcome/cadastro_pg';
$route['sregional/page/pg/edicao/salvar'] = 'welcome/editar_pg';
$route['sregional/page/pg/exclusao/desativar'] = 'welcome/desativar_pg';
$route['sregional/page/pg/exclusao/ativar'] = 'welcome/ativar_pg';
$route['sregional/page/pg/exclusao/permanente'] = 'welcome/excluir_pg_permanentemente';

$route['sregional/page/pg/licoes'] = 'SRegional/pagina_licoes';
$route['sregional/page/pg/preenchimento'] = 'SRegional/pagina_preenchimento_relatorio_pg';
$route['sregional/page/pg/consultas/retornar_informacoes_criancas_pg'] = 'SRegional/consulta_criancas_relatorios';
$route['sregional/page/pg/preenchimento/salvar'] = 'welcome/salvar_relatorio';

$route['sregional/page/criancas/cadastro/salvar'] = 'welcome/cadastro_crianca';
$route['sregional/page/criancas/edicao/salvar'] = 'welcome/editar_crianca';
$route['sregional/page/criancas/exclusao/desativar'] = 'welcome/desativar_crianca';
$route['sregional/page/criancas/exclusao/ativar'] = 'welcome/ativar_crianca';
$route['sregional/page/criancas/exclusao/permanente'] = 'welcome/excluir_crianca_permanentemente';
$route['sregional/page/criancas/gerar/relatorio'] = 'welcome/RelatoriosCriancas';

// Colíderes
$route['sregional/colider/cadastro/salvar'] = 'welcome/cadastro_colider';
$route['sregional/colider/desativar'] = 'welcome/desativar_colider';
$route['sregional/colider/ativar'] = 'welcome/ativar_colider';
$route['sregional/colider/exclusao/permanente'] = 'welcome/excluir_colider_permanentemente';
// Colíderes

// Material de Apoio Treinamento
$route['sregional/page/material-apoio-treinamento'] = 'SRegional/pagina_material_apoio_treinamento';

// Download de Material
$route['sregional/page/download'] = 'SRegional/pagina_download_material';
$route['sregional/page/modulo'] = 'SRegional/pagina_download_material_modulo';

// PG
$route['sregional/page/pg'] = 'SRegional/pagina_visualizacao_pg';

return $route;
