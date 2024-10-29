
<form action="{{ url('/verify-otp') }}" method="POST">
    @csrf
    <label for="phone">Phone Number:</label>
    <input type="text" id="phone" name="phone" required>

    <label for="otp">OTP:</label>
    <input type="text" id="otp" name="otp" required>

    <button type="submit">Verify OTP</button>
</form>
