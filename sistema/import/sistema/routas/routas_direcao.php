<?php

$route['direcao/home'] = 'Direcao/home'; // ok

// Dados Pessoais
$route['direcao/pagina_editar_pessoal'] = 'Direcao/pagina_editar_pessoal'; // ok
$route['direcao/salvar_edicao'] = 'Direcao/e_pessoal'; // ok
// Fim Dados Pessoais

// lideres
$route['direcao/page/lideres'] = 'Direcao/pagina_ver_lideres'; // ok
$route['direcao/page/lideres/gerar_excel'] = 'welcome/gerar_excel';

$route['direcao/page/lideres/mostrar'] = 'Direcao/mostrar_table_lider'; // ok

$route['direcao/page/lider/salvar'] = 'Lider/e_pessoal'; // ok
$route['direcao/page/lider/desativar'] = 'welcome/desativar_lider'; // ok
$route['direcao/page/lider/reativar'] = 'welcome/ativar_lider'; // ok
$route['direcao/page/lider/excluir'] = 'welcome/excluir_lider_permanentemente'; // ok
$route['direcao/page/lider/trocar-liderenca'] = 'welcome/trocar_liderenca'; // ok

$route['direcao/page/lider/liberar'] = 'welcome/liberar_acesso';

$route['direcao/page/lider/:any'] = 'Direcao/pagina_ver_detalhes_lider'; // ok

// coordenadores
$route['direcao/page/coordenadores'] = 'Direcao/pagina_ver_coordenadores'; // ok
$route['direcao/page/coordenadores/gerar_excel'] = 'welcome/gerar_excel';

$route['direcao/page/coordenadores/mostrar'] = 'Direcao/mostrar_table_coordenador'; // ok
$route['direcao/page/coordenador/lideres/mostrar'] = 'Direcao/mostrar_table_lideres_coordenador'; // ok

$route['direcao/page/coordenador/salvar'] = 'welcome/cadastro_coordenador'; // ok
$route['direcao/page/coordenador/edicao/salvar'] = 'Coordenador/e_pessoal'; // ok
$route['direcao/page/coordenador/desativar'] = 'welcome/desativar_coordenador'; // ok
$route['direcao/page/coordenador/exclusao/ativar'] = 'welcome/ativar_coordenador'; // ok
$route['direcao/page/coordenador/exclusao/permanente'] = 'welcome/excluir_coordenador_permanentemente'; // ok

$route['direcao/page/coordenador/liberar'] = 'welcome/liberar_acesso_coordenador';

$route['direcao/page/coordenador/lideres/:any'] = 'Direcao/pagina_ver_lideres_coordenadores'; // ok

$route['direcao/page/coordenador/lider/:any'] = 'Direcao/pagina_ver_detalhes_lider'; // ok

$route['direcao/page/coordenador/detalhes/:any'] = 'Direcao/pagina_ver_detalhes_coordenadores'; // ok

// supervisores
$route['direcao/page/supervisores'] = 'Direcao/pagina_ver_supervisores'; // ok
$route['direcao/page/supervisores/mostrar'] = 'Direcao/mostrar_table_supervisor'; // ok

$route['direcao/page/supervisor/edicao/salvar'] = 'Supervisor/e_pessoal'; // ok

$route['direcao/page/supervisor/salvar'] = 'welcome/cadastro_supervisor'; // ok
$route['direcao/page/supervisor/desativar'] = 'welcome/desativar_supervisor'; // ok
$route['direcao/page/supervisor/reativar'] = 'welcome/ativar_supervisor'; // ok
$route['direcao/page/supervisor/excluir'] = 'welcome/excluir_supervisor_permanentemente'; // ok

$route['direcao/page/supervisor/coordenadores/mostrar'] = 'Direcao/mostrar_coordenadores_do_supervisor'; // ok

$route['direcao/page/supervisor/coordenador/lideres/mostrar'] = 'Direcao/mostrar_table_lideres_coordenador_supervisor'; // ok
$route['direcao/page/supervisor/coordenador/lider/:any'] = 'Direcao/pagina_ver_detalhes_lider'; // ok

$route['direcao/page/supervisor/coordenador/lideres/:any'] = 'Direcao/pagina_ver_lideres_do_coordenadores_do_supervisor'; // ok
$route['direcao/page/supervisor/coordenador/detalhes/:any'] = 'Direcao/pagina_ver_detalhes_coordenadores'; // ok

$route['direcao/page/supervisor/detalhes/:any'] = 'Direcao/pagina_ver_detalhes_supervisor'; // ok
$route['direcao/page/supervisor/:any'] = 'Direcao/pagina_ver_coordenadores_do_supervisor'; // ok

// pg
$route['direcao/page/pg'] = 'Direcao/pagina_visualizacao_pg';
$route['direcao/page/pg/cadastro/salvar'] = 'welcome/cadastro_pg'; // ok
$route['direcao/page/pg/edicao/salvar'] = 'welcome/editar_pg'; // ok
$route['direcao/page/pg/exclusao/desativar'] = 'welcome/desativar_pg';
$route['direcao/page/pg/exclusao/ativar'] = 'welcome/ativar_pg'; // ok
$route['direcao/page/pg/exclusao/permanente'] = 'welcome/excluir_pg_permanentemente';

$route['direcao/page/pg/consultarProgresso'] = 'Lider/consulta_progresso_pg';

$route['direcao/page/pg/licoes'] = 'Direcao/pagina_licoes';
$route['direcao/page/pg/preenchimento'] = 'Direcao/pagina_preenchimento_relatorio_pg';
$route['direcao/page/pg/visualizar'] = 'Direcao/pagina_visualizacao_relatorio_pg';
$route['direcao/page/pg/consultas/retornar_informacoes_criancas_pg'] = 'Direcao/consulta_criancas_relatorios';
$route['direcao/page/pg/consultas/retornar_informacoes_relatorio_pg'] = 'Direcao/consulta_relatorio_pg';
$route['direcao/page/pg/preenchimento/salvar'] = 'welcome/salvar_relatorio';
$route['direcao/page/pg/preenchimento/edicao'] = 'welcome/edicao_relatorio';

// crianças
$route['direcao/page/criancas/cadastro/salvar'] = 'welcome/cadastro_crianca';
$route['direcao/page/criancas/edicao/salvar'] = 'welcome/editar_crianca';
$route['direcao/page/criancas/exclusao/desativar'] = 'welcome/desativar_crianca';
$route['direcao/page/criancas/exclusao/ativar'] = 'welcome/ativar_crianca';
$route['direcao/page/criancas/exclusao/permanente'] = 'welcome/excluir_crianca_permanentemente';
$route['direcao/page/criancas/gerar/relatorio'] = 'welcome/RelatoriosCriancas';

// Colíderes
$route['direcao/colider/cadastro/salvar'] = 'welcome/cadastro_colider';
$route['direcao/colider/desativar'] = 'welcome/desativar_colider';
$route['direcao/colider/ativar'] = 'welcome/ativar_colider';
$route['direcao/colider/exclusao/permanente'] = 'welcome/excluir_colider_permanentemente';
// Colíderes

// Material de Apoio Treinamento
$route['direcao/page/material-apoio-treinamento'] = 'Direcao/pagina_material_apoio_treinamento'; // ok

// Download de Material
$route['direcao/page/download'] = 'Direcao/pagina_download_material';
$route['direcao/page/modulo'] = 'Direcao/pagina_download_material_modulo';

return $route;
