<div class="btn-toolbar">
	<div class="btn-group">
	  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
	    <i class="icon-filter"></i> Filter
	    <span class="caret"></span>
	  </a>
	  <ul class="dropdown-menu">
	    <li><a href="?filter=cancelled">Cancelled</a></li>
	    <li><a href="?filter=completed">Completed</a></li>
	    <li><a href="?filter=failed">Failed</a></li>
	    <li><a href="?filter=on-hold">On Hold</a></li>
	    <li><a href="?filter=pending">Pending</a></li>
	    <li><a href="?filter=processing">Processing</a></li>
	    <li><a href="?filter=refunded">Refunded</a></li>
	    <li><a href="./">All Orders</a></li>
	  </ul>
	</div>
	
	<div class="btn-group">
	  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
	    <i class="icon-resize-vertical"></i> Sort
	    <span class="caret"></span>
	  </a>
	  <ul class="dropdown-menu">
	    <li><?php arachis_sort_by_link('date', __('By Date', 'arachis')); ?></li>
	    <li><?php arachis_sort_by_link('status', __('By Status', 'arachis')); ?></li>
	    <li><?php arachis_sort_by_link('total', __('By Total', 'arachis')); ?></li>
	  </ul>
	</div>

</div>

<?php
global $woocommerce;

$customer_id = get_current_user_id();

$main_args = array(
	'posts_per_page'	=> $recent_orders,
	'meta_key'			=> '_customer_user',
	'meta_value'		=> $customer_id,
	'post_type'			=> 'shop_order',
	'post_status'			=> 'publish'
);

$order_args = array();
$filter_args = array();

if ( $_REQUEST['filter'] ) :
	$filter_args = array(
		'tax_query' => array(
			array(
				'taxonomy'	=> 'shop_order_status',
				'field'			=> 'slug',
				'terms'			=> $_REQUEST['filter']
			)
		)
	);
endif;

$args = array_merge(
	$main_args,
	$order_args,
	$filter_args
);

/*
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
*/

$customer_orders = new WP_Query( $args );

if ( $customer_orders->have_posts() ) :
?>
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th><?php _e('Order', 'arachis'); ?></th>
				<th><?php _e('Date', 'arachis'); ?></th>
				<th><?php _e('Total Due', 'arachis'); ?></th>
				<th><? _e( 'Status', 'arachis' ); ?></th>
				<th></th>
			</tr>
		</thead>

		<tbody>
<?
	while ( $customer_orders->have_posts() ) : $customer_orders->the_post();
		$order = new WC_Order();
		$order->populate($post);
		$status = get_term_by('slug', $order->status, 'shop_order_status');
?>
				<tr class="order">
					<td width="1%">
						<a href="<?php echo esc_url( add_query_arg('order', $order->id, get_permalink(woocommerce_get_page_id('view_order'))) ); ?>"><?php echo $order->get_order_number(); ?></a>
					</td>
					<td>
						<time title="<?php echo esc_attr( strtotime($order->order_date) ); ?>"><?php echo date_i18n(get_option('date_format'), strtotime($order->order_date)); ?></time>
					</td>
					<td>
						<?php echo $order->get_formatted_order_total(); ?>
					</td>
					<td>
						<?= ucfirst( $order->status ); ?>
					</td>
					<td style="text-align:right;">

						<?php if (in_array($order->status, array('pending', 'failed'))) : ?>
							<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="btn btn-success"><i class="icon-shopping-cart icon-white"></i> <?php _e('Pay', 'arachis'); ?></a>
						<?php endif; ?>

						<a href="<?php echo esc_url( add_query_arg('order', $order->id, get_permalink(woocommerce_get_page_id('view_order'))) ); ?>" class="btn btn-info"><i class="icon-zoom-in icon-white"></i> <?php _e('View', 'arachis'); ?></a>
						
						<?php if (in_array($order->status, array('pending', 'failed'))) : ?>
							<a href="<?php echo esc_url( $order->get_cancel_order_url() ); ?>" class="btn btn-danger" title="<?php _e('Click to cancel this order', 'arachis'); ?>"><i class="icon-remove icon-white"></i> <?php _e('Cancel', 'arachis'); ?></a>
						<?php endif; ?>
					</td>
				</tr>
<?
	endwhile;
?>
		</tbody>
	</table>
<?php
else :
?>
	<p><?php _e('No orders found.', 'arachis'); ?></p>
<?php
endif;
?>