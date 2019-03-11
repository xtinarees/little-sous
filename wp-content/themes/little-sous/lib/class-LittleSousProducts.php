<?php


class LittleSousProducts extends TimberPost {

    function image_gallery_thumbnails() {
        $images = get_field('field_5b3981101cdae', $this->ID);
        return $images;
    }

    function shopify_link() {
        $button_link = get_field('field_5b3981281cdaf', $this->ID);
        return $button_link;
    }

}