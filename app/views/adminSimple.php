<!DOCTYPE html>
<html>
    <head>
        <title>ადმინ მაგალითი</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width">
     
        <script src="<?=PATH_TO_PUBLIC?>/js/functions.js"></script>
        
        <link rel="stylesheet" href="<?=PATH_TO_PUBLIC?>/css/_layout.css" />
        <link rel="stylesheet" href="<?=PATH_TO_PUBLIC?>/css/_photos.css" />
        
    </head>
    <body>
        <div id="container">
            <?php 
                
                $this->loadView($view);
            ?>
        </div>
    </body>
</html>
