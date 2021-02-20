function checkRegistration(registration) {
  if (registration.length !== 6) {
    return "The registration number must hold six characters.\n";
  }

  if (!registration.substr(0, 3).match(/^[A-Za-z]+$/)) {
    return "The first three characters of the registration number must be letters.\n";
  }

  if (!registration.substr(3, 2).match(/^[0-9]+$/)) {
    return "The second last two characters of the registration number must be digits.\n";
  }  

  if (!registration.substr(5).match(/^[A-Za-z0-9]+$/)) {
    return "The last character of the registration number must be a letter or a digit.\n";
  }  

  return "";
}

function checkMake(make) {
  if (!make) {
    return "The make must be selected.\n";
  }
  
  return "";
}
  
function checkColor(color) {
  if (!color) {
    return "The color must be selected.\n";
  }
  
  return "";
}
  
function checkYear(year) {
  if (!year.match(/^[0-9]+$/)) {
    return "The year must be an integer value.\n";
  }  

  if (year.length !== 4) {
    return "The year number must hold four digits.\n";
  }
  
  if ((year < 1900) || (year > 2019)) {
    return "The year must be a value between 1900 and 2019, inclusive.\n";
  }

  return "";  
}

function checkPrice(price) {
  if (!price.match(/^(\+|\-)?([0-9]+)(\.[0-9]+)?$/)) {
    return "The price must be an numerical value.\n";
  }
  
  if (price <= 0) {
    return "The price be a positive value.\n";
  }

  return "";  
}

function validateCar() {
  let registration = document.getElementById("registration").value    
  let result = checkRegistration(registration);
  result += checkMake(document.getElementById("make").value);
  result += checkColor(document.getElementById("color").value);
  result += checkYear(document.getElementById("year").value);
  result += checkPrice(document.getElementById("price").value);
  
  if (result.length > 0) {
    alert(result);
    return false;
  }

  document.getElementById("registration").value = registration.toUpperCase();
  return true;
}

/*console.log("checkPersonNumber(\"6822035953\") " + (checkPersonNumber("6822035953") ? "Yes" : "No"));
console.log("checkPersonNumber(\"6802315953\") " + (checkPersonNumber("6802315953") ? "Yes" : "No"));
console.log("checkPersonNumber(\"6802035953\") " + (checkPersonNumber("6802035953") ? "Yes" : "No"));
console.log("checkPersonNumber(\"6802035952\") " + (checkPersonNumber("6802035952") ? "Yes" : "No"));
console.log("checkPersonNumber(\"8112189876\") " + (checkPersonNumber("8112189876") ? "Yes" : "No"));
console.log("checkPersonNumber(\"8112189877\") " + (checkPersonNumber("8112189877") ? "Yes" : "No"));  
console.log("checkPersonNumber(\"1212121212\") " + (checkPersonNumber("1212121212") ? "Yes" : "No"));
console.log("checkPersonNumber(\"1212121213\") " + (checkPersonNumber("1212121213") ? "Yes" : "No"));

for (let index = 0; index < 100; ++index) {
  let personNumber = generatePersonNumber();
  //console.log(personNumber + " " + (checkPersonNumber(personNumber) ? "Yes" : "No"));
  document.write(personNumber + " " + (checkPersonNumber(personNumber) ? "Yes" : "No") + "<br>");
}

let personNumber = generatePersonNumber();
console.log(personNumber + " ");
console.log("Hello2");
console.log(checkPersonNumber(personNumber) ? "Yes" : "No");
console.log("Hello3");*/
