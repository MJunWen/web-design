var fNameNode = document.getElementById("firstName");
var lNameNode = document.getElementById("lastName");
var emailNode = document.getElementById("email");
fNameNode.addEventListener("change", checkNameF, false);
lNameNode.addEventListener("change", checkNameL, false);
emailNode.addEventListener("change", checkEmail, false);
