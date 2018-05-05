<?php
#   ___           __ _           _ __    __     _     
#  / __\ __ __ _ / _| |_ ___  __| / / /\ \ \___| |__  
# / / | '__/ _` | |_| __/ _ \/ _` \ \/  \/ / _ \ '_ \ 
#/ /__| | | (_| |  _| ||  __/ (_| |\  /\  /  __/ |_) |
#\____/_|  \__,_|_|  \__\___|\__,_| \/  \/ \___|_.__/ 
#
#		-[ Created by �Nomsoft
#		  `-[ Original core by Anthony (Aka. CraftedDev)
#
#				-CraftedWeb Generation II-                  
#			 __                           __ _   							   
#		  /\ \ \___  _ __ ___  ___  ___  / _| |_ 							   
#		 /  \/ / _ \| '_ ` _ \/ __|/ _ \| |_| __|							   
#		/ /\  / (_) | | | | | \__ \ (_) |  _| |_ 							   
#		\_\ \/ \___/|_| |_| |_|___/\___/|_|  \__|	- www.Nomsoftware.com -	   
#                  The policy of Nomsoftware states: Releasing our software   
#                  or any other files are protected. You cannot re-release    
#                  anywhere unless you were given permission.                 
#                  � Nomsoftware 'Nomsoft' 2011-2012. All rights reserved.    


    require('includes/loader.php'); //Load all php scripts
?>
<!DOCTYPE>
<html>
    <head>
        <?php require('includes/template_loader.php'); ?>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
        <title>
            <?php
                echo $website_title .' - ';

                while ($page_title = current($GLOBALS['core_pages']))
                {
                    if ($page_title == $_GET['p'] . '.php')
                    {
                        echo key($GLOBALS['core_pages']);
                        $foundPT = true;
                    }
                    next($GLOBALS['core_pages']);
                }
                if (!isset($foundPT))
                {
                    echo ucfirst($_GET['p']);
                }
            ?>
        </title>

        <?php
            $content = new Page('styles/' . $template['path'] . '/template.html');
            $content->loadCustoms(); //Load custom modules

            $content->replace_tags(array('content' 		=> 'modules/content.php')); //Main content 
            $content->replace_tags(array('menu' 		=> 'modules/menu.php'));
            $content->replace_tags(array('login' 		=> 'modules/login.php'));
            $content->replace_tags(array('account' 		=> 'modules/account.php'));
            $content->replace_tags(array('serverstatus' => 'modules/server_status.php'));
            $content->replace_tags(array('slideshow' 	=> 'modules/slideshow.php'));
            $content->replace_tags(array('footer' 		=> 'modules/footer.php'));
            $content->replace_tags(array('loadjava' 	=> 'includes/javascript_loader.php'));
            $content->replace_tags(array('social' 		=> 'modules/social.php'));
            $content->replace_tags(array('alert' 		=> 'modules/alert.php'));
        ?>
    </head>

    <body>
        <?php
            $content->output();
        ?>
    </body>
</html>