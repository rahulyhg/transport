<style type="text/css">
    body{color: #666666; font-size: 12px;}
    table tr td{ border-left: #000 solid 1px; border-bottom: #000 solid 1px; padding: 5px;}
    table tr th{ border-left: #000 solid 1px; border-bottom: #000 solid 1px; border-top: #000 solid 1px; padding: 5px; text-align: left; font-weight: normal;}
    table{ border-right: #000 solid 1px;}
    table tr th p{ margin-bottom: 10px;}
    #line{ color: #FFF; font-size: 5px;}
</style>
<?php

use yii\helpers\Url;

$truck_model = new \app\models\Truck();
$config = new \app\models\Config_system();
$driver = new app\models\Driver();
$customer_model = new \app\models\Customer();
$changwat_model = new app\models\Changwat();
$producttype_model = new app\models\ProductType();
$thaibaht = new app\models\Thaibaht();
?>
<!--
    #ข้อมูลใบปฏิบัติงาน
    Comment By Kimniyom
-->
<div style=" position: absolute; left: 50px; top: 30px;">
    <div style="width: 80px;">
        <img src="<?php echo Url::to('@web/web/images/logo.jpg', true) ?>"/>
    </div>
</div>

<div style="float: left; padding-top:50px;">
    <font style=" font-size: 12px;">
    <b><?php echo "ห้างหุ้นส่วนจํากัด ตงตง ทรานสปอร์ต"; ?></b><br/>
    162 หมู่ที่3  ต.พบพระ<br/>
    อ.พบพระ จ.ตาก 63160<br/>
    โทรศัพท์ 081-8868090 แฟกซ์ 055-508914<br/>
    เลขประจำตัวผู้เสียภาษี : 0633557000014
    </font>
</div>

<div style="float:right; top: 20px; position: absolute; right: 50px; text-align: center; font-weight: bold;">
    <p>สำเนา/Copy</p>
    <p>รายการขนส่ง</p>
    <p>วันที่พิใพ์ <?php echo date("Y-m-d H:i:s");?></p>
</div>

<br/>

<table class="table table-bordered" style="width:100%;border-top: #000 solid 1px;" cellpadding="1" cellspacing="0" width="100%">
    <tr>
        <td colspan="2" valign='top'>
            <?php $employer = $customer_model->find()->where(['cus_id' => $model->employer])->one() ?>
        <b>ลูกค้า :</b> <?php echo $employer['company']; ?>
        <div id="line">.</div>
        <b>ที่อยู่ : </b> <?php echo $employer['address']; ?>
        </td>
        <td colspan="2" valign='top'>
            <b>เลขที่ Invoice No.:</b>
            <div id="line">.</div>
            <b>วันที่ Invoice Date :</b>
        </td>
        <td valign='top' style=" text-align: right;">
            <?php echo $model->order_id; ?>
            <div id="line">.</div>
            <?php echo $config->thaidate($model->order_date_start); ?>
        </td>
    </tr>
    <thead>
        <tr>
            <th style=" text-align: center; width: 5%;">#</th>
            <th style="text-align:center; width: 65%;">รายการ</th>
            <th style=" text-align: center; width: 10%;">จำนวน</th>
            <th style="text-align:center; width: 10%;">หน่วยละ</th>
            <th style="text-align:center; width: 15%;">จำนวนเงินสุทธิ(บาท)</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sum = 0;
        $i = 0;
        foreach ($assigns as $rs): $i++;
            $sum = $sum + $rs['income'];
            ?>
            <tr>
                <td style="text-align: center;" valign="top"><?php echo $i; ?></td>
                <td>
                    - ค่าข่นส่งสินค้า <?php echo $producttype_model->find()->where(['id' => $rs['product_type']])->one()['product_type']; ?>
                    <div id="line">.</div>
                    - ลุกค้า <?php echo $customer_model->find()->where(['cus_id' => $rs['cus_start']])->one()['company']; ?>
                    ปลายทาง <?php echo $customer_model->find()->where(['cus_id' => $rs['cus_end']])->one()['company']; ?>
                    <div id="line">.</div>
                    - เส้นทาง <?php echo $changwat_model->find()->where(['changwat_id' => $rs['changwat_start']])->one()['changwat_name']; ?>
                    - <?php echo $changwat_model->find()->where(['changwat_id' => $rs['changwat_end']])->one()['changwat_name']; ?>
                </td>
                <td style=" text-align: center;" valign='top'><?php echo $rs['weigh']?></td>
                <td style=" text-align: right;" valign='top'><?php echo number_format($rs['unit_price'],2)?></td>
                <td style=" text-align: right;" valign="top"><?php echo number_format($rs['income'], 2); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td style=" text-align: center; font-weight: bold;" colspan="4">
                รวมทั้งสิ้น
            </td>
            <td style=" text-align: right; font-weight: bold;" valign='bottom'>
                <?php echo number_format($sum, 2); ?>
            </td>
        </tr>
        <tr>
            <td colspan="5" style=" text-align: right; font-weight: bold;">
                <b>( <?php echo $thaibaht->convert($sum); ?> )</b>
            </td>
        </tr>
       
        <tr>
            <td colspan="5" style=" text-align: center;">
                ในนาม ห้างหุ้นส่วนจำกัด ตงตง ทรานสปอร์ต TONG TONG TRANSPORT LIMITED PARTNERSHIP
            </td>
        </tr>
       
    </tfoot>
</table>

<!--
    ###################### END #########################
-->