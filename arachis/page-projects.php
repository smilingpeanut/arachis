<?php
get_header();
?>
<div id="primary" class="span8">
	<div id="content" role="main">
		<?php
		the_post();
		?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="page-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

<div class="btn-toolbar">	
	<div class="btn-group">
	  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
	    <i class="icon-filter"></i> Filter
	    <span class="caret"></span>
	  </a>
	  <ul class="dropdown-menu">
	    <li><a href="?filter=ongoing">Ongoing</a></li>
	    <li><a href="?filter=hold">On Hold</a></li>
	    <li><a href="?filter=canceled">Canceled</a></li>
	    <li><a href="?filter=completed">Completed</a></li>
	     <li><a href="./">All Projects</a></li>
	  </ul>
	</div>
	
	<div class="btn-group">
	  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
	    <i class="icon-resize-vertical"></i> Sort
	    <span class="caret"></span>
	  </a>
	  <ul class="dropdown-menu">
	    <li><?php arachis_sort_by_link('status', __('By Status', 'onyx')); ?></li>
	    <li><?php arachis_sort_by_link('title', __('By Project', 'onyx')); ?></li>
	    <li><?php arachis_sort_by_link('modified', __('By Updated', 'onyx')); ?></li>
	  </ul>
	</div>
	
	<div class="btn-group">
		<a href="/projects/new/" class="btn btn-primary"><i class="icon-plus icon-white"></i> New Project</a>
	</div>
	
	<div class="btn-group">
		<a class="btn btn-info"><i class="icon-share-alt icon-white"></i> Export</a>
	</div>
</div>

	<div class="entry-content clearfix">

		<table class="table table-bordered table-striped">
			<thead>
				<th><?php arachis_sort_by_link('status', __('Status', 'onyx')); ?></th>
				<th><?php arachis_sort_by_link('title', __('Project', 'onyx')); ?></th>
				<th><?php arachis_sort_by_link('modified', __('Updated', 'onyx')); ?></th>
				<th>Progress</th>
			</thead>
			<tbody>
		<?php
        $main_args = array(
        	'post_type'	=> 'project',
			'numberposts'	=>	'-1'
        );
        
        $client_args = array();
        $order_args = array();
        $filter_args = array();
        
        if ( $_REQUEST['orderby'] ) :
        	$order_args = array(
        		'orderby'	=>	$_GET['orderby'],
        		'order'		=>	$_GET['order']
        	);
        	
        	if ( $_REQUEST['orderby'] == 'status' ) :
        		$order_args = array(
        			'meta_key'	=>	'project_status',
        			'orderby'		=>	'meta_value',
        			'order'			=>	$_GET['order']
        		);
        	endif;
        	
        else :
        	$order_args = array(
        		'orderby'	=>	'modified',
        		'order'		=>	'desc'
        	);
        	
        endif;
        
        if ( $_REQUEST['filter'] ) :
        	$filter_args = array(
        		'meta_key'	=>	'project_status',
        		'meta_value'	=>	$_REQUEST['filter']
        	);
        	
        	if ( $_REQUEST['filter'] == 'hold' ) :
        		$filter_args = array(
        			'meta_value'	=>	'On Hold'
        		);
        	endif;
        	
        endif;
        
        $args = array_merge(
        	$main_args,
        	$order_args,
        	$filter_args
        );

        $projects = get_posts( $args );
                
        if ( $projects ) :
	    	foreach ( $projects as $post ) : setup_postdata($post);
				$total_tasks = arachis_get_total_tasks(get_the_ID());
				$completed_tasks = arachis_get_completed_tasks(get_the_ID());
				
				if ( $total_tasks > 0 ) :
					$fancy_percentage = $completed_tasks / $total_tasks;
					$fancy_percentage = round($fancy_percentage * 100);
				else :
					$fancy_percentage = 0;
				endif;
				
				$project_status = get_field( 'project_status' );
				
				if ( $project_status == 'Ongoing' ) $label = 'label';
				elseif ( $project_status == 'On Hold' ) $label = 'label label-warning';
				elseif ( $project_status == 'Canceled' ) $label = 'label label-inverse';
				else $label = 'label label-success';
	    ?>
	        	<tr>
	        		<td>
		        		<span class="<?= $label; ?>"><?= $project_status; ?></span>
	        		</td>
	        		<td><a href="<? the_permalink(); ?>"><? the_title(); ?></a></td>
					<td><?php echo $post->post_modified; ?></td>
	        		<td>
	        			<div class="progress progress-striped active">
	        				<div class="bar" style="width: <?= $fancy_percentage; ?>%;"><?= $fancy_percentage; ?>%</div>
	        			</div>
	        		</td>
	        		
	        	</tr>
	    <?
	    	endforeach;
	    	wp_reset_postdata();
	    ?>
            	</table>

        <?		
		else:
		?>
			<tr><td colspan="4">Nothing to see here. :(</td></tr>
		<?		
		endif;
		?>			
			</tbody>
		</table>

	</div><!-- .entry-content -->
	<?php edit_post_link( __( 'Edit', 'the-bootstrap' ), '<footer class="entry-meta"><span class="edit-link label">', '</span></footer>' ); ?>
</article><!-- #post-<?php the_ID(); ?> -->
	</div><!-- #content -->
</div><!-- #primary -->

<?php
get_sidebar();
get_footer();


/* End of file page.php */
/* Location: ./wp-content/themes/the-bootstrap/page.php */