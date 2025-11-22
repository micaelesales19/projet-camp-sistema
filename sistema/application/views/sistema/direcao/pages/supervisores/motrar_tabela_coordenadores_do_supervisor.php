<?php
$dados_coordenadores = $info_coordenadores['dados_coordenadores_gerais']['dados'];
$foto = base_url('import/sistema/' . $dados_supervisor['dados']['foto']);
?>

<head>
    <!-- jQuery (atualizado) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- jQuery UI -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">
        var lista_bd = <?= json_encode($dados_coordenadores, JSON_HEX_APOS | JSON_HEX_QUOT) ?>;

        var id_user = "<?= $id_supervisor; ?>";
        var valor = sessionStorage.getItem("is_ativo") || '';
        var opc1 = sessionStorage.getItem("opc1") || 'opc1';
        var data_in = sessionStorage.getItem('data_in') || '2018-02-01';
        var data_final = sessionStorage.getItem('data_final') || '';

        // Variáveis globais
        let listaGlobal = [];
        const linhasPorPagina = 10;
        let paginaAtual = 1;

        // Calcula datas como no PHP
        function calcularDatas(opc1, dataAtual, dataInicio = '', dataFim = '') {
            let data_formatada_1;
            let data_formatada_2 = new Date(dataAtual);
            const dataAtualObj = new Date(dataAtual);
            if (opc1 === 'opc1') {
                const menosUmMes = new Date(dataAtualObj);
                menosUmMes.setMonth(menosUmMes.getMonth() - 1);
                data_formatada_1 = menosUmMes;
            } else if (opc1 === 'opc2') {
                const menosSeisMeses = new Date(dataAtualObj);
                menosSeisMeses.setMonth(menosSeisMeses.getMonth() - 6);
                data_formatada_1 = menosSeisMeses;
            } else if (opc1 === 'opc3') {
                data_formatada_1 = new Date('2017-02-01');
            } else if (opc1 === 'opc4') {
                if (dataInicio && dataFim) {
                    data_formatada_1 = new Date(dataInicio);
                    data_formatada_2 = new Date(dataFim);
                } else {
                    data_formatada_1 = new Date('2017-02-01');
                    data_formatada_2 = dataAtualObj;
                }
            }

            return {
                data_formatada_1,
                data_formatada_2
            };
        }

        // Filtra coordenadores ativos e por datas
        function filtrarCoordenadores() {
            const {
                data_formatada_1,
                data_formatada_2
            } = calcularDatas(opc1, new Date(), data_in, data_final);

            return lista_bd
                .filter(c => {
                    const d = new Date(c.data_cadastro);
                    const dataCadastro = isNaN(d) ? new Date('2018-02-01') : d;

                    const dentroDoPeriodo = dataCadastro >= data_formatada_1 && dataCadastro <= data_formatada_2;
                    const ativo = valor === 'is_ativo' ? c.check_coordenador_ativo == 1 : true;
                    return dentroDoPeriodo && ativo;
                })
                .map(c => {
                    const listaLideres = c.lista_lideres?.dados || [];

                    // Filtra líderes dentro do período
                    const lideresNoPeriodo = listaLideres.filter(l => {
                        const d2 = new Date(l.data_cadastro);
                        const dataLider = isNaN(d2) ? new Date('2018-02-01') : d2;
                        return dataLider >= data_formatada_1 && dataLider <= data_formatada_2;
                    });

                    // Conta todos os líderes filtrados
                    const totalLideresFiltrados = lideresNoPeriodo.length;

                    // Conta apenas os líderes ativos (confirmado == 2)
                    const totalLideresAtivos = lideresNoPeriodo.filter(l => l.confirmado == 2).length;

                    return {
                        ...c,
                        total_lideres_filtrados: totalLideresFiltrados,
                        total_lideres_ativos_filtrados: totalLideresAtivos,
                        lista_lideres_filtrados: lideresNoPeriodo // opcional
                    };
                });
        }

        // Filtra coordenadores ativos e por datas
        function filtrarCoordenadoresTabela1() {
            const {
                data_formatada_1,
                data_formatada_2
            } = calcularDatas(opc1, new Date(), data_in, data_final);

            /*return lista_bd.filter(c => {
                const dataCadastro = new Date(c.data_cadastro);
                // Primeiro: aplica sempre o filtro de data
                const dentroDoPeriodo = dataCadastro >= data_formatada_1 && dataCadastro <= data_formatada_2;
                return dentroDoPeriodo;
            });*/
            /*lista_bd.filter(c => {
                const d = new Date(c.data_cadastro);
                const dataCadastro = isNaN(d) ? new Date('2018-02-01') : d;
                // Primeiro: aplica sempre o filtro de data
                const dentroDoPeriodo = dataCadastro >= data_formatada_1 && dataCadastro <= data_formatada_2;
                console.log(dataCadastro);
            });*/


            return lista_bd
                .filter(c => {
                    const d = new Date(c.data_cadastro);
                    const dataCadastro = isNaN(d) ? new Date('2018-02-01') : d;
                    const dentroDoPeriodo = dataCadastro >= data_formatada_1 && dataCadastro <= data_formatada_2;
                    return dentroDoPeriodo;
                })
                .map(c => {
                    // Aqui entra o segundo filtro — dentro de cada coordenador, filtramos os líderes
                    const listaLideres = c.lista_lideres?.dados || [];

                    // Filtra líderes que estão dentro do mesmo período de datas
                    const lideresNoPeriodo = listaLideres.filter(l => {
                        const d2 = new Date(l.data_cadastro);
                        const dataLider = isNaN(d2) ? new Date('2018-02-01') : d2;
                        return dataLider >= data_formatada_1 && dataLider <= data_formatada_2;
                    });

                    // Conta quantos passaram no filtro
                    const totalLideresFiltrados = lideresNoPeriodo.length;

                    // Retorna o coordenador com o novo campo somado
                    return {
                        ...c,
                        total_lideres_filtrados: totalLideresFiltrados,
                        lista_lideres_filtrados: lideresNoPeriodo // opcional, se quiser usar depois
                    };
                });
        }

        function preencher_primeira_tabela(lista) {
            const totais = lista.reduce((acc, item) => {
                acc.total_coordenadores += 1;
                acc.total_coordenadores_ativos += item.check_coordenador_ativo == 1 ? 1 : 0;
                acc.total_lideres += Number(item.total_lideres) || 0;
                acc.total_lideres_ativos += Number(item.total_lideres_ativos) || 0;
                acc.total_criancas += Number(item.total_criancas) || 0;
                acc.total_criancas_ativos += Number(item.total_criancas_ativos) || 0;
                return acc;
            }, {
                total_coordenadores: 0,
                total_coordenadores_ativos: 0,
                total_lideres: 0,
                total_lideres_ativos: 0,
                total_criancas: 0,
                total_criancas_ativos: 0
            });

            //console.log(totais);

            // Calcula porcentagens (evita divisão por 0)
            function calcPercent(part, total) {
                return total > 0 ? ((part / total) * 100).toFixed(1) : "0.0";
            }

            document.getElementById('td_total_coordenadores').innerText = totais.total_coordenadores;
            document.getElementById('td_total_coordenadores_ativos').innerText = totais.total_coordenadores_ativos;
            document.getElementById('td_percent_coordenadores').innerText = calcPercent(totais.total_coordenadores_ativos, totais.total_coordenadores) + "%";

            document.getElementById('td_total_lideres').innerText = totais.total_lideres;
            document.getElementById('td_total_lideres_ativos').innerText = totais.total_lideres_ativos;
            document.getElementById('td_percent_lideres').innerText = calcPercent(totais.total_lideres_ativos, totais.total_lideres) + "%";

            document.getElementById('td_total_criancas').innerText = totais.total_criancas;
            document.getElementById('td_total_criancas_ativos').innerText = totais.total_criancas_ativos;
            document.getElementById('td_percent_criancas').innerText = calcPercent(totais.total_criancas_ativos, totais.total_criancas) + "%";
        }

        var tabela; // variável global da tabela

        function preencherTabela(dados) {
            const tabela = document.getElementById('tabela');
            const thead = tabela.querySelector('thead tr');
            const tbody = tabela.querySelector('tbody');

            thead.innerHTML = '';
            tbody.innerHTML = '';

            if (dados.length === 0) {
                tbody.innerHTML = '<tr><td colspan="100%">Nenhum dado encontrado</td></tr>';
                return;
            }

            const colunas = [{
                    chave: 'nome_coordenador',
                    titulo: 'Nome do Coordenador'
                },
                {
                    chave: 'total_lideres',
                    titulo: 'Total Líderes'
                },
                {
                    chave: 'total_lideres_ativos',
                    titulo: 'Líderes Ativos'
                },
                {
                    chave: 'total_criancas',
                    titulo: 'Total Crianças'
                },
                {
                    chave: 'total_criancas_ativos',
                    titulo: 'Crianças Ativas'
                },
                // 🟢 Situação (ativo/inativo)
                {
                    chave: 'check_coordenador_ativo',
                    titulo: 'Situação',
                    render: function(data) {
                        return data == "1" ?
                            '<span class="label label-success">Ativo</span>' :
                            '<span class="label label-danger">Inativo</span>';
                    }
                },
                // 🔵 Ação: Visualizar
                {
                    chave: 'id_coordenador',
                    titulo: 'Visualizar',
                    render: function(id) {
                        return `
                    <form action="coordenador/lideres/${id}" method="post" style="margin:0;">
                        <input type="hidden" name="id_coordenador" value="${id}">
                        <input type="submit" class="btn btn-info btn-sm" value="Visualizar" />
                    </form>
                `;
                    }
                },
                // 🟢 Ação: Enviar WhatsApp
                {
                    chave: 'telefone_whatsapp',
                    titulo: 'WhatsApp',
                    render: function(telefone) {
                        if (!telefone) return '';
                        return `
                    <button class="btn btn-success btn-sm" onclick="enviar_whatsapp('${telefone}')">
                        Enviar Mensagem
                    </button>
                `;
                    }
                }
            ];

            // Criar cabeçalho fixo
            colunas.forEach(col => {
                const th = document.createElement('th');
                th.textContent = col.titulo;
                thead.appendChild(th);
            });

            // Criar linhas do corpo
            dados.forEach(item => {
                const tr = document.createElement('tr');

                colunas.forEach(col => {
                    const td = document.createElement('td');
                    if (col.render) {
                        td.innerHTML = col.render(item[col.chave]); // usa render personalizado
                    } else {
                        td.textContent = item[col.chave] ?? ''; // mostra o texto direto
                    }
                    tr.appendChild(td);
                });

                tbody.appendChild(tr);
            });
        }

        function mostrarPagina(pagina, lista = listaGlobal) {
            const inicio = (pagina - 1) * linhasPorPagina;
            const fim = inicio + linhasPorPagina;
            const dadosPagina = lista.slice(inicio, fim);
            preencherTabela(dadosPagina);
            criarPaginacao(pagina, lista);
        }

        function criarPaginacao(paginaAtual, lista) {
            console.log('criando paginação');

            const div = document.getElementById('paginacao');
            div.innerHTML = '';

            const totalPaginas = Math.ceil(lista.length / linhasPorPagina);
            const maxLinks = 3; // número de links antes e depois da página atual

            // Botão "Anterior"
            const btnAnterior = document.createElement('button');
            btnAnterior.textContent = '« Anterior';
            btnAnterior.className = 'btn btn-sm btn-outline-primary mx-1';
            btnAnterior.disabled = paginaAtual === 1;
            btnAnterior.onclick = () => mostrarPagina(paginaAtual - 1, lista);
            div.appendChild(btnAnterior);

            // Calcula o intervalo de páginas a exibir
            const inicio = Math.max(1, paginaAtual - maxLinks);
            const fim = Math.min(totalPaginas, paginaAtual + maxLinks);

            // Adiciona reticências no início, se necessário
            if (inicio > 1) {
                const btnPrimeira = document.createElement('button');
                btnPrimeira.textContent = '1';
                btnPrimeira.className = 'btn btn-sm btn-outline-primary mx-1';
                btnPrimeira.onclick = () => mostrarPagina(1, lista);
                div.appendChild(btnPrimeira);

                if (inicio > 2) {
                    const span = document.createElement('span');
                    span.textContent = '...';
                    span.className = 'mx-1';
                    div.appendChild(span);
                }
            }

            // Botões numéricos próximos da atual
            for (let i = inicio; i <= fim; i++) {
                const btn = document.createElement('button');
                btn.textContent = i;
                btn.className = i === paginaAtual ?
                    'btn btn-sm btn-primary mx-1' :
                    'btn btn-sm btn-outline-primary mx-1';
                btn.onclick = () => mostrarPagina(i, lista);
                div.appendChild(btn);
            }

            // Adiciona reticências no final, se necessário
            if (fim < totalPaginas) {
                if (fim < totalPaginas - 1) {
                    const span = document.createElement('span');
                    span.textContent = '...';
                    span.className = 'mx-1';
                    div.appendChild(span);
                }

                const btnUltima = document.createElement('button');
                btnUltima.textContent = totalPaginas;
                btnUltima.className = 'btn btn-sm btn-outline-primary mx-1';
                btnUltima.onclick = () => mostrarPagina(totalPaginas, lista);
                div.appendChild(btnUltima);
            }

            // Botão "Próximo"
            const btnProximo = document.createElement('button');
            btnProximo.textContent = 'Próximo »';
            btnProximo.className = 'btn btn-sm btn-outline-primary mx-1';
            btnProximo.disabled = paginaAtual === totalPaginas;
            btnProximo.onclick = () => mostrarPagina(paginaAtual + 1, lista);
            div.appendChild(btnProximo);
        }

        function atualizar_session() {

            document.getElementById('campoBusca').value = '';

            valor = sessionStorage.getItem("is_ativo");
            opc1 = sessionStorage.getItem("opc1");

            const th = document.getElementById('clicar');
            th.innerHTML = `Coordenadores` +
                (valor == 'is_ativo' ?
                    '<i class="fa fa-hand-pointer-o"></i>' :
                    '<i class="fa fa-hand-pointer-o icon-circle"></i>');

            const th_2 = document.getElementById('clicar_2');
            th_2.innerHTML = `Coordenadores Ativos` +
                (valor == 'is_ativo' ?
                    '<i class="fa fa-hand-pointer-o icon-circle"></i>' :
                    '<i class="fa fa-hand-pointer-o"></i>');

            data_in = sessionStorage.getItem('data_in') || '2018-02-01';
            data_final = sessionStorage.getItem('data_final') || '';

            console.log('INICIAR SESSION');
            console.log("SESSION ATUALIZADA - ATIVO: ", valor);
            console.log("SESSION ATUALIZADA - OPC 1:", opc1);

            console.log('SUCESSO');

            let listaFiltradaInicial = filtrarCoordenadoresTabela1();

            let listaFiltrada = filtrarCoordenadores();
            listaGlobal = listaFiltrada;

            console.log('RESPOSTA: ' + listaFiltrada);

            preencher_primeira_tabela(listaFiltradaInicial);
            mostrarPagina(paginaAtual, listaFiltrada);

            $('#campoBusca').on('input', function() {
                const termo = $(this).val().toLowerCase();

                // Usa sempre a lista global como base
                let resultados = listaGlobal;

                if (termo !== '') {
                    resultados = listaGlobal.filter(item =>
                        item.nome_coordenador.toLowerCase().includes(termo)
                    );
                }

                paginaAtual = 1; // volta pra primeira página ao pesquisar
                mostrarPagina(paginaAtual, resultados);
            });
        }

        function atualizarListaSemTotais() {

            if (sessionStorage.getItem("is_ativo") == '') {
                sessionStorage.setItem("is_ativo", "is_ativo");
            } else {
                sessionStorage.setItem("is_ativo", "");
            }

            valor = sessionStorage.getItem("is_ativo");
            opc1 = sessionStorage.getItem("opc1");

            const th = document.getElementById('clicar');
            th.innerHTML = `Coordenadores` +
                (valor == 'is_ativo' ?
                    '<i class="fa fa-hand-pointer-o"></i>' :
                    '<i class="fa fa-hand-pointer-o icon-circle"></i>');

            const th_2 = document.getElementById('clicar_2');
            th_2.innerHTML = `Coordenadores Ativos` +
                (valor == 'is_ativo' ?
                    '<i class="fa fa-hand-pointer-o icon-circle"></i>' :
                    '<i class="fa fa-hand-pointer-o"></i>');

            console.log('ATUALIZAR LISTA SEM TOTAIS');
            console.log("SESSION ATUALIZADA - ATIVO: ", valor);
            console.log("SESSION ATUALIZADA - OPC 1:", opc1);

            // apenas refaz a lista e tabela de baixo
            let listaFiltrada = filtrarCoordenadores();
            //listaGlobal = listaFiltrada;

            mostrarPagina(paginaAtual, listaFiltrada);
        }

        // Inicializa
        $(document).ready(function() {
            console.log('na função');

            // modal - excluir supervisor permanente
            const pesquisarInput_3 = document.getElementById('pesquisaSupervisor');
            if (pesquisarInput_3) {
                pesquisarInput_3.addEventListener('input', function() {
                    const filtro = this.value.toLowerCase();
                    document.querySelectorAll('#listaSupervisores_3 .form-check').forEach(div => {
                        const texto = div.innerText.toLowerCase();
                        div.style.display = texto.includes(filtro) ? '' : 'none';
                    });
                });
            }

            const form_3 = document.querySelector('form#form_exclusao_supervisor_permanentemente');
            if (!form_3) return; // evita erro se o formulário não existir

            const checkboxes_3 = document.querySelectorAll('.checkbox-supervisor-3');
            const inputHidden_3 = document.getElementById('idSupervisorNovoTroca');

            function atualizarSelecaoUnica_3(event) {
                checkboxes_3.forEach(cb => {
                    if (cb !== event.target) cb.checked = false;
                });
                const selecionado = Array.from(checkboxes_3)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value)
                    .join(',');
                inputHidden_3.value = selecionado;
                console.log('Selecionado:', inputHidden_3.value);
            }

            checkboxes_3.forEach(cb => cb.addEventListener('change', atualizarSelecaoUnica_3));

            form_3.addEventListener('submit', function(e) {
                e.preventDefault();

                if (!inputHidden_3.value) {
                    Swal.fire({
                        title: 'Atenção!',
                        text: 'Você precisa selecionar 1 coordenador.',
                        icon: 'warning',
                        confirmButtonText: 'Ok',
                        confirmButtonColor: '#198754',
                    });
                } else {
                    Swal.fire({
                        title: "Cuidado!",
                        text: "Essa alteração é irrevessível.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Continuar",
                        cancelButtonText: "Cancelar",
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form_3.submit();
                        }
                    });
                }
            });

            atualizar_session();
        });
    </script>
