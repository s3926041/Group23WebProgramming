if (localStorage.getItem("cart") === null)
  localStorage.setItem("cart", JSON.stringify({}));
let cart = JSON.parse(localStorage.getItem("cart"));
let count = 0;
for (let key in cart) {
  count += cart[key] > 0 ? 1 : 0;
}
document.getElementById("total_cart").innerHTML = count;

function addcart(pid) {
  console.log(pid);
  cart = JSON.parse(localStorage.getItem("cart"));
  if (cart === null) {
    cart[pid] = 1;
    localStorage.setItem("cart", JSON.stringify(cart));
    setToast('bg-success','Product added successfully!');
  } else {
    if (cart.hasOwnProperty(pid)) {
      if (cart[pid] > 0) {
        setToast('bg-danger','Product already added!');
      }
    } else {
      cart[pid] = 1;
      localStorage.setItem("cart", JSON.stringify(cart));
      setToast('bg-success','Product added successfully!');
    }
    count = 0;
    for (let key in cart) {
      count += cart[key] > 0 ? 1 : 0;
    }

    document.getElementById("total_cart").innerHTML = count;
  }
}

