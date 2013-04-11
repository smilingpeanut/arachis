<?
/* ===== Projects (project) ===== */
if ( ! function_exists('arachis_cpt_projects') ) {

// Register Custom Post Type
function arachis_cpt_projects() {
	$labels = array(
		'name'								=> _x( 'Projects', 'Post Type General Name', 'arachis' ),
		'singular_name'				=> _x( 'Project', 'Post Type Singular Name', 'arachis' ),
		'menu_name'					=> __( 'Projects', 'arachis' ),
		'parent_item_colon'			=> __( 'Parent Project:', 'arachis' ),
		'all_items'							=> __( 'All Projects', 'arachis' ),
		'view_item'						=> __( 'View Project', 'arachis' ),
		'add_new_item'				=> __( 'Add New Project', 'arachis' ),
		'add_new'						=> __( 'New Project', 'arachis' ),
		'edit_item'						=> __( 'Edit Project', 'arachis' ),
		'update_item'					=> __( 'Update Project', 'arachis' ),
		'search_items'					=> __( 'Search Projects', 'arachis' ),
		'not_found'						=> __( 'No Projects found', 'arachis' ),
		'not_found_in_trash'		=> __( 'No Projects found in Trash', 'arachis' ),
	);

	$args = array(
		'label'								=> __( 'prjoect', 'arachis' ),
		'description'						=> __( 'Arachis projects', 'arachis' ),
		'labels'								=> $labels,
		'supports'							=> array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', ),
		'hierarchical'					=> true,
		'public'								=> true,
		'show_ui'							=> true,
		'show_in_menu'				=> true,
		'show_in_nav_menus'		=> true,
		'show_in_admin_bar'		=> true,
		'menu_position'				=> 2.1,
		'menu_icon'						=> null,
		'can_export'						=> true,
		'has_archive'					=> false,
		'exclude_from_search'	=> false,
		'publicly_queryable'			=> true,
		'capability_type'				=> 'page',
	);

	register_post_type( 'project', $args );
}

// Hook into the 'init' action
add_action( 'init', 'arachis_cpt_projects', 0 );

}


/* ===== Tasks (task) ===== */
if ( ! function_exists('arachis_cpt_tasks') ) {

// Register Custom Post Type
function arachis_cpt_tasks() {
	$labels = array(
		'name'								=> _x( 'Tasks', 'Post Type General Name', 'arachis' ),
		'singular_name'				=> _x( 'Task', 'Post Type Singular Name', 'arachis' ),
		'menu_name'					=> __( 'Tasks', 'arachis' ),
		'parent_item_colon'			=> __( 'Parent Task:', 'arachis' ),
		'all_items'							=> __( 'All Tasks', 'arachis' ),
		'view_item'						=> __( 'View Task', 'arachis' ),
		'add_new_item'				=> __( 'Add New Task', 'arachis' ),
		'add_new'						=> __( 'New Task', 'arachis' ),
		'edit_item'						=> __( 'Edit Task', 'arachis' ),
		'update_item'					=> __( 'Update Task', 'arachis' ),
		'search_items'					=> __( 'Search Tasks', 'arachis' ),
		'not_found'						=> __( 'No Tasks found', 'arachis' ),
		'not_found_in_trash'		=> __( 'No Tasks found in Trash', 'arachis' ),
	);

	$args = array(
		'label'								=> __( 'task', 'arachis' ),
		'description'						=> __( 'Arachis tasks', 'arachis' ),
		'labels'								=> $labels,
		'supports'							=> array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', ),
		'hierarchical'					=> true,
		'public'								=> true,
		'show_ui'							=> true,
		'show_in_menu'				=> true,
		'show_in_nav_menus'		=> true,
		'show_in_admin_bar'		=> true,
		'menu_position'				=> 2.2,
		'menu_icon'						=> null,
		'can_export'						=> true,
		'has_archive'					=> false,
		'exclude_from_search'	=> false,
		'publicly_queryable'			=> true,
		'capability_type'				=> 'page',
	);

	register_post_type( 'task', $args );
}

// Hook into the 'init' action
add_action( 'init', 'arachis_cpt_tasks', 0 );

}

