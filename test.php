<?php
//ob_end_flush(); //关闭php缓存，或者在flush()前先执行ob_flush()，下面有解释
echo str_pad(" ", 256);  
for ($i=5; $i>0; $i--) {  
   echo $i. '<br>';  
   flush();  
   sleep(1);   
}