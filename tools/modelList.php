<?php class modelList
{
    
    /* 获取模型列表 */
    public function get_list()
    {
        return json_decode(file_get_contents('../model_list.json'), 1);
    }
    
    /* 获取模组名称 */
    public function id_to_name($id)
    {
        $list = self::get_list();
        return $list['models'][(int)$id-1];
    }
    
    /* 转换模型名称 */
    public function name_to_id($name)
    {
        $list = self::get_list();
        $id = array_search($name, $list['models']);
        return is_numeric($id) ? $id + 1 : false;
    }
}
