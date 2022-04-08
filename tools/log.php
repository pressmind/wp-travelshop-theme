<?php
/**
 * This is a sidy (si mple & di rty) log file helper
 *
 * It can be also used in monitored environments:
 * Simply add log.php?sensor=1 to your monitoring system an get the error count
 * (see loglevel in pm-config, otherwise it's possible to get info, warnings messages too)
 */

require_once '../bootstrap.php';
$db = \Pressmind\Registry::getInstance()->get('db');


$the_day = new DateTime();
if(!empty($_GET['offset'])){
    $offset = intval($_GET['offset']);
    $the_day->modify('-'.$offset.' day');
}

$sql = "SELECT * FROM pmt2core_logs ";
$sql .= " where category = 'custom_import_hook' and `date` BETWEEN '".$the_day->format('Y-m-d 00:00:00')."' AND '".$the_day->format('Y-m-d 23:59:59')."'";
$sql .= " group by text";
$sql .= " order by id desc";

$r = $db->fetchAll($sql);

if(!empty($_GET['sensor'])){
    echo count($r);
    exit;
}

define('WP_USE_THEMES', false);
require_once('../../../../wp/wp-load.php');

define('DONOTCACHE', true);

/*
if(!current_user_can('edit_pages')){
    echo 'Error: not logged in or user has not the required capability "edit_pages"<br>';
    echo '<a href="'.wp_login_url(site_url().'/wp-content/themes/travelshop/tools/log.php').'">Login WordPress</a>';
    exit;
}
*/


function makeClickableLinks($s)
{
    return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', $s);
}
?>
<!doctype html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>


    <script>
        function simpleTableSearch() {
            // Declare variables
            let input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("search");
            filter = input.value.toUpperCase();
            table = document.getElementById("logtable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                console.log(tr[i].parentElement.tagName);
                if(tr[i].parentElement.tagName != 'THEAD'){
                    td = tr[i].getElementsByTagName("td")[3];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().search(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }

            }
        }
    </script>
    <?php
    if(!empty($_GET['delete']) && $_GET['delete'] == 'log'){
        $sql = "delete FROM pmt2core_logs";
        $r = $db->fetchAll($sql);
        ?>
    <script>
        window.location.href = 'log.php';
    </script>
    <?php
    }

    ?>
</head>
<body>
<div class="container">

    <div class="row">
        <div class="col">
            <h1>Import Logfile</h1>
            <p><?php echo $the_day->format('d.m.Y').' 00:00:00 - 23:59:59'; ?></p>

            <a href="?offset=0">Heute</a> |
            <a href="?offset=1">Gestern</a> |
            <a href="?offset=2">Vorgestern</a> |
            <a href="?offset=3">vor 3 Tagen</a> |
            <a href="?offset=4">vor 4 Tagen</a> |
            <a href="?offset=5">vor 5 Tagen</a> |
            <a href="?offset=6">vor 6 Tagen</a> |
            <a href="?offset=7">vor 7 Tagen</a> |
            <a href="?delete=log" style="padding-left: 40px;">Delete Log</a>

            <table id="logtable" class="table table-hover">

                <thead class="thead-dark">
                <tr>
                    <td>id</td>
                    <td>date</td>
                    <td>type</td>
                    <td>
                        <div><input type="text" id="search" onkeyup="simpleTableSearch()" placeholder="Search"></div>

                    </td>
                    <td>category</td>
                    <td>trace</td>
                </tr>
                </thead>
                <?php
                foreach ($r as $item) {
                    ?>
                    <tr>
                        <td><?php echo $item->id; ?></td>
                        <td><?php echo $item->date; ?></td>
                        <td><?php
                            $class = 'bg-info';
                            if ($item->type == 'ERROR') {
                                $class = 'bg-danger';
                            }
                            ?>
                            <span class="badge <?php echo $class; ?>"><?php echo $item->type; ?></span>
                        </td>
                        <td><?php echo nl2br(makeClickableLinks($item->text)); ?></td>
                        <td><?php echo $item->category; ?></td>
                        <td><?php echo nl2br($item->trace); ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
    </div>
</div>
</body>
</html>