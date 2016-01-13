// function post(method, obj, callback){
//
//     return $.post('/app/api.php?method=' + method, obj, callback);
//
// }

var API = "/app/api.php?method=";


function display_events(callback){

    var eventsTPL  = '{{#events}}';
        eventsTPL += '<li class="uk-nav-header">{{title}}<ul id="sub-{{slug}}" class="uk-nav-sub"></ul></li>';
        eventsTPL += '{{/events}}';

    $.get(API+'events', function (res) {
        var html = Mustache.render(eventsTPL, {events: res.data});
        $("#events-list").html(html);
        callback();
    });


}

function display_pots(){
        // var tpl = '{{#events}}'
        //
        // tpl += "{{#pots}}";
        // tpl += '<li class="uk-grid uk-grid-collapse"><a href="#" data-pot-id="{{ID}}" class="uk-width-8-10 show-pot">{{title}}</a><a href="#" class="uk-width-2-10 create-expense uk-text-center" data-pot-id="{{ID}}" data-currency="{{currency}}">+</a></li>'
        // tpl += "{{/pots}}";


    $.get(API + 'get_my_pots', function (res) {
        console.log(res);

        var obj = {events: {}};

        $.each(res.data, function (key, val) {
            if(!obj.events[val.event_slug]) obj.events[val.event_slug] = [val]
                else obj.events[val.event_slug].push(val);
        });
        console.log(obj);
        // var view = {
        //     pots: obj
        // };
        // var html = Mustache.render(tpl, view);
        // $('#pots-list').html(html);
    });

}

function refresh_pots(){

    var tpl = '<li class="uk-grid uk-grid-collapse"><a href="#" data-pot-id="{{ID}}" class="uk-width-8-10 show-pot">{{title}}</a><a href="#" class="uk-width-2-10 create-expense uk-text-center" data-pot-id="{{ID}}" data-currency="{{currency}}">+</a></li>'


    $.get(API + 'get_my_pots', function (res) {
        // console.log(res);
        // var view = {
        //     pots: res.data
        // };
        // var html = Mustache.render(tpl, view);
        // $('#pots-list').html(html);

        $.each(res.data, function (key, val) {
            var item = Mustache.render(tpl, val);
            $('#sub-'+val.event_slug).append(item);
        });

    });

}

function get_pot(id){

    var tpl =   '<a class="uk-modal-close uk-close"></a>';
        tpl +=  '<div class="uk-modal-header">';
        tpl +=  '   <h2>{{title}}</h2>';
        tpl +=  '</div>';
        tpl +=  '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. In nobis nemo omnis repellendus tempore nisi magnam aspernatur, assumenda, fuga saepe quis repellat aut voluptatem magni eos, illum dicta porro blanditiis.</p>';

    $.get(API+'pot&pot_id='+id, function (res) {

        var html = Mustache.render(tpl, res.data);

        $('#show-pot').find('.uk-modal-dialog').html(html);

        Modals.showPot.show();

    });

}

function get_activity(){

    var tpl =   '{{#expenses}}';
        tpl +=  '<dt><span class="author">{{display_name}}</span> in <span class="pot-title">{{pot_title}}</span></dt>';
        tpl +=  '<dd><b>{{amount}} {{currency}}</b> - {{description}} - <time class="timeago" datetime="{{date}}">{{date}}</time></dd>';
        tpl += '{{/expenses}}';

    $.get(API+'get_activity', function (res) {
        console.log(res);
        var view = {expenses: res.data};
        var html = Mustache.render(tpl, view);

        $('#activity-list').html(html);
        setTimeout(function () {
            $("time.timeago").timeago();
        },10);
    });
}

function reset_form(form){
    $('#' + form).find('input[type="text"], textarea').val('');
}




var Modals;
$(document).ready(function () {
    display_events(refresh_pots);
    get_activity();

    Modals = {
        createPot: UIkit.modal('#create-pot'),
        showPot: UIkit.modal("#show-pot"),
        createExpense: UIkit.modal("#create-expense")
    };

    //Modal clicks
    $('body').on('click', '.modal-open', function () {
        var mod = $(this).data('modal');
        if(!Modals[mod]){
            alert("No modal to show");
        } else {
            Modals[mod].show();
        }

        return false;
    });

    $('#create-pot-button').on('click', function () {

        var options =   '<select name="event" id="event-id" class="uk-select uk-width-1-1">';
            options +=  '   {{#events}}';
            options +=  '   <option value="{{ID}}">{{title}} - {{location}}</option>';
            options +=  '   {{/events}}';
            options +=  '</select>';


        $.get(API+'events', function (res) {

            var events = {events: res.data};
            var optionHtml = Mustache.render(options, events);
            $('#event-choice').html(optionHtml);

            Modals.createPot.show();

        });


        return false;
    });


    $('#events-list').on('click', '.show-pot', function () {

        var id = $(this).data('pot-id');

        get_pot(id);

        return false;
    });

    $('#events-list').on('click', '.create-expense', function () {

        var pot = $(this).data('pot-id');
        var curr = $(this).data('currency');

        $('#amount').attr('placeholder', 'Amount (' + curr + ')');
        $('#expense-pot-id').val(pot);

        Modals.createExpense.show();

        return false;
    });

    $('#create-expense-form').on('submit', function (e) {
        e.preventDefault();

        var obj = {
            description: $('#description').val(),
            amount: $('#amount').val(),
            pot_id: $('#expense-pot-id').val()
        }

        $.post(API+'new_expense', obj, function (res) {
            console.log(res);
            Modals.createExpense.hide();
        });

        return false;
    })

    $('#create-pot-form').submit(function (e) {
        e.preventDefault();

        var obj = {
            title: $("#title").val(),
            currency: $('#currency').val(),
            event_id: $('#event-id').val(),
            new_event_name: $('#new-event-name').val(),
            new_event_loc: $('#new-event-loc').val()
        };

        console.log(obj);

        $.post('/app/api.php?method=new_pot', obj, function () {
            refresh_pots();
            Modals.createPot.hide();
            reset_form('create-pot-form');
        });

        return false;
    });




});
