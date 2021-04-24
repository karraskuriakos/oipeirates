<?php
/**
 * My Orders
 *
 * Shows recent orders on the account page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function is_old_woo() {
	if ( version_compare( WC()->version, '2.2', '<' ) ) {
		return true;
	} else {
		return false;
	}
}



if ( is_old_woo() ) {
	$customer_orders = get_posts( apply_filters( 'woocommerce_my_account_my_orders_query', array(
		'numberposts' => $order_count,
		'meta_key'    => '_customer_user',
		'meta_value'  => get_current_user_id(),
		'post_type'   => 'shop_order',
		'post_status' => 'publish'
	) ) );

} else {

	$customer_orders = get_posts( apply_filters( 'woocommerce_my_account_my_orders_query', array(
		'numberposts' => $order_count,
		'meta_key'    => '_customer_user',
		'meta_value'  => get_current_user_id(),
		'post_type'   => wc_get_order_types( 'view-orders' ),
		'post_status' => array_keys( wc_get_order_statuses() )
	) ) );

}




if ( $customer_orders ) : ?>

	<h2><?php echo apply_filters( 'woocommerce_my_account_my_orders_title', __( 'Recent Orders', 'woocommerce' ) ); ?></h2>

	<ul id="recent_orders" class="my_account_orders">
		<?php
			foreach ( $customer_orders as $customer_order ) {
				if ( is_old_woo() ) {
					$order = new WC_Order();
				} else {
					$order = wc_get_order( $customer_order );
				}
				$order->populate( $customer_order );

				if ( is_old_woo() ) {
					$status     = get_term_by( 'slug', $order->status, 'shop_order_status' );
				}

				$item_count = $order->get_item_count();

				?>
				<li class="status-<?php echo $order->status; ?>">
					<div>
						<h3><a href="<?php echo $order->get_view_order_url(); ?>"><?php echo $order->get_order_number(); ?></a> <span class="order-status"><?php if ( is_old_woo() ) { echo ucfirst( __( $status->name, 'woocommerce' ) ); } else { echo ucfirst( wc_get_order_status_name( $order->get_status() ) ); } ?></span></h3>
						<time datetime="<?php echo date( 'Y-m-d', strtotime( $order->order_date ) ); ?>" title="<?php echo esc_attr( strtotime( $order->order_date ) ); ?>"><?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ); ?></time>
						<span class="order-total"><?php echo sprintf( _n( '%s for %s item', '%s for %s items', $item_count, 'woocommerce' ), $order->get_formatted_order_total(), $item_count ); ?></span>
					</div>
					<ul class="order-actions">
						<?php
							$actions = array();

							if ( in_array( $order->status, apply_filters( 'woocommerce_valid_order_statuses_for_payment', array( 'pending', 'failed' ), $order ) ) ) {
								$actions['pay'] = array(
									'url'  => $order->get_checkout_payment_url(),
									'name' => __( 'Pay', 'woocommerce' )
								);
							}

							if ( in_array( $order->status, apply_filters( 'woocommerce_valid_order_statuses_for_cancel', array( 'pending', 'failed' ), $order ) ) ) {
								$actions['cancel'] = array(
									'url'  => $order->get_cancel_order_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ),
									'name' => __( 'Cancel', 'woocommerce' )
								);
							}

							$actions['view'] = array(
								'url'  => $order->get_view_order_url(),
								'name' => __( 'View', 'woocommerce' )
							);

							$actions = apply_filters( 'woocommerce_my_account_my_orders_actions', $actions, $order );

							if ($actions) {
								foreach ( $actions as $key => $action ) {
									echo '<li><a href="' . esc_url( $action['url'] ) . '" class="button ' . sanitize_html_class( $key ) . '">' . esc_html( $action['name'] ) . '</a></li>';
								}
							}
						?>
					</ul>
				</li><?php
			}
		?>
	</ul>

<?php endif; ?>
