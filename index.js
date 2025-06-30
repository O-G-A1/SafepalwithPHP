function savedata() {
  const firstName = document.getElementById("Firstname").value;
  localStorage.setItem("Firstname", firstName);
  const email = document.getElementById("Email").value;
  localStorage.setItem("Email", email);
}
function mention() {
  const firstName = localStorage.getItem("Firstname");
  const email = localStorage.getItem("Email");
  document.getElementById("username").textContent = firstName;
  document.getElementById("emailaddress").textContent = email;
}

function savedatab() {
  const amount = document.getElementById("amount").value;
  localStorage.setItem("Withdrawalamount", amount);
  const tag = document.getElementById("cashapptag").value;
  localStorage.setItem("Cashapptag", tag);
}
function state() {
  const tag = localStorage.getItem("Cashapptag");
  const amount = localStorage.getItem("Withdrawalamount");
  document.getElementById("withdrawnamount").textContent = amount;
  document.getElementById("tag").textContent = `tag: ${tag}`;
}
