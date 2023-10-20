<?php

namespace Custom\MediaType;

use Pressmind\ORM\Object\MediaType\AbstractMediaType;
use Pressmind\ORM\Object\MediaObject\DataType;

/**
 * Class Reise
 * @property integer $id
 * @property integer $id_media_object
 * @property string $language
 * @property string $kuschick_code_default
 * @property DataType\Table[] $tabelle_default
 * @property DataType\Categorytree[] $reisedauer_default
 * @property DataType\Link[] $video_default
 * @property DataType\Objectlink[] $unterkunftverknuepfung_default
 * @property DataType\Picture[] $bilder_default
 * @property DataType\Picture[] $karte_default
 * @property string $title_default
 * @property string $hinweis_headline_default
 * @property string $tipp_headline_default
 * @property string $tipp_headline_print
 * @property string $reiseleiter_empfehlung_headline_default
 * @property string $headline_default
 * @property string $leistungen_headline_default
 * @property string $leistungen_extra_text_default
 * @property string $fruehbucherrabatt_default
 * @property string $leistungen_extra_headline_print_default
 * @property DataType\Categorytree[] $reisetyp_default
 * @property DataType\Categorytree[] $steuerung_unterkunft_print_default
 * @property DataType\Location[] $googlemaps_default
 * @property string $meta_description_default
 * @property string $tipp_subline_default
 * @property string $tipp_subline_print
 * @property string $subline_default
 * @property string $leistungen_default
 * @property string $reiseleiter_empfehlung_default
 * @property string $hinweis_text_default
 * @property string $leistungen_extra_text_print_default
 * @property DataType\Categorytree[] $fluss_default
 * @property DataType\Categorytree[] $steuerung_hinweis_print_default
 * @property DataType\Categorytree[] $steuerung_unterkunft_bild_print_default
 * @property string $meta_keywords_default
 * @property string $reiseleiter_name_default
 * @property DataType\Table[] $routentabelle_default
 * @property string $einleitung_default
 * @property string $leistungen_extra_pdf_1_text_default
 * @property string $tipp_text_default
 * @property string $tipp_text_print
 * @property DataType\Categorytree[] $rederei_default
 * @property DataType\Categorytree[] $steuerung_unterkunft_bildhoehe_print_default
 * @property DataType\File[] $leistungen_extra_pdf_1_default
 * @property DataType\Objectlink[] $textbaustein_default
 * @property DataType\Picture[] $reiseleiter_bild_default
 * @property DataType\Picture[] $logo_default
 * @property string $meta_robots_default
 * @property string $tipp_zusatz_default
 * @property string $tipp_zusatz_print
 * @property DataType\Categorytree[] $schiffsbezeichnungen_default
 * @property DataType\Categorytree[] $steuerung_reiseleiter_print_default
 * @property string $meta_revisit_default
 * @property string $tipp_2_headline_default
 * @property string $tipp_2_headline_print
 * @property string $hinweis_headline_www_default
 * @property string $reisehighlights_default
 * @property string $leistungen_extra_pdf_2_text_default
 * @property DataType\File[] $leistungen_extra_pdf_2_default
 * @property string $header_source_code_default
 * @property string $treueherzen_default
 * @property string $tipp_2_subline_default
 * @property string $tipp_2_subline_print
 * @property string $hinweis_headline_text_default
 * @property DataType\Categorytree[] $reiseart_default
 * @property DataType\Categorytree[] $steuerung_beschreibung_headline_und_bild_print_default
 * @property string $footer_source_code_default
 * @property string $tipp_2_text_default
 * @property string $tipp_2_text_print
 * @property string $hinweis_hochseekreuzfahrt_tabelle_default
 * @property DataType\Categorytree[] $saison_default
 * @property string $url_default
 * @property string $beschreibung_headline_default
 * @property string $tipp_2_zusatz_default
 * @property string $tipp_2_zusatz_print
 * @property DataType\Categorytree[] $zielgebiet_default
 * @property DataType\Objectlink[] $url_verknuepfung_default
 * @property string $beschreibung_text_default
 * @property DataType\Categorytree[] $hotelkategorie_default
 * @property DataType\Categorytree[] $verpflegungsart_default
 * @property DataType\Categorytree[] $verkaufsprioritaet_default
 * @property string $hinweise_pdf_1_text_default
 * @property DataType\Categorytree[] $optionen_default
 * @property DataType\File[] $hinweise_pdf_1_default
 * @property DataType\Categorytree[] $farbsteuerung_default
 * @property DataType\Categorytree[] $steuerung_termine_preise_print_default
 * @property string $freitextstoerer_oben_default
 * @property string $freitextstoerer_unten_default
 */
