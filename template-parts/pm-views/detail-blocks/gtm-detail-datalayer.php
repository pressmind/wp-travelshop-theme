<?php 
use Pressmind\Travelshop\Template;
/**
 * @var array $args
 */

?>
<script>
    if(typeof dataLayer != 'undefined') {
        dataLayer.push({ ecommerce: null }); // Clear the previous ecommerce object.
        dataLayer.push({
            event: "travelshop.detail-view",
            ecommerce: {
            items: [
                {
                    id_media_object: <?php echo $args['id_media_object']; ?>,
                    code: '<?php echo !empty($args['code']) ? $args['code'] : ''; ?>',
                    name: '<?php echo !empty($args['name']) ? $args['name'] : '';?>',
                    destination: '<?php echo !empty($args['destination']) ? $args['destination'] : ''; ?>',
                    travel_type: '<?php echo !empty($args['category']) ? $args['category'] : ''; ?>',
                    price: <?php echo !empty($args['cheapest_price']->price_total) ? $args['cheapest_price']->price_total : null; ?>,
                }
            ]
        }
        });
    }
</script>