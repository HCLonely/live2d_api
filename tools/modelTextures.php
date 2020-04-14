<?php class modelTextures
{
    
    /* 获取材质名称 */
    public function get_name($modelName, $id)
    {
        $list = self::get_list($modelName);
        return $list['textures'][(int)$id-1];
    }
    
    /* 获取列表缓存 */
    public function get_list($modelName)
    {
        $modelName=preg_replace('/l2dmodel_[\d]+@[\d.]+?\//', '', $modelName);
        if (file_exists('../npm/'.$modelName.'/textures.cache')) {
            $textures = json_decode(file_get_contents('../npm/'.$modelName.'/textures.cache'), true);
        } else {
            $textures = self::get_textures($modelName);
            if (!empty($textures)) {
                file_put_contents('../npm/'.$modelName.'/textures.cache', str_replace('\/', '/', json_encode($textures)));
            }
        }
        return isset($textures) ? array('textures' => $textures) : false;
    }
    
    /* 获取材质列表 */
    public function get_textures($modelName)
    {
        $modelName=preg_replace('/l2dmodel_[\d]+@[\d.]+?\//', '', $modelName);
        if (file_exists('../npm/'.$modelName.'/textures_order.json')) {                   // 读取材质组合规则
            $tmp = array();
            foreach (json_decode(file_get_contents('../npm/'.$modelName.'/textures_order.json'), 1) as $k => $v) {
                $tmp2 = array();
                foreach ($v as $textures_dir) {
                    $tmp3 = array();
                    foreach (glob('../npm/'.$modelName.'/'.$textures_dir.'/*') as $n => $m) {
                        $tmp3['merge'.$n] = str_replace('../npm/'.$modelName.'/', '', $m);
                    }
                    $tmp2 = array_merge_recursive($tmp2, $tmp3);
                }
                foreach ($tmp2 as $v4) {
                    $tmp4[$k][] = str_replace('\/', '/', json_encode($v4));
                }
                $tmp = self::array_exhaustive($tmp, $tmp4[$k]);
            }
            foreach ($tmp as $v) {
                $textures[] = json_decode('['.$v.']', 1);
            }
            return $textures;
        } else {
            foreach (glob('../npm/'.$modelName.'/textures/*') as $v) {
                $textures[] = str_replace('../npm/'.$modelName.'/', '', $v);
            }
            return empty($textures) ? null : $textures;
        }
    }
    
    /* 数组穷举合并 */
    public function array_exhaustive($arr1, $arr2)
    {
        foreach ($arr2 as $k => $v) {
            if (empty($arr1)) {
                $out[] = $v;
            } else {
                foreach ($arr1 as $k2 => $v2) {
                    $out[] = str_replace('"["', '","', str_replace('"]"', '","', $v2.$v));
                }
            }
        }
        return $out;
    }
}
