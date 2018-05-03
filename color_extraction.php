<?php
function get_color($image_link){
        $h_or_w=50;
        $source_image = imagecreatefromjpeg($image_link);
        $width = imagesx($source_image);
        $height = imagesy($source_image);
        $thumbnail = imagecreatetruecolor($h_or_w,$h_or_w);
        imagecopyresampled($thumbnail, $source_image, 0, 0, 0, 0, $h_or_w, $h_or_w, $width, $height);
        $colours=array();
        for ($x=0;$x<$h_or_w;$x++) {
                for ($y=0;$y<$h_or_w;$y++) {
                        $rgb = imagecolorat($thumbnail,$x,$y);
                        $r   = ($rgb >> 16) & 0xFF;
                        $g   = ($rgb >> 8) & 0xFF;
                        $b   = $rgb & 0xFF;
                        if (($r<230 && $r>20) && ($g<230 && $g>20) && ($b<230 && $b>20)) {}
                        $r   = (ceil ($r/25)) * 25;
                        $g   = (ceil ($g/25)) * 25;
                        $b   = (ceil ($b/25)) * 25;
                        if (($r!=0 && $g!=0) || ($r!=0 && $b!=0) || ($g!=0 && $b!=0)) {
                                if (($r<250 && $r>5) && ($g<250 && $g>5) && ($b<250 && $b>5)) {
                                        $range_min=50;
                                        $range_max=200;
                                        if (($r<$range_min) || ($g<$range_min) || ($b<$range_min)) {
                                                $factor= (min($r,$g,$b)==0) ? 1 : $range_min/min($r,$g,$b) ;
                                                $r   = floor($r * $factor);
                                                $g   = floor($g * $factor);
                                                $b   = floor($b * $factor);
                                        }
                                        if (($r>$range_max) || ($g>$range_max) || ($b>$range_max)) {
                                                $factor=$range_max/max($r,$g,$b);
                                                $r   = floor($r * $factor);
                                                $g   = floor($g * $factor);
                                                $b   = floor($b * $factor);
                                        }
                                        array_push($colours,"$r,$g,$b");
                                }
                        }
                }
        }
        $array = array_diff($colours, ["0,0,0", "255,255,255"]);
        $c = array_count_values($array);
        $val = array_search(max($c), $c);
        return $val;
}

function lightest($rgb){
        $r_g_b=explode(',',$rgb);
        $factor=240/max($r_g_b[0],$r_g_b[1],$r_g_b[2]);
        $r_g_b[0]   = floor($r_g_b[0] * $factor);
        $r_g_b[1]   = floor($r_g_b[1] * $factor);
        $r_g_b[2]   = floor($r_g_b[2] * $factor);
        return $r_g_b[0].','.$r_g_b[1].','.$r_g_b[2];
}

function darkest($rgb){
        $r_g_b=explode(',',$rgb);
        $factor=15/min($r_g_b[0],$r_g_b[1],$r_g_b[2]);
        $r_g_b[0]   = floor($r_g_b[0] * $factor);
        $r_g_b[1]   = floor($r_g_b[1] * $factor);
        $r_g_b[2]   = floor($r_g_b[2] * $factor);
        return $r_g_b[0].','.$r_g_b[1].','.$r_g_b[2];
}
?>
