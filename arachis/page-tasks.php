<?php
get_header(); ?>

<div id="primary" class="span8">
	<div id="content" role="main">

		<?php
		the_post();
		get_template_part( '/partials/content', 'page' );
		//comments_template(); ?>
		
		<? get_template_part( 'arachis-panel', 'tasks' ); ?>

	</div><!-- #content -->
</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
?>