<?php
/* @var $this ReservationController */
/* @var $data Reservation */
$package = "";
if($data['is_custom'] == '0'){
	$package  = Package::model()->findByPk($data['package_id'])->name;
}
else{
	$package = "CUSTOM";
}

$customer = Customer::model()->findByPk($data['customer_id'])->name;
?>


<div class="row datarow">

	<div class='col-sm-2 cells'>
		<?php echo $data['code']; ?>
	</div>
	<div class='col-sm-5 cells'>
		<?php echo $package; ?>
	</div>
	<div class='col-sm-4 cells'>
		<?php echo $customer; ?>
	</div>
	<div class='col-sm-2 cells'>
		<?php echo $data['eff_date']; ?>
	</div>
	<div class='col-sm-2 cells'>
		<?php echo $data['total']; ?>
	</div>


	<div class='col-sm-1 cells btn-cog text-right'>
        <a href="<?php echo Yii::app()->createUrl("reservation") ?>/<?php echo $data['id']; ?>" data-id="<?php echo $data['id']; ?>" model="Reservation" controler="ReservationController" data-toggle="tooltip" data-placement="top" title="Details" target="_blank"><span class="glyphicon glyphicon-heart"></span></a>
		<?php
		if($data['is_accepted'] == '0'){
			?>
			<a class="accept"  href="" data-id="<?php echo $data['id']; ?>"  data-toggle="tooltip" data-placement="top" title="Accept"><span class="glyphicon glyphicon-ok"></span></a>
			<?php
		}
		else{
			?>
			<a class="reject"  href="" data-id="<?php echo $data['id']; ?>"  data-toggle="tooltip" data-placement="top" title="Reject"><span class="glyphicon glyphicon-remove"></span></a>


			<?php
		}
		?>
	</div>

</div>
