//Verification code thing
const inputFields = document.querySelectorAll('.id-input');
inputFields.forEach((field, index) => {
    field.addEventListener('keydown', (event) => {
        const input = event.target.value;
        var key = event.keyCode;
        if (key == 8) {
            inputFields[index].value = "";
            if (index > 0)
                inputFields[index - 1].focus();
            event.preventDefault();
        }
        else if (input.length === field.maxLength) {
            if (index < inputFields.length - 1) {
                inputFields[index + 1].focus();
            }
        }
        if (index == inputFields.length - 1 && input.length === field.maxLength) {
            event.preventDefault();
        }
    });
});

function removeErrorMessage() {
    let message = document.querySelector('#error_message');
    console.log(message)
    message.style.display = "none";
}