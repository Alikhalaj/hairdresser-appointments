<!DOCTYPE html>
<html lang="en">

<head>
    <title>Document</title>
</head>

<body>
    @forelse($services as $service)
    <li>
        <a href="{{ $service->patch()}}">{{ $service->name }}</a>
    </li>
    @empty
    <h1>no services</h1>
    @endforelse
</body>

</html>
