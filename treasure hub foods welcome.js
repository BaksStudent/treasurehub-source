
function MainCall()
{
    window.location.href = "treasure_hub_welcome.php";
}
function ToCart()
{
    window.location.href = "treasure hub cart section.php";
}

function toggleMobileMenu()
{
    const mobileMenu = document.getElementById("MobileMenu");
    mobileMenu.style.display = mobileMenu.style.display === "flex" ? "none" : "flex";
}
function handleResize() {
   /* const mainNavbar = document.querySelector(".Nav-links");
    const mobileMenu = document.getElementById("MobileMenu");
   
    if (window.innerWidth <= 768) {
        mainNavbar.style.display = "none";
    } else {
        mainNavbar.style.display = "flex"; 
        mobileMenu.style.display = "none"; 
    }*/
        const mainNavbar = document.querySelector(".Nav-links");
        const mobileMenu = document.getElementById("MobileMenu");
        const barIcon = document.getElementById("barIcon");
        const CategoryBar = document.getElementById("CategoryBar");
        const MobileCategoryBar = document.getElementById("CatergoryBar-Mobile");
        const RecentlyPage = document.getElementById("RecentlyAdded");
        const mobileRecentlyPage = document.getElementById("recentlyAddedMobile");
        const forSalePage = document.getElementById("forSale");
        const mobileforSale = document.getElementById("forSaleMobile");
        const FoodsBanner = document.getElementById("mainbanner");
        const mobileFoodsBanner = document.getElementById("mainbannermobile");
    
        if (window.innerWidth <= 700) {
            mainNavbar.style.display = "none";
            MobileCategoryBar.style.display = "block";
            CategoryBar.style.display = "none";
            mobileRecentlyPage.style.display = "block";
            mobileforSale.style.display = "block";
            RecentlyPage.style.display = "none";
            forSalePage.style.display = "none";
            mobileFoodsBanner.style.display = "block";
            FoodsBanner.style.display = "none";
        } else {
            mainNavbar.style.display = "flex"; 
            CategoryBar.style.display = "block";
            RecentlyPage.style.display = "block";
            forSalePage.style.display = "block";
            MobileCategoryBar.style.display = "none";
            mobileMenu.style.display = "none"; 
            FoodsBanner.style.display = "flex";
            mobileRecentlyPage.style.display = "none";
            mobileforSale.style.display = "none";
            mobileFoodsBanner.style.display = "none";
        }
}


window.addEventListener("resize", handleResize);


window.addEventListener("load", handleResize);