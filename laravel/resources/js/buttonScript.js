//Get the button
var mybutton = document.getElementById("myBtn");
// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {
    scrollFunction();
};

function scrollFunction() {
    
    if (
        document.body.scrollTop > 700 ||
        document.documentElement.scrollTop > 700
    ) {
        
        mybutton.classList.add('visible');
        mybutton.classList.remove('oculto');
        console.log(mybutton.classList);
    } else {
        
        mybutton.classList.remove('visible');
        mybutton.classList.add('oculto');
        // mybutton.style.display = "hidden";
        // console.log(mybutton.style.display);
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}
