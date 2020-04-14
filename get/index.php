<?php
isset($_GET['id']) ? $id = $_GET['id'] : exit('error');
header("Access-Control-Allow-Origin:*");

require '../tools/modelList.php';
require '../tools/modelTextures.php';
require '../tools/jsonCompatible.php';

$modelList = new modelList();
$modelTextures = new modelTextures();
$jsonCompatible = new jsonCompatible();

$id = explode('-', $id);
$modelId = (int)$id[0];
$modelTexturesId = isset($id[1]) ? (int)$id[1] : 0;

$modelName = $modelList->id_to_name($modelId);

if (is_array($modelName)) {
    $modelName = $modelTexturesId > 0 ? $modelName[$modelTexturesId-1] : $modelName[0];
    $pathName='../npm/'.$modelName;
    $pathName=preg_replace('/l2dmodel_[\d]+@[\d.]+?\//', '', $pathName);
    $fileName=file_exists($pathName.'/index.json')?$pathName.'/index.json':$pathName.'/model.json';
    $json = json_decode(file_get_contents($fileName), 1);
} else {
    $pathName='../npm/'.$modelName;
    $pathName=preg_replace('/l2dmodel_[\d]+@[\d.]+?\//', '', $pathName);
    $fileName=file_exists($pathName.'/index.json')?$pathName.'/index.json':$pathName.'/model.json';
    $json = json_decode(file_get_contents($fileName), 1);
    
    if ($modelTexturesId > 0) {
        $modelTexturesName = $modelTextures->get_name($modelName, $modelTexturesId);
        if (isset($modelTexturesName)) {
            $json['textures'] = is_array($modelTexturesName) ? $modelTexturesName : array($modelTexturesName);
        }
    }
}

for ($i=0;$i<count($json['textures'], 0);$i++) {
    $json['textures'][$i] = '../npm/'.$modelName.'/'.$json['textures'][$i];
}

$json['model'] = '../npm/'.$modelName.'/'.$json['model'];
if (isset($json['pose'])) {
    $json['pose'] = '../npm/'.$modelName.'/'.$json['pose'];
}
if (isset($json['physics'])) {
    $json['physics'] = '../npm/'.$modelName.'/'.$json['physics'];
}
if (isset($json['voice'])) {
    $json['voice'] = '../npm/'.$modelName.'/'.$json['voice'];
}

if (isset($json['motions'])) {
    foreach ($json['motions'] as $key=>$value) {
        for ($i=0;$i<count($json['motions'][$key], 0);$i++) {
            if (strpos($modelName, 'girlsFrontline')!==false) {
                $json['motions'][$key][$i]["file"]=str_replace(array("normal/","destroy/"), array("",""), $json['motions'][$key][$i]["file"]);
            }
            if (!empty($json['motions'][$key][$i]["file"])) {
                $json['motions'][$key][$i]["file"] = '../npm/'.$modelName.'/'.$json['motions'][$key][$i]["file"];
            }
            if (isset($json['motions'][$key][$i]['sound'])) {
                $json['motions'][$key][$i]['sound'] = '../npm/'.$modelName.'/'.$json['motions'][$key][$i]['sound'];
            }
        }
    }
}

if (isset($json['expressions'])) {
    for ($i=0;$i<count($json['expressions'], 0);$i++) {
        if (!empty($json['expressions'][$i]["file"])) {
            $json['expressions'][$i]["file"] = '../npm/'.$modelName.'/'.$json['expressions'][$i]["file"];
        }
    }
}

if (!isset($json["layout"])) {
    $json["layout"] = array(
        "center_x"=>0.0,
        "center_y"=>0.0
    );
}
if (!isset($json["hit_areas_custom"])) {
    $json["hit_areas_custom"] = array(
        "head_x"=>array(0.0, 0.0),
        "head_y"=>array(0.0, 0.0),
        "body_x"=>array(0.0, 0.0),
        "body_y"=>array(0.0, 0.0)
    );
}

header("Content-type: application/json");
echo $jsonCompatible->json_encode($json);
