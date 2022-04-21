<div class="list-filter-box list-filter-box-checkboxes list-filter-box-sorting">
    <div class="list-filter-box-title">
        <strong>Sortieren nach</strong>
    </div>

    <div class="list-filter-box-body">
        <select class="form-control mb-0" name="pm-o">
            <option value="">bestes Ergebnis</option>
            <option data-view="Calendar1" value="date_departure-asc"<?php echo (!empty($_GET['pm-o']) && $_GET['pm-o'] == 'date_departure-asc') ? ' selected' : '';?>>früheste Abreise</option>
            <option value="date_departure-desc"<?php echo (!empty($_GET['pm-o']) && $_GET['pm-o'] == 'date_departure-desc') ? ' selected' : '';?>>späteste Abreise</option>
            <option value="price-asc"<?php echo (!empty($_GET['pm-o']) && $_GET['pm-o'] == 'price-asc') ? ' selected' : '';?>>niedrigster Preis</option>
            <option value="price-desc"<?php echo (!empty($_GET['pm-o']) && $_GET['pm-o'] == 'price-desc') ? ' selected' : '';?>>höchster Preis</option>
        </select>
    </div>

</div>