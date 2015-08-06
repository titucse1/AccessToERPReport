<div class="menuWrapper">
<div class="row-fluid">
	<div class="span9">
                <nav class="navbar navbar-default" role="navigation">
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style=" height:auto;">
                  <ul class="nav navbar-nav">
                        
                        <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Home <span class="caret"></span></a>
                              <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo base_url();?>">Home</a></li>
                                <li><a href="<?php echo base_url().'development';?>">Development</a></li>
                              </ul>
                        </li>
                        <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Agent <span class="caret"></span></a>
                              <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo base_url().'agentBonus';?>">Agent Bonus Calculation</a></li>
                                <li><a href="<?php echo base_url().'person';?>">Person List</a></li>
                                <li><a href="<?php echo base_url().'package_list';?>">Product Package</a></li>
                              </ul>
                        </li>
                        
                                              
                         <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reports <span class="caret"></span></a>
                              <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo base_url().'last_transaction';?>">View Last Transaction</a></li>
                                <li><a href="<?php echo base_url().'report_by_product';?>">Report By Product</a></li>
                                <li><a href="<?php echo base_url().'report_by_person';?>">Report By Person</a></li>
                              </ul>
                        </li>
                        
                        
                        
                        <li><a href="<?php echo base_url().'logout/';?>">Logout</a></li>
                  </ul>

                </div><!-- /.navbar-collapse -->
                </nav>
    </div>
    <div class="span3">
    <h5 style="margin-bottom:0; text-align:right; line-height: 14px;">Hello, <?php echo $this->session->userdata('Admin_Info_Full_Name')?></h5>
    </div>
</div>
</div>
<hr style="margin:0px"/>