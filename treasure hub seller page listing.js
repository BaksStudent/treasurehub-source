function toggleState(state) 
{
    const onBtn = document.getElementById('onBtn');
    const offBtn = document.getElementById('offBtn');

    if (state === 'food') 
    {
        onBtn.classList.add('active');
        offBtn.classList.remove('active');
        document.getElementById("ListBackground").style.display = "none";
        document.getElementById("FoodListBackground").style.display = "block";
    }
    else 
    {
        offBtn.classList.add('active');
        onBtn.classList.remove('active');
        document.getElementById("ListBackground").style.display = "block";
        document.getElementById("FoodListBackground").style.display = "none";
    }
}

function DisableCaution()
{
    document.getElementById("StartOverCaution").style.display = "none";
    const body = document.body;
    body.style.overflow = "auto";
}
        
function handleImages()
{
    document.getElementById("CaptionSection").style.display = "none";
    document.getElementById("ImageSection").style.display = "block";
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0;
}

function EditName()
{
    document.getElementById("editName").value = "";
    document.getElementById("confirmbutton").style.display = "block ";
}

function EditCondition()
{
    document.getElementById("editCondition").value = "";
    document.getElementById("confirmbutton").style.display = "block";
}

function EditPrice()
{
    document.getElementById("editPrice").value = "";
    document.getElementById("confirmbutton").style.display = "block";
}

function EditQuantity()
{
    document.getElementById("editQuantity").value = "";
    document.getElementById("confirmbutton").style.display = "block";
}

function EditshortDescription()
{
    document.getElementById("editShortDescription").value = "";
    document.getElementById("confirmbutton").style.display = "block";
}

function EditlongDescription()
{
    document.getElementById("editLongDescription").value = "";
    document.getElementById("confirmbutton").style.display = "block";
}

function CreateListing()
{
    window.location.href = "treasure hub seller page home.php?view=list";
}

function getQueryParam(name) 
{
    const params = new URLSearchParams(window.location.search);
    return params.get(name);
}

function maincall()
{
    const action = getQueryParam('action');
    if (action === "edit") 
    {
        const editSuccessful = document.getElementById("editSuccesfulMessage");
        editSuccessful.style.display = "block";
        const body = document.body;
        body.style.overflow = "hidden";
    }
}

function DisableMessage()
{
    const editSuccessful = document.getElementById("editSuccesfulMessage");
    editSuccessful.style.display = "none";
    const body = document.body;
    body.style.overflow = "auto";
}

function redoOptionGroup()
{
    document.getElementById("StartOverCaution").style.display = "flex";
    const body = document.body;
    body.style.overflow = "hidden";

}