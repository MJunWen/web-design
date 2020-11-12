function checkNameF(event){
    var fName = event.currentTarget;
    var pos = fName.value.search(/^[a-zA-Z ]*$/);
    if (pos != 0){
        alert("The name you entered (" + fName.value +
         ") is not in the correct form. \n" + 
         "It should contain only alphabets.");
        fName.focus();
        fName.select();
        return false;
    }
}

function checkNameL(event){
    var LName = event.currentTarget;
    var pos = LName.value.search(/^[a-zA-Z ]*$/);
    if (pos != 0){
        alert("The name you entered (" + LName.value +
         ") is not in the correct form. \n" + 
         "It should contain only alphabets.");
        LName.focus();
        LName.select();
        return false;
    }
}

function checkEmail(event){
    var email = event.currentTarget;
    var pos = email.value.search(/^[\w-\.]+@[\w]+(\.[\w]+)?\.[\w]{2,3}$/);
    if (pos != 0){
        alert("The Email you entered (" + email.value +
         "is not in the correct form. \n" + 
         "It should contain a username followed by @ and a domain name part. The username contains word characters including hyphen (-) and period (.)."
         + "The domain name contains 2-4 address extensions. Each extension is a string of word characters and separated from the others by a period (.)."
         + "The last extension must have 2-3 characters.");
        email.focus();
        email.select();
        return false;
    }
}

function checkEmail2(event){
    var email2 = event.currentTarget;
    var pos = email2.value.search(/^[\w-\.]+@[\w]+(\.[\w]+)?\.[\w]{2,3}$/);
    if (pos != 0){
        alert("The Email you entered (" + email2.value +
         "is not in the correct form. \n" + 
         "It should contain a username followed by @ and a domain name part. The username contains word characters including hyphen (-) and period (.)."
         + "The domain name contains 2-4 address extensions. Each extension is a string of word characters and separated from the others by a period (.)."
         + "The last extension must have 2-3 characters.");
        email2.focus();
        email2.select();
        return false;
    }
}
