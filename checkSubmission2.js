var fNameNode = document.getElementById("firstName");
var lNameNode = document.getElementById("lastName");
var emailNode = document.getElementById("email");
var emailNode2 = document.getElementById("myEmail");
fNameNode.addEventListener("change", checkNameF, false);
lNameNode.addEventListener("change", checkNameL, false);
emailNode.addEventListener("change", checkEmail, false);
emailNode2.addEventListener("change", checkEmail2, false);
