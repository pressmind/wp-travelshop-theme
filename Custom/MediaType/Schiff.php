<?php

namespace Custom\MediaType;

use Pressmind\ORM\Object\MediaType\AbstractMediaType;
use Pressmind\ORM\Object\MediaObject\DataType;

/**
 * Class Schiff
 * @property integer $id
 * @property integer $id_media_object
 * @property string $language
 * @property DataType\File[] $deckplan_default
 * @property DataType\Objectlink[] $kabinen_default
 * @property string $beschreibung_default
 */
class Schiff extends AbstractMediaType {
protected $_definitions = [
    'class' => [
        'name' => 'Schiff',
    ],
    'database' => [
        'table_name' => 'objectdata_2194',
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
        'deckplan_default' => [
            'name' => 'deckplan_default',
            'title' => 'deckplan_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\File',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'deckplan_default',
                ],
            ],
        ],
        'kabinen_default' => [
            'name' => 'kabinen_default',
            'title' => 'kabinen_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Objectlink',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'kabinen_default',
                ],
            ],
        ],
        'beschreibung_default' => [
            'name' => 'beschreibung_default',
            'title' => 'beschreibung_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
    ],
];}