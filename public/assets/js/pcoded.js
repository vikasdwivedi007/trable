"use strict";
$(document).ready(function () {
    togglemenu();
    menuhrres();
    var vw = $(window)[0].innerWidth;
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();
    $('.to-do-list input[type=checkbox]').on('click', function () {
        if ($(this).prop('checked'))
            $(this).parent().addClass('done-task');
        else
            $(this).parent().removeClass('done-task');
    });
    $(".mobile-menu").on('click', function () {
        var $this = $(this);
        $this.toggleClass('on');
    });
    $("#mobile-collapse").on('click', function () {
        $(".pcoded-navbar").toggleClass("navbar-collapsed");
    });

    $(".search-btn").on('click', function () {
        var $this = $(this);
        $(".main-search").addClass('open');
        $(".main-search .form-control").css({
            'width': '90px'
        });
    });
    $(".search-close").on('click', function () {
        var $this = $(this);
        $(".main-search").removeClass('open');
        $(".main-search .form-control").css({
            'width': '0'
        });
    });
    // search
    $("#search-friends").on("keyup", function () {
        var g = $(this).val().toLowerCase();
        $(".header-user-list .userlist-box .media-body .chat-header").each(function () {
            var s = $(this).text().toLowerCase();
            $(this).closest('.userlist-box')[s.indexOf(g) !== -1 ? 'show' : 'hide']();
        });
    });
    $("#m-search").on("keyup", function () {
        var g = $(this).val().toLowerCase();
        var ln = $(this).val().length;

        $(".pcoded-inner-navbar > li").each(function () {
            var t = $(this).attr('data-username');
            if (t) {
                var s = t.toLowerCase();
            }
            if (s) {
                var n = s.indexOf(g);
                if (n !== -1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
                if (ln > 0) {
                    $('.pcoded-menu-caption').hide();
                } else {
                    $('.pcoded-menu-caption').show();
                }
            }
        });
    });
    // open user list
    $('.displayChatbox').on('click', function () {
        $('.header-user-list').toggleClass('open');
    });
    // open messages
    $('.header-user-list .userlist-box').on('click', function () {
        $('.header-chat').addClass('open');
        $('.header-user-list').toggleClass('msg-open');
    });
    // close user list
    $('.h-back-user-list').on('click', function () {
        $('.header-chat').removeClass('open');
        $('.header-user-list').removeClass('msg-open');
    });
    //  full chat
    $('.h-close-text').on('click', function () {
        $('.header-chat').removeClass('open');
        $('.header-user-list').removeClass('open');
        $('.header-user-list').removeClass('msg-open');
    });
    $('.btn-attach').click(function () {
        $('.chat-attach').trigger('click');
    });
    $('.h-send-chat').on('keyup', function (e) {
        fc(e);
    });
    $('.btn-send').on('click', function (e) {
        cfc(e);
    });
    if (vw <= 991) {
        $(".main-search").addClass('open');
        $(".main-search .form-control").css({
            'width': '90px'
        });
    }
    // Friend scroll
    if (vw >= 1024) {
        var px = new PerfectScrollbar('.main-friend-cont', {
            wheelSpeed: .5,
            swipeEasing: 0,
            suppressScrollX: !0,
            wheelPropagation: 1,
            minScrollbarLength: 40,
        });
        var px = new PerfectScrollbar('.main-chat-cont', {
            wheelSpeed: .5,
            swipeEasing: 0,
            suppressScrollX: !0,
            wheelPropagation: 1,
            minScrollbarLength: 40,
        });
    }
    // Menu scroll
    if (!$('.pcoded-navbar').hasClass('theme-horizontal')) {
        var vw = $(window)[0].innerWidth;
        if (vw < 992 || $('.pcoded-navbar').hasClass('menupos-static')) {
            var px = new PerfectScrollbar('.navbar-content', {
                wheelSpeed: .5,
                swipeEasing: 0,
                suppressScrollX: !0,
                wheelPropagation: 1,
                minScrollbarLength: 40,
            });
        } else {
            var px = new PerfectScrollbar('.navbar-content', {
                wheelSpeed: .5,
                swipeEasing: 0,
                suppressScrollX: !0,
                wheelPropagation: 1,
                minScrollbarLength: 40,
            });
        }
    }

    function fc(e) {
        if (e.which == 13) {
            cfc(e)
        }
    };

    function cfc(e) {
        $('.header-chat .main-friend-chat').append('' +
            '<div class="media chat-messages">' +
            '<div class="media-body chat-menu-reply">' +
            '<div class="">' +
            '<p class="chat-cont">' + $('.h-send-chat').val() + '</p>' +
            '</div>' +
            '<p class="chat-time">now</p>' +
            '</div>' +
            '</div>' +
            '');
        frc($('.h-send-chat').val());
        fsc();
        $('.h-send-chat').val(null);
    };

    function frc(wrmsg) {
        setTimeout(function () {
            $('.header-chat .main-friend-chat').append('' +
                '<div class="media chat-messages typing">' +
                '<a class="media-left photo-table" href="#!"><img class="media-object img-radius img-radius m-t-5" src="assets/images/user/avatar-2.jpg" alt="Generic placeholder image"></a>' +
                '<div class="media-body chat-menu-content">' +
                '<div class="rem-msg">' +
                '<p class="chat-cont">Typing . . .</p>' +
                '</div>' +
                '<p class="chat-time">now</p>' +
                '</div>' +
                '</div>' +
                '');
            fsc();
        }, 1500);
        setTimeout(function () {
            document.getElementsByClassName("rem-msg")[0].innerHTML = "<p class='chat-cont'>hello superior personality you write</p> <p class='chat-cont'>" + wrmsg + "</p>";
            $('.rem-msg').removeClass("rem-msg");
            $('.typing').removeClass("typing");
            fsc();
        }, 3000);
    };

    function fsc() {
        var tmph = $('.header-chat .main-friend-chat');
        $('.main-chat-cont.scroll-div').scrollTop(tmph.outerHeight());
    }

    // close card
    $(".card-option .close-card").on('click', function () {
        var $this = $(this);
        $this.parents('.card').addClass('anim-close-card');
        $this.parents('.card').animate({
            'margin-bottom': '0',
        });
        setTimeout(function () {
            $this.parents('.card').children('.card-block').slideToggle();
            $this.parents('.card').children('.card-body').slideToggle();
            $this.parents('.card').children('.card-header').slideToggle();
            $this.parents('.card').children('.card-footer').slideToggle();
        }, 600);
        setTimeout(function () {
            $this.parents('.card').remove();
        }, 1500);
    });
    // reload card
    $(".card-option .reload-card").on('click', function () {
        var $this = $(this);
        $this.parents('.card').addClass("card-load");
        $this.parents('.card').append('<div class="card-loader"><i class="pct-loader1 anim-rotate"></div>');
        setTimeout(function () {
            $this.parents('.card').children(".card-loader").remove();
            $this.parents('.card').removeClass("card-load");
        }, 3000);
    });
    // collpased and expaded card
    $(".card-option .minimize-card").on('click', function () {
        var $this = $(this);
        var port = $($this.parents('.card'));
        var card = $(port).children('.card-block').slideToggle();
        var card = $(port).children('.card-body').slideToggle();
        if (!port.hasClass('full-card')) {
            $(port).css("height", "auto");
        }
        $(this).children('a').children('span').toggle();
    });
    // full card
    $(".card-option .full-card").on('click', function () {
        var $this = $(this);
        var port = $($this.parents('.card'));
        port.toggleClass("full-card");
        $(this).children('a').children('span').toggle();
        if (port.hasClass('full-card')) {
            $('body').css('overflow', 'hidden');
            $('html,body').animate({
                scrollTop: 0
            }, 1000);
            var elm = $(port, this);
            var off = elm.offset();
            var l = off.left;
            var t = off.top;
            var docH = $(window).height();
            var docW = $(window).width();
            port.animate({
                'marginLeft': l - (l * 2),
                'marginTop': t - (t * 2),
                'width': docW,
                'height': docH,
            });
        } else {
            $('body').css('overflow', '');
            port.removeAttr('style');
            setTimeout(function () {
                $('html,body').animate({
                    scrollTop: $(port).offset().top
                }, 500);
            }, 400);
        }
    });
    // apply matchHeight to each item container's items

    // remove pre-loader start
    setTimeout(function () {
        $('.loader-bg').fadeOut('slow', function () {
            $(this).remove();
        });
    }, 400);
    // remove pre-loader end

});


// Change Theme (dark & Light)
function changeTheme() {
    if (current_theme == 'theme-light') {
        current_theme = "theme-dark";
    } else {
        current_theme = "theme-light";
    }
    $.post('/change-theme', {'theme': current_theme}).done(function () {
        window.location.reload();
    });
}

//========


//========== Start Add New Fucniton in Select ========

$('#radio-Precentage').click(function () {
    $('#discount-precentage').removeAttr("disabled");
    $('#discount-Amount').attr("disabled", "disabled");
});


$('#radio-Amount').click(function () {
    $('#discount-precentage').attr("disabled", "disabled");
    $('#discount-Amount').removeAttr("disabled");
});

$('#radio-Cancel-Precentage').click(function () {
    $('#Cancel-precentage').removeAttr("disabled");
    $('#Cancel-Amount').attr("disabled", "disabled");
});


$('#radio-Cancel-Amount').click(function () {
    $('#Cancel-precentage').attr("disabled", "disabled");
    $('#Cancel-Amount').removeAttr("disabled");
});

$("#RoomCategDDL").change(function () {
    var value = $("#RoomCategDDL option:selected").val();
    if (value == "-1") {
        $('#hid-shw').hide();
        $('#CustodianName').html('<input type="text" id="TxtCustodianName" placeholder="Add New Category" class="form-control" name="view_new" />');
    }
});

$("#jobTitleDDL").change(function () {
    var value = $("#jobTitleDDL option:selected").val();
    if (value == "-1") {
        $('#hid-shw').hide();
        $('#CustodianName').html('<input type="text" id="TxtCustodianName" placeholder="Add New Job Title" class="form-control" name="job_title" />');
    }
});


$("#HotelListDDL").change(function () {

    var value = $("#HotelListDDL option:selected").val();
    if (value == "-1") {
        window.location.href = "create-new-hotel.html";
    }

});

//========== End Add New Fucniton in Select ========

//======= Start Profile Page ==========


$("#clicker").click(function () {
    $("#file").click();

});
//======= End Proifle Page ==========


//======= Strat Job File Page =====


//  ++++++++++++ Job File Page > Start Enable Dropdown Menus   ++++++++++++


//  ++++++++++++ Job File Page > End Enable Dropdown Menus   ++++++++++++


//  ++++++++++++ Job File Page > Start Adding New Section ++++++++++++
function addSightSeeing() {

    var SihtSingOne = '<div class="row justify-content-center"><div class="col-md-3"><div class="form-group"><select id="SightSeeingsDDL" class="js-example-tags form-control" name="validation-select"><option value="0">Select SightSeeing</option><option value="AL">AHmed</option><option value="WY">Mohamed</option></select></div></div><div class="col-md-2"><div class="form-group"><input type="text" id="Time-From" class="form-control" name="validation-required" placeholder="Time From *"></div></div><div class="col-md-2"><div class="form-group"><input type="text" id="Time-To" class="form-control" name="validation-required" placeholder="Time To *"></div></div></div>',
        SihtSingTwo = '<div class="row justify-content-center"><div class="col-md-1 align-self-center"><div class="form-group">Adult Price</div></div><div class="col-md-1"><div class="form-group"><input type="text" class="form-control" disabled></div></div><div class="col-md-1 align-self-center"><div class="form-group">Child Price</div></div><div class="col-md-1"><div class="form-group"><input type="text" class="form-control" disabled></div></div><div class="col-md-1 align-self-center"><div class="form-group">Total</div></div><div class="col-md-1"><div class="form-group"><input type="text" class="form-control" disabled></div></div></div>',
        emptyCoulmn = '<div class="row justify-content-center"><div class="col-md-7"><div class="form-group float-right"><a href="#" onclick="addSightSeeing()">+ Add Another SightSeeing</a></div></div></div>'
    $('#SightSeeingDetails').append(SihtSingOne + SihtSingTwo + emptyCoulmn);

}

function addVisitNight() {

    var VistNitOne = '<div class="row justify-content-center"><div class="col-md-3"><div class="form-group"><select id="VisitsNightDDL" class="js-example-tags form-control" name="validation-select"><option value="0">Select Visit by Night</option><option value="AL">AHmed</option><option value="WY">Mohamed</option></select></div></div><div class="col-md-2"><div class="form-group"><input type="text" id="Time-From" class="form-control" name="validation-required" placeholder="Time From *"></div></div><div class="col-md-2"><div class="form-group"><input type="text" id="Time-To" class="form-control" name="validation-required" placeholder="Time To *"></div></div></div>',
        VistNitTwo = '<div class="row justify-content-center"><div class="col-md-1 align-self-center"><div class="form-group">Adult Price</div></div><div class="col-md-1"><div class="form-group"><input type="text" class="form-control" disabled></div></div><div class="col-md-1 align-self-center"><div class="form-group">Child Price</div></div><div class="col-md-1"><div class="form-group"><input type="text" class="form-control" disabled></div></div><div class="col-md-1 align-self-center"><div class="form-group">Total</div></div><div class="col-md-1"><div class="form-group"><input type="text" class="form-control" disabled></div></div></div>',
        emptyCoulmn = '<div class="row justify-content-center"><div class="col-md-7"><div class="form-group float-right"><a href="#" onclick="addVisitNight()">+ Add Another Visit by Night</a></div></div></div>'
    $('#Visit-Night-Details').append(VistNitOne + VistNitTwo + emptyCoulmn);

}


//==============================

function addNewTourGuide() {
    var GuideSecOne = '<div class="row justify-content-center"> <div class="col-md-3"> <div class="form-group"> <div class="form-group"> <input type="text" id="tourDate" name="validation-required" class="form-control" placeholder="Tour Date *"> </div></div></div><div class="col-md-3"> <div class="form-group"> <select id="joGuidesDDL" class="js-example-tags form-control joTGGuidesDDL" name="validation-select" disabled> <option value="0">Select Guide</option> <option value="AL">AHmed</option> <option value="WY">Mohamed</option> </select> </div></div><div class="col-md-2"> <div class="form-group"> <input type="text" class="form-control mob_no" placeholder="Mobile No." disabled> </div></div></div>',
        GuideSecTwo = ' <div class="row justify-content-center"> <div class="col-md-2"> <div class="form-group"> <select id="joCitiesDDL" class="js-example-tags form-control joTGCitiesDDL" name="validation-select" disabled> <option value="0">Select City</option> <option value="AL">AHmed</option> <option value="WY">Mohamed</option> </select> </div></div><div class="col-md-4"> <div class="form-group"> <select id="joVisitsDDL" class="js-example-tags form-control joTGVisitsDDL" name="validation-select" disabled> <option value="0">Select Visits(SightSeeing) </option> <option value="AL">AHmed</option> <option value="WY">Mohamed</option> </select> </div></div><div class="col-md-2"> <div class="form-group"> <input type="text" class="form-control mob_no" placeholder="Guide Language" disabled> </div></div></div>',
        emptyCoulmn = '<div class="row justify-content-center"><div class="col-md-7"><div class="form-group float-right"><a href="#" onclick="addNewTourGuide()">+ Add New Tour Guide</a></div></div></div>'
    $('#Tour-Guide').append(GuideSecOne + GuideSecTwo + emptyCoulmn);

}


var dayNmbr = 0;

function addAnotherDay() {

    dayNmbr = dayNmbr + 1;

    var AnotherDayOne = ' <div class="row justify-content-center"> <div class="col-md-3"> <div class="form-group"> <div class="form-group"> <input type="text" id="date" name="validation-required" class="form-control" placeholder="Date *"> </div></div></div><div class="col-md-2"> <div class="form-group"><select id="joCitiesDDL" class="js-example-tags form-control" name="validation-select"><option value="0">Select City</option><option value="AL">AHmed</option> <option value="WY">Mohamed</option> </select> </div></div></div>',
        AnotherDayTwo = '<div class="row justify-content-center"> <div class="col-md-8"> <div class="checkbox checkbox-fill d-inline mr-3 mt-3"> <input type="checkbox" name="checkbox-fill-' + dayNmbr + '" id="checkbox-fill-SightSeeing-' + dayNmbr + '" class="checkbox-fill-SightSeeing" name="validation-checkbox-custom"> <label for="checkbox-fill-SightSeeing-' + dayNmbr + '" class="cr">SightSeeing</label> </div></div></div><div id="SightSeeingDetails" class="bg-light mx-4 py-3 my-2 d-none"> <div class="row justify-content-center"> <div class="col-md-3"> <div class="form-group"> <select id="joSightSeeingsDDL" class="js-example-tags form-control" name="validation-select"> <option value="0">Select SightSeeing </option> <option value="AL">AHmed</option> <option value="WY">Mohamed</option> </select> </div></div><div class="col-md-2"> <div class="form-group"> <input type="text" id="Time-From" class="form-control" name="validation-required" placeholder="Time From *"> </div></div><div class="col-md-2"> <div class="form-group"> <input type="text" id="Time-To" class="form-control" name="validation-required" placeholder="Time To *"> </div></div></div><div class="row justify-content-center"> <div class="col-md-1 align-self-center"> <div class="form-group"> Adult Price </div></div><div class="col-md-2"> <div class="form-group"> <input type="text" class="form-control" disabled> </div></div><div class="col-md-1 align-self-center"> <div class="form-group"> Child Price </div></div><div class="col-md-2"> <div class="form-group"> <input type="text" class="form-control" disabled> </div></div><div class="col-md-1 align-self-center"> <div class="form-group"> Total </div></div><div class="col-md-2"> <div class="form-group"> <input type="text" class="form-control" disabled> </div></div></div><div class="row justify-content-center"> <div class="col-md-7"> <div class="form-group float-right"> <a href="#" onclick="addSightSeeing()"> + Add Another SightSeeing </a> </div></div></div></div>',
        AnotherDayThree = '<div class="row justify-content-center"><div class="col-md-8"><div class="checkbox checkbox-fill d-inline mr-3 mt-3"> <input type="checkbox" name="checkbox-fill-' + dayNmbr + '" id="checkbox-fill-Visit-Night-' + dayNmbr + '" class="checkbox-fill-Visit-Night" name="validation-checkbox-custom"> <label for="checkbox-fill-Visit-Night-' + dayNmbr + '" class="cr">Visit by Night</label> </div></div></div><div id="Visit-Night-Details" class="bg-light mx-4 py-3 my-2 d-none"> <div class="row justify-content-center"> <div class="col-md-3"> <div class="form-group"> <select id="joVisitsNightDDL" class="js-example-tags form-control" name="validation-select"> <option value="0">Select Visit by Night </option> <option value="AL">AHmed</option> <option value="WY">Mohamed</option> </select> </div></div><div class="col-md-2"> <div class="form-group"> <input type="text" id="Time-From" class="form-control" name="validation-required" placeholder="Time From *"> </div></div><div class="col-md-2"> <div class="form-group"> <input type="text" id="Time-To" class="form-control" name="validation-required" placeholder="Time To *"> </div></div></div><div class="row justify-content-center"> <div class="col-md-1 align-self-center"> <div class="form-group"> Adult Price </div></div><div class="col-md-2"> <div class="form-group"> <input type="text" class="form-control" disabled> </div></div><div class="col-md-1 align-self-center"> <div class="form-group"> Child Price </div></div><div class="col-md-2"> <div class="form-group"> <input type="text" class="form-control" disabled> </div></div><div class="col-md-1 align-self-center"> <div class="form-group"> Total </div></div><div class="col-md-2"> <div class="form-group"> <input type="text" class="form-control" disabled> </div></div></div><div class="row justify-content-center"> <div class="col-md-7"> <div class="form-group float-right"> <a href="#" onclick="addVisitNight()"> + Add Another Visit by Night </a> </div></div></div></div>',
        AnotherDayFour = '<div class="row justify-content-center"> <div class="col-md-8"> <div class="checkbox checkbox-fill d-inline mr-3 mt-3"> <input type="checkbox" name="checkbox-fill-' + dayNmbr + '" id="checkbox-fill-Light-Show-' + dayNmbr + '" class="checkbox-fill-Light-Show" name="validation-checkbox-custom"> <label for="checkbox-fill-Light-Show-' + dayNmbr + '" class="cr">Sound & Light Show</label> </div></div></div><div id="SoundLightShowDetails" class="bg-light mx-4 py-3 my-2 d-none"> <div class="row justify-content-center"> <div class="col-md-3"> <div class="form-group"> <select id="joLanguagesDDL" class="js-example-tags form-control" name="validation-select"> <option value="0">Select Language</option> <option value="AL">AHmed</option> <option value="WY">Mohamed</option> </select> </div></div><div class="col-md-2"> <div class="form-group"> <input type="text" id="time" class="form-control" name="validation-required" placeholder="Show Time *"> </div></div></div><div class="row justify-content-center"> <div class="col-md-1 align-self-center"> <div class="form-group"> Adult Price </div></div><div class="col-md-2"> <div class="form-group"> <input type="text" class="form-control" disabled> </div></div><div class="col-md-1 align-self-center"> <div class="form-group"> Child Price </div></div><div class="col-md-2"> <div class="form-group"> <input type="text" class="form-control" disabled> </div></div><div class="col-md-1 align-self-center"> <div class="form-group"> Total </div></div><div class="col-md-2"> <div class="form-group"> <input type="text" class="form-control" disabled> </div></div></div></div>',
        AnotherDayFive = '<div class="row justify-content-center"> <div class="col-md-8"> <div class="checkbox checkbox-fill d-inline mr-3 mt-3"> <input type="checkbox" name="checkbox-fill-' + dayNmbr + '" id="checkbox-fill-Train-Ticket-' + dayNmbr + '" class="checkbox-fill-Train-Ticket" name="validation-checkbox-custom"> <label for="checkbox-fill-Train-Ticket-' + dayNmbr + '" class="cr">Train Ticket</label> </div></div></div><div id="TrainTicketDetails" class="bg-light mx-4 py-3 my-2 d-none"> <div class="row justify-content-center"> <div class="col-md-3"> <div class="form-group"> <input type="text" id="Train-Number" class="form-control" name="validation-required" placeholder="Train Number"> </div></div><div class="col-md-3"> <div class="form-group"> <input type="text" id="Train-Type" class="form-control" placeholder="Train Type" disabled> </div></div><div class="col-md-2"> <div class="form-group"> <input type="text" id="City-From" class="form-control" placeholder="City From" disabled> </div></div><div class="col-md-2"> <div class="form-group"> <input type="text" id="City-To" class="form-control" placeholder="City To" disabled> </div></div></div><div class="row justify-content-center"> <div class="col-md-2"> <div class="form-group"> <input type="text" id="Train-Departure-date" class="form-control" disabled placeholder="Departure Date"> </div></div><div class="col-md-2"> <div class="form-group"> <input type="text" id="Train-Departure-Time" class="form-control" disabled placeholder="Departure Time"> </div></div><div class="col-md-2"> <div class="form-group"> <input type="text" id="Train-Arrival-date" class="form-control" disabled placeholder="Arrival date"> </div></div><div class="col-md-2"> <div class="form-group"> <input type="text" id="Train-Arrival-Time" class="form-control" disabled placeholder="Arrival Time"> </div></div></div><div class="row justify-content-center"> <div class="col-md-2"> <div class="form-group"> <input type="text" id="Cabin-Number" class="form-control autonumber" disabled placeholder="Cabin Number"> </div></div><div class="col-md-2"> <div class="form-group"> <input type="text" id="Wagon-Number" class="form-control autonumber" disabled placeholder="Wagon Number"> </div></div><div class="col-md-2"> <div class="form-group"> <input type="text" id="Seat-Number" class="form-control autonumber" disabled placeholder="Seat/Bed Number"> </div></div><div class="col-md-2"> <div class="form-group"> <input type="text" id="Train-Class" class="form-control" disabled placeholder="Train Class"> </div></div></div><div class="row justify-content-center"> <div class="col-md-1 align-self-center"> <div class="form-group"> Adult Price </div></div><div class="col-md-2"> <div class="form-group"> <input type="text" class="form-control" disabled> </div></div><div class="col-md-1 align-self-center"> <div class="form-group"> Total </div></div><div class="col-md-2"> <div class="form-group"> <input type="text" class="form-control" disabled> </div></div></div></div>',
        AnotherDaySix = '<div class="row justify-content-center"> <div class="col-md-8"> <div class="checkbox checkbox-fill d-inline mr-3 mt-3"> <input type="checkbox" name="checkbox-fill-' + dayNmbr + '" id="checkbox-fill-Nile-Curise-' + dayNmbr + '" class="checkbox-fill-Nile-Curise" name="validation-checkbox-custom"> <label for="checkbox-fill-Nile-Curise-' + dayNmbr + '" class="cr">Nile Curise</label> </div></div></div><div id="NileCuriseDetails" class="bg-light mx-4 py-3 my-2 d-none"> <div class="row justify-content-center "> <div class="col-md-2"> <div class="form-group"> <select id="joNileCruisesDDL" class="js-example-tags form-control" name="validation-select"> <option value="0">Select Nile Cruise </option> <option value="AL">Dahbia</option> <option value="WY">HAMADA</option> <option value="WY">NILE</option> </select> </div></div><div class="col-md-2"> <div class="form-group"> <select id="joNumCabinsDDL" class="js-example-tags form-control" name="validation-select"> <option value="0">No. of Cabins</option> <option value="AL">1</option> <option value="WY">2</option> <option value="WY">3</option> <option value="WY">4</option> <option value="WY">5</option> </select> </div></div><div class="col-md-2"> <div class="form-group"> <select id="joTypesRoomDDL" class="js-example-tags form-control" name="validation-select"> <option value="0">Type of Cabin</option> <option value="AL">Single</option> <option value="WY">Double</option> <option value="WY">Triple</option> <option value="WY">Quad</option> <option value="WY">Queen</option> <option value="WY">King</option> <option value="WY">Twin</option> <option value="WY">Suite</option> </select> </div></div></div><div class="row justify-content-center "> <div class="col-md-3"> <div class="form-group"> <input type="text" id="date-Cruise-Check-in" class="form-control" name="validation-required" placeholder="Check-in Date"> </div></div><div class="col-md-3"> <div class="form-group"> <input type="text" id="date-Cruise-Check-out" class="form-control" name="validation-required" placeholder="Check-out Date"> </div></div></div><div class="row justify-content-center "> <div class="col-md-3"> <div class="form-group"> <select id="joCityFromDDL" class="js-example-tags form-control" name="validation-select"> <option value="0">City From</option> <option value="AL">Cairo</option> <option value="WY">Aswan</option> <option value="WY">Edfo</option> <option value="WY">AboSimble</option> <option value="WY">Luxor</option> </select> </div></div><div class="col-md-3"> <div class="form-group"> <select id="joCityToDDL" class="js-example-tags form-control" name="validation-select"> <option value="0">City To</option> <option value="AL">Cairo</option> <option value="WY">Aswan</option> <option value="WY">Edfo</option> <option value="WY">AboSimble</option> <option value="WY">Luxor</option> </select> </div></div></div><div class="row justify-content-center "> <div class="checkbox checkbox-fill d-inline mr-3 mt-3"> <input type="checkbox" name="checkbox-fill-1" id="checkbox-Including-SightSeeing" name="validation-checkbox-custom"> <label for="checkbox-Including-SightSeeing" class="cr"> Including SightSeeing </label> </div><div class="checkbox checkbox-fill d-inline mr-3 mt-3"> <input type="checkbox" name="checkbox-fill-1" id="checkbox-Private-Guide" name="validation-checkbox-custom"> <label for="checkbox-Private-Guide" class="cr"> Private Tour Guide </label> </div><div class="checkbox checkbox-fill d-inline mr-3 mt-3"> <input type="checkbox" name="checkbox-fill-1" id="checkbox-Guide-Boat" name="validation-checkbox-custom"> <label for="checkbox-Guide-Boat" class="cr"> Guide on The Boat </label> </div></div><div class="row justify-content-center "> <div class="col-md-1 align-self-center"> <div class="form-group"> Adult Price </div></div><div class="col-md-2"> <div class="form-group"> <input type="text" class="form-control" disabled> </div></div><div class="col-md-1 align-self-center"> <div class="form-group"> Child Price </div></div><div class="col-md-2"> <div class="form-group"> <input type="text" class="form-control" disabled> </div></div><div class="col-md-1 align-self-center"> <div class="form-group"> Total </div></div><div class="col-md-2"> <div class="form-group"> <input type="text" class="form-control" disabled> </div></div></div></div>',
        emptyCoulmn = '<div class="row justify-content-center"> <div class="col-md-8 my-3"> <div class="form-group float-left"> <a href="#" onclick="addAnotherDay()"> + Add Another Day </a> </div></div></div>'
    $('#ProgramAdded').append(AnotherDayOne + AnotherDayTwo + AnotherDayThree + AnotherDayFour + AnotherDayFive + AnotherDaySix + emptyCoulmn);

}


//  ++++++++++++ Job File Page > End Adding New Section ++++++++++++


//======= End Job File Page ======

//  ============= Start Adding Contacts Section =============


function addNewCancelFees(amount, percentage, period_time, before, day, days, remove_period_time) {
    var CancelSecOne = '<div class="cancel-item row"><div class="col-md-3 pt-2"><div class="form-group"><div class="radio radio-primary d-inline"><input type="radio" name="cancels[' + next_cancel + '][type]" class="radio-Cancel-Amount" id="radio-Cancel-Amount-' + next_cancel + '" value="2" checked=""><label for="radio-Cancel-Amount-' + next_cancel + '" class="cr">' + amount + '</label></div><input type="text" id="Cancel-Amount" class="form-control autonumber Cancel-Amount" name="cancels[' + next_cancel + '][cancel_value_amount]"></div></div>',
        CancelSecTwo = '<div class="col-md-3 pt-2"><div class="form-group"><div class="radio radio-primary d-inline"><input type="radio" name="cancels[' + next_cancel + '][type]" class="radio-Cancel-Precentage" id="radio-Cancel-Precentage-' + next_cancel + '" value="1"><label for="radio-Cancel-Precentage-' + next_cancel + '" class="cr">' + percentage + '</label></div><input type="text" id="Cancel-precentage" class="form-control autonumber Cancel-precentage" name="cancels[' + next_cancel + '][cancel_value_perc]"  data-a-sign="% " disabled></div></div>',
        CancelSecThree = '<div class="col-md-2 pt-2"><label  class="cr">' + period_time + '</label><div class="form-group"><select id="CurrenciesDisDDL-' + next_cancel + '" class="js-example-tags form-control" name="cancels[' + next_cancel + '][time]"><option value="1">' + before + ' 1 ' + day + '</option><option value="2">' + before + ' 2 ' + days + '</option><option value="3">' + before + ' 3 ' + days + '</option><option value="4">' + before + ' 4 ' + days + '</option><option value="5">' + before + ' 5 ' + days + '</option></select></div></div>',
        emptyCoulmn = '<div class="col-md-2 align-self-center"><div class="form-group pt-4"><a href="#" onclick="$(this).closest(\'.cancel-item\').remove();return false;">' + remove_period_time + '</a></div></div></div>';
    $('#CancelationAdded').append(CancelSecOne + CancelSecTwo + CancelSecThree + emptyCoulmn);
    $('.autonumber').autoNumeric('init');
    $(".js-example-tags").select2();
    next_cancel++;
}

//==============================

function addNewHotelContact() {

    var contactName = '<div class="contact-item row"><div class="col-md-6"> <div class="form-group"><input type="text" id="Trnsprt-Contact-Name" class="form-control" name="contacts[' + next_contact + '][name]" placeholder="Contact Name"></div></div>',
        contactMobile = '<div class="col-md-6"><div class="form-group"><input type="text" id="Trnsprt-Contact-Mobile" class="form-control mob_no" name="contacts[' + next_contact + '][phone]" placeholder="Contact Mobile"></div></div>',
        contactEmail = '<div class="col-md-6"><div class="form-group"><input type="text" id="Trnsprt-Contact-Email" class="form-control" name="contacts[' + next_contact + '][email]" placeholder="Contact Email"></div></div>',
        emptyCoulmn = ' <div class="col-md-6 align-self-center"><div class="form-group"><a href="#" onclick="$(this).closest(\'.contact-item\').remove();return false;">Remove Contact</a></div></div></div>';
    //console.log();
    $('#HotelContactsAdded').append(contactName + contactMobile + contactEmail + emptyCoulmn);
    //apply mask to newely added fields
    $(".mob_no").inputmask({regex: "\\d*"});
    next_contact++;
}

//==============================

function addNewTourGuide() {
    var GuideSecOne = '<div class="row justify-content-center"><div class="col-md-3"><div class="form-group"><div class="form-group"><input type="text" id="date" class="form-control" placeholder="Tour Date *"></div></div></div><div class="col-md-3"><div class="form-group"><select id="GuidesDDL" class="js-example-tags form-control" name="validation-select"><option value="0">Select Guide</option><option value="AL">AHmed</option><option value="WY">Mohamed</option></select></div></div><div class="col-md-2"><div class="form-group"><input type="text" class="form-control mob_no" placeholder="Mobile No." disabled></div></div></div>',
        GuideSecTwo = '<div class="row justify-content-center"><div class="col-md-2"><div class="form-group"><select id="CitiesDDL" class="js-example-tags form-control" name="validation-select"><option value="0">Select City</option><option value="AL">AHmed</option><option value="WY">Mohamed</option></select></div></div><div class="col-md-4"><div class="form-group"><select id="VisitsDDL" class="js-example-tags form-control" name="validation-select"><option value="0">Select Visits(SightSeeing)</option><option value="AL">AHmed</option><option value="WY">Mohamed</option></select></div></div><div class="col-md-2"><div class="form-group"><input type="text" class="form-control mob_no" placeholder="Guide Language" disabled></div></div></div>',
        emptyCoulmn = '<div class="row justify-content-center"><div class="col-md-7"><div class="form-group float-right"><a href="#" onclick="addNewTourGuide()">+ Add New Tour Guide</a></div></div></div>'
    $('#Tour-Guide').append(GuideSecOne + GuideSecTwo + emptyCoulmn);

}

// =======================

function addNewRestrntContact() {

    var contactName = '<div class="contact-item row"><div class="col-md-6"> <div class="form-group"><input type="text" id="Trnsprt-Contact-Name" class="form-control" name="contacts[' + next_contact + '][name]" placeholder="Contact Name"></div></div>',
        contactMobile = '<div class="col-md-6"><div class="form-group"><input type="text" id="Trnsprt-Contact-Mobile" class="form-control mob_no" name="contacts[' + next_contact + '][phone]" placeholder="Contact Mobile"></div></div>',
        contactEmail = '<div class="col-md-6"><div class="form-group"><input type="text" id="Trnsprt-Contact-Email" class="form-control" name="contacts[' + next_contact + '][email]" placeholder="Contact Email"></div></div>',
        emptyCoulmn = ' <div class="col-md-6 align-self-center"><div class="form-group"><a href="#" onclick="$(this).closest(\'.contact-item\').remove();return false;">Remove Contact</a></div></div></div>';
    //console.log();
    $('#restrntContactsAdded').append(contactName + contactMobile + contactEmail + emptyCoulmn);
    //apply mask to newely added fields
    $(".mob_no").inputmask({regex: "\\d*"});
    next_contact++;
}

// =======================

function addNewFoodMenu() {

    var foodMenuName = '<div class="menu-item row"><div class="col-md-6"><div class="form-group"><input type="text" id="Food-Menu-Name" class="form-control" name="menus[' + next_menu + '][name]" placeholder="Food Menu Name"></div></div>',
        addNewMenu = '<div class="col-md-6 align-self-center"><div class="form-group"><a href="#" onclick="$(this).closest(\'.menu-item\').remove();return false;">Remove Food Menu</a></div></div>',
        foodMenuItems = '<div class="col-md-6"><div class="form-group"><textarea placeholder="Menu Items" class="form-control" rows="7" name="menus[' + next_menu + '][items]"></textarea></div></div> <div class="col-md-6"></div>';
    let buy_currencies_select = '<div class="col-md-3"><div class="form-group">\n' +
        '<select class="js-example-tags form-control currencies_select" ' +
        'name="menus[' + next_menu + '][buy_currency]" required>\n';
    for (let key in currencies) {
        buy_currencies_select += '<option value="' + key + '" >' + currencies[key] + '</option>\n';
    }
    buy_currencies_select += '</select></div></div>';
    let sell_currencies_select = buy_currencies_select.replace('menus[' + next_menu + '][buy_currency]', 'menus[' + next_menu + '][sell_currency]');
    let foodMenuPrice = ' <div class="col-md-3"><div class="form-group"><input id="Food-Menu-buy-pric" type="text" class="form-control autonumber" name="menus[' + next_menu + '][buy_price]" placeholder="Food Menu Buying Price"></div></div>' + buy_currencies_select + '<div class="col-md-3"><div class="form-group"><input id="Food-Menu-sell-pric" type="text" class="form-control autonumber" name="menus[' + next_menu + '][sell_price_vat_exc]" placeholder="Food Menu Selling Price"></div></div>' + sell_currencies_select + '</div>';
    //console.log();
    $('#FoodMenuAdded').append(foodMenuName + addNewMenu + foodMenuItems + foodMenuPrice);
    $('.autonumber').autoNumeric('init');
    $('.currencies_select').select2();
    next_menu++;
}

// =======================


function addNewCar() {
    var driverName = '<div class="car-item row"><div class="col-md-3"><div class="form-group"><input type="text" id="Trnsprt-Driver-Name" class="form-control" name="cars[' + next_car + '][driver_name]" placeholder="Driver Name" required></div></div><div class="col-md-3"><div class="form-group"><input type="text" id="Trnsprt-Driver-NameAr" class="form-control ar_only" name="cars[' + next_car + '][driver_name_ar]" placeholder="Name in Arabic" required></div></div>',
        driverMobile = '<div class="col-md-6"><div class="form-group"><input type="text" id="Trnsprt-Driver-Mobile" class="form-control mob_no" name="cars[' + next_car + '][driver_phone]" placeholder="Driver Mobile" required></div></div>',
        carSec2 = ' <div class="col-md-6"> <div class="form-group"><input type="text" id="CarTypeDDL" class="form-control" name="cars[' + next_car + '][car_type]" placeholder="Car Type" required></div></div>' +
            '<div class="col-md-6"><div class="form-group"><select required id="CarModelDDL-' + next_car + '" class="js-example-tags form-control" name="cars[' + next_car + '][car_model]"><option value="">Car Model</option><option value="2021">2021</option><option value="2020">2020</option><option value="2019">2019</option><option value="2018">2018</option><option value="2017">2017</option></select></div></div>',
        carSec3 = '<div class="col-md-6"><div class="row form-group"><div class="col-md-3 align-self-center"><label for="">Car Plate No.</label></div><div class="col-md-3"><input required type="number" id="Trnsprt-Car-Plate-No" class="form-control  Required" name="cars[' + next_car + '][car_no_seg][0]" maxlength="4"></div><div class="col-md-2"><input type="text" id="Trnsprt-Car-Plate-No" class="form-control " name="cars[' + next_car + '][car_no_seg][1]" maxlength="1"></div><div class="col-md-2"> <input type="text" id="Trnsprt-Car-Plate-No" class="form-control Required " name="cars[' + next_car + '][car_no_seg][2]" maxlength="1"></div><div class="col-md-2"><input type="text" id="Trnsprt-Car-Plate-No" class="form-control Required" name="cars[' + next_car + '][car_no_seg][3]" maxlength="1"></div></div></div><div class="col-md-6"><div class="form-group"><input type="text" id="Trnsprt-Driver-License-No" class="form-control" required name="cars[' + next_car + '][driver_no]" placeholder="Driver License No."></div></div>';

    let carSec4 = '<div class="col-md-3"><div class="form-group"><input  id="SGL-Cabin-buy-pric" type="text" class="form-control autonumber" name="cars[' + next_car + '][buy_price]" placeholder="Buying Price"></div></div>';

    let buy_currencies_select = '<div class="col-md-3"><div class="form-group">\n' +
        '<select class="js-example-tags form-control currencies_select" ' +
        'name="cars[' + next_car + '][buy_currency]" required>\n';
    for (let key in currencies) {
        buy_currencies_select += '<option value="' + key + '" >' + currencies[key] + '</option>\n';
    }
    buy_currencies_select += '</select></div></div>';
    let sell_currencies_select = buy_currencies_select.replace('cars[' + next_car + '][buy_currency]', 'cars[' + next_car + '][sell_currency]');

    carSec4 += buy_currencies_select;
    carSec4 += '<div class="col-md-6"></div><div class="col-md-3"><div class="form-group"><input  id="SGL-Cabin-sell-pric" type="text" class="form-control autonumber" name="cars[' + next_car + '][sell_price_vat_exc]" placeholder="Selling Price"></div></div>' + sell_currencies_select;
    let emptyCoulmn = '<div class="col-md-6 align-self-center"><div class="form-group"><a href="#" onclick="$(this).closest(\'.car-item\').remove();return false;">Remove Car</a></div></div></div>';
    //console.log();
    $('#CarsAdded').append(driverName + driverMobile + carSec2 + carSec3 + carSec4 + emptyCoulmn);
    //apply mask to newely added fields
    $(".mob_no").inputmask({regex: "\\d*"});
    $('.autonumber').autoNumeric('init');
    $('.js-example-tags').select2();
    next_car++;
}

// =======================
function addNewContact() {

    var contactName = '<div class="contact-item row"><div class="col-md-6"> <div class="form-group"><input type="text" id="Trnsprt-Contact-Name" class="form-control" name="contacts[' + next_contact + '][name]" placeholder="Contact Name"></div></div>',
        contactMobile = '<div class="col-md-6"><div class="form-group"><input type="text" id="Trnsprt-Contact-Mobile" class="form-control mob_no" name="contacts[' + next_contact + '][phone]" placeholder="Contact Mobile"></div></div>',
        contactEmail = '<div class="col-md-6"><div class="form-group"><input type="email" id="Trnsprt-Contact-Email" class="form-control" name="contacts[' + next_contact + '][email]" placeholder="Contact Email"></div></div>',
        emptyCoulmn = ' <div class="col-md-6 align-self-center"><div class="form-group"><a href="#" onclick="$(this).closest(\'.contact-item\').remove();return false;">Remove Contact</a></div></div></div>';
    //console.log();
    $('#contactsAdded').append(contactName + contactMobile + contactEmail + emptyCoulmn);
    //apply mask to newely added fields
    $(".mob_no").inputmask({regex: "\\d*"});
    next_contact++;
}

//======================

function addNewTrafficLine() {

    var trafficSecOne = '<div class="row"> <div class="col-md-3"> <div class="form-group"> <input type="text" id="date" class="form-control Required" name="validation-required" placeholder="Date"> </div></div><div class="col-md-3"> <div class="form-group"> <input type="text" id="time" class="form-control Required" name="validation-required" placeholder="Time"> </div></div><div class="col-md-3"> <div class="form-group float-right"> <a href="#" onclick="addNewTrafficLine()"> + Add New Traffic Line </a> </div></div></div>',
        trafficSecTwo = '<div class="row"> <div class="col-md-6"> <div class="form-group"> <textarea type="text" id="date" class="form-control" rows="6" name="validation-text" placeholder="Traffic Line Details"></textarea> </div></div></div>'
    $('#trafficLineAdded').append(trafficSecOne + trafficSecTwo);

}


// =============================
function addNewDay() {
    for (var i = 0; i < 6; i++) {
        var newDay = i + 2;

        var labelofDays = '<div class="col-md-3"><div class="form-group"> <input type="text" id="Day-Date-' + newDay + '" class="form-control" name="validation-required" placeholder="Day ' + newDay + ' Date"></div></div>',
            checkboxes = '<div class="col-md-7"><div class="form-group"><label>Day ' + newDay + ' Meal</label><div class="checkbox checkbox-fill d-inline"><input type="checkbox" name="checkbox-fill-' + newDay + '" id="checkbox-fill-American-Breakfast" name="validation-checkbox-custom"><label for="checkbox-fill-American-Breakfast" class="cr">American Breakfast</label></div><div class="checkbox checkbox-fill d-inline"><input type="checkbox" name="checkbox-fill-' + newDay + '" id="checkbox-fill-Continental-Breakfast" name="validation-checkbox-custom"><label for="checkbox-fill-Continental-Breakfast" class="cr">Continental Breakfast</label></div><div class="checkbox checkbox-fill d-inline"><input type="checkbox" name="checkbox-fill-' + newDay + '" id="checkbox-fill-Lunch" name="validation-checkbox-custom"><label for="checkbox-fill-Lunch" class="cr">Lunch</label></div><div class="checkbox checkbox-fill d-inline"><input type="checkbox" name="checkbox-fill-' + newDay + '" id="checkbox-fill-Dinner" name="validation-checkbox-custom"><label for="checkbox-fill-Dinner" class="cr">Dinner</label></div></div></div>',
            emptyCoulmn = ' <div class="col-md-2"></div>';
        $('#daysAdded').append(labelofDays + checkboxes + emptyCoulmn);
    }
}

//  ============= Start Redirect Pages =============


//  ========= End Redirect Pages =============

// ===============
$(window).resize(function () {
    togglemenu();
    menuhrres();
});

// menu [ horizontal configure ]
function menuhrres() {
    var vw = $(window)[0].innerWidth;
    if (vw < 992) {
        setTimeout(function () {
            $(".sidenav-horizontal-wrapper").addClass("sidenav-horizontal-wrapper-dis").removeClass("sidenav-horizontal-wrapper");
            $(".theme-horizontal").addClass("theme-horizontal-dis").removeClass("theme-horizontal");
        }, 400);
    } else {
        setTimeout(function () {
            $(".sidenav-horizontal-wrapper-dis").addClass("sidenav-horizontal-wrapper").removeClass("sidenav-horizontal-wrapper-dis");
            $(".theme-horizontal-dis").addClass("theme-horizontal").removeClass("theme-horizontal-dis");
        }, 400);
    }
}

var ost = 0;
$(window).scroll(function () {
    var vw = $(window)[0].innerWidth;
    if (vw >= 768) {
        var cOst = $(this).scrollTop();
        if (cOst == 400) {
            $('.theme-horizontal').addClass('top-nav-collapse');
        } else if (cOst > ost && 400 < ost) {
            $('.theme-horizontal').addClass('top-nav-collapse').removeClass('default');
        } else {
            $('.theme-horizontal').addClass('default').removeClass('top-nav-collapse');
        }
        ost = cOst;
    }
});

// menu [ compact ]
function togglemenu() {
    var vw = $(window)[0].innerWidth;
    if ($(".pcoded-navbar").hasClass('theme-horizontal') == false) {
        if (vw <= 1200 && vw >= 992) {
            $(".pcoded-navbar").addClass("navbar-collapsed");
        }
        if (vw < 992) {
            $(".pcoded-navbar").removeClass("navbar-collapsed");
        }
    }
}

// ===============

// toggle full screen
function toggleFullScreen() {
    var a = $(window).height() - 10;

    if (!document.fullscreenElement && // alternative standard method
        !document.mozFullScreenElement && !document.webkitFullscreenElement) { // current working methods
        if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen();
        } else if (document.documentElement.mozRequestFullScreen) {
            document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullscreen) {
            document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
        }
    } else {
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        }
    }
    $('.full-screen > i').toggleClass('icon-maximize');
    $('.full-screen > i').toggleClass('icon-minimize');
}

