<?
$today = date('m-d-Y', strtotime( 'now' ) );
$today_split = explode( '-', $today );

$in_a_week = date('Y-m-d', mktime( 0, 0, 0, $today_split[0], $today_split[1]+7, $today_split[2] ) );

$task_args = array(
	'post_type'			=> 'task',
	'meta_query'		=> array(
		array(
			'key'				=> 'item_status',
			'value'			=> 'open',
			'compare'	=> '='
		),
		array(
			'key'				=> 'item_assignee',
			'value'			=> 1,
			'compare'	=> 'LIKE'
		),
		array(
			'key'				=> 'item_due',
			'value'			=> $in_a_week,
			'compare'	=> '<='
		)
	)
);

$task_query = new WP_Query( $task_args );

if ( $task_query->have_posts() ) :
?>
<ul>
<?
	while( $task_query->have_posts() ) : $task_query->the_post();
?>
	<li><? the_title(); ?></li>
<?
	endwhile;
?>
</ul>
<? endif; ?>