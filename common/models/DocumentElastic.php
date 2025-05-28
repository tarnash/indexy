<?php

namespace common\models;


use DateTime;
use yii\base\InvalidConfigException;
use yii\elasticsearch\ActiveRecord;
use yii\elasticsearch\Exception;

/**
 * DocumentElastic model
 *
 * @property int $_id
 * @property string $title
 * @property string $content
 * @property DateTime $created_at
 * @property DateTime $updated_at
 */
class DocumentElastic extends ActiveRecord
{
    public static function index()
    {
        return 'documents';
    }

    public static function type()
    {
        return '_doc';
    }

    public function attributes()
    {
        return ['title', 'content', 'created_at', 'updated_at'];
    }

    public static function mapping()
    {
        return [
            'properties' => [
                'title' => ['type' => 'text'],
                'content' => ['type' => 'text'],
                'created_at' => ['type' => 'date'],
                'updated_at' => ['type' => 'date'],
            ],
        ];
    }


    /**
     * @throws InvalidConfigException
     * @throws Exception
     */
    public static function updateMapping()
    {
        $db = static::getDb();
        $command = $db->createCommand();
        $command->setMapping(static::index(), static::type(), static::mapping());
    }


    /**
     * @throws InvalidConfigException
     * @throws Exception
     */
    public static function createIndex()
    {
        $db = static::getDb();
        $command = $db->createCommand();
        $command->createIndex(static::index(), [
            //'aliases' => [ /* ... */ ],
            'mappings' => static::mapping(),
            //'settings' => [ /* ... */ ],
        ]);
    }


    /**
     * @throws InvalidConfigException
     * @throws Exception
     */
    public static function deleteIndex()
    {
        $db = static::getDb();
        $command = $db->createCommand();
        $command->deleteIndex(static::index());
    }

    /**
     * @throws \yii\db\Exception
     */
    public function saveDocument(Document $model): bool
    {
        $elastic = new DocumentElastic();
        $elastic->_id = $model->id;
        $elastic->title = $model->title;
        $elastic->content = $model->content;
        $elastic->created_at = $model->created_at;
        $elastic->updated_at = $model->updated_at;
        return $elastic->save();
    }
}