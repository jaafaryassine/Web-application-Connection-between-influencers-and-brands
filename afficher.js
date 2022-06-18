function marques(){
    document.getElementById('profil').style.display='none';
    document.getElementById('partenariats').style.display='none';
    document.getElementById('messages').style.display='none';
    document.getElementById('settings').style.display='none';
    document.getElementById('marques').style.display='block';
}
function profil(){
    document.getElementById('marques').style.display='none';
    document.getElementById('partenariats').style.display='none';
    document.getElementById('messages').style.display='none';
    document.getElementById('settings').style.display='none';
    document.getElementById('profil').style.display='block';
}
function partenariats(){
    document.getElementById('marques').style.display='none';
    document.getElementById('profil').style.display='none';
    document.getElementById('messages').style.display='none';
    document.getElementById('settings').style.display='none';
    document.getElementById('partenariats').style.display='block';
}
function messages(){
    document.getElementById('marques').style.display='none';
    document.getElementById('profil').style.display='none';
    document.getElementById('partenariats').style.display='none';
    document.getElementById('settings').style.display='none';
    document.getElementById('messages').style.display='block';
}

function settings(){
    document.getElementById('marques').style.display='none';
    document.getElementById('profil').style.display='none';
    document.getElementById('partenariats').style.display='none';
    document.getElementById('messages').style.display='none';
    document.getElementById('settings').style.display='block';
}



function showEdit(i){
    switch(i){
        case 1 : document.getElementById('prenom').style.display="none";
                 document.getElementById('age').style.display="none";
                 document.getElementById('insta').style.display="none";
                 document.getElementById('face').style.display="none";
                 document.getElementById('pass').style.display="none";
                 document.getElementById('nom').style.display="block";
                 break;
        case 2 : document.getElementById('nom').style.display="none";
                 document.getElementById('age').style.display="none";
                 document.getElementById('insta').style.display="none";
                 document.getElementById('face').style.display="none";
                 document.getElementById('pass').style.display="none";
                 document.getElementById('prenom').style.display="block";
                 break;
        case 3 : document.getElementById('prenom').style.display="none";
                 document.getElementById('nom').style.display="none";
                 document.getElementById('insta').style.display="none";
                 document.getElementById('face').style.display="none";
                 document.getElementById('pass').style.display="none";
                 document.getElementById('age').style.display="block";
                 break;
        case 4 : document.getElementById('prenom').style.display="none";
        document.getElementById('age').style.display="none";
        document.getElementById('nom').style.display="none";
        document.getElementById('face').style.display="none";
        document.getElementById('pass').style.display="none";
        document.getElementById('insta').style.display="block";
                 break;
        case 5 : document.getElementById('prenom').style.display="none";
                 document.getElementById('age').style.display="none";
                 document.getElementById('insta').style.display="none";
                 document.getElementById('nom').style.display="none";
                 document.getElementById('pass').style.display="none";
                 document.getElementById('face').style.display="block";
                 break;
        case 6 : document.getElementById('prenom').style.display="none";
                 document.getElementById('age').style.display="none";
                 document.getElementById('insta').style.display="none";
                 document.getElementById('face').style.display="none";
                 document.getElementById('nom').style.display="none";
                 document.getElementById('pass').style.display="block";
                 break;
    }
}

function showChange(){
    let change=document.getElementById('change');
    if(change.style.display=='none'){
        change.style.display='block';
    }
    else{
        change.style.display='none';
    }
}

