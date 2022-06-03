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
                    id_media_object: <?php echo $args['id']; ?>,
                    code: <?php echo $args['code']; ?>,
                    name: '<?php echo $args['name']; ?>',
                    destination: '<?php echo $args['destination']; ?>',
                    travel_type: '<?php echo $args['category']; ?>',
                    price: '<?php echo $args['price']; ?>',
                }
            ]
        }
        });
    }
</script>