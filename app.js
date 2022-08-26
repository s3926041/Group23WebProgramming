if(localStorage.getItem("cart")===null)
  localStorage.setItem('cart',JSON.stringify({}))


let cart = JSON.parse(localStorage.getItem("cart"));
let count = 0;
for (let key in cart) {
  count += cart[key] >0 ? 1 : 0;
}
document.getElementById("total_cart").innerHTML = count;

function addcart(pid){
  console.log(pid)
  cart = JSON.parse(localStorage.getItem('cart'));
  if (cart === null) {
    cart[pid] = 1
    localStorage.setItem('cart', JSON.stringify(cart));
  }
  else{
    if (cart.hasOwnProperty(pid)) {
      setToast('bg-danger','Product already in cart!')
    } else {
      cart[pid] = 1;
    }
    localStorage.setItem('cart', JSON.stringify(cart))
  }
  count = 0
  for (let key in cart) {
    count += cart[key] >0 ? 1 : 0;
  }
  // localStorage.setItem('cart',JSON.stringify(cart))
  document.getElementById("total_cart").innerHTML = count;
}

function validate(para,s){
  let regex;
  if(!para) //false for password
  regex = /^(?!.*\s)(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#$%^&*]).([a-zA-Z 0-9\!\@\#\$\%\^\&\*]){8,20}$/;
  else //true for user
  regex = /^(?!.*\s)([a-zA-Z 0-9]){8,15}$/;
  return regex.test(s)
}

