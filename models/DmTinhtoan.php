<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dm_tinhtoan".
 *
 * @property int $id
 * @property string|null $ten_bai_toan
 * @property string|null $duong_dan
 */
class DmTinhtoan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dm_tinhtoan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_bai_toan', 'duong_dan'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_bai_toan' => 'Ten Bai Toan',
            'duong_dan' => 'Duong Dan',
        ];
    }
}
