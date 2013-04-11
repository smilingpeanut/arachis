<?php
get_header();
$project = $post->ID;
$client = get_field('project_client');
$project_manager = get_field('project_manager');
$status = get_field('project_status');
$due_date = get_field('project_due');
$url = get_field('project_url');
$credentials = get_field('credentials');

if ( $status == 'Ongoing' ) $label = 'label';
elseif ( $status == 'On Hold' ) $label = 'label label-warning';
elseif ( $status == 'Canceled' ) $label = 'label label-inverse';
else $label = 'label label-success';
?>

<div id="primary" class="span8">
	<div id="content" role="main">

		<?php
		the_post();
		?>
		
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="page-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<span class="<?= $label; ?>">
			<?
			editable_post_meta( get_the_ID(), 'project_status', array(
				'type'	=>	'select',
				'values'	=>	array(
					'Ongoing'	=>	'Ongoing',
					'On Hold'	=>	'On Hold',
					'Canceled'	=>	'Canceled',
					'Completed'	=>	'Completed'
					)
				)
			);
			?>
		</span>
		<div class="entry-meta"></div><!-- .entry-meta -->
	</header><!-- .entry-header -->
	
<div class="btn-toolbar">	
	<div class="btn-group">
		<a href="/projects/new/" class="btn btn-primary"><i class="icon-edit icon-white"></i> Edit</a>
	</div>
	
	<div class="btn-group">
		<a class="btn btn-info"><i class="icon-print icon-white"></i> Print</a>
	</div>
</div>

<ul class="nav nav-tabs">
	<li class="active">
		<a href="#overview" data-toggle="tab"><i class="icon icon-home"></i> Overview</a>
	</li>
	<li>
		<a href="#tasks" data-toggle="tab"><i class="icon icon-tasks"></i> Tasks</a>
	</li>
	<li>
		<a href="#tickets" data-toggle="tab"><i class="icon icon-tags"></i> Tickets</a>
	</li>
	<li>
		<a href="#time" data-toggle="tab"><i class="icon icon-time"></i> Time</a>
	</li>
	<li>
		<a href="#orders" data-toggle="tab"><i class="icon icon-shopping-cart"></i> Orders</a>
	</li>
	<li>
		<a href="#credentials" data-toggle="tab"><i class="icon icon-lock"></i> Credentials</a>
	</li>
	<li>
		<a href="#files" data-toggle="tab"><i class="icon icon-file"></i> Files</a>
	</li>
	<li>
		<a href="#notes" data-toggle="tab"><i class="icon icon-comment"></i> Notes</a>
	</li>