/* ===== Tasks (task) ===== */
if ( ! function_exists('arachis_cpt_tickets') ) {

// Register Custom Post Type
function arachis_cpt_tickets() {
	$labels = array(
		'name'								=> _x( 'Tickets', 'Post Type General Name', 'arachis' ),
		'singular_name'				=> _x( 'Ticket', 'Post Type Singular Name', 'arachis' ),
		'menu_name'					=> __( 'Tickets', 'arachis' ),
		'parent_item_colon'			=> __( 'Parent Ticket:', 'arachis' ),
		'all_items'							=> __( 'All Tickets', 'arachis' ),
		'view_item'						=> __( 'View Ticket', 'arachis' ),
		'add_new_item'				=> __( 'Add New Ticket', 'arachis' ),
		'add_new'						=> __( 'New Ticket', 'arachis' ),
		'edit_item'						=> __( 'Edit Ticket', 'arachis' ),
		'update_item'					=> __( 'Update Ticket', 'arachis' ),
		'search_items'					=> __( 'Search Tickets', 'arachis' ),
		'not_found'						=> __( 'No Tickets found', 'arachis' ),
		'not_found_in_trash'		=> __( 'No Tickets found in Trash', 'arachis' ),
	);

	$args = array(
		'label'								=> __( 'ticket', 'arachis' ),
		'description'						=> __( 'Arachis tickets', 'arachis' ),
		'labels'								=> $labels,
		'supports'							=> array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', ),
		'hierarchical'					=> true,
		'public'								=> true,
		'show_ui'							=> true,
		'show_in_menu'				=> true,
		'show_in_nav_menus'		=> true,
		'show_in_admin_bar'		=> true,
		'menu_position'				=> 2.3,
		'menu_icon'						=> null,
		'can_export'						=> true,
		'has_archive'					=> false,
		'exclude_from_search'	=> false,
		'publicly_queryable'			=> true,
		'capability_type'				=> 'page',
	);

	register_post_type( 'ticket', $args );
}

// Hook into the 'init' action
add_action( 'init', 'arachis_cpt_tickets', 0 );

}

/* ===== Project Type taxonomy (project-type) ===== */
if ( ! function_exists('arachis_ctax_project_type') ) {

// Register Custom Taxonomy
function arachis_ctax_project_type()  {
	$labels = array(
		'name'											=> _x( 'Project Types', 'Taxonomy General Name', 'arachis' ),
		'singular_name'							=> _x( 'Project Type', 'Taxonomy Singular Name', 'arachis' ),
		'menu_name'								=> __( 'Project Types', 'arachis' ),
		'all_items'										=> __( 'All Project Types', 'arachis' ),
		'parent_item'								=> __( 'Parent Project Type', 'arachis' ),
		'parent_item_colon'						=> __( 'Parent Project Type:', 'arachis' ),
		'new_item_name'						=> __( 'New Project Type', 'arachis' ),
		'add_new_item'							=> __( 'Add New Project Type', 'arachis' ),
		'edit_item'									=> __( 'Edit Project Type', 'arachis' ),
		'update_item'								=> __( 'Update Project Type', 'arachis' ),
		'separate_items_with_commas'	=> __( 'Separate Project Types with commas', 'arachis' ),
		'search_items'								=> __( 'Search Project Types', 'arachis' ),
		'add_or_remove_items'				=> __( 'Add or remove Project Types', 'arachis' ),
		'choose_from_most_used'			=> __( 'Choose from the most used Project Types', 'arachis' ),
	);

	$args = array(
		'labels'											=> $labels,
		'hierarchical'								=> true,
		'public'											=> true,
		'show_ui'										=> true,
		'show_admin_column'					=> true,
		'show_in_nav_menus'					=> true,
		'show_tagcloud'							=> true,
	);

	register_taxonomy( 'project-type', 'project', $args );
}

// Hook into the 'init' action
add_action( 'init', 'arachis_ctax_project_type', 0 );

}

/* ===== Time (time) ===== */
if ( ! function_exists('arachis_cpt_time') ) {

// Register Custom Post Type
function arachis_cpt_time() {
	$labels = array(
		'name'								=> _x( 'Time', 'Post Type General Name', 'arachis' ),
		'singular_name'				=> _x( 'Time', 'Post Type Singular Name', 'arachis' ),
		'menu_name'					=> __( 'Time', 'arachis' ),
		'parent_item_colon'			=> __( 'Parent Time:', 'arachis' ),
		'all_items'							=> __( 'All Time', 'arachis' ),
		'view_item'						=> __( 'View Time', 'arachis' ),
		'add_new_item'				=> __( 'Add New Time', 'arachis' ),
		'add_new'						=> __( 'New Time', 'arachis' ),
		'edit_item'						=> __( 'Edit Time', 'arachis' ),
		'update_item'					=> __( 'Update Time', 'arachis' ),
		'search_items'					=> __( 'Search Time', 'arachis' ),
		'not_found'						=> __( 'No Time found', 'arachis' ),
		'not_found_in_trash'		=> __( 'No Time found in Trash', 'arachis' ),
	);

	$args = array(
		'label'								=> __( 'time', 'arachis' ),
		'description'						=> __( 'Arachis time', 'arachis' ),
		'labels'								=> $labels,
		'supports'							=> array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', ),
		'hierarchical'					=> true,
		'public'								=> true,
		'show_ui'							=> true,
		'show_in_menu'				=> true,
		'show_in_nav_menus'		=> true,
		'show_in_admin_bar'		=> true,
		'menu_position'				=> 2.4,
		'menu_icon'						=> null,
		'can_export'						=> true,
		'has_archive'					=> false,
		'exclude_from_search'	=> false,
		'publicly_queryable'			=> true,
		'capability_type'				=> 'post',
	);

	register_post_type( 'time', $args );
}

// Hook into the 'init' action
add_action( 'init', 'arachis_cpt_time', 0 );

}

?>