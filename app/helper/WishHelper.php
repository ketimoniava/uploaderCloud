<?php

class WishHelper extends Helper {
    private static $uplodPhotoTypes = array(
            'image/jpeg',
            'image/jpg',
            'image/png',
            'image/x-png',
            'image/gif'
        );
    
    private static $uploadPhotoMaxSize = 3;
    
    
    /**
     * სურვილის წაშლის დროს წაიშალოს მისი ფაილები.
     * შეგვიძლია გადმოვცეთ, კონკრეტული სურვილის მასივი ან სურვილის ფაილის სახელი
     * 
     * @param mixed $wish სურვილის მასივი ან სურვილის ფაილის სახელი 
     * @return type
     */
    public static function deleteWishFiles($wish) {
        if(!$wish) : return; endif;
        if (is_array($wish)) {
            return self::deleteWishFiles($wish['file_name']);
        }
        $path = UPLOAD_PRIVATE_PATH.DS."pht".DS;
        $pathThumb = $path."thmb".DS;
        // delete thumbnails
        FileHelper::deleteFile($pathThumb."a".DS.$wish);
        // delete original file
        return FileHelper::deleteFile($path.$wish);
    }

    

    /**
     * Prepare upload object for wish photo
     * @return \Upload
     */
    public static function &getPhotoUploadObject() {
        $upload = new Upload(UPLOAD_PRIVATE_PATH.DS."pht");
        $upload->file($_FILES['wish-photo']);
        $upload->set_max_file_size(self::$uploadPhotoMaxSize);
        $upload->set_allowed_mime_types(self::$uplodPhotoTypes);
        return $upload;
    }
    
    public static function getValidationObject() {
        
    } 
    
    /**
     * Draw select tag fopr privacy
     * @param type $data
     * @param type $active
     * @return type
     */
    public static function drawPrivacy($wishid, $data, $active, $id = '') {
        //return HtmlHelper::selectTag('wish-privacy', $data, $active);
		return HtmlHelper::selectUlAsSelectTag('wish-privacy', $wishid, $data, $active);
    }
    
    /**
     * Draw select tag fopr category
     * @param type $data
     * @param type $active
     * @return type
     */
    public static function drawCategory(&$data, $active) {
        return HtmlHelper::selectTag('wish-category', $data, $active, 'id', 'name');
    }
    
    
    public static function generateUserKey($uid){
        return URL::generateKey(array(
            $uid
        ), '-u:id.1'); 
    }
    
    public static function generateWishKey($wid){
        return URL::generateKey(array(
            $wid
        ), '-w:id.2'); 
    }
    
    public static function getWishURL($wid) {
        return URL::getPath('profile/viewWish?wid='.$wid);
    }
    
    public static function RedirectToWish($wid) {
        PageFunctions::redirect(self::getWishURL($wid));
    }
    
    
    public static function getFulfilHTML(&$wishData, $viewer) {
        $str = '<li class="fulfil">';
                    
        $ffBy = @$wishData['fulfilled_by'];
                   
        if ($ffBy) :
            if ($ffBy == $viewer) : 
                $str .= '<a href="'.URL::getPath('profile/viewWish?wid='.$wishData['id'].'&act=unff').'">გაუქმება</a>';
            else : /* IF WISH IS SELECTED BY ANOTHER ONE */
                if($viewer != $wishData['user_id'] || $wishData['show_to_owner'] != 1) :
                    $str .= '<p class="ff-chosen">არჩეული</p>';
                else :
                    $str .= '<p class="ff-chosen-by">არჩეული: '.$wishData['display_name'].'</p>';
                endif; 
            endif; 
                        
        else : 
            if($viewer != $wishData['user_id']) :
                
                $str .= '<a href="#" onclick="$(\'#notify-box-'.$wishData['id'].'\').show(); return false;">ასრულება</a>
                    <div class="notify-box" id="notify-box-'.$wishData['id'].'">
                        <form action="" method="get">
                        <input type="hidden" name="wid" value="'.$wishData['id'].'" />
                        <input type="hidden" name="act" value="ff" />
                        <label>
                            <input type="checkbox" value="1" name="show-ff" />
                            აჩვენე მეგობარს ჩემი ვინაობა
                             <br />
                            <button type="submit">ასრულება</button>
                        </label>
                        </form>
                    </div>';
            else: 
                $str .= '<p class="ff-not-selected">არ არის მონიშნული</p>';
            endif;
        endif; 
        
        $str .= '</li>';
        
        return $str;
    }
    
    
    
    
}