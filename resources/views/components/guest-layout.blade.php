{{-- resources/views/components/guest-layout.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tanahku.id - Auth</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap & FontAwesome --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f5f5f5;
        }
        .auth-card {
            max-width: 500px;
            margin: auto;
            margin-top: 5%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card auth-card shadow-sm">
            <div class="card-body">
                {{ $slot }}
            </div>
        </div>
    </div>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
