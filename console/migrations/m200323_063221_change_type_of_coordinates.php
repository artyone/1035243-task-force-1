<?php

use yii\db\Migration;

/**
 * Class m200323_063221_change_type_of_coordinates
 */
class m200323_063221_change_type_of_coordinates extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('tasks', 'longitude', 'double');
        $this->alterColumn('tasks', 'latitude', 'double');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('tasks', 'longitude', 'integer');
        $this->alterColumn('tasks', 'latitude', 'integer');
        echo "m200323_063221_change_type_of_coordinates cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200323_063221_change_type_of_coordinates cannot be reverted.\n";

        return false;
    }
    */
}