class Reise extends AbstractMediaType {
protected $_definitions = [
    'class' => [
        'name' => 'Reise',
    ],
    'database' => [
        'table_name' => 'objectdata_912',
        'primary_key' => 'id',
        'relation_key' => 'id_media_object',
    ],
    'properties' => [
        'id' => [
            'name' => 'id',
            'title' => 'id',
            'type' => 'integer',
            'required' => true,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'id_media_object' => [
            'name' => 'id_media_object',
            'title' => 'id_media_object',
            'type' => 'integer',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'index' => [
                'id_media_object' => 'index',
            ],
        ],
        'language' => [
            'name' => 'language',
            'title' => 'language',
            'type' => 'string',
            'required' => false,
            'validators' => [
                0 => [
                    'name' => 'maxlength',
                    'params' => 255,
                ],
            ],
            'filters' => NULL,
            'index' => [
                'language' => 'index',
            ],
        ],
        'kuschick_code_default' => [
            'name' => 'kuschick_code_default',
            'title' => 'kuschick_code_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'tabelle_default' => [
            'name' => 'tabelle_default',
            'title' => 'tabelle_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Table',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'tabelle_default',
                ],
            ],
        ],
        'reisedauer_default' => [
            'name' => 'reisedauer_default',
            'title' => 'reisedauer_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'reisedauer_default',
                ],
            ],
        ],
        'video_default' => [
            'name' => 'video_default',
            'title' => 'video_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Link',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'video_default',
                ],
            ],
        ],
        'unterkunftverknuepfung_default' => [
            'name' => 'unterkunftverknuepfung_default',
            'title' => 'unterkunftverknuepfung_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Objectlink',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'unterkunftverknuepfung_default',
                ],
            ],
        ],
        'bilder_default' => [
            'name' => 'bilder_default',
            'title' => 'bilder_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Picture',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'bilder_default',
                    'section_name' => 'IS NULL',
                ],
            ],
        ],
        'karte_default' => [
            'name' => 'karte_default',
            'title' => 'karte_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Picture',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'karte_default',
                    'section_name' => 'IS NULL',
                ],
            ],
        ],
        'title_default' => [
            'name' => 'title_default',
            'title' => 'title_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'hinweis_headline_default' => [
            'name' => 'hinweis_headline_default',
            'title' => 'hinweis_headline_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'tipp_headline_default' => [
            'name' => 'tipp_headline_default',
            'title' => 'tipp_headline_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'tipp_headline_print' => [
            'name' => 'tipp_headline_print',
            'title' => 'tipp_headline_print',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'reiseleiter_empfehlung_headline_default' => [
            'name' => 'reiseleiter_empfehlung_headline_default',
            'title' => 'reiseleiter_empfehlung_headline_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'headline_default' => [
            'name' => 'headline_default',
            'title' => 'headline_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'leistungen_headline_default' => [
            'name' => 'leistungen_headline_default',
            'title' => 'leistungen_headline_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'leistungen_extra_text_default' => [
            'name' => 'leistungen_extra_text_default',
            'title' => 'leistungen_extra_text_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'fruehbucherrabatt_default' => [
            'name' => 'fruehbucherrabatt_default',
            'title' => 'fruehbucherrabatt_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'leistungen_extra_headline_print_default' => [
            'name' => 'leistungen_extra_headline_print_default',
            'title' => 'leistungen_extra_headline_print_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'reisetyp_default' => [
            'name' => 'reisetyp_default',
            'title' => 'reisetyp_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'reisetyp_default',
                ],
            ],
        ],
        'steuerung_unterkunft_print_default' => [
            'name' => 'steuerung_unterkunft_print_default',
            'title' => 'steuerung_unterkunft_print_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'steuerung_unterkunft_print_default',
                ],
            ],
        ],
        'googlemaps_default' => [
            'name' => 'googlemaps_default',
            'title' => 'googlemaps_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Location',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'googlemaps_default',
                ],
            ],
        ],
        'meta_description_default' => [
            'name' => 'meta_description_default',
            'title' => 'meta_description_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'tipp_subline_default' => [
            'name' => 'tipp_subline_default',
            'title' => 'tipp_subline_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'tipp_subline_print' => [
            'name' => 'tipp_subline_print',
            'title' => 'tipp_subline_print',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'subline_default' => [
            'name' => 'subline_default',
            'title' => 'subline_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'leistungen_default' => [
            'name' => 'leistungen_default',
            'title' => 'leistungen_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'reiseleiter_empfehlung_default' => [
            'name' => 'reiseleiter_empfehlung_default',
            'title' => 'reiseleiter_empfehlung_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'hinweis_text_default' => [
            'name' => 'hinweis_text_default',
            'title' => 'hinweis_text_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'leistungen_extra_text_print_default' => [
            'name' => 'leistungen_extra_text_print_default',
            'title' => 'leistungen_extra_text_print_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'fluss_default' => [
            'name' => 'fluss_default',
            'title' => 'fluss_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'fluss_default',
                ],
            ],
        ],
        'steuerung_hinweis_print_default' => [
            'name' => 'steuerung_hinweis_print_default',
            'title' => 'steuerung_hinweis_print_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'steuerung_hinweis_print_default',
                ],
            ],
        ],
        'steuerung_unterkunft_bild_print_default' => [
            'name' => 'steuerung_unterkunft_bild_print_default',
            'title' => 'steuerung_unterkunft_bild_print_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'steuerung_unterkunft_bild_print_default',
                ],
            ],
        ],
        'meta_keywords_default' => [
            'name' => 'meta_keywords_default',
            'title' => 'meta_keywords_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'reiseleiter_name_default' => [
            'name' => 'reiseleiter_name_default',
            'title' => 'reiseleiter_name_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'routentabelle_default' => [
            'name' => 'routentabelle_default',
            'title' => 'routentabelle_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Table',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'routentabelle_default',
                ],
            ],
        ],
        'einleitung_default' => [
            'name' => 'einleitung_default',
            'title' => 'einleitung_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'leistungen_extra_pdf_1_text_default' => [
            'name' => 'leistungen_extra_pdf_1_text_default',
            'title' => 'leistungen_extra_pdf_1_text_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'tipp_text_default' => [
            'name' => 'tipp_text_default',
            'title' => 'tipp_text_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'tipp_text_print' => [
            'name' => 'tipp_text_print',
            'title' => 'tipp_text_print',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'rederei_default' => [
            'name' => 'rederei_default',
            'title' => 'rederei_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'rederei_default',
                ],
            ],
        ],
        'steuerung_unterkunft_bildhoehe_print_default' => [
            'name' => 'steuerung_unterkunft_bildhoehe_print_default',
            'title' => 'steuerung_unterkunft_bildhoehe_print_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'steuerung_unterkunft_bildhoehe_print_default',
                ],
            ],
        ],
        'leistungen_extra_pdf_1_default' => [
            'name' => 'leistungen_extra_pdf_1_default',
            'title' => 'leistungen_extra_pdf_1_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\File',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'leistungen_extra_pdf_1_default',
                ],
            ],
        ],
        'textbaustein_default' => [
            'name' => 'textbaustein_default',
            'title' => 'textbaustein_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Objectlink',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'textbaustein_default',
                ],
            ],
        ],
        'reiseleiter_bild_default' => [
            'name' => 'reiseleiter_bild_default',
            'title' => 'reiseleiter_bild_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Picture',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'reiseleiter_bild_default',
                    'section_name' => 'IS NULL',
                ],
            ],
        ],
        'logo_default' => [
            'name' => 'logo_default',
            'title' => 'logo_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Picture',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'logo_default',
                    'section_name' => 'IS NULL',
                ],
            ],
        ],
        'meta_robots_default' => [
            'name' => 'meta_robots_default',
            'title' => 'meta_robots_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'tipp_zusatz_default' => [
            'name' => 'tipp_zusatz_default',
            'title' => 'tipp_zusatz_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'tipp_zusatz_print' => [
            'name' => 'tipp_zusatz_print',
            'title' => 'tipp_zusatz_print',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'schiffsbezeichnungen_default' => [
            'name' => 'schiffsbezeichnungen_default',
            'title' => 'schiffsbezeichnungen_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'schiffsbezeichnungen_default',
                ],
            ],
        ],
        'steuerung_reiseleiter_print_default' => [
            'name' => 'steuerung_reiseleiter_print_default',
            'title' => 'steuerung_reiseleiter_print_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'steuerung_reiseleiter_print_default',
                ],
            ],
        ],
        'meta_revisit_default' => [
            'name' => 'meta_revisit_default',
            'title' => 'meta_revisit_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'tipp_2_headline_default' => [
            'name' => 'tipp_2_headline_default',
            'title' => 'tipp_2_headline_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'tipp_2_headline_print' => [
            'name' => 'tipp_2_headline_print',
            'title' => 'tipp_2_headline_print',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'hinweis_headline_www_default' => [
            'name' => 'hinweis_headline_www_default',
            'title' => 'hinweis_headline_www_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'reisehighlights_default' => [
            'name' => 'reisehighlights_default',
            'title' => 'reisehighlights_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'leistungen_extra_pdf_2_text_default' => [
            'name' => 'leistungen_extra_pdf_2_text_default',
            'title' => 'leistungen_extra_pdf_2_text_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'leistungen_extra_pdf_2_default' => [
            'name' => 'leistungen_extra_pdf_2_default',
            'title' => 'leistungen_extra_pdf_2_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\File',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'leistungen_extra_pdf_2_default',
                ],
            ],
        ],
        'header_source_code_default' => [
            'name' => 'header_source_code_default',
            'title' => 'header_source_code_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'treueherzen_default' => [
            'name' => 'treueherzen_default',
            'title' => 'treueherzen_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'tipp_2_subline_default' => [
            'name' => 'tipp_2_subline_default',
            'title' => 'tipp_2_subline_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'tipp_2_subline_print' => [
            'name' => 'tipp_2_subline_print',
            'title' => 'tipp_2_subline_print',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'hinweis_headline_text_default' => [
            'name' => 'hinweis_headline_text_default',
            'title' => 'hinweis_headline_text_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'reiseart_default' => [
            'name' => 'reiseart_default',
            'title' => 'reiseart_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'reiseart_default',
                ],
            ],
        ],
        'steuerung_beschreibung_headline_und_bild_print_default' => [
            'name' => 'steuerung_beschreibung_headline_und_bild_print_default',
            'title' => 'steuerung_beschreibung_headline_und_bild_print_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'steuerung_beschreibung_headline_und_bild_print_default',
                ],
            ],
        ],
        'footer_source_code_default' => [
            'name' => 'footer_source_code_default',
            'title' => 'footer_source_code_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'tipp_2_text_default' => [
            'name' => 'tipp_2_text_default',
            'title' => 'tipp_2_text_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'tipp_2_text_print' => [
            'name' => 'tipp_2_text_print',
            'title' => 'tipp_2_text_print',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'hinweis_hochseekreuzfahrt_tabelle_default' => [
            'name' => 'hinweis_hochseekreuzfahrt_tabelle_default',
            'title' => 'hinweis_hochseekreuzfahrt_tabelle_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'saison_default' => [
            'name' => 'saison_default',
            'title' => 'saison_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'saison_default',
                ],
            ],
        ],
        'url_default' => [
            'name' => 'url_default',
            'title' => 'url_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'beschreibung_headline_default' => [
            'name' => 'beschreibung_headline_default',
            'title' => 'beschreibung_headline_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'tipp_2_zusatz_default' => [
            'name' => 'tipp_2_zusatz_default',
            'title' => 'tipp_2_zusatz_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'tipp_2_zusatz_print' => [
            'name' => 'tipp_2_zusatz_print',
            'title' => 'tipp_2_zusatz_print',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'zielgebiet_default' => [
            'name' => 'zielgebiet_default',
            'title' => 'zielgebiet_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'zielgebiet_default',
                ],
            ],
        ],
        'url_verknuepfung_default' => [
            'name' => 'url_verknuepfung_default',
            'title' => 'url_verknuepfung_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Objectlink',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'url_verknuepfung_default',
                ],
            ],
        ],
        'beschreibung_text_default' => [
            'name' => 'beschreibung_text_default',
            'title' => 'beschreibung_text_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'hotelkategorie_default' => [
            'name' => 'hotelkategorie_default',
            'title' => 'hotelkategorie_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'hotelkategorie_default',
                ],
            ],
        ],
        'verpflegungsart_default' => [
            'name' => 'verpflegungsart_default',
            'title' => 'verpflegungsart_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'verpflegungsart_default',
                ],
            ],
        ],
        'verkaufsprioritaet_default' => [
            'name' => 'verkaufsprioritaet_default',
            'title' => 'verkaufsprioritaet_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'verkaufsprioritaet_default',
                ],
            ],
        ],
        'hinweise_pdf_1_text_default' => [
            'name' => 'hinweise_pdf_1_text_default',
            'title' => 'hinweise_pdf_1_text_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'optionen_default' => [
            'name' => 'optionen_default',
            'title' => 'optionen_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'optionen_default',
                ],
            ],
        ],
        'hinweise_pdf_1_default' => [
            'name' => 'hinweise_pdf_1_default',
            'title' => 'hinweise_pdf_1_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\File',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'hinweise_pdf_1_default',
                ],
            ],
        ],
        'farbsteuerung_default' => [
            'name' => 'farbsteuerung_default',
            'title' => 'farbsteuerung_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'farbsteuerung_default',
                ],
            ],
        ],
        'steuerung_termine_preise_print_default' => [
            'name' => 'steuerung_termine_preise_print_default',
            'title' => 'steuerung_termine_preise_print_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'steuerung_termine_preise_print_default',
                ],
            ],
        ],
        'freitextstoerer_oben_default' => [
            'name' => 'freitextstoerer_oben_default',
            'title' => 'freitextstoerer_oben_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'freitextstoerer_unten_default' => [
            'name' => 'freitextstoerer_unten_default',
            'title' => 'freitextstoerer_unten_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
    ],
];}