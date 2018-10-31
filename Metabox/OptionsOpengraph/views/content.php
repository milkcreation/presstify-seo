<?php
/**
 * @var tiFy\Contracts\View\ViewController $this
 */
?>

<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <label><?php _e('Activer l\'Opengraph', 'tify'); ?></label>
        </th>
        <td>
            <?php
            echo field(
                'toggle-switch',
                [
                    'name'  => 'seo_opengraph[active]',
                    'value' => $this->get('opengraph.active')
                ]
            );
            ?>
        </td>
    </tr>
    <tr>
        <th scope="row">
            <label><?php _e('Image représentative du site (pour le partage)', 'tify'); ?></label>

            <em style="font-size:11px; color:#999; display:block;">
                <?php
                printf(
                    __('HD : %s | LD : %s', 'tify'),
                    '[1200x1200]',
                    '[600x600]'
                );
                ?>
            </em>
        </th>
        <td>
            <?php
            echo field(
                'media-image',
                [
                    'name'   => 'seo_opengraph[image]',
                    'value'  => $this->get('opengraph.image'),
                    'width'  => 300,
                    'height' => 300
                ]
            );
            ?>
        </td>
    </tr>
    </tbody>
</table>