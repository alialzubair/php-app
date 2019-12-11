<?php

require  'init.php';

$page='';

$page=isset($_GET['page'])? $_GET['page'] :'manage';

if($page=='manage'):
	
	 echo 'this is manage Servies page';


	

elseif($page=='create'):
	echo  'create page';


elseif($page=='store'):
	echo  'stroe page';


elseif($page=='edit'):
	echo  'edit page';


elseif($page=='update'):
	echo  'upade page';


elseif($page=='delete'):
	echo  'delete page';

else:
   ?>
      <h1 class="text-danger pl-4">404</h1>
   <?php
endif;



?>