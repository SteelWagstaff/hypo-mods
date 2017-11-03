window.hypothesisConfig = function () {
    return {
        onLayoutChange: function(layoutParams) {
            jQuery('body').css({'padding-right':layoutParams.width});
        }
    };
};

/*
//possible alternative solution if I can figure out. Still need to account for placement of PB nav buttons :-(
window.hypothesisConfig = function () {
    return {
        onLayoutChange: function(layoutParams) {
            if (body.width() > 768) {
            var width = body.width() - layoutParams.width;
            jQuery('body').css({'width':width});
          }
        }
    };
};
*/
