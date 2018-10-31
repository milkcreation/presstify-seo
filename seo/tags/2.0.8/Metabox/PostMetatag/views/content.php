<?php
/**
 * @var tiFy\Contracts\View\ViewController $this
 */
?>

<div id="tify_seo_taboox_meta">
    <div id="tify_seo_meta-preview">
        <?php $title = $value['title'] ? esc_attr($value['title']) : $original_title; ?>
        <span id="tify_seo_meta_title-preview"
              data-original="<?php echo $original_title; ?>"><?php echo $title; ?></span>

        <?php $url = $value['url'] ? esc_url($value['url']) : $original_url; ?>
        <span id="tify_seo_meta_url-preview"
              data-original="<?php echo $original_url; ?>"><?php echo $url; ?></span>

        <?php $desc = $value['desc'] ? esc_attr(tify_excerpt($value['desc'])) : strip_tags(html_entity_decode($original_desc)); ?>
        <p id="tify_seo_meta_desc-preview"
           data-original="<?php echo $original_desc; ?>"><?php echo $desc; ?></p>
    </div>
    <h3><?php _e('Personnalisation', 'tify'); ?></h3>
    <table class="form-table">
        <tbody>
        <tr>
            <th scope="row">
                <?php _e('Balise titre', 'tify'); ?><br>
            </th>
            <td>
                <input type="text" id="tify_seo_meta_title" data-fill_out="#tify_seo_meta_title-preview"
                       name="tify_meta_post[_tify_seo_meta][title]" placeholder="<?php echo $original_title; ?>"
                       value="<?php echo $value['title']; ?>" autocomplete="off">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <?php _e('Balise description', 'tify'); ?><br>
            </th>
            <td>
                <?php tify_control_text_remaining([
                    'container_id' => 'tify_seo_meta_desc-wrapper',
                    'id'           => 'tify_seo_meta_desc',
                    'name'         => 'tify_meta_post[_tify_seo_meta][desc]',
                    'value'        => $value['desc'],
                    'length'       => 156,
                    'maxlength'    => true,
                    'attrs'        => [
                        'data-fill_out' => '#tify_seo_meta_desc-preview',
                        'placeholder'   => $original_desc
                    ]
                ]); ?>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <?php _e('Url canonique', 'tify'); ?><br>
                <em style="font-size:0.8em;color:#999;"><?php _e('Utilisateur avancé', 'tify'); ?></em>
            </th>
            <td>
                <input type="text" id="tify_seo_meta_url" data-fill_out="#tify_seo_meta_url-preview"
                       name="tify_meta_post[_tify_seo_meta][url]" placeholder="<?php echo $original_url; ?>"
                       value="<?php echo $value['url']; ?>" autocomplete="off">
            </td>
        </tr>
        </tbody>
    </table>
</div>