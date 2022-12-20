<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0"/>
<?php if(isset($titleSeoHeader) && !empty($titleSeoHeader)): ?>
<title><?php echo echoOutput($titleSeoHeader); ?></title>
<?php endif; ?>
</head>

<body>
<style type="text/css">

body{
font-family: Arial,Tahoma, Helvetica, sans-serif;
margin:0;
padding: 0;
}

table {
border-collapse: collapse;
margin: 0;
padding: 0;
width: 100%;
table-layout: fixed;
}

</style>

<div style="background-color: #fff; border: 1px solid #eee; height: 50px; border-radius: 6px;">
<div style="margin: 0 20px;">
<table>
<tr>
<td style="text-align: left; height: 100px; vertical-align:middle;line-height:100px;"><img src="<?php echo $urlPath->image($theme['th_logo']); ?>" style="max-width: 150px; width: 100%; border: none;display: block; vertical-align: middle;"></td>
<td style="text-align: right;">
<?php echo echoOutput($translation['tr_77']); ?>
<b> <?php echo echoOutput($itemDetails['pt_reference']); ?></b>
</td>
</tr>
</table>
</div>

</div>

<!-- End Header -->

<!-- Title & Price -->

<div style="background-color: #fff; border: 1px solid #eee; height: 50px; border-radius: 6px; margin-top: 20px;">
<div style="margin: 0 20px;">
<table>
<tr>
<td style="text-align: left; height: 50px; vertical-align:middle;line-height:50px;"><b style="font-weight: 400"><?php echo getAddress($itemDetails['city'], $itemDetails['zone']); ?></td>
<td style="text-align: right;">
<b><?php echo getPrice($itemDetails['pt_price']); ?>
<?php if(!empty($itemDetails['tr_label'])): ?>
<span> <?php echo echoOutput($itemDetails['tr_label']); ?></span>
<?php endif; ?></b></b>
</td>
</tr>
</table>
</div>

</div>

<!-- Property Description  -->
<div style="background-color: #fff; border: 1px solid #eee; height: 50px; border-radius: 6px; margin-top: 20px;">

<table>
<tr>
<td colspan="4" height="45" style="background-color: #eee; padding-left: 20px; padding-right: 20px; font-weight: bold">
<h4><?php echo echoOutput($translation['tr_69']); ?></h4>
</td>

</tr>
<tr>

<td height="45" style="padding: 10px 20px;">

<?php echo echoOutput($itemDetails['tr_description']); ?>

</td>

</tr>

</table>

</div>

<!-- Property Information -->

<div style="background-color: #fff; border: 1px solid #eee; height: 50px; border-radius: 6px; margin-top: 20px;">


<table>
<tr>
<td colspan="6" height="45" style="background-color: #eee; padding-left: 20px; padding-right: 20px; font-weight: bold">
<h4><?php echo echoOutput($translation['tr_70']); ?></h4>
</td>

</tr>
<tr>
<td height="45" style="padding-left: 20px; font-weight: 600"><?php echo echoOutput($translation['tr_56']); ?></td>
<td height="45" style="text-transform: capitalize;"><?php echo getUnit($itemDetails['pt_size']); ?></td>
<td height="45" style="padding-left: 20px; font-weight: 600"><?php echo echoOutput($translation['tr_57']); ?></td>
<td height="45"><?php echo echoOutput($itemDetails['pt_baths']); ?></td>
<td height="45" style="padding-left: 20px; font-weight: 600"><?php echo echoOutput($translation['tr_58']); ?></td>
<td height="45"><?php echo echoOutput($itemDetails['pt_beds']); ?></td>
</tr>

<tr>
<td height="45" style="padding-left: 20px; font-weight: 600"><?php echo echoOutput($translation['tr_59']); ?></td>
<td height="45"><?php echo echoOutput($itemDetails['pt_floor']); ?></td>
<td height="45" style="padding-left: 20px; font-weight: 600"><?php echo echoOutput($translation['tr_60']); ?></td>
<td height="45"><?php echo echoOutput($itemDetails['type']); ?></td>
<td height="45" style="padding-left: 20px; font-weight: 600"><?php echo echoOutput($translation['tr_61']); ?></td>
<td height="45"><?php echo echoOutput($itemDetails['pt_garages']); ?></td>
</tr>
tr_62
<tr>
<td height="45" style="padding-left: 20px; font-weight: 600"><?php echo echoOutput($translation['tr_62']); ?></td>
<td height="45"><?php echo echoOutput($itemDetails['conditions']); ?></td>
<td height="45" style="padding-left: 20px; font-weight: 600"><?php echo echoOutput($translation['tr_63']); ?></td>
<td height="45" style="text-transform: capitalize;"><?php echo echoOutput($itemDetails['pt_rating']); ?></td>
</tr>

</table>

</div>

<?php if (!empty($itemsExtras)): ?>

<?php
$numOfCols = 4;
$rowCount = 0;
$bootstrapColWidth = 12 / $numOfCols;
?>

<!-- Property Extras  -->
<div style="background-color: #fff; border: 1px solid #eee; height: 50px; border-radius: 6px; margin-top: 20px;">

<table>
<tr>
<td colspan="4" height="45" style="background-color: #eee; padding-left: 20px; padding-right: 20px; font-weight: bold">
<h4><?php echo echoOutput($translation['tr_71']); ?></h4>
</td>

</tr>
<tr>

<?php foreach ($itemsExtras as $item) { ?>  
<td height="45" style="padding-left: 20px;">· <?php echo echoOutput($item['tr_name']); ?></td>
<?php
$rowCount++;
if($rowCount % $numOfCols == 0) echo '</tr><tr>';}
?>

</table>

</div>

<?php endif; ?>

<!-- Property Location  -->
<div style="background-color: #fff; border: 1px solid #eee; height: 50px; border-radius: 6px; margin-top: 20px;">

<table>
<tr>
<td colspan="4" height="45" style="background-color: #eee; padding-left: 20px; padding-right: 20px; font-weight: bold">
<h4><?php echo echoOutput($translation['tr_73']); ?></h4>
</td>

</tr>
<tr>

<td height="45" style="padding-left: 20px;">

<?php echo echoOutput($itemDetails['pt_direction']); ?>

</td>

</tr>

</table>

</div>

</body>
</html>
