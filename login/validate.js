const username = document.getElementById('username')
const password = document.getElementById('Password1')
const form = document.getElementById('form')
const errorElement = document.getElementById('error')
let regexuser = /^(?!.*\s)([a-zA-Z 0-9]){8,15}$/;
form.addEventListener('submit', (e) => {
  let messages = []
  
  if(!regexuser.test(username.value)){
    messages.push('Username must contains only letters and digits, has a length from 8 to 15 characters')
  }
  if (password.value.length < 8 || password.value.length > 20) {
    messages.push('Password must has a length from 8 to 20 characters')
  }
  if (messages.length > 0) {
    e.preventDefault()
    errorElement.innerText = messages[0];
  }
})
