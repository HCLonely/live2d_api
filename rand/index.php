<?php
isset($_GET['id']) ? $modelId = (int)$_GET['id'] : exit('error');
header("Access-Control-Allow-Origin:*");

$visitor=intval(file_get_contents('../visitor.txt'));
file_put_contents('../visitor.txt', strval(++$visitor));

require '../tools/modelList.php';
require '../tools/jsonCompatible.php';

$modelList = new modelList();
$jsonCompatible = new jsonCompatible();

$modelList = $modelList->get_list();

$modelRandNewId = true;
while ($modelRandNewId) {
    $modelRandId = rand(0, count($modelList['models'])-1)+1;
    $modelRandNewId = $modelRandId == $modelId ? true : false;
}

header("Content-type: application/json");
echo $jsonCompatible->json_encode(array('model' => array(
    'id' => $modelRandId,
    'name' => $modelList['models'][$modelRandId-1],
    'message' => $modelList['messages'][$modelRandId-1]
)));
