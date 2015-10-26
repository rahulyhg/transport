<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\OrdersTransport */

$this->title = $model->order_id;
$this->params['breadcrumbs'][] = ['label' => 'ใบปฏิบัติงาน', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$truck_model = new \app\models\Truck();
$config = new \app\models\Config_system();
$driver = new app\models\Driver();
?>

<script type="text/javascript">
    function chkNumber(ele) {
        var vchar = String.fromCharCode(event.keyCode);
        if ((vchar < '0' || vchar > '9') && (vchar != '.'))
            return false;
        //ele.onKeyPress = vchar;
    }
</script>
<div class="panel panel-default">
    <div class="panel-heading">
        <i class="fa fa-book"></i> ใบปฏิบัติงาน(รถภายใน)
    </div>
    <div class="panel-body">
        <!--
            #ข้อมูลใบปฏิบัติงาน
            Comment By Kimniyom
        -->
        <div class="jumbotron" style="padding: 5px;">
            <p>
                <?= Html::a('<i class="fa fa-pencil"></i> แก้ไขใบปฏิบัติงาน', ['update', 'id' => $model->id], ['class' => 'btn btn-default btn-xs']) ?>
            </p>
            <div class="row">
                <div class="col-sm-6 col-md-3 col-lg-3"><label>ใบบฏิบัติงาน</label> <label class="label label-success"><?php echo $model->order_id; ?></label></div>
                <div class="col-sm-6 col-md-3 col-lg-3">
                    <label>วันที่ไป</label> 
                    <label class="label label-success">
                        <?php echo $config->thaidate($model->order_date_start); ?>
                    </label>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3">
                    <label>วันที่กลับ</label> 
                    <label class="label label-success">
                        <?php echo $config->thaidate($model->order_date_end); ?>
                    </label>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3">
                    <?php
                    echo "<label>ทะเบียนรถ </label>";
                    $rs = $truck_model->find()->where(['id' => $model->truck1])->one();
                    echo '<label class="label label-success">' . $rs['license_plate'] . '</label>';
                    ?>

                    <?php
                    echo " <label>ทะเบียนพ่วง </label>";
                    $rs2 = $truck_model->find()->where(['id' => $model->truck2])->one();
                    if (!empty($rs2)) {
                        echo '<label class="label label-success">' . $rs2['license_plate'] . '</label>';
                    } else {
                        echo " -";
                    }
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 col-md-2 col-lg-3">
                    <label>คนขับ 1</label> 
                    <label class="label label-success">
                        <?php
                        $d1 = $driver->find()->where(['id' => $model->driver1])->one();
                        echo $d1['name'] . ' ' . $d1['lname'];
                        ?></label>
                </div>
                <div class="col-sm-6 col-md-2 col-lg-3">
                    <label>คนขับ 2</label> 
                    <label class="label label-success">
                        <?php
                        $d2 = $driver->find()->where(['id' => $model->driver2])->one();
                        if (!empty($d2)) {
                            echo $d2['name'] . ' ' . $d2['lname'];
                        } else {
                            echo "-";
                        }
                        ?>
                    </label>
                </div>
            </div>
        </div>
        <!--
            ###################### END #########################
        -->

        <!--
            #ใบสั่งงาน
        -->

        <div>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-truck"></i> <i class="fa fa-angle-up"></i> รายละเอียดขาไป</a></li>
                <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-truck"></i> <i class="fa fa-angle-down"></i> รายละเอียดขากลับ</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content" style="background: #FFF; border: #dedcdc solid 1px; border-top: 0px; padding: 5px;">
                <!-- ฟอร์มกรอกขาไป -->
                <div role="tabpanel" class="tab-pane active" id="home">
                    <div class="panel panel-success">
                        <div class="panel-heading">รายการใบสั่งงาน</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    วันที่ขน <?php
                                    echo DatePicker::widget([
                                        'id' => 'date_start',
                                        'name' => 'date_start',
                                        //'model' => $model,
                                        //'attribute' => 'driver_license_expire',
                                        'language' => 'th',
                                        'value' => date("Y-m-d"),
                                        'removeButton' => false,
                                        'readonly' => true,
                                        'pluginOptions' => [
                                            'autoclose' => true,
                                            'format' => 'yyyy-mm-dd'
                                        ]
                                    ]);
                                    ?>
                                </div>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    ลูกค้า
                                    <select id="customer" class="form-control">
                                        <option value="">== เลือกลูกค้า ==</option>
                                        <?php
                                        $customer = \app\models\Customer::find()->all();
                                        foreach ($customer as $cus):
                                            ?>
                                            <option value="<?php echo $cus->cus_id ?>"><?php echo $cus->cus_id . '-' . $cus->company; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    ใบสั่งงาน 
                                    <input type="text" id="assign_id" name="assign_id" class="form-control" readonly="readonly" value="<?php echo $assign_id; ?>"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    ต้นทาง
                                    <select id="start" class="form-control">
                                        <?php
                                        $changwat = \app\models\Changwat::find()->all();
                                        foreach ($changwat as $ch1):
                                            ?>
                                            <option value="<?php echo $ch1->changwat_id; ?>"><?php echo $ch1->changwat_name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    ปลายทาง
                                    <select id="end" class="form-control">
                                        <?php
                                        foreach ($changwat as $ch2):
                                            ?>
                                            <option value="<?php echo $ch2->changwat_id; ?>"><?php echo $ch2->changwat_name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    ลูกค้าปลายทาง
                                    <select id="customer" class="form-control">
                                        <option value="">== เลือกลูกค้า ==</option>
                                        <?php
                                        $customer_end = \app\models\Customer::find()->all();
                                        foreach ($customer_end as $cusend):
                                            ?>
                                            <option value="<?php echo $cusend->cus_id; ?>"><?php echo $cusend->cus_id . '-' . $cusend->company; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    ประเภทสินค้า
                                    <select id="customer" class="form-control">
                                        <option value=""> == ประเภทสินค้า ==</option>
                                        <?php
                                        $product_type = \app\models\ProductType::find()->all();
                                        foreach ($product_type as $Ptype):
                                            ?>
                                            <option value="<?php echo $Ptype['id'] ?>"><?php echo $Ptype->product_type; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    น้ำหนัก
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" id="weight" name="weight" class="form-control" placeholder="ตัวเลขเท่านั้น..." onkeypress="return chkNumber();"/>
                                            <div class="input-group-addon">ตัน</div>
                                        </div>
                                    </div> 
                                </div>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    จำนวนน้ำมันที่กำหนด
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" id="oil_set" name="oil_set" class="form-control" placeholder="ตัวเลขเท่านั้น..." onkeypress="return chkNumber();"/>
                                            <div class="input-group-addon">ลิตร</div>
                                            <div class="input-group-addon btn btn-default"><i class="fa fa-save"></i> SAVE</div>
                                        </div>
                                    </div> 
                                </div>
                            </div>

                            <div class="jumbotron" style="padding: 5px; margin-top: 10px;">
                                <label>คิดตาม</label>
                                <div class="row">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><input type="radio" name="r1" id="r1" onclick="Unit_price_Calculator()"/> น้ำหนัก ตันละ </div>
                                                <input type="text" id="unit_price" name="unit_price" class="form-control" placeholder="ตัวเลขเท่านั้น..." onkeypress="return chkNumber();" onkeyup="Income_Calculator(1);" disabled="disabled"/>
                                                <div class="input-group-addon">บาท</div>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6"> 
                                        <div class="input-group">
                                            <div class="input-group-addon"><input type="radio" name="r1" id="r2" onclick="Pertimes_Calculator()"/> ต่อเที่ยว เที่ยวละ</div>
                                            <input type="text" id="per_times" name="per_times" class="form-control" placeholder="ตัวเลขเท่านั้น..." onkeypress="return chkNumber();" disabled="disabled" onkeyup="Income_Calculator(2);"/>
                                            <div class="input-group-addon">บาท</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="jumbotron" style="padding: 5px; margin-top: 5px;">
                                <label>เบี้ยเลี้ยง</label>
                                <div class="row">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon">เบี้ยเลี้ยงคนขับ(1)</div>
                                                <input type="text" id="allowance1" name="allowance1" class="form-control" placeholder="ตัวเลขเท่านั้น..." onkeypress="return chkNumber();"/>
                                                <div class="input-group-addon">บาท</div>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6"> 
                                        <div class="input-group">
                                            <div class="input-group-addon">เบี้ยเลี้ยงคนขับ(2)</div>
                                            <?php if (!empty($model->driver2)) { ?>
                                                <input type="text" id="allowance2" name="allowance2" class="form-control" placeholder="ตัวเลขเท่านั้น..." onkeypress="return chkNumber();"/>
                                            <?php } else { ?>
                                                <input type="text" id="allowance2" name="allowance2" class="form-control" placeholder="ตัวเลขเท่านั้น..." onkeypress="return chkNumber();" readonly="readonly"/>
                                            <?php } ?>
                                            <div class="input-group-addon">บาท</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="input-group">
                                        <div class="input-group-addon">รายได้</div>
                                        <input type="text" id="income" name="income" class="form-control" style="font-size: 20px; text-align: center; color: #ff0033;" readonly="readonly" value="0"/>
                                        <div class="input-group-addon">บาท</div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <!-- Table -->
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>วันที่ขน</th>
                                        <th>ลูกค้า</th>
                                        <th>เส้นทาง</th>
                                        <th>ลูกค้าปลายทาง</th>
                                        <th>เลขที่ใบขน</th>
                                        <th>เบี้ยเลี้ยง</th>
                                        <th>รายได้</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6" style="text-align: center;">
                                            รวม
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="panel-footer">
                            <button type="button" class="btn btn-success btn-block btn-lg"><i class="fa fa-save"></i> บันทึกข้อมูล</button>
                        </div>
                    </div>
                    <hr/>

                    <!-- 
                    #### END panel-success ####
                    -->

                    <div class="panel panel-primary">
                        <div class="panel-heading">ค่าเชื้อเพลิง</div>
                        <div class="panel-body">
                            <div class="well well-sm">
                                <div class="row">
                                    <div class="col-sm-4 col-md-4 col-lg-4">
                                        น้ำมันเติม
                                        <div class="input-group">
                                            <input type="text" id="login_email" name="login_email" class="form-control"/>
                                            <div class="input-group-addon">ลิตร</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-4 col-lg-4">
                                        ลิตรละ
                                        <div class="input-group">
                                            <input type="text" id="login_email" name="login_email" class="form-control"/>
                                            <div class="input-group-addon">บาท</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-4 col-lg-4">
                                        รวม
                                        <div class="input-group">
                                            <input type="text" id="login_email" name="login_email" class="form-control" style="font-size: 20px; text-align: center; color: #ff0033;" readonly="readonly"/>
                                            <div class="input-group-addon">บาท</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4 col-md-4 col-lg-4">
                                        แก๊สเติม
                                        <div class="input-group">
                                            <input type="text" id="login_email" name="login_email" class="form-control"/>
                                            <div class="input-group-addon">กก.</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-4 col-lg-4">
                                        กก.ละ
                                        <div class="input-group">
                                            <input type="text" id="login_email" name="login_email" class="form-control"/>
                                            <div class="input-group-addon">บาท</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-4 col-lg-4">
                                        รวม
                                        <div class="input-group">
                                            <input type="text" id="login_email" name="login_email" class="form-control" style="font-size: 20px; text-align: center; color: #ff0033;" readonly="readonly"/>
                                            <div class="input-group-addon">บาท</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button type="button" class="btn btn-success">บันทึกเติมน้ำมัน</button>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">ค่าใช้จ่ายอื่น ๆ</div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">รายการ</div>
                                                    <input type="text" id="login_email" name="login_email" class="form-control"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-9 col-lg-9">  
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">จำนวนเงิน</div>
                                                    <input type="text" id="login_email" name="login_email" class="form-control"/>
                                                    <div class="input-group-addon">บาท</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-3 col-lg-3" style="text-align: center;">
                                            <button type="button" class="btn btn-success btn-block"><i class="fa fa-save"></i> บันทึก</button>
                                        </div>
                                    </div>

                                    <br/>

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>รายการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td style="text-align: center;">รวม</td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">ระยะทาง</div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">เลขไมล์เดิม</div>
                                                    <input type="text" id="login_email" name="login_email" class="form-control"/>
                                                    <div class="input-group-addon">บาท</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">เลขไมล์เที่ยวนี้</div>
                                                    <input type="text" id="login_email" name="login_email" class="form-control"/>
                                                    <div class="input-group-addon">บาท</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">ระยะทางเที่ยวนี้</div>
                                                    <input type="text" id="login_email" name="login_email" class="form-control"/>
                                                    <div class="input-group-addon">ก.ม.</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">สะสมเที่ยวก่อน</div>
                                                    <input type="text" id="login_email" name="login_email" class="form-control"/>
                                                    <div class="input-group-addon">ก.ม.</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">สะสมเที่ยวนี้</div>
                                                    <input type="text" id="login_email" name="login_email" class="form-control"/>
                                                    <div class="input-group-addon">ก.ม.</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">น้ำมันที่กำหนด</div>
                                                    <input type="text" id="login_email" name="login_email" class="form-control"/>
                                                    <div class="input-group-addon">ลิตร</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">เฉลี่ย</div>
                                                    <input type="text" id="login_email" name="login_email" class="form-control"/>
                                                    <div class="input-group-addon">ก.ม./ลิตร</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">ชดเชยน้ำมัน</div>
                                                    <input type="text" id="login_email" name="login_email" class="form-control" readonly="readonly"/>
                                                    <div class="input-group-addon">ลิตร</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="panel panel-danger">
                        <div class="panel-heading">ข้อความ</div>
                        <div class="panel-body">
                            <textarea class="form-control" rows="5"></textarea>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary">บันทึกข้อมูล</button>
                    <button type="button" class="btn btn-danger">ออกจากหน้านี้</button>
                </div>
                <!-- ฟอร์มกรอกขากลับ -->
                <div role="tabpanel" class="tab-pane" id="profile">2</div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">

    //คำนวณรายได้
    function Income_Calculator(type) {
        var weight = $("#weight").val();
        var unit_price = $("#unit_price").val();
        var per_times = $("#per_times").val();
        var total;
        if (type == 1) {
            total = (weight * unit_price);
        } else {
            total = per_times;
        }

        $("#income").val(total);
    }

    //กรณีเลือกคิดตามน้ำหนัก
    function Unit_price_Calculator() {
        var weight = $("#weight").val();
        if (weight == "") {
            $("#unit_price").prop("disabled", true);
            alert("ยังไม่ได้กรอกช่องน้ำหนัก ...");
            $("#r1").prop("checked", false);
            $("#weight").focus();
            return false;
        }
        $("#income").val(0);
        $("#unit_price").prop("disabled", false);
        $("#per_times").prop("disabled", true);
    }

    //กรณีคิดตามเที่ยว
    function Pertimes_Calculator() {
        var weight = $("#weight").val();
        if (weight == "") {
            $("#per_times").prop("disabled", true);
            alert("ยังไม่ได้กรอกช่องน้ำหนัก ...");
            $("#r2").prop("checked", false);
            $("#weight").focus();
            return false;
        }
        $("#income").val(0);
        $("#per_times").prop("disabled", false);
        $("#unit_price").prop("disabled", true);
    }
</script>



