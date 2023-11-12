function loadArticle(articleWriterEmail, articleWriterApi, AWPhoto, currentUser, photo, name, date, author, articleWriter, booktitle, description, genre, hashtags) {
    
    // console.log("IN loadArticle with " + name);
    // console.log("photo " + photo);
    // console.log("AWPhoto " + AWPhoto);
    // console.log("articleWriter " + articleWriter);
    // console.log("currentUser " + currentUser);

    const chatHistory = document.querySelector('.aroundAll');
    chatHistory.innerHTML = '';
    
    // Create a Bootstrap row
    const row = document.createElement('div');
    row.classList.add('row');
    // row.style = 'hover: none';
    row.style.width = "100vw";
    
    // Create a Bootstrap column for the image
    const imageColumn = document.createElement('div');
    imageColumn.classList.add('col-md-6'); // Adjust the column size as needed
    imageColumn.style.textAlign = "center";
    imageColumn.style.paddingLeft = "120px";
    
    // Create an image element for the article
    const img = document.createElement('img');
    img.classList.add('img-fluid', 'rounded', 'mx-auto'); // Add the Bootstrap image class
    img.src = "http://imy.up.ac.za/u20426586/img/bk/" + photo;
    img.alt = name;
    img.style.width = "50%";
    img.style.height = "50%";
    
    // Append the image to the image column
    imageColumn.appendChild(img);


    
    // Create a Bootstrap column for the text
    const textColumn = document.createElement('div');
    textColumn.classList.add('col-md-6'); // Adjust the column size as needed
    textColumn.style.paddingRight = "200px";



    // Create a container for the image and text
    const imageTextContainer = document.createElement('div');
    imageTextContainer.classList.add('d-flex', 'align-items-center'); // Add d-flex and align-items-center classes
    textColumn.style.paddingTop = "40px";

    // Create a <a> tag to wrap the round user photo
    const userPhotoLink = document.createElement('a');

    const userName = articleWriterApi;

    userPhotoLink.href = `http://imy.up.ac.za/u20426586/php/general/userView.php?user=${userName}`;


    // Create a round user photo
    const userPhoto = document.createElement('img');
    userPhoto.classList.add('user-photo');
    userPhoto.src = "http://imy.up.ac.za/u20426586/img/" + AWPhoto;
    userPhoto.alt = currentUser;
    userPhoto.style.width = "180px";
    userPhoto.style.height = "180px";
    userPhoto.style.borderRadius = "50%"; // To make it round

    // Append the user photo to the <a> tag
    userPhotoLink.appendChild(userPhoto);

    // Create a <h2> element for the username
    const h2Name = document.createElement('h2');
    h2Name.textContent = articleWriter;
    h2Name.style.paddingLeft = "50px";

    // Append the user photo and username to the imageTextContainer
    imageTextContainer.appendChild(userPhotoLink);
    imageTextContainer.appendChild(h2Name);

    textColumn.appendChild(imageTextContainer);

    // Create a card element for the text
    const card = document.createElement('div');
    card.classList.add('card');
    
    // Create the card body
    const cardBody = document.createElement('div');
    cardBody.classList.add('card-body');
    
    // Create an h2 element with the name
    const h2 = document.createElement('h2');
    h2.classList.add('card-title');
    h2.textContent = name;
    
    // Create a paragraph for the article details
    const details = document.createElement('p');
    details.classList.add('card-text');
    details.innerHTML = `
        <strong>Date:</strong> ${date}<br>
        <strong>Author:</strong> ${author}<br>
        <strong>Article Writer:</strong> ${articleWriter}<br>
        <strong>Book Title:</strong> ${booktitle}<br>
        <strong>Description:</strong> ${description}<br>
        <strong>Genre:</strong> ${genre}<br>
    `;
    
    const hashtagLink = document.createElement('a');
    hashtagLink.href = 'javascript:void(0);';
    hashtagLink.textContent = `${hashtags}`;

    // click event listener to the hashtag link
    hashtagLink.addEventListener('click', function() {
        // Handle the click event, sending the hashtag to search.php
        window.location.href = `http://imy.up.ac.za/u20426586/php/general/search.php?hashtags=${encodeURIComponent(hashtags)}`;
    });

    details.appendChild(hashtagLink);
    

    // Append the h2 and details to the card body
    cardBody.appendChild(h2);
    cardBody.appendChild(details);
    
    // Append the card body to the card
    card.appendChild(cardBody);
    
    // Append the card to the text column
    textColumn.appendChild(card);
    
    // Append the image column and text column to the row
    row.appendChild(imageColumn);
    row.appendChild(textColumn);
    
    // Append the row to the chatHistory
    chatHistory.appendChild(row);

    if(currentUser == articleWriterApi){
        // console.log("loading loadOwnArt");
        loadOwnArt(articleWriterEmail, name, articleWriter, genre, photo, booktitle, author);
    }
    

    // TODO - display comments
    loadComments(name, currentUser);

    // console.log("current: " + currentUser + " writer: " + articleWriterApi);
    
    
}

