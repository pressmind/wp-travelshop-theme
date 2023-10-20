<?php

namespace Custom\MediaType;

use Pressmind\ORM\Object\MediaType\AbstractMediaType;
use Pressmind\ORM\Object\MediaObject\DataType;

/**
 * Class Unterkunft
 * @property integer $id
 * @property integer $id_media_object
 * @property string $language
 * @property DataType\Location[] $geodaten_default
 * @property DataType\Picture[] $logo_default
 * @property string $kuschick_code_default
 * @property string $hinweis_text_default
 * @property DataType\Categorytree[] $zielgebiet_default
 * @property DataType\Objectlink[] $textbausteine_default
 * @property DataType\Objectlink[] $zielgebietsverknuepfung_default
 * @property DataType\Picture[] $bilder_default
 * @property string $title_default
 * @property string $headline_default
 * @property DataType\Categorytree[] $hotelkategorie_default
 * @property DataType\Categorytree[] $ferienzielpendel_default
 * @property string $subline_default
 * @property DataType\Categorytree[] $unterkunftart_default
 * @property DataType\Picture[] $zimmer_default
 * @property string $meta_description_default
 * @property string $einleitung_default
 * @property DataType\Objectlink[] $url_verknuepfung_default
 * @property string $beschreibung_text_default
 * @property string $highlights_default
 * @property DataType\Categorytree[] $kategorie_default
 * @property DataType\Categorytree[] $indikationen_default
 * @property DataType\Categorytree[] $reisetyp_default
 * @property DataType\Link[] $hotellink_default
 * @property DataType\Picture[] $decksplan_default
 * @property DataType\Picture[] $kabine_default
 * @property string $kabine_headline_default
 * @property string $kabine_text_default
 * @property DataType\Table[] $kabinenzuteilung_default
 * @property string $zimmer_headline_default
 * @property string $zimmer_text_default
 * @property string $leistungen_default
 * @property string $treueherzen_pendel_default
 */
class Unterkunft extends AbstractMediaType {
protected $_definitions = [
    'class' => [
        'name' => 'Unterkunft',
    ],
    'database' => [
        'table_name' => 'objectdata_913',
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
        'geodaten_default' => [
            'name' => 'geodaten_default',
            'title' => 'geodaten_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Location',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'geodaten_default',
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
        'kuschick_code_default' => [
            'name' => 'kuschick_code_default',
            'title' => 'kuschick_code_default',
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
        'textbausteine_default' => [
            'name' => 'textbausteine_default',
            'title' => 'textbausteine_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Objectlink',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'textbausteine_default',
                ],
            ],
        ],
        'zielgebietsverknuepfung_default' => [
            'name' => 'zielgebietsverknuepfung_default',
            'title' => 'zielgebietsverknuepfung_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Objectlink',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'zielgebietsverknuepfung_default',
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
        'title_default' => [
            'name' => 'title_default',
            'title' => 'title_default',
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
        'ferienzielpendel_default' => [
            'name' => 'ferienzielpendel_default',
            'title' => 'ferienzielpendel_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'ferienzielpendel_default',
                ],
            ],
        ],
        'subline_default' => [
            'name' => 'subline_default',
            'title' => 'subline_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'unterkunftart_default' => [
            'name' => 'unterkunftart_default',
            'title' => 'unterkunftart_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'unterkunftart_default',
                ],
            ],
        ],
        'zimmer_default' => [
            'name' => 'zimmer_default',
            'title' => 'zimmer_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Picture',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'zimmer_default',
                    'section_name' => 'IS NULL',
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
        'einleitung_default' => [
            'name' => 'einleitung_default',
            'title' => 'einleitung_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
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
        'highlights_default' => [
            'name' => 'highlights_default',
            'title' => 'highlights_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'kategorie_default' => [
            'name' => 'kategorie_default',
            'title' => 'kategorie_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'kategorie_default',
                ],
            ],
        ],
        'indikationen_default' => [
            'name' => 'indikationen_default',
            'title' => 'indikationen_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'indikationen_default',
                ],
            ],
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
        'hotellink_default' => [
            'name' => 'hotellink_default',
            'title' => 'hotellink_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Link',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'hotellink_default',
                ],
            ],
        ],
        'decksplan_default' => [
            'name' => 'decksplan_default',
            'title' => 'decksplan_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Picture',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'decksplan_default',
                    'section_name' => 'IS NULL',
                ],
            ],
        ],
        'kabine_default' => [
            'name' => 'kabine_default',
            'title' => 'kabine_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Picture',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'kabine_default',
                    'section_name' => 'IS NULL',
                ],
            ],
        ],
        'kabine_headline_default' => [
            'name' => 'kabine_headline_default',
            'title' => 'kabine_headline_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'kabine_text_default' => [
            'name' => 'kabine_text_default',
            'title' => 'kabine_text_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'kabinenzuteilung_default' => [
            'name' => 'kabinenzuteilung_default',
            'title' => 'kabinenzuteilung_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Table',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'kabinenzuteilung_default',
                ],
            ],
        ],
        'zimmer_headline_default' => [
            'name' => 'zimmer_headline_default',
            'title' => 'zimmer_headline_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'zimmer_text_default' => [
            'name' => 'zimmer_text_default',
            'title' => 'zimmer_text_default',
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
        'treueherzen_pendel_default' => [
            'name' => 'treueherzen_pendel_default',
            'title' => 'treueherzen_pendel_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
    ],
];}