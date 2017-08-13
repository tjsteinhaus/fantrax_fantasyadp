<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?php wp_title( '' ); ?></title>
	<?php wp_head(); ?>
</head>
<body>
	<table id="fantrax_fantasyadp" class="fantrax_fantasyadp tablesorter print_table">
		<thead>
		<tr>
			<th>Rk</th>
			<th>Player</th>
			<th>POS</th>
			<th>ADP</th>
		</tr>
		</thead>
		<tbody>
		<?php
		if( !empty( $data ) ) {
			$i = ( $atts['start'] == 0 ) ? 1 : $atts['start'];
			foreach( $data as $player ) {
				$class = ( $i % 2 == 0 ) ? 'even' : 'odd';
				if( in_array( $atts['order'], array( 'NAME', 'ADP', 'name', 'adp' ) ) && !empty( $player->ADP ) ) {
					?>
					<tr class="<?php echo $class; ?>">
						<td><?php echo $i; ?></td>
						<td><?php echo $player->name; ?></td>
						<td><?php echo $player->pos; ?></td>
						<td><?php echo $player->ADP; ?></td>
					</tr>
					<?php
					$i++;
				} elseif( in_array( $atts['order'], array( 'NAME', 'ADP_PPR', 'name', 'adp_ppr' ) ) && !empty( $player->ADP_PPR ) ) {
					?>
					<tr class="<?php echo $class; ?>">
						<td><?php echo $i; ?></td>
						<td><?php echo $player->name; ?></td>
						<td><?php echo $player->pos; ?></td>
						<td><?php echo $player->ADP_PPR; ?></td>
					</tr>
					<?php
					$i++;
				}
			}
		}
		?>
		</tbody>
	</table>
	<script type="text/javascript">
		window.print();
	</script>
</body>
</html>