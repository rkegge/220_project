<?php

require_once("../general/headerForFriendSearch.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["buttonValue"])) {
        $buttonValue = $_POST["buttonValue"];

        // if($_POST["articleImg"]){
        //     // hidden input - old vals
        //     $name = $_POST["articleName"];
        //     $img = $_POST["articleImg"];
        //     $email = $_POST["email"];
        //     $userName = $_POST["userName"];
        // }

        include '../../config.php';
        $instance = new Database();

        

        if ($buttonValue === "Rate and Review") {

            $articleName = $_POST["articleName"];
            $comment = $_POST["comment"];
            $rate = $_POST["rate"];
            

            // echo($listName);

            

            $instance->addComment($articleName, $comment, $rate);

        }

        if ($buttonValue === "Delete your article") {
            $name = $_POST["articleName"];
            $img = $_POST["articleImg"];
            $email = $_POST["email"];
            $userName = $_POST["userName"];
            $booktitle = $_POST["booktitle"];
            $author = $_POST["author"];

            $instance->deleteArticle($name);

        }
        
        if ($buttonValue === "Edit this article") {

            $name = $_POST["articleName"];
            $img = $_POST["articleImg"];
            $email = $_POST["email"];
            $userName = $_POST["userName"];
            $booktitle = $_POST["booktitle"];
            $author = $_POST["author"];
            

            echo'<link href="../../css/form-style.css" rel="stylesheet">';

            echo' <div style="text-align:center" class="article-form">
                    <form id="createArticle" method="post" action="validate-article.php">

                    <!-- Email -->
                    <div class="email">
                        <label for="email">Email</label>
                        <span id="email"></span>
                    </div>
                    <input class="style" type="text" id="email" name="email" value="'.$email.'" required>

                    <br/>


                    <!-- ArticleName -->
                    <div class="anf">
                        <label for="anf">Article Name</label>
                        <span id="errAName"></span>
                    </div>
                    <input class="style" type="text" id="anf" name="anf" value="'.$name.'" required>

                    <br/>



                    <!-- bt -->
                    <div class="bt">
                        <label for="bt">Book Title</label>
                        <span id="errbt"></span>
                    </div>
                    <input class="style" type="text" id="bt" name="bt" value="'.$booktitle.'" required>

                    <br/>

                    <!-- surname -->
                    <div class="Author_field">
                        <label for="Author">Author</label>
                        <span id="errAuthor"></span>
                    </div>
                    <input class="style" type="text" id="Author" name="Author" value="'.$author.'" required>

                    <br/>


                    <input class="style" type="hidden" id="Blurb" name="Blurb" class="longer" required>



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
                    <label for="Genre">Genre:</label>

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
                    <div class="description_field">
                        <label for="myFile">Cover</label>
                        <span id="myFile"></span>
                    </div>

                    <input type="file" id="myFile" name="filename">




                    <br/>
                    <input type="hidden" name="update" value="update">
                    <input type="hidden" name="oldname" value="'.$name.'">
                    <input type="hidden" name="userName" value="'.$userName.'">
                    <input id="submit" style="text-align: center; margin-bottom: 20px;" type="submit" value="Save!">

                </div></form>';

        }
    }
}

require_once("../general/footer.php");

?>
