
const inputField = document.querySelectorAll('input');
const errorMessage = document.getElementById('customErrorMessage');

inputField.forEach(e => {
    e.addEventListener('invalid', function (event) {
        event.preventDefault();
        if (e.validity.valueMissing)
            errorMessage.textContent = 'This field is required';
        else if (e.validity.patternMismatch)
            errorMessage.textContent = 'Please enter only alphabetical characters.';
        errorMessage.style.display = 'block';
    });
})

inputField.addEventListener('input', function () {
    errorMessage.style.display = 'none';
});