<?php
// Require config file.
include "inc/config.php";
include "inc/helper.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>OpenFusion</title>
    <!-- Css -->
    <link rel="stylesheet" href="<?php echo '/css/style.css'?>"/>

    <!-- Scripts -->
    <script type="text/javascript" src="<?php echo '/js/unity.js'?>"></script>
</head>
<body onresize="OnResize()">
<div id="container">

    <!-- Server 2 client info exchange -->
    <script language="javascript" type="text/javascript">
        //allows us to skip the login screen
        function authDoCallback(param) {

            var unity = document.getElementById('Unity_embed');

            <?php
            // The resulting user info.
            $result = "";
            $username = "";
            $password = "";

            switch($LOGIN_TYPE) {

                case 0:
                    // Read the username from the cookie and get user server-side.
                    // Probably more secure than to store the password directly into the cookie.
                    if(isCookieSet($LOGIN_COOKIE_NAME)) {
                        // Now get the user info directly from the database.
                        $cookie_username = json_decode(getCookie($LOGIN_COOKIE_NAME), true);

                        // Only continue if the username is not empty.
                        if(isVariableSet($cookie_username)) {
                            $username = $cookie_username["username"];
                            $USER->setUserInfo($username, null, null);

                            // Now we've got it, send it to client.
                            $result = $USER->getUser();

                            // Assign the appropriate variables.
                            $password = $result["Password"];
                        }
                    }
                    // If we've set the remember me, go find the cookie for it
                    // and login through that.
                    else if(isCookieSet($REMEMBER_ME_COOKIE_NAME)) {
                        // Now get the user info directly from the database.
                        $cookie_selector = getCookie($REMEMBER_ME_COOKIE_NAME);


                        // Only continue if the username is not empty.
                        if(isVariableSet($cookie_selector)) {
                            $AUTH->selector = explode(":", $cookie_selector)[0];

                            if($AUTH->authTokenSelectorExists()) {
                                // Fetch the selector.
                                $result = $AUTH->getauthTokenBySelector();
                                $username = $result["UserId"];

                                $USER->setUserInfo($username, null, null);

                                // Now we've got it, send it to client.
                                $result = $USER->getUser();

                                // Assign the appropriate variables.
                                $password = $result["Password"];
                            }
                        }
                    }
                    break;
            }
            ?>

            <?php if($LOGIN_TYPE != 1) { ?>
            unity.SendMessage("GlobalManager", "SetTEGid", "<?php echo $username ?>");
            unity.SendMessage("GlobalManager", "SetAuthid", "<?php echo $password ?>");
            <?php } ?>
            unity.SendMessage("GlobalManager", "DoAuth", 0);


        }
    </script>

    <div id="client">
        <object classid="clsid:444785F1-DE89-4295-863A-D46C3A781394"
                codebase="undefined/UnityWebPlayer.cab#version=2,0,0,0" id="Unity_object" width="1264" height="661">
            <embed type="application/vnd.unity" pluginspage="http://www.unity3d.com/unity-web-player-2.x"
                   id="Unity_embed" width="1280" height="680" src="<?php echo $UNITY_FILE ?>"
                   disablecontdparaextmenu="true" bordercolor="000000" backgroundcolor="000000" textcolor="ccffff"
                   logoimage="img/unity_dexlabs.png" progressbarimage="img/unity_loadingbar.png"
                   progressframeimage="img/unity_loadingframe.png"
                   autoupdateurlsignature="42180ee5edc4e3d4dd706bcc17cedd8d6ec7b7ac463071fd34ab97fe181f1a78df31db5feb4526677e4f69ef53acaff44471591e68b87f041c80fd54765f0d5725b08aa28f5acf7716ffb2a04e971269f35925c7e38d57dd78f6a206530caaa3da7e32f07f19810efc0ebf29a4eae976a925ad9cc5beb4dd51564c67dc489033"
                   autoupdateurl="http://wp-cartoonnetwork.unity3d.com/ff/big/beta-20111013/autodownload_webplugin_beta"
                   disableContextMenu="true">
        </object>
    </div>
    <script type="text/javascript">
        OnResize(); // perfect fit, called after Unity_object is initialized
    </script>
</div>
</body>
</html>