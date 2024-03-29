<div class="adp_download_links">
	<a href="<?php echo $print_url; ?>" target="_blank" title="Print"><i class="material-icons">local_printshop</i></a>
	<a href="<?php echo $csv_url; ?>" target="_blank" title="CSV Download"><i class="material-icons">file_download</i></a>
</div>
<table id="fantrax_fantasyadp" class="fantrax_fantasyadp tablesorter">
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
					<td><a href="https://www.fantrax.com/newui/playerProfile.go?pId=<?php echo $player->id; ?>" target="_blank"><?php echo $player->name; ?></a></td>
                    <td><?php echo $player->pos; ?></td>
                    <td><?php echo $player->ADP; ?></td>
                </tr>
	            <?php
	            $i++;
            } elseif( in_array( $atts['order'], array( 'NAME', 'ADP_PPR', 'name', 'adp_ppr' ) ) && !empty( $player->ADP_PPR ) ) {
	            ?>
                <tr class="<?php echo $class; ?>">
                    <td><?php echo $i; ?></td>
                    <td><a href="https://www.fantrax.com/newui/playerProfile.go?pId=<?php echo $player->id; ?>" target="_blank"><?php echo $player->name; ?></a></td>
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