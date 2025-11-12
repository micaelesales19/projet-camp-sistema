<?php

$route['supervisor/home'] = 'Supervisor/home'; // ok

// Dados Pessoais
$route['supervisor/pagina_editar_pessoal'] = 'Supervisor/pagina_editar_pessoal';
$route['supervisor/salvar_edicao'] = 'Supervisor/e_pessoal';
// Fim Dados Pessoais

// lideres
$route['supervisor/page/lideres'] = 'Supervisor/pagina_ver_lideres'; // ok
$route['supervisor/page/lideres/mostrar'] = 'Supervisor/mostrar_table_lider'; // ok

$route['supervisor/page/lideres/gerar_excel'] = 'welcome/gerar_excel';

$route['supervisor/page/lider/salvar'] = 'Lider/e_pessoal'; // ok
$route['supervisor/page/lider/desativar'] = 'welcome/desativar_lider'; // ok
$route['supervisor/page/lider/reativar'] = 'welcome/ativar_lider'; // ok
$route['supervisor/page/lider/excluir'] = 'welcome/excluir_lider_permanentemente'; // ok
$route['supervisor/page/lider/trocar-liderenca'] = 'welcome/trocar_liderenca'; // ok

// coordenador - líder
$route['supervisor/page/coordenadores/lider/salvar'] = 'Lider/e_pessoal'; // ok
$route['supervisor/page/coordenadores/lider/desativar'] = 'welcome/desativar_lider'; // ok
$route['supervisor/page/coordenadores/lider/reativar'] = 'welcome/ativar_lider'; // ok
$route['supervisor/page/coordenadores/lider/excluir'] = 'welcome/excluir_lider_permanentemente'; // ok
$route['supervisor/page/coordenadores/lider/trocar-liderenca'] = 'welcome/trocar_liderenca'; // ok

$route['supervisor/page/coordenadores/lider/:any'] = 'Supervisor/pagina_ver_detalhes_lider'; // tô trabalhando aqui agora

$route['supervisor/page/lider/:any'] = 'Supervisor/pagina_ver_detalhes_lider';

// coordenadores
$route['supervisor/page/coordenadores'] = 'Supervisor/pagina_ver_coordenadores'; // ok
$route['supervisor/page/coordenadores/salvar'] = 'welcome/cadastro_coordenador'; // ok
$route['supervisor/page/coordenadores/edicao/salvar'] = 'Coordenador/e_pessoal'; // ok
$route['supervisor/page/coordenadores/desativar'] = 'welcome/desativar_coordenador'; // ok
$route['supervisor/page/coordenadores/exclusao/ativar'] = 'welcome/ativar_coordenador'; // ok
$route['supervisor/page/coordenadores/exclusao/permanente'] = 'welcome/excluir_coordenador_permanentemente'; // ok

$route['supervisor/page/coordenadores/mostrar'] = 'Supervisor/mostrar_table_coordenador'; // ok
$route['supervisor/page/coordenadores/lideres/mostrar'] = 'Supervisor/mostrar_table_lideres_coordenador'; // ok

$route['supervisor/page/coordenadores/lideres/:any'] = 'Supervisor/pagina_ver_lideres_coordenadores';
$route['supervisor/page/coordenadores/detalhes/:any'] = 'Supervisor/pagina_ver_detalhes_coordenadores';

$route['supervisor/page/coordenadores/gerar_excel'] = 'welcome/gerar_excel';

// red
$route['supervisor/page/lideres_do_coordenador/:any'] = 'welcome/red_lideres_coord';
$route['supervisor/page/info_lider_pessoal/:any/:any'] = 'welcome/red_lideres_info_licao';

// pg
$route['supervisor/page/pg/cadastro/salvar'] = 'welcome/cadastro_pg'; // ok
$route['supervisor/page/pg/edicao/salvar'] = 'welcome/editar_pg'; // ok
$route['supervisor/page/pg/exclusao/desativar'] = 'welcome/desativar_pg';
$route['supervisor/page/pg/exclusao/ativar'] = 'welcome/ativar_pg';
$route['supervisor/page/pg/exclusao/permanente'] = 'welcome/excluir_pg_permanentemente';

$route['supervisor/page/pg/consultarProgresso'] = 'Lider/consulta_progresso_pg'; // ok

$route['supervisor/page/pg/licoes'] = 'Supervisor/pagina_licoes'; // ok
$route['supervisor/page/pg/preenchimento'] = 'Supervisor/pagina_preenchimento_relatorio_pg'; // ok
$route['supervisor/page/pg/visualizar'] = 'Supervisor/pagina_visualizacao_relatorio_pg'; // ok
$route['supervisor/page/pg/consultas/retornar_informacoes_criancas_pg'] = 'Supervisor/consulta_criancas_relatorios'; // ok
$route['supervisor/page/pg/consultas/retornar_informacoes_relatorio_pg'] = 'Supervisor/consulta_relatorio_pg'; // ok
$route['supervisor/page/pg/preenchimento/salvar'] = 'welcome/salvar_relatorio'; // ok
$route['supervisor/page/pg/preenchimento/edicao'] = 'welcome/edicao_relatorio'; // ok

$route['supervisor/page/criancas/cadastro/salvar'] = 'welcome/cadastro_crianca'; // ok
$route['supervisor/page/criancas/edicao/salvar'] = 'welcome/editar_crianca'; // ok
$route['supervisor/page/criancas/exclusao/desativar'] = 'welcome/desativar_crianca'; // ok
$route['supervisor/page/criancas/exclusao/ativar'] = 'welcome/ativar_crianca'; // ok
$route['supervisor/page/criancas/exclusao/permanente'] = 'welcome/excluir_crianca_permanentemente'; // ok
$route['supervisor/page/criancas/gerar/relatorio'] = 'welcome/RelatoriosCriancas'; // ok

// Colíderes
$route['supervisor/colider/cadastro/salvar'] = 'welcome/cadastro_colider'; // ok
$route['supervisor/colider/desativar'] = 'welcome/desativar_colider'; // ok
$route['supervisor/colider/ativar'] = 'welcome/ativar_colider'; // ok
$route['supervisor/colider/exclusao/permanente'] = 'welcome/excluir_colider_permanentemente'; // ok
// Colíderes

// Material de Apoio Treinamento
$route['supervisor/page/material-apoio-treinamento'] = 'Supervisor/pagina_material_apoio_treinamento'; // ok

// Download de Material
$route['supervisor/page/download'] = 'Supervisor/pagina_download_material'; // ok
$route['supervisor/page/modulo'] = 'Supervisor/pagina_download_material_modulo'; // ok

// PG
$route['supervisor/page/pg'] = 'Supervisor/pagina_visualizacao_pg';

return $route;
