<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    @vite('resources/css/app.css')
    <!-- Include Tailwind CSS -->
</head>

<body class="bg-gray-100">
    <header class="bg-blue-600 text-white py-4 px-6">
        <div class="flex justify-between items-center">
            <h1 class="text-xl font-bold">User Dashboard</h1>
            <form action="{{ route('user.logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-500 px-4 py-2 rounded">Logout</button>
            </form>
        </div>
    </header>
    <main class="p-6">
        <h2 class="text-2xl font-bold">Welcome, {{ Auth::user()->name }}!</h2>
        <p class="mt-2">Here are your details:</p>
        <ul class="mt-4">
            <li><strong>Name:</strong> {{ Auth::user()->name }}</li>
            <li><strong>Email:</strong> {{ Auth::user()->email }}</li>
            <li><strong>Role:</strong> {{ ucfirst(Auth::user()->role) }}</li>
        </ul>

        <h3 class="text-xl font-bold mt-6">Your Missing Reports:</h3>
        @if($missing->isEmpty())
        <p class="mt-2">You have no missing reports.</p>
        @else
        <ul class="mt-4">
            @foreach($missing as $report)
            <li class="mb-2">
                <strong>Report ID:</strong> {{ $report->id }}<br>
                <strong>Full Name:</strong> {{ $report->fullname }}<br>
                <strong>Date of Birth:</strong> {{ $report->date_of_birth }}<br>
                <strong>Gender:</strong> {{ $report->gender }}<br>
                <strong>Permanent Address:</strong> {{ $report->permanent_address }}<br>
                <strong>Last Seen Location:</strong> {{ $report->last_seen_location_description }}<br>
                <strong>Father's Name:</strong> {{ $report->father_name }}<br>
                <strong>Mother's Name:</strong> {{ $report->mother_name }}<br>
                <strong>Contact Number:</strong> {{ $report->contact_number }}<br>
                <strong>Email:</strong> {{ $report->email }}<br>
                <strong>Date Reported:</strong> {{ $report->created_at->format('d M Y') }}
            </li>
            @endforeach
        </ul>
        @endif
    </main>

</body>

</html>