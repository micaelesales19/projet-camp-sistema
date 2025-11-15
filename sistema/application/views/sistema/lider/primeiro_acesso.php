<?php

if (!isset($_SESSION['usuario'])) {
	header("location: index");
} else {

	require_once(APPPATH . '../import/sistema/materiais/materiais_1_trilha.php');

	$url_redirecionamento = current_url() . ($_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '');

	$id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";
	$id_usuario_2 = ($_SESSION["id_usuario_2"]) ? $_SESSION["id_usuario_2"] : "";

	$nivel = $_POST['nivel'];
	$x_ir = $_POST['x_ir'];

	if ($x_ir == "") {
		$x_ir .= "";
	}

	$query = $this->Lideres->infos([$id_usuario], 'info_lider', '', '', '');
	$dados_lider = $query['dados'];

	/*$consultarPG = $this->PG->query([$id_usuario], 1, 1);
	$totalPG = $consultarPG['row'];*/

	$check_se_tem_pg = $this->PG->check_cadastro_pg('check_id_lider', [$id_usuario]);
?>
	<!DOCTYPE html>
	<html>
	<!-- Head -->
	<?php
	$this->load->view('partes/head');
	?>

	<body class="hold-transition skin-blue sidebar-mini">
		<div class="">
			<!-- Content . Contains page content -->
			<div class="content">

				<!-- Content Header (Page header) -->
				<?php if ($check_se_tem_pg) { ?>
					<section class="content-header">
						<center>
							<h1>
								Primeiro Acesso |
								<small>Sistema CAMP Brasil</small>
							</h1>

							<ol class="breadcrumb">
								<li class="active"><a href="#"><i class="fa fa-circle"></i> Cadastrar PG</a></li>
								<li class="active">Cadastrar Crianças</li>
								<li class="active">Download de Material</li>
							</ol>
						</center>
					</section>

					<section class="content">
						<!-- Small boxes (Stat box) -->
						<div class="row">
							<div class="box-body chat" id="chat-box">
								<form action="pg/cadastro/salvar" role="form" method="POST" enctype="multipart/form-data">
									<div class="box-body">
										<input class="form-control" type="hidden" name="idLider" value="<?= $id_usuario; ?>">
										<input class="form-control" type="hidden" name="nivel" value="<?= $nivel; ?>">

										<div class="col-lg-12">
											<div class="form-group">
												<label for="exampleInputEmail1">Nome para o PG</label>
												<input class="form-control" type="text" name="nome_pg" aria-describedby="emailHelp" placeholder="Informe o nome para o PG" required>
											</div>
										</div>

										<div class="col-lg-12">
											<div class="form-group">
												<label for="exampleInputPassword1">Data de Início</label>
												<p style="color: black;"><input type="text" autocomplete="off" name="data_inicio" placeholder="DD/MM/AAAA" class="form-control" id="datepicker_cadastro_pg" required></p>
											</div>
										</div>

										<div class="col-lg-12">
											<div class="form-group">
												<label>
													<input type="checkbox" name="autorizacao" value="1"> Desejo receber notificações por e-mail
												</label>
											</div>
										</div>

									</div>
									<div class="box-footer">
										<div class="pull-right">
											<input type="submit" class="btn btn-success" name="btn_form" value="Salvar">
								</form>
								<form action="pg/pular" method="post">
									<input type="hidden" name="idLider" value="<?= $id_usuario ?>">
									<input type="hidden" name="nome" value="<?= $dados_lider['nome_lider']; ?>">
									<input type="hidden" name="nivel" value="1">
									<br><input type="submit" value="Pular" class="btn btn-warning">
								</form>
							</div>
						</div>

						<script>
							$(function() {
								$("#datepicker_cadastro_pg").datepicker({
									dateFormat: 'dd/mm/yy',
									closeText: "Fechar",
									prevText: "&#x3C;Anterior",
									nextText: "Próximo&#x3E;",
									currentText: "Hoje",
									monthNames: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
									monthNamesShort: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
									dayNames: ["Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado"],
									dayNamesShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
									dayNamesMin: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
									weekHeader: "Sm",
									firstDay: 1,
									minDate: 0,
								});
							});
						</script>
			</div>
		</div>
		<!-- /.box -->
		</section>

		<?php } else {

					//$consultaCriancas = $funcao->mostrarCriancasPaisPg($id_usuario, $consultarPG['dados']['id_pg'], 2);
					$check_se_tem_crianca = $this->Criancas->check_criancas_cadastrada('check_criancas_id_lider', [$id_usuario]);

					if ($check_se_tem_crianca && $x_ir != 3) {
						$consultarPG = $this->PG->query([$id_usuario], 'query_pg_id_lider_all_ativo_or_no', 1);

		?>
			<section class="content-header">
				<center>
					<h1>
						Primeiro Acesso |
						<small>Sistema CAMP Brasil</small>
					</h1>

					<ol class="breadcrumb">
						<li class="active">Cadastrar PG</li>
						<li class="active"><a href="#"><i class="fa fa-circle"></i> Cadastrar Crianças</a></li>
						<li class="active">Download de Material</li>
					</ol>
				</center>
			</section>

			<section class="content">
				<!-- Small boxes (Stat box) -->
				<div class="row">
					<div class="box-body chat" id="chat-box">
						<form action="criancas/cadastro/salvar" role="form" method="POST" enctype="multipart/form-data">
							<div class="box-body">
								<input class="form-control" id="id_lider" type="hidden" name="id_lider" value="<?= $id_usuario; ?>">
								<input class="form-control" type="hidden" name="nivel" value="<?= $nivel; ?>">
								<div class="col-lg-12">
									<div class="form-group">
										<label for="exampleInputEmail1">PG</label>
										<select name="id_pg" id="id_pg" class="form-control">
											<optgroup label="Seu PG">
												<?php
												foreach ($consultarPG['dados'] as $key => $val) {
												?>
													<option value="<?= $val['id_pg'] ?>"><?= $val['nome_pg'] ?></option>
												<?php } ?>
										</select>
									</div>
								</div>

								<div class="col-lg-12">
									<div class="form-group">
										<label for="nomeCrianca">Nome da Criança</label>
										<input class="form-control" id="nomeCrianca" type="text" name="nome[]" placeholder="Nome da Criança" required>
									</div>
								</div>

								<div class="col-lg-6">
									<div class="form-group">
										<label for="dataDeNascimento">Data de Nascimento (DD/MM/YYYY)</label>
										<input class="form-control" type="text" id="dataDeNascimento" name="nascimento[]" placeholder="Data de Nascimento (DD/MM/YYYY)" maxlength="10" minlength="10" required>
									</div>
								</div>

								<div class="col-lg-6">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="exampleInputEmail1">É Cristão?</label>
											<select name="opcao[]" class="form-control" required>
												<option value="0" selected>Escolha uma opção</option>
												<option value="1">Sim</option>
												<option value="2">Não</option>
											</select>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="exampleInputEmail1">Responsável da Criança:</label>
											<select name="responsavel_crianca[]" onchange="mostrarCamposPais();" class="form-control" required>
												<option value="<?= $dados_lider['nome_lider'] ?>" selected><?= $dados_lider['nome_lider'] ?></option>
												<option value="outro">Outro</option>
											</select>
										</div>
									</div>
								</div>

								<script>
									function mostrarCamposPais() {
										var i = document.getElementById('controller').value;
										document.getElementById('linhaResponsaveis' + i).style.display = 'inline';
									}
								</script>

								<div class="col-lg-12" id="linhaResponsaveis1" style="display: none;">
									<div class="col-lg-4">
										<div class="form-group">
											<label for="exampleInputEmail1">Nome do Responsável (Obrigatório):</label>
											<input class="form-control" type="text" name="nome_responsavel[]" placeholder="Nome do Responsável">
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group">
											<label for="exampleInputEmail1">E-mail do Responsável:</label>
											<input class="form-control" type="text" name="email_responsavel[]" placeholder="E-mail do Responsável">
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group">
											<label for="exampleInputEmail1">Telefone do Responsável:</label>
											<input class="form-control" type="text" name="telefone_responsavel[]" placeholder="Telefone do Responsável">
										</div>
									</div>
								</div>

								<div class="col-lg-12">
									<label for="observacao">Observação</label>
									<textarea id="observacao" name="obs[]" class="form-control"></textarea>
								</div><br>

								<div id="conteudo"></div>
							</div>

							<div class="col-lg-12">
								<center><br><br>
									<input type="button" class="btn btn-danger" id="remove" value="Remover">
								</center>
							</div>

							<input type="hidden" value="1" id="total" name="total[]"><br>
							<input type="hidden" value="1" id="controller"><br>

							<div class="box-footer">
								<div class="pull-right">
									<input type="button" class="btn btn-info" value="Adicionar" id="add">
									<button type="submit" id="button" class="btn btn-success">Salvar</button>
						</form>

						<form action="primeiro_acesso" method="post">
							<input type="hidden" name="id_usuario" value="<?= $id_usuario ?>">
							<input type="hidden" name="nivel" value="1">
							<input type="hidden" name="x_ir" value="3">
							<br><input type="submit" value="Pular" class="btn btn-warning">
						</form>
					</div>
				</div>
				<!-- /.box -->
			</section>

		<?php } else {
					}
		?>
	<?php }
				if ($x_ir == 3) { ?>

		<style>
			#linha {
				height: 220px;
				display: flex;
				justify-content: center;
			}

			.not-active {
				pointer-events: none;
				cursor: default;
				color: red;
			}

			.succ {
				width: 120px;
				margin: 2px;
				display: table-column;
				justify-content: center;
				align-content: center;
				text-align: center;
			}

			.img-center {
				width: 100px;
				margin: 0 auto;
			}

			.img-capa {
				width: 100px;
				border-radius: 30px;
				height: 100px;
				display: flex;
				margin: 0 auto;
				justify-content: center;
				align-content: center;
			}

			#quadrado {
				height: 400px;
				margin-bottom: 10px;
			}

			@media (max-width: 360px) {
				#quadrado {
					height: 100%;
				}

				#linha {
					height: 100%;
					display: block;
					justify-content: center;
				}
			}
		</style>

		<section class="content-header">
			<center>
				<h1>
					Primeiro Acesso |
					<small>Sistema CAMP Brasil</small>
				</h1>

				<ol class="breadcrumb">
					<li class="active">Cadastrar PG</li>
					<li class="active">Cadastrar Crianças</li>
					<li class="active"><a href="#"><i class="fa fa-circle"></i> Download de Material</a></li>
				</ol>
			</center>
		</section>

		<div class="col-md-12">
			<section class="content-header">
				<center>
					<a href="lider/home" class="btn btn-warning">Fazer download depois / Continuar</a>
				</center>
			</section>
		</div>
		<br><br><br>

		<!-- Main content -->
		<section class="content">

			<!-- Small boxes (Stat box) -->
			<script>
				$(function() {
					$("#datepicker").datepicker({
						dateFormat: 'dd/mm/yy',
						closeText: "Fechar",
						prevText: "&#x3C;Anterior",
						nextText: "Próximo&#x3E;",
						currentText: "Hoje",
						monthNames: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
						monthNamesShort: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
						dayNames: ["Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado"],
						dayNamesShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
						dayNamesMin: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
						weekHeader: "Sm",
						firstDay: 1,
						minDate: 0,
					});
				});
			</script>

			<div class="row">
				<?php
					$dados_pg = $this->PG->query([$id_usuario], 'query_id_lider_ativo_order_by_modulo_desc_limit_1_download_material', 1);
					$id_modulo = $dados_pg['row'] == 0 ? 1 : $dados_pg['dados']['id_modulo'];
					$dadosModulos = $this->FConsultas_model->consultarModuloId($id_modulo);

					$nome_modulo = $dadosModulos['nome_modulo'];
					$aprenderemos = $dadosModulos['aprenderemos'];
					$descricao = $dadosModulos['descricao'];

					$color_h3 = 'black';

					$materialCapa = array();
					$materialCards = array();
					$materialLicao = array();
					$materialExtra = array();

					array_push($materialCapa, $materialCapaTrilha);
					array_push($materialCapa, $materialContraCapaTrilha);
					array_push($materialCards, $materialCardsTrilha);
					array_push($materialCards, $materialSemanarioTrilha);
					array_push($materialLicao, $materialIntroducaoTrilha);
					array_push($materialLicao, $materialLicaoTrilha);
					array_push($materialLicao, $materialLicaoVisuaisTrilha2);
					array_push($materialLicao, $materialLicaoVisuaisTrilha1);
					array_push($materialExtra, $materialChequinhoTrilha);

					if ($dados_pg['row'] == 0) {
				?>

					<div class="col-md-12">
						<div class="box box-danger">
							<div class="box-body chat"><br>
								<div class="callout callout-danger">
									<h4>
										Você não tem nenhum PG Cadastrado!
									</h4>
									<p>Cadastre para fazer o download do material</p>
								</div>
							</div>
						</div>
						<!-- /.box-body -->
					</div>

					<div class="col-md-12">
						<div class="col-md-6">
							<div class="box bg-info">
								<div class="box-header with-border">
									<h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-download"></i> <?= $nome_modulo; ?> | <?= $aprenderemos; ?></h3>
									<div class="box-tools pull-right">
										<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
										</button>
									</div>
								</div>
								<div class="box-body chat" id="quadrado">
									<br>
									<p style="text-align: justify;"><?= $descricao; ?></p>
								</div>
							</div>
							<!-- /.box-body -->
						</div>

						<div class="col-md-6">
							<div class="box bg-info">
								<div class="box-header with-border">
									<h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-list"></i> <?= $nome_modulo; ?> | Lições</h3>
									<div class="box-tools pull-right">
										<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
										</button>
									</div>
								</div>
								<div class="box-body chat" id="quadrado">
									<div class="tab-content">
										<div class="tab-pane active">
											<table class="table no-margin">
												<tbody>
													<?php
													$licoes = $this->FConsultas_model->consultarLicaoModulo($id_modulo);
													foreach ($licoes as $key => $dadosLicoes) {
														$numero_licao = $dadosLicoes['numero_licao'];
														$nome_licao = $dadosLicoes['nome_licao'];
													?>
														<tr>
															<td><?= $numero_licao; ?> - <?= $nome_licao; ?></td>
														</tr>
													<?php } ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<!-- /.box-body -->
							</div>
						</div>
					</div>

					<?php
						if ($materialCapa) {
					?>
						<div class="col-md-6">
							<div class="small-box bg-info">
								<div class="box-header with-border">
									<h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-download"></i> <?= $nome_modulo; ?> | Capa e Contra Capa</h3>
									<div class="box-tools pull-right">
										<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
										</button>
									</div>
								</div>
								<div class="box-body chat" id="linha">
									<?php
									foreach ($materialCapa as $key => $capas) {
										if ($capas['capa'] == '') {
										} else {
									?>
											<div class="succ not-active">
												<div class="img-center">
													<img src="<?php echo base_url($capas['capa']); ?>" title="Capa" class="img-capa" alt="User Image">
												</div>
											</div>
									<?php }
									} ?>
								</div>
							</div>
							<!-- /.box-body -->
						</div>
					<?php } else {
						} ?>

					<?php
						if ($materialLicao) {
					?>
						<div class="col-md-6">
							<div class="small-box bg-info">
								<div class="box-header with-border">
									<h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-download"></i> <?= $nome_modulo; ?> | Lição</h3>
									<div class="box-tools pull-right">
										<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
										</button>
									</div>
								</div>
								<div class="box-body chat" id="linha">
									<?php
									foreach ($materialLicao as $key => $licao) {
										if ($licao['id'] == 0) {
										} else {
									?>
											<div class="succ not-active">
												<div class="img-center">
													<img src="<?php echo base_url($licao['imagem']); ?>" title="<?= $licao['nome']; ?>" class="img-capa" alt="User Image">
												</div>
												<label for=""><?= $licao['nome_visivel']; ?></label>
											</div>
									<?php }
									} ?>
								</div>
							</div>
							<!-- /.box-body -->
						</div>
					<?php } else {
						} ?>

					<?php
						if ($materialCards) {
					?>
						<div class="col-md-6">
							<div class="small-box bg-info">
								<div class="box-header with-border">
									<h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-download"></i> <?= $nome_modulo; ?> | Versículos e Mistérios e Devocional Diário</h3>
									<div class="box-tools pull-right">
										<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
										</button>
									</div>
								</div>
								<div class="box-body chat" id="linha">
									<?php
									foreach ($materialCards as $key => $cards) {
									?>
										<div class="succ not-active">
											<div class="img-center">
												<img src="<?php echo base_url('import/sistema/img/documento.png'); ?>" title="<?= $cards['nome']; ?>" class="img-capa" alt="User Image">
											</div>
											<label for=""><?= $cards['nome']; ?></label>
										</div>
									<?php } ?>
								</div>
							</div>
							<!-- /.box-body -->
						</div>
					<?php } else {
						} ?>

					<?php
						if ($materialExtra) {
					?>
						<div class="col-md-6">
							<div class="small-box bg-info">
								<div class="box-header with-border">
									<h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-download"></i> <?= $nome_modulo; ?> | Extra</h3>
									<div class="box-tools pull-right">
										<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
										</button>
									</div>
								</div>
								<div class="box-body chat" id="linha">
									<?php
									foreach ($materialExtra as $key => $extra) {
									?>
										<div class="succ not-active">
											<div class="img-center">
												<img src="<?php echo base_url('import/sistema/img/documento.png'); ?>" title="<?= $extra['nome']; ?>" class="img-capa" alt="User Image">
											</div>
											<label for=""><?= $extra['nome']; ?></label>
										</div>
									<?php } ?>
								</div>
							</div>
							<!-- /.box-body -->
						</div>
					<?php } else {
						} ?>

				<?php } else { ?>
					<?php

						$idPG = $dados_pg['dados']['id_pg'];

						$consultarCriancas = $this->Criancas->query([$id_usuario, $idPG, 1, 'asc'], 'query_id_lider_id_pg_ativo_order_by_nome_crianca');

						if ($consultarCriancas['row'] == 0) {
					?>
						<div class="col-md-12">
							<div class="box box-danger">
								<div class="box-body chat"><br>
									<div class="callout callout-danger">
										<h4>
											Você não tem nenhuma criança cadastrada!
										</h4>
										<p>Cadastre pelo menos uma criança para ter acesso ao material.</p>
									</div>
								</div>
							</div>
							<!-- /.box-body -->
						</div>

						<div class="col-md-12">
							<div class="col-md-6">
								<div class="box bg-info">
									<div class="box-header with-border">
										<h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-download"></i> <?= $nome_modulo; ?> | <?= $aprenderemos; ?></h3>
										<div class="box-tools pull-right">
											<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
											</button>
										</div>
									</div>
									<div class="box-body chat" id="quadrado">
										<br>
										<p style="text-align: justify;"><?= $descricao; ?></p>
									</div>
								</div>
								<!-- /.box-body -->
							</div>

							<div class="col-md-6">
								<div class="box bg-info">
									<div class="box-header with-border">
										<h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-list"></i> <?= $nome_modulo; ?> | Lições</h3>
										<div class="box-tools pull-right">
											<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
											</button>
										</div>
									</div>
									<div class="box-body chat" id="quadrado">
										<div class="tab-content">
											<div class="tab-pane active">
												<table class="table no-margin">
													<tbody>
														<?php
														$licoes = $this->FConsultas_model->consultarLicaoModulo($id_modulo);
														foreach ($licoes as $key => $dadosLicoes) {
															$numero_licao = $dadosLicoes['numero_licao'];
															$nome_licao = $dadosLicoes['nome_licao'];
														?>
															<tr>
																<td><?= $numero_licao; ?> - <?= $nome_licao; ?></td>
															</tr>
														<?php } ?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<!-- /.box-body -->
								</div>
							</div>
						</div>

						<?php
							if ($materialCapa) {
						?>
							<div class="col-md-6">
								<div class="small-box bg-info">
									<div class="box-header with-border">
										<h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-download"></i> <?= $nome_modulo; ?> | Capa e Contra Capa</h3>
										<div class="box-tools pull-right">
											<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
											</button>
										</div>
									</div>
									<div class="box-body chat" id="linha">
										<?php
										foreach ($materialCapa as $key => $capas) {
											if ($capas['capa'] == '') {
											} else {
										?>
												<div class="succ not-active">
													<div class="img-center">
														<img src="<?php echo base_url($capas['capa']); ?>" title="Capa" class="img-capa" alt="User Image">
													</div>
												</div>
										<?php }
										} ?>
									</div>
								</div>
								<!-- /.box-body -->
							</div>
						<?php } else {
							} ?>

						<?php
							if ($materialLicao) {
						?>
							<div class="col-md-6">
								<div class="small-box bg-info">
									<div class="box-header with-border">
										<h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-download"></i> <?= $nome_modulo; ?> | Lição</h3>
										<div class="box-tools pull-right">
											<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
											</button>
										</div>
									</div>
									<div class="box-body chat" id="linha">
										<?php
										foreach ($materialLicao as $key => $licao) {
											if ($licao['id'] == 0) {
											} else {
										?>
												<div class="succ not-active">
													<div class="img-center">
														<img src="<?php echo base_url($licao['imagem']); ?>" title="<?= $licao['nome']; ?>" class="img-capa" alt="User Image">
													</div>
													<label for=""><?= $licao['nome_visivel']; ?></label>
												</div>
										<?php }
										} ?>
									</div>
								</div>
								<!-- /.box-body -->
							</div>
						<?php } else {
							} ?>

						<?php
							if ($materialCards) {
						?>
							<div class="col-md-6">
								<div class="small-box bg-info">
									<div class="box-header with-border">
										<h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-download"></i> <?= $nome_modulo; ?> | Versículos e Mistérios e Devocional Diário</h3>
										<div class="box-tools pull-right">
											<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
											</button>
										</div>
									</div>
									<div class="box-body chat" id="linha">
										<?php
										foreach ($materialCards as $key => $cards) {
										?>
											<div class="succ not-active">
												<div class="img-center">
													<img src="<?php echo base_url('import/sistema/img/documento.png'); ?>" title="<?= $cards['nome']; ?>" class="img-capa" alt="User Image">
												</div>
												<label for=""><?= $cards['nome']; ?></label>
											</div>
										<?php } ?>
									</div>
								</div>
								<!-- /.box-body -->
							</div>
						<?php } else {
							} ?>

						<?php
							if ($materialExtra) {
						?>
							<div class="col-md-6">
								<div class="small-box bg-info">
									<div class="box-header with-border">
										<h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-download"></i> <?= $nome_modulo; ?> | Extra</h3>
										<div class="box-tools pull-right">
											<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
											</button>
										</div>
									</div>
									<div class="box-body chat" id="linha">
										<?php
										foreach ($materialExtra as $key => $extra) {
										?>
											<div class="succ not-active">
												<div class="img-center">
													<img src="<?php echo base_url('import/sistema/img/documento.png'); ?>" title="<?= $extra['nome']; ?>" class="img-capa" alt="User Image">
												</div>
												<label for=""><?= $extra['nome']; ?></label>
											</div>
										<?php } ?>
									</div>
								</div>
								<!-- /.box-body -->
							</div>
						<?php } else {
							} ?>

						<?php
						} else {

							$idModuloPG = $dados_pg['dados']['id_modulo'];

							if ($idModuloPG < $id_modulo) {
						?>

							<div class="col-md-12">
								<div class="col-md-6">
									<div class="box bg-info">
										<div class="box-header with-border">
											<h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-download"></i> <?= $nome_modulo; ?> | <?= $aprenderemos; ?></h3>
											<div class="box-tools pull-right">
												<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
												</button>
											</div>
										</div>
										<div class="box-body chat" id="quadrado">
											<br>
											<p style="text-align: justify;"><?= $descricao; ?></p>
										</div>
									</div>
									<!-- /.box-body -->
								</div>

								<div class="col-md-6">
									<div class="box bg-info">
										<div class="box-header with-border">
											<h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-list"></i> <?= $nome_modulo; ?> | Lições</h3>
											<div class="box-tools pull-right">
												<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
												</button>
											</div>
										</div>
										<div class="box-body chat" id="quadrado">
											<div class="tab-content">
												<div class="tab-pane active">
													<table class="table no-margin">
														<tbody>
															<?php
															$licoes = $this->FConsultas_model->consultarLicaoModulo($id_modulo);
															foreach ($licoes as $key => $dadosLicoes) {
																$numero_licao = $dadosLicoes['numero_licao'];
																$nome_licao = $dadosLicoes['nome_licao'];
															?>
																<tr>
																	<td><?= $numero_licao; ?> - <?= $nome_licao; ?></td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
										<!-- /.box-body -->
									</div>
								</div>
							</div>

							<?php
								if ($materialCapa) {
							?>
								<div class="col-md-6">
									<div class="small-box bg-info">
										<div class="box-header with-border">
											<h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-download"></i> <?= $nome_modulo; ?> | Capa e Contra Capa</h3>
											<div class="box-tools pull-right">
												<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
												</button>
											</div>
										</div>
										<div class="box-body chat" id="linha">
											<?php
											foreach ($materialCapa as $key => $capas) {
												if ($capas['capa'] == '') {
												} else {
											?>
													<div class="succ not-active">
														<div class="img-center">
															<img src="<?php echo base_url($capas['capa']); ?>" title="Capa" class="img-capa" alt="User Image">
														</div>
													</div>
											<?php }
											} ?>
										</div>
									</div>
									<!-- /.box-body -->
								</div>
							<?php } else {
								} ?>

							<?php
								if ($materialLicao) {
							?>
								<div class="col-md-6">
									<div class="small-box bg-info">
										<div class="box-header with-border">
											<h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-download"></i> <?= $nome_modulo; ?> | Lição</h3>
											<div class="box-tools pull-right">
												<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
												</button>
											</div>
										</div>
										<div class="box-body chat" id="linha">
											<?php
											foreach ($materialLicao as $key => $licao) {
												if ($licao['id'] == 0) {
												} else {
											?>
													<div class="succ not-active">
														<div class="img-center">
															<img src="<?php echo base_url($licao['imagem']); ?>" title="<?= $licao['nome']; ?>" class="img-capa" alt="User Image">
														</div>
														<label for=""><?= $licao['nome_visivel']; ?></label>
													</div>
											<?php }
											} ?>
										</div>
									</div>
									<!-- /.box-body -->
								</div>
							<?php } else {
								} ?>

							<?php
								if ($materialCards) {
							?>
								<div class="col-md-6">
									<div class="small-box bg-info">
										<div class="box-header with-border">
											<h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-download"></i> <?= $nome_modulo; ?> | Versículos e Mistérios e Devocional Diário</h3>
											<div class="box-tools pull-right">
												<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
												</button>
											</div>
										</div>
										<div class="box-body chat" id="linha">
											<?php
											foreach ($materialCards as $key => $cards) {
											?>
												<div class="succ not-active">
													<div class="img-center">
														<img src="<?php echo base_url('import/sistema/img/documento.png'); ?>" title="<?= $cards['nome']; ?>" class="img-capa" alt="User Image">
													</div>
													<label for=""><?= $cards['nome']; ?></label>
												</div>
											<?php } ?>
										</div>
									</div>
									<!-- /.box-body -->
								</div>
							<?php } else {
								} ?>


							<?php
								if ($materialExtra) {
							?>
								<div class="col-md-6">
									<div class="small-box bg-info">
										<div class="box-header with-border">
											<h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-download"></i> <?= $nome_modulo; ?> | Extra</h3>
											<div class="box-tools pull-right">
												<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
												</button>
											</div>
										</div>
										<div class="box-body chat" id="linha">
											<?php
											foreach ($materialExtra as $key => $extra) {
											?>
												<div class="succ not-active">
													<div class="img-center">
														<img src="<?php echo base_url('import/sistema/img/documento.png'); ?>" title="<?= $extra['nome']; ?>" class="img-capa" alt="User Image">
													</div>
													<label for=""><?= $extra['nome']; ?></label>
												</div>
											<?php } ?>
										</div>
									</div>
									<!-- /.box-body -->
								</div>
							<?php } else {
								} ?>

						<?php
							} else {
						?>
							<!-- ATIVO -->
							<div class="col-md-12">
								<div class="col-md-6">
									<div class="box bg-info">
										<div class="box-header with-border">
											<h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-download"></i> <?= $nome_modulo; ?> | <?= $aprenderemos; ?></h3>
											<div class="box-tools pull-right">
												<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
												</button>
											</div>
										</div>
										<div class="box-body chat" id="quadrado">
											<br>
											<p style="text-align: justify;"><?= $descricao; ?></p>
										</div>
									</div>
									<!-- /.box-body -->
								</div>

								<div class="col-md-6">
									<div class="box bg-info">
										<div class="box-header with-border">
											<h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-list"></i> <?= $nome_modulo; ?> | Lições</h3>
											<div class="box-tools pull-right">
												<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
												</button>
											</div>
										</div>
										<div class="box-body chat" id="quadrado">
											<div class="tab-content">
												<div class="tab-pane active">
													<table class="table no-margin">
														<tbody>
															<?php
															$licoes = $this->FConsultas_model->consultarLicaoModulo($id_modulo);
															foreach ($licoes as $key => $dadosLicoes) {
																$numero_licao = $dadosLicoes['numero_licao'];
																$nome_licao = $dadosLicoes['nome_licao'];
															?>
																<tr>
																	<td><?= $numero_licao; ?> - <?= $nome_licao; ?></td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
										<!-- /.box-body -->
									</div>
								</div>
							</div>

							<?php
								if ($materialCapa) {
							?>
								<div class="col-md-6">
									<div class="small-box bg-info">
										<div class="box-header with-border">
											<h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-download"></i> <?= $nome_modulo; ?> | Capa e Contra Capa</h3>
											<div class="box-tools pull-right">
												<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
												</button>
											</div>
										</div>
										<div class="box-body chat" id="linha">
											<?php
											foreach ($materialCapa as $key => $capas) {
												if ($capas['capa'] == '') {
												} else {
											?>
													<div class="succ">
														<div class="img-center">
															<a href="<?php echo base_url($capas['capa']); ?>" target="_blank" download>
																<img src="<?php echo base_url($capas['capa']); ?>" title="Capa" class="img-capa" alt="User Image">
															</a>
														</div>
													</div>
											<?php }
											} ?>
										</div>
									</div>
									<!-- /.box-body -->
								</div>
							<?php } else {
								} ?>

							<?php
								if ($materialLicao) {
							?>
								<div class="col-md-6">
									<div class="small-box bg-info">
										<div class="box-header with-border">
											<h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-download"></i> <?= $nome_modulo; ?> | Lição</h3>
											<div class="box-tools pull-right">
												<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
												</button>
											</div>
										</div>
										<div class="box-body chat" id="linha">
											<?php
											foreach ($materialLicao as $key => $licao) {

												if ($licao['id'] == 0) {
												} else {

													if ($licao['id'] == 2 && $dados_pg['dados']['data_inicio'] == '') {
											?>
														<div class="succ">
															<a data-toggle="modal" data-target="<?= "#" . $licao['id']; ?>download" href="#">
																<div class="img-center">
																	<img src="<?php echo base_url($licao['imagem']); ?>" title="<?= $licao['nome']; ?>" class="img-capa" alt="User Image">
																</div>
																<label for=""><?= $licao['nome_visivel']; ?></label>
															</a>
														</div>

														<div class="modal fade" id="<?= $licao['id']; ?>download">
															<div class="modal-dialog modal-info">
																<div class="modal-content">
																	<form action="download_material" method="post" target="_blank" id="form__submit">
																		<input type="hidden" name="id" value="<?= $licao['id']; ?>">
																		<input type="hidden" name="id_lider" value="<?= $id_usuario; ?>">
																		<input type="hidden" name="id_pg" value="<?= $idPG; ?>">
																		<input type="hidden" name="title" value="<?= $licao['nome']; ?>" style="color: black;">
																		<input type="hidden" name="download" value="<?= $licao['arquivo']; ?>" style="color: black;">
																		<input type="hidden" name="nivel" value="1">

																		<div class="modal-header">
																			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																				<span aria-hidden="true">&times;</span></button>
																			<h4 class="modal-title">Download do Material | <?= $nome_modulo; ?></h4>
																		</div>
																		<div class="box-body">
																			<div class="form-group" style="text-align: center;">
																				<label for="exampleInputEmail1">Digite a data de início do PG</label>
																				<p style="color: black;">Data: <input type="text" name="data" id="datepicker" autocomplete="off" required></p>
																			</div>
																		</div>
																		<div class="modal-footer">
																			<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Sair</button>
																			<input type="submit" class="btn btn-default" onclick="fecharModal();" value="Baixar">
																		</div>

																		<script>
																			function fecharModal() {
																				let form = document.getElementById("form__submit");
																				form.submit();
																				$('.modal').modal('hide');
																				window.location.reload(true);
																			}
																		</script>
																	</form>
																</div>
																<!-- /.modal-content -->
															</div>
															<!-- /.modal-dialog -->
														</div>
													<?php } else { ?>
														<div class="succ">
															<form action="download_material" method="post" target="_blank" download>
																<input type="hidden" name="id" value="<?= $licao['id']; ?>">
																<input type="hidden" name="id_lider" value="<?= $id_usuario; ?>">
																<input type="hidden" name="id_pg" value="<?= $idPG; ?>">
																<input type="hidden" name="title" value="<?= $licao['nome']; ?>">
																<input type="hidden" name="download" value="<?= $licao['arquivo']; ?>">
																<input type="hidden" name="nivel" value="1">

																<div class="img-center">
																	<button type="submit" style="background-color: transparent; border: none;">
																		<img src="<?php echo base_url($licao['imagem']); ?>" title="<?= $licao['nome']; ?>" class="img-responsive img-capa" alt="User Image">
																	</button>
																</div>
																<label for=""><?= $licao['nome_visivel']; ?></label>
															</form>
														</div>
													<?php } ?>
												<?php } ?>
											<?php } ?>
										</div>
									</div>
									<!-- /.box-body -->
								</div>
							<?php } else {
								} ?>

							<?php
								if ($materialCards) {
							?>
								<div class="col-md-6">
									<div class="small-box bg-info">
										<div class="box-header with-border">
											<h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-download"></i> <?= $nome_modulo; ?> | Versículos e Mistérios e Devocional Diário</h3>
											<div class="box-tools pull-right">
												<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
												</button>
											</div>
										</div>
										<div class="box-body chat" id="linha">
											<?php
											foreach ($materialCards as $key => $cards) {
											?>
												<div class="succ">
													<a href="<?php echo base_url($cards['arquivo']); ?>" target="_blank" download>
														<div class="img-center">
															<img src="<?php echo base_url('import/sistema/img/documento.png'); ?>" title="<?= $cards['nome']; ?>" class="img-capa" alt="User Image">
														</div>
														<label for=""><?= $cards['nome']; ?></label>
													</a>
												</div>
											<?php } ?>
										</div>
									</div>
									<!-- /.box-body -->
								</div>
							<?php } else {
								} ?>



							<?php
								if ($materialExtra) {
							?>
								<div class="col-md-6">
									<div class="small-box bg-info">
										<div class="box-header with-border">
											<h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-download"></i> <?= $nome_modulo; ?> | Extra</h3>
											<div class="box-tools pull-right">
												<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
												</button>
											</div>
										</div>
										<div class="box-body chat" id="linha">
											<?php
											foreach ($materialExtra as $key => $extra) {
											?>
												<div class="succ">
													<a href="<?php echo base_url($extra['arquivo']); ?>" target="_blank" download>
														<div class="img-center">
															<img src="<?php echo base_url('import/sistema/img/documento.png'); ?>" title="<?= $extra['nome']; ?>" class="img-capa" alt="User Image">
														</div>
														<label for=""><?= $extra['nome']; ?></label>
													</a>
												</div>
											<?php } ?>
										</div>
									</div>
									<!-- /.box-body -->
								</div>
							<?php } else {
								} ?>


						<?php } ?>

					<?php } ?>
				<?php } ?>

				<div class="col-md-12">
					<section class="content-header">
						<center>
							<a href="lider/home" class="btn btn-warning">Fazer download depois / Continuar</a>
						</center>
					</section>
				</div>
				<!-- /.box -->
			</div>
			<!-- /.row -->
		</section>
		<!-- /.content -->
	<?php } ?>
	<!-- ./ -->
	<!-- Links JavaScript -->

	<script>
		$(document).ready(function() {
			var i = 1;

			document.getElementById('remove').style.display = 'none';

			$("#add").click(function() {
				i = i + 1;
				var conteudo = "#conteudo" + i;
				var conteudo2 = "conteudo" + i;
				var linhaResponsaveis = "linhaResponsaveis" + i;

				document.getElementById('controller').value = i;

				var iInicial = document.getElementById('controller').value;

				if (iInicial == 1) {
					document.getElementById('remove').style.display = 'none';
				} else {
					document.getElementById('remove').style.display = 'inline';
				}

				$("#conteudo").append('<div id="' + conteudo2 + '"></div>');

				$(conteudo).append('<br><hr><div class="col-lg-12"><div class="form-group"><label for="nomeCrianca">Nome da Criança</label><input class="form-control" id="nomeCrianca" type="text" name="nome[]" placeholder="Nome da Criança" required></div></div><div class="col-lg-6"><div class="form-group"><label for="dataDeNascimento">Data de Nascimento (DD/MM/YYYY)</label><input class="form-control" type="text" id="dataDeNascimento" name="nascimento[]" placeholder="Data de Nascimento (DD/MM/YYYY)" maxlength="10" minlength="10"></div></div><div class="col-lg-6"><div class="col-lg-6"><div class="form-group"><label for="exampleInputEmail1">É Cristão?</label><select name="opcao[]" class="form-control" required><option value="0" selected>Escolha uma opção</option><option value="1">Sim</option><option value="2">Não</option></select></div></div><div class="col-lg-6"><div class="form-group"><label for="exampleInputEmail1">Responsável da Criança:</label><select name="responsavel_crianca[]" onchange="mostrarCamposPais();" class="form-control" required><option value="<?= $dados_lider['nome_lider'] ?>" selected><?= $dados_lider['nome_lider'] ?></option><option value="outro">Outro</option></select></div></div></div><div class="col-lg-12" id="' + linhaResponsaveis + '" style="display: none;"><div class="col-lg-4"><div class="form-group"><label for="exampleInputEmail1">Nome do Responsável (Obrigatório):</label><input class="form-control" type="text" name="nome_responsavel[]" placeholder="Nome do Responsável"></div></div><div class="col-lg-4"><div class="form-group"><label for="exampleInputEmail1">E-mail do Responsável:</label><input class="form-control" type="text" name="email_responsavel[]" placeholder="E-mail do Responsável"></div></div><div class="col-lg-4"><div class="form-group"><label for="exampleInputEmail1">Telefone do Responsável:</label><input class="form-control" type="text" name="telefone_responsavel[]" placeholder="Telefone do Responsável"></div></div></div><div class="col-lg-12"><label for="observacao">Observação</label><textarea id="observacao" name="obs[]" class="form-control"></textarea></div><hr><br><input type="hidden" value="1" id="total" name="total[]">');
				return false;
			});

			$("#remove").click(function() {
				var iInicial = document.getElementById('controller').value;

				var novoI = document.getElementById('controller').value = i;

				var Novoconteudo = "#conteudo" + novoI;

				$(Novoconteudo).empty('');

				i = i - 1;
				document.getElementById('controller').value = i;
				var iInicial = document.getElementById('controller').value;

				if (iInicial == 1) {
					document.getElementById('remove').style.display = 'none';
				} else {
					document.getElementById('remove').style.display = 'inline';
				}

				return false;
			});
		});
	</script>

	<?php
	$this->load->view('partes/scripts2');
	?>
	</body>

	</html>
<?php
}
?>
