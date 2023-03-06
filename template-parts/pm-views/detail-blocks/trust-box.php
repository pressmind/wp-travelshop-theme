<?php
/**
 * This is only pseudo code! do not use in production!
 * <code>
 * $args['name']
 * </code>
 * @var array $args
 */

$terms = ['oft', 'einige Male', 'regelmäßig', 'von Stammkunden oft'];
$str = rand(10, 30) < 15 ? $terms[array_rand($terms, 1)] : rand(100, 362).'&nbsp;Mal';
$user_count = rand(0, rand(5, 24));

$user_str = $user_count.' weitere Nutzer online.';
if($user_count == 1){
    $user_str = 'Ein weiterer Nutzer online.';
}
?>
<div class="detail-box detail-box-trust">
    <div class="detail-box-body">
        <div class="trust-wrapper">
            <div class="trust-smiley">
                <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#smiley"></use></svg>
            </div>

            <div class="trust-content">
                <strong>Diese Reise interessiert viele Leute</strong>
                <p>Die Reise <?php echo !empty($args['name']) ? '"'.$args['name'].'"' : ''; ?> wurde in den letzten Monaten <?php echo $str; ?> gebucht.</p>
            </div>


            <?php if($user_count > 0){ ?>
                <div class="trust-footer">
                    <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#eye"></use></svg>

                    <?php echo $user_str; ?>
                </div>
            <?php } ?>
        </div>
    </div>

</div>