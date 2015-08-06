
<?php  include_once "headerfooter/header.php";?>

<?php  include_once "topmenu/topmenu.php";?>


<?php  if($msg!='')echo '<div class="row-fluid"><div class="span12">'.$msg.'</div></div>';?>
    
<div class="row-fluid">
    <div class="span12">
            <div class="panel panel-primary">
            <div class="panel-heading">
            <h3 class="panel-title">Summary Report</h3>
            </div>
            <div class="panel-body">
            
            
            
            
            <div class="table-responsive">
                    <table class="table table-bordered table-striped responsive-utilities">
                      <thead>
                        <tr>
                          <th>
                            Extra small devices
                            <small>Phones (&lt;768px)</small>
                          </th>
                          <th>
                            Small devices
                            <small>Tablets (≥768px)</small>
                          </th>
                          <th>
                            Medium devices
                            <small>Desktops (≥992px)</small>
                          </th>
                          <th>
                            Large devices
                            <small>Desktops (≥1200px)</small>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="is-visible">Visible</td>
                          <td class="is-hidden">Hidden</td>
                          <td class="is-hidden">Hidden</td>
                          <td class="is-hidden">Hidden</td>
                        </tr>
                        <tr>
                          <td class="is-hidden">Hidden</td>
                          <td class="is-visible">Visible</td>
                          <td class="is-hidden">Hidden</td>
                          <td class="is-hidden">Hidden</td>
                        </tr>
                        <tr>
                          <td class="is-hidden">Hidden</td>
                          <td class="is-hidden">Hidden</td>
                          <td class="is-visible">Visible</td>
                          <td class="is-hidden">Hidden</td>
                        </tr>
                        <tr>
                          <td class="is-hidden">Hidden</td>
                          <td class="is-hidden">Hidden</td>
                          <td class="is-hidden">Hidden</td>
                          <td class="is-visible">Visible</td>
                        </tr>
                      </tbody>
                      <tbody>
                        <tr>
                          <td class="is-hidden">Hidden</td>
                          <td class="is-visible">Visible</td>
                          <td class="is-visible">Visible</td>
                          <td class="is-visible">Visible</td>
                        </tr>
                        <tr>
                          <td class="is-visible">Visible</td>
                          <td class="is-hidden">Hidden</td>
                          <td class="is-visible">Visible</td>
                          <td class="is-visible">Visible</td>
                        </tr>
                        <tr>
                          <td class="is-visible">Visible</td>
                          <td class="is-visible">Visible</td>
                          <td class="is-hidden">Hidden</td>
                          <td class="is-visible">Visible</td>
                        </tr>
                        <tr>
                          <td class="is-visible">Visible</td>
                          <td class="is-visible">Visible</td>
                          <td class="is-visible">Visible</td>
                          <td class="is-hidden">Hidden</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
  
  
  
  
            </div>
            </div>
    </div>
</div>
 <?php include_once "headerfooter/footer.php";?>