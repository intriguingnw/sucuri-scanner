<?php
/* Sucuri Security - SiteCheck Malware Scanner
 * Copyright (C) 2010-2012 Sucuri Security - http://sucuri.net
 * Released under the GPL - see LICENSE file for details.
 */


if(!defined('SUCURISCAN'))
{
    return(0);
}

/* Sucuri WordPress Integrity page. */

function sucuriscan_core_integrity_function_wrapper($function_name, $description)
{
    echo '<div class="postbox">';
        echo '<div class="inside">';
        echo '<form action="" method="post">'.
                '<input type="hidden" name="'.$function_name.'nonce" value="'.wp_create_nonce($function_name.'nonce').'" />'.
                '<input type="hidden" name="'.$function_name.'" value="'.$function_name.'" />'.

                '<p>'.$description.'</p>'.
                '<input class="button-primary" type="submit" name="'.$function_name.'" value="Check">'.
            '</form>';
        echo '</div>';
    echo '</div>';

    if (isset($_POST[$function_name.'nonce']) && isset($_POST[$function_name])) {
        $function_name();
    }
}

function sucuriscan_core_integrity_lib()
{
        echo '<h2 id="warnings_hook"></h2>';
        echo '<div class="postbox-container" style="width:75%;">';
            echo '<div class="sucuriscan-maincontent">';

                echo '<div class="postbox">';
                   echo '<div class="inside">';
                       echo '<h2 align="center">Sucuri WordPress Integrity Checks</h2>';
                   echo '</div>';
                echo '</div>';

    include_once("lib/core_integrity.php");

    if(isset($_POST['wpsucuri-core-integrity']))
    {
        if(!wp_verify_nonce($_POST['sucuriscan_core_integritynonce'], 'sucuriscan_core_integritynonce'))
        {
            unset($_POST['wpsucuri-core_integrity']);
        }
    }

    ?>

        <div id="poststuff">

            <?php

                sucuriscan_core_integrity_function_wrapper(
                    'sucuriwp_core_integrity_check', 
                    'Check wp-include, wp-admin, and top directory files against the latest WordPress version.'
                    );
                sucuriscan_core_integrity_function_wrapper(
                    'sucuriwp_list_admins', 
                    'Check Administrator Users.'
                    );
                sucuriscan_core_integrity_function_wrapper(
                    'sucuriwp_content_check', 
                    'Check wp-content files modified in the past 3 days.'
                    );
                sucuriscan_core_integrity_function_wrapper(
                    'sucuriwp_check_plugins', 
                    'Check outdated active plugins in there.'
                    );
                sucuriscan_core_integrity_function_wrapper(
                    'sucuriwp_check_themes', 
                    'Check outdated themes in there.'
                    );
            ?>

        </div>

        <p align="center"><strong>If you have any questions about these checks or this plugin, contact us at support@sucuri.net or visit <a href="http://sucuri.net">Sucuri Security</a></strong></p>

    <?php
}
