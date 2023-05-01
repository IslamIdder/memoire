//Verification code thing
const inputFields = document.querySelectorAll('.id-input');
inputFields.forEach((field, index) => {
    field.addEventListener('input', (event) => {
        const input = event.target.value;
        if (input.length === field.maxLength) {
            if (index < inputFields.length - 1) {
                inputFields[index + 1].focus();
            }
        }
    });
});