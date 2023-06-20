const submit = document.getElementById("submit");

submit.addEventListener("click", validate);

function validate(e) {
  e.preventDefault();
  let valid = true;
  const name = document.getElementById("namejfznfo");
  const lastname = document.getElementById("lastnameksxcins");
  const email = document.getElementById("emailsklqds");
  const description = document.getElementById("descriptionpqcdq");

  if (!name.value || !lastname.value || !email.value || !description.value) {
    alert("You need to fill in the inputs");
    valid = false;
  }
  return valid;
}
