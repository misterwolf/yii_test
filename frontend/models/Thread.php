<?php

/*



MOVE THIS IN COMMONS FOLDER BECAUSE IT MAY NEED TO BE MANAGED BY ADMINS



*/

namespace app\models;

use Yii;
use common\models\User;
use app\models\Post;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "thread".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $views
 * @property integer $created_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Post[] $posts
 * @property User $author
 */
class Thread extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'thread';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            [['views', 'created_by', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 32],
            [['content'], 'string', 'max' => 100],
            [['title'], 'unique'],
            [['title'], 'unique'],
            [['created_at'], 'unique'],
            # TODO: rollback on this and use normal fk_id: it purpose is about Administrations
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\User::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
      * @inheritdoc
      */
    // public function relations()
    // {
    //    return array(
    //      'profile'=>array(self::HAS_ONE, 'User', 'created_by'),
    //    );
    // }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'      => 'ID',
            'title'   => 'Title',
            'content' => 'Content',
            'views'   => 'Views',
            'created_by' => 'Author ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
          TimestampBehavior::className(),
          'blameable' => [ // let's try this new functionality - TODO: important: rollback on this, Bleameable is more for Admins!
              'class' => BlameableBehavior::className(),
              'createdByAttribute' => 'created_by', # TODO: change in author_id
              'updatedByAttribute' => null,
          ]
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasMany(Post::className(), ['thread_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVote()
    {
        return $this->hasMany(Vote::className(), ['thread_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
}
