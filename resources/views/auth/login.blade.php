<x-guest-layout>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label>Email</label>
            <input type="email" name="email" required autofocus />
        </div>

        <div class="mt-4">
            <label>Password</label>
            <input type="password" name="password" required />
        </div>

        <div class="mt-4">
            <button type="submit">Login</button>
        </div>
    </form>
</x-guest-layout>