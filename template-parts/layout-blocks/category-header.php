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

if ( !function_exists('get_horizontal_direction') ) {
    function get_horizontal_direction($direction) {
        $directionType = '';

        if ( $direction = 'center' ) {
            $directionType = 'center';
        }

        if ( $direction = 'left' ) {
            $directionType = 'start';
        }

        if ( $direction = 'right' ) {
            $directionType = 'end';
        }
        return $directionType;
    }
}

if ( !function_exists('get_vertical_direction') ) {
    function get_vertical_direction($direction) {
        $directionType = '';

        if ( $direction = 'middle' ) {
            $directionType = 'center';
        }

        if ( $direction = 'top' ) {
            $directionType = 'start';
        }

        if ( $direction = 'bottom' ) {
            $directionType = 'end';
        }
        return $directionType;
    }
}
?>
<div class="content-block content-block-category-header">

    <div class="category-header category-header-<?php echo $args['uid']; ?> category-header-<?php echo $args['content_box_type']; ?> <?php if ($args['content_box_type'] == 'boxed') { ?>category-header-<?php echo $args['content_box_break'];
    } ?> <?php if ($args['content_box_type'] == 'docked') { ?> category-header-docked-<?php echo $args['content_alignment_horizontal']; ?> <?php } ?>">
        <?php
        // Media handling
        $video = empty($args['video']) && $args['media_type'] == 'video' ? SITE_URL . "/placeholder.svg?wh=1200x800&text=image is not set" : wp_get_attachment_url($args['video']);
        $image = empty($args['image']) && $args['media_type'] == 'image' ? SITE_URL . "/placeholder.svg?wh=1200x800&text=image is not set" : wp_get_attachment_image_url($args['image'], 'bigslide');
        ?>
        <div class="category-header-media category-header-media-<?php echo $args['media_type']; ?>">
            <?php if ($args['media_type'] == 'image') { ?>
                <div class="media media-cover">
                    <img src="<?php echo $image; ?>" alt="<?php echo $args['headline']; ?>"/>
                </div>
            <?php } else { ?>
                <div class="media media-video media-cover">
                    <video autoplay muted loop style="pointer-events: none;">
                        <source src="<?php echo $video; ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            <?php } ?>
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

        // -- category header positioning
        $categoryHeaderPositioningClasses = '';
        $categoryHeaderContainerClass = 'category-header-content-container category-header-content-container-widths';

        if ( $args['content_box_type'] == 'docked' ) {
            $categoryHeaderContainerClass = 'category-header-content-container';

            // Horizontal _
            if ( !empty($args['content_alignment_horizontal'] ) ) {
                $categoryHeaderPositioningClasses .= ' justify-content-' . get_horizontal_direction($args['content_alignment_horizontal']);
            }


            // Vertial |
        }
        ?>
        <div class="category-header-content-wrapper">

            <div class="<?php echo $categoryHeaderContainerClass; ?>">
                <div class="d-flex">

                    <div class="category-header-content-positioning <?php echo $categoryHeaderPositioningClasses; ?>

                    content-header-vertical-<?php echo $args['content_alignment_vertical']; ?>
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
        </div>
        <?php } ?>
    </div>
</div>