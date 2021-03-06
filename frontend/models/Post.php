<?php

namespace app\models;

use Yii;
use common\models\User;
use app\models\Thread;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use app\components\Utility;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property string  $content
 * @property integer $thread_id
 * @property integer $created_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $createdBy
 * @property Thread $thread
 */
class Post extends \yii\db\ActiveRecord
{
    public $testQuestion;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'thread_id', 'testQuestion'], 'required'],
            [['thread_id', 'created_by', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string', 'max' => 100],
            [['created_at'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(),   'targetAttribute' => ['created_by' => 'id']],
            [['thread_id'],  'exist', 'skipOnError' => true, 'targetClass' => Thread::className(), 'targetAttribute' => ['thread_id' => 'id']],
            ['content', function ($attribute, $params, $validator) {
                if (Utility::matchURLs($this->$attribute)){
                  // show error in main page
                  // TODO: show error in modal.
                  $this->addError($attribute, 'Sorry, urls are not allowed in the post');
                }
              }],
            ['testQuestion', function ($attribute, $params, $validator) {
                if ("two" !== $this->$attribute){
                  $this->addError($attribute, 'The text of the nice question is not right!');
                }
              }
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Content',
            'testQuestion' => "Humans have * legs (literal)",
            'thread_id' => 'Thread ID',
            'created_by' => 'Created By',
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
            'blameable' => [ // let's try this new functionality
              // TODO: important: rollback on this and use normal id, Bleameable is more for Admins!
              'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by', # TODO: change in author_id
                'updatedByAttribute' => null,         # TODO: in future we'll need to know who has modified.
            ]
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThread()
    {
        return $this->hasOne(Thread::className(), ['id' => 'thread_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVote()
    {
        return $this->hasMany(Vote::className(), ['post_id' => 'id']);
    }
    // future purpose.
    // /**
    //   * @param bool $insert
    //   *
    //   * @return bool
    //   */
    //   public function beforeSave($insert)
    //   {
    //     // rule for hiddin links
    //     $this->text = preg_replace('~((?:https?|ftps?)://.*?)( |$)~iu','[hidden-url]\2', $this->text);
    //
    //     return parent::beforeSave($insert);
    //   }
}
