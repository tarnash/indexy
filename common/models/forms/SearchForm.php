<?php

namespace common\models\forms;

use Yii;
use yii\base\Model;

/**
 * SearchForm model.
 *
 * @property string $query
 */
class SearchForm extends Model
{
    public $query;

    public function rules()
    {
        return [
            [['query'], 'required', 'message' => Yii::t('common', 'Please fill in this field')],
            [['query'], 'string', 'min' => 1],
        ];
    }

    public function attributeLabels()
    {
        return [
            'query' => 'Query',
        ];
    }
}