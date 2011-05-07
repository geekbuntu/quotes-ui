<?php 

if (isset($_GET['do']))     {
	$page = $_GET['do']; 
	} else {
	// homepage
	$page = "home";
	// $page = "Error";
}

function mongoConnect() {
	$con = new Mongo("mongodb://web:web@localhost"); //readonly account
    $m = $con->selectDB('test_site'); // Connect to Database
	return $m;
}

//get cursor/select database
$db = mongoConnect();
$collection = $db->site_content;

// create the page
$query = array( "url" => $page );
$content = $collection->find( $query );

foreach ($content as $obj) {	
	$title = $obj["title"] . "\n";
	$content = $obj["content"] . "\n";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset=utf-8>
<title>Quotes-ui</title>
<meta name="keywords" content="" />
<meta name="description" content="" />

<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<!-- this is an external javascript allowing html5 to run in older browsers -->

<link rel="stylesheet" type="text/css" href="css/reset.css" media="screen" title="html5doctor.com Reset Stylesheet" />
<link rel="stylesheet" type="text/css" href="css/site.css" media="screen" />

</head>
<body>
<div class="contentwidth">
    <header>
        <div class="logo left">Quotes-ui</div>

        <div class="clear"></div>
        <nav>
        	<ul>		
			<?php
				//build nav	//eventually build main nav here - sub nav to pages within or with jq?			
				$cursor = $collection->find();	

				echo "<li class='active'><a href='{$_SERVER['PHP_SELF']}?do=home'>Home</a></li>";
				foreach ($cursor as $list) {
					if ($list['url'] != 'home') {
						$list_id =  $list["_id"]; //eventually want queued by _id/maybe...
						$list_url =  $list["url"];
						$list_title = $list["title"];
						echo "<li><a href='{$_SERVER['PHP_SELF']}?do=$list_url'>$list_title</a></li>";
					}
				}
				//nav end
			?>
            </ul>
        </nav>
        <div id="teaser1"><p>random quote</p></div>
        <div id="teaser2"><img src="images/boxplusone.png" alt="quotes-ui" width="350"  height="208">   </div>
    </header>
</div>
    <div class="clear"></div>
<div class="contentwidth">
    <aside id="asidecolumn">
    <h2>Sidebits</h2>
        <h3>side panel</h3>
        <p>
		author search/see wireframe
        </p>
        <h3>Archives</h3>
			<ul>
            	<li><a href="#">Month</a></li>
            </ul>
    </aside>
    <section id="maincolumn">
    <?php echo '<h2>' . $title . '</h2>'; ?>
    <h3>Site tagline</h3>
        <p><?php echo '<p>' . $content . '</p>'; ?></p>
    </section>
</div>
<footer class="contentwidth">
<hr>
    <p>&copy; www.feedtheguru.com <?php echo date('Y'); ?></p>
</footer>
</body>
</html>
