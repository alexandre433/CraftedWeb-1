<?php
#   ___           __ _           _ __    __     _     
#  / __\ __ __ _ / _| |_ ___  __| / / /\ \ \___| |__  
# / / | '__/ _` | |_| __/ _ \/ _` \ \/  \/ / _ \ '_ \ 
#/ /__| | | (_| |  _| ||  __/ (_| |\  /\  /  __/ |_) |
#\____/_|  \__,_|_|  \__\___|\__,_| \/  \/ \___|_.__/ 
#
#		-[ Created by ©Nomsoft
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
#                  © Nomsoftware 'Nomsoft' 2011-2012. All rights reserved.    

    global $Account, $Website, $Database, $Character;

    $service  = $_GET['s'];
    $guid     = $Database->conn->escape_string($_GET['guid']);
    $realm_id = $Database->conn->escape_string($_GET['rid']);

    $service_title = ucfirst($service ." Change");

    $service_desc = array(
        'race'
        =>
        '<ul>
		<li>You can select a new character race only from those in the same faction that have the character’s class available. You cannot change a characters class.</li>
		<li>A character’s current home city reputation level will switch values with their new home city and their home city racial mounts will convert to those of their new race.</li>
		<li>A realm transfer is not included in a race change.</li>
	</ul>'
        ,
        'name'
        =>
        '<ul>
		<li>A name change can not be reversed once completed, except by a second name change operation (subject to the same costs and limitations).</li>
	</ul>'
        ,
        'appearance'
        =>
        '<ul>
		<li>This service lets you change your character’s gender, face, hair and skin color, hairstyle, name, and other cosmetic features determined by their race and gender combination. You cannot, however, change your character’s race or class.</li>
		<li>If you change the character’s name during this process, the name you choose must be available on the character’s realm.</li>
		<li>A Character Appearance Change cannot be reversed once completed.</li>
	</ul>'
        ,
        'faction'
        =>
        '<ul>
		<li>During this process, you will select a new character race from the opposite-faction races that have the character’s class available. You cannot change a character’s class.</li>
		<li>A realm transfer is not included in a faction change.</li>
	</ul>'
    );

    
    if ( DATA['service'][$service]['status'] != true )
    {
        echo "This page is currently unavailable.";
    }
    else
    {
        ?>
        <div class="box_two_title">Confirm <?php echo $service_title; ?></div>
        <?php
        if ( DATA['service'][$service]['price'] == 0 )
        {
            echo '<span class="attention">' . $service_title . ' is free of charge.</span>';
        }
        else
        { ?>
            <span class="attention"><?php echo $service_title; ?> costs 
                <?php echo DATA['service'][$service]['price'] . ' ' . $Website->convertCurrency(DATA['service'][$service]['currency']); ?></span>
                <?php
            if ( DATA['service'][$service]['currency'] == "vp" ) echo "<span class='currency'>Vote Points: " . $Account->loadVP($_SESSION['cw_user']) . "</span>";
            elseif (DATA['service'][$service]['currency'] == "dp") echo "<span class='currency'>" . DATA['website']['donation']['coins_name'] . ": " . $Account->loadDP($_SESSION['cw_user']) . "</span>";
        }

        $Account->isNotLoggedIn();

        $Database->selectDB("webdb");
        $result = $Database->select("realms", "name", null, "id=$realm_id")->get_result();
        $row    = $result->fetch_assoc();
        $realm  = $row['name'];

        $Database->realm($realm_id);

        $result = $Database->select("characters", null, null, "guid=$guid")->get_result();
        $row    = $result->fetch_assoc()
        ?>
        <h4>Selected character:</h4>
        <div class='charBox'>
            <table width="100%">
                <tr>
                    <td width="73">
                        <?php
                        if (!file_exists('styles/global/images/portraits/' . $row['gender'] . '-' . $row['race'] . '-' . $row['class'] . '.gif'))
                            echo '<img src="styles/' . DATA['template']['path'] . '/images/unknown.png" />';
                        else
                        {
                            ?>
                            <img src="styles/global/images/portraits/<?php echo $row['gender'] . '-' . $row['race'] . '-' . $row['class']; ?>.gif" border="none">
        <?php } ?>
                    </td>

                    <td width="160"><h3><?php echo $row['name']; ?></h3>
                        <?php echo $row['level'] . " " . $Character->getRace($row['race']) . " " . $Character->getGender($row['gender']) .
                        " " . $Character->getClass($row['class']);
                        ?>
                    </td>

                    <td>Realm: <?php echo $realm; ?>
        <?php if ($row['online'] == 1)
            echo "<br/><span class='red_text'>Please log out before applying this service.</span>";
        ?>
                    </td>
                </tr>                         
            </table>
        </div> 
        <p/>&nbsp;
        <h4>Conditions and Disclaimers</h4>
        <?php
        echo $service_desc[$service];
        ?>
        <input type="submit" value="Agree & Continue" 
               <?php if ($row['online'] == 0)
               { ?> 
                   onclick='confirmService(<?php echo $row['guid']; ?>,<?php echo $realm_id; ?>, "<?php echo $service; ?>", "<?php echo $service_title; ?>"
                                   , "<?php echo $row['name']; ?>")' <?php }
    else
    {
        echo 'disabled="disabled"';
    }
    ?>>
        <?php
    }
?>
