<?php
include "connect.php";
session_start();

if(isset($_SESSION['adminEmail']))
{
   
}
else
{
    header("Location: treasure_hub_signup_or_login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List</title>
    <link rel="stylesheet" href="treasure hub developer listing page.css">
    <link rel="stylesheet" href="treasure hub developer page home.css">
    <link rel="stylesheet" href="order-List.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <nav class = "MainNavbar">
            <button class = "MainLogo" style="border: none; background-color: rgba(0, 0, 0, 0);"><img src = "treasure hub logo reduced 4.png"></button>
       
            <div class ="Nav-links">
              
              <button class = "Nav-Buttons" onclick="Logout()">Logout</button>
              <button class = "Nav-Buttons" onclick = "HomeLink()">Home</button>
            </div>
        </nav>
        <div class = "DesktopHeaderContainer" >
            <nav class = "FilterBar" id = "FilterBar">
              <p class = "FilterText">Filter:</p>
    
              <div class = "dropdown" id = "sortdropdown">
                <div class = "sortdropdown-title">
                    <p>Sorting</p>
                    <i class="fa-solid fa-caret-down"></i>
                </div>
                <div class = "dropdown-content">
                    <form method = "get">
                        <input type="radio" id="sortNameAscending" name="sortby" value="NameAscending">
                        <label for="sortNameAscending">Name: A-Z</label> <br>
                        <input type="radio" id="sortNameDescending" name="sortby" value="NameDescending">
                        <label for="sortNameDescending">Name: Z-A</label> <br>
                        <input type="radio" id="sortDateAscending" name="sortby" value="DateAscending">
                        <label for="sortDateAscending">Newest Added</label> <br>
                        <input type="radio" id="sortDateDescending" name="sortby" value="DateDescending">
                        <label for="sortDateDescending">Oldest Added</label> <br>
                        <input type="radio" id="sortNone" name="sortby" value="sortnone">
                        <label for="sortNone">None</label> <br>
                        <?php
                        foreach ($_GET as $key => $value) {
                        if ($key !== 'sortby') {
                            echo "<input type='hidden' name='" . htmlspecialchars($key) . "' value='" . htmlspecialchars($value) . "'>";
                        }
                    }
                    ?>
                        <button type="submit" style="color: rgb(0, 162, 255); background-color: white; padding: 5px; border: none; border-radius: 2px;">Apply</button>
                      </form>
                </div>
              </div>            
            </nav> 
        </div>
    </header>
    

    <div class = "DesktopContainer">
        <div class = "SearchContainer">
            <form method="get" class = "searchbar-form" >
                <div class = searchbar>
                    <input type="text" name="search"> <br>

                    <?php
                    foreach ($_GET as $key => $value) {
                    if ($key !== 'search') {
                    echo "<input type='hidden' name='" . htmlspecialchars($key) . "' value='" . htmlspecialchars($value) . "'>";
                    }
                    }
                    ?>
                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>  
          </form>
        </div>


    <div class = "SectionContainer" style="display: none;" id = "SectionContainer-product">
            <?php
          $search = isset($_GET['search']) ? trim($_GET['search']) : '';
          $filter = isset($_GET['Category']) ? $_GET['Category'] : '';
          $hasFilter = false;
          $where = "";


        if (!empty($search)) 
        {
            $searchEscaped = mysqli_real_escape_string($conn, $search);
            $where .= " WHERE (ProductID LIKE '%$searchEscaped%' OR ProductName LIKE '%$searchEscaped%')";
            $hasFilter = true;
        }


        $sort = $_GET['sortby'] ?? 'sortnone';
        switch ($sort) 
        {
          case 'NameAscending':
            $orderBy = "ORDER BY ProductName ASC";
            $hasFilter = true;
            break;
          case 'NameDescending':
            $orderBy = "ORDER BY ProductName DESC";
            $hasFilter = true;
            break;
          case 'DateAscending':
            $orderBy = "ORDER BY listingDate DESC";
            $hasFilter = true;
          break;
          case 'DateDescending':
            $orderBy = "ORDER BY listingDate ASC";
            $hasFilter = true;
          break;
          case 'sortnone':
            $orderBy = "";
            break;
          default:
            $orderBy = "";
          break;
        }


             $listquery = mysqli_query($conn, "SELECT * FROM product $where $orderBy");
             if ($listquery && mysqli_num_rows($listquery) > 0) {
                    while ($row = mysqli_fetch_assoc($listquery)) {
                    $productId = $row["ProductID"];
                    $isSold = $row['isSold'];
                    $listingPicPath = "placeholder logo.png"; // Default fallback
                    $altText = "Product Image";

                    $imageQuery = mysqli_query($conn, "SELECT * FROM productimages WHERE ProductID = '$productId' LIMIT 1");
                    if ($imageQuery && mysqli_num_rows($imageQuery) > 0) {
                        $imgRow = mysqli_fetch_array($imageQuery);
                        if (!empty($imgRow['ImagePath'])) {
                            $listingPicPath = "Images/" . $imgRow['ImagePath'];
                            $altText = $imgRow['altText'];
                        }
                    }
        ?>
            <div class = "referenceItem-Container">
                <div class="referenceItem-ContentContainer">
                    <div class="referenceItem-imageContainer">
                        <img src="<?php echo $listingPicPath ?>" alt="<?php echo $altText ?>">
                    </div>  
                    <div class="referenceItem-middleTextContainer">
                        <div class="referenceItem-PlaceholderReference">
                            <p>Product ID: <?php echo htmlspecialchars($productId)?></p>
                        </div>
                        <div class="referenceItem-PlaceholderDescription">
                            <p><?php echo htmlspecialchars($row['ProductName']) ?></p>
                             <p>Status: <?php
                                        if($isSold == 0) 
                                        {
                                          ?>
                                          <p style="color: green; font-weight: 600;">Listed</p>
                                          <?php
                                        }
                                        else
                                        {
                                          ?>
                                          <p style="color: red; font-weight: 600;">De-Listed</p>
                                          <?php
                                        }
                            ?></p>
                        </div>
                    </div> 
                    <div class="referenceItem-dateButtonContainer">
                        <div class = "referenceItem-DateAndTimeReference">
                            <p><?php echo htmlspecialchars($row['listingDate']) ?></p>
                        </div>
                        <div class="referenceItem-detailsButton">
                            <button onclick="GotoOrder('<?php echo $productId?>')">View Details</button>
                        </div>
                    </div>   
                </div>
            </div>
            <?php 
                    }
                }
            
            ?>

        </div>




        <div class = "SectionContainer" id = "SectionContainer-seller" style="display: none;">
            <?php
          $search = isset($_GET['search']) ? trim($_GET['search']) : '';
          $filter = isset($_GET['Category']) ? $_GET['Category'] : '';
          $hasFilter = false;
          $where = "";


        if (!empty($search)) 
        {
            $searchEscaped = mysqli_real_escape_string($conn, $search);
            $where .= " WHERE (SellerID  LIKE '%$searchEscaped%' OR UserName LIKE '%$searchEscaped%' )";
            $hasFilter = true;
        }


        $sort = $_GET['sortby'] ?? 'sortnone';
        switch ($sort) 
        {
          case 'NameAscending':
            $orderBy = "ORDER BY UserName ASC";
            $hasFilter = true;
            break;
          case 'NameDescending':
            $orderBy = "ORDER BY UserName DESC";
            $hasFilter = true;
            break;
          case 'DateAscending':
            $orderBy = "ORDER BY dateJoined DESC";
            $hasFilter = true;
          break;
          case 'DateDescending':
            $orderBy = "ORDER BY dateJoined ASC";
            $hasFilter = true;
          break;
          case 'sortnone':
            $orderBy = "";
            break;
          default:
            $orderBy = "";
          break;
        }
        $sellers = mysqli_query($conn, "SELECT * FROM seller $where $orderBy"); 

        while ($seller = mysqli_fetch_assoc($sellers)) {
        $profilePic = !empty($seller['ProfilePicFile']) ? "Images/" . $seller['ProfilePicFile'] : "placeholder logo.png"; 
        $sellerID = $seller['SellerID'];
        $userName = htmlspecialchars($seller['UserName']);
        $email = htmlspecialchars($seller['Email']);
        $isVarified = $seller['Verified'];
        if($isVarified == '0')
        {
          $varified = 'No';
        }
        else
        {
          $varified = 'Yes';
        }

        $AllowedToSell = $seller['allowedToSell'];
        if($AllowedToSell == '1')
        {
          $sellerstatus = 'Allowed';
        }
        else
        {
          $sellerstatus = 'De-list';
        }
        $dateJoined = date("d M Y", strtotime($seller['dateJoined']));
        ?>
    
    <div class="seller-card">
        <img src="<?= $profilePic ?>" alt="Profile Picture" class="seller-pic">
        <div class="seller-info">
            <div><strong>ID:</strong> <?= $sellerID ?></div>
            <div><strong>Username:</strong> <?= $userName ?></div>
            <div><strong>Email:</strong><?= $email ?></div>
            <div><strong>Joined:</strong> <?= $dateJoined ?></div>
            <div><strong>Verified:</strong> <?= $varified ?></div>
            <div style="font-weight: 600;"><strong>Status:</strong> <?= $sellerstatus ?></div>
        </div>
        <button></button>
        <a href="treasure_hub_dev_sellerdisplay.php?sellerid=<?= $sellerID ?>">View Details</a>
    </div>

<?php } ?>
        </div>




        <div class = "SectionContainer" id = "SectionContainer-orderID" style="display: none;">
            <?php
          $search = isset($_GET['search']) ? trim($_GET['search']) : '';
          $filter = isset($_GET['Category']) ? $_GET['Category'] : '';
          $hasFilter = false;
          $where = "";


        if (!empty($search)) 
        {
            $searchEscaped = mysqli_real_escape_string($conn, $search);
            $where .= " WHERE (OrderDate  LIKE '%$searchEscaped%' OR OrderStatus LIKE '%$searchEscaped%' )";
            $hasFilter = true;
        }


        $sort = $_GET['sortby'] ?? 'sortnone';
        switch ($sort) 
        {
          case 'NameAscending':
            $orderBy = "ORDER BY OrderID  ASC";
            $hasFilter = true;
            break;
          case 'NameDescending':
            $orderBy = "ORDER BY OrderID  DESC";
            $hasFilter = true;
            break;
          case 'DateAscending':
            $orderBy = "ORDER BY OrderDate DESC";
            $hasFilter = true;
          break;
          case 'DateDescending':
            $orderBy = "ORDER BY OrderDate ASC";
            $hasFilter = true;
          break;
          case 'sortnone':
            $orderBy = "";
            break;
          default:
            $orderBy = "";
          break;
        }
        $orderQuery = mysqli_query($conn, "SELECT * FROM orders $where $orderBy"); 
        while ($order = mysqli_fetch_assoc($orderQuery))
        {
        $orderID = $order['OrderID'];
        $imagePath = "placeholder.png";
        $altText = "Product image";

        $itemQuery = mysqli_query($conn, "SELECT ProductID FROM order_details WHERE OrderID = '$orderID' LIMIT 1");
        if ($item = mysqli_fetch_assoc($itemQuery)) {
            $productID = $item['ProductID'];
            $imageQuery = mysqli_query($conn, "SELECT * FROM productimages WHERE ProductID = '$productID' LIMIT 1");
            if ($image = mysqli_fetch_assoc($imageQuery)) {
                if (!empty($image['ImagePath'])) {
                    $imagePath = "Images/" . $image['ImagePath'];
                    $altText = $image['altText'];
                }
            }
    }
    ?>

    <div class="order-container">
        <div class="order-thumbnail">
            <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($altText) ?>">
        </div>
        <div class="order-details">
            <div class="order-info"><span>Order ID:</span> <?= $orderID ?></div>
            <div class="order-info"><span>Date:</span> <?= $order['OrderDate'] ?></div>
            <div class="order-info"><span>Total:</span> R<?= number_format($order['TotalAmount'] + 35, 2) ?> (incl. delivery)</div>
            <div class="order-info"><span>Status:</span> <?= htmlspecialchars($order['OrderStatus']) ?></div>
        </div>
        <a href="treasure_hub_dev_orderdisplay.php?orderid=<?= $orderID ?>" class="view-btn">View Details</a>
        <!--<button class="view-button" onclick="OpenSummary('<?php// echo $orderID ?>')">View Details</button> -->

    </div>
    <?php
    } 
    ?>
    </div>


    <div class = "SectionContainer" id = "SectionContainer-userID" style="display: none;">
         <?php
          $search = isset($_GET['search']) ? trim($_GET['search']) : '';
          $filter = isset($_GET['Category']) ? $_GET['Category'] : '';
          $hasFilter = false;
          $where = "";


        if (!empty($search)) 
        {
            $searchEscaped = mysqli_real_escape_string($conn, $search);
            $where .= " WHERE (Email LIKE '%$searchEscaped%' OR UserID LIKE '%$searchEscaped%' )";
            $hasFilter = true;
        }


        $sort = $_GET['sortby'] ?? 'sortnone';
        switch ($sort) 
        {
          case 'NameAscending':
            $orderBy = "ORDER BY Email ASC";
            $hasFilter = true;
            break;
          case 'NameDescending':
            $orderBy = "ORDER BY Email DESC";
            $hasFilter = true;
            break;
          case 'DateAscending':
            $orderBy = "ORDER BY dateJoined DESC";
            $hasFilter = true;
          break;
          case 'DateDescending':
            $orderBy = "ORDER BY dateJoined ASC";
            $hasFilter = true;
          break;
          case 'sortnone':
            $orderBy = "";
            break;
          default:
            $orderBy = "";
          break;
        }
        $users = mysqli_query($conn, "SELECT * FROM user $where $orderBy");
        while ($user = mysqli_fetch_assoc($users)) {
            $userID = $user['UserID'];
            $firstName = htmlspecialchars($user['FirstName']);
            $lastName = htmlspecialchars($user['LastName']);
            $email = htmlspecialchars($user['Email']);
            $isActive = $user['IsBanned'];
            if($isActive == 0)
            {
              $status = 'Active';
            }
            else
            {
              $status = 'Banned';
            }
            $dateJoined = date("d M Y", strtotime($user['dateJoined']));
        ?>
    
    <div class="user-card">
        <div class="user-info">
            <div><strong>ID:</strong> <?= $userID ?></div>
            <div><strong>Name:</strong> <?= $firstName . ' ' . $lastName ?></div>
            <div><strong>Email:</strong> <?= $email ?></div>
            <div><strong>Joined:</strong> <?= $dateJoined ?></div>
            <div style="font-weight: 700;"><strong>Status:</strong> <?= $status ?></div>
        </div>
        <a href="treasure_hub_dev_userdisplay.php?userid=<?= $userID ?>" class="view-btn">View Details</a>
    </div>

<?php } ?> 

    </div>

<div class="SectionContainer" id = "SectionContainer-review" style="display: none;">
  <h2>All Reviews</h2>

  <?php 
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
          $filter = isset($_GET['Category']) ? $_GET['Category'] : '';
          $hasFilter = false;
          $where = "";


        if (!empty($search)) 
        {
            $searchEscaped = mysqli_real_escape_string($conn, $search);
            $where .= " WHERE (comment LIKE '%$searchEscaped%' OR rating LIKE '%$searchEscaped%' )";
            $hasFilter = true;
        }


        $sort = $_GET['sortby'] ?? 'sortnone';
        switch ($sort) 
        {
          case 'NameAscending':
            $orderBy = "ORDER BY ReviewID ASC";
            $hasFilter = true;
            break;
          case 'NameDescending':
            $orderBy = "ORDER BY ReviewID DESC";
            $hasFilter = true;
            break;
          case 'DateAscending':
            $orderBy = "ORDER BY reviewDate DESC";
            $hasFilter = true;
          break;
          case 'DateDescending':
            $orderBy = "ORDER BY reviewDate ASC";
            $hasFilter = true;
          break;
          case 'sortnone':
            $orderBy = "";
            break;
          default:
            $orderBy = "";
          break;
        }
    $reviewQuery = "SELECT * FROM review $where $orderBy";
    $reviewResult = $conn->query($reviewQuery);
  if ($reviewResult && $reviewResult->num_rows > 0): ?>
    <?php while($row = $reviewResult->fetch_assoc()): 
      $reviewID = $row['ReviewID'];
      $productID = $row['ProductID'];
      $userID = $row['UserID'];
      $rating = $row['rating'];

      // Get reviewer name
      $name = "Unknown";
      $userQuery = mysqli_query($conn, "SELECT FirstName, LastName FROM user WHERE UserID = '$userID'");
      if ($userQuery && mysqli_num_rows($userQuery) > 0) {
        $user = mysqli_fetch_assoc($userQuery);
        $name = htmlspecialchars($user['FirstName'] . " " . strtoupper($user['LastName'][0]) . ".");
      }

      // Get product name
      $productName = "Unknown Product";
      $productQuery = mysqli_query($conn,"SELECT ProductName FROM product WHERE ProductID = '$productID'");
      if ($productQuery && mysqli_num_rows($productQuery) > 0) {
        $product = mysqli_fetch_assoc($productQuery);
        $productName = $product['ProductName'];
      }

      // Get product image
      $productImage = "placeholder_logo.png";
      $altText = "Product Image";
      $imageQuery = mysqli_query($conn,"SELECT ImagePath, altText FROM productimages WHERE ProductID = '$productID' LIMIT 1");
      if ($imageQuery && mysqli_num_rows($imageQuery) > 0) {
        $images = mysqli_fetch_assoc($imageQuery);
        $productImage = "Images/" . $images['ImagePath'];
        $altText = $images['altText'];
      }
    ?>
      <div class="review-card">
        <img src="<?= htmlspecialchars($productImage) ?>" alt="<?= htmlspecialchars($altText) ?>" class="product-image">
        <div class="review-info">
          <h3>Review #<?= $reviewID ?></h3>
          <p><strong>Reviewer:</strong> <?= $name ?></p>
          <p><strong>Product:</strong> <?= htmlspecialchars($productName) ?></p>
          <p><strong>Rating:</strong> <?= $rating ?>/10</p>
        </div>
        <a href="treasure_hub_dev_reviewdisplay.php?reviewid=<?= $reviewID ?>" class="btn">View Summary</a>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p>No reviews found.</p>
  <?php endif; ?>
</div>

<div class="SectionContainer" id = "SectionContainer-query" style="display: none;">
  <h2>All Queries</h2>
  <?php
  $search = isset($_GET['search']) ? trim($_GET['search']) : '';
          $filter = isset($_GET['Category']) ? $_GET['Category'] : '';
          $hasFilter = false;
          $where = "";


        if (!empty($search)) 
        {
            $searchEscaped = mysqli_real_escape_string($conn, $search);
            $where .= " WHERE (QueryID LIKE '%$searchEscaped%' OR isResolved LIKE '%$searchEscaped%' )";
            $hasFilter = true;
        }


        $sort = $_GET['sortby'] ?? 'sortnone';
        switch ($sort) 
        {
          case 'NameAscending':
            $orderBy = "ORDER BY QueryID ASC";
            $hasFilter = true;
            break;
          case 'NameDescending':
            $orderBy = "ORDER BY QueryID DESC";
            $hasFilter = true;
            break;
          case 'DateAscending':
            $orderBy = "ORDER BY dateCreated DESC";
            $hasFilter = true;
          break;
          case 'DateDescending':
            $orderBy = "ORDER BY dateCreated ASC";
            $hasFilter = true;
          break;
          case 'sortnone':
            $orderBy = "";
            break;
          default:
            $orderBy = "";
          break;
        }
        $querySql = "SELECT * FROM queries $where $orderBy";
        $queryResult = $conn->query($querySql);
        if ($queryResult && $queryResult->num_rows > 0)
        {
          while($row = $queryResult->fetch_assoc())
          {
            $queryID = $row['QueryID'];
            $reason = htmlspecialchars($row['Reason']);
            $dateCreated = date("Y-m-d", strtotime($row['dateCreated']));
            $resolved = ($row['isResolved'] == 1) ? "Yes" : "No";
        ?>
        <div class="query-card">
            <div class="query-info">
              <h3>Query #<?= $queryID ?></h3>
              <p><strong>Reason:</strong> <?= $reason ?></p>
              <p><strong>Date Created:</strong> <?= $dateCreated ?></p>
              <p><strong>Resolved:</strong> <?= $resolved ?></p>
              <a href="treasure_hub_dev_querydisplay.php?queryid=<?= $queryID ?>" class="btn">View Details</a>
            </div>
      </div>
      <?php
          }
        } else echo "No queries found.";
      ?>
</div>




  <div class = "SectionContainer" id = "SectionContainer-foodproduct">
            <?php
          $search = isset($_GET['search']) ? trim($_GET['search']) : '';
          $filter = isset($_GET['Category']) ? $_GET['Category'] : '';
          $hasFilter = false;
          $where = "";


        if (!empty($search)) 
        {
            $searchEscaped = mysqli_real_escape_string($conn, $search);
            $where .= " WHERE (ProductID LIKE '%$searchEscaped%' OR FoodName LIKE '%$searchEscaped%')";
            $hasFilter = true;
        }


        $sort = $_GET['sortby'] ?? 'sortnone';
        switch ($sort) 
        {
          case 'NameAscending':
            $orderBy = "ORDER BY FoodName ASC";
            $hasFilter = true;
            break;
          case 'NameDescending':
            $orderBy = "ORDER BY FoodName DESC";
            $hasFilter = true;
            break;
          case 'DateAscending':
            $orderBy = "ORDER BY ListingDate DESC";
            $hasFilter = true;
          break;
          case 'DateDescending':
            $orderBy = "ORDER BY ListingDate ASC";
            $hasFilter = true;
          break;
          case 'sortnone':
            $orderBy = "";
            break;
          default:
            $orderBy = "";
          break;
        }


             $listquery = mysqli_query($conn, "SELECT * FROM foodproduct $where $orderBy");
             if ($listquery && mysqli_num_rows($listquery) > 0) {
                    while ($row = mysqli_fetch_assoc($listquery)) {
                    $productId = $row["ProductID"];
                    $isSold = $row['isSold'];
                    $listingPicPath = "placeholder logo.png"; // Default fallback
                    $altText = "Product Image";
                    if (!empty($imgRow['ImagePath'])) {
                            $listingPicPath = "Images/" . $row['ImagePath'];
                            $altText = $row['altText'];
                    }

        ?>
            <div class = "referenceItem-Container">
                <div class="referenceItem-ContentContainer">
                    <div class="referenceItem-imageContainer">
                        <img src="<?php echo $listingPicPath ?>" alt="<?php echo $altText ?>">
                    </div>  
                    <div class="referenceItem-middleTextContainer">
                        <div class="referenceItem-PlaceholderReference">
                            <p>Product ID: <?php echo htmlspecialchars($productId)?></p>
                        </div>
                        <div class="referenceItem-PlaceholderDescription">
                            <p><?php echo htmlspecialchars($row['FoodName']) ?></p>
                             <p>Status: <?php
                                        if($isSold == 0) 
                                        {
                                          ?>
                                          <p style="color: green; font-weight: 600;">Listed</p>
                                          <?php
                                        }
                                        else
                                        {
                                          ?>
                                          <p style="color: red; font-weight: 600;">De-Listed</p>
                                          <?php
                                        }
                            ?></p>
                        </div>
                    </div> 
                    <div class="referenceItem-dateButtonContainer">
                        <div class = "referenceItem-DateAndTimeReference">
                            <p><?php echo htmlspecialchars($row['ListingDate']) ?></p>
                        </div>
                        <div class="referenceItem-detailsButton">
                            <button onclick="GotoFoodProduct('<?php echo $productId?>')">View Details</button>
                        </div>
                    </div>   
                </div>
            </div>
            <?php 
                    }
                }
            
            ?>

        </div>



    <div class = "SectionContainer" id = "SectionContainer-foodorderID" >
            <?php
          $search = isset($_GET['search']) ? trim($_GET['search']) : '';
          $filter = isset($_GET['Category']) ? $_GET['Category'] : '';
          $hasFilter = false;
          $where = "";


        if (!empty($search)) 
        {
            $searchEscaped = mysqli_real_escape_string($conn, $search);
            $where .= " WHERE (OrderDate LIKE '%$searchEscaped%' OR OrderStatus LIKE '%$searchEscaped%' )";
            $hasFilter = true;
        }


        $sort = $_GET['sortby'] ?? 'sortnone';
        switch ($sort) 
        {
          case 'NameAscending':
            $orderBy = "ORDER BY OrderID  ASC";
            $hasFilter = true;
            break;
          case 'NameDescending':
            $orderBy = "ORDER BY OrderID  DESC";
            $hasFilter = true;
            break;
          case 'DateAscending':
            $orderBy = "ORDER BY OrderDate DESC";
            $hasFilter = true;
          break;
          case 'DateDescending':
            $orderBy = "ORDER BY OrderDate ASC";
            $hasFilter = true;
          break;
          case 'sortnone':
            $orderBy = "";
            break;
          default:
            $orderBy = "";
          break;
        }
        $orderQuery = mysqli_query($conn, "SELECT * FROM foodorders $where $orderBy"); 
        while ($order = mysqli_fetch_assoc($orderQuery))
        {
        $orderID = $order['OrderID'];
        $imagePath = "placeholder.png";
        $altText = "Product image";

        $itemQuery = mysqli_query($conn, "SELECT ProductID FROM foodorder_details WHERE OrderID = '$orderID' LIMIT 1");
        if ($item = mysqli_fetch_assoc($itemQuery)) {
            $productID = $item['ProductID'];
            $imageQuery = mysqli_query($conn, "SELECT * FROM foodproduct WHERE ProductID = '$productID' LIMIT 1");
            if ($image = mysqli_fetch_assoc($imageQuery)) {
                if (!empty($image['ImagePath'])) {
                    $imagePath = "Images/" . $image['ImagePath'];
                    $altText = $image['altText'];
                }
            }
    }
    ?>

    <div class="order-container">
        <div class="order-thumbnail">
            <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($altText) ?>">
        </div>
        <div class="order-details">
            <div class="order-info"><span>Order ID:</span> <?= $orderID ?></div>
            <div class="order-info"><span>Date:</span> <?= $order['OrderDate'] ?></div>
            <div class="order-info"><span>Total:</span> R<?= number_format($order['TotalAmount'] + 45, 2) ?> (incl. delivery)</div>
            <div class="order-info"><span>Status:</span> <?= htmlspecialchars($order['OrderStatus']) ?></div>
        </div>
        <a href="treasure_hub_dev_foodorderdisplay.php?orderid=<?= $orderID ?>" class="view-btn">View Details</a>
        <!--<button class="view-button" onclick="OpenSummary('<?php// echo $orderID ?>')">View Details</button> -->

    </div>
    <?php
    } 
    ?>
    </div>




    </div>
    <script src="developerlisting.js"></script>
    <script>
      function Logout()
      {
        window.location.href = "treasure_hub_signup_or_login.php";
      }
      function HomeLink()
      {
        window.location.href = "treasure hub developer page home.php";
      }
        function GotoOrder(link)
        {
            window.location.href = "treasure_hub_dev_productdisplay.php?productid="+link;
        }
        function GotoFoodProduct(link)
        {
            window.location.href = "treasure_hub_dev_foodproductdisplay.php?productid="+link;
        }
        function handlelists()
        {
            const sortdropdown = document.getElementById("sortdropdown");
            const sorttitle = sortdropdown.querySelector(".sortdropdown-title");
    
            sorttitle.addEventListener("click",()=>{
            sortdropdown.classList.toggle("active");
            })   
        }
        document.addEventListener("DOMContentLoaded",handlelists)
    </script>
</body>
</html>