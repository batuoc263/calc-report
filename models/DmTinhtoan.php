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
 * @property int|null $nhom_id
 *
 * @property DmNhomBai $nhom
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
            [['luot_giai', 'nhom_id'], 'integer'],
            [['ten_bai_toan', 'duong_dan'], 'string', 'max' => 1000],
            [['nhom_id'], 'exist', 'skipOnError' => true, 'targetClass' => DmNhomBai::className(), 'targetAttribute' => ['nhom_id' => 'id']],
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
            'nhom_id' => 'Nhóm bài tập',
        ];
    }

    /**
     * Gets query for [[Nhom]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNhom()
    {
        return $this->hasOne(DmNhomBai::className(), ['id' => 'nhom_id']);
    }
}
