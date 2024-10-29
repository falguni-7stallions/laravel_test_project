<!-- resources/views/sms_form.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Send SMS</title>
</head>
<body>
<h1>Send SMS</h1>

@if (session('status'))
    <p style="color: green;">{{ session('status') }}</p>
@endif

<form action="{{ route('sms.send') }}" method="POST">
    @csrf
    <label for="phone">Phone Number:</label>
    <input type="text" id="phone" name="phone" required>

    <label for="message">Message:</label>
    <textarea id="message" name="message" required></textarea>

    <button type="submit">Send SMS</button>
</form>
</body>
</html>
