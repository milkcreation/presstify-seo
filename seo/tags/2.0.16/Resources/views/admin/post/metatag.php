<?php
/**
 * Réglage des metadonnées - Meta Tags.
 * ---------------------------------------------------------------------------------------------------------------------
 * @var tiFy\Contracts\View\ViewController $this
 */
?>

<div class="Seo-pmtag">

    <div class="Seo-pmtagPreview">
        <h3><?php _e('Prévisualisation :', 'tify'); ?></h3>

        <h3 class="Seo-pmtagPreviewTitle" data-aim="title">
            <?php echo $this->get('title') ? : $this->get('orig_title'); ?>
        </h3>
        <br/>

        <div class="Seo-pmtagPreviewUrl" >
            <cite data-aim="url">
                <?php echo $this->get('url') ? : $this->get('orig_url'); ?>
            </cite>
        </div>

        <div class="Seo-pmtagPreviewDesc" data-aim="desc">
            <?php echo $this->get('desc') ? : $this->get('orig_desc'); ?>
        </div>
    </div>

    <hr>

    <div class="Seo-pmtagCustom">
        <h3><?php _e('Personnalisation :', 'tify'); ?></h3>

        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row">
                    <?php _e('Balise titre', 'tify'); ?>
                </th>

                <td>
                    <?php
                    echo field(
                        'text-remaining',
                        [
                            'name'     => '_seo_metatag[title]',
                            'value'    => $this->get('title') ? : $this->get('orig_title'),
                            'selector' => 'input',
                            'max'      => 60,
                            'attrs'    => [
                                'placeholder'  => $this->get('orig_title'),
                                'autocomplete' => 'off',
                                'data-target'  => 'title',
                                'data-orig'   => $this->get('orig_title'),
                            ]
                        ]
                    );
                    ?>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <?php _e('Balise description', 'tify'); ?><br>
                </th>
                <td>
                    <?php
                    echo field(
                        'text-remaining',
                        [
                            'name'  => '_seo_metatag[desc]',
                            'value' => $this->get('desc') ? : $this->get('orig_desc'),
                            'max'   => 155,
                            'attrs' => [
                                'placeholder'  => $this->get('orig_desc'),
                                'data-target' => 'desc',
                                'data-orig'   => $this->get('orig_desc'),
                            ]
                        ]); ?>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <?php _e('Url canonique', 'tify'); ?>
                    <em style="display:block;font-size:0.8em;color:#999;">
                        <?php _e('Utilisateur avancé', 'tify'); ?>
                    </em>
                </th>
                <td>
                    <?php
                    echo field(
                        'text',
                        [
                            'name'  => '_seo_metatag[url]',
                            'value' => $this->get('url') ? : $this->get('orig_url'),
                            'attrs' => [
                                'class'        => 'widefat',
                                'placeholder'  => $this->get('orig_url'),
                                'autocomplete' => 'off',
                                'data-target'  => 'url',
                                'data-orig'   => $this->get('orig_url'),
                            ]
                        ]
                    );
                    ?>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>