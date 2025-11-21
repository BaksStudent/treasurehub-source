function accountInfoEnter()
{
    window.location.href = "treasure hub settings page.php?action=sell";
}

function manageListing()
{
    /*
    const HomePageBackground = document.getElementById("mainback");
    const MakeListing = document.getElementById("createSellerBackground");

    HomePageBackground.style.display = "none";
    MakeListing.style.display = "block";
    */
   window.location.href = "treasure hub seller page listing.php";
}

function previewfoodImage(event) 
{
    const input = event.target;
    const reader = new FileReader();

    reader.onload = function()
    {
        const img = document.getElementById('FoodProductPic');
        img.src = reader.result;
    }

    if (input.files && input.files[0]) 
    {
        reader.readAsDataURL(input.files[0]);
    }
}

function preview1stImage(event) 
{
    const input = event.target;
    const reader = new FileReader();

    reader.onload = function()
    {
        const img = document.getElementById('firstProductPic');
        img.src = reader.result;
    }

    if (input.files && input.files[0]) 
    {
        reader.readAsDataURL(input.files[0]);
    }
}
function preview2ndImage(event) 
{
    const input = event.target;
    const reader = new FileReader();

    reader.onload = function()
    {
        const img = document.getElementById('SecondProductPic');
        img.src = reader.result;
    }

    if (input.files && input.files[0]) 
    {
        reader.readAsDataURL(input.files[0]);
    }
}
function preview3rdImage(event) 
{
    const input = event.target;
    const reader = new FileReader();

    reader.onload = function()
    {
        const img = document.getElementById('ThridProductPic');
        img.src = reader.result;
    }

    if (input.files && input.files[0]) 
    {
        reader.readAsDataURL(input.files[0]);
    }
}

function preview4thImage(event) 
{
    const input = event.target;
    const reader = new FileReader();

    reader.onload = function()
    {
        const img = document.getElementById('FourthProductPic');
        img.src = reader.result;
    }

    if (input.files && input.files[0]) 
    {
        reader.readAsDataURL(input.files[0]);
    }
}

function homePageLink()
{
    window.location.href = "treasure hub seller page home.php";
}


function getQueryParam(name) 
{
    const params = new URLSearchParams(window.location.search);
    return params.get(name);
}

function maincall()
{
    const action = getQueryParam('view');
    if (action === "sell") 
    {
        const HomePageBackground = document.getElementById("mainback");
        const MakeListing = document.getElementById("createSellerBackground");

        HomePageBackground.style.display = "flex";
        MakeListing.style.display = "none";
    }
    if(action === "list")
    {
        const HomePageBackground = document.getElementById("mainback");
        const MakeListing = document.getElementById("createSellerBackground");

        HomePageBackground.style.display = "none";
        MakeListing.style.display = "block";
    }
    if(action === "flist")
    {
        const HomePageBackground = document.getElementById("mainback");
        const MakeListing = document.getElementById("createFoodListingBackground");

        HomePageBackground.style.display = "none";
        MakeListing.style.display = "block";

    }
    if(action === "edit")
    {
        const product = JSON.parse(localStorage.getItem("backupProduct"));
        const HomePageBackground = document.getElementById("mainback");
        const MakeListing = document.getElementById("EditFoodListingBackground");

        HomePageBackground.style.display = "none";
        MakeListing.style.display = "block";

        const idedit = document.getElementById("Food_Pt");
        const nameedit = document.getElementById("Food_Pname_edit");
        const description_edit = document.getElementById("Food_sDescription_edit");
        const priceEdit = document.getElementById("Food_Pprice_edit");

        nameedit.value = product.name;
        description_edit.value = product.description;
        priceEdit.value = product.price;
        idedit.value = product.productId;
        localStorage.removeItem("backupProduct");
        
    }
  
           
}

let groupCounter = 0;
let singleChoiceAdded = false;
let multipleChoiceAdded = false;

function addOptionGroup() {

    const action = getQueryParam('view');
    let container;
    if(action === "edit")
    {
        container = document.getElementById("optionGroupsContainer-edit");
    }
    else
    {
        container = document.getElementById("optionGroupsContainer");
    } 
  const groupType = prompt("Enter option type: 'Options' for single choice, 'Add' for multiple choice").toLowerCase();


  if (!container) {
    console.error("Container not found.");
    return;
  }
  // Validate input
  if (groupType !== 'options' && groupType !== 'add') {
    alert("Invalid type. Only 'Options' or 'Add' are allowed.");
    return;
  }

  // Check limits
  if (groupType === 'options' && singleChoiceAdded) {
    alert("Only one Single Choice group is allowed.");
    return;
  }
  if (groupType === 'add' && multipleChoiceAdded) {
    alert("Only one Multiple Choice group is allowed.");
    return;
  }

  // Mark the type as added
  let TypeofGroup;
  if (groupType === 'options')
    {
        singleChoiceAdded = true;
        TypeofGroup = "Options";
    } 
  if (groupType === 'add')
    {
        multipleChoiceAdded = true;
        TypeofGroup = "Add-ons";
    } 

  const groupHTML = `
    <div class="optionGroup">
      <label>${TypeofGroup} Group Name: </label>
      <input type="text" name="option_groups[${groupCounter}][name]" placeholder="Option Group Name" required>
      <input type="hidden" name="option_groups[${groupCounter}][type]" value="${groupType}">
      <div class="options" id="options-${groupCounter}"></div>
      <button type="button" onclick="addOption(${groupCounter})">+ Add Option</button>
    </div>
  `;


  container.insertAdjacentHTML('beforeend', groupHTML);
  groupCounter++;
}

function addOption(groupId) {
  const optionsDiv = document.getElementById(`options-${groupId}`);
  const optionHTML = `
    <div>
      <input type="text" name="option_groups[${groupId}][options][]" placeholder="Option Name" required>
      <input type="number" step="0.01" name="option_groups[${groupId}][prices][]" placeholder="Extra Cost" required>
    </div>
  `;
  optionsDiv.insertAdjacentHTML('beforeend', optionHTML);
}

window.addEventListener("load", maincall);