<?php $numeroPaginas = totalPaginas($datos_por_pagina, $conexion);?>

<?php if (!empty($horas)): ?>
	<section class="paginacion">
		<ul>
			<?php if (paginaActual() === 1): ?>
				<li class="disabled"> &laquo; </li>
			<?php else: ?>
				<li><a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . $id;?>&p=<?php echo paginaActual() - 1; ?>"> &laquo;  </a></li>
			<?php endif ?>

			<?php for($i=1; $i<=$numeroPaginas; $i++): ?>
				<?php if (paginaActual() === $i): ?>
					<li class="active">
						<?php echo $i; ?>
					</li>
				<?php else: ?>
					<li>
						<a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . $id;?>&p=<?php echo $i; ?>"> <?php echo $i; ?> </a>
					</li>
				<?php endif; ?>
			<?php endfor; ?>

			<?php if (paginaActual() == $numeroPaginas): ?>
				<li class="disabled"> &raquo; </li>
			<?php else: ?>
				<li><a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . $id;?>&p=<?php echo paginaActual() + 1; ?>"> &raquo;  </a></li>
			<?php endif ?>
		</ul>
	</section>
<?php else: ?>
	<h5 class="text-center pt-3 pb-3"><i class="admin-icon fa fa-calendar-times-o"></i>Todavía no hay horario asignados.</h5>
<?php endif; ?>
