<!DOCTYPE html>
<html>
  <head>
    <title>{{ env('APP_NAME') }}</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <script src="{{ mix('/js/app.js') }}" defer></script>
  </head>
  <body class="dark-mode">
    @inertia
  </body>
</html>
