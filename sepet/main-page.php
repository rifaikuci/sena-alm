<?php

include "../netting/baglan.php";
include "../include/sql.php";

?>

<section class="content">

    <div style="text-align: center">
        <h4 style="color: #0b93d5">Sepetler</h4>
    </div>
    <div class="card-body"  id="sepet-goster">
        <div class="row">

            <div class="col-sm-3">
                <div class="form-group clearfix">
                    <div style="text-align: center">
                        <div class="icheck-primary d-inline">
                            <input
                                    @input="degistir($event,'termik')"
                                    type="checkbox" id="checkboxPrimary1" v-model="termik" >
                            <label style="color: #0e84b5" for="checkboxPrimary1">
                                Termik Sepeti
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group clearfix">
                    <div style="text-align: center">
                        <div class="icheck-primary d-inline">
                            <input
                                    @input="degistir($event,'kromat')"
                                    type="checkbox" id="checkboxPrimary2" v-model="kromat">
                            <label style="color: #0e84b5" for="checkboxPrimary2">
                                Kromat
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group clearfix">
                    <div style="text-align: center">
                        <div class="icheck-primary d-inline">
                            <input
                                    @input="degistir($event,'araba')"
                                    type="checkbox" id="checkboxPrimary3" v-model="araba">
                            <label style="color: #0e84b5" for="checkboxPrimary3">
                                Araba
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group clearfix">
                    <div style="text-align: center">
                        <div class="icheck-primary d-inline">
                            <input
                                    @input="degistir($event,'kromatS')"
                                    type="checkbox" id="checkboxPrimary4" v-model="kromatS">
                            <label style="color: #0e84b5" for="checkboxPrimary4">
                                Kromat Araba
                            </label>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Sepet No</th>
                                <th>Tür</th>
                                <th>İçindekiler</th>
                                <th style="text-align: center">İşlem</th>
                            </tr>
                            </thead>

                                <tr v-for="(sepet,index) in filter">
                                    <td>{{index+1}}</td>
                                    <td>{{sepet.ad}}</td>
                                    <td>{{sepet.tur}}</td>
                                    <td>{{sepet.isBos}}</td>
                                    <td style="text-align: center">
                                        <button type="button" v-on:click="detayGoster($event,sepet.id)"
                                                class="btn btn-outline-dark"
                                                data-toggle="modal">
                                            <i class="fa fa-expand"></i>
                                        </button>
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                        <div id="detail_sepet" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-xl">

                                <div class="modal-content">
                                    <div style="margin: 10px">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <div class="modal-body">
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
</section>