function loadOwnArt(articleWriterEmail, name, articleWriter, genre, photo, booktitle, author){

    // console.log("in loadOwnArt");

    const chatHistory = document.querySelector('.aroundAll');

    // Create the form element
    const editArtForm = document.createElement('form');
    editArtForm.id = 'editArt';
    editArtForm.method = 'post';
    editArtForm.action = 'http://imy.up.ac.za/u20426586/php/createArticle/home.php';

    // Create hidden input fields
    const emailInput = document.createElement('input');
    emailInput.type = 'hidden';
    emailInput.name = 'email';
    emailInput.value = articleWriterEmail;

    const bk = document.createElement('input');
    bk.type = 'hidden';
    bk.name = 'booktitle';
    bk.value = booktitle;

    const auth = document.createElement('input');
    auth.type = 'hidden';
    auth.name = 'author';
    auth.value = author;

    const userNameInput = document.createElement('input');
    userNameInput.type = 'hidden';
    userNameInput.name = 'userName';
    userNameInput.value = articleWriter;

    const articleNameInput = document.createElement('input');
    articleNameInput.type = 'hidden';
    articleNameInput.name = 'articleName';
    articleNameInput.value = name;

    const articleImgInput = document.createElement('input');
    articleImgInput.type = 'hidden';
    articleImgInput.name = 'articleImg';
    articleImgInput.value = photo;

    const articleGenreInput = document.createElement('input');
    articleGenreInput.type = 'hidden';
    articleGenreInput.name = 'articleGenre';
    articleGenreInput.value = genre;

   // Create a container for the buttons
    const buttonContainer = document.createElement('div');
    buttonContainer.classList.add('button-container');
    buttonContainer.style.display = 'flex';
    buttonContainer.style.paddingLeft = '750px';

    // Create a edit button
    const submitButton = document.createElement('input');
    submitButton.id = 'editArt';
    submitButton.type = 'submit';
    submitButton.name = 'buttonValue';
    submitButton.value = 'Edit this article';
    

    // Create a delete button
    const deleteButton = document.createElement('input');
    deleteButton.id = 'deleteArt';
    deleteButton.type = 'submit';
    deleteButton.name = 'buttonValue';
    deleteButton.value = 'Delete your article';

    // Append the buttons to the button container
    buttonContainer.appendChild(submitButton);
    buttonContainer.appendChild(deleteButton);

    // Append the input fields and the button container to the form
    editArtForm.appendChild(emailInput);
    editArtForm.appendChild(bk);
    editArtForm.appendChild(auth);
    editArtForm.appendChild(userNameInput);
    editArtForm.appendChild(articleNameInput);
    editArtForm.appendChild(articleImgInput);
    editArtForm.appendChild(articleGenreInput);
    editArtForm.appendChild(buttonContainer);

    // Append the form to your document or a specific location as needed
    chatHistory.appendChild(editArtForm);


}

