<?php
$gradeArray = array('1'=>'I','2'=>'II','3'=>'III','4'=>'IV','5'=>'V','6'=>'VI','7'=>'VII','8'=>'VIII','9'=>'IX','10'=>'X','11'=>'XI','12'=>'XII');
$curriculumArray = array('1'=>'CBSE Board','2'=>'ICSE Board','3'=>'Maharashtra Board','9'=>'Karnataka Board','13'=>'Tamil Nadu Board');
$gradeId = $data['gradeId'];
$curriculumId = $data['curriculumId'];
$productType = $data['type'];
$packageName = $data['packageName'];
$grade = $gradeArray[$gradeId];
//$board = $curriculumArray[$curriculumId];

?>
Dear <?php echo $data['name'];?>,
<br /><br />
We are extremely happy to know that you have trusted our services and have paid for "<b><?php echo $packageName;?></b>". We welcome you to the family of paid subscribers of Meritnation.com, a relationship which promises very comprehensive learning supported with our unique diagnostic tools.
<br /><br />
We would like to re-iterate that you have paid for "<b><?php echo $packageName;?></b>" of class <b><?php echo $grade;?></b> starting from  "<?php echo $data['startDate'];?>" & valid up to 15th April 2010, this pack includes:
<br /><br />
<?php if($curriculumId == 1 && $gradeId > 5) { ?>
1. Unlimited access to Model Tests, Practice Tests and Revision Notes along with the free access to NCERT solutions.
<?php }else { ?>
1. Unlimited access to Model Tests, Practice Tests and Revision Notes.
<?php } ?>
<br /><br />
2. This access will be available till 15th April 2010 and is independent of your school session period.
<br /><br />
3. Needless to say that we are always available to resolve your queries and our contact details are mentioned below.
<br /><br /><br />
<b>Details of Client Service Centre:</b>
<br /><br />
Address: Applect Learning Systems Pvt Ltd, A-221, Okhla Phase-I, New Delhi 110020.
<br /><br />
Email: <a href="mailto:support@meritnation.com">support@meritnation.com</a> (Response within 24 hours)
<br /><br />
Phone: 18605005556 (local charges apply) or 011-47195500 (available during 10 AM to 9 PM on all working days)
<br /><br /><br /><br />
Once again we welcome you to our family of paid subscriber of Meritnation.com and we will be glad to provide an extremely satisfying experience during the entire subscription period.
<br /><br />
Regards,
<br /><br />
Meritnation.com Team
<br /><br />
Meritnation Support Team,<br />
Applect Learning Systems (Naukri.com Group Co)<br />
Add: A-221, Okhla Phase-I, New Delhi-20<br />
Phone: 011-40705019