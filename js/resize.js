window.hypothesisConfig = function () {
    return {
        onLayoutChange: function(layoutParams) {
            if (body.width() > 768) {
            var width = body.width() - layoutParams.width;
            jQuery('body').css({'width':$width});
          }
        }
    };
};
