<?php
if (!isset($_SESSION['usuario'])) {
	header("location: index");
} else {
	$id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";
	$id_usuario_2 = ($_SESSION["id_usuario_2"]) ? $_SESSION["id_usuario_2"] : "";

	$nivel = $_GET['nivel'];
	$x_ir = $_GET['x_ir'];

	if ($x_ir == "") {
		$x_ir .= "";
	}

	$funcao = new FConsultas_model();
	$dadosPais = $funcao->consultaDadosPaisId($id_usuario);

	$consultarPG = $funcao->mostrarPGDownload($id_usuario);
	$totalPG = $consultarPG['row'];
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
				<?php if ($totalPG == 0) { ?>
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
								<form action="pais/page/pg/cadastro/paginaInicial" role="form" method="POST" enctype="multipart/form-data">
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
												<p style="color: black;"><input type="text" autocomplete="off" name="data_inicio" placeholder="DD/MM/AAAA" class="form-control" id="datepicker" required></p>
											</div>
										</div>
									</div>
									<div class="box-footer">
										<div class="pull-right">
											<input type="submit" class="btn btn-success" name="btn_form" value="Salvar">
								</form>
								<a href="primeiro_acesso?idLider=<?= $id_usuario ?>&nome=<?= $dadosPais['nome']; ?>&nivel=8" class="btn btn-warning">Pular</a>
							</div>
						</div>

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
			</div>
		</div>
		<!-- /.box -->
		</section>

		<?php } else {

					$consultaCriancas = $funcao->mostrarCriancasPaisPg($id_usuario, $consultarPG['dados']['id_pg']);

					if ($consultaCriancas['row'] == 0 && $x_ir != 3) {

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
						<form action="pais/page/criancas/cadastro/paginaInicial" role="form" method="POST" enctype="multipart/form-data">
							<div class="box-body">
								<input class="form-control" id="id_lider" type="hidden" name="id_lider" value="<?= $id_usuario; ?>">
								<input class="form-control" type="hidden" name="nivel" value="<?= $nivel; ?>">
								<div class="col-lg-12">
									<div class="form-group">
										<label for="exampleInputEmail1">PG</label>
										<select name="id_pg" id="id_pg" class="form-control">
											<optgroup label="Seu PG">
												<?php

												$val = $consultarPG['dados'];
												?>
												<option value="<?= $val['id_pg'] ?>"><?= $val['nome_pg'] ?></option>
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
												<option value="0">Não</option>
											</select>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="exampleInputEmail1">Responsável da Criança:</label>
											<select name="responsavel_crianca[]" onchange="mostrarCamposPais();" class="form-control" required>
												<option value="<?= $dadosPais['nome'] ?>" selected><?= $dadosPais['nome'] ?></option>
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
						<a href="primeiro_acesso?id_usuario=<?= $id_usuario ?>&nivel=8&x_ir=3" class="btn btn-warning">Pular</a>
					</div>
				</div>
				</div>
				</div>
				<!-- /.box -->
			</section>

		<?php } ?>

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

			.not-active label {
				text-align: center;
				margin-left: 21px;
			}

			.img-capa {
				border-radius: 30px;
				width: 150px;
				height: 150px;
				position: relative;
				text-align: center;
				margin: 10px;
			}

			#quadrado {
				height: 300px;
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
					<a href="pais/home" class="btn btn-warning">Fazer download depois / Continuar</a>
				</center>
			</section>
		</div>
		<br><br><br>

		<!-- Main content -->
		<section class="content">

			<!-- Small boxes (Stat box) -->
			<script>
				// $(function() {
				//   $("#datepicker").datepicker(
				//   );
				// });
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

					$consultarPG = $this->FConsultas_model->mostrarPGDownload($id_usuario);
					$id_modulo = $consultarPG['dados']['id_modulo'];
					$dadosModulos = $this->FConsultas_model->consultarModuloId($id_modulo);

					$nome_modulo = $dadosModulos['nome_modulo'];
					$aprenderemos = $dadosModulos['aprenderemos'];
					$descricao = $dadosModulos['descricao'];

					$color_modulo = '';
					$color_h3 = '';

					$materialCapa = array();
					$materialCards = array();
					$materialLicao = array();

					$materialCapaTrilha = array(
						'capa' => 'import/sistema/arquivos/01/Trilha/capa.jpg'
					);

					$materialContraCapaTrilha = array(
						'capa' => 'import/sistema/arquivos/01/Trilha/contracapa.jpg'
					);

					$materialCardsTrilha = array(
						'nome' => 'Versículos e Mistérios',
						'arquivo' => 'import/sistema/arquivos/01/Trilha/cards_novos.pdf'
					);

					$materialSemanarioTrilha = array(
						'nome' => 'Devocional Diário',
						'arquivo' => 'import/sistema/arquivos/01/Trilha/devocional.pdf'
					);

					$materialIntroducaoTrilha = array(
						'id' => 1,
						'nome' => 'Introdução à Trilha',
						'arquivo' => 'import/sistema/arquivos/01/Trilha/introducao.pdf',
						'imagem' => 'import/sistema/img/livro.png',
					);

					$materialLicaoTrilha = array(
						'id' => 2,
						'nome' => 'Manual da Trilha',
						'arquivo' => 'import/sistema/arquivos/01/Trilha/Trilha.php?id_lider=' . $id_usuario . '&id_modulo=1',
						'imagem' => 'import/sistema/img/livro.png',
					);

					$materialLicaoVisuais1 = array(
						'id' => 3,
						'nome' => 'Visuais da Trilha',
						'arquivo' => 'import/sistema/arquivos/01/Trilha/visuais.pdf',
						'imagem' => 'import/sistema/img/documento.png',
					);

					$materialLicaoVisuais2 = array(
						'id' => 4,
						'nome' => 'Lição em PowerPoint',
						'arquivo' => 'import/sistema/arquivos/01/Trilha/Trilha.ppsx',
						'imagem' => 'import/sistema/img/livro.png',
					);

					switch ($id_modulo) {
						case 1:
							$color_modulo = 'green';
							$color_h3 = 'black';
							array_push($materialCapa, $materialCapaTrilha);
							array_push($materialCapa, $materialContraCapaTrilha);
							array_push($materialCards, $materialCardsTrilha);
							array_push($materialCards, $materialSemanarioTrilha);
							array_push($materialLicao, $materialIntroducaoTrilha);
							array_push($materialLicao, $materialLicaoTrilha);
							array_push($materialLicao, $materialLicaoVisuais2);
							array_push($materialLicao, $materialLicaoVisuais1);
							break;
						case 2:
							$color_modulo = 'blue';
							$color_h3 = 'black';
							break;
						case 3:
							$color_modulo = 'gray';
							$color_h3 = 'white';
							break;
						case 4:
							$color_modulo = 'red';
							$color_h3 = 'black';
							break;
						case 5:
							$color_modulo = 'yellow';
							$color_h3 = 'black';
							break;
						case 6:
							$color_modulo = 'orange-active';
							$color_h3 = 'black';
							break;
						case 7:
							$color_modulo = 'orange';
							$color_h3 = 'black';
							break;
						case 8:
							$color_modulo = 'navy';
							$color_h3 = 'black';
							break;
						case 9:
							$color_modulo = 'brown';
							$color_h3 = 'black';
							break;
						case 10:
							$color_modulo = 'brown-active';
							$color_h3 = 'black';
							break;
						default:
							$color_modulo = 'green';
							$color_h3 = 'black';
							break;
					}

					if ($consultarPG['row'] == 0) {
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
									?>
										<a class="not-active" href="<?php echo base_url($capas['capa']); ?>" download>
											<img src="<?php echo base_url($capas['capa']); ?>" title="Capa" class="img-responsive img-capa" alt="User Image">
										</a>
									<?php } ?>
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
									?>
										<a class="not-active" href="<?php echo base_url($licao['arquivo']); ?>" download>
											<img src="<?php echo base_url($licao['imagem']); ?>" title="<?= $licao['nome']; ?>" class="img-responsive img-capa" alt="User Image">
											<label for=""><?= $licao['nome']; ?></label>
										</a>
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
										<a class="not-active" href="<?php echo base_url($cards['arquivo']); ?>" download>
											<img src="<?php echo base_url('import/sistema/img/documento.png'); ?>" title="<?= $cards['nome']; ?>" class="img-responsive img-capa" alt="User Image">
											<label for=""><?= $cards['nome']; ?></label>
										</a>
									<?php } ?>
								</div>
							</div>
							<!-- /.box-body -->
						</div>
					<?php } else {
						} ?>

				<?php } else { ?>
					<?php

						$idPG = $consultarPG['dados']['id_pg'];

						$consultarCriancas = $this->FConsultas_model->mostrarCriancasPaisPg($id_usuario, $idPG);

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
										?>
											<a class="not-active" href="<?php echo base_url($capas['capa']); ?>" download>
												<img src="<?php echo base_url($capas['capa']); ?>" title="Capa" class="img-responsive img-capa" alt="User Image">
											</a>
										<?php } ?>
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
										?>
											<a class="not-active" href="<?php echo base_url($licao['arquivo']); ?>" download>
												<img src="<?php echo base_url($licao['imagem']); ?>" title="<?= $licao['nome']; ?>" class="img-responsive img-capa" alt="User Image">
												<label for=""><?= $licao['nome']; ?></label>
											</a>
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
											<a class="not-active" href="<?php echo base_url($cards['arquivo']); ?>" download>
												<img src="<?php echo base_url('import/sistema/img/documento.png'); ?>" title="<?= $cards['nome']; ?>" class="img-responsive img-capa" alt="User Image">
												<label for=""><?= $cards['nome']; ?></label>
											</a>
										<?php } ?>
									</div>
								</div>
								<!-- /.box-body -->
							</div>
						<?php } else {
							} ?>

						<?php
						} else {

							$idModuloPG = $consultarPG['dados']['id_modulo'];

							if ($idModuloPG > $id_modulo) {
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
											?>
												<a class="not-active" href="<?php echo base_url($capas['capa']); ?>" download>
													<img src="<?php echo base_url($capas['capa']); ?>" title="Capa" class="img-responsive img-capa" alt="User Image">
												</a>
											<?php } ?>
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
											?>
												<a class="not-active" href="<?php echo base_url($licao['arquivo']); ?>" download>
													<img src="<?php echo base_url($licao['imagem']); ?>" title="<?= $licao['nome']; ?>" class="img-responsive img-capa" alt="User Image">
													<label for=""><?= $licao['nome']; ?></label>
												</a>
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
												<a class="not-active" href="<?php echo base_url($cards['arquivo']); ?>" download>
													<img src="<?php echo base_url('import/sistema/img/documento.png'); ?>" title="<?= $cards['nome']; ?>" class="img-responsive img-capa" alt="User Image">
													<label for=""><?= $cards['nome']; ?></label>
												</a>
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
											?>
												<a href="<?php echo base_url($capas['capa']); ?>" target="_blank" download>
													<img src="<?php echo base_url($capas['capa']); ?>" title="Capa" class="img-responsive img-capa" alt="User Image">
												</a>
											<?php } ?>
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

												if ($licao['id'] == 2 && $consultarPG['dados']['data_inicio'] == '') {
											?>
													<a data-toggle="modal" data-target="<?= "#" . $licao['id']; ?>download" href="#">
														<img src="<?php echo base_url($licao['imagem']); ?>" title="<?= $licao['nome']; ?>" class="img-responsive img-capa" alt="User Image">
														<label for=""><?= $licao['nome']; ?></label>
													</a>

													<div class="modal fade" id="<?= $licao['id']; ?>download">
														<div class="modal-dialog modal-info">
															<div class="modal-content">
																<form action="donwload_material" method="get" target="_blank" id="form__submit">
																	<input type="hidden" name="id" value="<?= $licao['id']; ?>">
																	<input type="hidden" name="id_lider" value="<?= $id_usuario; ?>">
																	<input type="hidden" name="id_pg" value="<?= $idPG; ?>">
																	<input type="hidden" name="title" value="<?= $licao['nome']; ?>" style="color: black;">
																	<input type="hidden" name="download" value="<?= $licao['arquivo']; ?>" style="color: black;">

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
													<a href="donwload_material?id=<?= $licao['id']; ?>&id_lider=<?= $id_usuario; ?>&id_pg=<?= $idPG; ?>&title=<?= $licao['nome']; ?>&download=<?= $licao['arquivo']; ?>" target="_blank" download>
														<img src="<?php echo base_url($licao['imagem']); ?>" title="<?= $licao['nome']; ?>" class="img-responsive img-capa" alt="User Image">
														<label for=""><?= $licao['nome']; ?></label>
													</a>
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
												<a href="<?php echo base_url($cards['arquivo']); ?>" target="_blank" download>
													<img src="<?php echo base_url('import/sistema/img/documento.png'); ?>" title="<?= $cards['nome']; ?>" class="img-responsive img-capa" alt="User Image">
													<label for=""><?= $cards['nome']; ?></label>
												</a>
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
							<a href="pais/home" class="btn btn-warning">Fazer download depois / Continuar</a>
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

				$(conteudo).append('<br><hr><div class="col-lg-12"><div class="form-group"><label for="nomeCrianca">Nome da Criança</label><input class="form-control" id="nomeCrianca" type="text" name="nome[]" placeholder="Nome da Criança" required></div></div><div class="col-lg-6"><div class="form-group"><label for="dataDeNascimento">Data de Nascimento (DD/MM/YYYY)</label><input class="form-control" type="text" id="dataDeNascimento" name="nascimento[]" placeholder="Data de Nascimento (DD/MM/YYYY)" maxlength="10" minlength="10"></div></div><div class="col-lg-6"><div class="col-lg-6"><div class="form-group"><label for="exampleInputEmail1">É Cristão?</label><select name="opcao[]" class="form-control" required><option value="0" selected>Escolha uma opção</option><option value="1">Sim</option><option value="0">Não</option></select></div></div><div class="col-lg-6"><div class="form-group"><label for="exampleInputEmail1">Responsável da Criança:</label><select name="responsavel_crianca[]" onchange="mostrarCamposPais();" class="form-control" required><option value="<?= $dadosPais['nome'] ?>" selected><?= $dadosPais['nome'] ?></option><option value="outro">Outro</option></select></div></div></div><div class="col-lg-12" id="' + linhaResponsaveis + '" style="display: none;"><div class="col-lg-4"><div class="form-group"><label for="exampleInputEmail1">Nome do Responsável (Obrigatório):</label><input class="form-control" type="text" name="nome_responsavel[]" placeholder="Nome do Responsável"></div></div><div class="col-lg-4"><div class="form-group"><label for="exampleInputEmail1">E-mail do Responsável:</label><input class="form-control" type="text" name="email_responsavel[]" placeholder="E-mail do Responsável"></div></div><div class="col-lg-4"><div class="form-group"><label for="exampleInputEmail1">Telefone do Responsável:</label><input class="form-control" type="text" name="telefone_responsavel[]" placeholder="Telefone do Responsável"></div></div></div><div class="col-lg-12"><label for="observacao">Observação</label><textarea id="observacao" name="obs[]" class="form-control"></textarea></div><hr><br><input type="hidden" value="1" id="total" name="total[]">');
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