function getQueryParam(name) 
{
    const params = new URLSearchParams(window.location.search);
    return params.get(name);
}

function maincall()
{
    const action = getQueryParam('section');
    const OrderLists = document.getElementById("SectionContainer-orderID");
    const SellerLists = document.getElementById("SectionContainer-seller");
    const ProductLists = document.getElementById("SectionContainer-product");
    const UserLists = document.getElementById("SectionContainer-userID");
    const ReviewLists = document.getElementById("SectionContainer-review");
    const queryLists = document.getElementById("SectionContainer-query");
    const foodOrderLists = document.getElementById("SectionContainer-foodorderID");
    const foodProductLists = document.getElementById("SectionContainer-foodproduct");

    if (action === "product") 
    {
        OrderLists.style.display = "none";
        SellerLists.style.display = "none";
        ProductLists.style.display = "block";
        UserLists.style.display = "none";
        ReviewLists.style.display = "none";
        queryLists.style.display = "none";
        foodOrderLists.style.display = "none";
        foodProductLists.style.display = "none";
    }
    if(action === "seller")
    {
        OrderLists.style.display = "none";
        SellerLists.style.display = "block";
        ProductLists.style.display = "none";
        UserLists.style.display = "none";
        ReviewLists.style.display = "none";
        queryLists.style.display = "none";
        foodOrderLists.style.display = "none";
        foodProductLists.style.display = "none";
    }
    if(action === "order")
    {
        OrderLists.style.display = "block";
        SellerLists.style.display = "none";
        ProductLists.style.display = "none";
        UserLists.style.display = "none";
        ReviewLists.style.display = "none";
        queryLists.style.display = "none";
        foodOrderLists.style.display = "none";
        foodProductLists.style.display = "none";
    }
    if(action === "user")
    {
        OrderLists.style.display = "none";
        SellerLists.style.display = "none";
        ProductLists.style.display = "none";
        UserLists.style.display = "block";
        ReviewLists.style.display = "none";
        queryLists.style.display = "none";
        foodOrderLists.style.display = "none";
        foodProductLists.style.display = "none";
    }
    if(action === "report")
    {
        OrderLists.style.display = "none";
        SellerLists.style.display = "none";
        ProductLists.style.display = "none";
        UserLists.style.display = "none";
        ReviewLists.style.display = "none";
        queryLists.style.display = "block";
        foodOrderLists.style.display = "none";
        foodProductLists.style.display = "none";
    }
    if(action === "review")
    {
        OrderLists.style.display = "none";
        SellerLists.style.display = "none";
        ProductLists.style.display = "none";
        UserLists.style.display = "none";
        ReviewLists.style.display = "block";
        queryLists.style.display = "none";
        foodOrderLists.style.display = "none";
        foodProductLists.style.display = "none";
    }
    if(action === "foodproduct")
    {
        OrderLists.style.display = "none";
        SellerLists.style.display = "none";
        ProductLists.style.display = "none";
        UserLists.style.display = "none";
        ReviewLists.style.display = "none";
        queryLists.style.display = "none";
        foodOrderLists.style.display = "none";
        foodProductLists.style.display = "block";
    }
    if(action === "foodorder")
    {
        OrderLists.style.display = "none";
        SellerLists.style.display = "none";
        ProductLists.style.display = "none";
        UserLists.style.display = "none";
        ReviewLists.style.display = "none";
        queryLists.style.display = "none";
        foodOrderLists.style.display = "block";
        foodProductLists.style.display = "none";
    }
}

window.addEventListener("load", maincall);