// =============   layout builder   =============
$.fn.pcodedmenu = function (settings) {
    var oid = this.attr("id");
    var defaults = {
        themelayout: 'vertical',
        MenuTrigger: 'click',
        SubMenuTrigger: 'click',
    };
    var settings = $.extend({}, defaults, settings);
    var PcodedMenu = {
        PcodedMenuInit: function () {
            PcodedMenu.HandleMenuTrigger();
            PcodedMenu.HandleSubMenuTrigger();
            PcodedMenu.HandleOffset();
        },
        HandleSubMenuTrigger: function () {
            var $window = $(window);
            var newSize = $window.width();
            if ($('.pcoded-navbar').hasClass('theme-horizontal') == true) {
                if (newSize >= 768) {
                    var $dropdown = $(".pcoded-inner-navbar .pcoded-submenu > li.pcoded-hasmenu");
                    $dropdown.off('click').off('mouseenter mouseleave').hover(
                        function () {
                            $(this).addClass('pcoded-trigger');
                        },
                        function () {
                            $(this).removeClass('pcoded-trigger');
                        }
                    );
                } else {
                    var $dropdown = $(".pcoded-inner-navbar .pcoded-submenu > li > .pcoded-submenu > li");
                    $dropdown.off('mouseenter mouseleave').off('click').on('click',
                        function () {
                            var str = $(this).closest('.pcoded-submenu').length;
                            if (str === 0) {
                                if ($(this).hasClass('pcoded-trigger')) {
                                    $(this).removeClass('pcoded-trigger');
                                    $(this).children('.pcoded-submenu').slideUp();
                                } else {
                                    $('.pcoded-submenu > li > .pcoded-submenu > li.pcoded-trigger').children('.pcoded-submenu').slideUp();
                                    $(this).closest('.pcoded-inner-navbar').find('li.pcoded-trigger').removeClass('pcoded-trigger');
                                    $(this).addClass('pcoded-trigger');
                                    $(this).children('.pcoded-submenu').slideDown();
                                }
                            } else {
                                if ($(this).hasClass('pcoded-trigger')) {
                                    $(this).removeClass('pcoded-trigger');
                                    $(this).children('.pcoded-submenu').slideUp();
                                } else {
                                    $('.pcoded-submenu > li > .pcoded-submenu > li.pcoded-trigger').children('.pcoded-submenu').slideUp();
                                    $(this).closest('.pcoded-submenu').find('li.pcoded-trigger').removeClass('pcoded-trigger');
                                    $(this).addClass('pcoded-trigger');
                                    $(this).children('.pcoded-submenu').slideDown();
                                }
                            }
                        });
                    $(".pcoded-inner-navbar .pcoded-submenu > li > .pcoded-submenu > li").on('click', function (e) {
                        e.stopPropagation();
                        alert("click call");
                        var str = $(this).closest('.pcoded-submenu').length;
                        if (str === 0) {
                            if ($(this).hasClass('pcoded-trigger')) {
                                $(this).removeClass('pcoded-trigger');
                                $(this).children('.pcoded-submenu').slideUp();
                            } else {
                                $('.pcoded-hasmenu li.pcoded-trigger').children('.pcoded-submenu').slideUp();
                                $(this).closest('.pcoded-inner-navbar').find('li.pcoded-trigger').removeClass('pcoded-trigger');
                                $(this).addClass('pcoded-trigger');
                                $(this).children('.pcoded-submenu').slideDown();
                            }
                        } else {
                            if ($(this).hasClass('pcoded-trigger')) {
                                $(this).removeClass('pcoded-trigger');
                                $(this).children('.pcoded-submenu').slideUp();
                            } else {
                                $('.pcoded-hasmenu li.pcoded-trigger').children('.pcoded-submenu').slideUp();
                                $(this).closest('.pcoded-submenu').find('li.pcoded-trigger').removeClass('pcoded-trigger');
                                $(this).addClass('pcoded-trigger');
                                $(this).children('.pcoded-submenu').slideDown();
                            }
                        }
                    });
                }
            }
            switch (settings.SubMenuTrigger) {
                case 'click':
                    $('.pcoded-navbar .pcoded-hasmenu').removeClass('is-hover');
                    $(".pcoded-inner-navbar .pcoded-submenu > li > .pcoded-submenu > li").on('click', function (e) {
                        e.stopPropagation();
                        var str = $(this).closest('.pcoded-submenu').length;
                        if (str === 0) {
                            if ($(this).hasClass('pcoded-trigger')) {
                                $(this).removeClass('pcoded-trigger');
                                $(this).children('.pcoded-submenu').slideUp();
                            } else {
                                $('.pcoded-submenu > li > .pcoded-submenu > li.pcoded-trigger').children('.pcoded-submenu').slideUp();
                                $(this).closest('.pcoded-inner-navbar').find('li.pcoded-trigger').removeClass('pcoded-trigger');
                                $(this).addClass('pcoded-trigger');
                                $(this).children('.pcoded-submenu').slideDown();
                            }
                        } else {
                            if ($(this).hasClass('pcoded-trigger')) {
                                $(this).removeClass('pcoded-trigger');
                                $(this).children('.pcoded-submenu').slideUp();
                            } else {
                                $('.pcoded-submenu > li > .pcoded-submenu > li.pcoded-trigger').children('.pcoded-submenu').slideUp();
                                $(this).closest('.pcoded-submenu').find('li.pcoded-trigger').removeClass('pcoded-trigger');
                                $(this).addClass('pcoded-trigger');
                                $(this).children('.pcoded-submenu').slideDown();
                            }
                        }
                    });
                    $(".pcoded-submenu > li").on('click', function (e) {
                        e.stopPropagation();
                        var str = $(this).closest('.pcoded-submenu').length;
                        if (str === 0) {
                            if ($(this).hasClass('pcoded-trigger')) {
                                $(this).removeClass('pcoded-trigger');
                                $(this).children('.pcoded-submenu').slideUp();
                            } else {
                                $('.pcoded-hasmenu li.pcoded-trigger').children('.pcoded-submenu').slideUp();
                                $(this).closest('.pcoded-inner-navbar').find('li.pcoded-trigger').removeClass('pcoded-trigger');
                                $(this).addClass('pcoded-trigger');
                                $(this).children('.pcoded-submenu').slideDown();
                            }
                        } else {
                            if ($(this).hasClass('pcoded-trigger')) {
                                $(this).removeClass('pcoded-trigger');
                                $(this).children('.pcoded-submenu').slideUp();
                            } else {
                                $('.pcoded-hasmenu li.pcoded-trigger').children('.pcoded-submenu').slideUp();
                                $(this).closest('.pcoded-submenu').find('li.pcoded-trigger').removeClass('pcoded-trigger');
                                $(this).addClass('pcoded-trigger');
                                $(this).children('.pcoded-submenu').slideDown();
                            }
                        }
                    });
                    break;
            }
        },
        HandleMenuTrigger: function () {
            var $window = $(window);
            var newSize = $window.width();
            if ($('.pcoded-navbar').hasClass('theme-horizontal') == true) {
                var $dropdown = $(".pcoded-inner-navbar > li");
                if (newSize >= 768) {
                    $dropdown.off('click').off('mouseenter mouseleave').hover(
                        function () {
                            $(this).addClass('pcoded-trigger');
                            if ($('.pcoded-submenu', this).length) {
                                var elm = $('.pcoded-submenu:first', this);
                                var off = elm.offset();
                                var l = off.left;
                                var w = elm.width();
                                var docH = $(window).height();
                                var docW = $(window).width();

                                var isEntirelyVisible = (l + w <= docW);
                                if (!isEntirelyVisible) {
                                    var temp = $('.sidenav-inner').attr('style');
                                    $('.sidenav-inner').css({'margin-left': (parseInt(temp.slice(12, temp.length - 3)) - 80)});
                                    $('.sidenav-horizontal-prev').removeClass('disabled');
                                } else {
                                    $(this).removeClass('edge');
                                }
                            }
                        },
                        function () {
                            $(this).removeClass('pcoded-trigger');
                        }
                    );
                } else {
                    $dropdown.off('mouseenter mouseleave').off('click').on('click',
                        function () {
                            if ($(this).hasClass('pcoded-trigger')) {
                                $(this).removeClass('pcoded-trigger');
                                $(this).children('.pcoded-submenu').slideUp();
                            } else {
                                $('li.pcoded-trigger').children('.pcoded-submenu').slideUp();
                                $(this).closest('.pcoded-inner-navbar').find('li.pcoded-trigger').removeClass('pcoded-trigger');
                                $(this).addClass('pcoded-trigger');
                                $(this).children('.pcoded-submenu').slideDown();
                            }
                        }
                    );
                }
            }
            switch (settings.MenuTrigger) {
                case 'click':
                    $('.pcoded-navbar').removeClass('is-hover');
                    $(".pcoded-inner-navbar > li:not(.pcoded-menu-caption) ").on('click', function () {
                        if ($(this).hasClass('pcoded-trigger')) {
                            $(this).removeClass('pcoded-trigger');
                            $(this).children('.pcoded-submenu').slideUp();
                        } else {
                            $('li.pcoded-trigger').children('.pcoded-submenu').slideUp();
                            $(this).closest('.pcoded-inner-navbar').find('li.pcoded-trigger').removeClass('pcoded-trigger');
                            $(this).addClass('pcoded-trigger');
                            $(this).children('.pcoded-submenu').slideDown();
                        }
                    });
                    break;
            }
        },
        HandleOffset: function () {
            switch (settings.themelayout) {
                case 'horizontal':
                    var trigger = settings.SubMenuTrigger;
                    if (trigger === "hover") {
                        $("li.pcoded-hasmenu").on('mouseenter mouseleave', function (e) {
                            if ($('.pcoded-submenu', this).length) {
                                var elm = $('.pcoded-submenu:first', this);
                                var off = elm.offset();
                                var l = off.left;
                                var w = elm.width();
                                var docH = $(window).height();
                                var docW = $(window).width();

                                var isEntirelyVisible = (l + w <= docW);
                                if (!isEntirelyVisible) {
                                    $(this).addClass('edge');
                                } else {
                                    $(this).removeClass('edge');
                                }
                            }
                        });
                    } else {
                        $("li.pcoded-hasmenu").on('click', function (e) {
                            e.preventDefault();
                            if ($('.pcoded-submenu', this).length) {
                                var elm = $('.pcoded-submenu:first', this);
                                var off = elm.offset();
                                var l = off.left;
                                var w = elm.width();
                                var docH = $(window).height();
                                var docW = $(window).width();

                                var isEntirelyVisible = (l + w <= docW);
                                if (!isEntirelyVisible) {
                                    $(this).toggleClass('edge');
                                }
                            }
                        });
                    }
                    break;
                default:
            }
        },
    };
    PcodedMenu.PcodedMenuInit();
};
$("#pcoded").pcodedmenu({
    MenuTrigger: 'click',
    SubMenuTrigger: 'click',
});
// menu [ Mobile ]
$("#mobile-collapse,#mobile-collapse1").click(function (e) {
    var vw = $(window)[0].innerWidth;
    if (vw < 992) {
        $(".pcoded-navbar").toggleClass('mob-open');
        e.stopPropagation();
    }
});
$(window).ready(function () {
    var vw = $(window)[0].innerWidth;
    $(".pcoded-navbar").on('click tap', function (e) {
        e.stopPropagation();
    });
    $('.pcoded-main-container,.pcoded-header').on("click", function () {
        if (vw < 992) {
            if ($(".pcoded-navbar").hasClass("mob-open") == true) {
                $(".pcoded-navbar").removeClass('mob-open');
                $("#mobile-collapse,#mobile-collapse1").removeClass('on');
            }
        }
    });
    // mobile header
    $("#mobile-header").on('click', function () {
        $(".navbar-collapse,.m-header").slideToggle();
    });
});
// Layout 1 navbar start
$('.layout-1 .sidemenu a').on('click', function () {
    var port = $(this);
    port.parents('li').siblings().removeClass('active');
    port.parents('li').addClass('active');
    $('.side-content .sidelink').slideUp();
    $('.side-content .sidelink.' + port.attr('data-cont')).slideDown();
});
$('.layout-1 .toggle-sidemenu').on('click', function () {
    var port = $(this);
    $('.pcoded-navbar').toggleClass('hide-sidemenu');
});
// Layout 1 navbar End


