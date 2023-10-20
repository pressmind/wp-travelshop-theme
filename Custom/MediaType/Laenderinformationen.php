<?php

namespace Custom\MediaType;

use Pressmind\ORM\Object\MediaType\AbstractMediaType;
use Pressmind\ORM\Object\MediaObject\DataType;

/**
 * Class Laenderinformationen
 * @property integer $id
 * @property integer $id_media_object
 * @property string $language
 * @property string $headline_textbaustein_default
 * @property string $text_default
 * @property string $einreiseinformationen_default
 * @property string $ortstaxe_default
 */
class Laenderinformationen extends AbstractMediaType {
protected $_definitions = [
    'class' => [
        'name' => 'Laenderinformationen',
    ],
    'database' => [
        'table_name' => 'objectdata_915',
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
        'headline_textbaustein_default' => [
            'name' => 'headline_textbaustein_default',
            'title' => 'headline_textbaustein_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'text_default' => [
            'name' => 'text_default',
            'title' => 'text_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'einreiseinformationen_default' => [
            'name' => 'einreiseinformationen_default',
            'title' => 'einreiseinformationen_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'ortstaxe_default' => [
            'name' => 'ortstaxe_default',
            'title' => 'ortstaxe_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
    ],
];}