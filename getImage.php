<?php
    require_once("CurlBrowser.php");
    
    $browser = new CurlBrowser();
    $title = urlencode($_GET["title"]);
    $type = $_GET["type"];
    if ($type == 'books'){
        $url = "http://www.goodreads.com/search?q=".$title;
        $result = $browser->get($url);
        $findList = explode('class="tableList"', $result);
        $imageLink = explode('href="', $findList[1]);
        $link = explode('"',$imageLink[1]);
        $bookUrl = $link[0];
        if ($bookUrl != ''){
            $detailPageUrl = "http://www.goodreads.com".$bookUrl;
            $result = $browser->get($detailPageUrl);
            $cover = explode('id="imagecol"', $result);
            if ($cover[1] == '')
                $cover = explode('class="cover"', $result);
            $imageSrc = explode('src="', $cover[1]);
            $image = explode('"', $imageSrc[1]);
            $imageLink = $image[0];
            $result = array();
            $result['detailPage'] = $detailPageUrl;
            $result['url'] = $imageLink;
            $result['title'] = $_GET["title"];
            echo json_encode($result);
            //echo $result;
            exit;
        }
        else{
            $result = array();
            $result['detailPage'] = '';
            $result['url'] = '';
            $result['title'] = $_GET["title"];
            echo json_encode($result);
            exit;
        }        
    }else{
        $url = "http://www.imdb.com/find?q=".$title."&s=all";
        $result = $browser->get($url);    
        
        /*$findList = explode('<table class="findList">', $result);
        $imageSrc = explode('<img src="', $findList[1]);
        $img = explode('"',$imageSrc[1]);
        $imageUrl = $img[0];
        //$image = $browser->get($imageUrl);
        $extension = end(explode('.', $imageUrl));
        $result = '';
        if ($extension == 'jpg'){
            $image = imagecreatefromjpeg($imageUrl);
            ob_start();
            imagejpeg($image);
            $imgContent = ob_get_clean();
            $tt = base64_encode($imgContent);
            $result = 'data:image/jpeg;base64,'.$tt;
        }else if ($extension == 'png'){
            $image = imagecreatefrompng($imageUrl);
            ob_start();
            imagepng($image);
            $imgContent = ob_get_clean();
            $tt = base64_encode($imgContent);
            $result = 'data:image/png;base64,'.$tt;
        }*/
        $typePattern = '/<td class="primary_photo"> <a href="([^"]*)/';
        preg_match($typePattern,$result,$detailUrl);
        $url = "http://www.imdb.com".$detailUrl[1];
        $result = $browser->get($url);
        
        $findList = explode('<div class="image">', $result);
        $imageSrc = explode('src="', $findList[1]);
        $image = explode('"', $imageSrc[1]);
        $imageUrl = $image[0];
        $extension = end(explode('.', $image[0]));
        $result = array();
        if ($extension == 'jpg'){
            $image = imagecreatefromjpeg($imageUrl);
            ob_start();
            imagejpeg($image);
            $imgContent = ob_get_clean();
            $tt = base64_encode($imgContent);
            $result['content'] = 'data:image/jpeg;base64,'.$tt;
        }else if ($extension == 'png'){
            $image = imagecreatefrompng($imageUrl);
            ob_start();
            imagepng($image);
            $imgContent = ob_get_clean();
            $tt = base64_encode($imgContent);
            $result['content'] = 'data:image/png;base64,'.$tt;
        }
        $result['url'] = $imageUrl;
        $result['title'] = $_GET["title"];
        echo json_encode($result);
        //echo $result;
        exit;
    }     
?>