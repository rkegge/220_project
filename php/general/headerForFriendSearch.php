<!DOCTYPE html>
<head>
		<title>
			KeyWords
		</title>
		<meta charset = "UTF-8" />
		<meta name = "author" content = "Rachel Kegge" />
		<meta name="description" content="Home page" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="http://imy.up.ac.za/u20426586/css/generalstyle.css" rel="stylesheet">
		<link href="http://imy.up.ac.za/u20426586/css/index-style.css" rel="stylesheet">
		<link href="http://imy.up.ac.za/u20426586/css/form-style.css" rel="stylesheet">

		<link rel="icon" type="image/x-icon" href="http://imy.up.ac.za/u20426586/favicon/favicon.ico">
</head>
<body>
		<header>
			<h1 id="title">KeyWords</h1>
			<nav>
				<ul>
					<?php
		                // Define $page as an empty string if it's not already set
		                if (!isset($page)) {
		                    $page = '';
		                }
		            ?>
		            <li><a href="http://imy.up.ac.za/u20426586/home.php" <?php if ($page == 'home') echo 'class="active"'; ?>>Home</a></li>
				</ul>
			</nav>
		</header>
		</main>
	</body>
</html>