</head>

<table class="table table-hover" id="numeros" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th><?= $dados_supervisor['dados']['nome_supervisorR']; ?></th>
            <th id="clicar" onclick="atualizarListaSemTotais(this);"></th>
            <th id="clicar_2" onclick="atualizarListaSemTotais(this);"></th>
            <th>% C.A.</th>
            <th>Líderes <i class="fa fa-hand-pointer-o"></i></th>
            <th>Líderes Ativos <i class="fa fa-hand-pointer-o"></i></th>
            <th>% L.A.</th>
            <th>Crianças <i class="fa fa-hand-pointer-o"></i></th>
            <th>Crianças Ativas <i class="fa fa-hand-pointer-o"></i></th>
            <th>% C.A.</th>
            <th>Ação</th>
            <th>Ação</th>
            <th>Ação</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td>
                <img src="<?= $foto; ?>" alt="" id="imgPhoto_usuario">
            </td>
            <td id="td_total_coordenadores"></td>
            <td id="td_total_coordenadores_ativos"></td>
            <td id="td_percent_coordenadores"></td>

            <td id="td_total_lideres"></td>
            <td id="td_total_lideres_ativos"></td>
            <td id="td_percent_lideres"></td>

            <td id="td_total_criancas"></td>
            <td id="td_total_criancas_ativos"></td>
            <td id="td_percent_criancas"></td>
            <td>
                <form action="detalhes/<?= $dados_supervisor['dados']['id_supervisorR']; ?>" method="post">
                    <input type="hidden" name="id_supervisor" value="<?= $dados_supervisor['dados']['id_supervisorR']; ?>">
                    <input type="submit" class="btn btn-info" value="Visualizar" />
                </form>
            </td>

            <td style="display:flex;gap: 10px;">
                <?php
                if ($dados_supervisor['dados']['ativo'] == 0) {
                ?>
                    <form action="reativar" method="post">
                        <input type="hidden" name="idUsuario" value="<?= $id_usuario; ?>">
                        <input type="hidden" name="id_supervisor" value="<?= $dados_supervisor['dados']['id_supervisorR']; ?>">
                        <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">
                        <input type="submit" class="btn btn-warning" value="Ativar" />
                    </form>
                <?php
                } else {
                ?>
                    <form action="desativar" method="post">
                        <input type="hidden" name="idUsuario" value="<?= $dados_supervisor['dados']['id_supervisorR']; ?>">
                        <input type="hidden" name="id_supervisor" value="<?= $dados_supervisor['dados']['id_supervisorR']; ?>">
                        <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">
                        <input type="submit" class="btn btn-default" value="Desativar" />
                    </form>
                <?php } ?>

                <button type="button" class="btn btn-danger pull-left" data-toggle="modal" data-target="#excluir_supervisor_permantemente">Excluir Permanentemente</button>
            </td>
            <td id="clicar" onclick="enviar_whatsapp('<?= $dados_supervisor['dados']['telefone_whatsapp']; ?>');"><input type="submit" class="btn btn-success" value="Enviar Mensagem" /></td>
        </tr>
    </tbody>
