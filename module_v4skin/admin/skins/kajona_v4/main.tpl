<!DOCTYPE html>
<html lang="en">
<head>
    <!-- TODO: integrate locally -->
    <link href="http://fonts.googleapis.com/css?family=Dosis:500,700" rel="stylesheet">

    <meta charset="utf-8">
    <title>Kajona admin [%%webpathTitle%%]</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow" />
    <meta name="generator" content="Kajona, www.kajona.de" />

    <!--<link href="css/ui-lightness/jquery-ui-1.8.18.custom.css" rel="stylesheet">-->
    <!-- <link rel="stylesheet" href="_skinwebpath_/styles.css?_system_browser_cachebuster_" > -->

    <link href="_skinwebpath_/less/bootstrap.less?_system_browser_cachebuster_" rel="stylesheet/less">
    <link href="_skinwebpath_/less/responsive.less?_system_browser_cachebuster_" rel="stylesheet/less">
    <script> less = { env:'development' }; </script>
    <script src="_skinwebpath_/less/less.js"></script>

    <script src="_webpath_/core/module_system/admin/scripts/jquery/jquery.min.js?_system_browser_cachebuster_"></script>
    <script src="_webpath_/core/module_system/admin/scripts/yui/yuiloader-dom-event/yuiloader-dom-event.js?_system_browser_cachebuster_"></script>
    %%head%%
    <script src="_webpath_/core/module_system/admin/scripts/kajona.js?_system_browser_cachebuster_"></script>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="_skinwebpath_/js/html5.js?_system_browser_cachebuster_"></script>
    <![endif]-->

    <link rel="shortcut icon" href="_skinwebpath_/img/favicon.png">
    <!--
    <link rel="apple-touch-icon" href="_skinwebpath_/img/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="_skinwebpath_/img/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="_skinwebpath_/img/apple-touch-icon-114x114.png">
    -->
</head>

<body>

<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span4" style="padding:5px 0 0 10px;">

                    <!--%%tagSelector%%-->

                    %%login%%

                </div>
                <div class="span8" style="text-align: right;">
                    <form class="navbar-search pull-left">
                        <i id="icon-lupe"></i>
                        <input type="text" class="search-query" placeholder="Suchbegriff" id="globalSearchInput">
                    </form>
                    <select id="languageChooser" class="input-small">
                        <option>English</option>
                        <option>Deutsch</option>
                    </select>

                    %%aspectChooser%%

                    <button id="portaleditor">
                        Portaleditor
                        <i class="icon-share"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span2">&nbsp;</div>
            <div class="span10">
                %%path%%
                <!--
                <ul class="breadcrumb">
                    <li>
                        <a href="#"><i id="icon-home"></i></a> <span class="divider"></span>
                    </li>
                    <li>
                        <a href="#">Pages</a> <span class="divider"></span>
                    </li>
                    <li>
                        <a href="#">My first page</a> <span class="divider"></span>
                    </li>
                    <li class="active">
                        <a href="#">Second level page</a>
                    </li>
                </ul>
                -->
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row-fluid">

        <!-- MODULE NAVIGATION -->
        <div class="span2">
            <div class="well sidebar-nav">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <div class="pull-left">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </div>
                    <div class="pull-left">
                        Modules
                    </div>
                </a>
                <div class="nav-collapse">
                    %%moduleSitemap%%
                </div>
            </div>
        </div>



        <!-- CONTENT CONTAINER -->
        <div class="span10" id="content">

            <h1>%%moduletitle%%</h1>
            %%quickhelp%%

            %%content%%


        </div>
    </div>

    <hr>

    <footer>
        <p>powered by <a href="http://www.kajona.de/" target="_blank" title="Kajona - empowering your content">Kajona</a></p>
    </footer>

</div>



