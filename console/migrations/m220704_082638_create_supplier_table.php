<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%supplier}}`.
 */
class m220704_082638_create_supplier_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%supplier}}', [
            'id' => $this->primaryKey()->notNull()->unsigned(),
            'name' => \yii\db\mysql\Schema::TYPE_STRING . "(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT ''",
            'code' => \yii\db\mysql\Schema::TYPE_CHAR . "(3) CHARACTER SET ascii COLLATE ascii_general_ci DEFAULT NULL",
            't_status' => "enum('ok','hold') CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL DEFAULT 'ok'",
        ]);
        // code添加唯一索引
        $this->createIndex('uk_code', '{{%supplier}}', ['code'], true);
        //伪造一些数据
        $this->fake();
    }

    /**
     * 伪造一些数据
     */
    protected function fake()
    {
        for($i = 0; $i <50; $i ++){
            try{
                $this->insert('{{%supplier}}',
                    [
                        'name' => Yii::$app->security->generateRandomString(30),
                        'code' => Yii::$app->security->generateRandomString(3),
                        't_status' => rand(1,100)%2 > 0 ? 'ok' : 'hold'
                    ]
                );
            }catch (\Exception $e){}
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%supplier}}');
    }
}
