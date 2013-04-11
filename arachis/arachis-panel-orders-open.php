<?php
global $woocommerce;

$customer_id = get_current_user_id();

$args = array(
    'numberposts'     => $recent_orders,
    'meta_key'        => '_customer_user',
    'meta_value'	  => $customer_id,
    'post_type'       => 'shop_order',
    'post_status'     => 'publish'
);
$customer_orders = get_posts($args);

if ($customer_orders) :
?>
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th><?php _e('Order', 'arachis'); ?></th>
				<th><?php _e('Date', 'arachis'); ?></th>
				<th><?php _e('Total Due', 'arachis'); ?></th>
				<th></th>
			</tr>
		</thead>

		<tbody><?php
			foreach ($customer_orders as $customer_order) :
				$order = new WC_Order();

				$order->populate( $customer_order );

				$status = get_term_by('slug', $order->status, 'shop_order_status');
				if ( $order->status != 'pending' ) continue;
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
		<?php
			endforeach;
		?>
		</tbody>
	</table>
<?php
else :
?>
	<p><?php _e('You have no recent orders.', 'arachis'); ?></p>
<?php
endif;
?>
