<?php

include_once('config.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">


    <title>Property Search</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/main.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?php echo $site_custom_css ?>" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $site_mapsAPIKey?>" type="text/javascript"></script>

</head>

<body>
<input type="hidden" id='property-data' value='<?php  echo urlencode($property_search->getPropertyJson());?>'>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo $site_url ?>">
                <img src="<?php echo $site_logo ?> " height="<?php echo  $site_logo_h?>" width="<?php echo $site_logo_w?>">
            </a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class=""><a href="<?php echo $site_url ?>/about"><?php echo $site_name ?></a></li>
               
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container-fluid main-container">
    <!--Filter Variables-->
    <div class="filter-inputs">
    <input type="hidden" id="sort" value="<?php print (isset($_GET['sort'])?$_GET['sort']:'' )?>">
    <input type="hidden" id="beds"  value="<?php print (isset($_GET['beds'])?$_GET['beds']:'' )?>">
    <input type="hidden" id="baths"  value="<?php print (isset($_GET['baths'])?$_GET['baths']:'' )?>">
    <input type="hidden" id="type" value="<?php print (isset($_GET['type'])?$_GET['type']:'' )?>">
    <input type="hidden" id="price_min" value="<?php print (isset($_GET['price_min'])?$_GET['price_min']:'' )?>">
    <input type="hidden" id="price_max"  value="<?php print (isset($_GET['price_max'])?$_GET['price_max']:'' )?>">
    </div>
    <div class="starter-template">
        <div class="row search-row">
            <div class="col-md-4 ">
                <form id="search-form">
                <div class="input-group">

                    <input id="search-input" type="text" class="form-control" placeholder="Address, city, zip, neighborhood" aria-describedby="basic-addon1">
                    <span class="input-group-btn">
                        <button class="btn btn-default" id="search-button">Search</button>
                    </span>

                </div>
                </form>
            </div>
            <div class="col-md-8">
                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Any Price <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu filter-dropdown" data-rel="price">
                        <li><a data-rel=""  href="#">Any</a></li>
                        <li role="separator" class="divider"></li>
                        <li class="long-option">
                            <div clas="row">
                                <div class="col-md-5 text-right">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-addon" id="sizing-addon3">$</span>
                                        <input id="price-min" type="text" class="form-control" placeholder="Min Price" aria-describedby="sizing-addon3">
                                    </div>
                                </div>
                                <div class="col-md-2 text-center">-</div>
                                <div class="col-md-5 text-left">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-addon" id="sizing-addon3">$</span>
                                        <input id="price-max" type="text" class="form-control" placeholder="Max Price" aria-describedby="sizing-addon3">
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>


                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Any Beds <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu filter-dropdown" data-rel="beds">
                        <li><a data-rel=""  href="#">Any</a></li>
                        <li><a data-rel="0" href="#">Sudio</a></li>
                        <li><a data-rel="1" href="#">1+</a></li>
                        <li><a data-rel="2" href="#">2+</a></li>
                        <li><a data-rel="3" href="#">3+</a></li>
                        <li><a data-rel="4" href="#">4+</a></li>
                        <li><a data-rel="5" href="#">5+</a></li>

                    </ul>
                </div>

                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Any Baths <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu filter-dropdown" data-rel="baths">
                        <li><a data-rel="" href="#">Any</a></li>
                        <li><a data-rel="1" href="#">1+</a></li>
                        <li><a data-rel="2" href="#">2+</a></li>
                        <li><a data-rel="3" href="#">3+</a></li>
                        <li><a data-rel="4" href="#">4+</a></li>
                        <li><a data-rel="5" href="#">5+</a></li>
                    </ul>
                </div>

                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Any Types <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu filter-dropdown" data-rel="type">
                        <li><a data-rel="" href="#">Any</a></li>
                        <li><a data-rel="studio" href="#">Studio</a></li>
                        <li><a data-rel="apartment" href="#">Apartment</a></li>
                        <li><a data-rel="town house" href="#">Town House</a></li>
                        <li><a data-rel="detached house" href="#">Deatached House</a></li>

                    </ul>
                </div>
           </div>
        </div>
        <div class="row full-height-container">
            <div class="col-md-9 full-height"><div id="map"></div> </div>
            <div class="col-md-3 full-height property-column" >
                <div class="row results-head">
                   <div class="col-md-5 ">
                       <div class="text-left property-count-container"><span class="property-count badge"><?php  echo count( $property_search->getProperties())?></span> Properties found.</div>
                   </div>
                    <div class="col-md-7 text-right">

                        <div class="dropdown">
                            Sort By

                            <button class="btn-sm btn btn-default dropdown-toggle" type="button" id="sortDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                New
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" id="sort-list" aria-labelledby="sortDropdown" data-rel="sort">
                                <li><a href="#" data-rel="new">New</a></li>
                                <li><a href="#" data-rel="low">Price low to high</a></li>
                                <li><a href="#" data-rel="high">Price high to low</a></li>
                            </ul>
                        </div>


                    </div>
                </div>
                <div id="properties-results">
                    <?php  echo $property_search->getPropertiesHTML( )?>
                </div>
            </div>
        </div>


    </div>

</div><!-- /.container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="css/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="js/ie10-viewport-bug-workaround.js"></script>
<script src="js/main.js"></script>
</body>
</html>
