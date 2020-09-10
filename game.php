<!DOCTYPE html>
<html>
<head>
    <title>OpenFusion</title>
    <link rel="stylesheet" href="css/style.css"/>
    <script type="text/javascript" src="js/unity.js"></script>
</head>
<body onresize="OnResize()">
<div id="container">
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