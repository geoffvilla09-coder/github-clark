<?php
// --- PROCESS FORM WHEN SUBMITTED ---
$submitted = false;
$summaryHTML = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $submitted = true;

    $Fname = $_POST["Fname"] ?? "";
    $Lname = $_POST["Lname"] ?? "";
    $Cnum = $_POST["Cnum"] ?? "";
    $Ddate = $_POST["Ddate"] ?? "";
    $notes = $_POST["notes"] ?? "";
    $size = $_POST["size"] ?? "";

    $items = $_POST["items"] ?? [];
    $addons = $_POST["addons"] ?? [];
    $payment = $_POST["payment"] ?? "Not Selected";
    $cashAmount = $_POST["cashAmount"] ?? 0;

    // PRICE LIST
    $sizePrice = ["Small" => 0, "Medium" => 50, "Large" => 100];
    $itemPrice = [
        "Classic Spicy Chicken" => 120,
        "Spicy Chicken Wings" => 150,
        "Spicy Chicken Burger" => 130,
        "Spicy Chicken Rice Bowl" => 140,
        "Cheesy Spicy Chicken" => 160
    ];
    $addonPrice = [
        "Extra Rice" => 20,
        "Softdrinks" => 30,
        "Fries" => 40
    ];

    $total = 0;
    $receiptList = "";

    // SIZE
    if ($size !== "") {
        $total += $sizePrice[$size];
        $receiptList .= "<li>$size Size – ₱{$sizePrice[$size]}</li>";
    }

    // ITEMS
    foreach ($items as $i) {
        $total += $itemPrice[$i];
        $receiptList .= "<li>$i – ₱{$itemPrice[$i]}</li>";
    }

    // ADDONS
    foreach ($addons as $a) {
        $total += $addonPrice[$a];
        $receiptList .= "<li>$a – ₱{$addonPrice[$a]}</li>";
    }

    // CHANGE IF CASH
    $change = 0;
    if ($payment === "Cash") {
        $change = $cashAmount - $total;
        if ($change < 0) $change = 0;
    }

    // RESULT HTML
    $summaryHTML = "
        <h2>Order Successfully Submitted!</h2>
        <h3>Thank you, $Fname $Lname!</h3>
        <p><strong>Contact Number:</strong> $Cnum</p>
        <p><strong>Delivery Date:</strong> $Ddate</p>
        <p><strong>Payment Method:</strong> $payment</p>
    ";

    if ($payment === "Cash") {
        $summaryHTML .= "
            <p><strong>Cash Given:</strong> ₱$cashAmount</p>
            <p><strong>Change:</strong> ₱$change</p>
        ";
    }

    $summaryHTML .= "
        <h3>Your Order:</h3>
        <ul>$receiptList</ul>
        <h2>Total: ₱$total</h2>
        <h3>Additional Notes:</h3>
        <p>$notes</p>
    ";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Clark’s Pinoy Spicy Chicken Order Form</title>

<style>
  body { 
    background-image: url("spicy chicken.JPG");
    background-size: cover; 
    background-repeat: no-repeat; 
    background-position: center;
    font-family: Arial, sans-serif; 
    padding: 20px; 
    color: #222; 
  }
  .container { 
    background: rgba(255,255,255,0.9); 
    width: 600px; 
    padding: 20px; 
    border-radius: 10px; 
    margin: auto; 
  }
  label { font-weight: bold; display: block; margin-top: 10px; }
  input[type="text"], input[type="number"], textarea { width: 100%; padding: 8px; margin-bottom: 12px; }
  .btn { padding: 10px 20px; background: #ff4500; border: none; color: white; font-size: 18px; cursor: pointer; border-radius: 5px; margin-top: 15px; }
</style>
</head>

<body>

<?php if ($submitted): ?>
    <div class="container">
        <?= $summaryHTML ?>
        <button onclick="window.print()" class="btn">Print Receipt</button>
    </div>

<?php else: ?>

<div class="container">

<h2>Clark’s Pinoy Spicy Chicken ORDER FORM</h2>

<form method="POST">

<label>First Name:</label>
<input type="text" name="Fname" required>

<label>Last Name:</label>
<input type="text" name="Lname" required>

<label>Contact Number:</label>
<input type="text" name="Cnum" required>

<label>Preferred Delivery Date:</label>
<input type="text" name="Ddate" required>

<label>SIZE:</label>
<p>
  <input type="radio" name="size" value="Small"> Small<br>
  <input type="radio" name="size" value="Medium"> Medium<br>
  <input type="radio" name="size" value="Large"> Large
</p>

<h3>SIGNATURE DISHES</h3>
<p><input type="checkbox" name="items[]" value="Classic Spicy Chicken"> Classic Spicy Chicken – ₱120</p>
<p><input type="checkbox" name="items[]" value="Spicy Chicken Wings"> Spicy Chicken Wings – ₱150</p>
<p><input type="checkbox" name="items[]" value="Spicy Chicken Burger"> Spicy Chicken Burger – ₱130</p>
<p><input type="checkbox" name="items[]" value="Spicy Chicken Rice Bowl"> Spicy Chicken Rice Bowl – ₱140</p>
<p><input type="checkbox" name="items[]" value="Cheesy Spicy Chicken"> Cheesy Spicy Chicken – ₱160</p>

<label>Add-ons:</label>
<p>
  <input type="checkbox" name="addons[]" value="Extra Rice"> Extra Rice – ₱20<br>
  <input type="checkbox" name="addons[]" value="Softdrinks"> Softdrinks – ₱30<br>
  <input type="checkbox" name="addons[]" value="Fries"> Fries – ₱40
</p>

<label>PAYMENT METHOD:</label>
<p>
  <input type="radio" name="payment" value="Cash" onclick="showCash(true)"> Cash
  <input type="radio" name="payment" value="Gcash" onclick="showCash(false)"> Gcash
  <input type="radio" name="payment" value="Credit Card" onclick="showCash(false)"> Credit Card
</p>

<div id="cashInput" style="display:none;">
  <label>Enter Cash Amount:</label>
  <input type="number" name="cashAmount" min="0">
</div>

<label>Additional Notes:</label>
<textarea name="notes" rows="5"></textarea>

<input type="submit" value="Submit Order" class="btn">

</form>

</div>

<script>
function showCash(show) {
    document.getElementById("cashInput").style.display = show ? "block" : "none";
}
</script>

<?php endif; ?>

<p><img src="clark122.JPG" width="125px" height="125px"></p>
<p>&nbsp;Submitted by: CLARK L. CADAHING</p>
<p>&nbsp;Submitted TO: SHERWIN SANGALANG</p>
<p>&nbsp;Section: BSIT-1F</p>

</body>
</html>
