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
				
				<? get_template_part( 'arachis-panel', 'orders-all' ); ?>
				
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