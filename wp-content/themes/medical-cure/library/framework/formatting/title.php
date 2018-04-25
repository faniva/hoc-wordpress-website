<?php
function code125_format_title($value='' , $tag = 'h4', $class='', $span = '')
{

    if (is_array($value)) {
        $values = $value;
    }else{
        if( is_array(@code125_decode($value )) ){
            $values =  code125_decode($value );
        }else{
            return $values;
        }
    }
    $id = code125_generate_unique_id();

    if (isset($values['title']) && $values['title'] =='') {
        return '';
    }

    $return = '<'.$tag.' class="code125-extended-title-common '.$class.' code125-extended-title-'.$id.'">';
    if (isset($values['icon']) && $values['icon'] !='' && $values['icon'] != 'fa fa-none') {
        $return .= '<span class="'.$values['icon'].'"></span> ';
    }
    if (isset($values['title']) && $values['title'] !='') {
        $return .= $values['title'];
    }
    $size = '';
    if (isset($values['fontsize']) && $values['fontsize'] !='') {
        $options = array(
            'xsmall' => '14px',
            'small' => '18px',
            'medium' => '24px',
            'large' => '30px',
            'xlarge' => '36px',
            'xxlarge' => '48px',
            'xxxlarge' => '64px',
            'xxxxlarge' => '72px',
        );
        $values['fontsize'] = isset($options[$values['fontsize']]) ? $options[$values['fontsize']] : 'inherit';
        if ($values['fontsize'] == 'inherit') {
            $size = '';
        }else{
            $size = round(str_replace('px','',$values['fontsize']) * 0.25);
        }
    }
    $return .= $span . '</'.$tag.'>';

    $css = '';
    if (isset($values['color']) && $values['color'] !='') {
        $css .= 'color: ' . $values['color'] . ' !important;';
    }
    if (isset($values['fontsize']) && $values['fontsize'] !='') {
        $css .= 'font-size: ' . $values['fontsize'] . ';';
    }
    if (isset($values['texttransform']) && $values['texttransform'] !='') {
        $css .= 'text-transform: ' . $values['texttransform'] . ';';
    }
    if (isset($values['fontweight']) && $values['fontweight'] !='') {
        $css .= 'font-weight: ' . $values['fontweight'] . ' !important;';
    }
    if (isset($values['letterspacing']) && $values['letterspacing'] !='') {
        $css .= 'letter-spacing: ' . $values['letterspacing'] . ' !important;';
    }
    if (isset($values['lineheight']) && $values['lineheight'] !='') {
        $css .= 'line-height: ' . $values['lineheight'] . ' !important;';
    }


    if ($css!= '') {
        $css = $tag . '.code125-extended-title-'.$id.'{' . $css . '}';
    }


    if (isset($values['fontsize']) && $values['fontsize'] !='' && $size!='') {
        $css .= $tag . '.code125-extended-title-'.$id.' span{ margin-right: ' . $size . 'px; }';
    }
    if (isset($values['colorhover']) && $values['colorhover'] !='') {
        $css .= $tag. '.code125-extended-title-'.$id.':hover{ color: ' . $values['colorhover'] . ' !important; }';
    }
    if ($css!='') {

        $return .= '<style>' . $css . '</style>';
    }

    return $return;
}
?>
