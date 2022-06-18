let dropdown=document.getElementById("dropdown");
dropdown.addEventListener("click",function(){
    let submenu=document.getElementById("submenu");
    if(submenu.style.display=='none'){
    submenu.style.display='block';
    } 
    else {
        submenu.style.display='none';
    }
    
})
