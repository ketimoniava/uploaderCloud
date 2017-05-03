<?php
/**
 * HTML-სთვის დამხმარე კლასი
 */
class HtmlHelper {
 
    /**
     * Draw select tag
     * @param type $name
     * @param type $optionTags
     * @param type $activeEntry
     * @param string $keyFromV if provided :key will be taken from $v
     * @return string
     */
    public static function selectTag($name,$optionTags, $activeEntry, $keyName=null, $valueName=null) {
        $str = '<select name="'.$name.'">';
        foreach ($optionTags as $kt=>$vt) {
            $k = $keyName==null ? $kt: $vt[$keyName];
            $v = $valueName==null ? $vt: $vt[$valueName];
            $str .= '<option value="'.$k.'"'.($k==$activeEntry?' selected="selected"':'').'>'.$v.'</option>';
        }
        $str .= '</select>';
        return $str;
    }

	public static function selectUlAsSelectTag($name, $wishid, $optionTags, $activeEntry, $keyName=null, $valueName=null) {
		if($activeEntry == 1)
		{
			$active_v = "ყველა";
		}
		if($activeEntry == 2)
		{
			$active_v = "მეგობრები";
		}
		if($activeEntry == 3)
		{
			$active_v = "მე";
		}
		if($activeEntry == 9)
		{
			$active_v = "სია";
		}
		$str= "<span id='dd".$wishid."' class='click' data-value='".$wishid."'>".$active_v." </span>\n";
		$str.= '<ul id="'.$name.$wishid.'">';
        foreach($optionTags as $kt=>$vt) {
            $k = $keyName == null ? $kt: $vt[$keyName];
            $v = $valueName == null ? $vt: $vt[$valueName];
            $str .= '<li data-value="'.$k.'"'.($k==$activeEntry?' selected="selected"':'').'>'.$v.'</li>';
        }
        $str.= '</ul>';
        return $str;
    }
}