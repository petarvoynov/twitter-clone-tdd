window.onload = function(){
    let notifications = document.querySelectorAll('.notification');

    for(let i = 0; i < notifications.length; i++){
        notifications[i].addEventListener('click', function(e){
            if(e.target.id){
                location.href = "/tweets/" + e.target.id;
            } else {
                location.href = "/tweets/" + e.target.parentNode.id;
            }
        });
    }
};
