<?php


function code125_format_button($value='', $class='')
{
    if (is_array($value)) {
        $values = $value;
    }else{
        if( is_array(@code125_decode($value )) ){
            $values =  code125_decode($value );
        }else{
            return '';
        }
    }


    if (!isset($values['link']) || $values['link'] =='') {
        return '';
    }

    $id = code125_generate_unique_id();

    $link = isset($values['link']) ? 'href="'.esc_url($values['link']).'"' : '';
    $target = isset($values['target']) && $values['target'] != '' ? 'target="'.$values['target'].'"' : '';

    $return = '<a class="'.$class.' c5-btn-'.$id.'" '.$link.' '.$target.'>';

    if (isset($values['text']) && $values['text'] !='') {
        $return .= $values['text'];
    }
    if (isset($values['icon']) && $values['icon'] !='' && $values['icon'] != 'fa fa-none') {
        $return .= '<span class="c5-btn-icon '.$values['icon'].'"></span> ';
    }
    $return .='</a>';
    $css = '';
    if (isset($values['color']) && $values['color'] !='') {

        $obj_style = new Code125_Colors();
        $light_accent = $obj_style->AdjustHSL($values['color'] ,'1', '0.96' );

        $css .= 'a.btn.c5-btn-'.$id.'{ color: ' . $values['color'] . ' ; border-color: #fff; background: #fff; }';
        $css .= 'a.btn.c5-btn-'.$id.':hover{ color: #fff; background: ' . $values['color'] . '; border-color: ' . $values['color'] . '; }';

        $css .= 'a.btn.inverse.c5-btn-'.$id.':hover{ color: ' . $values['color'] . ' ; border-color: '.$light_accent.' ; background: '.$light_accent.'; }';
        $css .= 'a.btn.inverse.c5-btn-'.$id.'{ color: #fff; background: ' . $values['color'] . '; border-color: ' . $values['color'] . '; }';


    }
    if($css!=''){
        $return .= '<style>'.$css.'</style>';
    }



    return $return;
}

?>