//=========== Start Invoice Page =============


$(document).on('click', "#nvoicDetalsShow", function () {
    var currentClass = $(this).data("dynamicclass");
    $("div." + currentClass).removeClass("d-none");
    $('#nvoicDetalsEdit').removeClass("d-none");
    $('#nvoicDetalsShow').addClass("disabled");
});

$(document).on('click', "#nvoicDetalsEdit", function () {
    $('#changeLabel input, #changeLabel textarea').removeClass("form-control-asLabel");
    $('#changeLabel input, #changeLabel textarea').prop("disabled", false);
    $('#nvoicDetalsEdit').addClass("disabled");
    return false;
});


function addNewItem() {

    var ItemSecOne = ' <div class="row"> <div class="col-md-3"> <label class="text-info text-uppercase">Item Description</label> <div id="changeLabel" class="form-group"> <textarea class="form-control" name="validation-text" rows="8"></textarea> </div></div><div class="col-md-3"> </div><div class="col-md-3"> <label class="text-info text-uppercase">Item Price</label> <div id="changeLabel" class="form-group"> <input type="text" class="form-control" name="validation-required"> </div></div><div class="col-md-3"></div></div>',
        ItemSecTwo = '<div class="row"><div class="col-md-3"> <label class="text-info text-uppercase">VAT</label> <div id="changeLabel" class="form-group"><input type="text" class="form-control autonumber" data-a-sign="% "></div></div><div class="col-md-3"> </div><div class="col-md-3"> <label class="text-info text-uppercase">Total Amount</label> <div class="form-group"><label></label></div></div><div class="col-md-3"></div></div>';

    $('#NewItemAdded').append(ItemSecOne + ItemSecTwo);
}

//=========== End Invoice Page =============
