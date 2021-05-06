<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dm_tinhtoan".
 *
 * @property int $id
 * @property string|null $ten_bai_toan
 * @property string|null $duong_dan
 * @property int|null $luot_giai
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
            [['luot_giai'], 'integer'],
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
            'ten_bai_toan' => 'Tên bài toán',
            'duong_dan' => 'Đường dẫn',
            'luot_giai' => 'Lượt giải',
        ];
    }
}
