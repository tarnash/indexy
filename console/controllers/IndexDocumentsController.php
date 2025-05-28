<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\Document;
use common\models\DocumentElastic;
use yii\console\ExitCode;
use yii\db\Exception;
use yii\helpers\Console;

class IndexDocumentsController extends Controller
{
    /**
     */
    public function actionIndex($batchSize=100)
    {
        $offset = 0;
        $count = 0;
        $errorCount = 0;
        $console = new Console();

        try {
            $console->output('Creating elastic indexes...');
            DocumentElastic::deleteIndex();

            while (true) {
                $docs = Document::find()
                    ->limit($batchSize)
                    ->offset($offset)
                    ->all();

                if (empty($docs)) {
                    break;
                }
                foreach ($docs as $doc) {
                    $elastic = new DocumentElastic();
                    if ($elastic->saveDocument($doc)) {
                        $count++;
                    }else{
                        $errorCount++;
                    }
                }
                $offset += $batchSize;
            }
            $console->output("Updated: {$count}, Errors: {$errorCount}");
            $console->output('Done');
            \Yii::$app->db->close();
            return ExitCode::OK;
        } catch (\Throwable $e) {
            $console->output('Error: ' . $e->getMessage());
            Yii::error("Error: " . $e->getMessage(), 'console');

            return ExitCode::NOPERM;
        }
    }
}
