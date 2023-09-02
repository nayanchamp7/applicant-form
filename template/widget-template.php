<?php
/**
 * Widget Template
 *
 * @category Template
 * @package  Template
 * @author   Nazrul Islam Nayan <nazrulislamnayan7@gmail.com>
 * @license  GPL3 https://www.gnu.org/licenses/gpl-3.0.en.html
 * @link     https://github.com/nayanchamp7/applicant-form
 * @since    1.0.0
 */
?>
<style>
    .afm-table, .afm-table th, .afm-table td {
        border: 1px solid black;
        border-collapse: collapse;
    }

    .afm-table th, .afm-table td {
        padding: 5px;
    }
</style>
<table class="afm-table">
    <tr>
        <th><?php _e("Name", "applicant-form"); ?></th>
        <th width="50%"><?php _e("Email", "applicant-form"); ?></th>
        <th><?php _e("Mobile", "applicant-form"); ?></th>
    </tr>

    <?php foreach($attendee_list as $attendee): ?>
    <tr>
        <td style="text-align:center;"><?php echo $attendee->first_name; ?></td>
        <td width="50%" style="text-align:center;"><?php echo $attendee->email; ?></td>
        <td style="text-align:center;"><?php echo $attendee->mobile; ?></td>
    </tr>
    <?php endforeach; ?>
</table>
