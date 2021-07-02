<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dm_nhom_bai".
 *
 * @property int $id
 * @property string $ten
 *
 * @property DmTinhtoan[] $dmTinhtoans
 */
class DmNhomBai extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dm_nhom_bai';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten'], 'required'],
            [['ten'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten' => 'Tên nhóm',
        ];
    }

    /**
     * Gets query for [[DmTinhtoans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDmTinhtoans()
    {
        return $this->hasMany(DmTinhtoan::className(), ['nhom_id' => 'id']);
    }
}
