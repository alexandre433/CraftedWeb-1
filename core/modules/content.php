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

    global $Database, $Plugins;
    $Database->selectDB("webdb");

    $pages = scandir('core/pages');
    unset($pages[0], $pages[1]);
    $page  = $Database->conn->escape_string($_GET['page']);

    if ( !isset($page) )
    {
        include "core/pages/home.php";
    }
    elseif ( isset($_SESSION['loaded_plugins_pages']) && DATA['website']['enable_plugins'] == true && !in_array($page . '.php', $pages) )
    {
        $Plugins->load("pages");
    }
    elseif ( in_array($page . ".php", $pages) )
    {
        $result = $Database->select("disabled_pages", "COUNT(filename) AS filename", null, "filename='$page'")->get_result();
        if ( $result->data_seek(0) == 1 )
        {
            include "core/pages/". $page .".php";
        }
        else
        {
            include "core/pages/404.php";
        }
    }
    else
    {
        $result = $Database->select("custom_pages", null, null, "filename='$page'")->get_result();
        if ( $result->num_rows > 0 )
        {
            $check = $Database->select("disabled_pages", "COUNT(filename) AS filename", null, "filename='$page'")->get_result();
            if ( $check->fetch_assoc()['filename'] == 0 )
            {
                $row = $result->fetch_assoc();
                echo html_entity_decode($row['content']);
            }
        }
        else
        {
            include "core/pages/404.php";
        }
    }
?>