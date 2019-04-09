<?php
/**
 * Réglage des options - Google Analytics.
 * ---------------------------------------------------------------------------------------------------------------------
 * @var tiFy\Contracts\View\ViewController $this
 */
?>

<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <?php _e('Code Google Analytics', 'tify'); ?><br>
            <em>
                <a href="http://www.google.com/analytics/"
                   title="<?php _e('Vers le site officiel de Google Analytics', 'tify'); ?>"
                   style="font-size:11px; text-decoration:none;"
                   target="_blank">
                    <?php _e('Site Google Analytics', 'tify'); ?>
                </a>
            </em>
        </th>
        <td>
            <input type="text" name="seo_ua_code" value="<?php echo $this->get('ua_code'); ?>"/>
        </td>
    </tr>
    </tbody>
</table>