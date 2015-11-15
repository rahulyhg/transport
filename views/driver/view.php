<style tyle="text/css">
    .croppic{
        max-width:200px;
        min-height:250px;
        background: #FFF;
    }
</style>
<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Driver */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'พนักงานขับรถ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$config = new app\models\Config_system();
$SalaryMasterModel = new \app\models\SalaryMaster();
?>

<script type="text/javascript">
    function chkNumber(ele) {
        var vchar = String.fromCharCode(event.keyCode);
        if ((vchar < '0' || vchar > '9') && (vchar != '.'))
            return false;
        //ele.onKeyPress = vchar;
    }
</script>
<!-- Main content -->
<input type="hidden" id="employee" name="employee" value="<?php echo $model->driver_id; ?>"/>
<section class="content">

    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <center>
                        <div id="cropContaineroutput" class="croppic">
                            <?php if (!empty($model->images)) { ?>
                                <img src="<?php echo Url::to('@web/web/uploads/profile/' . $model->images) ?>" class="img-responsive"/>
                            <?php } else { ?>
                                <img src="<?php echo Url::to('@web/web/images/No_image.jpg') ?>" class="img-responsive"/>
                            <?php } ?>
                        </div>
                    </center>
                    <h3 class="profile-username text-center"><?php echo $model->name . ' ' . $model->lname; ?></h3>

                    <p class="text-muted text-center">พนักงานขับรถ</p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>อายุ</b> <a class="pull-right"><?php echo $config->get_age($model->birth); ?> ปี</a>
                        </li>
                        <li class="list-group-item">
                            <b>เลขที่ใบขับขี่</b> <a class="pull-right"><?php echo $model->driver_license_id; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>วันหมดอายุ</b> <a class="pull-right"><?php echo $config->thaidate($model->driver_license_expire); ?></a>
                        </li>
                        <li class="list-group-item">
                            <?php
                            if ($config->Datediff(date("Y-m-d"), $model->driver_license_expire) < 0) {
                                echo "<font style='color:red;'>";
                                echo "<b>หมดอายุ </b><a class=\"pull-right\">" . (+-$config->Datediff(date("Y-m-d"), $model->driver_license_expire)) . ' วัน</a>';
                            } else {
                                echo "<font style='color:green;'>";
                                echo "<b>เหลือ </b><a class=\"pull-right\">" . $config->Datediff(date("Y-m-d"), $model->driver_license_expire) . ' วัน</a>';
                            }

                            echo "</font>";
                            ?>
                        </li>

                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#activity" data-toggle="tab"><i class="fa fa-user"></i> ข้อมูลทั่วไป</a></li>
                    <li><a href="#timeline" data-toggle="tab" onclick="get_history('<?php echo $model->driver_id ?>')"><i class="fa fa-truck"></i> ประวัติการวิ่งรถ</a></li>
                    <li><a href="#settings" data-toggle="tab"><i class="fa fa-bar-chart"></i> ภาพรวม</a></a></li>
                    <li><a href="#salary" data-toggle="tab" onclick="load_salary('<?php echo $model->driver_id ?>');"><i class="fa fa-dollar"></i> บัญชีเงินเดือน</a></a></li>
                    <li><a href="#incom" data-toggle="tab" onclick="load_incom('<?php echo $model->driver_id ?>');"><i class="fa fa-download"></i> รายรับ</a></a></li>
                    <li><a href="#expenses" data-toggle="tab" onclick="load_expenses('<?php echo $model->driver_id ?>');"><i class="fa fa-upload"></i> รายจ่าย</a></a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <?php echo $this->title; ?>
                                <div style="text-align: right; float: right;">
                                    <?= Html::a('<i class="fa fa-pencil"></i> แก้ไข', ['update', 'id' => $model->id], ['class' => '']) ?>
                                    <?=
                                    Html::a('<i class="fa fa-trash"></i> ลบ', ['delete', 'id' => $model->id], [
                                        'class' => '',
                                        'data' => [
                                            'confirm' => 'Are you sure you want to delete this item?',
                                            'method' => 'post',
                                        ],
                                    ])
                                    ?>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                                        <?=
                                        DetailView::widget([
                                            'model' => $model,
                                            'attributes' => [
                                                'id',
                                                'driver_id',
                                                'name',
                                                'lname',
                                                'card_id',
                                                [
                                                    'attribute' => 'birth',
                                                    'format' => 'raw',
                                                    'value' => $config->get_age($model->birth) . ' ปี',
                                                    //'valueColOptions' => ['style' => 'width:30%'],
                                                    'displayOnly' => true
                                                ],
                                                'address',
                                                'tel1',
                                                'tel2',
                                                'driver_license_id',
                                                'driver_license_expire',
                                                'create_date'
                                            ],
                                        ])
                                        ?>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="timeline">
                        <div id="history"></div>
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="settings">

                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="salary">
                        <div class="box box-success">
                            <div class=" box-header with-border">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon">เงินเดือนปัจจุบัน</div>
                                                <?php $salary_active = $SalaryMasterModel->find()->where(['employee' => $model->driver_id, 'active' => 1])->one()['salary']; ?>
                                                <input type="text" id="salary_price" name="salary_price" value="<?php echo $salary_active; ?>" readonly="readonly" class="form-control"/>
                                                <div class="input-group-addon">บาท</div>
                                                <div class="input-group-addon btn btn-default" onclick="dialog_salary_master()">กำหนดเงินเดือน</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon">ประจำเดือน</div>
                                                <select id="month" name="month" class="form-control">
                                                    <?php
                                                    $monthnow = date("m");
                                                    if (strlen($monthnow) > 1) {
                                                        $month = $monthnow;
                                                    } else {
                                                        $month = "0" . $monthnow;
                                                    }
                                                    $month_val = $config->Monthval();
                                                    $month_full = $config->MonthFull();
                                                    for ($i = 0; $i <= 11; $i++):
                                                        ?>
                                                        <option value="<?php echo $month_val[$i]; ?>" <?php
                                                        if ($month_val[$i] == $month) {
                                                            echo "selected = 'selected' ";
                                                        }
                                                        ?>>
                                                                    <?php echo $month_val[$i] . " - " . $month_full[$i]; ?>
                                                        </option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon">ประจำปี</div>
                                                <select id="year" name="year" class="form-control">
                                                    <?php
                                                    $yearnow = date("Y");
                                                    for ($i = $yearnow; $i >= ($yearnow - 2); $i--):
                                                        ?>
                                                        <option value="<?php echo $i; ?>"><?php echo $i + 543; ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                        <button id="" class="btn btn-success btn-block" onclick="save_salary();"><i class="fa fa-money"></i> จ่ายเงินเดือน</button>
                                    </div>
                                </div>
                            </div>
                            <div class=" box-body" id="result-salary">

                            </div>
                            <div class=" box-footer">

                            </div>
                        </div>

                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

