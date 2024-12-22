/**
 * created by: tushar Khan
 * email : tushar.khan0122@gmail.com
 * date : 12/22/2024
 */


function enableSpinnerForButton(button){
    button.attr('disabled', 'disabled');
    button.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
}

function disableSpinnerForButton(button, text){
    button.removeAttr('disabled');
    button.html(text);
}
