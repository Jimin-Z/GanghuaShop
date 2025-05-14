function sameSign(a, b) {
    return (a ^ b) >= 0;
}
// 123456789
function vector(a, b) {
    return {
        x: b.x - a.x,
        y: b.y - a.y
    }
}

function vectorProduct(v1, v2) {
    return v1.x * v2.y - v2.x * v1.y;
}

function isPointInTriangle(p, a, b, c) {

    var pa = vector(p, a),
        pb = vector(p, b),
        pc = vector(p, c),
        t1 = vectorProduct(pa, pb),
        t2 = vectorProduct(pb, pc),
        t3 = vectorProduct(pc, pa);

    return sameSign(t1, t2) && sameSign(t2, t3);
}

function needDelay(el, cur, prev) {

    var offsetPosition = el.offset(),
        topLeft,
        bottomLeft;
    if(el.hasClass("left")) {
        topLeft = {
            x: offsetPosition.left + el.width(),
            y: offsetPosition.top
        };
        bottomLeft = {
            x: offsetPosition.left + el.width(),
            y: offsetPosition.top + el.height()
        };
    }

    if(el.hasClass("right")) {
        topLeft = {
            x: offsetPosition.left,
            y: offsetPosition.top
        };
        bottomLeft = {
            x: offsetPosition.left,
            y: offsetPosition.top + el.height()
        };
    }


    return isPointInTriangle(cur, prev, topLeft, bottomLeft)
}


function addOffsetLeft(el) {
    var $_xl = el.offset().left;
    var $_xr = $(window).width() - (el.width() + $_xl);

    if($_xl > $_xr) {
        el.addClass("right");
    } else {
        el.addClass("left");
    }
}

function removeOffsetLeft(el) {
    if(el.hasClass("left")) {
        el.removeClass("left");
    }
    if(el.hasClass("right")) {
        el.removeClass("right");
    }
}

$.fn.ellipsis = function(maxwidth) {
    this.each(function() {
        if ($(this).text().length > maxwidth) {
            $(this).text($(this).text().substring(0, maxwidth));
            $(this).html($(this).html() + '...');
        }
    });
};

$.fn.ellipsisCustom = function(maxwidth,html) {
	this.each(function() {
		if ($(this).text().length > maxwidth) {
			$(this).text($(this).text().substring(0, maxwidth));
			$(this).html($(this).html() + html);
		}
	});
};

$.fn.ellipsisCustom_html = function(maxwidth,html) {
    this.each(function() {
        if ($(this).html().length > maxwidth) {
            $(this).html($(this).html().substring(0, maxwidth));
            $(this).html($(this).html() + html);
        }
    });
};
function setMarginLeftRight(el,$_length) {
    for(var i = 0; i < $_length; i++) {
        if ((i -2) % 3 === 0) {
            el.eq(i-1).css({
                "marginLeft" : "27px",
                "marginRight" : "27px"
            })
        }
    }
}