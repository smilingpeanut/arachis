<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>
				<i class="icon-tasks"></i> Task
			</th>
			<th>
				<i class="icon-folder-open"></i> Project
			</th>
			<th>
				<i class="icon-calendar"></i> Due
			</th>
		</tr>
	</thead>
	
	<tbody>
	<?
	$task_args = array(
		'post_type'			=> 'task',
		'posts_per_page'	=> -1,
		'meta_query'		=> array(
/*
				array(
					'key'				=> 'item_status',
					'value'			=> 'open',
					'compare'	=> '='
				),
*/
				array(
					'key'				=> 'item_assignee',
					'value'			=> $current_user->ID,
					'compare'	=> '=',
				),
/*
				array(
					'key'				=> 'item_due',
					'value'			=> $now,
					'compare'	=> '>='
				),
				array(
					'key'				=> 'item_due',
					'value'			=> $in_a_week,
					'compare'	=> '<='
				)
*/
			)
	);
	
	$task_query = new WP_Query( $task_args );
	
	if ( $task_query->have_posts() ) :
	
		while ( $task_query->have_posts() ) : $task_query->the_post();
			$fields_to_get = array(
				'item_project',
				'item_status',
				'item_due'
			);
			
			foreach ( $fields_to_get as $each_field ) :
				${ $each_field } = get_field( $each_field );
			endforeach;
			
			if ( $item_status == 'open' ) $row_class = 'warning';
			elseif ( $item_status == 'on-hold' ) $row_class = 'error';
			else $row_class = 'success';
	?>
		<tr class="<?= $row_class; ?>">
			<td>
				<a href="<? the_permalink(); ?>" title="<? the_title_attribute(); ?>">
					<? the_title(); ?>
				</a>
			</td>
			<td>
				<a href="<?= get_permalink( $item_project->ID ); ?>"><?= get_the_title( $item_project->ID ); ?></a>
			</td>
			<td>
				<? if ( $item_status == 'completed' ) : ?>
				<i class="icon-ok"></i>
				<?
				else :
					echo date( 'F j', strtotime( $item_due ) );
				endif;
				?>
			</td>
		</tr>
	<?
		endwhile; wp_reset_query();
	
	endif;
	?>
	</tbody>
</table>