<div class="content-block-schema-accordion">
    <?php
        foreach($args['items'] as $key => $item) { ?>
        <div class="accordion-item <?php echo $args['expandfirst'] != 'false' && $key == 0 ? 'active' : ''; ?>">
            <div class="accordion-question">
                <span><?php echo $item['question']; ?></span>
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="icon icon-tabler icon-tabler-plus" viewBox="0 0 24 24"><path stroke="none" d="M0 0h24v24H0z"/><path d="M12 5v14M5 12h14"/></svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="icon icon-tabler icon-tabler-minus" viewBox="0 0 24 24"><path stroke="none" d="M0 0h24v24H0z"/><path d="M5 12h14"/></svg>
            </div>
            <div class="accordion-answer">
                <?php echo $item['answer']; ?>
            </div>
        </div>
    <?php } ?>
</div>

<?php
error_reporting(E_ALL);
error_reporting(-1);
ini_set('error_reporting', E_ALL);
    function printSchema($args) {
        if($args['renderschema'] == 'true') { ?>
        <script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "FAQPage",
                "mainEntity": [
                    <?php foreach($args['items'] as $key => $item) { ?>
                        {
                            "@type": "Question",
                            "name": "<?php echo $item['question']; ?>",
                            "acceptedAnswer": {
                                "@type": "Answer",
                                "text": "<p><?php echo $item['answer']; ?></p>"
                            }
                        } <?php echo $key + 1 == count($args['items']) ? '' : ','; ?>
                    <?php } ?>
                ]
            }
        </script>
    <?php } }
//printSchema($args);
add_action('wp_footer',
    function() use ( $args ) {
        printSchema( $args ); }
);
?>