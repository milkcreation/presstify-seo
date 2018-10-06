<?php
/**
 * @var tiFy\Contracts\Views\ViewInterface $this .
 */
?>

<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <label><?php _e('Activer l\'OpenGraph', 'tify'); ?></label>
        </th>
        <td>
            <?php
            echo field(
                'toggle-switch',
                [
                    'name'  => 'seo_open_graph[active]',
                    'value' => $this->get('open_graph.active')
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
                    'name'   => 'seo_open_graph[image]',
                    'value'  => $this->get('open_graph.image'),
                    'width'  => 300,
                    'height' => 300
                ]
            );
            ?>
        </td>
    </tr>
    </tbody>
</table>