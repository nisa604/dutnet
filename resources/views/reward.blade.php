<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>{{ $title }}</h1>
        
        <div class="card">
            <div class="card-header">
                <h2>Informasi Reward</h2>
            </div>
            <div class="card-body">
                @foreach ($rfmScores as $id_pelanggan => $scores)
                    <p>
                        Pelanggan ID: {{ $id_pelanggan }}, 
                        Recency: {{ $scores['recency'] }}, 
                        Frequency: {{ $scores['frequency'] }}, 
                        Monetary: {{ $scores['monetary'] }},
                        Engagement: {{ $scores['engagement'] }},
                        Total Score: {{ $scores['totalScore'] }},
                        Discount: {{ $scores['discount'] }}%
                    </p>
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>
