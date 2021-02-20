function checkDate(year, month, day) {
  let date1 = new Date(year, month, day);
  let date2 = new Date(date1.getTime());
  return ((year === date2.getFullYear()) &&
          (month === date2.getMonth()) &&
          (day === date2.getDate()));
}

function generatePersonNumber() {
  let year, month, day;

  do {
    year = Math.trunc(90 * Math.random() + 10);      // 0..89
    month = Math.trunc(12 * Math.random()) + 1;  // 1..12
    day = Math.trunc(31 * Math.random()) + 1     // 1..31
  }
  while (!checkDate(1900 + year, month - 1, day));

  let yearStr = ((year < 10) ? "0" : "") + year.toString();
  let monthStr = ((month < 10) ? "0" : "") + month.toString();
  let dayStr = ((day < 10) ? "0" : "") + day.toString();

  let number = Math.trunc(1000 * Math.random()); // 0..999
  let numberStr = ((number < 100) ? "0" : "") + ((number < 10) ? "0" : "") + number.toString();

  let factor = 2;
  let totalSum = 0;
  let digit0to8 = yearStr + monthStr + dayStr + numberStr;

  for (index = 0; index < 9; ++index) {
    let digit = digit0to8[index];
    let value = factor * digit;
    let digitSum = Math.trunc(value / 10) + (value % 10);
    totalSum += digitSum;
    factor = (factor == 1) ? 2 : 1;
  }

  let digit9 = (10 - (totalSum % 10)) % 10;
  return digit0to8 + digit9;
}

function checkPerson(person) {
  if (!person.match(/^[0-9]+$/)) {
    return "The person number must hold digits.\n";
  }

  if (person.length !== 10) {
    return "The person number must hold ten digits.\n";
  }
  
  let year = parseInt(person.substr(0, 2));
  let month = parseInt(person.substr(2, 2));
  let day = parseInt(person.substr(4, 2));        

  if (!checkDate(1900 + year, month - 1, day)) {
    return "The date \"" + year + month + day + "\" of the person number is incorrect.\n";
  }

  let factor = 2;
  let totalSum = 0;

  for (index = 0; index < 9; ++index) {
    let digit = person[index];
    let value = factor * digit;
    let digitSum = Math.trunc(value / 10) + (value % 10);
    totalSum += digitSum;
    factor = (factor == 1) ? 2 : 1;
  }

  let lastDigit = (10 - (totalSum % 10)) % 10;
  if (lastDigit != person[9]) {
    return "The last digit \"" + person[9] + "\" of the person number is incorrect.\n";
  }
  
  return "";
}

function checkName(name) {
  if (name.length === 0) {
    return "The name is empty.\n";
  }
  
  return "";
}

function checkAddress(address) {
  if (address.length === 0) {
    return "The address is empty.\n";
  }
  
  return "";
}

function checkPostal(postal) {
  if (!postal.match(/^[0-9]+$/)) {
    return "The postal number must hold digits.\n";
  }
  
  if (postal.length !== 5) {
    return "The postal number must hold five digits.\n";
  }
  
  return "";
}

function checkPhone(phone) {
  if (!phone.match(/^[0-9]+$/)) {
    return "The phone number must hold digits.\n";
  }
  
  if (phone.length != 10) {
    return "The phone number must hold ten digits.\n";
  }
  
  if (phone[0] != "0") {
    return "The phone number must begin with the digit zero.\n";
  }
  
  return "";
}

/*for (let index = 0; index < 100; ++index) {
  let personNumber = generatePersonNumber();
  //console.log(personNumber + " " + (checkPersonNumber(personNumber) ? "Yes" : "No"));
  //document.write(personNumber + " " + (checkPersonNumber(personNumber) ? "Yes" : "No") + "<br>");
  document.write(personNumber + "<br>");
}*/

function validateCustomer() {
  let result = checkPerson(document.getElementById("person").value);
  result += checkName(document.getElementById("name").value);
  result += checkAddress(document.getElementById("address").value);
//  result += checkPostal(document.getElementById("postal").value);
  result += checkPhone(document.getElementById("phone").value);

  if (result.length > 0) {
    alert(result);
    return false;
  }
  
  return true;
}