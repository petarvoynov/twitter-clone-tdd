let textarea = document.querySelectorAll('.comment-area')
let commentButton = document.querySelectorAll('.comment-button');

for(let i = 0; i < textarea.length; i++){
    textarea[i].style.display = "none";
}

for(let i = 0; i < commentButton.length; i++){
    commentButton[i].addEventListener('click', function(e) {
        let id = e.target.id;
        let currentCommentAre = document.querySelector('#comment-area-' + id);
        if(currentCommentAre.style.display === 'none'){
            currentCommentAre.style.display = 'block';
        } else {
            currentCommentAre.style.display = 'none';
        }
    });
}
