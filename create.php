<?php
$page = 'create';

error_reporting(E_ALL);
ini_set('display_errors', 1);

?>

<?php require_once("./php/general/headerLoggedIn.php"); ?>

<link href="./css/form-style.css" rel="stylesheet">

<main>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
	

<link href="./css/form-style.css" rel="stylesheet">
<link href="./css/generalstyle.css" rel="stylesheet">
<link href="./css/index-style.css" rel="stylesheet">
<link href="./css/create-style.css" rel="stylesheet">

			
			<div style='text-align:center' class="article-form">
				<h2>Make your article!</h2>
				<p>We would <em>love</em> to help you write your article.</p>

				<form id="createArticle" method="post" action="./php/createArticle/validate-article.php">

					<!-- Email -->
	                <div class="email">
	                    <label for="email">Email</label>
	                    <span id="email"></span>
	                </div>
	                <input class="style" type="text" id="email" name="email" required>

	                <br/>


					<!-- ArticleName -->
	                <div class="anf">
	                    <label for="anf">Article Name</label>
	                    <span id="errAName"></span>
	                </div>
	                <input class="style" type="text" id="anf" name="anf" required>

	                <br/>



					<!-- bt -->
	                <div class="bt">
	                    <label for="bt">Book Title</label>
	                    <span id="errbt"></span>
	                </div>
	                <input class="style" type="text" id="bt" name="bt" required>

	                <br/>

	                <!-- surname -->
	                <div class="Author_field">
	                    <label for="Author">Author</label>
	                    <span id="errAuthor"></span>
	                </div>
	                <input class="style" type="text" id="Author" name="Author" required>

	                <br/>


	               	<!-- short blurb -->
	                <!-- <div class="Blurb_field">
	                    <label for="Description">Short Blurb</label>
	                    <span id="errDesc"></span>
	                </div> -->
	                <input class="style" type="hidden" id="Blurb" name="Blurb" class="longer" value="blurb" required>



	                <!-- description -->
	                <div class="description_field">
	                    <label for="Description">Your thoughts</label>
	                    <span id="errDesc"></span>
	                </div>
	                <input class="style" type="text" id="Description" name="Description" class="longer" required>



	                <!-- hashtags -->
	                <div class="hashtags">
	                    <label for="hashtags">Hashtags</label>
	                    <span id="errHashtags"></span>
	                </div>
	                <input class="style" type="text" id="hashtags" name="hashtags" required>

	                <br/>


					<!-- genre/category -->
	                <label for="Genre">Genre</label><br/>

			  		<select name="Genre" id="Genre">
			  				<option value="Thriller">Thriller</option>
			  				<option value="Romance">Romance</option>
			  				<option value="Comedy">Comedy</option>
			  				<option value="Fiction">Fiction</option>
			  				<option value="Science Fiction">Science Fiction</option>
			  				<option value="Action">Action</option>
			  				<option value="Other">Other</option>
					</select>



	                <!-- Cover -->
	                <!-- <div class="description_field">
	                    <label for="myFile">Cover</label>
	                    <span id="myFile"></span>
	                </div> -->

	                <!-- <input type="file" id="myFile" name="filename"> -->

					<div class="mb-3" id="picInput">
						<label for="formFile" class="form-label">Book Cover</label>
						<input class="form-control" type="file" id="myFile" name="filename">
					</div>




	                <br/>
	                <input id="submit" type="submit" value="Create Your Article!">

				</form>

				<div id="result"></div>
			</div>
			
		</main>

<?php require_once("./php/general/footer.php"); ?>