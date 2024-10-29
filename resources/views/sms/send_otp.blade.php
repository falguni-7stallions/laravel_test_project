
<form action="{{ url('/send-otp') }}" method="POST">
    @csrf
    <label for="phone">Phone Number:</label>
    <input type="text" id="phone" name="phone" required>
    <button type="submit">Send OTP</button>
</form>
