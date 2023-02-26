$(document).ready(function() {

    var chkboxShiftLastChecked = [];

    $(document).on('click','[data-chkbox-shiftsel]',function(e){
        var chkboxType = $(this).data('chkbox-shiftsel');
        var type_checkbox =  $('input[type="checkbox"]');
        if(chkboxType === ''){
            chkboxType = 'default';
        }
        var $chkboxes = $('[data-chkbox-shiftsel="'+chkboxType+'"]');

        if (!chkboxShiftLastChecked[chkboxType]) {
            chkboxShiftLastChecked[chkboxType] = this;
            return;
        }

        if (e.shiftKey) {
            var start = $chkboxes.index(this);
            var end = $chkboxes.index(chkboxShiftLastChecked[chkboxType]);

            $chkboxes.slice(Math.min(start,end), Math.max(start,end)+ 1).prop('checked', chkboxShiftLastChecked[chkboxType].checked);
        }

        // type_checkbox.each(function() {
        //     if($(this).is(':checked')){
        //         sessionStorage.setItem('CHECKED_'+$(this).attr('id'), $(this).attr('id'));
        //     }else{
        //         sessionStorage.removeItem('CHECKED_'+$(this).attr('id'));
        //     }
        // });

        chkboxShiftLastChecked[chkboxType] = this;
    });

});

//Câu lệnh get session
// var get_id = sessionStorage.getItem('CHECKED_' + $(this).attr('id'));

// function allStorage() {

//     var values = [],
//         keys = Object.keys(localStorage),
//         i = keys.length;

//     while ( i-- ) {
//         values.push( localStorage.getItem(keys[i]) );
//     }

//     return values;
// }
