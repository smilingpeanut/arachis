<?
/* Displays all tasks due in the next week */
class TasksDueSoonWidget extends WP_Widget {
	function TasksDueSoonWidget() {
		$widget_ops = array('classname' => 'TasksDueSoonWidget', 'description' => 'Displays tasks that are due in the next week.' );
		$this->WP_Widget('TasksDueSoonWidget', 'Tasks Due Soon', $widget_ops);
	}
	
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = $instance['title'];
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title: 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
			</label>
		</p>
		<?php
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		return $instance;
	}
	
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		
		echo $before_widget;
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		
		if (!empty($title))
		echo $before_title . $title . $after_title;;

		/* ===== Begin Widget ===== */		
		$today = date( 'm-d-Y', strtotime( 'now' ) );
		$today_split = explode( '-', $today );
		
		$now = date( 'Y-m-d', strtotime( 'now' ) );
		
		$in_a_week = date( 'Y-m-d', mktime( 0, 0, 0, $today_split[0], $today_split[1]+7, $today_split[2] ) );
		
		$current_user = wp_get_current_user();
		
		$task_args = array(
			'post_type'			=> 'task',
			'order'					=> 'ASC',
			'meta_query'		=> array(
				array(
					'key'				=> 'item_status',
					'value'			=> 'open',
					'compare'	=> '='
				),
				array(
					'key'				=> 'item_assignee',
					'value'			=> $current_user->ID,
					'compare'	=> '=',
				),
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
			)
		);
		
		$task_query = new WP_Query( $task_args );
		
		if ( $task_query->have_posts() ) :
		?>
		<table class="table table-striped">
		<?
			while( $task_query->have_posts() ) : $task_query->the_post();
				$item_project = get_field( 'item_project' );
				$item_due = get_field( 'item_due' );
		?>
			<tr>
				<td>
					<a href="<?= get_permalink( $item_project ); ?>"><? the_title(); ?></a>
				</td>
				<td>
					<?= date( 'n/j', strtotime( $item_due ) ); ?>
				</td>
			</tr>
		<?	
			endwhile;
		?>
		</table>
		<?
		endif;
		/* ===== End Widget ===== */
		
		echo $after_widget;
	}
	
	}
add_action( 'widgets_init', create_function('', 'return register_widget("TasksDueSoonWidget");') );
?>