<?php

namespace common\widgets\yii2TranslatePanel\models\query;

use Yii;
use yii\db\ActiveQuery;
use common\widgets\yii2I18nModule\models\Message;

class SourceMessageQuery extends ActiveQuery
{
    /**
     * @return \common\widgets\yii2TranslatePanel\models\query\SourceMessageQuery
     */
    public function notTranslated()
    {
        $table = Message::tableName();
        $query = Message::find()->select("{$table}.id");

        $i = 0;
        foreach (Yii::$app->getI18n()->languages as $language) {
            if ($i === 0) {

                $query->andWhere("{$table}.language = :language and {$table}.translation is not null", [
                    ':language' => $language,
                ]);
            } else {
                //dd(111);
                $query->innerJoin("{$table} t{$i}", "t{$i}.id = {$table}.id and t{$i}.language = :language and t{$i}.translation is not null", [
                    ':language' => $language,
                ]);
            }
            $i++;
        }

        $ids = $query->indexBy('id')->all();
        $this
            //->andWhere(['not in', "{$table}.id", array_keys($ids)])
            ->andWhere(['not in', "id", array_keys($ids)])
            ->andWhere(['not like', 'message', '@@'])
        ;

        return $this;
    }

    /**
     * @return \common\widgets\yii2TranslatePanel\models\query\SourceMessageQuery
     */
    public function translated()
    {
        $table = Message::tableName();
        $query = Message::find()->select("{$table}.id");
        $i = 0;
        foreach (Yii::$app->getI18n()->languages as $language) {
            if ($i === 0) {
                $query->andWhere("{$table}.language = :language and {$table}.translation is not null", [
                    ':language' => $language,
                ]);
            } else {
                $query->innerJoin("{$table} t{$i}", "t{$i}.id = {$table}.id and t{$i}.language = :language and t{$i}.translation is not null", [
                    ':language' => $language,
                ]);
            }
            $i++;
        }
        $ids = $query->indexBy('id')->all();
        $this
            //->andWhere(['in', "{$table}.id", array_keys($ids)])
            ->andWhere(['in', "id", array_keys($ids)])
            ->andWhere(['not like', 'message', '@@'])
        ;

        return $this;
    }

    /**
     * @return \common\widgets\yii2TranslatePanel\models\query\SourceMessageQuery
     */
    public function deleted()
    {
        $this->andWhere(['like', 'message', '@@']);

        return $this;
    }
}
