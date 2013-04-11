<?
/* KEEP NON-ADMINS FROM ADMIN PAGES */

function arachis_admin_only() {
	if ( !current_user_can('administrator') ) :
		wp_redirect( home_url() );
	endif;
}

/* ADDING EXTRA FIELDS TO ACF:
   1) USER SELECT FIELD
   2) TIME PICKER FIELD */

if ( function_exists('register_field') ) {
	register_field('Users_field', dirname(__File__) . '/fields/users_field.php');
	register_field('acf_time_picker', dirname(__File__) . '/fields/acf_time_picker/acf_time_picker.php');
}

/* //END ACF EXTRA FIELDS */

/* CHANGING PERMALINK STRUCTURE FOR TICKET POST_TYPE TO
   /ticket/ID
   
   http://wordpress.org/support/topic/custom-post-type-permalink-structure */
   
add_action('init', 'arachis_ticket_rewrite');

function arachis_ticket_rewrite() {
	global $wp_rewrite;
	$queryarg = 'post_type=ticket&p=';
	$wp_rewrite->add_rewrite_tag('%post_id%', '([^/]+)', $queryarg);
	$wp_rewrite->add_permastruct('ticket', '/ticket/%post_id%', false);
}

add_filter('post_type_link', 'arachis_ticket_permalink', 1, 3);

function arachis_ticket_permalink($post_link, $id = 0, $leavename) {
	global $wp_rewrite;
	$post = &get_post($id);
	if ( is_wp_error( $post ) )
		return $post;
	$newlink = $wp_rewrite->get_extra_permastruct('ticket');
	$newlink = str_replace("%post_id%", $post->ID, $newlink);
	$newlink = home_url(user_trailingslashit($newlink));
	if(get_post_type() == 'ticket') :
		return $newlink;
	else :
		return $post_link;
	endif;
}

/* //END TICKET POST_TYPE PERMALINK */

/* GET TOTAL TASKS FOR A PROJECT */

function arachis_get_total_tasks($post_id) {
	global $wpdb;
	$get_tasks = $wpdb->get_row( 
		"
			SELECT COUNT(meta_id) 
			AS total 
			FROM $wpdb->postmeta 
			WHERE post_id = '" . $post_id . "' 
			AND meta_key LIKE '%task_name%' 
			AND meta_value NOT LIKE '%field_%'
		"
	);
	return $get_tasks->total;
}

/* //END TOTAL TASKS */

/* GET COMPLETED TASKS FOR A PROJECT */

function arachis_get_completed_tasks($post_id) {
	global $wpdb;
	$get_tasks = $wpdb->get_row( 
		"
			SELECT COUNT(meta_id) 
			AS completed 
			FROM $wpdb->postmeta 
			WHERE post_id = '" . $post_id . "' 
			AND meta_key LIKE '%task_completed%' 
			AND meta_value NOT LIKE '%field_%' 
			AND meta_value > 0
		"
	);
	return $get_tasks->completed;
}

/* //END TOTAL TASKS */

/* HUMAN READABLE TIME */

if (!function_exists('arachis_human_time_diff')) {
	function arachis_human_time_diff( $date ) { 
		if (strtotime($date)<strtotime('NOW -7 day')) return date('jS F Y', strtotime($date));
		else return human_time_diff(strtotime($date), current_time('timestamp')) . __(' ago', 'onyx');
	}
}

/* //END HUMAN READABLE TIME */

/*-----------------------------------------------------------------------------------*/
/* Sorting headings on tickets list */
/*-----------------------------------------------------------------------------------*/

if (!function_exists('arachis_sort_by_link')) {
	function arachis_sort_by_link( $ordering_link = 'age', $label = 'Age' ) { 
		
		$_current_url = strip_tags( 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] );
		
		if (!isset($_GET['orderby'])) $_GET['orderby'] = 'age';
		if (!isset($_GET['order'])) $_GET['order'] = 'desc';
		
		if ($_GET['order']=='asc') $arrow = '&uarr;'; else $arrow = '&darr;';
		
		$dir = ( $_GET['orderby']==$ordering_link && $_GET['order'] == 'asc' ) ? 'desc' : "asc";  

		echo '<a href="' . add_query_arg(array('orderby' => $ordering_link, 'order' => $dir), $_current_url) . '">'.$label.' ';
		if ($_GET['orderby']==$ordering_link) echo $arrow;
		echo '</a>';
		
	}
}


/*-----------------------------------------------------------------------------------*/
/* Gravity Forms - New Project */
/* Populating drop-downs with the values we need: */
/*-----------------------------------------------------------------------------------*/

function arachis_populate_projects($form){
    
    foreach($form['fields'] as &$field){
        
        if($field['type'] != 'post_custom_field' || strpos($field['cssClass'], 'populate_projects') === false)
            continue;
        
        // you can add additional parameters here to alter the posts that are retreieved
        // more info: http://codex.wordpress.org/Template_Tags/get_posts
        $posts = get_posts('numberposts=-1&post_status=publish&post_type=project');
        
        // update 'Select a Post' to whatever you'd like the instructive option to be
        $choices = array(array('text' => 'Select a Project', 'value' => ' '));
        
        foreach($posts as $post){
            $choices[] = array('text' => $post->post_title, 'value' => $post->post_title);
        }
        
        $field['choices'] = $choices;
        
    }
    
    return $form;
}

add_filter('gform_pre_render_1', 'arachis_populate_users');

function arachis_populate_users($form){
    
    foreach($form['fields'] as &$field){
        
        if($field['type'] != 'post_custom_field' || strpos($field['cssClass'], 'populate_users') === false)
            continue;
        
        // you can add additional parameters here to alter the posts that are retreieved
        // more info: http://codex.wordpress.org/Template_Tags/get_posts
        $users = get_users('blog_id=18&orderby=nicename');
        
        // update 'Select a Post' to whatever you'd like the instructive option to be
        $choices = array(array('text' => 'Select a User', 'value' => ' '));
        
        foreach($users as $user){
            $choices[] = array('text' => $user->display_name, 'value' => $user->ID);
        }
        
        $field['choices'] = $choices;
        
    }
    
    return $form;
}

function arachis_get_fields( $fields_to_get ) {
	$field_array = array();
	
	foreach ( $fields_to_get as $each_field ) :
		$field_array['{$each_field}'] = get_field( $each_field );
	endforeach;
	
	return $field_array;
}