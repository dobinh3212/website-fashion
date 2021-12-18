<?php
function data_tree($data, $parent_id = 0, $level = 0){
    $result = array();
    foreach($data as $item){
        if($item['parent_id'] == $parent_id){
            $item['level'] = $level;
            $result[] = $item;
            unset($data[$item['id']]);
            $child = data_tree($data, $item['id'], $level+1);
            $result = array_merge($result, $child);
        }
    }
    return $result;
}

function showCategories($categories, $parent_id = 0, $char = '')
{
    // BƯỚC 2.1: LẤY DANH SÁCH CATE CON
    $cate_child = array();
    foreach ($categories as $key => $item)
    {

        if ($item['parent_id'] == $parent_id)
        {
            $cate_child[] = $item;
            unset($categories[$key]);
        }
    }
    if ($cate_child)
    {
        echo '<ul>';
        foreach ($cate_child as $key => $item)
        {
            echo '<li>'.$item['product_cat_title'];

            // Tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đang lặp
            showCategories($categories, $item['id'], $char . '|---');
            echo '</li>';
        }
        echo '</ul>';
    }
}



