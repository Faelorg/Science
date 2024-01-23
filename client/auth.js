let login = $("#floatingLogin").get();
let password = $("#floatingPassword").get();

let signin = $("#in").get();

let signup = $("up").get();

signin.click(() => {
  if (user["login"] == login.value && user.password == password.value) {
    alert("uhvewui");
  }
});
