<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comments".
 *
 * @property int $id
 * @property int|null $rating
 * @property string|null $text
 * @property int|null $user_id
 * @property int|null $api_fruit_id
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Fruits $fruit
 * @property Users $user
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rating', 'user_id', 'api_fruit_id'], 'integer'],
            [['text'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rating' => 'Rating',
            'text' => 'Text',
            'user_id' => 'User ID',
            'api_fruit_id' => 'Fruit ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getLatestReviews(?int $limit = null, bool $withUser = true)
    {
        $query = Comment::find()
            ->select(['text', 'rating', 'user_id', 'api_fruit_id'])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit($limit);

        if ($withUser) {
            $query->with(['user' => function ($query) {
                $query->select(['id', 'name']);
            }]);
        }

        return $query->all();
    }
}
