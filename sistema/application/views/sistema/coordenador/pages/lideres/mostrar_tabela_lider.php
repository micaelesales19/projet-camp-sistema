<?php
$dados_coordenadores = $info_lideres['dados_lideres_gerais']['dados'];
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

        var id_user = "<?= $info['dados']['id_coordenador']; ?>";

        var valor = sessionStorage.getItem("is_ativo") || '';
        var opc1 = sessionStorage.getItem("opc1") || 'opc1';
        var data_in = sessionStorage.getItem('data_in') || '2018-02-01';
        var data_final = sessionStorage.getItem('data_final') || '';

        // Variáveis globais
        let listaGlobal = [];
        const linhasPorPagina = 10;
        let paginaAtual = 1;

        // Função auxiliar
        function calcPercent(part, total) {
            return total > 0 ? ((part / total) * 100).toFixed(1) : "0.0";
        }

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
                    const dataCadastro = new Date(c.data_cadastro);
                    const dentroDoPeriodo = dataCadastro >= data_formatada_1 && dataCadastro <= data_formatada_2;
                    const ativo = valor === 'is_ativo' ? c.check_lider_ativo == 1 : true;
                    return dentroDoPeriodo && ativo;
                });
        }

        // Filtra coordenadores ativos e por datas
        function filtrarCoordenadoresTabela1() {
            const {
                data_formatada_1,
                data_formatada_2
            } = calcularDatas(opc1, new Date(), data_in, data_final);

            return lista_bd
                .filter(c => {
                    const dataCadastro = new Date(c.data_cadastro);
                    const dentroDoPeriodo = dataCadastro >= data_formatada_1 && dataCadastro <= data_formatada_2;
                    const ativo = c.check_lider_ativo;
                    return dentroDoPeriodo;
                });
        }

        // Preenche tabela de totais
        function preencher_primeira_tabela(lista) {
            const totais = lista.reduce((acc, item) => {
                acc.total_lideres += 1;

                if (item.check_lider_ativo == 1) {
                    acc.total_lideres_ativos += 1;
                } else {}

                acc.total_criancas += Number(item.total_criancas) || 0;


                if (item.check_lider_ativo == 1) {
                    acc.total_criancas_ativos += Number(item.total_criancas_ativos) || 0;
                } else {}

                return acc;
            }, {
                total_lideres: 0,
                total_lideres_ativos: 0,
                total_criancas: 0,
                total_criancas_ativos: 0
            });

            document.getElementById('td_total_lideres').innerText = totais.total_lideres;
            document.getElementById('td_total_lideres_ativos').innerText = totais.total_lideres_ativos;
            document.getElementById('td_percent_lideres').innerText = calcPercent(totais.total_lideres_ativos, totais.total_lideres) + "%";

            document.getElementById('td_total_criancas').innerText = totais.total_criancas;
            document.getElementById('td_total_criancas_ativos').innerText = totais.total_criancas_ativos;
            document.getElementById('td_percent_criancas').innerText = calcPercent(totais.total_criancas_ativos, totais.total_criancas) + "%";
        }

        // Preenche tabela principal
        function preencherTabela(dados) {
            const tabela = document.getElementById('tabela');
            const thead = tabela.querySelector('thead tr');
            const tbody = tabela.querySelector('tbody');

            thead.innerHTML = '';
            tbody.innerHTML = '';

            if (dados.length === 0) {
                tbody.innerHTML = '<tr><td colspan="100%">Nenhum líder encontrado</td></tr>';
                return;
            }

            const colunas = [{
                    chave: 'nome_lider',
                    titulo: 'Nome do Líder'
                },
                {
                    chave: 'igreja',
                    titulo: 'Igreja'
                },
                {
                    chave: 'telefone_whatsapp',
                    titulo: 'WhatsApp',
                    render: tel => tel || ''
                },
                {
                    chave: 'total_criancas',
                    titulo: 'Total Crianças'
                },
                {
                    chave: 'total_criancas_ativos',
                    titulo: 'Crianças Ativas'
                },
                {
                    chave: 'check_lider_ativo',
                    titulo: 'Situação',
                    render: function(data) {
                        return data == "1" ?
                            '<span class="label label-success">Ativo</span>' :
                            '<span class="label label-danger">Inativo</span>';
                    }
                },
                {
                    chave: 'id_lider',
                    titulo: 'Visualizar',
                    render: function(id) {
                        return `
                            <form action="lider/${id}" method="post" style="margin:0;">
                                <input type="hidden" name="id_lider" value="${id}">
                                <input type="submit" class="btn btn-info btn-sm" value="Visualizar" />
                            </form>`;
                    }
                },
                {
                    chave: 'telefone_whatsapp',
                    titulo: 'Enviar WhatsApp',
                    render: function(telefone) {
                        if (!telefone) return '';
                        return `
                            <button class="btn btn-success btn-sm" onclick="enviar_whatsapp('${telefone}')">
                                Enviar Mensagem
                            </button>`;
                    }
                }
            ];

            // Cabeçalho
            colunas.forEach(col => {
                const th = document.createElement('th');
                th.textContent = col.titulo;
                thead.appendChild(th);
            });

            // Corpo
            dados.forEach(item => {
                const tr = document.createElement('tr');
                colunas.forEach(col => {
                    const td = document.createElement('td');
                    td.innerHTML = col.render ? col.render(item[col.chave]) : (item[col.chave] ?? '');
                    tr.appendChild(td);
                });
                tbody.appendChild(tr);
            });
        }

        function atualizar_session() {

            document.getElementById('campoBusca').value = '';

            valor = sessionStorage.getItem("is_ativo");
            opc1 = sessionStorage.getItem("opc1");

            const th = document.getElementById('clicar');
            th.innerHTML = `Líderes` +
                (valor == 'is_ativo' ?
                    '<i class="fa fa-hand-pointer-o"></i>' :
                    '<i class="fa fa-hand-pointer-o icon-circle"></i>');

            const th_2 = document.getElementById('clicar_2');
            th_2.innerHTML = `Líderes Ativos` +
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
            preencher_primeira_tabela(listaFiltradaInicial);

            let listaFiltrada = filtrarCoordenadores();
            listaGlobal = listaFiltrada;
            console.log('RESPOSTA: ' + listaFiltradaInicial);
            mostrarPagina(paginaAtual, listaFiltrada);

            $('#campoBusca').on('input', function() {
                const termo = $(this).val().toLowerCase();

                // Usa sempre a lista global como base
                let resultados = listaGlobal;

                if (termo !== '') {
                    resultados = listaGlobal.filter(item =>
                        item.nome_lider.toLowerCase().includes(termo)
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
            th.innerHTML = `Líderes` +
                (valor == 'is_ativo' ?
                    '<i class="fa fa-hand-pointer-o"></i>' :
                    '<i class="fa fa-hand-pointer-o icon-circle"></i>');

            const th_2 = document.getElementById('clicar_2');
            th_2.innerHTML = `Líderes Ativos` +
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

        // Inicializa
        $(document).ready(function() {
            console.log('na função');
            atualizar_session();
        });
    </script>
</head>

<table class="table table-hover" id="numeros" width="100%" cellspacing="0">
    <thead>
        <tr>
            <!-- <th id="clicar" onclick="atualizarListaSemTotais(this);"></th>
            <th id="clicar_2" onclick="atualizarListaSemTotais(this);"></th>
            <th>% C.A.</th> -->
            <!-- <th>Líderes <i class="fa fa-hand-pointer-o"></i></th>
            <th>Líderes Ativos <i class="fa fa-hand-pointer-o"></i></th> -->
            <th id="clicar" onclick="atualizarListaSemTotais(this);"></th>
            <th id="clicar_2" onclick="atualizarListaSemTotais(this);"></th>
            <th>% L.A.</th>
            <th>Crianças <i class="fa fa-hand-pointer-o"></i></th>
            <th>Crianças Ativas <i class="fa fa-hand-pointer-o"></i></th>
            <th>% C.A.</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <!-- <td id="td_total_coordenadores"></td>
            <td id="td_total_coordenadores_ativos"></td>
            <td id="td_percent_coordenadores"></td> -->

            <td id="td_total_lideres"></td>
            <td id="td_total_lideres_ativos"></td>
            <td id="td_percent_lideres"></td>

            <td id="td_total_criancas"></td>
            <td id="td_total_criancas_ativos"></td>
            <td id="td_percent_criancas"></td>
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

<div id="paginacao" style="margin-top:10px;"></div>
