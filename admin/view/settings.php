<form method="post" action="" novalidate="novalidate">
    <table class="form-table">

        <tbody>

        <?php wp_nonce_field( 'compute_links_setting_form', 'compute_links_setting_token' ); ?>

        <tr>
            <th scope="row"><label for="box_title">Box Title</label></th>
            <td>
                <input name="box_title" type="text" id="box_title" maxlength="20"
                       value="<?php echo get_option('compute_links_box_title') ?>" class="regular-text">
            </td>
        </tr>

        <tr>
            <th scope="row"><label for="box_color">Box Color</label></th>
            <td>
                <?php $selectColor = get_option('compute_links_box_color'); ?>
                <select name="box_color" id="box_color">
                    <option <?= $selectColor=='gray'? "selected='selected'":'' ?> value="gray">Gray</option>
                    <option <?= $selectColor=='red'? "selected='selected'":'' ?> value="red">Red</option>
                    <option <?= $selectColor=='blue'? "selected='selected'":'' ?> value="blue">Blue</option>
                    <option <?= $selectColor=='green'? "selected='selected'":'' ?> value="green">Green</option>
                    <option <?= $selectColor=='yellow'? "selected='selected'":'' ?> value="yellow">Yellow</option></select>
            </td>
        </tr>

        <tr>
            <th scope="row"><label for="is_short_link">Is Short Link</label></th>
            <td>
                <?php $selectIsShortLink = get_option('compute_links_is_short_link'); ?>
                <select name="is_short_link" id="is_short_link">
                    <option <?= $selectIsShortLink=='1'? "selected='selected'":'' ?> value="1">Yes</option>
                    <option <?= $selectIsShortLink=='0'? "selected='selected'":'' ?> value="0">No</option>
                </select>
            </td>
        </tr>
        </tbody></table>


    <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>

</form>