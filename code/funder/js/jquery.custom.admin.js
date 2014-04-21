/* Custom JS for the Admin (Controls the project type chooser)
---------------------------------------------------------------------------*/

jQuery(document).ready(function () {
    var projectTypeTrigger = jQuery('#gt_project_type'),
        projectImage = jQuery('#gt-meta-box-project-image'),
        projectVideo = jQuery('#gt-meta-box-project-video'),
        projectAudio = jQuery('#gt-meta-box-project-audio');
    currentType = projectTypeTrigger.val();

    gtSwitch(currentType);

    projectTypeTrigger.change(function () {
        currentType = jQuery(this).val();

        gtSwitch(currentType);
    });

    function gtSwitch(currentType) {
        if (currentType === 'Audio') {
            gtHideAll(projectAudio);
        } else if (currentType === 'Video') {
            gtHideAll(projectVideo);
        } else {
            gtHideAll(projectImage);
        }
    }

    function gtHideAll(notThisOne) {
        projectImage.css('display', 'none');
        projectVideo.css('display', 'none');
        projectAudio.css('display', 'none');
        notThisOne.css('display', 'block');
    }
});