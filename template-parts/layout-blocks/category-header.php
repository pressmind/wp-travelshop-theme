<?php
/**
 * <code>
 *  $args = [
 *  'uid' => '',
 *  'background_overlay_gradient' => '',
 *  'content_box_type' => '',
 *  'content_box_break' => '',
 *  'content_alignment_horizontal' => '',
 *  'media_type' => '',
 *  'headline' => '',
 *  'background_overlay_type' => '',
 *  'background_overlay_color' => ''
 * ]
 * </code>
 * @var $args
 */

?>
<div class="category-header category-header-<?php echo $args['uid']; ?> category-header-<?php echo $args['content_box_type']; ?> <?php if ($args['content_box_type'] == 'boxed') { ?>category-header-<?php echo $args['content_box_break'];
} ?> <?php if ($args['content_box_type'] == 'docked') { ?> category-header-docked-<?php echo $args['content_alignment_horizontal']; ?> <?php } ?>">
    <?php
    // Media handling
    $video = empty($args['video']) && $args['media_type'] == 'video' ? SITE_URL . "/placeholder.svg?wh=1200x800&text=image is not set" : wp_get_attachment_url($args['video']);
    $image = empty($args['image']) && $args['media_type'] == 'image' ? SITE_URL . "/placeholder.svg?wh=1200x800&text=image is not set" : wp_get_attachment_image_url($args['image'], 'bigslide');
    ?>
    <div class="category-header-media category-header-media-<?php echo $args['media_type']; ?>">
        <div class="category-header-media-holder">
                <?php if ($args['media_type'] == 'image') { ?>
                    <div class="media-image">
                        <img src="<?php echo $image; ?>" alt="<?php echo $args['headline']; ?>"/>
                    </div>
                <?php } else { ?>
                    <div class="media-video">
                        <video autoplay muted loop style="pointer-events: none;">
                            <source src="<?php echo $video; ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                <?php } ?>
        </div>
        <?php
        // Overlay handling
        if ($args['background_overlay_type'] !== 'none') {
            $overlay_style = '';
            if ($args['background_overlay_type'] == 'color') {
                if (!empty($args['background_overlay_color'])) {
                    if (strlen($args['background_overlay_color']) < 8) {
                        $overlay_style = 'style="background-color: #' . $args['background_overlay_color'] . ';"';
                    } else {
                        $overlay_style = 'style="background-color: ' . $args['background_overlay_color'] . ';"';
                    }
                } else {
                    $overlay_style = 'style="background-color: rgba(0,0,0,.25);"';
                }
            }
            ?>
            <div class="category-header-overlay category-header-overlay-<?php echo $args['background_overlay_type']; ?>" <?php echo $overlay_style; ?>>
            </div>
        <?php } ?>
    </div>
    <?php
    // Content
    if (!empty($args['headline'])) {
    ?>
    <div class="category-header-content-wrapper">

        <div class="container-fluid">
            <div class="category-header-content-positioning content-header-vertical-<?php echo $args['content_alignment_vertical']; ?>
                content-header-vertical-medium-<?php echo $args['content_alignment_vertical_medium']; ?>
                content-header-vertical-small-<?php echo $args['content_alignment_vertical_responsive']; ?>
                content-header-horizontal-<?php echo $args['content_alignment_horizontal']; ?>
                content-header-horizontal-medium-<?php echo $args['content_alignment_horizontal_medium']; ?>
                content-header-horizontal-small-<?php echo $args['content_alignment_horizontal_responsive']; ?>">
                <article class="category-header-content <?php echo $args['content_box_text_align']; ?> category-header-content-<?php echo $args['content_box_type']; ?> <?php if (($args['content_box_type'] == 'boxed' || $args['content_box_type'] == 'docked') && (!empty($args['content_box_background']))) { ?> category-header-content-<?php echo $args['content_box_background']; ?><?php } ?>">
                    <<?php echo $args['headline_type']; ?> class="category-header-title" ><?php echo $args['headline']; ?></<?php echo $args['headline_type']; ?>>
                    <?php if (!empty($args['subline'])) { ?>
                        <<?php echo $args['subline_type']; ?> class="category-header-subline" ><?php echo $args['subline']; ?></<?php echo $args['subline_type']; ?>>
                    <?php } ?>
                <?php if (!empty($args['text'])) { ?>
                    <div class="category-header-text">
                        <?php echo $args['text']; ?>
                    </div>
            <?php } ?>
            </article>
        </div>
    </div>
</div>
<?php } ?>
</div>