</section>
<!-- /.content -->

<!--
    ########### Dialog เพิ่มเงินเดือนพนักงาน ##############
-->
<div class="modal modal-defalut" id="dialog_salary_master">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-dollar"></i> ปรับเงินเดือนพนักงาน</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon">ปรับเงินเดือนใหม่</div>
                        <input type="text" class="form-control" id="salary_new" placeholder="ตัวเลขเท่านั้น" onkeypress="return chkNumber()"/>
                        <div class="input-group-addon">บาท</div>
                        <div class="input-group-addon btn btn-default" onclick="save_salary_master();"><i class="fa fa-save"></i> บันทึก</div>
                    </div>
                </div>

                <div class="box bax-info">
                    <div class="box-body">
                        <div id="result-salary-moaster"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php
$url = Url::to(['driver/img_crop_to_file', 'id' => $model->id]);
$this->registerJs(
        "var croppicContaineroutputOptions = {
        uploadUrl: '" . Yii::$app->urlManager->createUrl('driver/img_save_to_file') . "',
        cropUrl: '" . $url . "',
        outputUrlId: 'cropOutput',
        modal: false,
        loaderHtml: '<div class=\"loader bubblingG\"><span id=\"bubblingG_1\"></span><span id=\"bubblingG_2\"></span><span id=\"bubblingG_3\"></span></div> ',
        onBeforeImgUpload: function () {
            console.log('onBeforeImgUpload')
        },
        onAfterImgUpload: function () {
            console.log('onAfterImgUpload')
        },
        onImgDrag: function () {
            console.log('onImgDrag')
        },
        onImgZoom: function () {
            console.log('onImgZoom')
        },
        onBeforeImgCrop: function () {
            console.log('onBeforeImgCrop')
        },
        onAfterImgCrop: function () {
            window.location.reload();
            console.log('onAfterImgCrop')
        },
        onReset: function () {
            console.log('onReset')
        },
        onError: function (errormessage) {
            console.log('onError:' + errormessage)
        }
    }

    var cropContaineroutput = new Croppic('cropContaineroutput', croppicContaineroutputOptions);
"
);
?>

<script type="text/javascript">
    //ประวัติการวิ่งรถ
    function get_history(driver_id) {
        $("#history").html("<br/><center><i class='fa fa-spinner fa-spin fa-2x text-red'><i></center>");
        var url = "<?php echo Url::to(['history']) ?>";
        var data = {driver_id: driver_id};

        $.post(url, data, function (result) {
            $("#history").html(result);
        });
    }

    //ประวัติการรับเงินเดือน
    function load_salary() {
        $("#result-salary").html("<br/><center><i class='fa fa-spinner fa-spin fa-2x text-red'><i></center>");
        var url = "<?php echo Url::to(['salary/load_salary']) ?>";
        var employee = $("#employee").val();
        var data = {employee: employee};

        $.post(url, data, function (result) {
            $("#result-salary").html(result);
        });
    }

    //เปิด popup dialog master
    function dialog_salary_master() {
        $("#dialog_salary_master").modal();
        load_salary_master();
    }

    //ข้อมูลการขึ้นเงินเดือน
    function load_salary_master() {
        var employee = $("#employee").val();
        $("#result-salary-moaster").html("<br/><center><i class='fa fa-spinner fa-spin fa-2x'><i></center>");
        var url = "<?php echo Url::to(['salary-master/salary_master']) ?>";
        var data = {employee: employee};

        $.post(url, data, function (result) {
            $("#result-salary-moaster").html(result);
        });
    }

    //ฟังก์ชันบันทึกข้อมูลปรับเงินเดือนพนักงาน
    function save_salary_master() {
        var salary = $("#salary_new").val();
        var employee = $("#employee").val();

        if (salary == '') {
            $("#salary_new").focus();
            return false;
        }

        var url = "<?php echo Url::to(['salary-master/save_salary_master']) ?>";
        var data = {salary: salary, employee: employee};
        $.post(url, data, function (success) {
            load_salary_master();
        });
    }

    //ฟังก์ชันบันทึกเงินเดือนพนักงานในแต่ละเดือน
    function save_salary() {
        var url = "<?php echo Url::to(['salary/save']) ?>";
        var salary = $("#salary_price").val();
        var employee = $("#employee").val();
        var month = $("#month").val();
        var year = $("#year").val();

        var data = {
            salary: salary,
            employee: employee,
            month: month,
            year: year
        };

        $.post(url, data, function (result) {
            load_salary();
        });

    }
</script>