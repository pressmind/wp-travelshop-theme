<?php

if ( ! FLBuilderModel::is_builder_active() ) {
    return;
}

$db = \Pressmind\Registry::getInstance()->get('db');
$config = \Pressmind\Registry::getInstance()->get('config');


/**
 * beaverbuilder settings
 * @var $settings
 */

// get all categories group by id objec type for later purposes
$r = $db->fetchAll('select distinct var_name, ti.id_tree as id, ct.name, id_object_type from pmt2core_media_object_tree_items ti
                            left join pmt2core_media_objects mo on(mo.id = ti.id_media_object)
                            left join pmt2core_category_trees ct on (ct.id = ti.id_tree)
                            order by ct.name asc');

$category_map = [];
foreach ($r as $category){
    $category_map[$category->var_name] = $category;
}
$categories = [];
foreach($config['data']['search_mongodb']['search']['categories'] as $id_ot => $item){
    foreach($item as $var_name => $category){
        if(empty($category_map[$var_name]->id)){
            continue;
        }
        $id_tree = $category_map[$var_name]->id;
        $id_object_type = $category_map[$var_name]->id_object_type;
        $fieldname = 'category_'.$id_object_type.'_'.$id_tree.'-'.$var_name;
        $categories[$id_ot][] = [
            'fieldname' => $fieldname,
            'var_name' => $var_name
        ];
    }
}
?>
    <div id="fl-builder-settings-section-general" class="fl-builder-settings-section">
        <div class="fl-builder-settings-section-header">
            <button class="fl-builder-settings-title">
                <svg class="fl-symbol">
                    <use xlink:href="#fl-down-caret"></use>
                </svg>
                Type
            </button>
        </div>
        <div class="fl-builder-settings-section-content">
            <table class="fl-form-table">
                <?php
                // get all possible view files and group by object_type
                $view_options =  [];
                $script_path = str_replace('APPLICATION_PATH', APPLICATION_PATH, $config['view_scripts']['base_path']);
                foreach(glob($script_path.'/*.php') as $file){
                    $basename = basename($file, '.php');
                    if($r = preg_match('/^Teaser([0-9]+)$/', $basename, $matches) !== 1 ){
                        continue;
                    }
                    $view_options[$basename] = $basename;
                }

                $toggle = [];
                // toggle media object type specific category fields
                foreach($categories as $id_ot => $item){
                    foreach($item as $category){
                        $toggle[$id_ot]['fields'][] = $category['fieldname'];
                    }
                }

                FLBuilder::render_settings_field('pm-ot', array(
                    'type' => 'select',
                    'label' => 'Object Type',
                    'default' => !empty($config['data']['primary_media_type_ids'][0]) ? $config['data']['primary_media_type_ids'][0] : array_key_first($config['data']['media_types']) ,
                    'options' => $config['data']['media_types'],
                    'toggle' => $toggle
                ), $settings);

                FLBuilder::render_settings_field('view', array(
                    'type' => 'select',
                    'label' => 'View',
                    'default' => 'Teaser1',
                    'options' => $view_options,
                ), $settings);
                ?>
            </table>
        </div>
    </div>

    <div id="fl-builder-settings-section-pagination" class="fl-builder-settings-section fl-builder-settings-section-collapsed">
        <div class="fl-builder-settings-section-header">
            <button class="fl-builder-settings-title">
                <svg class="fl-symbol">
                    <use xlink:href="#fl-down-caret"></use>
                </svg>
                Pagination
            </button>
        </div>
        <div class="fl-builder-settings-section-content">
            <table class="fl-form-table">
                <?php
                // Limit
                FLBuilder::render_settings_field('items_per_page', array(
                    'type' => 'unit',
                    'label' => 'Items per page',
                    'default' => '4',
                    'placeholder' => '4',
                    'sanitize' => 'absint',
                    'slider' => array(
                        'min' => 1,
                        'max' => 100,
                        'step' => 1,
                    ),
                ), $settings);

                // Offset
                FLBuilder::render_settings_field('page', array(
                    'type' => 'unit',
                    'label' => 'Page',
                    'default' => '0',
                    'placeholder' => '0',
                    'sanitize' => 'absint',
                    'slider' => array(
                        'min' => 0,
                        'max' => 100,
                        'step' => 2,
                    ),
                ), $settings);
                ?>
            </table>
        </div>
    </div>
    <div id="fl-builder-settings-section-order" class="fl-builder-settings-section fl-builder-settings-section-collapsed">
        <div class="fl-builder-settings-section-header">
            <button class="fl-builder-settings-title">
                <svg class="fl-symbol">
                    <use xlink:href="#fl-down-caret"></use>
                </svg>
                Order
            </button>
        </div>
        <div class="fl-builder-settings-section-content">
            <table class="fl-form-table">
                <?php
                // Order
                FLBuilder::render_settings_field('order', array(
                    'type' => 'select',
                    'label' => __('Order', 'fl-builder'),
                    'options' => array(
                        'desc' => __('Descending', 'fl-builder'),
                        'asc' => __('Ascending', 'fl-builder'),
                    ),
                ), $settings);

                // Order By
                FLBuilder::render_settings_field('order_by', array(
                    'type' => 'select',
                    'label' => __('Order', 'fl-builder'),
                    'options' => array(
                        '' => '-',
                        'price' => 'price',
                        'date_departure' => 'date_departure',
                        'code' => 'code',
                        'rand' => 'random',
                    ),
                ), $settings);
                ?>
            </table>
        </div>
    </div>
    <div id="fl-builder-settings-section-basic" class="fl-builder-settings-section fl-builder-settings-section-collapsed">
        <div class="fl-builder-settings-section-header">
            <button class="fl-builder-settings-title">
                <svg class="fl-symbol">
                    <use xlink:href="#fl-down-caret"></use>
                </svg>
                Basis filter
            </button>
        </div>
        <div class="fl-builder-settings-section-content">
            <table class="fl-form-table">
                <?php


                FLBuilder::render_settings_field('pm-t', array(
                    'type' => 'text',
                    'label' => 'Keyword',
                    'default' => '',
                ), $settings);

                FLBuilder::render_settings_field('pm-id', array(
                    'type' => 'text',
                    'label' => 'ID media object',
                    'placeholder' => '12345,12346',
                    'default' => '',
                ), $settings);


                ?>
            </table>
        </div>
    </div>
    <div id="fl-builder-settings-section-states" class="fl-builder-settings-section fl-builder-settings-section-collapsed">
        <div class="fl-builder-settings-section-header">
            <button class="fl-builder-settings-title">
                <svg class="fl-symbol">
                    <use xlink:href="#fl-down-caret"></use>
                </svg>
                Dates, Durations & Prices
            </button>
        </div>
        <div class="fl-builder-settings-section-content">
            <table class="fl-form-table">
                <?php
                FLBuilder::render_settings_field('pm-du', array(
                    'type' => 'text',
                    'label' => 'Duration range',
                    'placeholder' => '3-5',
                    'default' => '',
                ), $settings);

                FLBuilder::render_settings_field('pm-dr', array(
                    'type' => 'text',
                    'label' => 'Date range',
                    'placeholder' => 'YYYYMMDD-YYYYMMDD or OFFSET-OFFSET',
                    'help' => 'Example 1 fixed range: "20221224-20221231" | Example 2 relative range: "30-90" (means show departures in 30 days for the next 60 days)',
                    'default' => '',
                ), $settings);

                FLBuilder::render_settings_field('pm-pr', array(
                    'type' => 'text',
                    'label' => 'Price range',
                    'placeholder' => '100-400',
                    'default' => '',
                ), $settings);

                FLBuilder::render_settings_field('pm-vr', array(
                    'type' => 'text',
                    'label' => 'Valid from/to range',
                    'placeholder' => 'YYYYMMDD-YYYYMMDD',
                    'default' => '',
                ), $settings);
                ?>
            </table>
        </div>
    </div>
    <!-- this id is used to identify the section for toggling fl-builder-settings-section-SECTIONID -->
    <div id="fl-builder-settings-section-categories" class="fl-builder-settings-section fl-builder-settings-section-collapsed____">
        <div class="fl-builder-settings-section-header">
            <button class="fl-builder-settings-title">
                <svg class="fl-symbol">
                    <use xlink:href="#fl-down-caret"></use>
                </svg>
                Categories
            </button>
        </div>
        <div class="fl-builder-settings-section-content">
            <table class="fl-form-table">
                <?php
                foreach($categories as $id_ot => $item){
                    foreach($item as $category){
                        FLBuilder::render_settings_field($category['fieldname'], array(
                            'type' => 'suggest',
                            'action' => $category['fieldname'],
                            'data' => 'categorytree',
                            'label' => $category['var_name'],
                            'help' => 'Type "search_behavior-AND" or "search_behavior-OR" to decide between AND- or OR-Search (all items are chained with OR or AND). If  not set, "search_behavior-OR" is used as default',
                            'matching' => false,
                            'limit' => 10
                        ), $settings);
                    }
                }
                ?>
            </table>
        </div>
    </div>
