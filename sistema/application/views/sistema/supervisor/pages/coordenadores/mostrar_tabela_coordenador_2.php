<?php
$dados_coordenadores = $info_coordenadores['dados_coordenadores_gerais']['dados'];
?>

<head>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


    <script type="text/javascript">
        var lista_bd = <?= json_encode($dados_coordenadores, JSON_HEX_APOS | JSON_HEX_QUOT) ?>;

        var valor = sessionStorage.getItem("is_ativo") || '';
        var opc1 = sessionStorage.getItem("opc1") || 'opc1';
        var data_in = sessionStorage.getItem('data_in') || '2018-02-01';
        var data_final = sessionStorage.getItem('data_final') || '';

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

            //return lista_bd;

            return lista_bd.filter(c => {

                if (valor == '') {
                    // filtro por data
                    const dataCadastro = new Date(c.data_cadastro);
                    return dataCadastro >= data_formatada_1 && dataCadastro <= data_formatada_2;
                } else {
                    // filtro por ativo
                    return false;
                    //if (valor === '' && c.check_coordenador_ativo == 0) return false;
                }
            });
        }

        function preencher_primeira_tabela(lista) {
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

        function preencher_segunda_tabela(lista) {
            /*if ($.fn.DataTable.isDataTable('#tabela')) {
                $('#tabela').DataTable().clear().destroy();
            }*/

            // senão, cria a tabela pela primeira vez
            $('#tabela').DataTable({
                destroy: true, // <- Isso resolve seu problema
                data: lista,
                columns: [{
                        data: 'nome_coordenador',
                        title: 'Coordenador'
                    },
                    {
                        data: 'total_lideres',
                        title: 'Líderes'
                    },
                    {
                        data: 'total_lideres_ativos',
                        title: 'Líderes Ativos'
                    },
                    {
                        data: 'total_criancas',
                        title: 'Crianças'
                    },
                    {
                        data: 'total_criancas_ativos',
                        title: 'Crianças Ativos'
                    },
                    {
                        data: 'check_coordenador_ativo',
                        title: 'Situação',
                        render: function(data) {
                            if (data == "1") {
                                return '<span class="label label-success">Ativo</span>';
                            } else {
                                return '<span class="label label-danger">Inativo</span>';
                            }
                        }
                    },
                    {
                        data: 'id_coordenador',
                        title: 'Ação',
                        render: function(id) {
                            return `
                                <form action="coordenadores/detalhes/${id}" method="post">
                                    <input type="hidden" name="id_coordenador" value="${id}">
                                    <input type="submit" class="btn btn-info" value="Visualizar" />
                                </form>
                            `;
                        }
                    },
                    {
                        data: 'telefone_whatsapp',
                        title: 'Ação',
                        render: function(telefone) {
                            return `
                                <button class="btn btn-success" onclick="enviar_whatsapp('${telefone}')">
                                    Enviar Mensagem
                                </button>
                            `;
                        }
                    }
                ],
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json"
                }
            });
        }

        function so_atualizar_tabela(lista) {
            const tabela = $('#tabela').DataTable();
            tabela.clear();
            tabela.rows.add(lista);
            tabela.draw();
        }

        function atualizar_session() {
            valor = sessionStorage.getItem("is_ativo");
            opc1 = sessionStorage.getItem("opc1");

            data_in = sessionStorage.getItem('data_in') || '2018-02-01';
            data_final = sessionStorage.getItem('data_final') || '';

            console.log('ATUALIZAR SESSION');
            console.log("SESSION ATUALIZADA - ATIVO: ", valor);
            console.log("SESSION ATUALIZADA - OPC 1:", opc1);
            //console.log("SESSION ATUALIZADA - DATA INICIAL:", data_in);
            //console.log("SESSION ATUALIZADA - DATA FINAL:", data_final);

            const listaFiltrada = filtrarCoordenadores();
            preencher_primeira_tabela(listaFiltrada)
            so_atualizar_tabela(listaFiltrada);
            //console.log(listaFiltrada);
        }

        function iniciar() {
            console.log('INICIAR');
            valor = sessionStorage.getItem("is_ativo");
            opc1 = sessionStorage.getItem("opc1");

            data_in = sessionStorage.getItem('data_in') || '2018-02-01';
            data_final = sessionStorage.getItem('data_final') || '';

            console.log('ATUALIZAR SESSION');
            console.log("SESSION ATUALIZADA - ATIVO: ", valor);
            console.log("SESSION ATUALIZADA - OPC 1:", opc1);

            const listaFiltrada = filtrarCoordenadores();
            preencher_primeira_tabela(listaFiltrada)
            preencher_segunda_tabela(listaFiltrada);
            console.log(listaFiltrada);
        }

        // Inicializa
        $(document).ready(function() {
            iniciar();
        });
    </script>
</head>


<table class="table table-hover" id="numeros" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th id="clicar" onclick="voltar_list_coordenadores(this);"></th>
            <th id="clicar_2" onclick="list_coordenadores_ativos(this);"></th>
            <th>% C.A.</th>
            <th>Líderes <i class="fa fa-hand-pointer-o"></i></th>
            <th>Líderes Ativos <i class="fa fa-hand-pointer-o"></i></th>
            <th>% L.A.</th>
            <th>Crianças <i class="fa fa-hand-pointer-o"></i></th>
            <th>Crianças Ativas <i class="fa fa-hand-pointer-o"></i></th>
            <th>% C.A.</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td id="td_total_coordenadores"></td>
            <td id="td_total_coordenadores_ativos"></td>
            <td id="td_percent_coordenadores"></td>

            <td id="td_total_lideres"></td>
            <td id="td_total_lideres_ativos"></td>
            <td id="td_percent_lideres"></td>

            <td id="td_total_criancas"></td>
            <td id="td_total_criancas_ativos"></td>
            <td id="td_percent_criancas"></td>
        </tr>
    </tbody>
</table>

<table class="table table-bordered table-hover" id="tabela" width="100%">

</table>
