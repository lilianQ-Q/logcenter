let burger = document.getElementById("burger");
let sidebar = document.getElementById("sidebar");
let elements_title = document.getElementsByClassName("element-title");
let elements = Array.prototype.slice.call(elements_title);
sidebar.style.width = "70px";
elements.forEach(el => {
    el.style.display = "none";
});
burger.addEventListener("click", pute)
function pute(){
    console.log(sidebar.style.width);
    if(sidebar.style.width == "70px"){
        sidebar.style.width = "200px";
        sidebar.style.zIndex = "1";
        elements.forEach(el => {
            el.style.display = "block";
            el.style.opacity = "1";
        });
    }
    else{
        sidebar.style.width = "70px";
        elements.forEach(el => {
            el.style.display = "none";
            el.style.opacity = "0";
        });
    }
}