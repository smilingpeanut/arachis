<?php
get_header(); ?>
<div id="primary" class="span8">
	<div id="content" role="main">
	
		<? tha_entry_before(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php tha_entry_top(); ?>
			
			<header class="page-header">
				<h1 class="entry-title">Welcome, <?= $current_user->display_name; ?></h1>
			</header><!-- .entry-header -->
		
			<div class="entry-content clearfix">
				<p class="lead">This is your account dashboard, which gives you an overview of your projects, open tickets and open orders.</p>
				
				<h2>Open Projects</h2>
				
				<? get_template_part( 'arachis-panel', 'projects-open' ); ?>
				
				<p class="text-right">
					<a href="/projects/" class="btn btn-info">
						<i class="icon icon-white icon-eye-open"></i> 
						All Projects
					</a>
				</p>
				
				<h2>Open Tickets</h2>
				
				<? get_template_part( 'arachis-panel', 'tickets-open' ); ?>
				
				<p class="text-right">
					<a href="/tickets/" class="btn btn-info">
						<i class="icon icon-white icon-tags"></i> 
						All Tickets
					</a>
				</p>
				
				<h2>Open Orders</h2>
				
				<? get_template_part( 'arachis-panel', 'orders-open' ); ?>
				
				<p class="text-right">
					<a href="/orders/" class="btn btn-info">
						<i class="icon icon-white icon-shopping-cart"></i> 
						All Orders
					</a>
				</p>
				
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