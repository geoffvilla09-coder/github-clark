<?php
// CHECK IF FORM IS SUBMITTED
$submitted = isset($_POST['submit']);
?>
<!DOCTYPE html>
<html lang="en">
<head>s
<meta charset="UTF-8">
<title>Clark’s Pinoy Spicy Chicken Order Form</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
    body {
        background-image: url('');
        background-size: cover;
        background-repeat: no-repeat;
        font-family: Arial, sans-serif;
        padding: 20px;
        color: #222;
    }
    .container, .receipt-box {
        background: rgba(255,255,255,0.95);
        width: 650px;
        padding: 20px;
        border-radius: 10px;
        margin: 20px auto;
        box-shadow: 0 0 10px #888;
    }
    label { font-weight: bold; }
    input[type="text"], textarea {
        width: 100%; padding: 8px; margin-bottom: 12px;
    }
    .section-title {
        font-size: 20px; font-weight: bold; margin-top: 20px;
    }
    #totalDisplay {
        font-size: 22px; color: #b30000; font-weight: bold; margin-top: 20px;
    }
    input[type="submit"] {
        padding: 10px 20px; background: #ff4500; border: none;
        color: white; font-size: 18px; cursor: pointer; border-radius: 5px;
        margin-top: 20px;
    }
    h2 { text-align: center; }
</style>
</head>
<body>

<!-- ORDER FORM -->
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

<div class="section-title">ORDER DETAILS</div>

<label>SIZE:</label><br>
<input type="checkbox" name="size[]" value="Small"> Small
<input type="checkbox" name="size[]" value="Medium"> Medium
<input type="checkbox" name="size[]" value="Large"> Large

<div class="section-title">SIGNATURE DISHES</div>
<p><input type="checkbox" name="item[]" class="item" value="Classic Spicy Chicken - 120"> Classic Spicy Chicken – ₱120</p>
<p><input type="checkbox" name="item[]" class="item" value="Spicy Chicken Wings - 150"> Spicy Chicken Wings – ₱150</p>
<p><input type="checkbox" name="item[]" class="item" value="Spicy Chicken Burger - 130"> Spicy Chicken Burger – ₱130</p>
<p><input type="checkbox" name="item[]" class="item" value="Spicy Chicken Rice Bowl - 140"> Spicy Chicken Rice Bowl – ₱140</p>
<p><input type="checkbox" name="item[]" class="item" value="Cheesy Spicy Chicken - 160"> Cheesy Spicy Chicken – ₱160</p>

<label>Add-ons:</label><br>
<input type="checkbox" name="addon[]" class="addon" value="Extra Rice - 20"> Extra Rice – ₱20
<input type="checkbox" name="addon[]" class="addon" value="Softdrinks - 30"> Softdrinks – ₱30
<input type="checkbox" name="addon[]" class="addon" value="Fries - 40"> Fries – ₱40

<div id="totalDisplay">Total: ₱0</div>

<label>PAYMENT METHOD:</label><br>
<input type="radio" name="payment" value="Cash" required> Cash
<input type="radio" name="payment" value="Gcash"> Gcash
<input type="radio" name="payment" value="Credit Card"> Credit Card

<label>Additional Notes:</label>
<textarea name="notes" rows="5">Enter your comments........</textarea>

<input type="submit" name="submit" value="Submit Order">

<p><img src="clark122.JPG" width="125" height="125"></p>
<p>Submitted by: CLARK L. CADAHING</p>
<p>Submitted to: SHERWIN SANGALANG</p>
<p>Section: BSIT-1F</p>

</form>
</div>

<script>
const items = document.querySelectorAll('.item');
const addons = document.querySelectorAll('.addon');

function calculateTotal() {
    let total = 0;

    items.forEach(i => { if(i.checked) total += parseInt(i.value.split('-')[1]); });
    addons.forEach(a => { if(a.checked) total += parseInt(a.value.split('-')[1]); });

    document.getElementById('totalDisplay').innerText = 'Total: ₱' + total;
}

items.forEach(i => i.addEventListener('change', calculateTotal));
addons.forEach(a => a.addEventListener('change', calculateTotal));
</script>


<!-- RECEIPT SECTION -->
<?php if($submitted): ?>

<?php
$fname = $_POST['Fname'];
$lname = $_POST['Lname'];
$cnum  = $_POST['Cnum'];
$ddate = $_POST['Ddate'];
$payment = $_POST['payment'];
$notes = $_POST['notes'];

$size   = isset($_POST['size']) ? $_POST['size'] : [];
$items  = isset($_POST['item']) ? $_POST['item'] : [];
$addons = isset($_POST['addon']) ? $_POST['addon'] : [];

$total = 0;

// COMPUTE TOTAL
foreach ($items as $i) {
    $total += intval(explode(" - ", $i)[1]);
}
foreach ($addons as $a) {
    $total += intval(explode(" - ", $a)[1]);
}
?>

<div class="receipt-box">
<h2>ORDER RECEIPT</h2>

<h3>Customer Information</h3>
<p><strong>Name:</strong> <?= $fname . " " . $lname ?></p>
<p><strong>Contact Number:</strong> <?= $cnum ?></p>
<p><strong>Preferred Delivery Date:</strong> <?= $ddate ?></p>

<h3>Selected Size:</h3>
<ul>
<?php foreach ($size as $s) echo "<li>$s</li>"; ?>
</ul>

<h3>Ordered Items:</h3>
<ul>
<?php foreach ($items as $i) echo "<li>$i</li>"; ?>
</ul>

<h3>Add-ons:</h3>
<ul>
<?php foreach ($addons as $a) echo "<li>$a</li>"; ?>
</ul>

<h3>Total Amount: <span style="color:red;">₱<?= $total ?></span></h3>

<h3>Payment Method:</h3>
<p><?= $payment ?></p>

<h3>Additional Notes:</h3>
<p><?= nl2br($notes) ?></p>

</div>

<?php endif; ?>

</body>
</html>
