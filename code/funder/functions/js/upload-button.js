jQuery(document).ready(function () {
    jQuery('#gt_project_upload_images').click(function () {
        var tbURL = jQuery('#add_image').attr('href');
        if (typeof tbURL === 'undefined') {
            tbURL = jQuery('#content-add_media').attr('href');
        }
        tb_show('', tbURL);
        return false;
    });
    jQuery('#gt_post_upload_images').click(function () {
        var tbURL = jQuery('#add_image').attr('href');
        if (typeof tbURL === 'undefined') {
            tbURL = jQuery('#content-add_media').attr('href');
        }
        tb_show('', tbURL);
        return false;
    });
});