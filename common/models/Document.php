<?php

namespace common\models;

use DateTime;
use Throwable;
use Yii;
use yii\db\ActiveRecord;

/**
 * Document model
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property DateTime $created_at
 * @property DateTime $updated_at
 */
class Document extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%documents}}';
    }

    public function rules()
    {
        return [
            [['id', 'title', 'content'], 'required'],
            [['id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'created_at' => 'Created',
            'updated_at' => 'Updated',
        ];
    }

    /**
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $elastic = new DocumentElastic();
        $elastic->_id = $this->id;
        $elastic->title = $this->title;
        $elastic->content = $this->content;
        $elastic->created_at = $this->created_at;
        $elastic->updated_at = $this->updated_at;
        try {
            $elastic->save();
        } catch (Throwable $e) {
            Yii::error("Ошибка индексации документа ID {$this->id}: " . $e->getMessage(), __METHOD__);
        }
    }
}