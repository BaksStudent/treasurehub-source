function FoodsCall()
{
    window.location.href = "treasure hub foods welcome.html";
}

function toggleMobileMenu()
{
    const mobileMenu = document.getElementById("MobileMenu");
    mobileMenu.style.display = mobileMenu.style.display === "flex" ? "none" : "flex";
}
function handleResize() {
    
    const mainNavbar = document.querySelector(".Nav-links");
    const mobileMenu = document.getElementById("MobileMenu");
    const barIcon = document.getElementById("barIcon");
    const CategoryBar = document.getElementById("CategoryBar");
    const MobileCategoryBar = document.getElementById("CatergoryBar-Mobile");
 

    if (window.innerWidth <= 768) {
        mainNavbar.style.display = "none";
        MobileCategoryBar.style.display = "block";
        CategoryBar.style.display = "none";
       
    } else {
        mainNavbar.style.display = "flex"; 
        CategoryBar.style.display = "block"; 
        MobileCategoryBar.style.display = "none";
        mobileMenu.style.display = "none"; 
       
    }
}


window.addEventListener("resize", handleResize);


window.addEventListener("load", handleResize);