<script src="_skinwebpath_/js/jquery-ui-1.8.18.custom.min.js"></script>
<script src="_skinwebpath_/js/jquery.ui.touch-punch.min.js"></script>
<script src="_skinwebpath_/js/bootstrap-transition.js"></script>
<script src="_skinwebpath_/js/bootstrap-alert.js"></script>
<script src="_skinwebpath_/js/bootstrap-modal.js"></script>
<script src="_skinwebpath_/js/bootstrap-dropdown.js"></script>
<script src="_skinwebpath_/js/bootstrap-scrollspy.js"></script>
<script src="_skinwebpath_/js/bootstrap-tab.js"></script>
<script src="_skinwebpath_/js/bootstrap-tooltip.js"></script>
<script src="_skinwebpath_/js/bootstrap-popover.js"></script>
<script src="_skinwebpath_/js/bootstrap-button.js"></script>
<script src="_skinwebpath_/js/bootstrap-collapse.js"></script>
<script src="_skinwebpath_/js/bootstrap-carousel.js"></script>
<script src="_skinwebpath_/js/bootstrap-typeahead.js"></script>
<script src="_skinwebpath_/js/bootstrap-datepicker.js"></script>
<script src="_skinwebpath_/js/locales/bootstrap-datepicker.de.js"></script>

<script src="_skinwebpath_/js/jstree/jquery.cookie.js"></script>
<script src="_skinwebpath_/js/jstree/jquery.hotkeys.js"></script>
<script src="_skinwebpath_/js/jstree/jquery.jstree.js"></script>
<script src="_skinwebpath_/treedemo.js"></script>

<script>
    $(function () {
        function isTouchDevice() {
          return !!('ontouchstart' in window) ? 1 : 0;
        }

        $.widget('custom.catcomplete', $.ui.autocomplete, {
            _renderMenu: function(ul, items) {
                var self = this;
                var currentCategory = '';

                $.each(items, function(index, item) {
                    if (item.category != currentCategory) {
                        ul.append('<li class="ui-autocomplete-category"><h3>' + item.category + '</h3></li>');
                        currentCategory = item.category;
                    }
                    self._renderItem(ul, item);
                });

                ul.append('<li class="detailedResults"><a href="#">View detailed search results</a></li>');

                ul.addClass('dropdown-menu');
            },
            _renderItem: function (ul, item) {
                return $('<li></li>')
                    .data('item.autocomplete', item)
                    .append('<a>' + '<img src="http://placehold.it/40x40" alt="" class="pull-left"><h4 class="pull-left">' + item.label + '</h4><br>' + item.desc + '</a>')
                    .appendTo(ul);
            }
        });
        $('#globalSearchInput').catcomplete({
            source: '_skinwebpath_/search.json',
            select: function (event, ui) {
                alert( ui.item ?
                    "Selected: " + ui.item.value + " aka " + ui.item.label :
                    "Nothing selected, input was " + this.value );
            }
        });

        //sidebar responsive
        $('.nav-collapse').on('show', function () {
            var collapsible = $(this);
            window.setTimeout(function () {
                collapsible.css({
                    overflow: 'visible',
                    height: 'auto'
                });
            }, 500);
        });

        $('.nav-collapse').on('hide', function () {
            $(this).css('overflow', '');
        });




        $('#myModal1').on('show', function () {
            var $modal = $(this);
            var $progressbar = $modal.find('.progress > .bar');
            var progress = 0;

            var interval = window.setInterval(function () {
                progress += 10;
                $progressbar.css('width', progress + '%');

                if (progress >= 100) {
                    $modal.modal('hide');

                    window.clearInterval(interval);
                    $progressbar.css('width', '0%');
                }
            }, 1000);

        });


        // insert demo thumbnails
        var $thumb = $('.gallery li').first();
        for (var i = 2; i < 12; i++) {
            var $newThumb = $thumb.clone();
            $newThumb.find('.number').html(i);
            $('.gallery').append($newThumb);
        }

        // init drag&drop ordering for gallery
        $('.sortable').sortable({
            stop: function (event, data) {
                console.log('[sortable] stopped', arguments);
            },
            delay: isTouchDevice() ? 2000 : 0
        });
        $('.sortable').disableSelection();


        // init popovers & tooltips
        $('#content a[rel=popover]').popover();

        $('*[rel=tooltip]').tooltip();

    });

</script>
</body>
</html>