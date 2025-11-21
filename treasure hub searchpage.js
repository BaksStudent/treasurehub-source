document.addEventListener("DOMContentLoaded",function()
{
    /*
    const pricedropdown= document.getElementById("pricedropdown");
    const pricetitle = pricedropdown.querySelector(".pricedropdown-title");
    const sortdropdown = document.getElementById("sortdropdown");
    const sorttitle = sortdropdown.querySelector(".sortdropdown-title");
    const filterdropdown = document.getElementById("filterdropdown");
    const filtertitle = filterdropdown.querySelector(".filterdropdown-title")
    pricetitle.addEventListener("click",()=>{
            pricedropdown.classList.toggle("active") 
    }
    )
    sorttitle.addEventListener("click",()=>{
        sortdropdown.classList.toggle("active");
    })
    filtertitle.addEventListener("click",()=>{
        filterdropdown.classList.toggle("active");
    })
*/
}
)

function ToCart()
{
    window.location.href = "treasure hub cart section.php";
}

function CheckSorting() {
        
    if (document.getElementById("sortNameAscending").checked) {
        console.log("Sorting by Name A-Z");
    } else if (document.getElementById("sortNameDescending").checked) {
        console.log("Sorting by Name Z-A");
    } else if (document.getElementById("sortDateAscending").checked) {
        console.log("Sorting by Newest Added");
    } else if (document.getElementById("sortDateDescending").checked) {
        console.log("Sorting by Oldest Added");
    } else if (document.getElementById("sortNone").checked) {
        console.log("No sorting applied");
    } else {
        console.log("No option selected");
    }
}
function handlelists()
{
    const pricedropdown= document.getElementById("pricedropdown");
    const pricetitle = pricedropdown.querySelector(".pricedropdown-title");
    const sortdropdown = document.getElementById("sortdropdown");
    const sorttitle = sortdropdown.querySelector(".sortdropdown-title");
    /*const filterdropdown = document.getElementById("filterdropdown");
    const filtertitle = filterdropdown.querySelector(".filterdropdown-title")*/
    pricetitle.addEventListener("click",()=>{
            pricedropdown.classList.toggle("active") 
    }
    )
    sorttitle.addEventListener("click",()=>{
        sortdropdown.classList.toggle("active");
    })
    /*filtertitle.addEventListener("click",()=>{
        filterdropdown.classList.toggle("active");
    })*/

    const Mobilepricedropdown= document.getElementById("mobilepricedropdown");
    const Mobilepricetitle = Mobilepricedropdown.querySelector(".pricedropdown-title");
    const Mobilesortdropdown = document.getElementById("mobilesortdropdown");
    const Mobilesorttitle = Mobilesortdropdown.querySelector(".sortdropdown-title");
    const Mobilefilterdropdown = document.getElementById("mobilefilterdropdown");
    const Mobilefiltertitle = Mobilefilterdropdown.querySelector(".filterdropdown-title");

    Mobilepricetitle.addEventListener("click",()=>{
            Mobilepricedropdown.classList.toggle("active") 
    }
    )
    Mobilesorttitle.addEventListener("click",()=>{
        Mobilesortdropdown.classList.toggle("active");
    })
    Mobilefiltertitle.addEventListener("click",()=>{
        Mobilefilterdropdown.classList.toggle("active");
    })

}

function toggleMobileMenu()
{
    const mobileMenu = document.getElementById("MobileMenu");
    mobileMenu.style.display = mobileMenu.style.display === "flex" ? "none" : "flex";
}
function toggleFilterMenu()
{
    const filterMenu = document.getElementById("mobilefiltersMenu")
    filterMenu.style.display = filterMenu.style.display === "block" ? "none" : "block";
}

function handleResize()
{
    const mainNavbar = document.getElementById("mainNavbar");
    const desktopHeaderContainer = document.getElementById("DesktopHeaderContainer");
    const mobileNavbar = document.getElementById("mobileNavbar") ;
    const desktopConatiner = document.getElementById("desktopContainer");
    const mobileSearchContainer = document.getElementById("mobileSeachContainer");
    const mobileContentSection = document.getElementById("mobileContentSection");

    if(window.innerWidth <= 700)
    {
        mainNavbar.style.display = "none";
        desktopHeaderContainer.style.display = "none";
        mobileNavbar.style.display = "flex";
        desktopConatiner.style.display = "none";
        mobileSearchContainer.style.display = "flex";
        mobileContentSection.style.display = "block";
    }
    else
    {
        mainNavbar.style.display = "flex";
        desktopHeaderContainer.style.display ="block";
        mobileNavbar.style.display = "none";
        desktopConatiner.style.display = "block";
        mobileSearchContainer.style.display = "none";
        mobileContentSection.style.display = "none";
    }
}
document.addEventListener("DOMContentLoaded",handlelists)
window.addEventListener("resize", handleResize);
window.addEventListener("load", handleResize);