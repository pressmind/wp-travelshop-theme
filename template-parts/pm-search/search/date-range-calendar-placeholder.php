<?php
/**
 * @var $CalendarObject array
 */
?>

<div class="daterange-calendar-items">
    <div class="daterange-calendar-items-inner">
        <?php
        if ( !empty($CalendarObject) ) {
            $Year = $CalendarObject[0];
            $IterateItems = 0;
            foreach ( $Year as $Month ) {
                if ( $IterateItems < 100 ) {
                    ?>
                    <div class="calendar-item calendar-item-placeholder">

                        <div class="calendar-item-month">
                            &nbsp;
                        </div>

                        <div class="calendar-item-days calendar-item-days-header">
                            <?php foreach ( $Month['daysHeader'] as $DayHeader ) { ?>
                                <div class="day-item">
                                    &nbsp;
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
                                    $DayClassName .= ' day-item-active';
                                }

                                if ( $Day['rangeStart']  ) {
                                    $DayClassName .= ' day-item-active day-item-start';
                                }

                                if ( $Day['rangeEnd']  ) {
                                    $DayClassName .= ' day-item-active day-item-end';
                                }
                                ?>
                                <div class="day-item <?php echo $DayClassName; ?>">
                                    <div class="day-item-inner">
                                        &nbsp;
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                    </div>
                    <?php
                }
                $IterateItems++;
            }
        }
        ?>
    </div>
</div>