let valid =
  /^[a-zA-z0-9][a-zA-Z0-9\.-]*[a-zA-z0-9][@][a-zA-z0-9][a-zA-z0-9\.-]*[a-zA-z0-9][\.][a-zA-z0-9]{2,3}$/;
let valid2 =
  /^[a-zA-z0-9]+(?:[a-zA-Z0-9]+|([ _’'-\.])(?!\1))+[a-zA-z0-9]+[@]{1}[a-zA-Z0-9]+(?:[a-zA-Z0-9]+|([.-])(?!\1))+[a-zA-Z0-9]{1,3}$/;

function isValid(value) {
  if (!valid.test(value)) {
    alert("ok");
  }
}
