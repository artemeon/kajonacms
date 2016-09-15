<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Kajona admin [%%webpathTitle%%]</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow" />
    <meta name="generator" content="Kajona, www.kajona.de" />

    <link rel="stylesheet" href="_webpath_/[webpath,module_system]/admin/scripts/jqueryui/css/smoothness/jquery-ui.custom.css?_system_browser_cachebuster_" type="text/css" />
    <link rel="stylesheet" href="_webpath_/[webpath,module_system]/admin/scripts/qtip2/jquery.qtip.min.css?_system_browser_cachebuster_" type="text/css" />

    <!-- KAJONA_BUILD_LESS_START -->
    <link href="_webpath_/[webpath,module_v4skin]/admin/skins/kajona_v4/less/bootstrap.less?_system_browser_cachebuster_" rel="stylesheet/less">
    <!--<script> less = { env:'development' }; </script>-->
    <script src="_webpath_/[webpath,module_v4skin]/admin/skins/kajona_v4/less/less.min.js"></script>
    <!-- KAJONA_BUILD_LESS_END -->

    %%head%%

    <!-- BC layer while moving to requirejs -->
    <script src="_webpath_/[webpath,module_system]/admin/scripts/jquery/jquery.min.js?_system_browser_cachebuster_"></script>
    <script src="_webpath_/[webpath,module_system]/admin/scripts/jqueryui/jquery-ui.custom.min.js?_system_browser_cachebuster_"></script>
    <script src="_webpath_/[webpath,module_system]/system/scripts/loader.js?_system_browser_cachebuster_"></script>
    <script src="_webpath_/[webpath,module_system]/admin/scripts/kajona.js?_system_browser_cachebuster_"></script>
    <!-- BC layer -->

    <script type="text/javascript">var searchExtendText = '[lang,search_details,search]';</script>
    <script type="text/javascript">
        var require = %%requirejs_conf%%;

        // BC layer so that we fire document ready events only after requirejs has loaded all js files
        $.holdReady(true);
    </script>
    <script data-main="core/module_system/admin/scripts/app" src="_webpath_/[webpath,module_system]/admin/scripts/requirejs/require.js"></script>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="_webpath_/[webpath,module_v4skin]/admin/skins/kajona_v4/js/html5.js?_system_browser_cachebuster_"></script>
    <![endif]-->

    <link rel="shortcut icon" href="_webpath_/[webpath,module_v4skin]/admin/skins/kajona_v4/img/favicon.png">
</head>

<body class="dialogBody">

<div class="container-fluid">
    <div class="row">

        <!-- CONTENT CONTAINER -->
        <div id="content" class="col-md-12">
            %%content%%
        </div>
    </div>
</div>

<!-- folderview container -->
<div class="modal fade" id="folderviewDialog" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 id="folderviewDialog_title" class="modal-title">BROWSER</h3>
            </div>
            <div class="modal-body">
                <div id="folderviewDialog_loading" class="loadingContainer loadingContainerBackground"></div>
                <div id="folderviewDialog_content"><!-- filled by js --></div>
            </div>
        </div>
    </div>
</div>

<!-- modal dialog container -->
<div class="modal fade" id="jsDialog_0">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 id="jsDialog_0_title"><!-- filled by js --></h3>
            </div>
            <div class="modal-body" id="jsDialog_0_content">
                <!-- filled by js -->
            </div>
        </div>
    </div>
</div>

<!-- confirmation dialog container -->
<div class="modal fade" id="jsDialog_1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 id="jsDialog_1_title"><!-- filled by js --></h3>
            </div>
            <div class="modal-body" id="jsDialog_1_content">
                <!-- filled by js -->
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-default" data-dismiss="modal" id="jsDialog_1_cancelButton">[lang,dialog_cancelButton,system]</a>
                <a href="#" class="btn btn-default btn-primary" id="jsDialog_1_confirmButton">confirm</a>
            </div>
        </div>
    </div>
</div>

<!-- loading dialog container -->
<div class="modal fade" id="jsDialog_3">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="jsDialog_3_title">%%dialog_title%%</h3>
            </div>
            <div class="modal-body">
                <div id="dialogLoadingDiv" class="loadingContainer loadingContainerBackground"></div>
                <div id="jsDialog_3_content"><!-- filled by js --></div>
            </div>
        </div>
    </div>
</div>

<!-- raw dialog container -->
<div class="modal" id="jsDialog_2">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div id="jsDialog_2_content"><!-- filled by js --></div>
            </div>
        </div>
    </div>
</div>

<div id="jsStatusBox" class="" style="display: none; position: absolute;"><div class="jsStatusBoxHeader">Status-Info</div><div id="jsStatusBoxContent" class="jsStatusBoxContent"></div></div>

</body>
</html>