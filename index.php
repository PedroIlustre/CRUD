<?php 
require_once 'config.php'; 
require_once DBAPI;

include(HEADER_TEMPLATE); 
$db = open_database(); ?>

<h1>Dashboard</h1>
<hr />

<?php if ($db) { ?>

<div class="row">
	<div class="col-xs-6 col-sm-3 col-md-2">
		<a href="funcionarios/add.php" class="btn btn-primary">
			<div class="row">
				<div class="col-xs-12 text-center">
					<i class="fa fa-plus fa-5x"></i>
				</div>
				<div class="col-xs-12 text-center">
					<p>Novo Funcionário</p>
				</div>
			</div>
		</a>
	</div>

	<div class="col-xs-6 col-sm-3 col-md-2">
            <a href="funcionarios" class="btn btn-default">
			<div class="row">
				<div class="col-xs-12 text-center">
					<i class="fa fa-user fa-5x"></i>
				</div>
				<div class="col-xs-12 text-center">
					<p>Funcionários</p>
				</div>
			</div>
		</a>
	</div>
</div>

<?php }else { ?>
	<div class="alert alert-danger" role="alert">
		<p><strong>ERRO:</strong> Não foi possível Conectar ao Banco de Dados!</p>
	</div>

<?php } ?>

<?php include(FOOTER_TEMPLATE);