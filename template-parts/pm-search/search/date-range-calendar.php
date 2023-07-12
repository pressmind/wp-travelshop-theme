<?php
/**
 * @var $CalendarObject array
 */
?>

<div class="daterange-calendar-items">
    <div class="daterange-calendar-items-inner">
        <?php
        if ( !empty($CalendarObject) ) {
            foreach ( $CalendarObject as $Year ) {
                foreach ( $Year as $Month ) {
                    ?>
                    <div class="calendar-item">

                        <div class="calendar-item-month">
                            <?php echo $Month['title']; ?>
                        </div>

                        <div class="calendar-item-days calendar-item-days-header">
                            <?php foreach ( $Month['daysHeader'] as $DayHeader ) { ?>
                                <div class="day-item">
                                    <?php echo $DayHeader; ?>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="calendar-item-days calendar-item-days-dates">
                            <?php

                            if ( (int) $Month['days'][0]['dayNumber'] > 1 ) {
                                $BlanksBefore = range(1, (int) $Month['days'][0]['dayNumber'] - 1);

                                foreach ($BlanksBefore as $Blank ) {
                                    ?>
                                    <div class="day-item day-item-blank"></div>
                                    <?php
                                }

                            }
                            ?>
                            <?php foreach ( $Month['days'] as $Day ) { ?>
                                <?php
                                $DayClassName = '';

                                if ( $Day['interactive'] ) {
                                    $DayClassName .= ' day-item-interactive';
                                }

                                if ( $Day['departure'] ) {
                                    $DayClassName .= ' day-item-departure';
                                }

                                if ( $Day['current'] ) {
                                    $DayClassName .= ' day-item-active day-item-current';
                                }

                                if ( $Day['rangeStart']  ) {
                                    $DayClassName .= ' day-item-active day-item-start';
                                }

                                if ( $Day['rangeEnd']  ) {
                                    $DayClassName .= ' day-item-active day-item-end';
                                }

                                if ( $Day['rangeBetween']  ) {
                                    $DayClassName .= ' day-item-between';
                                }
                                ?>
                                <div class="day-item <?php echo $DayClassName; ?>" data-type="<?php echo $Day['interactive'] ? 'date' : ''; ?>" data-date="<?php echo $Day['date']; ?>" data-date-numeric="<?php echo str_replace('-', '', $Day['date']); ?>">
                                    <div class="day-item-inner">
                                        <?php echo $Day['day']; ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                    </div>
                    <?php
                }
            }
        }
        ?>
    </div>

    <div class="slider-controls">
        <button class="prev" type="button" disabled>
            <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#caret-left-bold"></use></svg>
        </button>
        <button class="next" type="button">
            <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#caret-right-bold"></use></svg>
        </button>
    </div>

</div>