<?phpinclude "../../netting/baglan.php";include "../../include/sql.php";require_once "../../include/data.php";$sepetsql = "SELECT * FROM tblsepet where tur =  'termik' and durum = 1 and isTermik = 0";$sepetler = $db->query($sepetsql);?><section class="content">    <div class="card card-info">        <div class="card-header">            Termik Alanı        </div>        <div class="card-body" id="termik-giris">            <form method="post" action="<?php echo base_url() . 'netting/termik/index.php' ?>"                  enctype="multipart/form-data">               <div class="row">                   <div class="col-sm-12">                       <div class="form-group" >                           <label>Sepetleri Seçiniz</label>                           <div class="select2-blue">                               <select  required name="sepetler[]" class="select2" multiple="multiple"                                       data-dropdown-css-class="select2-blue"                                        data-maximum-selection-length="4"                                        id="termik_sepet_select2"                                       data-placeholder="Sepetleri seçiniz"                                       style="width: 100%;">                                   <?php while ($sepet = $sepetler->fetch_array())  {  ?>                                       <option value="<?php echo $sepet['id']?>"><?php echo $sepet['ad']?></option>                                   <?php } ?>                                <input type="hidden" value="true" name="termikekle">                               </select>                           </div>                       </div>                   </div>               </div>                <div class="card-footer">                    <div>                        <button v-if="sepetler && sepetler.length  != 4" :disabled="isDisabled"                                onclick="return confirm('4 Sepet Seçmek İstemediğinizden Emin Misiniz?')"                                type="submit" class="btn btn-info float-right">Termiği Başlat</button>                        <button v-if=" sepetler && sepetler.length  == 4" :disabled="isDisabled"                                onclick="return confirm('Termik Başlatılıyor?')"                                type="submit" class="btn btn-info float-right">Termiği Başlat</button>                        <a href="../"                           class="btn btn-warning float-left">Vazgeç</a>                    </div>                </div>        </div>        </form>    </div></section>