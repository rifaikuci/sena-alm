<?php
require_once "../../netting/baglan.php";
require_once "../../include/sql.php";
require_once "../../include/helper.php";
require_once "../../include/style.php";
$profilId = $_POST['profilId'];
$boy = $_POST['boy'];


$sql = "
select str_to_date(b.bitisZamani, '%d.%m.%Y %H:%i') as bitisZamani,
       b.id                                         as id,
       b.fire,
       b.guncelGr,
       biyetBoy,
       b.araIsFire,
       b.konveyorBoy,
       b.boylamFire,
       b.baskiFire
from tblbaski b
ORDER BY b.bitisZamani desc
LIMIT 5
 ";
$profil = tablogetir("tblprofil", 'id', $profilId, $db);
$result = $db->query($sql);


?>

<style>
    body{
        padding-top:50px;
        background-color:#34495e;
    }



    .hiddenRow {
        padding: 0 !important;
    }
</style>
<div style="text-align: center">
    <h4 style="color: #0e84b5">
        Profil Geçmişi (Son 5 )
    </h4>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label style="color: #0b2e13">Profil: <?php echo $profil['profilNo'] . " - " . $profil['profilAdi'] ?></label>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label style="color: #0b2e13">Boy: <?php echo $boy ?></label>
        </div>
    </div>
</div>