</ul>
	 
	<div class="tab-content">
	  <div class="tab-pane fade in active" id="overview">
	  
		<div class="entry-content clearfix">
			<?php
			the_content();
			the_bootstrap_link_pages(); ?>
		</div><!-- .entry-content -->
	  
		  <div class="row">
			<div class="span4">
			
				<table class="table table-bordered table-striped">
					<tr>
						<td><strong>Client</strong></td>
						<td>
							<?= $client->display_name; ?> <br />
							<?= $client->billing_company; ?>
						</td>
					</tr>
					<tr>				
						<td><strong>Project Manager</strong></td>
						<td><?= $project_manager->display_name; ?></td>
					</tr>
				</table>	
			
			</div>
			
			<div class="span4">
				
				<table class="table table-bordered table-striped">
					<tr>
						<td><strong>Created</strong></td>
						<td><?= $post->post_date; ?></td>
					</tr>
					<tr>
						<td><strong>Updated</strong></td>
						<td><?= $post->post_modified; ?></td>
					</tr>
				</table>
				
			</div>
		  </div>
  
	  </div>
	  
	  <div class="tab-pane fade" id="tasks">
	  
	  	<p>
	  		<h3>Tasks</h3>
	  	</p>
		  
		<?
		$project_task_args = array(
			'post_type'		=> 'task',
			'order'				=> 'ASC',
			'meta_key'		=> 'item_project',
			'meta_value'	=> $project
		);
		
		$project_task_query = new WP_Query( $project_task_args );
		
		if ( $project_task_query->have_posts() ) :
		?>
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>
						<i class="icon-tasks"></i> Task
					</th>
					<th>
						<i class="icon-user"></i> Assignee
					</th>
					<th>
						<i class="icon-calendar"></i> Due
					</th>
				</tr>
			</thead>
		<?
			while ( $project_task_query->have_posts() ) : $project_task_query->the_post();
				$fields_to_get = array(
					'item_status',
					'item_due',
					'item_assignee'
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
					<? if ( $item_status != 'completed' ) : ?>
						<a href="#" class="btn btn-success"><i class="icon-ok icon-white"></i></a> 
					<? endif; ?>
					<? the_title(); ?>
				</td>
				<td>
					<?= $item_assignee->display_name; ?>
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
		?>
		</table>
		<?
		else :
		?>
		<div class="alert alert-info">
			There are no tasks on file for this project.
		</div>
		<? endif; ?>
		  
	  </div>
	  
	  <div class="tab-pane fade" id="tickets">
		<?
		$project_ticket_args = array(
			'post_type'		=> 'ticket',
			'order'				=> 'ASC',
			'meta_key'		=> 'item_project',
			'meta_value'	=> $project
		);
		
		$project_ticket_query = new WP_Query( $project_ticket_args );
		
		if ( $project_ticket_query->have_posts() ) :
		?>
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>
						<i class="icon-tag"></i> Ticket
					</th>
					<th>
						<i class="icon-user"></i> Assignee
					</th>
					<th>
						<i class="icon-calendar"></i> Due
					</th>
				</tr>
			</thead>
		<?
			while ( $project_ticket_query->have_posts() ) : $project_ticket_query->the_post();
				$fields_to_get = array(
					'item_status',
					'item_due',
					'item_assignee'
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
					<? if ( $item_status != 'completed' ) : ?>
						<a href="#" class="btn btn-success"><i class="icon-ok icon-white"></i></a> 
					<? endif; ?>
					<? the_title(); ?>
				</td>
				<td>
					<?= $item_assignee->display_name; ?>
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
		?>
		</table>
		<?
		else :
		?>
		<div class="alert alert-info">
			There are no tickets on file for this project.
		</div>
		<? endif; ?>

	  </div>
	  
	  <div class="tab-pane fade" id="time">time</div>
	  <div class="tab-pane fade" id="orders">orders</div>
	  <div class="tab-pane fade" id="credentials">
	  
				<?
                if ( $credentials ) :
				?>
					<p><h3>Credentials</h3></p>
					
                	<table class="table table-bordered table-striped">
                		<thead>
                			<tr>
                				<th>Type</th>
                				<th>User</th>
                				<th>Password</th>
								<th>Notes</th>
                			</tr>
                		</thead>
				<?
                	$alt = 1;
                
                	foreach ( $credentials as $cred_item ) :
                		$alt = $alt * -1;
                ?>
                		<tr class="<?php if ($alt==1) echo 'odd'; else echo 'even'; ?>">
                			<td>
								<? if ( $cred_item['cred_url'] ) : ?>
								<a href="<?= $cred_item['cred_url']; ?>" target="_blank">
								<? endif; ?>
								<?= $cred_item['cred_type']; ?>
								<? if ( $cred_item['cred_url'] ) : ?>
								</a>
								<? endif; ?>
							</td>
                			<td><?= $cred_item['cred_user']; ?></td>
							<td><?= $cred_item['cred_password']; ?></td>
							<td><?= $cred_item['cred_notes']; ?></td>
                		</tr>
                <?
                	endforeach;
                ?>
                	</table>
                <?
					else :
				?>
					<div class="alert alert-info">
						There are no credentials on file for this project.
					</div>
				<?
                endif;
                ?>	  
	  
	  </div>
	  
	  <div class="tab-pane fade" id="files">
		  
		  <p>
		  	<h3>Files</h3>
		  </p>
		  
<?
$file_args = array(
'post_type'		=> 'attachment',
'parent'			=> $project
);

$file_q = new WP_Query( $file_args );

if ( $file_q->have_posts() ) :

	while ( $file_q->have_posts() ) : $file_q->the_post();
	
		the_ID();
	
	endwhile; wp_reset_query();

endif;
?>
		  
		  
	  </div>
	  
		<div class="tab-pane fade" id="notes">
		
			<p>
				<h3>Notes</h3>
			</p>
			
			<?
			$note_args = array(
				'post_id'	=> $project
			);
			
			$notes = get_comments( $note_args );
			
			if ( $notes ) :
			?>
			<table class="table table-bordered table-striped">
			<?
			foreach ( $notes as $note ) :
				$alt = $alt * -1;
			?>
				<tr class="<?php if ($alt==1) echo 'odd'; else echo 'even'; ?>">
					<td>
						<?= get_avatar( $note->user_id, 128, $note->comment_author ); ?>
					</td>
					<td>
						<?= wpautop( $note->comment_content ); ?>
						(<?= $note->comment_date; ?>)
					</td>
				</tr>
			<? endforeach; ?>
			</table>
			<? endif; ?>
			
			<? comment_form(); ?>
		</div>
	
	</div>	
	
</article><!-- #post-<?php the_ID(); ?> -->

	</div><!-- #content -->
</div><!-- #primary -->

<?php
get_sidebar();
get_footer();


/* End of file page.php */
/* Location: ./wp-content/themes/the-bootstrap/page.php */