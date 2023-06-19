import './bootstrap';

let fileInput = document.querySelector('input[type=file]');
if (fileInput) {
  let filePreview = fileInput.previousElementSibling.querySelector('img');
  fileInput.addEventListener('change', function () {
    let reader = new FileReader();
    reader.addEventListener('load', function () {
      filePreview.src = reader.result;
    });
    reader.readAsDataURL(this.files[0]);
  });
}

let priceTotal = document.querySelector('#price-total');
if (priceTotal) {
  let price = document.querySelector('#price');
  let quantity = document.querySelector('#number_of_tickets');

  priceTotal.textContent = (
    parseFloat(price.value) * parseInt(quantity.value || 0)
  ).toFixed(0);

  quantity.addEventListener('change', function () {
    priceTotal.textContent = (
      parseFloat(price.value) * parseInt(quantity.value || 0)
    ).toFixed(0);
  });
}
