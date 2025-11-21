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

function redoOptionGroup()
{
    document.getElementById("StartOverCaution").style.display = "flex";
    const body = document.body;
    body.style.overflow = "hidden";
}