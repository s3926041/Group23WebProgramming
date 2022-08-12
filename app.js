let str = localStorage.getItem('cart')
let cart = JSON.parse(str)
let count = 0

for(let key in cart){
  count += cart[key]
  }
localStorage.setItem('cart',JSON.stringify(cart))
document.getElementById('total_cart').innerHTML = count;