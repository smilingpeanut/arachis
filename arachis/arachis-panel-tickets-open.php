<table class="table table-bordered table-striped">
	<thead>
		<th>ID</th>
		<th>Title</th>
		<th>Project</th>
		<th>Updated</th>
	</thead>
	
	<tbody>
	<?
	$tix_args = array(
		'post_type'			=> 'ticket',
		'posts_per_page'	=> -1,
		'meta_key'			=> 'ticket_status',
		'meta_value'		=> 'open'
	);
	
	$tix_query = new WP_Query( $tix_args );
	
	if ( $tix_query->have_posts() ) :
	
		while ( $tix_query->have_posts() ) : $tix_query->the_post();
			$ticket_project = get_field( 'ticket_project' );
	?>
		<tr>
			<td><? the_ID(); ?></td>
			<td>
				<a href="<? the_permalink(); ?>" title="<? the_title_attribute(); ?>">
					<? the_title(); ?>
				</a>
			</td>
			<td>
				<a href="<?= get_permalink( $ticket_project->ID ); ?>"><?= $ticket_project->post_title; ?></a>
			</td>
			<td>
				Date
			</td>
		</tr>
	<?
		endwhile; wp_reset_query();
	
	endif;
	?>
	</tbody>
</table>