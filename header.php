<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>FoRUM</title>
    <meta content="Matthew Webber" name="author">
    <meta content="Pie Chart Programming Project" name="description">
    <link rel="stylesheet" type="text/css" href="../styles/main.css">
</head>
<body>
	<div class="container">
		<header>
			<span class="left">
				<ul>
					<li><h1><a href="index.php">Converter</a></h1></li>
					<li>
					    <form action="/index.php?page=search" method="get">
                            <input type="text" name="params" placeholder="searchtext"></input>
                            <input type="submit" value="search"/>
					    </form>
					</li>
				</ul>
			</span>
			<span class="right login">
				<?php
					if(isset($_SESSION['username'])) {
						echo $_SESSION['username'];
						echo '<form action="/index.php?page=logout" method="post">
							  <input type="submit" value="Logout"/>
							  </form>';
					} else {
					echo '<form action="/index.php?page=login" method="post">
							  <input type="text" name="username" placeholder="username"></input>
							  <input type="password" name="password" placeholder="password"></input>
							  <input type="submit" value="Login"/>
						  </form>
						<br><a href="register.php"><button>Register</button></a>';
					}
				?>
			</span>
		</header