const namee = document.getElementById('name')
const pricee = document.getElementById('price')
const dese = document.getElementById('des')
const forme = document.getElementById('form')
const errorElemente = document.getElementById('error')

let cur = 0;
forme.addEventListener('submit', (e) => {
  let messages = []
  if(namee.value.length < 10 || namee.value.length > 20){
    messages.push(`Product's name has a length from 10 to 20`)
  }
 if(/^\d+$/.test(pricee.value)){
    let s =parseFloat(pricee.value)
    if(s <=0) {
        messages.push(`Price must be an positve number and greater > 0`)
    }
 }
 else{
    messages.push(`Price must be an positve number`)
 }
 if(dese.value.length > 500){
    messages.push(`Description`)
 }
  if (messages.length > 0) {
    e.preventDefault()
    errorElemente.innerText = messages[0];
  }
})
