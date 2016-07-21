  <style>
.container{
  text-align: justify; 
  display: block;
  font-family: 'Courier-New', Courier, monospace;
  font-size: 18px;
  color:black;
  margin: 1em 1em 1em 1em;
  padding: 1em 1em 1em 1em;
}

.box {
  padding: 1em 1em 1em 1em;
}

</style>

<div class="container">
  <div class="box">
    <h4> Hi,<pre><?php echo $customer['email']; ?></h4></pre>
    <p>This is confirmation message for your payment. You used your <?php echo $charge['brand']; ?> card to pay $<?php echo $charge['amount']; ?> CAD to Alpacode</p>
    <p>Thank you, we appreciate your business.</p>
    <p>The Alpacode team.</p>  
  </div>
</div>


