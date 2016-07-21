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
    Hello Webmaster,
      <h4><?php echo $postdata['name']; ?></h4>has sent a mesage detailing payment as follows:</p>
      <p>This is the number of the invoice:
      <b><p><?php echo $postdata['invoice']; ?></b>
      <p> The body of his message is:</p>
      <pre><p><?php echo $postdata['message']; ?>.</pre>
      <b><p>The contact has the following info avalible:</b>
      <p>Mail:  <?php echo $postdata['email']; ?> 
      <p>Phone: <?php echo $postdata['phone']; ?> </p>

      <h6>This message was generated from the alpacode payment gateway.</h6>
  </div>
</div>

