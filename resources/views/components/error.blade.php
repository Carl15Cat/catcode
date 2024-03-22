@if($errors->any())
    <div class="message-box error-box" id="error-box">
        <p>{{ $errors->all()[0] }}</p>
    </div>
@endif