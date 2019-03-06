<?php

function getModelClassByTableName($tableName, $primeryKey=null)
{
    $className = 'App\\Models\\' . studly_case(str_singular($tableName));
    $model = null;
    if(class_exists($className)) {
        $model = new $className;
        if ($primeryKey) {
            $model = $model->find($primeryKey);
        }
    }
    return ['model' => $model, 'class' => $className];
}