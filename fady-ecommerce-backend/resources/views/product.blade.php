<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Product</title>
    @vite(['resources/css/app.css','resources/js/app.js','resources/js/store/product-main.js'])
    <script>window.PRODUCT_SLUG = '{{ $slug }}'</script>
  </head>
  <body>
    <div id="product"></div>
  </body>
  </html>