</table>

<div class="mb-3">
    <input type="text" id="campoBusca" class="form-control" placeholder="🔍 Pesquisar por nome..." />
</div><br>

<table class="table table-bordered table-hover" id="tabela" width="100%">
    <thead>
        <tr></tr>
    </thead>
    <tbody>
    </tbody>
</table>

<div class="modal fade" id="excluir_supervisor_permantemente">
    <div class="modal-dialog modal-danger">
        <div class="modal-content">
            <form action="excluir" id="form_exclusao_supervisor_permanentemente" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Excluir Supervisor Permanentemente</h4>
                </div>

                <div class="box-body">
                    <input type="hidden" name="idUsuario" value="<?= $id_usuario; ?>">
                    <input type="hidden" name="opc" value="<?= $id_supervisor; ?>">
                    <input type="hidden" name="red" value="https://sistema.campbrasil.com/sistema/direcao/page/supervisores">
                    <input type="hidden" name="id_novo_supervisor" id="idSupervisorNovoTroca" value="0">

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="exampleInputPassword1">Conte-nos o motivo:</label>
                            <textarea name="motivo" class="form-control"></textarea>
                        </div>

                        <div class="form-group txt_center">
                            <label for="exampleInputEmail1">Deseja realmente excluir esse Supervisor permanente?</label>
                        </div>

                        <?php
                        $lideres_do_supervisor = $this->Lideres->infos([$id_supervisor], 'query_lideres_id_supervisor', '', '');
                        $coordenadores_do_supervisor = $this->Coordenadores->infos([$id_supervisor], 'info_coordenador_id_supervisor', '', '');
                        if ($lideres_do_supervisor['row'] == 0 && $coordenadores_do_supervisor['row'] == 0) {
                        } else {
                        ?>
                            <label for="id_coordenador_troca">Selecione um novo supervisor para os coordenadores e líderes:</label>

                            <!-- Caixa de pesquisa -->
                            <input type="text" id="pesquisaSupervisor" class="form-control mb-3" placeholder="Pesquisar Supervisor..."><br>

                            <!-- Lista de líderes -->
                            <div id="listaSupervisores_3" style="max-height: 300px; overflow-y: auto;">

                                <div class="form-check">
                                    <input class="form-check-input checkbox-supervisor-3" type="checkbox" value="0" id="coord0">
                                    <label class="form-check-label" for="coord0">
                                        Sem supervisor
                                    </label>
                                </div>

                                <?php
                                // exemplo: buscando do banco
                                $supervisores = $this->db->query("SELECT id_supervisorR, nome_supervisorR FROM supervisor_local ORDER BY nome_supervisorR ASC")->result_array();
                                foreach ($supervisores as $c) {
                                    if ($c['id_supervisorR'] == $id_supervisor) {
                                    } else {
                                ?>
                                        <div class="form-check">
                                            <input class="form-check-input checkbox-supervisor-3" type="checkbox" value="<?= $c['id_supervisorR']; ?>" id="coord<?= $c['id_supervisorR']; ?>">
                                            <label class="form-check-label" for="coord<?= $c['id_supervisorR']; ?>">
                                                <?= htmlspecialchars($c['nome_supervisorR']); ?>
                                            </label>
                                        </div>
                                <?php }
                                } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Não</button>
                    <input type="submit" class="btn btn-default pull-right" value="Sim">
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="paginacao" style="margin-top:10px;"></div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