function loadRate(articleName, currentUser) {
    const chatHistory = document.querySelector('.aroundAll');


         // Create and append the rating and review form
        const form = document.createElement('form');
        form.id = 'rateAndReview';
        form.method = 'post';
        form.action = 'http://imy.up.ac.za/u20426586/php/createArticle/home.php';
        form.style.paddingTop='50px';

        // Add hidden input fields
        const apiInput = document.createElement('input');
        apiInput.type = 'hidden';
        apiInput.name = 'api';
        apiInput.value = currentUser;
        form.appendChild(apiInput);

        const articleNameInput = document.createElement('input');
        articleNameInput.type = 'hidden';
        articleNameInput.name = 'articleName';
        articleNameInput.value = articleName;
        form.appendChild(articleNameInput);

        // Create a label and input for leaving a comment
        const commentLabel = document.createElement('label');
        commentLabel.textContent = 'Leave a comment';
        form.appendChild(commentLabel);

        const commentInput = document.createElement('input');
        commentInput.classList.add('style');
        commentInput.type = 'text';
        commentInput.id = 'comment';
        commentInput.name = 'comment';
        commentInput.required = true;
        commentInput.style.marginLeft = "20px";
        form.appendChild(commentInput);

        // Create a label and input for leaving a comment
        const rateLabel = document.createElement('label');
        rateLabel.textContent = 'Rate';
        rateLabel.style.marginLeft = "30px";
        form.appendChild(rateLabel);

        const starRatingSelect = document.createElement('select');
        starRatingSelect.id = 'rate';
        starRatingSelect.name = 'rate';
        starRatingSelect.required = true;
        starRatingSelect.style.width = "180px";
        starRatingSelect.style.marginLeft = "30px";

        // Create and append the star rating options
        for (let i = 1; i <= 5; i++) {
        const option = document.createElement('option');
        option.value = i;
        option.text = `${i} star${i > 1 ? 's' : ''}`;
        starRatingSelect.appendChild(option);
        }

        form.appendChild(starRatingSelect);

        const lineBreak = document.createElement('br');
        form.appendChild(lineBreak);


        // Create the submit button
        const submitButton = document.createElement('input');
        submitButton.id = 'rateAndReviewsub';
        submitButton.type = 'submit';
        submitButton.name = 'buttonValue';
        submitButton.value = 'Rate and Review';
        submitButton.style.width = "1200px";


        form.appendChild(submitButton);

        // console.log(form);

        chatHistory.appendChild(form);
}


function loadComments(articleName, currentUser) {
    fetch('http://imy.up.ac.za/u20426586/getComments.php?articleName=' + articleName)
        .then(response => response.json())
        .then(data => {
            // console.log(data.comments);
            const comments = data.comments;
            const chatHistory = document.querySelector('.aroundAll');
            const commentsContainer = document.createElement('div');
            commentsContainer.style.backgroundColor='#b8d0de';
            commentsContainer.style.textAlign='center';
            commentsContainer.style.width='80%';
            commentsContainer.style.borderRadius = '10px';
            commentsContainer.style.marginLeft = '220px';
            commentsContainer.style.padding = '50px';

            // Create a heading for comments
            const commentsHeading = document.createElement('h1');
            commentsHeading.textContent = 'Comments';
            commentsHeading.style.color='#6d98bd';

            commentsContainer.appendChild(commentsHeading);

            // Loop through comments and create elements for each
            comments.forEach(comment => {
                // Create a container div for each comment
                const commentContainer = document.createElement('div');
                commentContainer.classList.add('comment-container');
                commentContainer.style.display = 'flex';
                commentContainer.style.paddingBottom='35px';

                // Add the user photo
                const userPhoto = document.createElement('img');
                userPhoto.classList.add('user-photo');
                userPhoto.src = "http://imy.up.ac.za/u20426586/img/" + comment.photo;
                userPhoto.alt = currentUser;
                userPhoto.style.width = "50px";
                userPhoto.style.height = "50px";
                userPhoto.style.borderRadius = "50%";
                commentContainer.appendChild(userPhoto);

                // Add the rating and review
                const commentElement = document.createElement('div');
                commentElement.classList.add('comment');
                commentElement.textContent = comment.review + " " +  comment.rate + "/5";
                commentElement.style.paddingLeft='25px';
                commentContainer.appendChild(commentElement);

                // Append the comment container to the commentsContainer
                commentsContainer.appendChild(commentContainer);
            });

            chatHistory.appendChild(commentsContainer);

            loadRate(articleName, currentUser);
        })
        .catch(error => {
            console.error('Error fetching comments:', error);
        });

        

        

}
