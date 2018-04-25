<?php

/**
*
*/
class C5AB_FORMAT_BUILDER_DATA
{


    function get_child_values($order , $post_data) {
        $data_return = array();
        foreach ($order as $id => $value2) {
            $return = array();

            foreach ($post_data as $key => $value) {
                $exploded = explode("-", $key);

                if($exploded[0] == 'c5ab' ){
                    if( $exploded[1] == $id){

                        if( is_array(@code125_decode( $value) ) ){

                            $return[$exploded[2] ] = code125_decode( $value  );
                        }else {
                            $return[$exploded[2] ] = stripslashes($value);
                        }

                    }
                }
            }
            if(count($value2)!=0){
                $return['content'] = $this->get_child_values($value2 , $post_data);
            }
            $return['id'] = $id;
            $data_return[] = $return;
        }
        return $data_return;
    }

    function get_children($parent_id , $post_data ) {

        $order =array();
        foreach ($post_data as $key => $value) {
            $exploded = explode("-", $key);
            if($exploded[0] == 'c5ab' && $exploded[1] != 'test' ){
                if( $post_data['c5ab-' . $exploded[1] .'-parent'] == $parent_id){
                    $order[$exploded[1]] = array() ;
                }
            }
        }
        if(count($order)!=0){
            foreach ($order as $key => $value) {
                $order[$key]=$this->get_children($key , $post_data );
            }
        }

        return $order;
    }
}

?>
