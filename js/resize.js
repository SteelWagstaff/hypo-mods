window.hypothesisConfig = function () {
    return {
        onLayoutChange: function(layoutParams) {
            jQuery('body').css({'padding-right':layoutParams.width});
        }
    };
};
