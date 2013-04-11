<?php
get_header(); ?>
<div id="primary" class="span8">
	<div id="content" role="main">
	
		<? tha_entry_before(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php tha_entry_top(); ?>
			
			<header class="page-header">
				<h1 class="entry-title"><? the_title(); ?></h1>
			</header><!-- .entry-header -->
		
			<div class="entry-content clearfix">
				<p class="lead"><? the_content(); ?></p>
				
				<div class="btn-toolbar">
					<div class="btn-group">
					  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
					    <i class="icon-filter"></i> Filter
					    <span class="caret"></span>
					  </a>
					  <ul class="dropdown-menu">
					    <li><a href="?filter=oepn">Open</a></li>
					    <li><a href="?filter=closed">Closed</a></li>
					     <li><a href="./">All Tickets</a></li>
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
						<a href="/tickets/new/" class="btn btn-primary"><i class="icon-plus icon-white"></i> Open New Ticket</a>
					</div>
				</div>
				
				<h2>Open Tickets</h2>
				
				<? get_template_part( 'arachis-panel', 'tickets-open' ); ?>
				
			</div><!-- .entry-content -->
			<?php edit_post_link( __( 'Edit', 'the-bootstrap' ), '<footer class="entry-meta"><span class="edit-link label">', '</span></footer>' );
			
			tha_entry_bottom(); ?>
		</article><!-- #post-<?php the_ID(); ?> -->
		<?php tha_entry_after(); ?>

	</div><!-- #content -->
</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
?>