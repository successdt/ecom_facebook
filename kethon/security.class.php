<?php
/*
Code by : Nguyen Anh Duc
 Photoshop by:Ho Thuong Tham
 We are best friend
*/
class security
{
function is_secure($string)
            {
            $pattern = "#[^0-9_\-]#";
                if(preg_match($pattern,$string)==true)return false;
                        else
                        return true;
                }            
}
?> 
