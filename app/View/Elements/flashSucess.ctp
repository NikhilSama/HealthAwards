<?php if($session->check('Message.flash')) {
$errors = $session->read('Message.flash.params');
?>
 <div class="success msg">
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
            <td rowspan="2" class="image"></td>
            <td class="title">Success</td>
        </tr>
        <tr>
            <td class="message">
                <ul>
                   <?php foreach($errors as $key=>$error) {?>
                    <li><?php echo $error; ?></li>
                    <?php } ?>
                </ul>
            </td>
        </tr>
        </table>
    </div>
  <?php } ?>