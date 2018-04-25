<?php

/**
 *
 */
class C5_Post_Query
{
    public $temp_width;
    function __construct()
    {
        # code...
    }
    public function get_count()
    {
        if ($GLOBALS['c5_content_width'] < 400) {
            $count = 1;
        }elseif($GLOBALS['c5_content_width'] < 900) {
            $count = 2;
        }else{
            $count = 3;
        }
        return $count;
    }

    public function after_width()
    {
        $GLOBALS['c5_content_width'] = $this->temp_width;
    }

    public function before_width($count=1)
	{
		$this->temp_width = $GLOBALS['c5_content_width'];

		if ($count > 1) {
			$GLOBALS['c5_content_width'] = round($GLOBALS['c5_content_width']/$count);
		}
	}

	public function before_layout($the_query , $count = 1)
	{
		$span = 12 / $count;
		$data = '';
		if ($count != 1) {
            if ($the_query->current_post%$count == 0) {
				$data .= '<div class="row" >';
			}
			$data .= '<div class="col-sm-'.$span.'">';
		}

		$this->before_width($count);
		return $data;
	}

	public function after_layout($the_query , $count = 1)
	{
		$data = '';
		if ($count != 1) {
            
			$data .=  '</div>';
			if ($the_query->current_post%$count == ($count -1)) {
				$data .=  '</div>';
			}elseif  ($the_query->current_post  == ($the_query->post_count -1)) {
                $data .=  '</div>';
            }
		}
		$this->after_width();
		return $data;
	}
}

?>
