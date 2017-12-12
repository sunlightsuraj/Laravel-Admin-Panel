<?php
/**
 * User: suraj
 * Date: 10/17/17
 * Time: 1:05 PM
 */
?>


<div class="container">
    <h1 class="text-center">Contact Us</h1>
    @if(session('message'))
        <p>{{ session('message') }}</p>
    @endif
    <form action="{{ route('home_contact_page') }}" method="post" style="width: 500px; margin: auto;">
        {{ csrf_field() }}
        <div>
            <label for="name-input">Name *</label>
            <input type="text" id="name-input" name="name" placeholder="Enter your name" required value="{{ old('name') }}">
        </div>
        <div>
            <label for="email-input">Email *</label>
            <input type="email" id="email-input" name="email" placeholder="Enter your email" required value="{{ old('email') }}">
        </div>
        <div>
            <label for="phone-input">Phone *</label>
            <input type="text" id="phone-input" name="phone" placeholder="Enter your phone number" required
                   minlength="6" maxlength="15" value="{{ old('phone') }}">
        </div>
        <div>
            <label for="address-input">Address</label>
            <input type="text" id="address-input" name="address" placeholder="Enter your address" value="{{ old('address') }}">
        </div>
        <div>
            <label for="message-input">Message</label>
            <textarea name="message" id="message-input" cols="30" rows="10"
                      placeholder="Enter your message...">{{ old('message') }}</textarea>
        </div>
        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
</div>
