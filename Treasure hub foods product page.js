function MainCall()
{
    window.location.href = "treasure hub welcome.html";
}
function toggleMobileMenu()
{
    const mobileMenu = document.getElementById("MobileMenu");
    mobileMenu.style.display = mobileMenu.style.display === "flex" ? "none" : "flex";
}
function handleResize() {
   
        const mainNavbar = document.querySelector(".Nav-links");
        const mobileMenu = document.getElementById("MobileMenu");
       
    
        if (window.innerWidth <= 700) {
            mainNavbar.style.display = "none";
          
        } else {
            mainNavbar.style.display = "flex"; 
            mobileMenu.style.display = "none"; 
            
        }
}


window.addEventListener("resize", handleResize);


window.addEventListener("load", handleResize);