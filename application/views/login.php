<?php  include_once "headerfooter/header.php";?>
<div class="row-fluid">
    <br>
    <br>
</div>


<div class="row-fluid">

    <div class="span4">
    </div>
    
    
    <div class="span4">
      <form class="form-signin" id="validation" method="post" action="<?php echo base_url()."login/submit/";?>" >
        <h2 class="form-signin-heading">Please Sign In</h2>
        <input type="text" class="input-block-level required" value="<?php echo $username;?>" name="username" placeholder="Username" >
        <input type="password" class="input-block-level required" value="<?php echo $username;?>" name="password" placeholder="Password">
        <button class="btn btn-large btn-primary" type="submit">Sign in</button>
      </form>
    </div>
    
    
    <div class="span4">
    </div>

</div>
 <?php include_once "headerfooter/footer.php";?>