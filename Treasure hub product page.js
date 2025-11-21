function toggleMobileMenu()
{
    const mobileMenu = document.getElementById("MobileMenu");
    mobileMenu.style.display = mobileMenu.style.display === "flex" ? "none" : "flex";
}

function toLogin()
{
  window.location.href = "treasure_hub_signup_or_login.php";
}

function handleResize() {
    
    const mainNavbar = document.querySelector(".Nav-links");
    const mobileMenu = document.getElementById("MobileMenu");
    const desktopBackground = document.getElementById("mainBackground");
    const mobileBackground = document.getElementById("mobileBackground");
    
   

    if (window.innerWidth <= 700) {
        mainNavbar.style.display = "none";
        desktopBackground.style.display = "none";
        mobileBackground.style.display = "block";
       
    } else {
        mainNavbar.style.display = "flex"; 
        mobileMenu.style.display = "none"; 
        desktopBackground.style.display = "block";
        mobileBackground.style.display = "none";
       
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const banner = document.querySelector(".notification-banner");
    if (banner) {
      setTimeout(() => {
        banner.style.transition = "opacity 0.5s ease";
        banner.style.opacity = 0;
        setTimeout(() => banner.remove(), 500); // Remove element from DOM after fade out
      }, 5000); // 5 seconds before fade starts
    }
  });

function ToCart()
{
    window.location.href = "treasure hub cart section.php";
}



window.addEventListener("resize", handleResize);


window.addEventListener("load", handleResize);