if(document.getElementById('but')){
    const but = document.getElementById('but')
    const un = document.getElementById('navbarSupportedContent')
    let bol = false;
    but.addEventListener("click",()=>{
        if(!bol){
            but.className ='navbar-toggler collapsed'
            un.className ='navbar-collapse collapse show'
        }
        else {
            but.className ='navbar-toggler'
            un.className ='navbar-collapse collapse'
        }
        bol = !bol
        console.log(1)
    })
}
