<?php
/**
 * <code>
 *  $args = (
 *          [headline] => Reise-Empfehlungen
 *          [text] => Travel is the movement of people between relatively distant geographical locations, and can involve travel by foot, bicycle, automobile, train, boat, bus, airplane, or other means, with or without luggage, and can be one way or round trip.
 *      )
 * </code>
 * @var array $args
 */

use Pressmind\Search\CheapestPrice;
use Pressmind\HelperFunctions;
use Pressmind\Travelshop\PriceHandler;
use Pressmind\Travelshop\Calendar;
use Pressmind\Travelshop\Template;

// get the calendar items
$items = Calendar::get();

// abort if nothing to display
if (count($items) == 0) {
    return;
}

?>
<div class="calendar-result">
</div>
<section class="content-block">
    <div class="row">
        <?php if (!empty($args['headline']) || !empty($args['text'])) { ?>
            <div class="col-12">
                <?php if (!empty($args['headline'])) { ?>
                    <h2 class="mt-0">
                        <?php echo $args['headline']; ?>
                    </h2>
                <?php } ?>
                <?php if (!empty($args['text'])) { ?>
                    <p>
                        <?php echo $args['text']; ?>
                    </p>
                <?php } ?>
            </div>
        <?php } ?>

        <div class="col-12">
            <div class="product-calendar-wrap">
                <?php
                // group items by month & year
                $itemsGroupedByMonth = [];
                $itemsCount = count($items);
                !isset($_GET['pm-l']) ? $_GET['pm-l'] = '1,14' : '';
                $pageStats = explode(',', $_GET['pm-l']);
                $sliceStart = ceil($itemsCount / $pageStats[1]) * ( $pageStats[0] - 1 );
                $totalPages = ceil($itemsCount / $pageStats[1]);
                $sliceEnd = $sliceStart + $pageStats[1];
                foreach (array_slice($items, $sliceStart, $sliceEnd) as $item) {
                    $item->date_departure = new DateTime($item->date_departure);
                    $itemsGroupedByMonth[$item->date_departure->format('m.Y')][] = $item;
                }

                // use grouped array to render items
                $month_count = 1;
                foreach ($itemsGroupedByMonth as $items) { ?>
                    <div class="product-calendar-group">

                        <div class="product-calendar-group-title">
                            <h3><?php
                                echo Template::render(APPLICATION_PATH . '/template-parts/micro-templates/month-name.php', [
                                    'date' => $items[0]->date_departure]);
                                ?>
                            </h3>
                        </div>

                        <div class="product-calendar-group--items">
                            <div class="product-calendar-items-title d-none d-md-block">
                                <div class="row">
                                    <div class="col-3">Reisezeitraum</div>
                                    <div class="col-4">Reise</div>
                                    <div class="col-2">Dauer</div>
                                    <div class="col-3 md-align-right">Preis</div>
                                </div>
                            </div>
                            <?php
                            $date_count = 1;
                            foreach ($items as $item) {
                                $mo = new \Pressmind\ORM\Object\MediaObject($item->id);
                                $CheapestPriceFilter = new CheapestPrice();
                                $CheapestPriceFilter->date_from = $CheapestPriceFilter->date_to = $item->date_departure;
                                $cheapest_price = $mo->getCheapestPrice($CheapestPriceFilter);
                            ?>
                                <div class="product-calendar-group-item " data-row-id="<?php echo $month_count . "-" . $date_count; ?>" data-pm-id="<?php echo $item->id; ?>" data-pm-dr="<?php echo $CheapestPriceFilter->date_from->format("Ymd") . '-' . $CheapestPriceFilter->date_to->format("Ymd"); ?>">
                                  <div class="row">
                                      <div class="col-12 col-md-3">
                                          <div class="arrow--wrapper">
                                              <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/phosphor-sprite.svg#caret-down"></use></svg>

                                              <i class="circle green"></i>
                                              <?php
                                              if(!empty($cheapest_price)) {
                                                  echo Template::render(APPLICATION_PATH . '/template-parts/micro-templates/travel-date-range.php', [
                                                      'date_departure' => $cheapest_price->date_departure,
                                                      'date_arrival' => $cheapest_price->date_arrival
                                                  ]);
                                              }
                                              ?>
                                          </div>
                                      </div>
                                      <div class="col-12 col-md-4">
                                          <strong><?php echo $item->name; ?></strong>
                                      </div>
                                      <div class="col-6 col-md-2">
                                          <?php echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/duration.php', ['duration' => $cheapest_price->duration]);?>
                                      </div>
                                      <div class="col-6 col-md-3 md-align-right">
                                        <span class="price">
                                            <?php
                                            if (!empty($cheapest_price) && ($discount = PriceHandler::getDiscount($cheapest_price)) !== false) {
                                                echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/discount.php', [
                                                    'cheapest_price' => $cheapest_price,
                                                    'discount' => $discount,
                                                    'hide-price-total' => true,
                                                    'hide-discount-valid-to' => true,
                                                ]);
                                            }
                                            if (empty($cheapest_price->price_total) === false) {
                                                echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/price-1.php', [
                                                    'cheapest_price' => $cheapest_price,
                                                ]);
                                            }
                                            ?>
                                        </span>
                                      </div>
                                  </div>
                                </div>

                                <div class="product-calendar-group-item-product">
                                    <div class="row product-calendar-group-item--product" data-row-id="<?php echo $month_count . "-" . $date_count; ?>">
                                        <?php // this section will get the content by ajax; (pm-view/Teaser*), see ajax.js:initCalendarRowClick();
                                        ?>
                                    </div>
                                </div>
                            <?php
                                $date_count++;
                            } // each date
                            ?>
                        </div>
                    </div>
                <?php
                    $month_count++;
                } // each month
                ?>
            </div>
            <?php
            echo Template::render(APPLICATION_PATH.'/template-parts/pm-search/result-pagination.php', [
            'current_page' => $pageStats[0],
            'page_size' => $pageStats[1],
            'pages' => $totalPages,
            'total_result' => $itemsCount
            ]); ?>
        </div>
    </div>
</section>