<div class="container">
    <div class="col-md-12">
        <div class="panel panel-default">

            <div class="panel-body">
                <table class="table table-condensed table-striped">
                    <thead>
                    <tr>
                        <th>Fist Name</th>
                        <th>Last Name</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Status</th>
                    </tr>
                    </thead>

                    <tr data-toggle="collapse" data-target="#demo2" class="accordion-toggle">
                        <td>Carlos</td>
                        <td>Mathias</td>
                        <td>Leme</td>
                        <td>SP</td>
                        <td>new</td>
                    </tr>

                    <tr>
                        <td colspan="12" class="hiddenRow">
                            <div class="accordian-body collapse" id="demo2">
                                <table class="table table-striped">
                                    <thead style="background-color: #0b93d5">
                                    <tr class="info">
                                        <th>Job</th>
                                        <th>Company</th>
                                        <th>Salary</th>
                                        <th>Date On</th>
                                        <th>Date off</th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                    <tr data-toggle="collapse"  class="accordion-toggle" data-target="#demo10">
                                        <td>Enginner Software</a></td>
                                        <td>Google</td>
                                        <td>U$8.00000 </td>
                                        <td> 2016/09/27</td>
                                        <td> 2017/09/27</td>

                                    </tr>

                                    <tr>
                                        <td>Scrum Master</td>
                                        <td>Google</td>
                                        <td>U$8.00000 </td>
                                        <td> 2016/09/27</td>
                                        <td> 2017/09/27</td>
                                       
                                    </tr>


                                    <tr>
                                        <td>Back-end</td>
                                        <td>Google</td>
                                        <td>U$8.00000 </td>
                                        <td> 2016/09/27</td>
                                        <td> 2017/09/27</td>
                                     
                                    </tr>

                                    <tr>
                                        <td>Back-end</td>
                                        <td>Google</td>
                                        <td>U$8.00000 </td>
                                        <td> 2016/09/27</td>
                                        <td> 2017/09/27</td>

                                    </tr>   <tr>
                                        <td>Back-end</td>
                                        <td>Google</td>
                                        <td>U$8.00000 </td>
                                        <td> 2016/09/27</td>
                                        <td> 2017/09/27</td>

                                    </tr>   <tr>
                                        <td>Back-end</td>
                                        <td>Google</td>
                                        <td>U$8.00000 </td>
                                        <td> 2016/09/27</td>
                                        <td> 2017/09/27</td>

                                    </tr>
                                    <tr>
                                        <td>Front-end</td>
                                        <td>Google</td>
                                        <td>U$8.00000 </td>
                                        <td> 2016/09/27</td>
                                        <td> 2017/09/27</td>
                                        
                                    </tr>


                                    </tbody>
                                </table>

                            </div>
                        </td>
                    </tr>

                    <tr data-toggle="collapse" data-target="#demo3" class="accordion-toggle">
                        <td>Carlos</td>
                        <td>Mathias</td>
                        <td>Leme</td>
                        <td>SP</td>
                        <td>new</td>
                    </tr>

                    <tr>
                        <td colspan="12" class="hiddenRow">
                            <div class="accordian-body collapse" id="demo3">
                                <table class="table table-striped">
                                    <thead style="background-color: #0b93d5">
                                    <tr class="info">
                                        <th>Job</th>
                                        <th>Company</th>
                                        <th>Salary</th>
                                        <th>Date On</th>
                                        <th>Date off</th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                    <tr data-toggle="collapse"  class="accordion-toggle" data-target="#demo10">
                                        <td>Enginner Software</a></td>
                                        <td>Google</td>
                                        <td>U$8.00000 </td>
                                        <td> 2016/09/27</td>
                                        <td> 2017/09/27</td>

                                    </tr>

                                    <tr>
                                        <td>Scrum Master</td>
                                        <td>Google</td>
                                        <td>U$8.00000 </td>
                                        <td> 2016/09/27</td>
                                        <td> 2017/09/27</td>

                                    </tr>


                                    <tr>
                                        <td>Back-end</td>
                                        <td>Google</td>
                                        <td>U$8.00000 </td>
                                        <td> 2016/09/27</td>
                                        <td> 2017/09/27</td>

                                    </tr>

                                    <tr>
                                        <td>Back-end</td>
                                        <td>Google</td>
                                        <td>U$8.00000 </td>
                                        <td> 2016/09/27</td>
                                        <td> 2017/09/27</td>

                                    </tr>   <tr>
                                        <td>Back-end</td>
                                        <td>Google</td>
                                        <td>U$8.00000 </td>
                                        <td> 2016/09/27</td>
                                        <td> 2017/09/27</td>

                                    </tr>   <tr>
                                        <td>Back-end</td>
                                        <td>Google</td>
                                        <td>U$8.00000 </td>
                                        <td> 2016/09/27</td>
                                        <td> 2017/09/27</td>

                                    </tr>
                                    <tr>
                                        <td>Front-end</td>
                                        <td>Google</td>
                                        <td>U$8.00000 </td>
                                        <td> 2016/09/27</td>
                                        <td> 2017/09/27</td>

                                    </tr>


                                    </tbody>
                                </table>

                            </div>
                        </td>
                    </tr>

                    <tr data-toggle="collapse" data-target="#demo4" class="accordion-toggle">
                        <td>Carlos</td>
                        <td>Mathias</td>
                        <td>Leme</td>
                        <td>SP</td>
                        <td>new</td>
                    </tr>

                    <tr>
                        <td colspan="12" class="hiddenRow">
                            <div class="accordian-body collapse" id="demo4">
                                <table class="table table-striped">
                                    <thead style="background-color: #0b93d5">
                                    <tr class="info">
                                        <th>Job</th>
                                        <th>Company</th>
                                        <th>Salary</th>
                                        <th>Date On</th>
                                        <th>Date off</th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                    <tr data-toggle="collapse"  class="accordion-toggle" data-target="#demo10">
                                        <td>Enginner Software</a></td>
                                        <td>Google</td>
                                        <td>U$8.00000 </td>
                                        <td> 2016/09/27</td>
                                        <td> 2017/09/27</td>

                                    </tr>

                                    <tr>
                                        <td>Scrum Master</td>
                                        <td>Google</td>
                                        <td>U$8.00000 </td>
                                        <td> 2016/09/27</td>
                                        <td> 2017/09/27</td>

                                    </tr>


                                    <tr>
                                        <td>Back-end</td>
                                        <td>Google</td>
                                        <td>U$8.00000 </td>
                                        <td> 2016/09/27</td>
                                        <td> 2017/09/27</td>

                                    </tr>

                                    <tr>
                                        <td>Back-end</td>
                                        <td>Google</td>
                                        <td>U$8.00000 </td>
                                        <td> 2016/09/27</td>
                                        <td> 2017/09/27</td>

                                    </tr>   <tr>
                                        <td>Back-end</td>
                                        <td>Google</td>
                                        <td>U$8.00000 </td>
                                        <td> 2016/09/27</td>
                                        <td> 2017/09/27</td>

                                    </tr>   <tr>
                                        <td>Back-end</td>
                                        <td>Google</td>
                                        <td>U$8.00000 </td>
                                        <td> 2016/09/27</td>
                                        <td> 2017/09/27</td>

                                    </tr>
                                    <tr>
                                        <td>Front-end</td>
                                        <td>Google</td>
                                        <td>U$8.00000 </td>
                                        <td> 2016/09/27</td>
                                        <td> 2017/09/27</td>

                                    </tr>


                                    </tbody>
                                </table>

                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</div>





