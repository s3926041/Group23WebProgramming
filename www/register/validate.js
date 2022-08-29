const username = document.getElementById('username')
const password = document.getElementById('Password1')
const cpassword = document.getElementById('Password2')
const five_chars = document.querySelectorAll('.fivechar')
const form = document.getElementById('form')
const errorElement = document.getElementById('error')
let regexpass = /^(?!.*\s)(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#$%^&*]).([a-zA-Z 0-9\!\@\#\$\%\^\&\*]){8,20}$/;
let regexuser = /^(?!.*\s)([a-zA-Z 0-9]){8,15}$/;
form.addEventListener('submit', (e) => {
  let messages = []
  
  if(!regexuser.test(username.value)){
    messages.push('Username must contains only letters and digits, has a length from 8 to 15 characters')
  }
  if (!regexpass.test(password.value)) {
    messages.push('Password must contains at least one upper case letter, one lower case letter, one digit, one special letter in the set !@#$%^&*, NO other kind of characters, has a length from 8 to 20 characters')
  }
  if (password.value != cpassword.value) {
    messages.push('Confirm password not match')
  }

  five_chars.forEach(element => {
    if(element.value == undefined){
      messages.push('Field must have a minimum length of 5')
    
    }
    else if(element.value.length <5){
      messages.push('Field must have a minimum length of 5')
    
    }
  })
  if (messages.length > 0) {
    e.preventDefault()
    errorElement.innerText = messages[0];

  }
})
