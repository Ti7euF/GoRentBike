/**
 * Script de validación del formulario de bicicletas
 */
const btnAddImage = document.getElementById('btnAddImage');
const inputAddImage = document.getElementById('inputAddImage');

if (btnAddImage && inputAddImage) {
    btnAddImage.addEventListener('click', () => { inputAddImage.click(); });
    inputAddImage.addEventListener('change', () => { document.getElementById('formAddImage').submit(); });
}

document.addEventListener('DOMContentLoaded', () => {
    const brand = document.getElementById('brand');
    const model = document.getElementById('model');
    const dailyPrice = document.getElementById('dailyPrice');
    const frame = document.getElementById('frame');
    const gear = document.getElementById('gear');
    const brakes = document.getElementById('brakes');
    const suspension = document.getElementById('suspension');
    const tires = document.getElementById('tires');
    const seatpost = document.getElementById('seatpost');
    const submitBtn = document.querySelector('button[type="submit"]');

    const errorBrand = document.getElementById('errorBrand');
    const errorModel = document.getElementById('errorModel');
    const errorDailyPrice = document.getElementById('errorDailyPrice');
    const errorFrame = document.getElementById('errorFrame');
    const errorGear = document.getElementById('errorGear');
    const errorBrakes = document.getElementById('errorBrakes');
    const errorSuspension = document.getElementById('errorSuspension');
    const errorTires = document.getElementById('errorTires');
    const errorSeatpost = document.getElementById('errorSeatpost');

    submitBtn.disabled = true;

    const textRegex = /^[A-Za-z0-9ÁÉÍÓÚáéíóúÑñ\s\-\/]{1,50}$/;

    function updateSubmitButton() {
        submitBtn.disabled = !isFormValid();
    }

    function isTextValid(input) {
        return textRegex.test(input.value.trim());
    }

    function isDailyPriceValid() {
        const value = dailyPrice.value.trim();
        return value !== "" && !isNaN(value);
    }

    function isFormValid() {
        return (isTextValid(brand) && isTextValid(model) && isTextValid(frame) && isTextValid(gear) && isTextValid(brakes) && isTextValid(suspension) && isTextValid(tires) && isTextValid(seatpost) && isDailyPriceValid());
    }

    //Eventos input
    brand.addEventListener('input', updateSubmitButton);
    model.addEventListener('input', updateSubmitButton);
    dailyPrice.addEventListener('input', updateSubmitButton);
    frame.addEventListener('input', updateSubmitButton);
    gear.addEventListener('input', updateSubmitButton);
    brakes.addEventListener('input', updateSubmitButton);
    suspension.addEventListener('input', updateSubmitButton);
    tires.addEventListener('input', updateSubmitButton);
    seatpost.addEventListener('input', updateSubmitButton);

    //Eventos blur
    brand.addEventListener('blur', () => { errorBrand.style.display = isTextValid(brand) ? 'none' : 'block'; });
    model.addEventListener('blur', () => { errorModel.style.display = isTextValid(model) ? 'none' : 'block'; });
    dailyPrice.addEventListener('blur', () => { errorDailyPrice.style.display = isDailyPriceValid() ? 'none' : 'block'; });
    frame.addEventListener('blur', () => { errorFrame.style.display = isTextValid(frame) ? 'none' : 'block'; });
    gear.addEventListener('blur', () => { errorGear.style.display = isTextValid(gear) ? 'none' : 'block'; });
    brakes.addEventListener('blur', () => { errorBrakes.style.display = isTextValid(brakes) ? 'none' : 'block'; });
    suspension.addEventListener('blur', () => { errorSuspension.style.display = isTextValid(suspension) ? 'none' : 'block'; });
    tires.addEventListener('blur', () => { errorTires.style.display = isTextValid(tires) ? 'none' : 'block'; });
    seatpost.addEventListener('blur', () => { errorSeatpost.style.display = isTextValid(seatpost) ? 'none' : 'block'; });
});