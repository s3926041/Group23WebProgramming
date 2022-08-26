const toastAlert = document.getElementById("toastAlert");
const toastText = document.getElementById("toast-text");
pre = 'toast border-0 text-white translate-middle-x  '
function setToast(bg,text){
    toastAlert.className = `${pre} ${bg}`
    toastText.innerHTML = text
    const toast = new bootstrap.Toast(toastAlert)
    toast.show()

}
