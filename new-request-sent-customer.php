<?php
/**
 * Request New Quote email
 */
$order_obj = new WC_order( $order->order_id );
$display_price = false;
$opening_paragraph = __( 'Nueva cotizacion %s. El detalle de la cotizacion esta:', 'quote-wc' );
?>

<?php do_action( 'woocommerce_email_header', $email_heading ); ?>

<?php
if ( $order ) : ?>
	<p><?php printf( $opening_paragraph, $site_name ); ?></p>
<?php endif; ?>

<table cellspacing="0" cellpadding="6" style="width: 100%; border: 1px solid #eee;" border="1" bordercolor="#eee">
	<tbody>
		<tr>
			<th style="text-align:left; border: 1px solid #eee;"><?php _e( 'Producto', 'quote-wc' ); ?></th>
			<th style="text-align:left; border: 1px solid #eee;"><?php _e( 'Cantidad', 'quote-wc' ); ?></th>
			<?php 
			if ( qwc_order_display_price( $order_obj ) ) {
			    $display_price = true; 
            ?>
			<th style="text-align:left; border: 1px solid #eee;"><?php _e( 'Precio', 'quote-wc' ); ?></th>
			<?php } ?>
			
		</tr>
		<?php
		foreach( $order_obj->get_items() as $items ) {
		    ?>
		    <tr>
                <td style="text-align:left; border: 1px solid #eee;"><?php echo $items->get_name(); ?></td>
                <td style="text-align:left; border: 1px solid #eee;"><?php echo $items->get_quantity(); ?></td>
                <?php if( $display_price ) { ?>
                <td style="text-align:left; border: 1px solid #eee;"><?php echo $order_obj->get_formatted_line_subtotal( $items ); ?></td>
                <?php } ?>
            </tr>
            <?php 
		} 
		?>
	</tbody>
</table>

<p><?php _e( 'Esta orden quedo en espera,.', 'quote-wc' ); ?></p>

<p><?php _e( 'Pronto recibiras un email con la cotizacion. ', 'quote-wc' ); ?></p>

<?php do_action( 'woocommerce_email_footer' ); ?>
